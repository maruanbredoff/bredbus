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
$query = sprintf("select crm.idmovimento,crm.idcliente,pa.idpassagem, pa.embarque, pa.desembarque,c.nome as nomecliente, crm.valor_total, crm.qtdparcelas, fr.tipo, crm.data_movimento, pa.status_passagem, sum(cr.valor) as contaspagas, fr.tipo, crm.desconto as desconto, c.nome
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
left join contas_receber cr on cr.idmovimento = crm.idmovimento
inner join passagem pa on pa.idpassagem = crm.idpassagem 
inner join formapg fr on fr.idformapg = crm.idformapg
where pa.status_passagem <> 4 and DATEDIFF(CURDATE(), crm.data_movimento) < 10
group by crm.idmovimento,crm.idcliente,pa.idpassagem, pa.embarque, pa.desembarque,c.nome, crm.valor_total, crm.qtdparcelas, fr.tipo, pa.status_passagem, crm.data_movimento, fr.tipo, crm.desconto
");  

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

$linha = mysqli_fetch_assoc($dados); 
    
$total = mysqli_num_rows($dados);

$idmovimento = $linha['idmovimento'];
    
//------------------------------Soma o valor de parcelas pagas ------------------------
$somapago = sprintf("select sum(cr.valor) as contaspagas
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
left join contas_receber cr on cr.idmovimento = crm.idmovimento
inner join passagem pa on pa.idpassagem = crm.idpassagem 
inner join formapg fr on fr.idformapg = cr.idformapg
where pa.status_passagem <> 4 and cr.idsituacao = 2  "); 

// executa a query 
$dados_soma_pago = mysqli_query($con,$somapago) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapago = mysqli_fetch_assoc($dados_soma_pago);   
$valorpago = $linhapago['contaspagas'];
$valorpago_format = number_format($valorpago,2, ',', '.');

//--------------------------------soma o valor de desconto
$query_desconto = sprintf("select sum(crm.desconto) as desconto 
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
left join contas_receber cr on cr.idmovimento = crm.idmovimento
inner join passagem pa on pa.idpassagem = crm.idpassagem 
inner join formapg fr on fr.idformapg = crm.idformapg
where pa.status_passagem <> 4
");  

// executa a query 
$dados_desconto = mysqli_query($con,$query_desconto) or die(mysqli_error($con)); 

$linha_desconto = mysqli_fetch_assoc($dados_desconto); 

$desconto2 = $linha_desconto['desconto'];

//------------------------------- Soma o valor total------------------------------------------
$somageral = sprintf("select sum(crm.valor_total) as valor_total
from contas_receb_movi crm 
inner join clientes c on crm.idcliente = c.idcliente 
inner join passagem pa on pa.idpassagem = crm.idpassagem 
inner join formapg fr on fr.idformapg = crm.idformapg
where pa.status_passagem <> 4");

// executa a query 
$dados_soma= mysqli_query($con,$somageral) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhapagogeral = mysqli_fetch_assoc($dados_soma);   
    
$valorgeral = $linhapagogeral['valor_total'];
    
$valorgeral_format = number_format($valorgeral,2, ',', '.');

$valorapagar = $valorgeral - $desconto2;
$valorapagar_format = number_format($valorapagar,2, ',', '.');

//------------------------------ Soma o valor de parcelas pendentes -----------------------------------
$valorpendente = $valorgeral - $valorpago - $desconto2;
$valorpendente_format = number_format($valorpendente,2, ',', '.');

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
                        <div class="card">
                                    <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="financeiro_receber.php"><i class="mdi mdi-cash-multiple"></i> Receitas</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="financeiro_receber_parcelas.php"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
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
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
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
