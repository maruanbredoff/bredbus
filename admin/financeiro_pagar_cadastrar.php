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
include "../verificanivel.php";
include "../config.php"; 
$date2 = date('Y-m-d H:i');
//$datebr = date('d-m-Y H:i', strtotime('+1 months', strtotime(date('d-m-Y'))));
$datebr2 = date('d-m-Y H:i');
$data_procedimento = date('Y-m-d H:i');
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];
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
if($_POST){
      // inicio dos campos da tabela parcelas
    $valor = mysqli_real_escape_string($con,$_POST['valor']);              
    $valorbd = str_replace(".","",$valor );  
    $valortotal = str_replace(",",".",$valorbd );
    //fim dos campos da tabela parcelas
      $descricao = mysqli_real_escape_string($con,$_POST['descricao']);
      $idformapg = mysqli_real_escape_string($con,$_POST['idformapg']);
      $resp_cadastro = mysqli_real_escape_string($con,$_POST['resp_cadastro']); 
      $tipopg = mysqli_real_escape_string($con,$_POST['tipopg']); 
    //Insere na tabela pagamentos
          $cad_pagamento = mysqli_query($con,"INSERT INTO contas_pagar_movi (descricao,valor,idformapg,data_movimento,resp_cadastro, idsituacao, tipopg, data_pg, idcontrato) 
            values('$descricao','$valortotal','$idformapg','$date2','$resp_cadastro', 2,'$tipopg','$date2','$idcontrato') ") or die(mysqli_error($con)); 

if($cad_pagamento) { 
    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cadastro efetuado com sucesso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=financeiro_pagar.php'>";  }
          else{ ?>
                
        <?php  
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Cadastrar o pagamento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: cliente_receitas.php?idcliente=$idcliente");      
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=financeiro_pagar.php'>";  }
}
?>
</div>
</div>
</div>