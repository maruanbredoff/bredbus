<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include "../config.php"; // Inclua aqui seu arquivo de configuração do banco de dados
$date = date('d-m-Y H:i');
$date2 = date('d-m-Y H:i');
$idviagem = $_GET['idviagem'];

// Buscar dados do ônibus e a quantidade de poltronas
$sql = "
 SELECT b.idbus, b.lugares, v.dataviagem, v.horaviagem,
           c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino,
           v.motorista1 as motorista1, v.motorista2 as motorista2, v.obs
    FROM bus b 
    JOIN viagem v ON b.idbus = v.idbus 
    JOIN rota r ON r.idrota = v.idrota
    JOIN cidades c1 ON c1.id = r.corigem
    JOIN cidades c2 ON c2.id = r.cdestino
    JOIN estados e1 ON e1.id = r.uforigem
    JOIN estados e2 ON e2.id = r.ufdestino
    LEFT JOIN motorista m1 ON m1.idmotorista = v.motorista1
    LEFT JOIN motorista m2 ON m2.idmotorista = v.motorista2
    WHERE v.idviagem = $idviagem";
$result = mysqli_query($con, $sql);
$bus = mysqli_fetch_assoc($result);

$origem =  $bus['corigem'] . " - " . $bus['uforigem'];
$destino = $bus['cdestino'] . " - " . $bus['ufdestino'];
$data_hora_partida = "DATA PARTIDA: " . date('dm/Y', strtotime($bus['dataviagem'])) . " - " . $bus['horaviagem'];
$motorista1 = $bus['motorista1'];
$motorista2 = $bus['motorista2'];
$obsviagem = $bus['obs'];
$nomearquivo = "passageiros"."-".date('d-m-Y', strtotime($bus['dataviagem']))."-".$bus['horaviagem'];

// Buscar passagens para a viagem específica usando a consulta SQL fornecida
$sql = "
    SELECT 
        p.poltrona, 
        p.embarque, 
        p.desembarque, 
        v.idviagem, 
        v.dataviagem, 
        v.horaviagem, 
        c.nome as passageiro, 
        c.sexo, 
        c.nascimento, 
        c.documento, 
        c.celular, 
        a.nome as agencia, 
        c.idcliente, 
        cr.valor, 
        p.hembarque, 
        c1.nome as corigem, 
        e1.uf as uforigem, 
        c2.nome as cdestino, 
        e2.uf as ufdestino, 
        fr.tipo, 
        c.mae, 
        cr.obs
    FROM passagem p
    INNER JOIN clientes c ON c.idcliente = p.idcliente
    INNER JOIN viagem v ON p.idviagem = v.idviagem
    INNER JOIN agencia a ON a.idagencia = p.idagencia
    INNER JOIN rota r ON r.idrota = v.idrota
    INNER JOIN contas_receb_movi crm ON crm.idpassagem = p.idpassagem
    INNER JOIN formapg fr ON fr.idformapg = crm.idformapg
    INNER JOIN cidades c1 ON c1.id = r.corigem
    INNER JOIN cidades c2 ON c2.id = r.cdestino
    INNER JOIN estados e1 ON e1.id = r.uforigem
    INNER JOIN estados e2 ON e2.id = r.ufdestino
    LEFT JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
    WHERE v.idviagem = $idviagem AND p.status_passagem <> 4
    ORDER BY p.poltrona";
$result = mysqli_query($con, $sql);

// Inicializar array para todas as poltronas
$poltronas = array_fill(1, $bus['lugares'], [
    'passageiro' => '',
    'mae' => '', 
    'documento' => '', 
    'embarque' => '', 
    'desembarque' => '', 
    'celular' => '', 
    'valor' => '', 
    'tipo' => '', 
    'obs' => ''
]);

// Preencher o array com as passagens ocupadas
while ($row = mysqli_fetch_assoc($result)) {
    $poltronas[$row['poltrona']] = [
        'passageiro' => $row['passageiro'],
        'mae' => $row['mae'],
        'documento' => $row['documento'],
        'embarque' => $row['embarque'],
        'desembarque' => $row['desembarque'],
        'celular' => $row['celular'],
        'valor' => $row['valor'],
        'tipo' => $row['tipo'],
        'obs' => $row['obs']
    ];
}

// Preparar dados para a tabela
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Poltronas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 8px}
        table { width: 100%; border-collapse: collapse;}
        th, td { border: 1px solid #000; padding: 1px; text-align: center;}
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div>


             <table align="center">
                <tr>
                    <td rowspan="2"><img src="https://samuelturismo.com.br/sistema/admin/logo2.png" width="80" class="img-circle"></td>
                    <td colspan="2"><b>ORIGEM: </b> <i> '. $origem .'</i> - <b>DESTINO: </b> <i>'. $destino .'</i> - <b>' . $data_hora_partida . ' </i> </td>
                </tr>
                <tr>
                    <td><b>MOTORISTA: </b> <i> ' . $motorista1 . ' </i></td>
                    <td><b>MOTORISTA: </b> <i> ' . $motorista2 . ' </i></td>
                </tr>
             </table> 

    <center><h1>Mapa de Poltronas </h1></center>
    <table>
        <thead>
            <tr>
                <th>POLT.</th>          
                <th>CLIENTE</th>
                <th>DOC.</th>
                <th>EMBARQUE.</th>
                <th>DESEMBARQUE</th>
                <th>TELEFONE</th>
                <th>VAL.PG</th>
                <th>TIPO PG</th>
                <th>OBS</th>
            </tr>
        </thead>
        <tbody>';

for ($i = 1; $i <= $bus['lugares']; $i++) {
    $html .= '
            <tr>
                <td>' . $i . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['passageiro']) . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['documento']) . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['embarque']) . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['desembarque']) . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['celular']) . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['valor']) . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['tipo']) . '</td>
                <td>' . htmlspecialchars($poltronas[$i]['obs']) . '</td>
            </tr>';
}


$html .= '
        </tbody>
    </table>
<table>
    <tr>
        <td>'. $obsviagem .'</td>
    </tr>
</table>

<h5> '. $date . ' </h5>
</div>
</body>
</html>';

// Inicializar o Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Carregar o HTML
$dompdf->loadHtml($html);

// (Opcional) Definir o tamanho do papel e a orientação
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream("$nomearquivo.pdf", array("Attachment" => false));
?>
