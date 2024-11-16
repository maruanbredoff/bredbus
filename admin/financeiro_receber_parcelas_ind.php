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
//where cr.idcliente = $idcliente"); 
$idcliente = $_GET['idcliente']; 
$idmovimento = $_GET['idmovimento']; 
$query = sprintf("SELECT cr.idparcelas, fr.idformapg, crm.idmovimento, crm.idcliente,p.idpassagem, c.nome as nomecliente, cr.valor, cr.parcela, fr.tipo
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
inner join passagem p on p.idpassagem = crm.idpassagem 
inner join contas_receber cr on cr.idmovimento = crm.idmovimento 
inner join formapg fr on fr.idformapg = crm.idformapg
where cr.idcliente = $idcliente and crm.idmovimento = $idmovimento and c.idcontrato = $idcontrato"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);

//------------------------------ Soma o valor de parcelas pendentes -----------------------------------
$somapendente = sprintf("select SUM(cr.valor) as total_pendente from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
inner join tratamento t on t.idtratamento = crm.idtratamento 
inner join contas_receber cr on cr.idmovimento = crm.idmovimento
inner join situacao_caixa sc on sc.idsituacao = cr.idsituacao
where cr.idcliente = $idcliente and cr.idsituacao = 1 and c.idcontrato = $idcontrato"); 

// executa a query 
$dados_soma_pendente = mysqli_query($con,$somapendente) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapendente = mysqli_fetch_assoc($dados_soma_pendente);
$valorpendente = $linhapendente['total_pendente'];
$valorpendente_format = number_format($valorpendente,2, ',', '.');
    
//------------------------------Soma o valor de parcelas pagas -----------------------------------------------
$somapago = sprintf("select SUM(cr.valor) as total_pago from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
inner join tratamento t on t.idtratamento = crm.idtratamento 
inner join contas_receber cr on cr.idmovimento = crm.idmovimento
inner join situacao_caixa sc on sc.idsituacao = cr.idsituacao
where cr.idcliente = $idcliente and cr.idsituacao = 2 and c.idcontrato = $idcontrato"); 

// executa a query 
$dados_soma_pago = mysqli_query($con,$somapago) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapago = mysqli_fetch_assoc($dados_soma_pago);   
$valorpago = $linhapago['total_pago'];
$valorpago_format = number_format($valorpago,2, ',', '.');

//------------------------------- Soma o valor de parcelas-------------------------------------------------------
$somageral = sprintf("select SUM(cr.valor) as total_geral from contas_receb_movi crm inner join clientes c on crm.idcliente = c.idcliente inner join tratamento t on t.idtratamento = crm.idtratamento inner join contas_receber cr on cr.idmovimento = crm.idmovimento where cr.idcliente = $idcliente and c.idcontrato = $idcontrato"); 

// executa a query 
$dados_soma= mysqli_query($con,$somageral) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapagogeral = mysqli_fetch_assoc($dados_soma);   
    
$valorgeral = $linhapagogeral['total_geral'];
    
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
                    <h3 class="text-themecolor">Parcelas</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item"><?php echo $linha['nomecliente'] ?></li>
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
                        <div class="card">
                                    <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link" href="financeiro_receber.php"><i class="mdi mdi-cash-multiple"></i> Contas a Receber</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="financeiro_receber_parcelas.php"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                    </ul>

                            <div class="card-body wizard-content">
                <div class="row">
                                 <div class="card-body wizard-content">
                                    <h3 class="card-title">Parcelas de: <?php echo $linha['nomecliente'] ?></h4>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID Parcela</th>
                                                    <th>Passaporte</th>                                  
                                                    <th>Data Passagem</th>
                                                    <th>Destino</th>
                                                    <th>Valor PG</th>
                                                    <th>Forma PG</th>
                                                    <th>Situação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                                $valor = $linha['valorpg'];
                                                $valor_formatado = number_format($valor,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idparcelas']?></td>
                                                    <td><?php echo $linha['passaporte']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['data_passagem'])); ?></td>
                                                    <td><?php echo $linha['destino']?></td>
                                                    <td width="110" align="center">R$ <?php echo $valor_formatado?></td>
                                                    <td><?php echo $linha['tipo']?></td>
                                                    <td width="50" align="center"><span class="label label-success pull-center">PAGO</span></td>
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

    </div>
                <?php foreach($dados as $aqui){ ?>
                                <div class="modal fade" id="concluir_tratamento<?php echo $aqui['idparcelas']?>" tabindex="-1" role="dialog" aria-labelledby="concluir_tratamento">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_procedimento">Concluir Tratamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="cliente_financeiro_parcelas_pg.php?idparcelas=<?php echo $aqui['idparcelas'] ?>&idcliente=<?php echo $aqui['idcliente']?>" class="form-cadastro" method="post">
                                                    <div class="form-group">
                                                        <label for="contadeposito">Conta Deposito</label>
                                                        <input type="text" class="form-control" id="contadeposito" name="contadeposito"> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="depositante">Depositante</label>
                                                        <input type="text" class="form-control" id="depositante" name="depositante"> 
                                                    </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="cadastrar" class="btn btn-success">Pagar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <?php  }  ?>
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
