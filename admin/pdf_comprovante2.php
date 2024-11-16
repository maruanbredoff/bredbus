<?php
// Ativar exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include "../verifica_sessao.php";
include "../config.php"; // Inclua aqui seu arquivo de configuração do banco de dados

$data_extenso = strftime('%d de %B de %Y', strtotime('today'));
$date = date('d-m-Y H:i');

$idpassagem = $_GET['idpassagem'];
$idviagem = $_GET['idviagem'];

// Verificar a conexão com o banco de dados
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Buscar dados do comprovante
$sql = "
    SELECT p.idpassagem, p.desembarque, v.idviagem, v.dataviagem, v.horaviagem, substring_index(c.nome, ' ', 1)  as primeironome, substring_index(c.nome, ' ', -2)  as segundonome, c.sexo, c.nascimento, c.documento, c.celular, p.poltrona, a.nome as agencia, c.idcliente, cr.valor as valpassagem, p.valor, p.hembarque, sc.situacao, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino, v.motorista1, v.motorista2, COALESCE(pe.nome, p.embarque) AS embarque, pe.idembarque, crm.valor_total, crm.desconto
from passagem p
inner join clientes c on c.idcliente = p.idcliente
inner join viagem v on p.idviagem = v.idviagem
inner join agencia a on a.idagencia = p.idagencia
inner join rota r on r.idrota = v.idrota
left join pontos_embarque pe on pe.idembarque = p.idembarque
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
inner join contas_receb_movi crm on crm.idpassagem = p.idpassagem
inner join situacao_caixa sc on sc.idsituacao = crm.idsituacao
left join contas_receber cr on cr.idmovimento = crm.idmovimento
where p.idpassagem = $idpassagem and p.status_passagem <> 4 and v.idcontrato = $contrato_id
order by p.poltrona";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$comprovante = mysqli_fetch_assoc($result);

if (!$comprovante) {
    die("No data found for ID $idpassagem");
}
$desconto = $comprovante['desconto'];
$valorliquido = $comprovante['valor_total']  - $comprovante['desconto'];
$valortotal = $comprovante['valor_total'];
$valorliquido_formatado = number_format($valorliquido, 2, ',', '.');


$origem_destino = "ORIGEM: " . $comprovante['corigem'] . " - " . $comprovante['uforigem'] . " - DESTINO: " . $comprovante['cdestino'] . " - " . $comprovante['ufdestino'];
$data_hora_partida = "DATA PARTIDA: " . date('d/m/Y', strtotime($comprovante['dataviagem'])) . " - " . $comprovante['horaviagem'];
//$motoristas = "MOTORISTA: " . $comprovante['motorista1'] . " MOTORISTA: " . $comprovante['motorista2'];

// Gerar HTML para o PDF
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Viagem</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px}
        table { width: 100%; border-collapse: collapse;}
        th, td {padding: 4px; text-align: center; }
    </style>
</head>
<body margin: 1px;>

               <center><h2>RESERVA DE PASSAGEM</h2></center>

    <table align="center" border="1">
        <tr>
            <td><img src="https://localhost/bredbus/assets/images/'.$contrato_id.'/logo2.png" width="60" class="img-circle"></td>
            <td colspan="2"><b>ORIGEM: </b> <i>' . $comprovante['corigem'] . '</i> - <b>DESTINO: </b> <i>' . $comprovante['cdestino'] . '</i> - <b>' . $data_hora_partida . ' </b></td>
        </tr>
    </table>

                                        <table border="0">
                                            <thead>
                                                <tr>
                                                    <th>POLT.</th>          
                                                    <th>CLIENTE</th>
                                                    <th>DOC.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>' . $comprovante['poltrona'] . '</td>
                                                    <td>' . $comprovante['primeironome'] ." ". $comprovante['segundonome'] . '</td>
                                                    <td>' . $comprovante['documento'] . '</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>

                                        <table border="0">
                                            <thead>
                                                <tr>
                                                    <th>EMBARQUE</th>          
                                                    <th>HR. EMBARQUE</th>
                                                    <th>DESEMBARQUE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>' . $comprovante['embarque'] . '</td>
                                                    <td>' . $comprovante['hembarque'] . '</td>
                                                    <td>' . $comprovante['desembarque'] . '</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>

                                        <table border="0">
                                            <thead>
                                                <tr>
                                                    <th>VALOR PG</th>                                                    
                                                    <th>PAGAMENTO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>' . 'R$ ' .$valorliquido_formatado . '</td>
                                                    <td>' . $comprovante['situacao'] . '</td>
                                                </tr>
                                            </tbody>
                                        </table>

<center><p><h5>Favor chegar no mínimo com 10 minutos de antecedência no embarque!</h5></p></center>
<center><p> <u> Obs: Todo passageiro tem direito a 2 malas ou bolsas em baixo e 1 de mão em cima! </u></p></center>
<h5> '. $date . ' </h5>

</body>
</html>';

// Salvar o HTML para depuração
file_put_contents('debug.html', $html);

// Inicializar o Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Carregar o HTML
$dompdf->loadHtml($html);

// (Opcional) Definir o tamanho do papel e a orientação
$dompdf->setPaper('A6', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream("comprovante.pdf", array("Attachment" => false));
?>
