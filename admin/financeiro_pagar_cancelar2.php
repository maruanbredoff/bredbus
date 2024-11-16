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
 
$idmovipagar = $_POST['idmovipagar']; 
$mcancelamento = $_POST['mcancelamento']; 
    $data_cancelamento = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['data_cancelamento'])));
    $cancelado_por = $_POST['cancelado_por'];
        //insere na BD
//mysqli_query($con,"update contas_pagar_movi set cancelado = 1, data_cancelamento = '$date2', cancelado_por = '$cancelado_por', mcancelamento = '$mcancelamento' where idmovipagar=$idmovipagar") or die(mysqli_error($con));
                
$cad = mysqli_query($con,"update contas_pagar_movi set cancelado = 1, data_cancelamento = '$data_cancelamento', cancelado_por = '$cancelado_por', mcancelamento = '$mcancelamento' WHERE where idmovipagar=$idmovipagar") or die(mysqli_error($con)); 
if($cad) {
include "../funcoes.php";
criaLog("Evolucao Editada", "Evolucao numero $idevolucao");  
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Pagamento Cancelado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: tratamento_procedimentos_ver.php?idcliente=$idcliente&idtratamento=$idtratamento");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=financeiro_pagar.php'>";         
           }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar a evolução <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: tratamento_procedimentos_ver.php?idcliente=$idcliente&idtratamento=$idtratamento");             
               //echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=at_tratamento_procedimentos_ver.php?idcliente=$idcliente&idtratamento=$idtratamento'>";  }

?>
        </div>

    </div>