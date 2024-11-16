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
$idmovireceb = $_POST['idmovireceb']; 
$cancelado_por =  $_POST['cancelado_por']; 
$mcancelamento =  $_POST['mcancelamento']; 
                
mysqli_query($con,"update contas_priv_receb_movi set cancelado = 1, data_cancelamento = '$date2', cancelado_por = '$cancelado_por', mcancelamento = '$mcancelamento' where idmovireceb=$idmovireceb");

$query = sprintf("select cpm.data_movimento, cpm.tipopg, cp.valor, cp.parcela, cp.vencimento, cp.idmovireceb, sc.situacao, cp.idcpagar, fp.tipo, tp.descricao 
from contas_priv_receb_movi cpm 
inner join contas_pagar cp on cpm.idmovireceb = cp.idmovireceb
inner join formapg fp on fp.idformapg = cpm.idformapg
inner join situacao_caixa sc on sc.idsituacao = cp.idsituacao
inner join tipopg tp on tp.idtipopg = cpm.tipopg
where cp.idmovireceb = $idmovireceb"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);
                
while($total >0) {
$cad = mysqli_query($con,"update contas_priv_receb set idsituacao = '3', data_pg = null, quem_pagou = null WHERE idmovireceb = $idmovireceb") or die(mysqli_error($con)); 
$total = $total-1;
}
if($cad){ 
criaLog("Pagamento Cancelado", "Pagamento numero $idmovireceb"); ?>   
                    <?php
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Pagamento Cancelado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: cliente_imagens.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=financeiro_priv_receber.php'>";  
                          
            }
          else{ ?>
                
        <?php  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Cancelar Pagamento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=financeiro_priv_receber.php'>";  }

?>
        </div>

    </div>