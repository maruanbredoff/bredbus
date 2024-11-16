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
                        url: "carrega_dados3.php",
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

$query = sprintf("SELECT r.idrota, r.obs, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino 
FROM rota r
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino;"); 

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
                    <h3 class="text-themecolor">Cadastro de Linhas</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active">Linhas</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
<?php
if($_POST){
      // inicio dos campos da tabela parcelas            
    $cidadeorigem = mysqli_real_escape_string($con,$_POST['corigem']);              
    $cidadedestino = mysqli_real_escape_string($con,$_POST['cdestino']);  
    $uforigem = mysqli_real_escape_string($con,$_POST['uforigem']);  
    $ufdestino = mysqli_real_escape_string($con,$_POST['ufdestino']); 
    $resp_cadastro = mysqli_real_escape_string($con,$_POST['resp_cadastro']); 
    $obs = mysqli_real_escape_string($con,$_POST['obs']); 
    //Insere na tabela pagamentos
          $cad_rota = mysqli_query($con,"INSERT INTO rota (corigem,cdestino,obs,resp_cadastro,uforigem,ufdestino) values('$cidadeorigem','$cidadedestino','$obs','$resp_cadastro','$uforigem','$ufdestino') ") or die(mysqli_error($con)); 

          if(mysqli_affected_rows($con) == 1){ ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=linha_cadastrar.php'>";    
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
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cadastrar_linha">Cadastrar Linha</button>
<!--                                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrar_tipopg">Cadastrar Tipo Pg</button> -->
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Cidade/Estado Origem</th>
                                                    <th>Cidade/Estado Destino</th>
                                                    <th>Obs</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                                    @$valor = $linha['valor'];
                                                    $valor_formatado = number_format($valor,2, ',', '.');
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idrota']?></td>
                                                    <td><?php echo $linha['corigem']?> - <?php echo $linha['uforigem'] ?></td>
                                                    <td><?php echo $linha['cdestino']?> - <?php echo $linha['ufdestino'] ?></td>
                                                    <td><?php echo $linha['obs']?></td>
                                                    <td width="166">
                                                 <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#editar_rota<?php echo $linha['idrota']?>"><i class="fa fa-edit"></i></a>
                                                    <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#financeiro_cancelar<?php echo $linha['idrota']?>"><i class="fa fa-trash"></i></a>

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
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrar_linha" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_procedimento">Cadastrar Linha/Rota</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">

<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="estado">Estado 1</label>
                <select id="estado" class="form-control">
                    <option value="">Selecione um estado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade 1</label>
                <select id="cidade" class="form-control">
                    <option value="">Selecione uma cidade</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="estado2">Estado 2</label>
                <select id="estado2" class="form-control">
                    <option value="">Selecione um estado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="cidade2">Cidade 2</label>
                <select id="cidade2" class="form-control">
                    <option value="">Selecione uma cidade</option>
                </select>
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
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_rota<?php echo $aqui2['idrota']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editar_procedimento">Editar Pagamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="linha_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="uforigem">Estado Origem</label>
                                                    <select class="form-control" name="uforigem" id="uforigem" required>
                                                        <option value="<?php echo $aqui2['uforigem'] ?>"><?php echo $aqui2['uforigem'] ?></option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM estados order by sigla") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['sigla']."'>".$line['sigla']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                     <label for="cidade">Cidade/Origem</label>
                                                        <select class="form-control" name="corigem" id="corigem" required>
                                                        <option value="<?php echo $aqui2['corigem'] ?>"><?php echo $aqui2['corigem'] ?></option>
                                                            <option value="Padre Paraiso">Padre Paraiso</option>
                                                            <option value="Belo Horizonte">Belo Horizonte</option>
                                                            <option value="Campinas">Campinas</option>
                                                      </select> 
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="ufdestino">Estado Destino</label>
                                                    <select class="form-control" name="ufdestino" id="ufdestino" required>
                                                        <option value="<?php echo $aqui2['ufdestino'] ?>"><?php echo $aqui2['ufdestino'] ?></option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM estados order by sigla") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['sigla']."'>".$line['sigla']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                     <label for="cidade">Cidade/Destino</label>
                                                        <select class="form-control" name="cdestino" id="cdestino" required>
                                                        <option value="<?php echo $aqui2['cdestino'] ?>"><?php echo $aqui2['cdestino'] ?></option>
                                                            <option value="Padre Paraiso">Padre Paraiso</option>
                                                            <option value="Belo Horizonte">Belo Horizonte</option>
                                                            <option value="Campinas">Campinas</option>
                                                      </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="obs">obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs"> 
                                                    <input type="hidden" class="form-control" id="idrota" name="idrota" value="<?php echo $aqui2['idrota']?>"> 
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
                    
<?php 
include "../rodape.php";
?>
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
<script>
$(document).ready(function() {
    // Função para carregar estados
    function carregarEstados(selectElement) {
        $.ajax({
            url: 'linha_cadastrar.php',
            type: 'POST',
            data: { tipo: 'estados' },
            success: function(response) {
                try {
                    var data = JSON.parse(response);
                    if (data.error) {
                        console.error('Erro: ' + data.error);
                        return;
                    }
                    if (data.length) {
                        selectElement.empty();
                        selectElement.append('<option value="">Selecione um estado</option>');
                        for (var i = 0; i < data.length; i++) {
                            selectElement.append('<option value="' + data[i].id + '">' + data[i].nome + '</option>');
                        }
                    } else {
                        console.error('Erro: Nenhum dado encontrado');
                    }
                } catch (e) {
                    console.error('Erro ao processar a resposta JSON: ', e);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro na requisição AJAX: ' + textStatus, errorThrown);
            }
        });
    }

    // Função para carregar cidades com base no estado selecionado
    function carregarCidades(estadoId, cidadeSelect) {
        $.ajax({
            url: 'linha_cadastrar.php',
            type: 'POST',
            data: { tipo: 'cidades', cat_id: estadoId },
            success: function(response) {
                try {
                    var data = JSON.parse(response);
                    if (data.error) {
                        console.error('Erro: ' + data.error);
                        return;
                    }
                    if (data.length) {
                        cidadeSelect.empty();
                        cidadeSelect.append('<option value="">Selecione uma cidade</option>');
                        for (var i = 0; i < data.length; i++) {
                            cidadeSelect.append('<option value="' + data[i].id + '">' + data[i].nome + '</option>');
                        }
                    } else {
                        console.error('Erro: Nenhum dado encontrado');
                    }
                } catch (e) {
                    console.error('Erro ao processar a resposta JSON: ', e);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro na requisição AJAX: ' + textStatus, errorThrown);
            }
        });
    }

    // Carregar estados ao carregar a página
    carregarEstados($('#estado'));
    carregarEstados($('#estado2'));

    // Carregar cidades ao selecionar um estado
    $('#estado').on('change', function() {
        var estadoId = $(this).val();
        if (estadoId) {
            carregarCidades(estadoId, $('#cidade'));
        } else {
            $('#cidade').empty();
            $('#cidade').append('<option value="">Selecione uma cidade</option>');
        }
    });

    $('#estado2').on('change', function() {
        var estadoId = $(this).val();
        if (estadoId) {
            carregarCidades(estadoId, $('#cidade2'));
        } else {
            $('#cidade2').empty();
            $('#cidade2').append('<option value="">Selecione uma cidade</option>');
        }
    });
});
</script>
</body>

</html>
