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
      $idcliente = mysqli_real_escape_string($con,$_POST['idcliente']);
      $nome = mysqli_real_escape_string($con,$_POST['nome']);
      $idviagem = mysqli_real_escape_string($con,$_POST['idviagem']);
      $documento = mysqli_real_escape_string($con,$_POST['documento']);
      $sexo = mysqli_real_escape_string($con,$_POST['sexo']);
      $mae = mysqli_real_escape_string($con,$_POST['mae']);
      $org = mysqli_real_escape_string($con,$_POST['org']);
      //$nascimento = $_POST['rg'];
      $nascimento = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['nascimento']))); 
      $celular = mysqli_real_escape_string($con,$_POST['celular']);
      //$data_cadastro = $_POST['data_cadastro']; 
      $data_cadastro = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['data_cadastro'])));
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      $atendente = mysqli_real_escape_string($con,$_POST['atendente']); 
      //$foto = $_FILES['foto'];


// executa a query 
$dados_clientes = mysqli_query($con,"SELECT documento from clientes 
where documento = '$documento'") or die(mysqli_error($con));  

$linha_cliente = mysqli_fetch_array($dados_clientes);       

$total_cliente = mysqli_num_rows($dados_clientes);

if($total_cliente) { 
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Não pode ter mais de 1 cliente com o <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  }
               else {
      //$foto = $_FILES['foto'];
          $cad = mysqli_query($con,"INSERT INTO clientes (nome, documento, org, sexo, nascimento, celular, data_cadastro, obs, atendente, mae, idcontrato) values('$nome','$documento','$org','$sexo','$nascimento','$celular','$data_cadastro','$obs','$atendente','$mae','$idcontrato') ") or die(mysqli_error($con)); 
          if(mysqli_affected_rows($con) == 1){ 

                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cliente Cadastrado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: cliente_receitas.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  
                          
            }
          else{ ?>
                
        <?php  
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Cadastrar o Cliente <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        //header("Location: cliente_receitas.php?idcliente=$idcliente");      
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  }
        }
    }
?>
        </div>

    </div>