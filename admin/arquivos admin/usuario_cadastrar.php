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

$query = sprintf("select * from usuario u, usuario_nivel n where u.nivel = n.idnivel"); 

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
                        <li class="breadcrumb-item active">Usuario</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
<?php
if($_POST){
      $u_nome = mysqli_real_escape_string($con,$_POST['u_nome']);
      $usuario = mysqli_real_escape_string($con,$_POST['usuario']);
      $senha = mysqli_real_escape_string($con,$_POST['senha']);
      //$data_cadastro = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['data_cadastro'])));
      $nivel = mysqli_real_escape_string($con,$_POST['nivel']); 
      $ativo = mysqli_real_escape_string($con,$_POST['ativo']); 
      $altera_senha = mysqli_real_escape_string($con,$_POST['altera_senha']); 
      $iddentista = mysqli_real_escape_string($con,$_POST['iddentista']); 
      $resp_cadastro = mysqli_real_escape_string($con,$_POST['resp_cadastro']); 
    
    //Insere na tabela pagamentos
          $cad = mysqli_query($con,"INSERT INTO usuario(id_usuario,u_nome,usuario,senha,data_cadastro,nivel,ativo,altera_senha,iddentista,resp_cadastro) values(NULL,'$u_nome','$usuario',SHA1('$senha'),now(),'$nivel','$ativo','$altera_senha','$iddentista','$resp_cadastro') ") or die(mysqli_error($con)); 

if($cad) {?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=cadastrar_usuario.php'>";    
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
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#cadastrar_usuario">Cadastrar Usuario</button>
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                  <th>ID</th>
                                                  <th>Nome</th>
                                                  <th>Nivel</th>
                                                  <th>Data cadastro</th>
                                                  <th>Login</th>
                                                  <th>Ativo</th>
                                                  <th>Ação</th>
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
                                                    <td><?php echo $linha['id_usuario']?> </td>
                                                    <td><?php echo $linha['u_nome']?></td>
                                                    <td><?php echo $linha['u_nivel']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['data_cadastro'])); ?></td>
                                                    <td><?php echo $linha['usuario'] ?></td> 
                                                    <td>
                                                    <?php if ($linha["ativo"] == 1){ ?>
                                                    <?php echo "Sim"; ?>
                                                    <?php } 
                                                    else 
                                                        echo "Não";     
                                                    ?>
                                                    </td> 
                                                    <td width="108">
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#editar_usuario<?php echo $linha['id_usuario']?>"><i class="fa fa-edit"></i> </a>
                                                    <a class="btn btn-danger btn-circle" onclick="return confirm('Deseja realmente excluir Esse Usuario?!')" href="usuario_delete.php?id_usuario=<?php echo $linha['id_usuario'] ?>" role="button"><i class="fa fa-trash-o"></i> </a>
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
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrar_usuario" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_receita">Cadastrar Usuario</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="u_nome">Nome</label>
                                                        <input type="text" class="form-control" id="u_nome" name="u_nome" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="usuario">Usuario</label>
                                                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label for="senha">Senha</label>
                                                        <input type="password" class="form-control" id="senha" name="senha" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="cpf">Nivel</label>
                                                        <select class="form-control p-0" name="nivel" id="nivel" required>
                                                          <option></option>
                                                          <option value="1">Funcionario</option> 
                                                          <option value="2">Dentista</option>
                                                          <option value="10">Admin</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="ativo">Usuario Ativo</label>
                                                        <select class="form-control p-0" name="ativo" id="ativo" required>
                                                          <option value="" disabled selected></option>
                                                          <option value="1">Sim</option>
                                                          <option value="0">Não</option>
                                                        </select>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <label for="altera_senha">Alterar Senha</label>
                                                    <select class="form-control p-0" name="altera_senha" id="altera_senha" required>
                                                      <option value="" disabled selected></option>
                                                      <option value="1">Sim</option>
                                                      <option value="0">Não</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            <div class="col-md-9" style="visibility:hidden;">
                                                <div class="form-group">
                                                        <label for="iddentista">Dentista</label>
                                                        <select class="form-control p-0" id="iddentista" name="iddentista" required>
                                                            <option></option>
                                                            <?php 
                                                            $q = mysqli_query($con,"SELECT * FROM dentista order by nome") or die(mysqli_error());	 
                                                            if(mysqli_num_rows($q)){ 
                                                            //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                            while($line = mysqli_fetch_array($q)) 
                                                            { 
                                                            echo "<option value='".$line['iddentista']."'>".utf8_encode($line['nome'])."</option>";
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
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Cadastrar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    
                            <?php foreach($dados as $aqui){ ?>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_usuario<?php echo $aqui['id_usuario']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_receita">Cadastrar Usuario </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="usuario_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="u_nome">Nome</label>
                                                        <input type="text" class="form-control" id="u_nome" name="u_nome" value="<?php echo $aqui['u_nome'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="usuario">Usuario</label>
                                                        <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $aqui['usuario'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cpf">Nivel</label>
                                                        <select class="form-control p-0" name="nivel" id="nivel" required>
                                                <?php if($aqui['nivel']==1) {?>            
                                                          <option value="1">Funcionario</option> 
                                                          <option value="2">Dentista</option>
                                                          <option value="10">Admin</option>
                                                <?php} elseif($aqui['nivel']==2) {?>
                                                          <option value="2">Dentista</option> 
                                                          <option value="1">Funcionario</option>
                                                          <option value="10">Admin</option><?php } 
                                                else {?>
                                                          <option value="10">Admin</option> 
                                                          <option value="1">Funcionario</option>
                                                          <option value="2">Dentista</option><?php }?> 
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="ativo">Usuario Ativo</label>
                                                        <select class="form-control p-0" name="ativo" id="ativo" required>
                                                        <?php if($aqui['ativo']==1) {?>
                                                          <option value="1">Sim</option> 
                                                          <option value="0">Não</option><?php } 
                                                           else {?>
                                                          <option value="0">Não</option>
                                                          <option value="1">Sim</option><?php } ?>
                                                        </select>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                    <label for="altera_senha">Alterar Senha</label>
                                                    <select class="form-control p-0" name="altera_senha" id="altera_senha" required>
                                                        <?php if($aqui['altera_senha']==1) {?>
                                                          <option value="1">Sim</option> 
                                                          <option value="0">Não</option><?php } 
                                                           else {?>
                                                          <option value="0">Não</option>
                                                          <option value="1">Sim</option><?php } ?>
                                                    </select>
                                                    </div>
                                                </div>
                                            <?php
                                                if($linha['iddentista']!=' '){
                                                ?>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                        <label for="iddentista">Dentista</label>
                                                        <select class="form-control p-0" id="iddentista" name="iddentista" required>
                                                            <option></option>
                                                            <?php 
                                                            $q = mysqli_query($con,"SELECT * FROM dentista order by nome") or die(mysqli_error());	 
                                                            if(mysqli_num_rows($q)){ 
                                                            //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                            while($line = mysqli_fetch_array($q)) 
                                                            { 
                                                            echo "<option value='".$line['iddentista']."'>".utf8_encode($line['nome'])."</option>";
                                                            } 
                                                            }
                                                             else {//Caso não haja resultados 
                                                            echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                            } 	
                                                            ?>		
                                                        </select> 
                                                </div>
                                                <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $aqui['id_usuario'] ?>" required>
                                            </div>
                                            <?php } ?>
                                        </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Editar</button>
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
