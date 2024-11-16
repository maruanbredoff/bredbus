<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>OdontoCare - Seu sistema inteligente de Odontologia</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>

img {
  max-width: 100%;
  height: auto;
}

</style>
</head>

<body>
    <?php
include "config.php"; 
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$nivel_necessario = 0;

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona o visitante de volta pro login
    header("Location: index.php"); exit;
}
$id_usuario = $_SESSION['UsuarioID'];
$query = sprintf("select * from usuario where id_usuario = '$id_usuario'");

// executa a query 
$dados = mysqli_query($con,$query) or die(mysql_error()); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados);     
if ($_POST)
        { 
      $senha_atual = SHA1($_POST['senha_atual']);
      $nova_senha = SHA1($_POST['nova_senha']); 
      $confirma_senha = SHA1($_POST['confirma_senha']);
      $senha_user = $linha['senha'];
      if($senha_atual == "" && $nova_senha == "" && $confirma_senha == "") {
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>As Senhas não podem ser Nulas </div>"; 
      }elseif ($senha_atual != $senha_user) {
          
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Senha atual esta errada!</div>";     
                    }
			elseif ($senha_atual != $senha_user || $nova_senha == "" || $confirma_senha == "") {
                
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Novas senhas em branco </div>";      
                    }
     elseif (($nova_senha != $confirma_senha)) {
         
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>As Senhas não correspondem </div>";     
                    }
            
     else if(($senha_atual == $senha_user) && ($nova_senha == $confirma_senha)){
              $cad = mysqli_query ($con,"UPDATE usuario set senha = '$confirma_senha' where id_usuario = '$id_usuario'")or die(mysqli_error($con)); 
         
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Senha alterada com Sucesso</div>";      
          echo "<meta HTTP-EQUIV='refresh' CONTENT='3;URL=sistema/index.php'>";   
         }
      
               
                     
             //header("Location: listar_entradas.php");
           // echo "<script>alert('Entrada efetuada com sucesso');</script>";
}
   
?>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" method="post" action="<?php $_SERVER['PHP_SELF']?>">
<?php
if(isset($_SESSION['msg'])){
echo $_SESSION['msg'];
unset($_SESSION['msg']);
}
?>
                        <div class="img">
                        <center><img src="assets/images/logo2.png" alt="homepage" width="150" height="50" class="dark-logo" /></center></div>
                        <center><h3 class="box-title m-b-20"><?php echo $_SESSION['UsuarioNome']; ?></h3></center>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <label for="usuario"><strong>Senha Atual</strong></label>
						        <input class="form-control" type="text" name="senha_atual" id="senha_atual" placeholder="Senha Atual" value="<?php echo $linha['senha']; ?>">
                            </div></div>
                        <div class="form-group">
                        <div class="col-xs-12">
                                <label for="senha"><strong>Senha</strong></label>
						        <input class="form-control" type="password" name="nova_senha" id="nova_senha" placeholder="Nova Senha">
                        </div></div>                        
                        <div class="form-group">
                        <div class="col-xs-12">
                                <label for="senha"><strong>Comfirma Senha</strong></label>
						        <input class="form-control" type="password" name="confirma_senha" id="confirma_senha" placeholder="Confirme a Senha">
                        </div></div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Alterar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>