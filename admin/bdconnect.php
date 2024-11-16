<?php
$banco = "michella_samuelturismo";
$usuario = "michella_newuser";
$senha = "testeteste";
$hostname = "localhost";

//Criando a conexão
$conn = mysqli_connect($servername, $username, $password, $database);

//Checando conexão
if (!$conn) {
    die("Falha na conexão: " . mysli_connect_error());
}
//echo "conexão feita";
?>


