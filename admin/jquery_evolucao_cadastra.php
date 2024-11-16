<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	header("Location: ../restrita.php"); exit;
}
//include "../verificanivel.php"; 
include "../config.php"; 
?>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <div class="page-wrapper"> 
                <div class="col-md-5 align-self-center">
                    <br>
                </div>
            <div class="container-fluid">
<?php   
 
   //recebe os parâmetros
    $idcliente = $_POST['idcliente']; 
    $idtratamento = $_POST['idtratamento'];
    $evolucao = $_POST['evolucao'];
    //$data_evo = date('Y/m/d H:i', strtotime($_REQUEST['data_evo']);
    $data_evo = $_POST['data_evo'];
    $resp_evo = $_POST['resp_evo'];
        //insere na BD
$cad = mysqli_query($con,"INSERT INTO evolucao (idevolucao, idtratamento, evolucao, data_evo, resp_evo) values(NULL,'$idtratamento','$evolucao','$data_evo','$resp_evo') ") or die(mysqli_error($con));  
if($cad) {
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Evolucao Cadastrada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: evolucao_tratamento.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=evolucao_tratamento.php?idcliente=$idcliente'>";  
                          
            }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao excluir a imagem <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=cliente_imagens.php?idcliente=$idcliente'>";  }


?>
        </div>

    </div>