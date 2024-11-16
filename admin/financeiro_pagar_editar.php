<?php 
date_default_timezone_set('America/Sao_Paulo');
$date2 = date('Y-m-d H:i');
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
      // inicio dos campos da tabela parcelas
    $valor = mysqli_real_escape_string($con,$_POST['valor']);              
    $valorbd = str_replace(".","",$valor );  
    $valortotal = str_replace(",",".",$valorbd );
    //fim dos campos da tabela parcelas
      $tipopg = mysqli_real_escape_string($con,$_POST['tipopg']);
      $idmovipagar = mysqli_real_escape_string($con,$_POST['idmovipagar']);
      $idformapg = mysqli_real_escape_string($con,$_POST['idformapg']);
      $resp_edicao = mysqli_real_escape_string($con,$_POST['resp_edicao']); 
      $descricao = mysqli_real_escape_string($con,$_POST['descricao']); 
                        
          $cad = mysqli_query ($con,"update contas_pagar_movi set tipopg = '$tipopg', valor = '$valor', idformapg = '$idformapg', data_edicao = '$date2',resp_edicao = '$resp_edicao',descricao = '$descricao' where idmovipagar = '$idmovipagar'")  or die(mysqli_error($con));
    
if($cad){ 
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Contas a pagar Editada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: usuario_cadastrar.php");
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=financeiro_pagar.php'>";  
                          
            }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar Contas a pagar <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: usuario_cadastrar.php");  }            
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=financeiro_pagar.php'>";  }
?>