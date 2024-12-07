<?php
include "../config.php";

$nova_viagem = $_GET['nova_viagem'];

// Buscar número total de poltronas no ônibus
$sql_bus = "SELECT b.lugares
            FROM viagem v
            INNER JOIN bus b ON b.idbus = v.idbus
            WHERE v.idviagem = ?";
$stmt_bus = $con->prepare($sql_bus);
$stmt_bus->bind_param("i", $nova_viagem);
$stmt_bus->execute();
$result_bus = $stmt_bus->get_result();
$bus_info = $result_bus->fetch_assoc();

if (!$bus_info) {
    echo "<option value=''>Erro ao carregar o ônibus</option>";
    exit;
}

$total_poltronas = $bus_info['lugares'];

// Buscar poltronas ocupadas na viagem selecionada
$sql_ocupadas = "SELECT poltrona
                 FROM passagem
                 WHERE idviagem = ? AND status_passagem <> 4";
$stmt_ocupadas = $con->prepare($sql_ocupadas);
$stmt_ocupadas->bind_param("i", $nova_viagem);
$stmt_ocupadas->execute();
$result_ocupadas = $stmt_ocupadas->get_result();

$ocupadas = [];
while ($row = $result_ocupadas->fetch_assoc()) {
    $ocupadas[] = $row['poltrona'];
}

// Gerar opções para as poltronas disponíveis
$options = "";
for ($i = 1; $i <= $total_poltronas; $i++) {
    if (!in_array($i, $ocupadas)) {
        $options .= "<option value='$i'>Poltrona $i</option>";
    }
}

if (empty($options)) {
    $options = "<option value=''>Sem poltronas disponíveis</option>";
}

echo $options;
?>
