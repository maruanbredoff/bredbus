<?php
header('Content-Type: application/json');

include "../config.php";

// Obtendo os dados do POST
$data = json_decode(file_get_contents('php://input'), true);
$idcliente = $data['idcliente'];
$poltrona = $data['poltrona'];
$idagencia = $data['idagencia'];
$embarque = $data['embarque'];
$hembaque = $data['hembaque'];
$desembarque = $data['desembarque'];
$valor = $data['valor'];
$formaPg = $data['formaPg'];
$desconto = $data['desconto'];
$status = $data['status'];
$obs = $data['obs'];
$idviagem = $data['idviagem'];

// Inserindo os dados na tabela passagens
$sql = "INSERT INTO passagem (idcliente, poltrona, idagencia, embarque, hembaque, desembarque, idviagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssssssi", $idcliente, $poltrona, $idagencia, $embarque, $hembaque, $desembarque, $name, $document, $birthdate, $phone, $idviagem);

if ($stmt->execute()) {
    $passagemId = $stmt->insert_id;
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Inserindo os dados na tabela contas_receb_movi
$sql = "INSERT INTO contas_receb_movi (valor, formaPg, desconto, status, obs) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("dssss", $valor, $formaPg, $desconto, $status, $obs);

if ($stmt->execute()) {
    $contaId = $stmt->insert_id;
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
$stmt->close();

$conn->close();
?>
