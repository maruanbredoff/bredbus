<?php
include "../config.php";

$idpassagem = $_POST['idpassagem'];
$nova_viagem = $_POST['nova_viagem'];
$nova_poltrona = $_POST['nova_poltrona'];

// Verificar se a poltrona está disponível
$sql_check = "SELECT COUNT(*) AS ocupada FROM passagem WHERE idviagem = ? AND poltrona = ? AND status_passagem <> 4";
$stmt_check = $con->prepare($sql_check);
$stmt_check->bind_param("ii", $nova_viagem, $nova_poltrona);
$stmt_check->execute();
$result_check = $stmt_check->get_result()->fetch_assoc();

if ($result_check['ocupada'] > 0) {
    echo "Poltrona já está ocupada.";
    exit;
}

// Atualizar a viagem e poltrona do passageiro
$sql_update = "UPDATE passagem SET idviagem = ?, poltrona = ? WHERE idpassagem = ?";
$stmt_update = $con->prepare($sql_update);
$stmt_update->bind_param("iii", $nova_viagem, $nova_poltrona, $idpassagem);

if ($stmt_update->execute()) {
    header("Location: passagem.php?idviagem=$nova_viagem&success=1");
} else {
    echo "Erro ao transferir o passageiro.";
}
?>
