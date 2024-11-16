<?php
include "../config.php"; 

if (isset($_POST["tipo"])) {
    if ($_POST["tipo"] == "estados") {
        $sql = "SELECT id, CONCAT(uf, ' - ', nome) AS nome FROM estados ORDER BY uf ASC";
        $estados = mysqli_query($con, $sql);

        if (!$estados) {
            echo json_encode(['error' => 'Erro na consulta: ' . mysqli_error($con)]);
            exit();
        }

        $saida = [];
        while ($row = mysqli_fetch_array($estados)) {
            $saida[] = array(
                'id' => $row["id"],
                'nome' => $row["nome"]
            );
        }
        echo json_encode($saida);
    } elseif ($_POST["tipo"] == "cidades") {
        $cat_id = $_POST["cat_id"];
        $sql = "SELECT id, nome FROM cidades WHERE estado = '" . $cat_id . "' ORDER BY nome ASC";
        $cidades = mysqli_query($con, $sql);

        if (!$cidades) {
            echo json_encode(['error' => 'Erro na consulta: ' . mysqli_error($con)]);
            exit();
        }

        $saida = [];
        while ($row = mysqli_fetch_array($cidades)) {
            $saida[] = array(
                'id' => $row["id"],
                'nome' => $row["nome"]
            );
        }
        echo json_encode($saida);
    }
}
?>
