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
    <title>Admin Press Admin Template - The Ultimate Bootstrap 4 Admin Template</title>
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
</head>

<body>
    
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
    header("Location: ../restrita.php"); exit;
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
      $nova_senha = SHA1($_POST['nova_senha']); 
      $confirma_senha = SHA1($_POST['confirma_senha']);
      $senha_user = $linha['senha'];
      if($nova_senha == "" && $confirma_senha == "") { ?>
             <div class="alert alert-success"> 
                 As senhas não podem ser nulas!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
<?php } elseif (($nova_senha != $confirma_senha)) {
         ?>
            <div class="alert alert-success"> 
                 As senhas não correspondem!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
<?php }        
     else if($nova_senha == $confirma_senha){
              $cad = mysqli_query ($con,"UPDATE usuario set senha = '$confirma_senha', altera_senha = 0 where id_usuario = '$id_usuario'")or die(mysqli_error($con)); 
         ?>
            <div class="alert alert-success"> 
                 Senha alterada com Sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
<?php
session_destroy();
          echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=/sistema'>";   
         }
}
?>
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" method="post" action="<?php $_SERVER['PHP_SELF']?>">
                        <img src="assets/images/logo2.png" alt="homepage" width="350" height="150" class="dark-logo" /><br><br>
                        <center><h3 class="box-title m-b-20"><?php echo $_SESSION['UsuarioNome']; ?></h3></center>   
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <label for="usuario">Nova Senha</label>
						        <input class="form-control" type="password" id="nova_senha" name="nova_senha" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                    <label for="senha">Confirmar Senha</label>
                                    <input type="hidden" name="usuario" value="<?php echo $_SESSION['usuario']; ?>">
                                    <input class="form-control" type="password" id="confirma_senha" name="confirma_senha" required>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Alterar Senha</button>
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