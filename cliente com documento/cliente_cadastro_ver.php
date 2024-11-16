<!DOCTYPE html>
<html lang="en">

<head>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
$datebr = date('d-m-Y H:i'); 
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
include "../config.php"; 
?>
</head>

<body class="fix-header card-no-border">
<?php 
//ini_set('display_errors',1);
include "../verificanivel.php";    
include "../funcoes.php"; 
?>

<?php 
$idcliente = $_GET['idcliente'];
$query = sprintf("SELECT * from clientes where idcliente=$idcliente"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados);
    
// ----------------------- Usuario ----------------------------    
// executa a query 
$usuarios = mysqli_query($con,"SELECT nivel FROM usuario where id_usuario=$usuarioid") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhausuario = mysqli_fetch_assoc($usuarios); 
                
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
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Cadastro de Paciente</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active"><?php echo $linha['nome'] ?></li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-12">
                        <div class="card">                      
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="cliente_cadastro_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Cliente</a>
                                      </li>
                                      <li class="nav-item ">
                                        <a class="nav-link" href="cliente_passagem_listar.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-hospital"></i>Passagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Financeiro</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro_parcelas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                    </ul>

                            <div class="card-body wizard-content">
                                
                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                <div class="row">
                                    <div class="form-group m-b-40 col-md-8">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $linha['nome'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                        <label for="nascimento">Nascimento</label>
                                        <input type="text" class="form-control" id="nascimento" name="nascimento" value="<?php echo date('d/m/Y', strtotime($linha['nascimento'])); ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                        <label for="sexo">Sexo</label>
                                        <select class="form-control p-0" id="sexo" name="sexo" readonly>
                                            <option value="<?php echo $linha['sexo'] ?>"><?php echo $linha['sexo'] ?></option>
                                        </select><span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="rg">Documento</label>
                                        <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $linha['documento'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $linha['celular'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="obs">Observação</label>
                                        <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $linha['obs'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    </div>
                                </form>
                            </div>
                        </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
<?php 
include "../rodape.php";
?>
        </div>

    </div>
    <!-- ============================================================== -->

</body>

</html>
