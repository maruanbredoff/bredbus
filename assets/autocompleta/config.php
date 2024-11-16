<?php
// definições de host, database, usuário e senha 
$host = "localhost"; 
$db = "odontologia"; 
$user = "root"; 
$pass = "root"; 
// conecta ao banco de dados 
$con = mysqli_connect($host, $user, $pass) or trigger_error(mysql_error(),E_USER_ERROR); 

// seleciona a base de dados em que vamos trabalhar 
mysqli_select_db($con,$db);
?>
