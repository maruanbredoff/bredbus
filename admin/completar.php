<?php
$hostname = "";
$user = "";
$pass = "";
$basedados = "";
$pdo = new PDO("mysql:host=localhost; dbname=odontologia; charset=utf8;",'root','root');
$dados1 = $pdo->prepare("SELECT nome FROM clientes");
$dados1->execute();
echo json_encode($dados1->fetchAll(PDO::FETCH_ASSOC));
?>