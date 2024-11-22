<?php
date_default_timezone_set('America/Sao_Paulo');
$banco = "bredbus";
$usuario = "root";
$senha = "";
$hostname = "localhost";
$con = mysqli_connect($hostname,$usuario,$senha,$banco) ; 
mysqli_select_db($con,$banco) or die( "Não foi possível conectar ao banco MySQL");
?>