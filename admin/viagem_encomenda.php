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
$dados2 = mysqli_query($con,"select ve.idencomenda, ve.idviagem, ve.etiqueta, ve.descricao, ve.remetente, ve.destinatario,ve.descricao, ve.localhorigem, ve.localdestino, ve.telremetente, ve.teldestinatario, ve.valor, ve.idsituacao, ve.obs, ve.docremetente, ve.docdestinatario, sc.situacao, ce.valorpg, ve.idencomenda
from viagem_encomenda ve
inner join viagem v on v.idviagem = ve.idviagem
inner join situacao_caixa sc on sc.idsituacao = ve.idsituacao
left join contas_encomendas ce on ce.idencomenda = ve.idencomenda
where v.idviagem = $idviagem and sc.idsituacao <> 3 and ve.idcontrato = $idcontrato
order by ve.idencomenda") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha2 = mysqli_fetch_assoc($dados2); 

// calcula quantos dados retornaram 
$total2 = mysqli_num_rows($dados2);

@$idpassagem = $linha2['idpassagem'];

$valor = $linha2['valor'];
//------------------------------Soma o valor de parcelas pagas -----------------------------------------------
$somapago = sprintf("select sum(ce.valorpg) as contaspagas
from viagem_encomenda ve
inner join viagem v on v.idviagem = ve.idviagem
inner join situacao_caixa sc on sc.idsituacao = ve.idsituacao
inner join contas_encomendas ce on ce.idencomenda = ve.idencomenda
where v.idviagem = $idviagem and ce.idsituacao = 2 and ve.idcontrato = $idcontrato
order by ve.idencomenda  "); 

// executa a query 
$dados_soma_pago = mysqli_query($con,$somapago) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapago = mysqli_fetch_assoc($dados_soma_pago);   
$valorpago = $linhapago['contaspagas'];
$valorpago_format = number_format($valorpago,2, ',', '.');


//------------------------------- soma o valor total ------------------------
$somageral = sprintf("select sum(ve.valor) as valor_total
from viagem_encomenda ve
inner join viagem v on v.idviagem = ve.idviagem
inner join situacao_caixa sc on sc.idsituacao = ve.idsituacao
where v.idviagem = $idviagem and sc.idsituacao <> 3 and ve.idcontrato = $idcontrato"); 

// executa a query 
$dados_soma= mysqli_query($con,$somageral) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapagogeral = mysqli_fetch_assoc($dados_soma);   
    
$valorgeral = $linhapagogeral['valor_total'];

$valorapagar_format = number_format($valorgeral,2, ',', '.');

//------------------------------ Soma o valor de parcelas pendentes -----------------------------------
$valorpendente = $valorgeral - $valorpago;
$valorpendente_format = number_format($valorpendente,2, ',', '.');
//--------------------- Usuario ----------------------------    
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
      $quem_recebeu = $_SESSION['UsuarioNome'];
      $atendente = $_SESSION['UsuarioNome'];
      //Campos formatados
      $valor = mysqli_real_escape_string($con,$_POST['valor']);
      $valor_ponto = str_replace(".","",$valor);  
      $valorformatado = str_replace(",",".",$valor_ponto);

      $formapg = mysqli_real_escape_string($con,$_POST['formapg']);


    //Insere na tabela pagamentos
    $cad_encomenda = mysqli_query($con,"INSERT INTO viagem_encomenda (idviagem,etiqueta,descricao,remetente,destinatario,localhorigem,localdestino, telremetente, teldestinatario, docremetente, docdestinatario, obs, valor, idsituacao, atendente) values('$idviagem','$etiqueta','$descricao','$remetente','$destinatario','$localhorigem','$localdestino','$telremetente', '$teldestinatario', '$docremetente', '$docdestinatario', '$obs', '$valorformatado', '$idsituacao', '$atendente') ") or die(mysqli_error($con));       

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
$cad_contas_encomenda = mysqli_query($con,"INSERT INTO contas_encomendas (idencomenda, valorpg, formapg, idsituacao, quem_recebeu, datapg, obs) values('$idencomendaprox','$valor','Dinheiro','$idsituacao','$quem_recebeu','$date','$obs') ") or die(mysqli_error($con)); 
         
}
else  {
         if(mysqli_affected_rows($con) == 1){ 
criaLog("Encomenda Cadastrada", "Encomenda numero $idencomendaprox");
            ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                  echo "<meta HTTP-EQUIV='refresh' CONTENT='1;URL=viagem_encomenda.php?idviagem=$idviagem'>";    
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
                                        <a class="nav-link" href="passagem.php?idviagem=<?php echo $idviagem ?>"><i class="mdi mdi-hospital"></i>Passagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link active" href="viagem_encomenda.php?idviagem=<?php echo $idviagem ?>"><i class="mdi mdi-package-variant"></i> Encomendas</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="viagem_financeiro.php?idviagem=<?php echo $idviagem ?>"><i class="mdi mdi-cash-multiple"></i>Financeiro</a>
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

                                <div class="card-body">
                                    <div class="form-group m-b-40 col-md-3">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrarencomenda">+ Nova Encomenda</button>
                                        <?php echo @$idencomendaprox; ?>
                                    </div>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>            
                                                    <th>Remetente/DOC</th>
                                                    <th>Destinatário/DOC</th>
                                                    <th>Local Origem</th>
                                                    <th>Local Destino</th>
                                                    <th>Valor</th>
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
                                                    <td><?php echo $linha2['idencomenda']?></td>
                                                    <td><b><?php echo $linha2['remetente'] ?> </b> - <i><?php echo $linha2['docremetente'] ?></i>
                                                    </td>
                                                    <td><b><?php echo $linha2['destinatario'] ?> </b> - <b><i><?php echo $linha2['docdestinatario'] ?></i>
                                                    </td>
                                                    <td><?php echo $linha2['localhorigem']?></td>
                                                    <td><?php echo $linha2['localdestino']?></td>
                                                    <td><?php echo $valor_formatadoo ?></td>
                                                   <?php if($valorliquido>0) {?>
                                                    <td width="120" align="center">
                                                    <a href="" class="btn btn-success" role="button" data-toggle="modal" data-target="#financeiro_pagar<?php echo $linha2['idencomenda']?>">Pagar</a> 
                                                    <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#passagem_cancelar<?php echo $linha2['idencomenda']?>"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                    <?php } else { ?>
                                                    <td width="120" align="center">
                                                    <a href="#" class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i></a>
                                                    <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#encomenda_cancelar<?php echo $linha2['idencomenda']?>"><i class="fa fa-trash"></i></a></td> <?php } ?>
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="nome">Cod/Etiqueta:</label>
                                                        <input type="text" class="form-control" id="etiqueta" name="etiqueta">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                     <label for="descricao">Descrição:</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descreva como é a encomenda">
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
                                                <h4 class="modal-title" id="cancelar_pagamento">Cancelar Pagamento</h4>
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
