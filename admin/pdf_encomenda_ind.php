<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include "../verifica_sessao.php";
include "../config.php"; // Inclua aqui seu arquivo de configuração do banco de dados

// Configurações de data
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_extenso = strftime('%d de %B de %Y', strtotime('today'));

// Conecte-se ao banco de dados e obtenha os dados necessários
include "../config.php";
$idviagem = $_GET['idviagem'];

// Consultas ao banco
$dados2_query = "SELECT ve.idencomenda, ve.idviagem, ve.etiqueta, ve.remetente, ve.destinatario, ve.descricao, ve.localhorigem, ve.localdestino, ve.telremetente, ve.teldestinatario, ve.valor, ve.idsituacao, ve.obs, ve.docremetente, ve.docdestinatario, sc.situacao, ce.valorpg, ce.id as idmovimento, c1.nome as corigemm, e1.uf as uforigem, c2.nome as cdestinoo, e2.uf as ufdestino, ve.tipo as tipoo, ve.qtd as qtde, ve.valdeclarado, ve.etiqueta
                 FROM viagem_encomenda ve
                 INNER JOIN viagem v ON v.idviagem = ve.idviagem
                 INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
                 INNER JOIN rota r ON r.idrota = v.idrota
                 LEFT JOIN contas_encomendas ce ON ce.idencomenda = ve.idencomenda
                 INNER JOIN cidades c1 ON c1.id = r.corigem
                 INNER JOIN cidades c2 ON c2.id = r.cdestino
                 INNER JOIN estados e1 ON e1.id = r.uforigem
                 INNER JOIN estados e2 ON e2.id = r.ufdestino
                 WHERE v.idviagem = $idviagem AND sc.idsituacao <> 3 and v.idcontrato = $contrato_id
                 ORDER BY ve.idencomenda";

$dados2 = mysqli_query($con, $dados2_query);
$linha2 = mysqli_fetch_assoc($dados2);

$dados_rota_query = "SELECT v.idviagem, v.dataviagem, v.horaviagem, v.motorista1, v.motorista2, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
                     FROM viagem v
                     INNER JOIN rota r ON r.idrota = v.idrota
                     INNER JOIN cidades c1 ON c1.id = r.corigem
                     INNER JOIN cidades c2 ON c2.id = r.cdestino
                     INNER JOIN estados e1 ON e1.id = r.uforigem
                     INNER JOIN estados e2 ON e2.id = r.ufdestino
                     WHERE v.idviagem = $idviagem and v.idcontrato = $contrato_id";

$dados_rota = mysqli_query($con, $dados_rota_query);
$linha_rota = mysqli_fetch_assoc($dados_rota);

// HTML para o PDF
$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comprovante de Encomenda</title></center>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px}
        table { width: 100%; border-collapse: collapse;}
        th, td { border: 1px solid #000; padding: 1px; text-align: center;}
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <center><h3>COMPROVANTE DE ENCOMENDA</h3></center>
    
    <table>
        <tr>
            <td><img src="https://samuelturismo.com.br/sistema/admin/logo2.png" width="70"></td>
            <td>
                <b>ORIGEM:</b> <i>' . $linha2['localhorigem'] . '</i><br>
                <b>DESTINO:</b> <i>' . $linha2['localdestino'] . '</i><br>
                <b>DATA PARTIDA:</b> <i>' . date('d/m/Y', strtotime($linha_rota['dataviagem'])) . ' - ' . $linha_rota['horaviagem'] . '</i>
            </td>
        </tr>
    </table>

    <table>
        <tr><th>ETIQUETA</th><th>VALOR:</th><th>PAGAMENTO</th></tr>
        <tr>
            <td>' . $linha2['etiqueta'] . '</td>
            <td>' . number_format($linha2['valor'], 2, ',', '.') . '</td>
            <td>' . $linha2['situacao'] . '</td>
        </tr>
    </table>

    <table>
        <tr><th>DESCRIÇÃO:</th><th>QTD:</th><th>TIPO</th></tr>
        <tr>
            <td>' . $linha2['descricao'] . '</td>
            <td>' . $linha2['qtde'] . '</td>
            <td>' . $linha2['tipoo'] . '</td>
        </tr>
    </table>

    <table>
        <tr><th>ORIGEM</th><th>DESTINO</th><th>DATA</th></tr>
        <tr>
            <td>' . $linha2['localhorigem'] . '</td>
            <td>' . $linha2['localdestino'] . '</td>
            <td>' . date('d/m/Y', strtotime($linha_rota['dataviagem'])) . '</td>
        </tr>
    </table>

    <table>
        <tr><th>REMETENTE</th><th>TEL</th><th>DOC</th></tr>
        <tr>
            <td>' . $linha2['remetente'] . '</td>
            <td>' . $linha2['telremetente'] . '</td>
            <td>' . $linha2['docremetente'] . '</td>
        </tr>
    </table>

    <table>
        <tr><th>DESTINATÁRIO</th><th>TEL</th><th>DOC</th></tr>
        <tr>
            <td>' . $linha2['destinatario'] . '</td>
            <td>' . $linha2['teldestinatario'] . '</td>
            <td>' . $linha2['docdestinatario'] . '</td>
        </tr>
    </table>

    <p class="small-text">
        OBS: Mercadorias não retiradas no prazo de 90 dias, não nos responsabilizamos.<br>
        Mercadorias como: vidros, eletrodoméstico, garrafas, ou qualquer mercadoria frágil, não nos responsabilizamos por danos.
    </p>

    <h5>' . $data_extenso . '</h5>
</body>
</html>
';

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
$dompdf->stream("comprovante_encomendaind.pdf", array("Attachment" => false));
exit(0);
?>
