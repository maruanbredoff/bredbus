<?php
header('Content-Type: application/json');

include "../config.php";

// Obtendo o termo de busca a partir dos parâmetros da URL
$termo = isset($_GET['termo']) ? $_GET['termo'] : '';

$sql = "SELECT nome, idcliente, sexo, documento, org, celular, nascimento, mae FROM clientes WHERE nome LIKE ? OR documento LIKE ?";
$stmt = $con->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => $con->error]);
    exit();
}
$searchTerm = "%$termo%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

$stmt->close();
$con->close();

echo json_encode(['clientes' => $clientes]);
?>
