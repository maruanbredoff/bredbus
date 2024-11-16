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
                                    <center><h4>Viagens Encontradas</h4></center>
                                    <div class="table-responsive m-t-40">
<?php 
    $hoje = date('Y/m/d');                                //Antes do POST
$dataviagem = $_POST['dataviagem'];  
$dados = mysqli_query($con,"select distinct v.idviagem, v.motorista1, v.motorista2, v.dataviagem, v.horaviagem, b.tipo, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
from viagem v
inner join rota r on r.idrota = v.idrota
inner join bus b on b.idbus = v.idbus
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where DATE_ADD(v.dataviagem, INTERVAL 3 DAY)
order by v.dataviagem") or die(mysqli_error($con)); 

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
                                        <table id="myTable2" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>          
                                                    <th>Dt. Partida</th>
                                                    <th>Hora Embarq.</th>
                                                    <th>Linha</th>
                                                    <th>Ônibus</th>
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
$idviagem = $linha['idviagem'];
$dadosencomendas = mysqli_query($con,"select count(*) as qtdencomenda
from viagem_encomenda ve
inner join viagem v on v.idviagem = ve.idviagem
where ve.idviagem = $idviagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_encomendas = mysqli_fetch_assoc($dadosencomendas); 

$qtdencomenda = $linha_encomendas['qtdencomenda'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idviagem']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['dataviagem'])); ?></td>
                                                    <td><?php echo $linha['horaviagem']?></td>
                                                    <td><?php echo $linha['corigem']."->".$linha['cdestino']?></td>
                                                    <td><?php echo $linha['tipo']?></td>
                                                    <td><?php echo @$linha['obs']?></td>
                                                    <td>
                                                    <a href="passagem.php?idviagem=<?php echo $linha['idviagem'] ?>"  class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i> </a>
                                                    <a href="print_passageiros.php?idviagem=<?php echo $linha['idviagem'] ?>" target="_blank" class="btn btn-primary btn-circle" role="button"><i class="mdi mdi-bus"></i> </a><?php if($qtdencomenda > 0) {?>
                                                    <a href="print_encomendas.php?idviagem=<?php echo $linha['idviagem'] ?>" target="_blank" class="btn btn-warning btn-circle" role="button"><i class="mdi mdi-package-variant"></i> </a> <?php } ?>
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
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrarviagem" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrarviagem">Cadastrar Viagem</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="viagem_salvar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="rota">Linha / Rota</label>
                                                    <select class="custom-select form-control" name="idrota" id="idrota" required>
                                                        <option value="">Selecione</option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM rota") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idrota']."'>".$line['corigem']." -> ".$line['cdestino']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="dataviagem">Dt. Viagem</label>
                                                        <input type="date" class="form-control" id="dataviagem" name="dataviagem" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="horaviagem">Hr. Viagem</label>
                                                        <input type="time" class="form-control" id="horaviagem" name="horaviagem" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="idbus">Onibus</label>
                                                    <select class="custom-select form-control" name="idbus" id="idbus" required>
                                                        <option value="">Selecione</option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM bus") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idbus']."'>".$line['descricao']."</option>";
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
                                                     <label for="motorista1">Motorista 1</label>
                                                    <select class="custom-select form-control" name="motorista1" id="motorista1" required>
                                                        <option value="">Selecione</option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM motorista order by nome") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['nome']."'>".$line['nome']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="motorista2">Motorista 2</label>
                                                    <select class="custom-select form-control" name="motorista2" id="motorista2">
                                                        <option value="">Selecione</option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM motorista order by nome") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['nome']."'>".$line['nome']."</option>";
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
                                                     <label for="obs">Observação</label>
                                                        <input type="date" class="form-control" id="obs" name="obs">
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
        
        $('#myTable2').DataTable();
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
function formatar(mascara, documento){
  var i = documento.value.length;
  var saida = mascara.substring(0,1);
  var texto = mascara.substring(i)
  
  if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
  }
  
}
</script>
</body>

</html>
