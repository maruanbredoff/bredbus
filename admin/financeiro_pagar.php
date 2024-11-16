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
$idcontrato = $_SESSION['ContratoID'];
// Inicialização das variáveis para Data Inicial e Data Final
$data_inicial = date('Y-m-01');  // Data de 7 dias atrás
$data_final = date('Y-m-d');  // Data de hoje
// Convertendo para o formato em português
$data_inicial_pt = date('d/m/Y', strtotime($data_inicial));
$data_final_pt = date('d/m/Y', strtotime($data_final));

$valorpago_format = '';
$valorgeral_format = '';
$valorapagar_format = '';
$valorpendente_format = '';
$valorcancelado_format = '';

// Se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura as datas enviadas pelo formulário
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];
    $data_inicial_pt = date('d/m/Y', strtotime($data_inicial));
    $data_final_pt = date('d/m/Y', strtotime($data_final));
    // Filtros com data inicial e final
    $where_clause = "WHERE cpm.data_movimento BETWEEN ? AND ? AND cpm.idsituacao <> 3 AND cpm.idcontrato = $idcontrato";
    $where_clause_pago = "WHERE cpm.data_movimento BETWEEN ? AND ? AND cpm.idsituacao = 2 AND cpm.idcontrato = $idcontrato" ;
    $where_clause_cancelado = "WHERE cpm.data_movimento BETWEEN ? AND ? AND cpm.idsituacao = 3 AND cpm.idcontrato = $idcontrato" ;
    $where_clause_pendente = "WHERE cpm.data_movimento BETWEEN ? AND ? AND cpm.idsituacao = 1 AND cpm.idcontrato = $idcontrato" ;
} else {
    // Se não houver POST, exibe os registros do mes atual
    $where_clause = "WHERE cpm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND cpm.idsituacao <> 3 AND cpm.idcontrato = $idcontrato";
    $where_clause_pago = "WHERE cpm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND cpm.idsituacao <> 2 AND cpm.idcontrato = $idcontrato";
    $where_clause_cancelado = "WHERE cpm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND cpm.idsituacao <> 3 AND cpm.idcontrato = $idcontrato";
    $where_clause_pendente = "WHERE cpm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND cpm.idsituacao = 1 AND cpm.idcontrato = $idcontrato";
}

// Consulta principal
$query = "SELECT cpm.idmovipagar, cpm.data_movimento, cpm.valor, cpm.tipopg, cpm.idformapg, cpm.qtdparcelas, 
                 fp.tipo, cpm.tipopg, cpm.descricao, cpm.data_pg, sc.situacao, tp.descricao as tipo_despesa, tp.idtipopg, cpm.idmovipagar
          FROM contas_pagar_movi cpm 
          INNER JOIN formapg fp ON fp.idformapg = cpm.idformapg
          INNER JOIN situacao_caixa sc ON sc.idsituacao = cpm.idsituacao
          INNER JOIN tipopg tp ON tp.idtipopg = cpm.tipopg
          $where_clause
          GROUP BY cpm.idmovipagar, cpm.data_movimento, cpm.valor, cpm.tipopg, cpm.idformapg, 
                   cpm.qtdparcelas, fp.tipo, cpm.tipopg, cpm.descricao";
$stmt = $con->prepare($query);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt->bind_param("ss", $data_inicial, $data_final);
}
$stmt->execute();
$dados = $stmt->get_result();
$linha = $dados->fetch_assoc();
$total = $dados->num_rows;

// Soma o valor de parcelas pendentes
$somapendente_query = "SELECT SUM(cpm.valor) as total_pendente 
                       FROM contas_pagar_movi cpm 
                       INNER JOIN situacao_caixa sc ON sc.idsituacao = cpm.idsituacao
                       INNER JOIN formapg fp ON fp.idformapg = cpm.idformapg
                       $where_clause_pendente";
$stmt_somapendente = $con->prepare($somapendente_query);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt_somapendente->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somapendente->execute();
$dados_soma_pendente = $stmt_somapendente->get_result();
$linhapendente = $dados_soma_pendente->fetch_assoc();
$valorpendente = round($linhapendente['total_pendente'] * 100 / 100);
$valorpendente_format = number_format($valorpendente, 2, ',', '.');

// Soma o valor de parcelas canceladas
$somacancelado_query = "SELECT SUM(cpm.valor) as total_cancelado 
                        FROM contas_pagar_movi cpm 
                        INNER JOIN situacao_caixa sc ON sc.idsituacao = cpm.idsituacao
                        INNER JOIN formapg fp ON fp.idformapg = cpm.idformapg
                        $where_clause_cancelado";
$stmt_somacancelado = $con->prepare($somacancelado_query);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt_somacancelado->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somacancelado->execute();
$dados_soma_cancelado = $stmt_somacancelado->get_result();
$linhacancelado = $dados_soma_cancelado->fetch_assoc();
$valorcancelado = round($linhacancelado['total_cancelado'] * 100 / 100);
$valorcancelado_format = number_format($valorcancelado, 2, ',', '.');

// Soma o valor de parcelas pagas
$somapago_query = "SELECT SUM(cpm.valor) as total_pago 
                   FROM contas_pagar_movi cpm 
                   INNER JOIN situacao_caixa sc ON sc.idsituacao = cpm.idsituacao
                   INNER JOIN formapg fp ON fp.idformapg = cpm.idformapg
                   $where_clause_pago";
$stmt_somapago = $con->prepare($somapago_query);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt_somapago->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somapago->execute();
$dados_soma_pago = $stmt_somapago->get_result();
$linhapago = $dados_soma_pago->fetch_assoc();
$valorpago = round($linhapago['total_pago'] * 100 / 100);
$valorpago_format = number_format($valorpago, 2, ',', '.');

// Soma o valor total de parcelas
$somageral_query = "SELECT SUM(cpm.valor) as total_geral 
                    FROM contas_pagar_movi cpm 
                    INNER JOIN formapg fp ON fp.idformapg = cpm.idformapg
                    $where_clause";
$stmt_somageral = $con->prepare($somageral_query);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt_somageral->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somageral->execute();
$dados_soma = $stmt_somageral->get_result();
$linhapagogeral = $dados_soma->fetch_assoc();
$valorgeral = round($linhapagogeral['total_geral'] * 100 / 100);
$valorgeral_format = number_format($valorgeral, 2, ',', '.');

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
                                        <a class="nav-link active" href="financeiro_pagar.php"><i class="mdi mdi-cash-multiple"></i> Contas a Pagar</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="financeiro_pagar_listacanc.php"><i class="fa fa-trash"></i> Canceladas</a>
                                      </li>
                                    </ul>
                        <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                    <!-- Formulário para filtro por data -->
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="data_inicial">Data Inicial:</label>
                                <!-- Verifique se o valor está preenchendo corretamente -->
                                <input type="date" id="data_inicial" name="data_inicial" class="form-control" required
                                       value="<?php echo $data_inicial; ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="data_final">Data Final:</label>
                                <input type="date" id="data_final" name="data_final" class="form-control" required
                                       value="<?php echo $data_final; ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div></div></div>
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
<!--                                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrar_tipopg">Cadastrar Tipo Pg</button> -->
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
                                                <form action="financeiro_pagar_cadastrar.php" method="post">
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
                                                <h4 class="modal-title" id="editar_pagamento">Editar Pagamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="financeiro_pagar_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group ">
                                                    <label for="descricao">Descreva o Pagamento</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $aqui3['descricao']?>" required>
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
                                                          <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $aqui3['valor']?>" required>
                                                        <input type="hidden" class="form-control" id="data_movimento" name="data_movimento" value="<?php echo $date2 ?>" required>
                                                        <input type="hidden" name="resp_edicao" id="resp_edicao" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                        <input type="hidden" class="form-control" id="idmovipagar" name="idmovipagar" value="<?php echo $aqui3['idmovipagar'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="idformapg">Forma de Pagamento</label>
                                                    <select class="form-control" name="idformapg" id="idformapg" required>
                                                        <option value="<?php echo $aqui3['idformapg'] ?>"><?php echo $aqui3['tipo'] ?></option>
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
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Editar</button>
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
                                                <form action="financeiro_pagar_cancelar.php" method="post">
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
