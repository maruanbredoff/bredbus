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
    $idagencia = mysqli_real_escape_string($con,$_POST['idagencia']);  
    $nome = mysqli_real_escape_string($con,$_POST['nome']);              
    $cep = mysqli_real_escape_string($con,$_POST['cep']);  
    $endereco = mysqli_real_escape_string($con,$_POST['endereco']); 
    $cidade = mysqli_real_escape_string($con,$_POST['cidade']); 
    $estado = mysqli_real_escape_string($con,$_POST['estado']); 
    $telefone = mysqli_real_escape_string($con,$_POST['telefone']); 

          $cad = mysqli_query ($con,"UPDATE agencia set nome = '$nome',cep = '$cep',endereco = '$endereco',cidade = '$cidade',estado = '$estado',telefone = '$telefone' where idagencia = $idagencia")  or die(mysqli_error($con));
if($cad) {
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Agencia Editada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: linha_cadastrar.php");
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=agencia_cadastrar.php'>";  
                          
            }
          else{  
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar a agencia <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: linha_cadastrar.php");  }          
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=agencia_cadastrar.php?'>";  }
?>
      