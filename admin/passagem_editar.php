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
      $idviagem = mysqli_real_escape_string($con,$_POST['idviagem']);
      $idpassagem = mysqli_real_escape_string($con,$_POST['idpassagem']);
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      $idmovimento = mysqli_real_escape_string($con,$_POST['idmovimento']);

      $idcliente = mysqli_real_escape_string($con,$_POST['idcliente']);
      $idembarque = mysqli_real_escape_string($con,$_POST['idembarque']);
      $hembarque = mysqli_real_escape_string($con,$_POST['hembarque']);
      $editado_por = $_SESSION['UsuarioNome'];

      $desembarque = mysqli_real_escape_string($con,$_POST['desembarque']);
      $idagencia = mysqli_real_escape_string($con,$_POST['idagencia']);
      $poltrona = mysqli_real_escape_string($con,$_POST['poltrona']);
      $atendente = $_SESSION['UsuarioNome'];
      $idsituacao = mysqli_real_escape_string($con,$_POST['idsituacao']);
      $quem_recebeu = $_SESSION['UsuarioNome'];
      //Campos Tabela Contas_Receber
      //Formata o valores para inserir no BD
      $valor_total = mysqli_real_escape_string($con,$_POST['valor']);
      $valort_ponto = str_replace(".","",$valor_total);  
      $valortformatado = str_replace(",",".",$valort_ponto);
     
          $cad = mysqli_query ($con,"UPDATE passagem set idembarque = '$idembarque', desembarque = '$desembarque', poltrona = '$poltrona', obs = '$obs', editado_por = '$editado_por',hembarque = '$hembarque', data_edicao = '$date2' where idpassagem=$idpassagem")  or die(mysqli_error($con));

          $updatecontas = mysqli_query ($con,"UPDATE contas_receb_movi set valor_total = '$valortformatado' where idpassagem=$idpassagem")  or die(mysqli_error($con));

          $updatecontasreceber = mysqli_query ($con,"UPDATE contas_receber set valor = '$valortformatado', obs = '$obs' where idmovimento=$idmovimento")  or die(mysqli_error($con));

          $updatepoltronas = mysqli_query ($con,"UPDATE poltronas_ocupadas set id_poltrona = '$poltrona' where idpassagem=$idpassagem")  or die(mysqli_error($con));

if($cad){ 

criaLog("Passagem Editada", "Passagem numero $idpassagem"); ?>   
                    <?php
    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Passagem Editada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: cliente_imagens.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  
                          
            }
          else{ ?>
                
        <?php  
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar Passagem <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=passagem.php?idviagem=$idviagem'>";  }

?>
        </div>

    </div>