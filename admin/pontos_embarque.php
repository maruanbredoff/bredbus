<!DOCTYPE html>
<html lang="en">

<head>
        <script src="js/jquery.js"></script>

        <link rel="stylesheet" href="css/bootstrap-select.min.css">
        <script src="js/bootstrap-select.min.js"></script>
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

        <script>
            $(document).ready(function () {

                $('select').selectpicker();

                //$('#cidades').selectpicker();

                carrega_dados('estados');

                function carrega_dados(tipo, cat_id = ''){
                    $.ajax({
                        url: "carrega_dados.php",
                        method: "POST",
                        data: {tipo: tipo, cat_id: cat_id},
                        dataType: "json",
                        success: function (data)
                        {
                            var html = '';
                            for (var count = 0; count < data.length; count++){
                                html += '<option value="' + data[count].id + '">' + data[count].nome + '</option>';
                            }
                            if (tipo == 'estados'){
                                $('#estados').html(html);
                                $('#estados').selectpicker('refresh');
                            } else {
                                $('#cidades').html(html);
                                $('#cidades').selectpicker('refresh');
                            }
                        }
                    })
                }

                $(document).on('change', '#estados', function () {
                    var nome = $('#estados').val();
                    carrega_dados('cidades', nome);
                });

            });
        </script>

        <script>
            $(document).ready(function () {

                $('select').selectpicker();

                //$('#cidades').selectpicker();

                carrega_dados2('estados2');

                function carrega_dados2(tipo2, cat_id2 = ''){
                    $.ajax({
                        url: "carrega_dados2.php",
                        method: "POST",
                        data: {tipo2: tipo2, cat_id2: cat_id2},
                        dataType: "json",
                        success: function (data)
                        {
                            var html = '';
                            for (var count = 0; count < data.length; count++){
                                html += '<option value="' + data[count].id + '">' + data[count].nome + '</option>';
                            }
                            if (tipo2 == 'estados2'){
                                $('#estados2').html(html);
                                $('#estados2').selectpicker('refresh');
                            } else {
                                $('#cidades2').html(html);
                                $('#cidades2').selectpicker('refresh');
                            }
                        }
                    })
                }

                $(document).on('change', '#estados2', function () {
                    var cat_id2 = $('#estados2').val();
                    carrega_dados2('cidades2', cat_id2);
                });

            });
        </script>
</head>

<body class="fix-header card-no-border">
<?php 
include "../verificanivel.php"; 
include "../funcoes.php"; 
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];

// Prepara a consulta para buscar os dados da rota e pontos de embarque
$query = "SELECT r.idrota, pe.idembarque, pe.nome, pe.horario, 
                 c1.nome as corigem, e1.uf as uforigem, 
                 c2.nome as cdestino, e2.uf as ufdestino
          FROM pontos_embarque pe 
          INNER JOIN rota r ON pe.idrota = r.idrota
          INNER JOIN cidades c1 ON c1.id = r.corigem
          INNER JOIN cidades c2 ON c2.id = r.cdestino
          INNER JOIN estados e1 ON e1.id = r.uforigem
          INNER JOIN estados e2 ON e2.id = r.ufdestino
          WHERE r.idcontrato = ?
          GROUP BY pe.idembarque, pe.nome
          ORDER BY r.idrota";

// Prepara e executa a query
$stmt = $con->prepare($query);
$stmt->bind_param("i", $idcontrato);
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
                 WHERE u.id_usuario = ?";

// Prepara e executa a consulta de usuário
$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->bind_param("i", $usuarioid);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->get_result();

// Transforma os dados em um array
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
                    <h3 class="text-themecolor">Cadastro de Embarques</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active">Embarque</li>
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
    $horario = mysqli_real_escape_string($con,$_POST['horario']);  
    $idrota = mysqli_real_escape_string($con,$_POST['idrota']);  
    $resp_cadastro = mysqli_real_escape_string($con,$_POST['resp_cadastro']); 
    //Insere na tabela pagamentos
          $cad_rota = mysqli_query($con,"INSERT INTO pontos_embarque (nome,horario,idrota,resp_cadastro) values('$nome','$horario','$idrota','$resp_cadastro') ") or die(mysqli_error($con)); 

          if(mysqli_affected_rows($con) == 1){ ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=pontos_embarque.php'>";    
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
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cadastrar_embarque">Cadastrar Embarque</button>
<!--                                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrar_tipopg">Cadastrar Tipo Pg</button> -->
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID ROTA</th>
                                                    <th>Embarque</th>
                                                    <th>Rota</th>
                                                    <th>Horario</th>
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
                                                    <td><?php echo $linha['idrota']?></td>
                                                    <td><?php echo $linha['nome']?></td>
                                                    <td><?php echo $linha['corigem']?> - <?php echo $linha['uforigem'] ?> - <?php echo $linha['cdestino']?> - <?php echo $linha['ufdestino'] ?> </td>
                                                    <td><?php echo $linha['horario']?></td>
                                                    <td width="166">
                                                 <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#editar_embarque<?php echo $linha['idembarque']?>"><i class="fa fa-edit"></i></a>
                                                    <?php if($linhausuario["nivel"]>=9){ ?> 
                                                    <a class="btn btn-danger btn-circle" onclick="return confirm('Deseja realmente excluir esse embarque?!')" href="pontos_embarque_deletar.php?idembarque=<?php echo $linha['idembarque'] ?>" role="button"><i class="fa fa-trash-o"></i> </a> <?php } ?>

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
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrar_embarque" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_procedimento">Cadastrar Linha/Rota</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="rota">Linha / Rota</label>
                                                    <select class="custom-select form-control" name="idrota" id="idrota" required>
                                                        <option value="">Selecione</option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT r.idrota, r.obs, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino 
                                                                FROM rota r
                                                                INNER JOIN cidades c1 ON c1.id = r.corigem
                                                                INNER JOIN cidades c2 on c2.id = r.cdestino
                                                                INNER JOIN estados e1 on e1.id = r.uforigem
                                                                INNER JOIN estados e2 on e2.id = r.ufdestino") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
        echo "<option value='".$line['idrota']."'>".$line['corigem']." - ".$line['uforigem']." -> ".$line['cdestino']." - ".$line['ufdestino']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="nome">Embarque</label>
                                                        <input type="text" class="form-control" id="nome" name="nome"> 
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="horario">Horario</label>
                                                        <input type="time" class="form-control" id="horario" name="horario"> 
                                                        <input type="hidden" name="resp_cadastro" id="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                    </div>
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
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_embarque<?php echo $aqui2['idembarque']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_procedimento">Editar Embarque</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form mlk/lkio action="pontos_embarque_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="rota">Linha / Rota</label>
                                                    <select class="custom-select form-control" name="idrota" id="idrota">
                                                        <option value="<?php echo $aqui2['idrota'] ?>" ><?php echo $aqui2['corigem']." - ".$aqui2['uforigem']." -> ".$aqui2['cdestino']." - ".$aqui2['ufdestino'] ?></option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT r.idrota, r.obs, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino 
                                                                FROM rota r
                                                                INNER JOIN cidades c1 ON c1.id = r.corigem
                                                                INNER JOIN cidades c2 on c2.id = r.cdestino
                                                                INNER JOIN estados e1 on e1.id = r.uforigem
                                                                INNER JOIN estados e2 on e2.id = r.ufdestino") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idrota']."'>".$line['corigem']." - ".$line['uforigem']." -> ".$line['cdestino']." - ".$line['ufdestino']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="nome">Embarque</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $aqui2['nome'] ?>"> 
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="horario">Horario</label>
                                                        <input type="time" class="form-control" id="horario" name="horario" value="<?php echo $aqui2['horario'] ?>"> 
                                                        <input type="hidden" class="form-control" id="idembarque" name="idembarque" value="<?php echo $aqui2['idembarque'] ?>"> 
                                                        <input type="hidden" name="resp_cadastro" id="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="editar" id="editar" class="btn btn-primary">Editar</button>
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
