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
$obs = mysqli_real_escape_string($con,$_POST['obs']); 
     
          $cad = mysqli_query ($con,"UPDATE viagem set obs = '$obs' where idviagem=$idviagem")  or die(mysqli_error($con));

if($cad){ 

criaLog($con,"viagem Editada", "viagem numero $idviagem"); ?>   
                    <?php
    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Obs Adicionada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: cliente_imagens.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  
                          
            }
          else{ ?>
                
        <?php  
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Editar Adicionar <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  }

?>
        </div>

    </div>