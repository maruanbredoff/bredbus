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
include "../funcoes.php";
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];
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
    $where_clause = "WHERE crm.data_movimento BETWEEN ? AND ? AND crm.idsituacao <> 3 AND pa.status_passagem <> 4 AND c.idcontrato = $idcontrato" ;
    $where_clause_pago = "WHERE crm.data_movimento BETWEEN ? AND ? AND crm.idsituacao <> 2 AND pa.status_passagem <> 4 AND c.idcontrato = $idcontrato" ;
} else {
    // Se não houver POST, exibe os registros do mes atual
    $where_clause = "WHERE crm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND crm.idsituacao <> 3 AND pa.status_passagem <> 4 AND c.idcontrato = $idcontrato";
    $where_clause_pago = "WHERE crm.data_movimento BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) AND crm.idsituacao = 2 AND pa.status_passagem <> 4 AND c.idcontrato = $idcontrato";
}

// Primeira consulta principal
$query = "SELECT crm.idmovimento, crm.idcliente, pa.idpassagem, pa.embarque, pa.desembarque, 
                 c.nome, crm.valor_total, crm.qtdparcelas, fr.tipo, crm.data_movimento, 
                 pa.status_passagem, SUM(cr.valor) AS contaspagas, crm.desconto AS desconto
          FROM contas_receb_movi crm
          INNER JOIN clientes c ON crm.idcliente = c.idcliente
          LEFT JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
          INNER JOIN passagem pa ON pa.idpassagem = crm.idpassagem
          INNER JOIN formapg fr ON fr.idformapg = crm.idformapg
          $where_clause
          GROUP BY crm.idmovimento, crm.idcliente, pa.idpassagem, pa.embarque, pa.desembarque, 
                   c.nome, crm.valor_total, crm.qtdparcelas, fr.tipo, pa.status_passagem, crm.data_movimento, crm.desconto";

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

//------------------------------ Soma o valor de parcelas pagas ------------------------
$somapago_query = "SELECT SUM(cr.valor) AS contaspagas
                   FROM contas_receb_movi crm
                   INNER JOIN clientes c ON crm.idcliente = c.idcliente
                   INNER JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
                   INNER JOIN passagem pa ON pa.idpassagem = crm.idpassagem
                   INNER JOIN formapg fr ON fr.idformapg = cr.idformapg
                   $where_clause";

$stmt_somapago = $con->prepare($somapago_query);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt_somapago->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somapago->execute();
$dados_soma_pago = $stmt_somapago->get_result();
$linhapago = $dados_soma_pago->fetch_assoc();
$valorpago = $linhapago['contaspagas'];
$valorpago_format = number_format($valorpago, 2, ',', '.');

//-------------------------------- Soma o valor de desconto --------------------------------
$query_desconto = "SELECT SUM(crm.desconto) AS desconto
                   FROM contas_receb_movi crm
                   INNER JOIN clientes c ON crm.idcliente = c.idcliente
                   LEFT JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
                   INNER JOIN passagem pa ON pa.idpassagem = crm.idpassagem
                   INNER JOIN formapg fr ON fr.idformapg = crm.idformapg
                   $where_clause";

$stmt_desconto = $con->prepare($query_desconto);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt_desconto->bind_param("ss", $data_inicial, $data_final);
}
$stmt_desconto->execute();
$dados_desconto = $stmt_desconto->get_result();
$linha_desconto = $dados_desconto->fetch_assoc();
$desconto2 = $linha_desconto['desconto'];

//------------------------------- Soma o valor total ------------------------------------------
$somageral_query = "SELECT SUM(crm.valor_total) AS valor_total
                    FROM contas_receb_movi crm
                    INNER JOIN clientes c ON crm.idcliente = c.idcliente
                    INNER JOIN passagem pa ON pa.idpassagem = crm.idpassagem
                    LEFT JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento
                    INNER JOIN formapg fr ON fr.idformapg = crm.idformapg
                    $where_clause";

$stmt_somageral = $con->prepare($somageral_query);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt_somageral->bind_param("ss", $data_inicial, $data_final);
}
$stmt_somageral->execute();
$dados_soma = $stmt_somageral->get_result();
$linhapagogeral = $dados_soma->fetch_assoc();

$valorgeral = $linhapagogeral['valor_total'];
$valorgeral_format = number_format($valorgeral, 2, ',', '.');

//------------------------------ Calcula valores a pagar e pendentes -------------------------
$valorapagar = $valorgeral - $desconto2;
$valorapagar_format = number_format($valorapagar, 2, ',', '.');

$valorpendente = $valorgeral - $valorpago - $desconto2;
$valorpendente_format = number_format($valorpendente, 2, ',', '.');
?>


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
                    <h3 class="text-themecolor">Finanças</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Finanças</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
            <div class="container-fluid">            
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <center><h4><i class="fa fa-tasks"></i> Valores a Receber</h4></center>
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
                <div class="card-group">    
                    <div class="card">
                        <div class="card-body">
                                <div class="card-body wizard-content">
                                    <h4>Fluxo</h4>
                                    <h6 class="card-subtitle">Lista dos pagamentos</h6>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Cliente</th>
                                                    <th>Valor</th>
                                                    <th>Desconto</th>
                                                    <th>Restam</th>
                                                    <th>Tipo</th>
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
                                                $valorliquido = $linha['valor_total'] -$linha['contaspagas'] - $linha['desconto'];
                                                $valortotal = $linha['valor_total'];
                                                $valor_formatadoo = number_format($valortotal,2, ',', '.');
                                                $valor_desconto = number_format($desconto,2, ',', '.');
                                                $valor_liq_formatado = number_format($valorliquido,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idpassagem']?></td>
                                                    <td>
<a href="cliente_financeiro.php?idmovimento=<?php echo $linha['idmovimento']?>&idcliente=<?php echo $linha['idcliente']?>"><?php echo $linha['nome']?></a></td>
                                                    <td width="150">R$ <?php echo $valor_formatadoo?></td>
                                                    <td width="115">R$ <?php echo $valor_desconto?></td>
                                                    <td width="115">R$ <?php echo $valor_liq_formatado?></td>
                                                    <td><?php echo $linha['tipo']?></td>
                                                   <?php if($valorliquido>0) {?>
                                                    <td width="50" align="center">
                                                    <a href="" class="btn btn-danger" role="button" data-toggle="modal" data-target="#financeiro_pagar<?php echo $linha['idmovimento']?>">Pagar</a> 
                                                    </td>
                                                    <?php } else { ?>
                                                    <td width="50" align="center">
                                                    <a href="cliente_financeiro_parcelas_ind.php?idmovimento=<?php echo $linha['idmovimento']?>&idcliente=<?php echo $linha['idcliente']?>" class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i></a></td> <?php } ?>
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
                        </div></div>

                    <?php foreach($dados as $aqui){ 
                        $idmovimentoprox = $aqui['idmovimento'] + 1;
      $valor_passagem = $aqui['valor_total'];
      $valorp_ponto = str_replace(".",",",$valor_passagem);  
      $valorpformatado = str_replace(",",".",$valorp_ponto);
                        ?>
                                <div class="modal fade bs-example-modal" tabindex="-1" id="financeiro_pagar<?php echo $aqui['idmovimento']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="financeiro_pagar">Pagar Parcela</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="cliente_financeiro_parcelas_pg2.php" method="post">
                                                    <div class="form-group">
                                                        <label for="valor" class="control-label">Introduza o Valor Pago</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" value="<?php echo $valorpformatado ?>" readonly>
                                                        <label for="idformapg" class="control-label">Forma de Pagamento</label>
                                                    <select class="form-control" name="idformapg" id="idformapg" required onchange="checkpg()">
                                                        <option value=""></option>
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
                                                        <label for="obs" class="control-label">Observação</label>
                                                        <input type="text" class="form-control" id="obs" name="obs">
                                                        <input type="hidden" class="form-control" id="idmovimento" name="idmovimento" value="<?php echo $aqui['idmovimento'] ?>" required>
                                                        <input type="hidden" class="form-control" id="idcliente" name="idcliente" value="<?php echo $aqui['idcliente'] ?>" required>
                                                        <input type="hidden" class="form-control" id="idparcelasprox" name="idparcelasprox" value="<?php echo $idparcelasprox ?>" required>
                                                    </div>
                                                    <button type="submit" name="cancelar" id="cancelar" class="btn btn-danger">Confirmar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    <?php }?>
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
