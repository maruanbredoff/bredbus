<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/css_onibus.css">
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
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
include "../verificanivel.php"; 
include "../funcoes.php"; 
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];
$idviagem = $_GET['idviagem'];

// Consulta para `viagem_encomenda`
$sql_viagem_encomenda = "SELECT ve.idencomenda, ve.idviagem, ve.etiqueta, ve.descricao, ve.remetente, ve.destinatario,ve.descricao, ve.localhorigem, ve.localdestino, ve.telremetente, ve.teldestinatario, ve.valor, ce.idsituacao, ve.obs, ve.docremetente, ve.docdestinatario, sc.situacao, ce.valorpg, ve.idencomenda, ve.tipo, ve.qtd, ve.valdeclarado, ve.etiqueta 
                         FROM viagem_encomenda ve
                         INNER JOIN viagem v ON v.idviagem = ve.idviagem
                         INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
                         LEFT JOIN contas_encomendas ce ON ce.idencomenda = ve.idencomenda
                         WHERE v.idviagem = ? AND sc.idsituacao <> 3 AND ve.idcontrato = ?
                         ORDER BY ve.idencomenda";

$stmt_viagem_encomenda = $con->prepare($sql_viagem_encomenda);
$stmt_viagem_encomenda->bind_param("ii", $idviagem, $idcontrato);
$stmt_viagem_encomenda->execute();
$dados2 = $stmt_viagem_encomenda->get_result();

$linha2 = $dados2->fetch_assoc();
$total2 = $dados2->num_rows;

// Soma do valor das parcelas pagas
$sql_somapago = "SELECT SUM(ce.valorpg) AS contaspagas
                 FROM viagem_encomenda ve
                 INNER JOIN viagem v ON v.idviagem = ve.idviagem
                 INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
                 INNER JOIN contas_encomendas ce ON ce.idencomenda = ve.idencomenda
                 WHERE v.idviagem = ? AND ce.idsituacao = 2 AND ve.idcontrato = ?
                 ORDER BY ve.idencomenda";

$stmt_somapago = $con->prepare($sql_somapago);
$stmt_somapago->bind_param("ii", $idviagem, $idcontrato);
$stmt_somapago->execute();
$dados_soma_pago = $stmt_somapago->get_result();

$linhapago = $dados_soma_pago->fetch_assoc();
$valorpago = $linhapago['contaspagas'];
$valorpago_format = number_format($valorpago, 2, ',', '.');

// Soma do valor total das encomendas
$sql_somageral = "SELECT SUM(ve.valor) AS valor_total
                  FROM viagem_encomenda ve
                  INNER JOIN viagem v ON v.idviagem = ve.idviagem
                  INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
                  WHERE v.idviagem = ? AND sc.idsituacao <> 3 AND ve.idcontrato = ?";

$stmt_somageral = $con->prepare($sql_somageral);
$stmt_somageral->bind_param("ii", $idviagem, $idcontrato);
$stmt_somageral->execute();
$dados_soma = $stmt_somageral->get_result();

$linhapagogeral = $dados_soma->fetch_assoc();
$valorgeral = $linhapagogeral['valor_total'];
$valorapagar_format = number_format($valorgeral, 2, ',', '.');

// Valor de parcelas pendentes
$valorpendente = $valorgeral - $valorpago;
$valorpendente_format = number_format($valorpendente, 2, ',', '.');

// Consulta para o nível de usuário
$sql_usuarios = "SELECT nivel FROM usuario WHERE id_usuario = ?";
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->bind_param("i", $usuarioid);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->get_result();

$linhausuario = $usuarios->fetch_assoc();

// Consulta para rota e viagem
$sql_dados_rota = "SELECT v.idviagem, v.dataviagem, v.horaviagem, c1.nome AS corigem, e1.uf AS uforigem, c2.nome AS cdestino, e2.uf AS ufdestino
                   FROM viagem v
                   INNER JOIN rota r ON r.idrota = v.idrota
                   INNER JOIN cidades c1 ON c1.id = r.corigem
                   INNER JOIN cidades c2 ON c2.id = r.cdestino
                   INNER JOIN estados e1 ON e1.id = r.uforigem
                   INNER JOIN estados e2 ON e2.id = r.ufdestino
                   WHERE v.idviagem = ? AND v.idcontrato = ?";

$stmt_dados_rota = $con->prepare($sql_dados_rota);
$stmt_dados_rota->bind_param("ii", $idviagem, $idcontrato);
$stmt_dados_rota->execute();
$dados_rota = $stmt_dados_rota->get_result();

$linha_rota = $dados_rota->fetch_assoc();
$total_rota = $dados_rota->num_rows;

// Fechar as consultas
$stmt_viagem_encomenda->close();
$stmt_somapago->close();
$stmt_somageral->close();
$stmt_usuarios->close();
$stmt_dados_rota->close();

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
if(isset($_SESSION['msg'])){
echo $_SESSION['msg'];
unset($_SESSION['msg']);
}
if($_POST){
      //Campos tabela passagem
      $idviagem = mysqli_real_escape_string($con,$_POST['idviagem']);
      $etiqueta = mysqli_real_escape_string($con,$_POST['etiqueta']);
      $descricao = mysqli_real_escape_string($con,$_POST['descricao']);
      $remetente = mysqli_real_escape_string($con,$_POST['remetente']);
      $destinatario = mysqli_real_escape_string($con,$_POST['destinatario']);
      $localhorigem = mysqli_real_escape_string($con,$_POST['localhorigem']);
      $localdestino = mysqli_real_escape_string($con,$_POST['localdestino']);
      $telremetente = mysqli_real_escape_string($con,$_POST['telremetente']);
      $teldestinatario = mysqli_real_escape_string($con,$_POST['teldestinatario']);
      $docremetente = mysqli_real_escape_string($con,$_POST['docremetente']);
      $docdestinatario = mysqli_real_escape_string($con,$_POST['docdestinatario']);
      $idsituacao = mysqli_real_escape_string($con,$_POST['idsituacao']);
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      $tipo = mysqli_real_escape_string($con,$_POST['tipo']);
      $qtd = mysqli_real_escape_string($con,$_POST['qtd']);

      $valdeclarado = mysqli_real_escape_string($con,$_POST['valdeclarado']);
      $valord_ponto = str_replace(".","",$valdeclarado);  
      $valordformatado = str_replace(",",".",$valord_ponto);

      $quem_recebeu = $_SESSION['UsuarioNome'];
      $atendente = $_SESSION['UsuarioNome'];
      //Campos formatados
      $valor = mysqli_real_escape_string($con,$_POST['valor']);
      $valor_ponto = str_replace(".","",$valor);  
      $valorformatado = str_replace(",",".",$valor_ponto);

      @$formapg = mysqli_real_escape_string($con,$_POST['formapg']);


    //Insere na tabela pagamentos
    $cad_encomenda = mysqli_query($con,"INSERT INTO viagem_encomenda (idviagem,etiqueta,descricao,remetente,destinatario,localhorigem,localdestino, telremetente, teldestinatario, docremetente, docdestinatario, obs, valor, idsituacao, atendente, tipo, qtd, valdeclarado, idcontrato) values('$idviagem','$etiqueta','$descricao','$remetente','$destinatario','$localhorigem','$localdestino','$telremetente', '$teldestinatario', '$docremetente', '$docdestinatario', '$obs', '$valorformatado', '$idsituacao', '$atendente', '$tipo', '$qtd', '$valordformatado', '$idcontrato') ") or die(mysqli_error($con));       

// --------- selecionar ultimo idencomenda ---------------------// 
$query6 = sprintf("select max(idencomenda) as idencomenda from viagem_encomenda"); 

// executa a query 
$dados6 = mysqli_query($con,$query6) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha6 = mysqli_fetch_array($dados6);

$idencomendaprox = $linha6['idencomenda']; 

//verifica a situação do pagamento
if($idsituacao == 2){
//------------Insere na tabela contas_encomendas
$cad_contas_encomenda = mysqli_query($con,"INSERT INTO contas_encomendas (idencomenda, valorpg, formapg, idsituacao, quem_recebeu, datapg, obs, idcontrato) values('$idencomendaprox','$valor','Dinheiro','$idsituacao','$quem_recebeu','$date','$obs','$idcontrato') ") or die(mysqli_error($con)); 
         
}
else  {
         if(mysqli_affected_rows($con) == 1){ 
//criaLog($con,"Encomenda Cadastrada", "Encomenda numero $idencomendaprox", $idcontrato);
            ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                  echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=encomenda_ver.php?idviagem=$idviagem'>";    
            }
          else{ ?>
                <div class="alert alert-danger alert-rounded">
                    <i class="ti-user"></i> Erro. Ocorreu algum problema no Cadastro!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
        <?php }   
        }
                }        
?>
                <div class="row">
                    <div class="col-12">                    
                        <div class="card">
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="encomenda_ver.php?idviagem=<?php echo $idviagem ?>"><i class="mdi mdi-package-variant"></i> Encomendas</a>
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
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-info"></i></h2>
                                    <h2 class="">R$ <?php echo $valorapagar_format ?></h2>
                                    <div class="font-bold text-info"><i class="fa fa-check"></i> <small>Valor a Pagar</small></div></div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>

                                    <div class="row">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-7">
                                        <table border="1">
                                            <tr>
                                                <td><b>ORIGEM: </b> <i> <?php echo $linha_rota['corigem'] ?> </i> - <?php echo $linha_rota['uforigem'] ?> <b>DESTINO: </b> <i><?php echo $linha_rota['cdestino'] ?></i> - <?php echo $linha_rota['ufdestino']?> <b>DATA PARTIDA: </b> <i> <?php echo date('d/m/Y', strtotime($linha_rota['dataviagem'])); ?> - <?php echo $linha_rota['horaviagem'] ?> </i>
                                                </td>
                                            </tr>
                                        </table>  
                                        </div>
                                 </div>

                                <div class="card-body">
                                    <div class="form-group m-b-40 col-md-3">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrarencomenda">+ Nova Encomenda</button>
                                    </div>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>COD</th>            
                                                    <th>REMETENTE/TEL</th>
                                                    <th>DESTINATARIO/TEL</th>
                                                    <th>ORIGEM</th>
                                                    <th>DESTINO</th>
                                                    <th>VALOR</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total2 > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                                $valor = $linha2['valor'];
                                                $valor_formatadoo = number_format($valor,2, ',', '.');
                                                $valorliquido = $linha2['valor'] -$linha2['valorpg'];
                                                $valor_liq_formatado = number_format($valorliquido,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha2['etiqueta']?></td>
                                                    <td><b><?php echo $linha2['remetente'] ?> </b> - <i><?php echo $linha2['telremetente'] ?></i>
                                                    </td>
                                                    <td><b><?php echo $linha2['destinatario'] ?> </b> - <b><i><?php echo $linha2['teldestinatario'] ?></i>
                                                    </td>
                                                    <td><?php echo $linha2['localhorigem']?></td>
                                                    <td><?php echo $linha2['localdestino']?></td>
                                                    <td><?php echo $valor_formatadoo ?></td>
                                                   <?php if($valorliquido>0) {?>
                                                    <td width="120" align="center">
                                                    <a href="" class="btn btn-success" role="button" data-toggle="modal" data-target="#financeiro_pagar<?php echo $linha2['idencomenda']?>">Pagar</a> 
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#encomenda_ver<?php echo $linha2['idencomenda']?>"><i class="fa fa-search"></i></a> 
                                                    <?php if($linhausuario["nivel"]>=9){ ?> 
                                                    <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#encomenda_cancelar<?php echo $linha2['idencomenda']?>"><i class="fa fa-trash"></i></a> <?php } ?>
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#encomenda_editar<?php echo $linha2['idencomenda']?>"><i class="fa fa-edit"></i></a> 
                                                    </td>
                                                    <?php } else { ?>
                                                    <td width="120" align="center">
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#encomenda_ver<?php echo $linha2['idencomenda']?>"><i class="fa fa-search"></i></a> 
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#encomenda_editar<?php echo $linha2['idencomenda']?>"><i class="fa fa-edit"></i></a> 
                                                    <a href="pdf_encomenda_ind.php?idencomenda=<?php echo $linha2['idencomenda']?>&idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-success btn-circle" role="button"><i class="mdi mdi-receipt"></i> </a>
                                                    <?php if($linhausuario["nivel"]>=9){ ?> 
                                                    <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#encomenda_cancelar<?php echo $linha2['idencomenda']?>"><i class="fa fa-trash"></i></a>
                                                    </td> <?php }} ?>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha2 = mysqli_fetch_assoc($dados2)); 
                                                    // fim do if 
                                                            } 
                                            ?> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrarencomenda" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrarviagem">Cadastrar Encomenda</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="descricao">Etiqueta:</label>
                                                        <input type="text" class="form-control" id="etiqueta" name="etiqueta">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="descricao">Descrição:</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descreva a encomenda">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="descricao">Qtde:</label>
                                                        <input type="text" class="form-control" id="qtd" name="qtd" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idsituacao">Tipo</label>
                                                        <select class="form-control" name="tipo" id="tipo" required>
                                                            <option value=""></option>
                                                            <option value="Caixa">Caixa</option>
                                                            <option value="Sacola">Sacola</option>
                                                            <option value="Peça">Peça</option>
                                                            <option value="Diversos">Diversos</option>
                                                      </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Val Declar.</label>
                                                        <input type="text" class="form-control" id="valdeclarado" name="valdeclarado" onKeyPress="return(MascaraMoeda(this,'.',',',event))" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="remetente">Remetente:</label>
                                                        <input type="text" class="form-control" id="remetente" name="remetente" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="docremetente">DOC Remetente</label>
                                                        <input type="text" class="form-control" id="docremetente" name="docremetente">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="telremetente">Tel Remetente</label>
                                                        <input type="text" class="form-control" id="telremetente" name="telremetente" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="destinatario">Destinatário</label>
                                                        <input type="text" class="form-control" id="destinatario" name="destinatario" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="docdestinatario">DOC Destinatário</label>
                                                    <input type="text" class="form-control" id="docdestinatario" name="docdestinatario">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="teldestinatario">Tel Destinatário</label>
                                                        <input type="text" class="form-control" id="teldestinatario" name="teldestinatario">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="localhorigem">Local Origem</label>
                                                        <input type="text" class="form-control" id="localhorigem" name="localhorigem" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="localhorigem">Local Destino</label>
                                                        <input type="text" class="form-control" id="localdestino" name="localdestino" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Valor</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" >
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idsituacao">Foi Pago?</label>
                                                        <select class="form-control" name="idsituacao" id="idsituacao" required>
                                                            <option value=""></option>
                                                            <option value="2">Sim</option>
                                                            <option value="1">Não</option>
                                                      </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $idviagem ?>">
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

                    <?php foreach($dados2 as $aqui){ 
                        $idencomendaprox2 = $aqui['idencomenda'];
                        $valor2 = $aqui['valor'];
                        $valor_formatadoo2 = number_format($valor2,2, ',', '.');
                        ?>
                                <div class="modal fade bs-example-modal" tabindex="-1" id="financeiro_pagar<?php echo $aqui['idencomenda']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="financeiro_pagar">Pagar Parcela</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="viagem_encomenda_pg.php" method="post">
                                                    <div class="form-group">
                                                        <label for="valor" class="control-label">Introduza o Valor Pago</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" value="<?php echo $valor_formatadoo2 ?>" readonly>
                                                        <label for="obs" class="control-label">Observação</label>
                                                        <input type="text" class="form-control" id="obs" name="obs">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui['idviagem'] ?>">
                                                        <input type="hidden" class="form-control" id="idencomenda" name="idencomenda" value="<?php echo $idencomendaprox2 ?>">
                                                    </div>
                                                    <button type="submit" name="cancelar" id="cancelar" class="btn btn-info">Confirmar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    <?php }?>

                    <?php foreach($dados2 as $aqui3){ ?>
                                <div class="modal fade bs-example-modal" tabindex="-1" id="encomenda_cancelar<?php echo $aqui3['idencomenda']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cancelar_encomenda">Cancelar Encomenda</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="encomenda_cancelar.php" method="post">
                                                    <div class="form-group">
                                                        <label for="mcancelamento" class="control-label">Motivo</label>
                                                        <textarea class="form-control" rows="3" id="mcancelamento" name="mcancelamento" required></textarea>
                                                        
                                                        <input type="hidden" class="form-control" id="cancelado_por" name="cancelado_por" value="<?php echo $_SESSION['UsuarioNome']?>" readonly>
                                                        <input type="hidden" class="form-control" id="idencomenda" name="idencomenda" value="<?php echo $aqui3['idencomenda'] ?>">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui3['idviagem'] ?>">
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

                <?php foreach($dados2 as $aqui4){ 
      $valor_encomenda = $aqui4['valor'];
      $valore_ponto = str_replace(".",",",$valor_encomenda);  
      $valoreformatado = str_replace(",",".",$valore_ponto);

      $valor_declarad = $aqui4['valdeclarado'];
      $valordecla_ponto = str_replace(".",",",$valor_declarad);  
      $valordecformatado = str_replace(",",".",$valordecla_ponto);?> 
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="encomenda_editar<?php echo $aqui4['idencomenda']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="encomenda_editar">Editar Encomenda</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="encomenda_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="descricao">Etiqueta:</label>
                                                        <input type="text" class="form-control" id="etiqueta" name="etiqueta" value="<?php echo $aqui4['etiqueta'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="descricao">Descrição:</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $aqui4['descricao'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="descricao">Qtde:</label>
                                                        <input type="text" class="form-control" id="qtd" name="qtd" value="<?php echo $aqui4['qtd'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="tipo">Tipo</label>
                                                        <select class="form-control" name="tipo" id="tipo" required>
                                                <option value="<?php echo $aqui4['tipo'] ?>" ><?php echo $aqui4['tipo'] ?></option>
                                                            <option value="Caixa">Caixa</option>
                                                            <option value="Sacola">Sacola</option>
                                                            <option value="Diversos">Diversos</option>
                                                      </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Val Declar.</label>
                                                        <input type="text" class="form-control" id="valdeclarado" name="valdeclarado" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valordecla_ponto ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="remetente">Remetente:</label>
                                                        <input type="text" class="form-control" id="remetente" name="remetente" value="<?php echo $aqui4['remetente'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="docremetente">DOC Remetente</label>
                                                        <input type="text" class="form-control" id="docremetente" name="docremetente" value="<?php echo $aqui4['docremetente'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="telremetente">Tel Remetente</label>
                                                        <input type="text" class="form-control" id="telremetente" name="telremetente" value="<?php echo $aqui4['telremetente'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="destinatario">Destinatário</label>
                                                        <input type="text" class="form-control" id="destinatario" name="destinatario" value="<?php echo $aqui4['destinatario'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="docdestinatario">DOC Destinatário</label>
                                                    <input type="text" class="form-control" id="docdestinatario" name="docdestinatario" value="<?php echo $aqui4['docdestinatario'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="teldestinatario">Tel Destinatário</label>
                                                        <input type="text" class="form-control" id="teldestinatario" name="teldestinatario" value="<?php echo $aqui4['teldestinatario'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="localhorigem">Local Origem</label>
                                                        <input type="text" class="form-control" id="localhorigem" name="localhorigem" value="<?php echo $aqui4['localhorigem'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="localhorigem">Local Destino</label>
                                                        <input type="text" class="form-control" id="localdestino" name="localdestino" value="<?php echo $aqui4['localdestino'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Valor</label>
                                                     <?php if($aqui4['idsituacao']<>2){ ?>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valore_ponto ?>">
                                                    <?php } else { ?>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valore_ponto ?>" readonly>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idsituacao">Pagamento</label>
                                                        <select class="form-control" name="idsituacao" id="idsituacao" readonly>
                                                        <option value="<?php echo $aqui4['idsituacao'] ?>" ><?php echo $aqui4['situacao'] ?></option>
                                                      </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $aqui4['obs'] ?>">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui4['idviagem'] ?>">
                                                        <input type="hidden" class="form-control" id="idencomenda" name="idencomenda" value="<?php echo $aqui4['idencomenda'] ?>">
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
 <?php foreach($dados2 as $aqui5){ 
      $valor_encomenda = $aqui5['valor'];
      $valore_ponto = str_replace(".",",",$valor_encomenda);  
      $valoreformatado = str_replace(",",".",$valore_ponto);?> 
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="encomenda_ver<?php echo $aqui5['idencomenda']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="encomenda_ver">Ver Encomenda</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="#" method="post">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="descricao">Etiqueta:</label>
                                                        <input type="text" class="form-control" id="etiqueta" name="etiqueta" value="<?php echo $aqui5['etiqueta'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="descricao">Descrição:</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $aqui5['descricao'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="descricao">Qtde:</label>
                                                        <input type="text" class="form-control" id="qtd" name="qtd" value="<?php echo $aqui4['qtd'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="tipo">Tipo</label>
                                                        <select class="form-control" name="tipo" id="tipo" readonly> 
                                                <option value="<?php echo $aqui4['tipo'] ?>" ><?php echo $aqui4['tipo'] ?></option>
                                                      </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Val Declar.</label>
                                                        <input type="text" class="form-control" id="valdeclarado" name="valdeclarado" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valordecla_ponto ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="remetente">Remetente:</label>
                                                        <input type="text" class="form-control" id="remetente" name="remetente" value="<?php echo $aqui5['remetente'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="docremetente">DOC Remetente</label>
                                                        <input type="text" class="form-control" id="docremetente" name="docremetente" value="<?php echo $aqui5['docremetente'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="telremetente">Tel Remetente</label>
                                                        <input type="text" class="form-control" id="telremetente" name="telremetente" value="<?php echo $aqui5['telremetente'] ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="destinatario">Destinatário</label>
                                                        <input type="text" class="form-control" id="destinatario" name="destinatario" value="<?php echo $aqui5['destinatario'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="docdestinatario">DOC Destinatário</label>
                                                    <input type="text" class="form-control" id="docdestinatario" name="docdestinatario" value="<?php echo $aqui5['docdestinatario'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="teldestinatario">Tel Destinatário</label>
                                                        <input type="text" class="form-control" id="teldestinatario" name="teldestinatario" value="<?php echo $aqui5['teldestinatario'] ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="localhorigem">Local Origem</label>
                                                        <input type="text" class="form-control" id="localhorigem" name="localhorigem" value="<?php echo $aqui5['localhorigem'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="localhorigem">Local Destino</label>
                                                        <input type="text" class="form-control" id="localdestino" name="localdestino" value="<?php echo $aqui5['localdestino'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Valor</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valore_ponto ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idsituacao">Pagamento</label>
                                                        <select class="form-control" name="idsituacao" id="idsituacao" readonly>
                                                        <option value="<?php echo $aqui5['idsituacao'] ?>" ><?php echo $aqui5['situacao'] ?></option>
                                                      </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $aqui5['obs'] ?>" readonly>
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui5['idviagem'] ?>">
                                                        <input type="hidden" class="form-control" id="idencomenda" name="idencomenda" value="<?php echo $aqui5['idencomenda'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                         <?php  }  ?> 
    </div>

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

<script>
function formatar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)
  
  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }
  
}
</script>
</body>

</html>
