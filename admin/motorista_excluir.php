<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 10;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	header("Location: ../restrita.php"); exit;
}
include "../verificanivel.php";
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
$idmotorista = $_GET['idmotorista'];
mysqli_query($con,"delete from motorista where idmotorista=$idmotorista");
if(mysqli_affected_rows($con) == 1){ 
include "../funcoes.php";
criaLog("Motorista Excluido", "Motorista numero $idmotorista"); ?>     
                    <?php
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Motorista Excluído com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: agencia_cadastrar.php");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=motorista_cadastrar.php'>";  
                          
            }
          else{ ?>
                
        <?php  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro! Problema ao excluir Motorista <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: dentista_cadastrar.php");      
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=motorista_cadastrar.php'>";  }

?>
        </div>

    </div>