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
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                                 <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <center><h4 class="card-title">Lista de Clientes</h4></center>
                                <form class="form-material m-t-40 row" action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                    <div class="form-group m-b-40 col-md-3">
                                        
                                    </div>
                                    <div class="form-group m-b-40 col-md-6">
                                        <label for="nome">Nome</label>
                                        <input type="search" class="form-control" id="nome" name="nome">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <input type="submit" class="btn btn-info" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                     </div>
                    </div>
<?php 
if ($_POST)
        { 
$nomep = $_POST['nome'];  
$dados = mysqli_query($con,"SELECT distinct c.idcliente, c.nome, c.sexo, c.celular, c.nascimento, p.idpassagem
    from clientes c, passagem p
    where c.idcliente = p.idcliente and status_passagem <> 0 and c.nome like '%$nomep%'
    group by c.idcliente, c.nome, c.sexo, c.celular, c.nascimento, p.idpassagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados);
    
// ----------------------- Usuario ----------------------------    
// executa a query 
$usuarios = mysqli_query($con,"SELECT nivel FROM usuario where id_usuario=$usuarioid") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhausuario = mysqli_fetch_assoc($usuarios);   
?>
                    <div class="col-12">                    
                        <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Anamnese</h4>
                                    <h6 class="card-subtitle">Lista de Anamnese com palavra chave "<?php echo $nomep ?>"</h6>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>   
                                                    <th>CLIENTE</th>          
                                                    <th>PASSAPORTE</th>
                                                    <th>DATA</th>
                                                    <th>DESTINO</th>
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
                                                    <td><?php echo $linha['nome']?></td>
                                                    <td><?php echo $linha['passaporte']?></td>
                                                    <td><?php echo date('d/m/Y h:i', strtotime($linha['data_passagem'])); ?></td>
                                                    <td><?php echo $linha['destino']?></td>
                                                    <td>
                                                    <a href="cliente_cadastro_ver.php?idcliente=<?php echo $linha['idcliente'] ?>"  class="btn btn-info btn-circle" role="button"><i class="icon-magnifier"></i> </a>
                                                    <a href="print_contrato.php?idcliente=<?php echo $linha['idcliente'] ?>&idpassagem=<?php echo $linha['idpassagem'] ?>" target="_blank"  class="btn btn-warning btn-circle" role="button"><i class="fa fa-print"></i> </a>
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

<?php 
}
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
