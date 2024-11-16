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

//$query = sprintf("select cr.idparcelas, cr.idcliente,t.idtratamento, c.nome as nomecliente, pr.descricao, cr.valor, crm.qtdparcelas, cr.vencimento, cr.situacao 
//from contas_receber cr inner join clientes c on cr.idcliente = c.idcliente 
//inner join tratamento t on t.idcliente = cr.idcliente 
//inner join contas_receb_movi crm on crm.idcliente = c.idcliente and crm.idtratamento = t.idtratamento and crm.idmovimento = cr.idmovimento
//inner join procedimento pr on pr.idprocedimento = t.idprocedimento
//where cr.idcliente = $idcliente"); 
$query = sprintf("select cr.idparcelas, crm.idmovimento, crm.idcliente,p.idpassagem, c.nome as nomecliente, p.desembarque, cr.valor, cr.valor, cr.parcela, p.embarque, c.rg, cr.quem_recebeu, cr.data_pg, fp.tipo, cr.obs, cr.idsituacao, sc.situacao
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
inner join passagem p on p.idpassagem = crm.idpassagem 
inner join contas_receber cr on cr.idmovimento = crm.idmovimento 
inner join formapg fp on fp.idformapg = cr.idformapg
inner join situacao_caixa sc on sc.idsituacao = cr.idsituacao"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);

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
                        <li class="breadcrumb-item">Finanças</li>
                        <li class="breadcrumb-item active">Receber</li>
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
                                        <a class="nav-link" href="financeiro_receber.php"><i class="mdi mdi-cash-multiple"></i> Contas a Receber</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link active" href="financeiro_receber_parcelas.php"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                    </ul>

                            <div class="card-body wizard-content">
                <div class="row">
                                 <div class="card-body wizard-content">
                                    <h4 class="card-title">Fluxo</h4>
                                    <h6 class="card-subtitle">Lista dos pagamentos</h6>
<input type="button" class="btn btn-info" onclick="printDiv('printableArea')" value="Imprimir" />
                        <div id="printableArea">
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Desembarque</th>
                                                    <th>Valor</th>
                                                    <th>Recebimento</th>
                                                    <th>Forma PG</th>
                                                    <th>Obs</th>
                                                    <th>Situação</th>
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
                                                    <td><?php echo $linha['idmovimento']?></td>
                                                    <td><?php echo $linha['nomecliente']?></td>
                                                    <td align="center">R$ <?php echo $valor_formatado?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['data_pg'])); ?></td>
                                                    <td><?php echo $linha['tipo']?></td>
                                                    <td><?php echo $linha['obs']?></td>

                                                    <?php if($linha['idsituacao']==1) {?>
                                                    <td width="50" align="center"><span class="label label-warning pull-center"><?php echo $linha['situacao']?></span></td> <?php }
                                                    else if($linha['idsituacao']==2) {?>
                                                    <td width="50" align="center"><span class="label label-success pull-center"><?php echo $linha['situacao']?></span></td> 
                                                  <?php }
                                                    else{?>
                                                    <td width="50" align="center"><span class="label label-danger pull-center"><?php echo $linha['situacao']?></span></td> 
                                                    <?php }?>
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
<script language="javascript"> 
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
</body>

</html>
