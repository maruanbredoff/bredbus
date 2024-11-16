<?php
include_once('../config.php');
$nome = mysqli_real_escape_string($con,$_POST['nome']);
$documento = mysqli_real_escape_string($con,$_POST['documento']);
$sexo = mysqli_real_escape_string($con,$_POST['sexo']);
$idviagem = mysqli_real_escape_string($con,$_POST['idviagem']);
 //$nascimento = $_POST['rg'];
$nascimento = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['nascimento']))); 
$celular = mysqli_real_escape_string($con,$_POST['celular']);
      //$data_cadastro = $_POST['data_cadastro']; 
$data_cadastro = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['data_cadastro'])));
$obs = mysqli_real_escape_string($con,$_POST['obs']);
 $atendente = mysqli_real_escape_string($con,$_POST['atendente']);

$cad = mysqli_query($con,"INSERT INTO clientes (nome, documento, sexo, nascimento, celular, data_cadastro, obs, atendente) values('$nome','$documento','$sexo','$nascimento','$celular','$data_cadastro','$obs','$atendente') ") or die(mysqli_error($con)); 

if($cad) {
include "../funcoes.php";
criaLog("Cliente Cadastrado", "Cliente numero $idcliente");  
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cliente cadastrado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: financeiro_pagar.php");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idcliente=$idcliente&idviagem=$idviagem'>";  
                          
            }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Cadastrar o tipo de Pagamento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: financeiro_pagar.php");               
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idcliente=$idcliente&idviagem=$idviagem'>";    }


?>
<meta http-equiv="refresh" content='0;url=passagem.php?idcliente=<?=$idcliente?>&idviagem=<?=$idviagem?>'>