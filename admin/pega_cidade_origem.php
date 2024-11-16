<?php 
include_once('../config.php');
$id = $_GET['id'];
$busca_cidade_ori = mysqli_query($con, "select * from cidades where estados_id='$id'") or die('Erro '.mysqli_error($con));
     while ($row = mysqli_fetch_array($busca_cidade_ori)) {
     	$nome = $row['nome'];
     	$id = $row['id'];

     	echo '<option> value="'.$id.'">'.$nome.'</option>';
     }
?>