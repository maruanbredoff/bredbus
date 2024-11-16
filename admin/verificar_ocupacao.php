<?php
include '../config.php';

$poltrona = (int)$_GET['poltrona'];
$idviagem = (int)$_GET['idviagem'];

function verificarOcupacaoPoltrona($poltrona, $idviagem, $con) {
    $sql = "SELECT COUNT(*) as total FROM passagem WHERE poltrona = ? AND idviagem = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $poltrona, $idviagem);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    return $data['total'] > 0; // Retorna true se a poltrona estiver ocupada
}

$ocupada = verificarOcupacaoPoltrona($poltrona, $idviagem, $con);
echo json_encode(['ocupada' => $ocupada]);
?>
