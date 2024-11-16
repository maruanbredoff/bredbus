<?php
header('Content-Type: application/json');

// Substitua as credenciais abaixo pelas suas credenciais do banco de dados
include "../config.php";

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
include "../verifica_sessao.php";
$idviagem = $_GET['idviagem'];
// Substitua '1' pelo ID da viagem que você deseja consultar
$id_viagem = isset($_GET['idviagem']) ? $_GET['idviagem'] : $idviagem;

$sql = "SELECT poltrona FROM passagem p, viagem v WHERE p.idviagem = v.idviagem and v.idcontrato = $contrato_id and p.status_passagem <> 4 and p.idviagem = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_viagem);
$stmt->execute();
$result = $stmt->get_result();

$occupiedSeats = [];
while ($row = $result->fetch_assoc()) {
    $occupiedSeats[] = $row['poltrona'];
}

$stmt->close();
$con->close();

echo json_encode(['occupiedSeats' => $occupiedSeats]);
