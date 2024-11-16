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
$idcontrato = $_SESSION['ContratoID'];
// Primeira consulta: busca informações do cliente pelo idcontrato
$sql_clientes = "SELECT idcliente, nome, mae, documento, sexo, nascimento, celular, obs, org, idcontrato 
                 FROM clientes 
                 WHERE idcliente = $idcliente and idcontrato = ? 
                 ORDER BY nome";
$stmt_clientes = $con->prepare($sql_clientes);
$stmt_clientes->bind_param("i", $idcontrato);  // "i" indica que $idcontrato é um inteiro
$stmt_clientes->execute();
$dados = $stmt_clientes->get_result();

// Verifica se há dados retornados e os transforma em um array
$linha = $dados->fetch_assoc();
$total = $dados->num_rows; // Número total de registros retornados

// Segunda consulta: busca o nível do usuário pelo id_usuario
$sql_usuarios = "SELECT u.nivel 
                 FROM usuario u 
                 INNER JOIN usuario_contrato uc ON uc.idcontrato = u.idcontrato 
                 WHERE id_usuario = ?";
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->bind_param("i", $usuarioid);  // "i" indica que $usuarioid é um inteiro
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->get_result();

// Verifica se há dados retornados e os transforma em um array
$linhausuario = $usuarios->fetch_assoc();
                
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
                                    <div class="form-group m-b-40 col-md-6">
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
                                        <label for="documento">Documento</label>
                                        <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $linha['documento'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                        <label for="org">ORG EXP.</label>
                                        <input type="text" class="form-control" id="org" name="org" value="<?php echo $linha['org'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $linha['celular'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="mae">Mãe</label>
                                        <input type="text" class="form-control" id="mae" name="mae" value="<?php echo $linha['mae'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-12">
                                        <label for="obs">Observação</label>
                                        <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $linha['obs'] ?>" readonly>
                                        <span class="bar"></span>
                                    </div>  
                                    </div>
                                    <a href="" class="btn btn-info" role="button" data-toggle="modal" data-target="#editar_cliente<?php echo $linha['idcliente']?>">Editar</i></a>
                                </form>
                            </div>
                        </div>
            </div>

               <?php foreach($dados as $aqui2){ ?> 
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_cliente<?php echo $aqui2['idcliente']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_cliente">Editar Cliente</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="cliente_editar.php" method="post">
                                            <div class="row">
                                                <div class="form-group m-b-40 col-md-7">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $aqui2['nome'] ?>" required>
                                                    <input type="hidden" class="form-control" id="idcliente" name="idcliente" value="<?php echo $aqui2['idcliente'] ?>" required>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-5">
                                                    <label for="nascimento">Nascimento</label>
                                                    <input type="text" class="form-control" id="nascimento" name="nascimento" value="<?php echo $aqui2['nascimento'] ?>" required>
                                                    <span class="bar"></span>
                                                </div>
                                           
                                                <div class="form-group m-b-40 col-md-4">
                                                    <label for="sexo">Sexo</label>
                                                    <select class="form-control p-0" id="sexo" name="sexo" required>
                                                    <?php echo "<option value='".$aqui2['sexo']."'>".$aqui2['sexo']."</option>"; ?>
                                                        <option>Masculino</option>
                                                        <option>Feminino</option>
                                                        <option>Outros</option>
                                                    </select><span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-5">
                                                    <label for="documento">Documento</label>
                                                    <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $aqui2['documento'] ?>" >
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-3">
                                                    <label for="documento">Org Exp.</label>
                                                    <input type="text" class="form-control" id="org" name="org" value="<?php echo $aqui2['org'] ?>" required>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-5">
                                                    <label for="celular">Celular</label>
                                                    <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $aqui2['celular'] ?>" OnKeyPress="formatar('##-#####-####', this)">
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-7">
                                                    <label for="celular">Nome Mãe</label>
                                                    <input type="text" class="form-control" id="mae" name="mae" value="<?php echo $aqui2['mae'] ?>">
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-12">
                                                    <label for="obs">Observação</label>
                                                    <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $aqui2['obs'] ?>">
                                                    <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $datebr ?>">
                                                    <input type="hidden" class="form-control" id="atendente" name="atendente" value="<?php echo $_SESSION['UsuarioNome']?>">
                                                    <span class="bar"></span>
                                                </div>
                                                       <div class="form-group m-b-40 col-md-12">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                            <button type="submit" name="editar" id="editar" class="btn btn-primary">Editar</button>
                                                    </div>
                                                </div>
                                            </form>


                                            </div>
                                        </div>
                                    </div>
                                </div> 
                         <?php  }  ?> 
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
