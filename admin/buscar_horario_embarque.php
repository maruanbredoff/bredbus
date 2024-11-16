<?php
include '../config.php';

$idembarque = $_GET['idembarque'] ?? null;

if ($idembarque) {
    $sql = "SELECT pe.horario 
            FROM pontos_embarque pe 
            INNER JOIN viagem v ON v.idrota = pe.idrota 
            WHERE pe.idembarque = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idembarque);
    $stmt->execute();
    $stmt->bind_result($horario);
    $stmt->fetch();

    echo json_encode(['horario' => $horario]);

    $stmt->close();
} else {
    echo json_encode(['horario' => '']);
}

$con->close();
?>
