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
 $idcliente = $_POST['idcliente']; 
 $idviagem = $_POST['idviagem']; 
  $idparcelasprox = $_POST['idparcelasprox'];

   //recebe os parâmetros
    $idcliente = $_POST['idcliente'];
      $valorpg = mysqli_real_escape_string($con,$_POST['valor']);
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      //Formata o valor_total para inserir no BD
      $valorpg_ponto = str_replace(".","",$valorpg);  
      $valorpgformatado = str_replace(",",".",$valorpg_ponto);

      $desconto = mysqli_real_escape_string($con,$_POST['desconto']);
      $desconto_ponto = str_replace(".","",$desconto);  
      $descontoformatado = str_replace(",",".",$desconto);
      $idformapg = mysqli_real_escape_string($con,$_POST['idformapg']);
    $idmovimento = $_POST['idmovimento'];
    $quem_recebeu = $_SESSION['UsuarioNome'];  
    $valor_liquido = ((float)$valorpg - (float)$desconto);
             
        //insere na BD
//$cad = mysqli_query($con,"INSERT INTO contas_receber (idparcelas, idcliente, idmovimento, data_pg, quem_recebeu, valorpg) values(null,'$idcliente','$idmovimento', now(),'$quem_recebeu','$valorpg'") or die(mysqli_error($con);
    
     $cad2 = mysqli_query($con,"update contas_receb_movi set idsituacao = '2', idformapg = '$idformapg', desconto = '$descontoformatado' where idmovimento = $idmovimento") or die(mysqli_error($con)); 

          $cad = mysqli_query($con,"INSERT INTO contas_receber (idparcelas,idcliente,idmovimento,data_pg,quem_recebeu,valor,obs, idformapg, idsituacao) values(NULL,'$idcliente','$idmovimento',now(),'$quem_recebeu','$valor_liquido','$obs','$idformapg', '2') ") or die(mysqli_error($con)); 


if($cad) {
include "../funcoes.php";
criaLog($con, "Parcela Paga", "Pagamento de parcela numero $idparcelas");
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Pagamento Efetuado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: cliente_financeiro_parcelas.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=viagem_financeiro.php?idviagem=$idviagem'>";  
                          
            }
          else{  
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Efetuar o Pagamento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		//header("Location: cliente_financeiro_parcelas.php?idcliente=$idcliente");  }            
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=viagem_financeiro.php?idviagem=$idviagem'>";  }

?>
        </div>

    </div>