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
$idpassagem = $_GET['idpassagem'];
$idcliente = $_GET['idcliente'];
$query = sprintf("SELECT DISTINCT c.nome, c.cpf, c.passaporte, p.origem, p.destino, p.data_passagem, st.status, st.idstatuspass, p.idpassagem, crm.entrada, crm.valor_total, crm.idpassagem, crm.qtdparcelas, fp.idformapg, fp.tipo, MIN(crm.vencimento) as vencimento, p.obs, crm.valor_restante, p.idcliente, crm.idmovimento
from clientes c, passagem p, status_passagem st, contas_receb_movi crm, formapg fp
where c.idcliente = p.idcliente
and p.status_passagem = st.idstatuspass
and crm.idpassagem = p.idpassagem
and crm.idcliente = c.idcliente
and crm.idformapg = fp.idformapg
and p.idpassagem = $idpassagem
order by p.idpassagem desc"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados);

$valoredit = $linha['valor_total'];
$valoredit_format = number_format($valoredit,2, ',', '.');   

$entradaedit = $linha['entrada'];
$entradaedit_format = number_format($entradaedit,2, ',', '.');  

$valorrestante = $linha['valor_restante'];
$valorrestante_format = number_format($valorrestante,2, ',', '.'); 
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
                                        <a class="nav-link active" href="passagem.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Passagem</a>
                                      </li>
                                    </ul>

                            <div class="card-body wizard-content"> 
                                <form action="<?php $_SERVER['PHP_SELF']?>" class="form" method="post">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cliente">Nome do Cliente</label>
                                                    <input type="text" class="form-control" id="cliente" name="cliente" value="<?php echo $linha['nome']?>" readonly> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="origem">Origem</label>
                                                    <input type="text" class="form-control" id="origem" name="origem" value="<?php echo $linha['origem']?>" readonly> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="destino">Destino</label>
                                                    <input type="text" class="form-control" id="destino" name="destino" value="<?php echo $linha['destino']?>" readonly> 
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="data_passagem">Data Passagem</label>
                                                        <input type="date" class="form-control" id="data_passagem" name="data_passagem" value="<?php echo $linha['data_passagem']?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                            <label for="valor" class="control-label">Valor Total</label>
                                                <input type="text" class="form-control" id="valor_total" name="valor_total" value="<?php echo $valoredit_format ?>"onKeyPress="return(MascaraMoeda(this,'.',',',event))" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="valor" class="control-label">Entrada R$</label>
                                                        <input type="text" class="form-control" id="entrada" name="entrada" value="<?php echo $entradaedit_format ?>"onKeyPress="return(MascaraMoeda(this,'.',',',event))" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="valor">Valor Restante</label>
                                                    <input type="text" class="form-control" id="valrestante" name="valrestante" value="<?php echo $valorrestante_format ?>"onKeyPress="return(MascaraMoeda(this,'.',',',event))" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                 <label for="idformapg">Forma de Pagamento</label>
                                                    <select class="custom-select form-control" name="idformapg" id="idformapg" readonly onchange="checkpg()">
                                                        <option value="<?php echo $linha['idformapg']?>"><?php echo $linha['tipo']?></option>
                              </select> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="vencimento">Vencimento</label>
                                                    <input type="text" class="form-control" id="vencimento" name="vencimento" value="<?php echo date('d/m/Y', strtotime($linha['vencimento'])); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="obs">Observação</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $linha['obs']?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="data_cadastro" id="data_cadastro" value="<?php echo $datepass;?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="atendente" id="atendente" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                           <div class="form-group m-b-40 col-md-12">
                                             <a href="passagem_editar.php?idpassagem=<?php echo $linha['idpassagem']?>&idcliente=<?php echo $linha['idcliente']?>&idmovimento=<?php echo $linha['idmovimento']?>"  class="btn btn-info" role="button"><i class="fa fa-edit"></i> Editar</a>
                                        </div>
                                    </section>
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
