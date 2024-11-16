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
    $idmotorista = mysqli_real_escape_string($con,$_POST['idmotorista']);  
    $nome = mysqli_real_escape_string($con,$_POST['nome']);              
    $documento = mysqli_real_escape_string($con,$_POST['documento']);  
    $tel = mysqli_real_escape_string($con,$_POST['tel']); 
    $obs = mysqli_real_escape_string($con,$_POST['obs']); 

          $cad = mysqli_query ($con,"UPDATE motorista set nome = '$nome',documento = '$documento',tel = '$tel',obs = '$obs' where idmotorista = $idmotorista")  or die(mysqli_error($con));
if($cad) {
include "../funcoes.php";
criaLog($con, "Motorista Editado", "Motorista numero $idmotorista");
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Linha Editada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: linha_cadastrar.php");
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=motorista_cadastrar.php'>";  
                          
            }
          else{  
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar a linha <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: linha_cadastrar.php");  }          
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=motorista_cadastrar.php?'>";  }
?>
      