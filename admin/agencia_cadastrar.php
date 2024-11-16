<!DOCTYPE html>
<html lang="en">

<head>
<?php 
date_default_timezone_set('America/Sao_Paulo');
$date2 = date('Y-m-d H:i');
//$datebr = date('d-m-Y H:i', strtotime('+1 months', strtotime(date('d-m-Y'))));
$datebr2 = date('d-m-Y H:i');
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

// Consulta para buscar informações da agência vinculadas ao contrato
$query = "SELECT idagencia, nome, cep, endereco, cidade, estado, telefone 
          FROM agencia
          WHERE idcontrato = ?";

// Prepara e executa a consulta
$stmt = $con->prepare($query);
$stmt->bind_param("i", $idcontrato); // Vincula o idcontrato na consulta
$stmt->execute();
$dados = $stmt->get_result();

// Transforma os dados em um array
$linha = $dados->fetch_assoc();
$total = $dados->num_rows;

$stmt->close();

// ----------------------- Consulta Usuário ----------------------------
$sql_usuarios = "SELECT u.nivel 
                 FROM usuario u 
                 INNER JOIN usuario_contrato uc ON uc.idcontrato = u.idcontrato 
                 WHERE u.id_usuario = ? AND u.idcontrato = ?";

// Prepara e executa a consulta de usuário
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->bind_param("ii", $usuarioid, $idcontrato); // Vincula id_usuario e idcontrato na consulta
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->get_result();

// Transforma os dados em um array
$linhausuario = $usuarios->fetch_assoc();

$stmt_usuarios->close();

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
                    <h3 class="text-themecolor">Cadastro de Motorista</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active">Motorista</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
<?php
if($_POST){
      // inicio dos campos da tabela parcelas            
    $nome = mysqli_real_escape_string($con,$_POST['nome']);              
    $cep = mysqli_real_escape_string($con,$_POST['cep']);  
    $endereco = mysqli_real_escape_string($con,$_POST['endereco']); 
    $cidade = mysqli_real_escape_string($con,$_POST['cidade']); 
    $estado = mysqli_real_escape_string($con,$_POST['estado']); 
    $telefone = mysqli_real_escape_string($con,$_POST['telefone']); 
    $resp_cadastro = mysqli_real_escape_string($con,$_POST['resp_cadastro']); 
    //Insere na tabela pagamentos
          $cad_rota = mysqli_query($con,"INSERT INTO agencia(nome,cep,endereco,cidade,estado,telefone,resp_cadastro, idcontrato) values('$nome','$cep','$endereco','$cidade','$estado','$telefone','$resp_cadastro','$idcontrato') ") or die(mysqli_error($con)); 

          if(mysqli_affected_rows($con) == 1){ ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=agencia_cadastrar.php'>";    
            }
          else{ ?>
                <div class="alert alert-danger alert-rounded">
                    <i class="ti-user"></i> Erro. Ocorreu algum problema no Cadastro!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
        <?php }
        }
?>
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
                        <div class="card-group">
                                               <div class="card-body wizard-content">
                                    <h4>Linhas</h4>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cadastrar_agencia">Cadastrar Agencia</button>
<!--                                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrar_tipopg">Cadastrar Tipo Pg</button> -->
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>NOME</th>
                                                    <th>CEP</th>
                                                    <th>ENDEREÇO</th>
                                                    <th>CIDADE</th>
                                                    <th>ESTADO</th>
                                                    <th>TELEFONE</th>
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
                                                    <td><?php echo $linha['nome']?></td>
                                                    <td><?php echo $linha['cep']?></td>
                                                    <td><?php echo $linha['endereco']?></td>
                                                    <td><?php echo $linha['cidade']?></td>
                                                    <td><?php echo $linha['estado']?></td>
                                                    <td><?php echo $linha['telefone']?></td>
                                                    <td width="166">
                                                 <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#editar_agencia<?php echo $linha['idagencia']?>"><i class="fa fa-edit"></i></a>

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
                            </div></div>
                        </div>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrar_agencia" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_agencia">Cadastrar Agencia</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="nome">Nome</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Agencia BH" required>  
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="documento">Cep</label>
                                                    <input type="text" class="form-control" id="cep" name="cep"> 
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" id="endereco" name="endereco"> 
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="cidade">Cidade</label>
                                                    <input type="text" class="form-control" id="cidade" name="cidade"> 
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="estado">Estado</label>
                                                    <input type="text" class="form-control" id="estado" name="estado"> 
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" name="telefone">
                                                    <input type="hidden" name="resp_cadastro" id="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Cadastrar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                <?php foreach($dados as $aqui2){ ?>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_agencia<?php echo $aqui2['idagencia']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_agencia">Editar Agencia</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="agencia_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="nome">Nome</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $aqui2['nome']?>" required>  
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="documento">Cep</label>
                                                    <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $aqui2['cep']?>"> 
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="endereco">Endereço</label>
                                                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $aqui2['endereco']?>"> 
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="cidade">Cidade</label>
                                                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $aqui2['cidade']?>"> 
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="estado">Estado</label>
                                                    <input type="text" class="form-control" id="estado" name="estado" value="<?php echo $aqui2['estado']?>"> 
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="telefone">Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $aqui2['telefone']?>">
                                                    <input type="hidden" name="resp_cadastro" id="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                        <input type="hidden" class="form-control" id="idagencia" name="idagencia" value="<?php echo $aqui2['idagencia']?>"> 
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Editar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                         <?php  }  ?>
                    

        <style type="text/css">
.escondida {
    display:none;
}
</style>
<script>
    $("#estadoorigem").on("change",function(){
        var id = $("estadoorigem").val();

        $.ajax({
            url: 'pega_cidade_origem.php?id='+id,
            type: 'POST',
            dataType: "text",
            beforeSend: function(){
            $("#cidadeorigem").css({display:'block'});
            $("#cidadeorigem").html("Carregando...");
            },
            success: function(res)
            {
            //$('.cidadeori').slideToggle(); // aparece o div
            //$('.cidadeori').show(); // aparece o div
            $("#cidadeorigem").css({display:'block'});
            $("#cidadeorigem").html(res); 
            $("#cidadeorigem").append(res); 
            }

        })
    })
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
