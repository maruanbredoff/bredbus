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

$nivel_necessario = 9;
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

$query = sprintf("select u.id_usuario,u.u_nome,u.senha,u.nivel,u.usuario,u.ativo,u.data_cadastro,u.altera_senha,u.iddentista,u.resp_cadastro,n.u_nivel,d.nome
from usuario u
left join dentista d on d.iddentista = u.iddentista
inner join usuario_nivel n on n.idnivel = u.nivel"); 

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
      // inicio dos campos da tabela parcelas
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
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=usuario_cadastrar.php'>";    
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
                                                      <option value="Sim">Sim</option>
                                                      <option value="Nao">Não</option>
                                                    </select>
                                                    </div>
                                                </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                 <label for="sedentista">É Dentista?</label>
                                                    <select class="form-control p-0" name="sedentista" id="sedentista" required onchange="checkdentista()">
                                                        <option value=""></option>
                                                        <option value="1">Sim</option>
                                                        <option value="0">Não</option>
										          </select> 
                                                </div>
                                            </div>
                                            <div id="hiddendt" class="col-md-9" style="visibility:hidden;">
                                                <div class="form-group">
                                                        <label for="iddentista">Dentista</label>
                                                        <select class="form-control p-0" id="iddentista" name="iddentista">
                                                            <option>0</option>
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
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="editar_dentista<?php echo $aqui['iddentista']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrar_receita">Editar Dentista</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="dentista_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nome">Nome</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $aqui['nome'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="nascimento">Nascimento</label>
                                                        <input type="text" class="form-control" id="nascimento" name="nascimento" required value="<?php echo $aqui['nascimento'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="sexo">Sexo</label>
                                                    <select class="form-control p-0" id="sexo" name="sexo" required>
                                                        <option value="<?php echo $aqui['sexo'] ?>"><?php echo $aqui['sexo'] ?></option>
                                                        <option>Masculino</option>
                                                        <option>Feminino</option>
                                                        <option>Outros</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="cpf">CPF</label>
                                                        <input type="text" class="form-control" id="cpf" name="cpf" OnKeyPress="formatar('###.###.###-##', this)" value="<?php echo $aqui['cpf'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label for="celular">Celular</label>
                                                    <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $aqui['celular'] ?>" OnKeyPress="formatar('##-#####-####', this)">
                                                    <span class="bar"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="idespecialidade">Especialidade</label>
                                                        <select class="form-control p-0" id="idespecialidade" name="idespecialidade" required>
                                                            <option value="<?php echo $aqui['idespecialidade']?>"><?php echo $aqui['especialidade']?></option>
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
                                                        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" value="<?php echo $aqui['cep'] ?>">
                                                        <span class="bar"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="endereco">Endereço</label>
                                                        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" value="<?php echo $aqui['endereco'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="numero">Numero</label>
                                                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Numero" value="<?php echo $aqui['numero'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bairro">Bairro</label>
                                                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="<?php echo $aqui['bairro'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="cidade">Cidade</label>
                                                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="<?php echo $aqui['cidade'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="estado">Estado</label>
                                                        <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" value="<?php echo $aqui['estado'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="comissao">Comissão(%)</label>
                                                        <select class="form-control p-0" id="comissao" name="comissao" required>
                                                            <option value="<?php echo $aqui['comissao']?>"><?php echo $aqui['comissao']?>%</option>
                                                            <option value="5">5%</option>
                                                            <option value="10">10%</option>
                                                            <option value="15">15%</option>
                                                            <option value="20">20%</option>
                                                            <option value="25">25%</option>
                                                        </select>
                                                        <input type="hidden" name="resp_cadastro" id="resp_cadastro" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                        <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $datebr ?>" required>
                                                        <input type="hidden" class="form-control" id="iddentista" name="iddentista" value="<?php echo $aqui['iddentista'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Cadastrar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div></div>  
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
