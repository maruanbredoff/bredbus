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
    SELECT DISTINCT c.nome, c.documento, c.celular, p.embarque, p.desembarque, 
                    v.dataviagem, v.horaviagem, st.status, st.idstatuspass, 
                    p.idpassagem, v.idviagem
    FROM clientes c
    INNER JOIN passagem p ON p.idcliente = c.idcliente
    INNER JOIN viagem v ON v.idviagem = p.idviagem
    INNER JOIN status_passagem st ON p.status_passagem = st.idstatuspass
    WHERE c.idcliente = p.idcliente 
      AND p.idcliente = ? 
      AND c.idcontrato = ?
    ORDER BY p.idpassagem DESC
";

$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $idcliente, $idcontrato); // "ii" indica dois parâmetros inteiros
$stmt->execute();
$dados = $stmt->get_result();

// Transforma os dados em um array
$linha = $dados->fetch_array();

// Calcula o número total de registros
$total = $dados->num_rows;

// Fecha a declaração preparada e a conexão, se não forem mais necessários

    
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
                    <h3 class="text-themecolor">Lista de Passagens</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active">Passagem</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">                    
                        <div class="card">                        
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_cadastro_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Cliente</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link active" href="cliente_passagem_listar.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-hospital"></i>Passagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Financeiro</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro_parcelas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                    </ul>

                                 <div class="card-body wizard-content">
                                    <h4 class="card-title">Passagens</h4>
                                    <h6 class="card-subtitle">Lista de passagens Cadastradas</h6>
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Data</th>
                                                    <th>Embarque</th>
                                                    <th>Desembarque</th>
                                                    <th>status Passagem</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idpassagem']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['dataviagem'])). " - " . $linha['horaviagem'];  ?></td>
                                                    <td><?php echo $linha['embarque']?></td>
                                                    <td><?php echo $linha['desembarque']?></td>
                                                    <?php if($linha['idstatuspass']==1) {?>
                                                    <td width="50" align="center"><span class="label label-info pull-center"><?php echo $linha['status']?></span></td> <?php }
                                                    else if($linha['idstatuspass']==2) {?>
                                                    <td width="50" align="center"><span class="label label-success pull-center"><?php echo $linha['status']?></span></td> 
                                                  <?php }
                                                    else if($linha['idstatuspass']==3) {?>
                                                    <td width="50" align="center"><span class="label label-warning pull-center"><?php echo $linha['status']?></span></td> 
                                                  <?php } else { ?>
                                                    <td width="50" align="center"><span class="label label-danger pull-center"><?php echo $linha['status']?></span></td>
                                                    <?php
                                                    }?>
                                                    <td><a href="passagem.php?idviagem=<?php echo $linha['idviagem'] ?>"class="btn btn-success" role="button">Ver Viagem </a></td>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha = mysqli_fetch_array($dados)); 
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

</body>

</html>
