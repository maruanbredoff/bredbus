<?php
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
$datebr = date('d-m-Y H:i'); 
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$nivel_necessario = 1;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: ../restrita.php"); exit;
}
include "../config.php"; 
$idviagem = $_GET['idviagem']; 
$sql = "select c.nome, c.documento, c.org
from passagem p
inner join clientes c on c.idcliente = p.idcliente
inner join viagem v on p.idviagem = v.idviagem
inner join agencia a on a.idagencia = p.idagencia
inner join rota r on r.idrota = v.idrota
inner join contas_receb_movi crm on crm.idpassagem = p.idpassagem
inner join situacao_caixa sc on sc.idsituacao = crm.idsituacao
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where v.idviagem = $idviagem and p.status_passagem <> 4";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $clients = [];
    while($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
} else {
    echo "No records found";
    exit;
}

$con->close();

$format = isset($_GET['format']) ? $_GET['format'] : 'txt';
$filename = "clientes-$datebr." . $format;

if ($format == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    fputcsv($output, array('Nome do Cliente', 'Documento', 'Orgao'));

    foreach ($clients as $client) {
        fputcsv($output, $client);
    }

    fclose($output);
} else if ($format == 'txt') {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');

    foreach ($clients as $client) {
        fwrite($output, implode("\t", $client) . "\n");
    }

    fclose($output);
}
?>
