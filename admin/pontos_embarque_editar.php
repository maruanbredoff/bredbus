<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	header("Location: ../restrita.php"); exit;
}
//include_once("../verificanivel.php");
include_once("../config.php"); 
    $idembarque = mysqli_real_escape_string($con,$_POST['idembarque']); 
    $nome = mysqli_real_escape_string($con,$_POST['nome']);              
    $horario = mysqli_real_escape_string($con,$_POST['horario']);  
    $idrota = mysqli_real_escape_string($con,$_POST['idrota']);  
    $resp_cadastro = mysqli_real_escape_string($con,$_POST['resp_cadastro']); 

          $cad = mysqli_query ($con,"UPDATE pontos_embarque set nome = '$nome',horario = '$horario',idrota = '$idrota' where idembarque = $idembarque")  or die(mysqli_error($con));
if($cad) {
include "../funcoes.php";
criaLog("Linha Editada", "Linha numero $idrota");
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Embarque Editado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: linha_cadastrar.php");
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=pontos_embarque.php'>";  
                          
            }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar a linha <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: linha_cadastrar.php");  }          
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=pontos_embarque.php?'>";  }
?>
      