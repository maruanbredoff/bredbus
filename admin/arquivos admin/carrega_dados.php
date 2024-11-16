<?php
require './bdconnect.php';

if (isset($_POST["tipo"])) {
    if ($_POST["tipo"] == "estados") {
        $sql = "
                SELECT * FROM estados
                ORDER BY uf ASC
                ";
        $estados = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($estados)) {
            $saida[] = array(
                'id' => $row["id"],
                'nome' => $row["uf"] . " - " . $row["nome"]
            );
        }
        echo json_encode($saida);
    } else {
        $cat_id = $_POST["cat_id"];
        $sql = "
                SELECT * FROM cidades 
                WHERE estado = '" . $cat_id . "' 
                ORDER BY nome ASC
                ";
        $cidades = mysqli_query($conn, $sql);

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

