<!DOCTYPE html>
<html lang="en">

<head>
<?php 
include "../config.php"; 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
$datebr = date('d-m-Y H:i');
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

$nivel_necessario = 10;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
	// Destrói a sessão por segurança
	session_destroy();
	// Redireciona o visitante de volta pro login
	header("Location: ../restrita.php"); exit;
}
?>
</head>

<body class="fix-header card-no-border">
<?php 
include "../verificanivel.php"; 
include "../funcoes.php"; 

$query = sprintf("select d.iddentista,d.nome,d.cpf,d.nascimento,d.celular,d.sexo,d.comissao,e.descricao as especialidade,d.conselho
from dentista d, especialidade e 
where d.idespecialidade = e.idespecialidade"); 

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
                    <h3 class="text-themecolor">Cadastro</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="inicioadm.php">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active">Dentista</li>
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
      $cpf = mysqli_real_escape_string($con,$_POST['cpf']);
      $sexo = mysqli_real_escape_string($con,$_POST['sexo']);
      $nascimento = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['nascimento'])));
      $celular = mysqli_real_escape_string($con,$_POST['celular']); 
      $idespecialidade = mysqli_real_escape_string($con,$_POST['idespecialidade']); 
      $cep = mysqli_real_escape_string($con,$_POST['cep']); 
      $endereco = mysqli_real_escape_string($con,$_POST['endereco']); 
      $bairro = mysqli_real_escape_string($con,$_POST['bairro']); 
      $cidade = mysqli_real_escape_string($con,$_POST['cidade']); 
      $estado = mysqli_real_escape_string($con,$_POST['estado']); 
      $numero = mysqli_real_escape_string($con,$_POST['numero']); 
      $comissao = mysqli_real_escape_string($con,$_POST['comissao']); 
      $resp_cadastro = mysqli_real_escape_string($con,$_POST['resp_cadastro']); 
    
    //Insere na tabela pagamentos
          $cad = mysqli_query($con,"INSERT INTO dentista(iddentista,nome,cpf,sexo,nascimento,celular,idespecialidade,cep,endereco,bairro,cidade,estado,numero,comissao,resp_cadastro,data_cadastro) values(NULL,'$nome','$cpf','$sexo','$nascimento','$celular','$idespecialidade','$cep','$endereco','$bairro','$cidade','$estado','$numero','$comissao','$resp_cadastro','now()') ") or die(mysqli_error($con)); 

if($cad) {?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=cadastrar_dentista.php'>";    
            }
          else{ ?>
                <div class="alert alert-danger alert-rounded">
                    <i class="ti-user"></i> Erro. Ocorreu algum problema no Cadastro!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
        <?php } }
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
                                <div class="card-body wizard-content">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cadastrar_dentista">Cadastrar Dentista</button>
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Especialidade</th>
                                                    <th>Conselho</th>
                                                    <th>Comissao %</th>
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
                                                    <td><?php echo utf8_encode($linha['nome'])?></td>
                                                    <td><?php echo utf8_encode($linha['especialidade'])?></td>
                                                    <td><?php echo $linha['conselho']?></td>
                                                    <td><?php echo $linha['comissao']?></td>
                                                    <td width="108">
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#editar_receita<?php echo $linha['idreceita']?>"><i class="fa fa-edit"></i> </a>
                                                    <a class="btn btn-danger btn-circle" onclick="return confirm('Deseja realmente excluir Esse Cliente?!')" href="cliente_cadastro_delete.php?idcliente=<?php echo $linha['idcliente'] ?>" role="button"><i class="fa fa-trash-o"></i> </a>
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
                    
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrar_dentista" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_receita">Cadastrar Dentista</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Nome</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="nascimento">Nascimento</label>
                                                        <input type="date" class="form-control" id="nascimento" name="nascimento" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="sexo">Sexo</label>
                                                    <select class="form-control p-0" id="sexo" name="sexo" required>
                                                        <option></option>
                                                        <option>Masculino</option>
                                                        <option>Feminino</option>
                                                        <option>Outros</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cpf">CPF</label>
                                                        <input type="text" class="form-control" id="cpf" name="cpf" OnKeyPress="formatar('###.###.###-##', this)" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label for="celular">Celular</label>
                                                    <input type="text" class="form-control" id="celular" name="celular" OnKeyPress="formatar('##-#####-####', this)">
                                                    <span class="bar"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="idespecialidade">Especialidade</label>
                                                        <select class="form-control p-0" id="idespecialidade" name="idespecialidade" required>
                                                            <option></option>
                                                            <?php 
                                                            $q = mysqli_query($con,"SELECT * FROM especialidade order by descricao") or die(mysqli_error());	 
                                                            if(mysqli_num_rows($q)){ 
                                                            //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                            while($line = mysqli_fetch_array($q)) 
                                                            { 
                                                            echo "<option value='".$line['idespecialidade']."'>".utf8_encode($line['descricao'])."</option>";
                                                            } 
                                                            }
                                                             else {//Caso não haja resultados 
                                                            echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                            } 	
                                                            ?>		
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cep">CEP</label>
                                                        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP">
                                                        <span class="bar"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="endereco">Endereço</label>
                                                        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="numero">Numero</label>
                                                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Numero">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bairro">Bairro</label>
                                                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="cidade">Cidade</label>
                                                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="estado">Estado</label>
                                                        <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="comissao">Comissão(%)</label>
                                                        <select class="form-control p-0" id="comissao" name="comissao" required>
                                                            <option></option>
                                                            <option value="10">5%</option>
                                                            <option value="15">10%</option>
                                                            <option value="20">20%</option>
                                                            <option value="25">25%</option>
                                                        </select>
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
                    
                            <?php foreach($dados as $aqui){ ?>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_receita<?php echo $aqui['idreceita']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_receita">Cadastrar Receita</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="valor">Medicamentos</label>
                                                        <input type="text" class="form-control" id="medicamentos" name="medicamentos" value="<?php echo $aqui['medicamentos'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="modo_usar">Modo de Usar</label>
                                                        <textarea class="form-control" rows="3" id="modo_usar" name="modo_usar"required><?php echo $aqui['modo_usar'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="data_receita">Data Receita</label>
                                                        <input type="text" class="form-control" id="data_receita" name="data_receita" value="<?php echo $aqui['data_receita'] ?>" required>
                                                        <input type="hidden" name="resp_receita" id="resp_receita" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
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
