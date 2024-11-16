<?php 
include_once('../config.php');
$idcliente = $_POST['idcliente'];
$data_cadastro = $_POST['data_cadastro'];
$data_cadastro2 = date('Y-m-d H:i');
mysqli_query($con, "insert into passagem(data_cadastro,idcliente) values('$data_cadastro2',$idcliente)") or die('Erro '.mysqli_error($con));
$idpassagem = mysqli_insert_id($con);
echo json_encode(['id'=>$idpassagem]);
?>