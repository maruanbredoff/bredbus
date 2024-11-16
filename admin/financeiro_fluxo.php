<!DOCTYPE html>
<html lang="en">

<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d');
$mes = date('m');
$ano = date('Y');
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
?>

<body class="fix-header card-no-border">
<?php
include "../verificanivel.php";
include "../config.php"; 

?>
    <div id="main-wrapper">
        <div class="page-wrapper">
<br>
            <div class="container-fluid"> 
<?php
$idcontrato = $_SESSION['ContratoID'];
// Inicialização das variáveis para Data Inicial e Data Final
$data_inicial = date('Y-m-01');  // Data de 7 dias atrás
$data_final = date('Y-m-d');  // Data de hoje
// Convertendo para o formato em português
$data_inicial_pt = date('d/m/Y', strtotime($data_inicial));
$data_final_pt = date('d/m/Y', strtotime($data_final));

// Se o formulário for enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura as datas enviadas pelo formulário
    $data_inicial = $_POST['data_inicial'];
    $data_final = $_POST['data_final'];
    $data_inicial_pt = date('d/m/Y', strtotime($data_inicial));
    $data_final_pt = date('d/m/Y', strtotime($data_final));
    // Filtros com data inicial e final
    $where_clause = "WHERE crm.data_movimento BETWEEN ? AND ? AND pa.status_passagem <> 4 AND crm.idsituacao <> 3 AND c.idcontrato = $idcontrato";
    $where_clause_pagamento = "WHERE cpm.data_movimento BETWEEN ? AND ? AND cpm.idsituacao <> 3 AND cpm.idcontrato = $idcontrato";
    $where_clause__recebpago = "WHERE crm.data_movimento BETWEEN ? AND ? AND crm.idsituacao = 2 AND pa.status_passagem <> 4 AND c.idcontrato = $idcontrato" ;
    $where_clause_despesapago = "WHERE cpm.data_movimento BETWEEN ? AND ? AND cpm.idsituacao = 2 AND cpm.idcontrato = $idcontrato" ;
    $where_clause_valtotal = "WHERE crm.data_movimento BETWEEN ? AND ? AND crm.idsituacao <> 3 AND p.status_passagem <> 4 AND c.idcontrato = $idcontrato" ;
} else {
    // Se não houver POST, exibe os registros do mes atual
    $where_clause = "WHERE crm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND pa.status_passagem <> 4 AND crm.idsituacao <> 3 AND c.idcontrato = $idcontrato";
    $where_clause_pagamento = "WHERE cpm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND cpm.idsituacao <> 3 AND cpm.idcontrato = $idcontrato";
    $where_clause__recebpago = "WHERE crm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND crm.idsituacao = 2 AND pa.status_passagem <> 4 AND c.idcontrato = $idcontrato" ;
    $where_clause_despesapago = "WHERE cpm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND cpm.idsituacao = 2 AND cpm.idcontrato = $idcontrato" ;
    $where_clause_valtotal = "WHERE crm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND crm.idsituacao <> 3 AND p.status_passagem <> 4 AND c.idcontrato = $idcontrato" ;
}

// Consulta principal
$query = "SELECT crm.idmovimento, crm.idcliente, pa.idpassagem, pa.embarque, pa.desembarque, c.nome as nomecliente, 
                 crm.valor_total, crm.qtdparcelas, fr.tipo, crm.data_movimento, pa.status_passagem, SUM(cr.valor) as contaspagas, 
                 fr.tipo, crm.desconto as desconto, c.nome, v.dataviagem, crm.entrada
          FROM contas_receb_movi crm 
          INNER JOIN clientes c ON crm.idcliente = c.idcliente 
          LEFT JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
          INNER JOIN passagem pa ON pa.idpassagem = crm.idpassagem 
          INNER JOIN viagem v ON v.idviagem = pa.idviagem
          INNER JOIN formapg fr ON fr.idformapg = crm.idformapg
          $where_clause
          GROUP BY crm.idmovimento, crm.idcliente, pa.idpassagem, pa.embarque, pa.desembarque, c.nome, crm.valor_total, 
                   crm.qtdparcelas, fr.tipo, pa.status_passagem, crm.data_movimento, fr.tipo, crm.desconto, c.nome, v.dataviagem";
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
$valorliquido = $linha['valor_total'] - $linha['entrada'];

// Lista de pagamentos
$query_pagamentos = "SELECT cpm.idmovipagar, cpm.data_movimento, cpm.valor, cpm.tipopg, cpm.idformapg, cpm.qtdparcelas, 
                            fp.tipo, cpm.tipopg, cpm.descricao, cpm.data_pg, sc.situacao, tp.descricao as tipo_despesa
                     FROM contas_pagar_movi cpm 
                     INNER JOIN formapg fp ON fp.idformapg = cpm.idformapg
                     INNER JOIN situacao_caixa sc ON sc.idsituacao = cpm.idsituacao
                     INNER JOIN tipopg tp ON tp.idtipopg = cpm.tipopg
                     $where_clause_pagamento
                     GROUP BY cpm.idmovipagar, cpm.data_movimento, cpm.valor, cpm.tipopg, cpm.idformapg, 
                              cpm.qtdparcelas, fp.tipo, cpm.tipopg, cpm.descricao";
$stmt_pagamentos = $con->prepare($query_pagamentos);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt_pagamentos->bind_param("ss", $data_inicial, $data_final);
}
$stmt_pagamentos->execute();
$dados_pagamentos = $stmt_pagamentos->get_result();
$linha_pagamentos = $dados_pagamentos->fetch_assoc();
$totalpg = $dados_pagamentos->num_rows;

// Soma o valor de recebimentos pagos
$somarecebpago_query = "SELECT SUM(cr.valor) as contaspagas
                        FROM contas_receb_movi crm 
                        INNER JOIN clientes c ON crm.idcliente = c.idcliente 
                        LEFT JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
                        INNER JOIN passagem pa ON pa.idpassagem = crm.idpassagem 
                        INNER JOIN formapg fr ON fr.idformapg = cr.idformapg
                        $where_clause__recebpago";

$stmt_somarecebpago = $con->prepare($somarecebpago_query);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt_somarecebpago->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somarecebpago->execute();
$dados_receb_pago = $stmt_somarecebpago->get_result();
$linharecebpago = $dados_receb_pago->fetch_assoc();
$valorrecebpago = round($linharecebpago['contaspagas'] * 100 / 100);
$valorrecebpago_format = number_format($valorrecebpago, 2, ',', '.');

// Soma o valor de pagamentos pagos
$somapago_query = "SELECT SUM(cpm.valor) as total_pago 
                   FROM contas_pagar_movi cpm 
                   INNER JOIN situacao_caixa sc ON sc.idsituacao = cpm.idsituacao
                   INNER JOIN formapg fp ON fp.idformapg = cpm.idformapg
                   $where_clause_despesapago";
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
$somageral_query = "SELECT SUM(crm.valor_total) as total_geral 
                    FROM contas_receb_movi crm 
                    INNER JOIN clientes c ON crm.idcliente = c.idcliente 
                    INNER JOIN passagem p ON p.idpassagem = crm.idpassagem
                    $where_clause_valtotal";
$stmt_somageral = $con->prepare($somageral_query);
// Verifica se foi um POST com datas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vincula as variáveis de data
    $stmt_somageral->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somageral->execute();
$dados_soma = $stmt_somageral->get_result();
$linhapagogeral = $dados_soma->fetch_assoc();
$valorgeral = $linhapagogeral['total_geral'];
$valorgeral_format = number_format($valorgeral, 2, ',', '.');

// Residual do caixa
$residual = round(($valorrecebpago - $valorpago) * 100 / 100);
$residual_format = number_format($residual, 2, ',', '.');

?>
                <div class="row">
                    <div class="col-12">
                <div class="alert alert-warning">
                    <center><h4><i class="fa fa-tasks"></i> Fluxo Caixa</h4></center>
                </div>
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
                        </div>
                    </div>
                </div>
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-success"></i></h2>
                                    <h2 class="">R$ <?php echo $valorrecebpago_format ?></h2>
                                    <div class="font-bold text-warning"><i class="fa fa-exclamation"></i> <small>Receitas Pagas</small></div>
                                </div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-briefcase-check text-warning"></i></h2>
                                    <h2 class="">R$ <?php echo $valorpago_format?></h2>
                                    <div class="font-bold text-success"><i class="fa fa-check"></i> <small>Despesas Pagas</small></div></div>
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
                                    <h2 class="">R$ <?php echo $residual_format ?></h2>
                                    <div class="font-bold text-navy"><i class="fa fa-check"></i> <small>Residual</small></div></div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">

                                    <h4 class="card-title">Despesas<br/></h4>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($totalpg > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                                $valor_pag = round($linha_pagamentos['valor']*100/100);
                                                $valor_pag_formatado= number_format($valor_pag,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha_pagamentos['idmovipagar']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha_pagamentos['data_movimento'])); ?></td>
                                                    <td><?php echo $linha_pagamentos['tipo_despesa']?></td>
                                                    <td><?php echo $linha_pagamentos['descricao']?></td>
                                                    <td width="110">R$ <?php echo $valor_pag_formatado?></td>
                                                    <td><?php echo $linha_pagamentos['tipo']?></td>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha_pagamentos = mysqli_fetch_assoc($dados_pagamentos)); 
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
                </div><hr>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <h4 class="card-title">Receitas<br/></h4>
                                        <table id="myTable2" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Cliente</th>
                                                    <th>Data Viagem</th>
                                                    <th>Destino</th>
                                                    <th>Valor PG</th>
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
                                                $desconto = $linha['desconto'];
                                                $valorliquido = $linha['contaspagas'];
                                                $valortotal = $linha['valor_total'];
                                                $valor_formatadoo = number_format($valortotal,2, ',', '.');
                                                $valor_desconto = number_format($desconto,2, ',', '.');
                                                $valor_liq_formatado = number_format($valorliquido,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idpassagem']?></td>
                                                    <td><?php echo $linha['nomecliente']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['dataviagem'])); ?></td>
                                                    <td><?php echo $linha['desembarque']?></td>
                                                    <td width="120">R$ <?php echo $valor_liq_formatado?></td>
                                                    <td width="180"><?php echo $linha['tipo']?></td>
                                                    <td width="110">
                                                    <a href="cliente_financeiro_parcelas_ind.php?idmovimento=<?php echo $linha['idmovimento']?>&idcliente=<?php echo $linha['idcliente']?>"  class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i> </a>
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
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
               
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                        </div>
            </div>
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
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
        
        $('#myTable2').DataTable();
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
</body>

</html>