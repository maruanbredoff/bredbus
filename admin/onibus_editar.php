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
    $idbus = mysqli_real_escape_string($con,$_POST['idbus']); 
    $descricao = mysqli_real_escape_string($con,$_POST['descricao']);              
    $placa = mysqli_real_escape_string($con,$_POST['placa']);  
    $tipo = mysqli_real_escape_string($con,$_POST['tipo']); 
    $lugares = mysqli_real_escape_string($con,$_POST['lugares']);  
    $editado_por = mysqli_real_escape_string($con,$_POST['editado_por']); 

          $cad = mysqli_query ($con,"UPDATE bus set descricao = '$descricao',placa = '$placa',tipo = '$tipo',lugares = '$lugares',editado_por = '$editado_por' where idbus = $idbus")  or die(mysqli_error($con));
if($cad) {
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Onibus Editado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: linha_cadastrar.php");
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=onibus_cadastrar.php'>";  
                          
            }
          else{  
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar o Onibus <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: linha_cadastrar.php");  }          
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=onibus_cadastrar.php?'>";  }
?>
      