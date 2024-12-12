<?php
include "../config.php";

$data_viagem = $_GET['data_viagem'];
$id_viagem_atual = $_GET['id_viagem'];

// Obter a data da viagem atual
$sql_viagem_atual = "SELECT dataviagem FROM viagem WHERE idviagem = ?";
$stmt_viagem_atual = $con->prepare($sql_viagem_atual);
$stmt_viagem_atual->bind_param("i", $id_viagem_atual);
$stmt_viagem_atual->execute();
$result_viagem_atual = $stmt_viagem_atual->get_result();
$viagem_atual = $result_viagem_atual->fetch_assoc();

if (!$viagem_atual) {
    echo "<option value=''>Erro ao buscar a data da viagem atual</option>";
    exit;
}

$data_viagem_atual = $viagem_atual['dataviagem'];

// Garantir que a data recebida é válida
if (strtotime($data_viagem) < strtotime(date('Y-m-d'))) {
    echo "<option value=''>Selecione uma data igual ou posterior a " . date('d/m/Y') . "</option>";
    exit;
}

// Consulta as viagens disponíveis para a data selecionada
$sql = "SELECT v.idviagem, v.horaviagem, b.tipo, b.lugares,r.idrota, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino,
               (SELECT COUNT(*) FROM passagem p WHERE p.idviagem = v.idviagem AND p.status_passagem <> 4) AS ocupadas
        FROM viagem v
        INNER JOIN bus b ON b.idbus = v.idbus
        INNER JOIN rota r on r.idrota = v.idrota
        INNER JOIN cidades c1 ON c1.id = r.corigem
        INNER JOIN cidades c2 on c2.id = r.cdestino
        INNER JOIN estados e1 on e1.id = r.uforigem
        INNER JOIN estados e2 on e2.id = r.ufdestino
        WHERE v.dataviagem = ?
        ORDER BY v.horaviagem";

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $data_viagem);
$stmt->execute();
$result = $stmt->get_result();

$options = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_viagem = $row['idviagem'];
        $horario = $row['horaviagem'];
        $rota = $row['corigem']." - ".$row['uforigem']." - ".$row['cdestino']." - ".$row['ufdestino'];
        $lugares_disponiveis = $row['lugares'] - $row['ocupadas'];
        // Ignorar a viagem atual
        if ($id_viagem == $id_viagem_atual) {
            continue;
        }

        // Adicionar as opções para o select
        $options .= "<option value='$id_viagem'>$rota | Vagas: $lugares_disponiveis</option>";
    }
} else {
    $options = "<option value=''>Nenhuma viagem encontrada</option>";
}

echo $options;
?>
