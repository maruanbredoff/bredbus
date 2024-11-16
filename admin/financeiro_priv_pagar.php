<!DOCTYPE html>
<html lang="en">

<head>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date2 = date('Y-m-d H:i');
//$datebr = date('d-m-Y H:i', strtotime('+1 months', strtotime(date('d-m-Y'))));
$datebr2 = date('d-m-Y H:i');
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
include "../verificanivel.php"; 
include "../funcoes.php"; 

$query = sprintf("select cpm.idmovipagar, cpm.data_movimento, cpm.valor, cpm.tipopg, cpm.idformapg, cpm.qtdparcelas, fp.tipo, cpm.tipopg, cpm.descricao, cpm.data_pg, sc.situacao, tp.descricao as tipo_despesa
from contas_priv_pagar_movi cpm 
inner join formapg fp on fp.idformapg = cpm.idformapg
inner join situacao_caixa sc on sc.idsituacao = cpm.idsituacao
inner join tipopg tp on tp.idtipopg = cpm.tipopg
where cpm.cancelado <> 1
group by cpm.idmovipagar, cpm.data_movimento, cpm.valor, cpm.tipopg, cpm.idformapg, cpm.qtdparcelas, fp.tipo, cpm.tipopg, cpm.descricao"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);


//------------------------------ Soma o valor de parcelas pendentes -----------------------------------
$somapendente = sprintf("select sum(cpm.valor) as total_pendente 
from contas_priv_pagar_movi cpm 
inner join situacao_caixa sc on sc.idsituacao = cpm.idsituacao
inner join formapg fp on fp.idformapg = cpm.idformapg
where cpm.idsituacao = 1 and cpm.cancelado <> 1"); 

// executa a query 
$dados_soma_pendente = mysqli_query($con,$somapendente) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapendente = mysqli_fetch_assoc($dados_soma_pendente);
$valorpendente = round($linhapendente['total_pendente']*100/100);
$valorpendente_format = number_format($valorpendente,2, ',', '.');
    
//------------------------------ Soma o valor de parcelas canceladas -----------------------------------
$somacancelado = sprintf("select sum(cpm.valor) as total_cancelado 
from contas_priv_pagar_movi cpm 
inner join situacao_caixa sc on sc.idsituacao = cpm.idsituacao
inner join formapg fp on fp.idformapg = cpm.idformapg
where cpm.cancelado = 1"); 

// executa a query 
$dados_soma_cancelado = mysqli_query($con,$somacancelado) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhacancelado = mysqli_fetch_assoc($dados_soma_cancelado);
$valorcancelado = round($linhacancelado['total_cancelado']*100/100);
$valorcancelado_format = number_format($valorcancelado,2, ',', '.');
    
//------------------------------Soma o valor de parcelas pagas -----------------------------------------------
$somapago = sprintf("select sum(cpm.valor) as total_pago 
from contas_priv_pagar_movi cpm 
inner join situacao_caixa sc on sc.idsituacao = cpm.idsituacao
inner join formapg fp on fp.idformapg = cpm.idformapg
where cpm.idsituacao = 2 and cpm.cancelado <> 1"); 

// executa a query 
$dados_soma_pago = mysqli_query($con,$somapago) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapago = mysqli_fetch_assoc($dados_soma_pago);   
$valorpago = round($linhapago['total_pago']*100/100);
$valorpago_format = number_format($valorpago,2, ',', '.');

//------------------------- Soma o valor de parcelas--------------------------------------
$somageral = sprintf("select sum(cpm.valor) as total_geral 
from contas_priv_pagar_movi cpm 
inner join formapg fp on fp.idformapg = cpm.idformapg
where cpm.cancelado <> 1"); 

// executa a query 
$dados_soma= mysqli_query($con,$somageral) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapagogeral = mysqli_fetch_assoc($dados_soma);   
    
$valorgeral = round($linhapagogeral['total_geral']*100/100);
    
$valorgeral_format = number_format($valorgeral,2, ',', '.');
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
                    <h3 class="text-themecolor">Contas a Pagar</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item">Finanças</li>
                        <li class="breadcrumb-item active">Pagar</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
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
          $cad_pagamento = mysqli_query($con,"INSERT INTO contas_priv_pagar_movi (descricao,valor,idformapg,data_movimento,resp_cadastro, idsituacao, tipopg, data_pg) 
            values('$descricao','$valortotal','$idformapg','$date2','$resp_cadastro', 2,'$tipopg','$date2') ") or die(mysqli_error($con)); 

          if(mysqli_affected_rows($con) == 1){ ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=financeiro_priv_pagar.php'>";    
            }
          else{ ?>
                <div class="alert alert-danger alert-rounded">
                    <i class="ti-user"></i> Erro. Ocorreu algum problema no Cadastro!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
        <?php }
        }
?>
            <div class="container-fluid"> 
<?php
if(isset($_SESSION['msg'])){
echo $_SESSION['msg'];
unset($_SESSION['msg']);
}
?>
                <div class="row">
                    <div class="col-12">
                    <div class="card">
                                    <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="financeiro_priv_pagar.php"><i class="mdi mdi-cash-multiple"></i> Contas a Pagar</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="financeiro_priv_pagar_listacanc.php"><i class="fa fa-trash"></i> Canceladas</a>
                                      </li>
                                    </ul>
                        <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-warning"></i></h2>
                                    <h2 class="">R$ <?php echo $valorpendente_format ?></h2>
                                    <div class="font-bold text-warning"><i class="fa fa-exclamation"></i> <small>Pendente</small></div></div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-success"></i></h2>
                                    <h2 class="">R$ <?php echo $valorpago_format?></h2>
                                    <div class="font-bold text-success"><i class="fa fa-check"></i> <small>Pagos</small></div></div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-danger"></i></h2>
                                    <h2 class="">R$ <?php echo $valorcancelado_format ?></h2>
                                    <div class="font-bold text-danger"><i class="fa fa-check"></i> <small>Cancelados</small></div></div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-info"></i></h2>
                                    <h2 class="">R$ <?php echo $valorgeral_format ?></h2>
                                    <div class="font-bold text-info"><i class="fa fa-check"></i> <small>Total</small></div></div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                                               <div class="card-body wizard-content">
                                    <h4>Fluxo</h4>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cadastrar_pagamento">Cadastrar Pagamento</button>
                                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrar_tipopg">Cadastrar Tipo Pg</button>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Data</th>
                                                    <th>Tipo</th>
                                                    <th>Descrição</th>
                                                    <th>Valor</th>
                                                    <th>Forma PG</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                                    $valor = $linha['valor'];
                                                    $valor_formatado = number_format($valor,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idmovipagar']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['data_movimento'])); ?></td>
                                                    <td><?php echo $linha['tipo_despesa']?></td>
                                                    <td><?php echo $linha['descricao']?></td>
                                                    <td width="110">R$ <?php echo $valor_formatado?></td>
                                                    <td><?php echo $linha['tipo']?></td>
                                                    <td width="166">
                                                 <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#editar_pagamento<?php echo $linha['idmovipagar']?>"><i class="fa fa-edit"></i></a>
                                                    <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#financeiro_cancelar<?php echo $linha['idmovipagar']?>"><i class="fa fa-trash"></i></a>

                                                    </td>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha = mysqli_fetch_assoc($dados)); 
                                                    // fim do if 
                                                            } 
                                            ?> 
                                            </tbody>
                                        </table>
                                    </div>
                            </div></div>
                        </div>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrar_pagamento" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_procedimento">Cadastrar Pagamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group ">
                                                    <label for="descricao">Descreva o Pagamento</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="valor">Tipo Despesa</label>
                                                    <select class="form-control" name="tipopg" id="tipopg" required>
                                                        <option value="">Escolha o Tipo</option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM tipopg") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idtipopg']."'>".$line['descricao']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="qtdparcelas">Valor</label>
                                                          <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
                                                        <input type="hidden" class="form-control" id="data_movimento" name="data_movimento" value="<?php echo $date2 ?>" required>
                                                        <input type="hidden" name="resp_cadastro" id="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="idformapg">Forma de Pagamento</label>
                                                    <select class="form-control" name="idformapg" id="idformapg" required>
                                                        <option value="">Forma de Pagamento</option>
														<?php 
														$q = mysqli_query($con,"SELECT * FROM formapg order by tipo") or die(mysqli_error());	 
														if(mysqli_num_rows($q)){ 
														//faz o loop para preencher o campo criado com os valores retornados na consulta 
														while($line = mysqli_fetch_array($q)) 
														{ 
														echo "<option value='".$line['idformapg']."'>".$line['tipo']."</option>";
														} 
														}
														 else {//Caso não haja resultados 
														echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
														} 	
														?>	
										          </select> 
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Cadastrar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                <?php foreach($dados as $aqui3){ 
                //$val2 = round($aqui2['valor']*100/100);
                $valformatado = number_format($aqui3['valor'],2, ',', '.');?>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_pagamento<?php echo $aqui3['idmovipagar']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_procedimento">Editar Pagamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="financeiro_pagar_editar" method="post">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group ">
                                                    <label for="descricao">Descreva o Pagamento</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="valor">Tipo Despesa</label>
                                                    <select class="form-control" name="tipopg" id="tipopg" required>
                                                        <option value="<?php echo $aqui3['idtipopg'] ?>"><?php echo $aqui3['tipo_despesa'] ?></option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM tipopg") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idtipopg']."'>".$line['tipo_despesa']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="qtdparcelas">Valor</label>
                                                          <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
                                                        <input type="hidden" class="form-control" id="data_movimento" name="data_movimento" value="<?php echo $date2 ?>" required>
                                                        <input type="hidden" name="resp_cadastro" id="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="idformapg">Forma de Pagamento</label>
                                                    <select class="form-control" name="idformapg" id="idformapg" required>
                                                        <option value="">Forma de Pagamento</option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM formapg order by tipo") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idformapg']."'>".$line['tipo']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Cadastrar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                         <?php  }  ?>
                    
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrar_tipopg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_tipopg">Cadastrar Pagamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="financeiro_cadastrar_tipopg.php" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                    <label for="tipopg">Tipo de Pagamento</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Ex: Cemig" required>
                                                        <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $date ?>" required>
                                                        <input type="hidden" name="responsavel" id="responsavel" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Cadastrar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    <?php foreach($dados as $aqui2){ ?>
                                <div class="modal fade bs-example-modal" tabindex="-1" id="financeiro_cancelar<?php echo $aqui2['idmovipagar']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cancelar_pagamento">Cancelar Pagamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="financeiro_priv_pagar_cancelar.php" method="post">
                                                    <div class="form-group">
                                                        <label for="evolucao" class="control-label">Motivo</label>
                                                        <textarea class="form-control" rows="3" id="mcancelamento" name="mcancelamento" required></textarea>
                                                        <input type="hidden" class="form-control" id="idmovipagar" name="idmovipagar" value="<?php echo $aqui2['idmovipagar'] ?>" required>
                                                        <input type="hidden" class="form-control" id="cancelado_por" name="cancelado_por" value="<?php echo $_SESSION['UsuarioNome']?>" readonly>
                                                    </div>
                                                    <button type="submit" name="cancelar" id="cancelar" class="btn btn-danger">Confirmar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    <?php }?>
<?php 
include "../rodape.php";
?>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ]

    });
    </script>
    <!-- ============================================================== -->

</body>

</html>
