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
$idcliente = $_GET['idcliente']; 
// Consulta SQL com parâmetros para `prepare`
$sql = "
    SELECT cr.idparcelas, crm.idmovimento, crm.idcliente, p.idpassagem, c.nome AS nomecliente, 
           p.desembarque, cr.valor, cr.parcela, p.embarque, c.documento, cr.quem_recebeu, 
           cr.data_pg, fp.tipo, cr.obs, cr.idsituacao, sc.situacao
    FROM contas_receb_movi crm 
    INNER JOIN clientes c ON crm.idcliente = c.idcliente 
    INNER JOIN passagem p ON p.idpassagem = crm.idpassagem 
    INNER JOIN contas_receber cr ON cr.idmovimento = crm.idmovimento 
    INNER JOIN formapg fp ON fp.idformapg = cr.idformapg
    INNER JOIN situacao_caixa sc ON sc.idsituacao = cr.idsituacao
    WHERE cr.idcliente = ? AND c.idcontrato = ?
";

$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $idcliente, $idcontrato); // "ii" indica dois parâmetros inteiros
$stmt->execute();
$dados = $stmt->get_result();

// Transforma os dados em um array
$linha = $dados->fetch_assoc();

// Calcula o número total de registros
$total = $dados->num_rows;

// ----------------------- Usuario ----------------------------    
// Segunda consulta: busca o nível do usuário pelo id_usuario
$sql_usuarios = "SELECT u.nivel 
                 FROM usuario u 
                 INNER JOIN usuario_contrato uc ON uc.idcontrato = u.idcontrato 
                 WHERE id_usuario = ?";
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->bind_param("i", $usuarioid);  // "i" indica que $usuarioid é um inteiro
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->get_result();

// Verifica se há dados retornados e os transforma em um array
$linhausuario = $usuarios->fetch_assoc();  

$stmt->close();
$stmt_usuarios->close();
$con->close();
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
                                        <a class="nav-link" href="cliente_cadastro_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Cliente</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_passagem_listar.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-hospital"></i>Passagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Financeiro</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link active" href="cliente_financeiro_parcelas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                    </ul>

                            <div class="card-body wizard-content">
                <div class="row">
                                 <div class="card-body wizard-content">
                                    <h4 class="card-title">Fluxo</h4>
                                    <h6 class="card-subtitle">Lista dos pagamentos</h6>
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
                                                    <td><?php echo $linha['desembarque']?></td>
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
                    <?php foreach($dados as $aqui){ 
                        $idparcelasprox = $aqui['idparcelas'] + 1;
                        ?>
                                <div class="modal fade bs-example-modal" tabindex="-1" id="financeiro_pagar<?php echo $aqui['idparcelas']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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
                                                        <input type="text" class="form-control" id="valor" name="valor">
                                                        <input type="hidden" class="form-control" id="idparcelas" name="idparcelas" value="<?php echo $aqui['idparcelas'] ?>" required>
                                                        <input type="hidden" class="form-control" id="valor" name="valor" value="<?php echo $aqui['valor'] ?>" required>
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
