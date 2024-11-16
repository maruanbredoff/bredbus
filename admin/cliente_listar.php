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
// Obtém o idcontrato e o usuarioid da sessão
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];

// Primeira consulta: busca informações do cliente pelo idcontrato
$sql_clientes = "SELECT idcliente, nome, mae, documento, sexo, nascimento, celular, obs, org, idcontrato 
                 FROM clientes 
                 WHERE idcontrato = ? 
                 ORDER BY nome";
$stmt_clientes = $con->prepare($sql_clientes);
$stmt_clientes->bind_param("i", $idcontrato);  // "i" indica que $idcontrato é um inteiro
$stmt_clientes->execute();
$dados = $stmt_clientes->get_result();

// Verifica se há dados retornados e os transforma em um array
$linha = $dados->fetch_assoc();
$total = $dados->num_rows; // Número total de registros retornados

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
                    <h3 class="text-themecolor">Lista de Clientes</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active">Cliente</li>
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
                                 <div class="col-12">
                        <div class="card">
                            <div class="card-body">
<!--                                     <div class="form-group m-b-40 col-md-3">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastrarcliente">+ Novo Cadastro</button>
                                    </div> -->
                                <center><h4 class="card-title">Pesquisar Clientes</h4></center>
                                <form class="form-material m-t-40 row" action="<?php $_SERVER['PHP_SELF']?>" method="post" onsubmit="return validateForm()">
                                    <div class="form-group m-b-40 col-md-6">
                                        <label for="nome">Nome</label>
                                        <input type="search" class="form-control" id="nome" name="nome" placeholder="Pesquisar nome completo ou parcial">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="nome">Documento</label>
                                        <input type="search" class="form-control" id="documento" name="documento">
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

// Primeira consulta (antes do POST)
$sql = "SELECT idcliente, nome, documento, mae, sexo, nascimento, celular, obs, org, idcontrato 
        FROM clientes 
        WHERE idcontrato = ? AND (nome LIKE '' OR documento = '')";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $idcontrato); // "i" indica que $idcontrato é um inteiro
$stmt->execute();
$dados = $stmt->get_result();

// Transforma os dados em um array
$linha = $dados->fetch_assoc();

// Fechar a primeira declaração preparada, se não for mais necessária
$stmt->close();

// Condição para verificar se o formulário foi enviado (POST)
if ($_POST) {
    $nomep = $_POST['nome'];
    $nomep = "%{$nomep}%"; // Adiciona os curingas para LIKE
    $documento = $_POST['documento'];

    // Segunda consulta (dentro do POST)
    $sql_post = "SELECT idcliente, nome, mae, documento, sexo, nascimento, celular, obs, org, idcontrato 
                 FROM clientes 
                 WHERE idcontrato = ? AND (nome LIKE ? OR documento = ?)";
    $stmt_post = $con->prepare($sql_post);
    $stmt_post->bind_param("iss", $idcontrato, $nomep, $documento); // "i" para idcontrato, "s" para nomep e documento
    $stmt_post->execute();
    $dados = $stmt_post->get_result();

    // Transforma os dados em um array
    $linha = $dados->fetch_assoc();

    // Fechar a segunda declaração preparada
    $stmt_post->close();
}

// Fechar a conexão após o uso
$con->close(); 


?>
    
                <div class="row">
                    <div class="col-12">                    
                        <div class="card">
                                 <div class="card-body wizard-content">
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Documento</th>
                                                    <th>Nascimento</th>
                                                    <th>Celular</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { ;?>
                                                <tr>
                                                    <td><?php echo $linha['nome']?></td>
                                                    <td><?php echo $linha['documento']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['nascimento'])); ?></td>
                                                    <td><?php echo $linha['celular']?></td>
                                                    <td>
                                                    <a href="cliente_cadastro_ver.php?idcliente=<?php echo $linha['idcliente'] ?>"  class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i> </a>
                                                    <a href="" class="btn btn-warning btn-circle" role="button" data-toggle="modal" data-target="#editar_cliente<?php echo $linha['idcliente']?>"><i class="fa fa-edit"></i></a> 
                                                    <?php if($linhausuario["nivel"]==10){ ?>  
                                                    <a class="btn btn-danger btn-circle" onclick="return confirm('Deseja realmente excluir Esse Cliente?!')" href="cliente_cadastro_delete.php?idcliente=<?php echo $linha['idcliente'] ?>" role="button"><i class="fa fa-trash-o"></i> </a>
                                                    <?php } ?>
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

include "../rodape.php";
?>

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrarcliente" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrarviagem">Cadastrar Cliente</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                <form action="cliente_cadastrar.php" method="post">
                                <div class="row">
                                    <div class="form-group m-b-40 col-md-7">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Paciente" required>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-5">
                                        <label for="nascimento">Nascimento</label>
                                        <input type="date" class="form-control" id="nascimento" name="nascimento" required>
                                        <span class="bar"></span>
                                    </div>
                               
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="sexo">Sexo</label>
                                        <select class="form-control p-0" id="sexo" name="sexo" required>
                                            <option></option>
                                            <option>Masculino</option>
                                            <option>Feminino</option>
                                        </select><span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="rg">Documento</label>
                                        <input type="text" class="form-control" id="documento" name="documento" placeholder="Documento">
                                        <span class="bar"></span>
                                    </div>
                                
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" OnKeyPress="formatar('##-#####-####', this)">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-8">
                                        <label for="obs">Observação</label>
                                        <input type="text" class="form-control" id="obs" name="obs" placeholder="Observação">
                                        <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $datebr ?>">
                                        <input type="hidden" class="form-control" id="atendente" name="atendente" value="<?php echo $_SESSION['UsuarioNome']?>">
                                        <span class="bar"></span>
                                    </div>
                                           <div class="form-group m-b-40 col-md-12">
                                        <input type="submit" class="btn btn-success" value="Cadastrar">
                                        </div>
                                    </div>
                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                <?php foreach($dados as $aqui2){ ?> 
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_cliente<?php echo $aqui2['idcliente']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_cliente">Editar Cliente</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="cliente_editar.php" method="post">
                                            <div class="row">
                                                <div class="form-group m-b-40 col-md-7">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $aqui2['nome'] ?>" required>
                                                    <input type="hidden" class="form-control" id="idcliente" name="idcliente" value="<?php echo $aqui2['idcliente'] ?>" required>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-5">
                                                    <label for="nascimento">Nascimento</label>
                                                    <input type="text" class="form-control" id="nascimento" name="nascimento" value="<?php echo $aqui2['nascimento'] ?>" required>
                                                    <span class="bar"></span>
                                                </div>
                                           
                                                <div class="form-group m-b-40 col-md-4">
                                                    <label for="sexo">Sexo</label>
                                                    <select class="form-control p-0" id="sexo" name="sexo" required>
                                                    <?php echo "<option value='".$aqui2['sexo']."'>".$aqui2['sexo']."</option>"; ?>
                                                        <option>Masculino</option>
                                                        <option>Feminino</option>
                                                        <option>Outros</option>
                                                    </select><span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-5">
                                                    <label for="documento">Documento</label>
                                                    <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $aqui2['documento'] ?>" >
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-3">
                                                    <label for="documento">Org Exp.</label>
                                                    <input type="text" class="form-control" id="org" name="org" value="<?php echo $aqui2['org'] ?>" required>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-5">
                                                    <label for="celular">Celular</label>
                                                    <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $aqui2['celular'] ?>" OnKeyPress="formatar('##-#####-####', this)">
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-7">
                                                    <label for="celular">Nome Mãe</label>
                                                    <input type="text" class="form-control" id="mae" name="mae" value="<?php echo $aqui2['mae'] ?>">
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group m-b-40 col-md-12">
                                                    <label for="obs">Observação</label>
                                                    <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $aqui2['obs'] ?>">
                                                    <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $datebr ?>">
                                                    <input type="hidden" class="form-control" id="atendente" name="atendente" value="<?php echo $_SESSION['UsuarioNome']?>">
                                                    <span class="bar"></span>
                                                </div>
                                                       <div class="form-group m-b-40 col-md-12">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                            <button type="submit" name="editar" id="editar" class="btn btn-primary">Editar</button>
                                                    </div>
                                                </div>
                                            </form>


                                            </div>
                                        </div>
                                    </div>
                                </div> 
                         <?php  }  ?> 


    </div>
<script>
function validateForm() {
    const nome = document.getElementById('nome').value.trim();
    const documento = document.getElementById('documento').value.trim();

    if ((nome.length < 3) && (documento.length < 3)) {
        alert('Por favor, digite pelo menos 3 caracteres no campo "Nome" ou "Documento".');
        return false;
    }
    return true;
}
</script>
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
