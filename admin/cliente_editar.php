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
if ($_POST)
        { 
      //$idviagem = mysqli_real_escape_string($con,$_POST['idviagem']);
      $idcliente = mysqli_real_escape_string($con,$_POST['idcliente']);
      $nome = mysqli_real_escape_string($con,$_POST['nome']);
      $mae = mysqli_real_escape_string($con,$_POST['mae']);
      $documento = mysqli_real_escape_string($con,$_POST['documento']);
      $org = mysqli_real_escape_string($con,$_POST['org']);
      $sexo = mysqli_real_escape_string($con,$_POST['sexo']);
      //$nascimento = $_POST['rg'];
      $nascimento = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['nascimento']))); 
      $celular = mysqli_real_escape_string($con,$_POST['celular']);
      //$data_cadastro = $_POST['data_cadastro']; 
      $data_cadastro = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['data_cadastro'])));
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      $atendente = mysqli_real_escape_string($con,$_POST['atendente']); 

      $cad = mysqli_query ($con,"UPDATE clientes set nome = '$nome', documento = '$documento', sexo = '$sexo', nascimento = '$nascimento', celular = '$celular', mae = '$mae', org = '$org', data_cadastro = '$data_cadastro', obs = '$obs', atendente = '$atendente' WHERE idcliente = $idcliente") or die(mysqli_error($con));


     // $cad = mysqli_query($con,"UPDATE clientes set data_passagem='$data_passagem', status_passagem = 1, data_cadastro = '$data_cadastro', atendente='$atendente', origem='$origem', destino='$destino', obs='$obs' where idpassagem = $idpassagem") or die(mysqli_error($con)); 

if($cad) {
include "../funcoes.php";
criaLog("$con,cliente Editado", "Cliente numero $idcliente");
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cliente Editado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                //header("Location: cliente_listar.php");
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=cliente_cadastro_ver.php?idcliente=$idcliente'>";  
                          
            }
          else{  
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar o Cliente <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                //header("Location: cliente_listar.php");  }          
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=cliente_cadastro_ver.php?idcliente=$idcliente'>";  }
}
?>