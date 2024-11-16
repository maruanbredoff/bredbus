<?php
require '../vendor/autoload.php'; // Certifique-se de que o caminho para o autoload do Composer esteja correto

use Dompdf\Dompdf;
use Dompdf\Options;

include "../config.php";
$data_extenso = strftime('%d de %b de %Y', strtotime('today'));
// Obtenção dos dados
$idviagem = $_GET['idviagem'];

// Dados das encomendas
$dados2 = mysqli_query($con, "SELECT ve.idencomenda, ve.idviagem, ve.etiqueta, ve.descricao, ve.remetente, ve.destinatario, ve.localhorigem, ve.localdestino, ve.telremetente, ve.teldestinatario, ve.valor, ve.idsituacao, ve.obs, ve.docremetente, ve.docdestinatario, sc.situacao, ce.valorpg, ce.id AS idmovimento, ve.tipo, ve.qtd, ve.valdeclarado
    FROM viagem_encomenda ve
    INNER JOIN viagem v ON v.idviagem = ve.idviagem
    INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
    LEFT JOIN contas_encomendas ce ON ce.idencomenda = ve.idencomenda
    WHERE v.idviagem = $idviagem AND sc.idsituacao <> 3
    ORDER BY ve.idencomenda") or die(mysqli_error($con));

$linha2 = mysqli_fetch_assoc($dados2);
$total2 = mysqli_num_rows($dados2);

// Soma o valor total das encomendas
$dados_soma = mysqli_query($con, "SELECT SUM(ve.valor) AS totalencomenda, SUM(ve.qtd) AS totalvolume
    FROM viagem_encomenda ve
    INNER JOIN viagem v ON v.idviagem = ve.idviagem
    INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
    LEFT JOIN contas_encomendas ce ON ce.idencomenda = ve.idencomenda
    WHERE v.idviagem = $idviagem AND sc.idsituacao <> 3
    ORDER BY ve.idencomenda") or die(mysqli_error($con));

$linha_soma = mysqli_fetch_assoc($dados_soma);

// Dados da rota
$dados_rota = mysqli_query($con, "SELECT v.idviagem, v.dataviagem, v.horaviagem, r.corigem, r.cdestino, v.motorista1, v.motorista2, c1.nome AS corigem, e1.uf AS uforigem, c2.nome AS cdestino, e2.uf AS ufdestino
    FROM viagem v
    INNER JOIN rota r ON r.idrota = v.idrota
    INNER JOIN cidades c1 ON c1.id = r.corigem
    INNER JOIN cidades c2 ON c2.id = r.cdestino
    INNER JOIN estados e1 ON e1.id = r.uforigem
    INNER JOIN estados e2 ON e2.id = r.ufdestino
    WHERE v.idviagem = $idviagem") or die(mysqli_error($con));

$linha_rota = mysqli_fetch_assoc($dados_rota);

// Geração do HTML para o PDF
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resumo de Encomendas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { text-align: right; }
    </style>
</head>
<body>

             <table align="center">
                <tr>
                    <td rowspan="2"><img src="https://samuelturismo.com.br/sistema/admin/logo2.png" width="80" class="img-circle"></td>
                    <td colspan="2"><b>ORIGEM: </b> <i> <?php echo $linha_rota['corigem'] . ' - ' . $linha_rota['uforigem']; ?></i> - <b>DESTINO: </b> <i> <?php echo $linha_rota['cdestino'] . ' - ' . $linha_rota['ufdestino']; ?> </i> - <b> Data Partida:</b> <?php echo date('d/m/Y', strtotime($linha_rota['dataviagem'])) . ' ' . $linha_rota['horaviagem']; ?></td>
                </tr>
                <tr>
                    <td><b>MOTORISTA: </b> <i> <?php echo $linha_rota['motorista1']; ?> </i></td>
                    <td><b>MOTORISTA: </b> <i> <?php echo $linha_rota['motorista2']; ?> </i></td>
                </tr>
             </table> 

    <div class="content">

        <center><h2>Lista de Encomendas</h2></center>
        <table>
            <thead>
                <tr>
                    <th>Remetente</th>
                    <th>Telefone</th>
                    <th>Destinatário</th>
                    <th>Tipo</th>
                    <th>Vol</th>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Valor</th>
                    <th>PG?</th>
                    <th>COD</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($total2 > 0) {
                do {
                    $valor_formatado = number_format($linha2['valor'], 2, ',', '.');
                    $valorliquido = $linha2['valor'] - $linha2['valorpg'];
                    $valor_liq_formatado = number_format($valorliquido, 2, ',', '.');
                    ?>
                    <tr>
                        <td><?php echo strtoupper($linha2['remetente']); ?></td>
                        <td><?php echo strtoupper($linha2['telremetente']); ?></td>
                        <td><?php echo strtoupper($linha2['destinatario']); ?></td>
                        <td><?php echo strtoupper($linha2['tipo']); ?></td>
                        <td><?php echo strtoupper($linha2['qtd']); ?></td>
                        <td><?php echo strtoupper($linha2['localhorigem']); ?></td>
                        <td><?php echo strtoupper($linha2['localdestino']); ?></td>
                        <td>R$ <?php echo $valor_formatado; ?></td>
                        <td><?php echo $valorliquido > 0 ? 'NÃO' : 'SIM'; ?></td>
                        <td><?php echo strtoupper($linha2['etiqueta']); ?></td>
                    </tr>
                    <?php
                } while ($linha2 = mysqli_fetch_assoc($dados2));
            } else {
                echo "<tr><td colspan='10'>Nenhuma encomenda encontrada.</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <table>
            <tr>
                <th>QTD Volumes:</th>
                <td><?php echo $linha_soma['totalvolume']; ?></td>
                <th>Valor Total:</th>
                <td>R$ <?php echo number_format($linha_soma['totalencomenda'], 2, ',', '.'); ?></td>
            </tr>
        </table>

<br><br><br><br>
<h4><?php echo " $data_extenso" ?></h4>
    </div>
</body>
</html>

<?php

// Configurações do Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);

$html = ob_get_clean();
$dompdf->loadHtml($html);

// Define o tamanho do papel e a orientação
$dompdf->setPaper('A4', 'portrait');

// Renderiza o HTML como PDF
$dompdf->render();

// Envia o PDF gerado para o navegador (faz o download)
$dompdf->stream("encomenda_" . date('YmdHis') . ".pdf", ["Attachment" => false]);
