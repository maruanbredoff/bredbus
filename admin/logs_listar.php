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
include "../funcoes.php";
?>
</head>

<body class="fix-header card-no-border">
<?php 
$idcontrato = $_SESSION['ContratoID'];
include "../verificanivel.php"; 

$query = sprintf("SELECT * from logs where idcontrato = $idcontrato order by logid desc limit 300"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

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
                <div class="row">
                    <div class="col-12">                    
                        <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Logs</h4>
                                    <h6 class="card-subtitle">Lista de ações de Usuarios</h6>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Login</th>
                                                    <th>Mensagem</th>
                                                    <th>Informação</th>
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
                                                    <td><?php echo $linha['hora'] ?></td>
                                                    <td width="400"><?php echo utf8_encode($linha['login'])?></td>
                                                    <td><?php echo utf8_encode($linha['mensagem'])?></td>
                                                    <td><?php echo utf8_encode($linha['relacionamento'])?></td>
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
                                <div class="modal fade" id="cadastrar_procedimento" tabindex="-1" role="dialog" aria-labelledby="cadastrar_procedimento">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_procedimento">Cadastrar Procedimento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" class="form-cadastro" method="post">
                                                    <div class="form-group ">
                                                        <label for="descricao" class="control-label">Descrição:</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="valor" class="control-label">Valor R$:</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="resp_cadastro" class="control-label">Quem Cadastra:</label>
                                                        <input type="text" class="form-control" id="resp_cadastro" name="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>">
                                                    </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <?php foreach($dados as $aqui){ ?>
                                <div class="modal fade" id="editar_procedimento<?php echo $aqui['idprocedimento']?>" tabindex="-1" role="dialog" aria-labelledby="editar_procedimento">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_procedimento">Editar Procedimento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="procedimento_editar.php" class="form-cadastro" method="post">
                                                    <div class="form-group ">
                                                        <label for="descricao" class="control-label">Descrição:</label>
                                                        <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo utf8_encode($aqui['descricao']) ?>">
                                                        <input type="hidden" class="form-control" id="idprocedimento" name="idprocedimento" value="<?php echo utf8_encode($aqui['idprocedimento']) ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="valor" class="control-label">Valor R$:</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" value="<?php echo $aqui['valor'] ?>"onKeyPress="return(MascaraMoeda(this,'.',',',event))">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editado_por" class="control-label">Quem Cadastra:</label>
                                                        <input type="text" class="form-control" id="editado_por" name="editado_por" value="<?php echo $_SESSION['UsuarioNome'] ?>">
                                                    </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="cadastrar" class="btn btn-primary">Editar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <?php  }  ?>
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
