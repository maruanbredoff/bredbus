<?php
require './bdconnect.php';

if (isset($_POST["tipo2"])) {
    if ($_POST["tipo2"] == "estados2") {
        $sql = "
                SELECT * FROM estados
                ORDER BY uf ASC
                ";
        $estados2 = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($estados2)) {
            $saida2[] = array(
                'id' => $row["id"],
                'nome' => $row["uf"] . " - " . $row["nome"]
            );
        }
        echo json_encode($saida2);
    } else {
        $cat_id2 = $_POST["cat_id2"];
        $sql = "
                SELECT * FROM cidades 
                WHERE estado = '" . $cat_id2 . "' 
                ORDER BY nome ASC
                ";
        $cidades2 = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($cidades2)) {
            $saida2[] = array(
                'id' => $row["id"],
                'nome' => $row["nome"]
            );
        }
        echo json_encode($saida2);
    }
}
?>

