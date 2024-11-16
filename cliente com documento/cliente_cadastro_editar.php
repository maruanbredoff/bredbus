<!DOCTYPE html>
<html lang="en">

<head>
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
ini_set('display_errors',0);
include "../verificanivel.php";     
?>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <div id="main-wrapper">
        <div class="page-wrapper"> 
<?php  
$idcliente = $_GET['idcliente'];    
$query = sprintf("SELECT * from clientes where idcliente=$idcliente"); 

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

if($_POST){
      //$idcliente = $_POST['idcliente'];
      $nome = mysqli_real_escape_string($con,$_POST['nome']);
      $documento = mysqli_real_escape_string($con,$_POST['documento']);
      $sexo = mysqli_real_escape_string($con,$_POST['sexo']);
      //$nascimento = $_POST['rg'];
      $nascimento = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['nascimento'])));
      $endereco = mysqli_real_escape_string($con,$_POST['endereco']);
      $numero = mysqli_real_escape_string($con,$_POST['numero']);
      $bairro = mysqli_real_escape_string($con,$_POST['bairro']);
      $estado = mysqli_real_escape_string($con,$_POST['estado']);
      $cidade = mysqli_real_escape_string($con,$_POST['cidade']);
      $cep = mysqli_real_escape_string($con,$_POST['cep']);  
      $celular = mysqli_real_escape_string($con,$_POST['celular']);
      $telefone = mysqli_real_escape_string($con,$_POST['telefone']);
      $email = mysqli_real_escape_string($con,$_POST['email']);  
      $passaporte = mysqli_real_escape_string($con,$_POST['passaporte']);
      //$data_cadastro = $_POST['data_cadastro']; 
      $data_cadastro = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['data_cadastro'])));
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      $atendente = mysqli_real_escape_string($con,$_POST['atendente']);  
      //if(isset($_FILES['foto'])){
          //$extensao = strtolower(substr($_FILES['foto']['name'],-4));
          //$nome_foto = md5(time()) . $extensao;
          //mkdir(__DIR__."../assets/img_pacientes/".$idcliente."/", 0740, true);
          //mkdir(dirname(__FILE__)."/assets/img_pacientes/$idcliente/", 0777, true);
          //$diretorio = "../assets/img_pacientes/".$idcliente."/";
         // $_UP['pasta'] = "../assets/img_pacientes/".$idcliente."/";
          //mkdir($_UP['pasta'],0777);
         // move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio.$nome_foto);
         // move_uploaded_file($_FILES['foto']['tmp_name'], $_UP['pasta'].$nome_foto);
      $cad = mysqli_query ($con,"UPDATE clientes  set nome = '$nome', documento = '$documento', sexo = '$sexo', nascimento = '$nascimento', endereco = '$endereco', numero = '$numero', bairro = '$bairro', estado = '$estado', cidade = '$cidade', cep = '$cep', celular = '$celular', telefone = '$telefone', email = '$email', passaporte = '$passaporte', data_cadastro = '$data_cadastro', obs = '$obs', atendente = '$atendente' WHERE idcliente = $idcliente") or die(mysqli_error($con)); 
          if(mysqli_affected_rows($con) == 1){ 
            include "../funcoes.php";
            criaLog("Paciente Editado", "Cadastro no paciente $idcliente");?>
             <div class="alert alert-success"> 
                 Cadastro Editado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                   echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=cliente_listar.php'>";   
                          
            }
          else{ ?>
                <div class="alert alert-danger alert-rounded">
                    <i class="ti-user"></i> Erro. Ocorreu algum problema no Cadastro!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
        <?php }
}
        
?>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Cadastro de Paciente</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                        <li class="breadcrumb-item">Cadastro</li>
                        <li class="breadcrumb-item active"><?php echo $linha['nome']?></li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                           
    <?php if($linhausuario["nivel"]!=1){ ?>                         
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="cliente_cadastro_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Paciente</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="tratamento.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-hospital"></i>Passagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Financeiro</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro_parcelas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_imagens.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-image-album"></i> Imagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_receitas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-bulletin-board"></i>Receitas</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_atestado.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-bulletin-board"></i>Atestado</a>
                                      </li>
                                    </ul>
<?php } 
else {?>
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="cliente_cadastro_ver.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Paciente</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="tratamento.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-hospital"></i>Passagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Financeiro</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_financeiro_parcelas.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-cash-multiple"></i> Parcelas</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="cliente_imagens.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-image-album"></i> Imagens</a>
                                      </li>
                                    </ul>
<?php } ?>
                            <div class="card-body wizard-content">
                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                    <div class="form-group m-b-40 col-md-7">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $linha['nome'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="nascimento">Nascimento</label>
                                        <input type="date" class="form-control" id="nascimento" name="nascimento" value="<?php echo $linha['nascimento'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                        <label for="sexo">Sexo</label>
                                        <select class="form-control p-0" id="sexo" name="sexo">
                                            <option value="<?php echo $linha['sexo'] ?>"><?php echo $linha['sexo'] ?></option>
                                            <option>Masculino</option>
                                            <option>Feminino</option>
                                        </select><span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="cpf">Documento</label>
                                        <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $linha['documento'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $linha['celular'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="telefone">Telefone</label>
                                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $linha['telefone'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                        <label for="cep">CEP</label>
                                        <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $linha['cep'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-8">
                                        <label for="endereco">Endereço</label>
                                        <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $linha['endereco'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                        <label for="numero">Numero</label>
                                        <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $linha['numero'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $linha['bairro'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $linha['cidade'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="estado">Estado</label>
                                        <input type="text" class="form-control" id="estado" name="estado" value="<?php echo $linha['estado'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $linha['email'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="obs">Observação</label>
                                        <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $linha['obs'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="data_cadastro">Data do Cadastro</label>
                                        <input type="text" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $linha['data_cadastro'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                        <label for="passaporte">Passaporte</label>
                                        <input type="text" class="form-control" id="passaporte" name="passaporte" value="<?php echo $linha['passaporte'] ?>">
                                        <input type="hidden" class="form-control" id="atendente" name="atendente" value="<?php echo $linha['atendente'] ?>">
                                        <span class="bar"></span>
                                    </div>
                                           <div class="form-group m-b-40 col-md-12">
                                            <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
<?php 
include "../rodape.php";
?>
        </div>

    </div>
    <!-- ============================================================== -->

</body>

</html>
