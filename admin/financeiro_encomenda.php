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
include "../verificanivel.php"; 
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];
// Inicialização das variáveis para Data Inicial e Data Final
$data_inicial = date('Y-m-d', strtotime('-7 days'));  // Data de 7 dias atrás
$data_final = date('Y-m-d');  // Data de hoje
$valorpago_format = '';
$valorgeral_format = '';
$valorapagar_format = '';
$valorpendente_format = '';

// Se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura as datas enviadas pelo formulário
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];

    // Filtros com data inicial e final
    $where_clause = "WHERE v.dataviagem BETWEEN ? AND ? AND sc.idsituacao <> 3 AND v.idcontrato = $idcontrato";
} else {
    // Se não houver POST, exibe os registros dos últimos 7 dias
    $where_clause = "WHERE v.dataviagem >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND sc.idsituacao <> 3 AND v.idcontrato = $idcontrato";
}

// Query principal com prepared statement
$query = "SELECT ve.idencomenda, ve.idviagem, ve.etiqueta, ve.descricao, ve.remetente, ve.destinatario, ve.localhorigem, 
                 ve.localdestino, ve.telremetente, ve.teldestinatario, ve.valor, ve.idsituacao, ve.obs, 
                 ve.docremetente, ve.docdestinatario, sc.situacao, ce.valorpg, ce.id as idmovimento, v.dataviagem
          FROM viagem_encomenda ve
          INNER JOIN viagem v ON v.idviagem = ve.idviagem
          INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
          LEFT JOIN contas_encomendas ce ON ce.idencomenda = ve.idencomenda
          $where_clause
          ORDER BY ve.idencomenda";

// Prepara a query principal
$stmt = $con->prepare($query);

// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt->bind_param("ss", $data_inicial, $data_final);
}

// Executa a query principal
$stmt->execute();
$dados = $stmt->get_result();

// Soma o valor das parcelas pagas
$somapago_query = "SELECT SUM(ce.valorpg) AS contaspagas
                   FROM viagem_encomenda ve
                   INNER JOIN viagem v ON v.idviagem = ve.idviagem
                   INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
                   INNER JOIN contas_encomendas ce ON ce.idencomenda = ve.idencomenda
                   $where_clause";
$stmt_pago = $con->prepare($somapago_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt_pago->bind_param("ss", $data_inicial, $data_final);
}

$stmt_pago->execute();
$dados_soma_pago = $stmt_pago->get_result();
$linhapago = $dados_soma_pago->fetch_assoc();   
$valorpago = $linhapago['contaspagas'];
$valorpago_format = number_format($valorpago, 2, ',', '.');

// Soma o valor total
$somageral_query = "SELECT SUM(ve.valor) AS valor_total
                    FROM viagem_encomenda ve
                    INNER JOIN viagem v ON v.idviagem = ve.idviagem
                    INNER JOIN situacao_caixa sc ON sc.idsituacao = ve.idsituacao
                    $where_clause";
$stmt_geral = $con->prepare($somageral_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt_geral->bind_param("ss", $data_inicial, $data_final);
}

$stmt_geral->execute();
$dados_soma = $stmt_geral->get_result();
$linhapagogeral = $dados_soma->fetch_assoc();   
$valorgeral = $linhapagogeral['valor_total'];
$valorgeral_format = number_format($valorgeral, 2, ',', '.');

// Calcula o valor a pagar e o valor pendente
$valorapagar = $valorgeral - @$desconto2;
$valorapagar_format = number_format($valorapagar, 2, ',', '.');
$valorpendente = $valorgeral - $valorpago;
$valorpendente_format = number_format($valorpendente, 2, ',', '.');


// ----------------------- Usuario ----------------------------    
// Consulta de usuário com prepared statement
$usuarios_query = "SELECT nivel FROM usuario WHERE id_usuario = ?";

// Preparação do statement
$stmt_usuario = $con->prepare($usuarios_query);
$stmt_usuario->bind_param('i', $usuarioid); // 'i' indica que o parâmetro é um número inteiro

// Executa o statement
$stmt_usuario->execute();

// Pega o resultado
$dados_usuario = $stmt_usuario->get_result();
$linhausuario = $dados_usuario->fetch_assoc();
 
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
                    <h3 class="text-themecolor">Encomendas Geral</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Encomendas</li>
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
                                               <div class="card-body wizard-content">
                                    <h4>Fluxo</h4>
                                    <h6 class="card-subtitle">Lista dos pagamentos</h6>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>  
                                                    <th>Data</th>          
                                                    <th>Remetente/DOC</th>
                                                    <th>Local Origem</th>
                                                    <th>Local Destino</th>
                                                    <th>Valor</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            // inicia o loop que vai mostrar todos os dados 
                                                while($linha = $dados->fetch_assoc()) {
                                                $valorliquido = $linha['valor'] -$linha['valorpg'];
                                                $valortotal = $linha['valor'];
                                                $valor_formatadoo = number_format($valortotal,2, ',', '.');
                                                @$valor_desconto = number_format($desconto,2, ',', '.');
                                                $valor_liq_formatado = number_format($valorliquido,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td width="50">
                                                    <a href="viagem_encomenda.php?idviagem=<?php echo $linha['idviagem']?>"><?php echo $linha['idencomenda']?></a></td>
                                                    <td width="100"><?php echo date('d/m/Y', strtotime($linha['dataviagem'])); ?></td>
                                                    <td width="200"><?php echo $linha['remetente']?></td>
                                                    <td width="200"><?php echo $linha['localhorigem']?></td>
                                                    <td width="200"><?php echo $linha['localdestino']?></td>
                                                    <td width="115">R$ <?php echo $valor_formatadoo?></td>
                                                   <?php if($valorliquido>0) {?>
                                                    <td width="50" align="center">
                                                    <a href="" class="btn btn-danger" role="button" data-toggle="modal" data-target="#financeiro_pagar<?php echo $linha['idencomenda']?>">Pagar</a> 
                                                    </td>
                                                    <?php } else { ?>
                                                    <td width="50" align="center">
                                                    <a href="viagem_encomenda.php?idviagem=<?php echo $linha['idviagem']?>" class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i></a></td> <?php } ?>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }
                                                    // fim do if 
                                                            
                                            ?> 
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    <?php foreach($dados as $aqui){ 
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
                                                <form action="financeiro_encomenda_pg.php" method="post">
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

                    </div>

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
