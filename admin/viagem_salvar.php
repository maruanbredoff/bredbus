<?php
include_once('../config.php');

$idrota = mysqli_real_escape_string($con,$_POST['idrota']);
$dataviagem = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['dataviagem'])));
$horaviagem = mysqli_real_escape_string($con,$_POST['horaviagem']);
$idbus = mysqli_real_escape_string($con,$_POST['idbus']);
$motorista1 = mysqli_real_escape_string($con,$_POST['motorista1']); 
$motorista2 = mysqli_real_escape_string($con,$_POST['motorista2']); 
$obs = mysqli_real_escape_string($con,$_POST['obs']); 
$atendente = mysqli_real_escape_string($con,$_POST['atendente']);


$cad = mysqli_query($con,"INSERT INTO viagem (idviagem, idrota, dataviagem, horaviagem, idbus, motorista1, motorista2, obs, atendente, idcontrato) values(null,'$idrota','$dataviagem','$horaviagem','$idbus','$motorista1','$motorista2','$obs','$atendente','$idcontrato') ") or die(mysqli_error($con)); 
?>
<meta http-equiv="refresh" content='0;url=viagem_pesquisa.php'>