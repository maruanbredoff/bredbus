<?php

$host_do_banco_de_dados = "localhost";
$usuario_banco_de_dados = "michella_teste";
$senha_do_banco_de_dados = "teste1010";
$nome_do_banco_de_dados = "michella_teste";

$link = mysqli_connect("$host_do_banco_de_dados", "$usuario_banco_de_dados", "$senha_do_banco_de_dados", "$nome_do_banco_de_dados");

if (!$link) {
   echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
   echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
   echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
   exit;
}

echo "Sucesso: Sucesso ao conectar-se com a base de dados MySQL." . PHP_EOL;

mysqli_close($link);
?>