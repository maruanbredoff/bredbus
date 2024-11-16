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
include "../funcoes.php"; 
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
 $idcliente = $_POST['idcliente']; 
  $idparcelas = $_POST['idparcelas']; 
$query = sprintf("select cr.idparcelas, crm.idmovimento, crm.idcliente,p.idpassagem, c.nome as nomecliente, p.destino, cr.valor, cr.valorpg, cr.parcela, cr.vencimento, sc.idsituacao, p.origem, c.passaporte
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
inner join passagem p on p.idpassagem = crm.idpassagem 
inner join contas_receber cr on cr.idmovimento = crm.idmovimento 
inner join situacao_caixa sc on sc.idsituacao = cr.idsituacao
where cr.idparcelas = $idparcelas order by cr.vencimento"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);
$idsituacao = $linha['idsituacao'];

   //recebe os parâmetros
    $idcliente = $_POST['idcliente'];
    $valor = $_POST['valor'];
    $valorpg = $_POST['valorpg'];
    $idparcelas = $_POST['idparcelas'];
    $quem_recebeu = $_SESSION['UsuarioNome'];
    $contadeposito = mysqli_real_escape_string($con,$_POST['contadeposito']);   
    $depositante = mysqli_real_escape_string($con,$_POST['depositante']);   

if($valorpg < $valor) {
$cad = mysqli_query($con,"update contas_receber set idsituacao = '4', data_pg = now(), quem_recebeu='$quem_recebeu',contadeposito = '$contadeposito', depositante = '$depositante', valorpg = '$valorpg' WHERE idparcelas = $idparcelas") or die(mysqli_error($con));
}
else if($valorpg = $valor) {
$cad = mysqli_query($con,"update contas_receber set idsituacao = '2', data_pg = now(), quem_recebeu='$quem_recebeu',contadeposito = '$contadeposito', depositante = '$depositante', valorpg = '$valorpg' WHERE idparcelas = $idparcelas") or die(mysqli_error($con));
}            
        //insere na BD
//$cad = mysqli_query($con,"update contas_receber set idsituacao = '2', data_pg = now(), quem_recebeu='$quem_recebeu',contadeposito = '$contadeposito', depositante = '$depositante', valorpg = '$valorpg' WHERE idparcelas = $idparcelas") or die(mysqli_error($con));
                
if($cad) {
include "../funcoes.php";
criaLog("Parcela Paga", "Pagamento de parcela numero $idparcelas");
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Pagamento Efetuado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: cliente_financeiro_parcelas.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=cliente_financeiro_parcelas.php?idcliente=$idcliente'>";  
                          
            }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Efetuar o Pagamento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: cliente_financeiro_parcelas.php?idcliente=$idcliente");  }            
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=cliente_financeiro_parcelas.php?idcliente=$idcliente'>";  }

?>
        </div>

    </div>