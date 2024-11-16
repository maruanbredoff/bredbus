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
      //$valortotal = mysqli_real_escape_string($con,$_POST['valor2']);
      $idmovipagar = mysqli_real_escape_string($con,$_POST['idmovipagar']);
      $qtdparcelas = mysqli_real_escape_string($con,$_POST['qtdparcelas']);
    // divide a data da venda por partes
      $vencimento = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['vencimento'])));
      $partes = explode("/",$vencimento); 
      $ano = $partes[0]; 
      $mes = $partes[1]; 
      $dia = $partes[2];
    // divide o valor pelo numero de parcelas
      $valor_parcela = $valortotal/$qtdparcelas;
      $parcela = 1;
    //fim dos campos da tabela parcelas
      $tipopg = mysqli_real_escape_string($con,$_POST['tipopg']);
      $idformapg = mysqli_real_escape_string($con,$_POST['idformapg']);
      $num_doc = mysqli_real_escape_string($con,$_POST['num_doc']);
      $resp_edicao = mysqli_real_escape_string($con,$_POST['resp_edicao']); 
    //Insere na tabela pagamentos
   // $cad = mysqli_query($con,"UPDATE `contas_pagar_movi` SET tipopg = $tipopg, `valor` = $valortotal, `idformapg` = $idformapg, `data_edicao` = '$date2', `resp_edicao` = '$resp_edicao',qtdparcelas = $qtdparcelas WHERE idmovipagar` = $idmovipagar");
                        
          $cad = mysqli_query ($con,"update contas_pagar_movi set tipopg = '$tipopg', valor = '$valortotal', idformapg = '$idformapg', data_edicao = '$date2',num_doc = '$num_doc',qtdparcelas = '$qtdparcelas',resp_edicao = '$resp_edicao' where idmovipagar = '$idmovipagar'")  or die(mysqli_error($con));
    
while($qtdparcelas >0) {
// realiza a gravação no banco de dados
$data = $ano.'/'.$mes.'/'.$dia;// iguala a data a data da venda
$sqlinsert ="UPDATE contas_pagar set parcela = '$parcela', vencimento = '$data', valor = '$valor_parcela' where idmovipagar = '$idmovipagar'";
mysqli_query($con,$sqlinsert) or die(mysqli_error($con));
$parcela++;
$qtdparcelas=$qtdparcelas-1;// subtrai 1 a variavel parcela
if ($mes<12){
$mes++;
}// adiciona +1 a variavel mes
else{
$mes = 1;
$ano++; }
}
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