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
$date2 = date('Y-m-d H:i'); 
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
include "../funcoes.php";
$idviagem = $_POST['idviagem']; 
$idencomenda = $_POST['idencomenda']; 
$cancelado_por =  $_POST['cancelado_por']; 
$mcancelamento =  $_POST['mcancelamento']; 
     
          $cad = mysqli_query ($con,"UPDATE viagem_encomenda set idsituacao = 3, data_cancelamento = '$date2', cancelado_por = '$cancelado_por', mcancelamento = '$mcancelamento' where idencomenda=$idencomenda")  or die(mysqli_error($con));

if($cad){ 

          $updatecontas = mysqli_query ($con,"UPDATE contas_encomendas set idsituacao = 3 where idencomenda=$idencomenda")  or die(mysqli_error($con));

criaLog("Encomenda Cancelada", "Encomenda numero $idencomenda"); ?>   
                    <?php
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Encomenda Cancelada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: cliente_imagens.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=encomenda_ver.php?idviagem=$idviagem'>";  
                          
            }
          else{ ?>
                
        <?php  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Cancelar Pagamento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=encomenda_ver.php?idviagem=$idviagem'>";  }

?>
        </div>

    </div>