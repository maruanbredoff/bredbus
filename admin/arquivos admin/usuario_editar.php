<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
$nivel_necessario = 10;
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
      $idusuario = $_POST['id_usuario'];
      $u_nome = $_POST['u_nome']; 
      $usuario = $_POST['usuario'];
      $altera_senha = $_POST['altera_senha'];
      $nivel = $_POST['nivel'];
      $ativo = $_POST['ativo'];
          $cad = mysqli_query ($con,"update usuario set u_nome = '$u_nome',usuario = '$usuario',nivel = '$nivel',ativo = '$ativo',altera_senha = '$altera_senha' where id_usuario = '$idusuario'")  or die(mysqli_error($con));
if($cad) {
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuario Editado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: cadastrar_usuario.php");
                   // echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=evolucao_tratamento.php?idcliente=$idcliente'>";  
                          
            }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar o usuario <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: cadastrar_usuario.php");  }            
               //echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=evolucao_tratamento.php?idcliente=$idcliente'>";  }
}
?>
      
}