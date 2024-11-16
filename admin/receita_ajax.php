<?php 
include_once('../config.php');
$idcliente = $_POST['idcliente'];
mysqli_query($con, "insert into receita(data_receita,idcliente)values(now(),$idcliente)") or die('Erro '.mysqli_error($con));
$idreceita = mysqli_insert_id($con);
echo json_encode(['id'=>$idreceita]);
?>