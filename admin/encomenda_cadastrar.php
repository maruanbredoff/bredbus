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
$usuario_nivel = $_SESSION['UsuarioNivel'];
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

<?php
if(isset($_SESSION['msg'])){
echo $_SESSION['msg'];
unset($_SESSION['msg']);
}
 
?>
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                                 <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <center><h4 class="card-title">Procurar Viagens</h4></center>
                                <form class="form-material m-t-40 row" action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="dataviagem">Data</label>
                                        <input type="date" class="form-control" id="dataviagem" name="dataviagem">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <input type="submit" class="btn btn-info" value="Pesquisar">
                                    </div>
                                    <div class="form-group m-b-40 col-md-2">
                                    </div>
                                </form>
                            </div>
                     </div>
                    </div>
                    <div class="col-12">                    
                        <div class="card">
                                <div class="card-body">
                                    <center><h4>Viagens Encontradas</h4></center>
                                    <div class="table-responsive m-t-40">
<?php 
    $hoje = date('Y/m/d');                  
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];

// Definindo o valor da data de hoje
$hoje = date("Y-m-d");

// Consulta de viagens antes do POST
$sql_viagens_hoje = "
    SELECT v.idviagem, v.motorista1, v.motorista2, v.dataviagem, v.horaviagem, 
           b.tipo, b.lugares, b.idbus, b.descricao, v.obs, 
           c1.nome as corigem, e1.uf as uforigem, 
           c2.nome as cdestino, e2.uf as ufdestino, v.idcontrato
    FROM viagem v
    INNER JOIN rota r ON r.idrota = v.idrota
    INNER JOIN bus b ON b.idbus = v.idbus
    INNER JOIN cidades c1 ON c1.id = r.corigem
    INNER JOIN cidades c2 ON c2.id = r.cdestino
    INNER JOIN estados e1 ON e1.id = r.uforigem
    INNER JOIN estados e2 ON e2.id = r.ufdestino
    WHERE v.dataviagem = ? AND v.idcontrato = ?";

$stmt_viagens_hoje = $con->prepare($sql_viagens_hoje);
$stmt_viagens_hoje->bind_param("si", $hoje, $idcontrato);
$stmt_viagens_hoje->execute();
$dados2 = $stmt_viagens_hoje->get_result();
$linha2 = $dados2->fetch_assoc();
$total2 = $dados2->num_rows;

$idviagem2 = $linha2['idviagem'];

// Consulta de nível do usuário
$sql_usuario = "SELECT nivel FROM usuario WHERE id_usuario = ?";
$stmt_usuario = $con->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $usuarioid);
$stmt_usuario->execute();
$usuarios = $stmt_usuario->get_result();
$linhausuario = $usuarios->fetch_assoc();

$stmt_viagens_hoje->close();
$stmt_usuario->close();

if ($_POST) {
    $dataviagem = $_POST['dataviagem'];

    // Consulta de viagens para uma data específica
    $sql_viagens_data = "
        SELECT v.idviagem, v.motorista1, v.motorista2, v.dataviagem, v.horaviagem, 
               b.tipo, b.lugares, b.idbus, b.descricao, v.obs, 
               c1.nome as corigem, e1.uf as uforigem, 
               c2.nome as cdestino, e2.uf as ufdestino, v.idcontrato
        FROM viagem v
        INNER JOIN rota r ON r.idrota = v.idrota
        INNER JOIN bus b ON b.idbus = v.idbus
        INNER JOIN cidades c1 ON c1.id = r.corigem
        INNER JOIN cidades c2 ON c2.id = r.cdestino
        INNER JOIN estados e1 ON e1.id = r.uforigem
        INNER JOIN estados e2 ON e2.id = r.ufdestino
        WHERE v.dataviagem = ? AND v.idcontrato = ?";

    $stmt_viagens_data = $con->prepare($sql_viagens_data);
    $stmt_viagens_data->bind_param("si", $dataviagem, $idcontrato);
    $stmt_viagens_data->execute();
    $dados = []; // Inicializa como array vazio para evitar erros
    //$dados = $stmt_viagens_data->get_result();
    $linha = $dados->fetch_assoc();
    $total = $dados->num_rows;

    $idviagem3 = $linha['idviagem'];

// Se houver resultados, atribua-os a $dados
if ($result && $result->num_rows > 0) {
    $dados = $stmt_viagens_data->fetch_all(MYSQLI_ASSOC); // Preenche $dados com resultados como array associativo
}    
?>

                                        <table id="" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                                $sql_encomendas = "
                                                    SELECT COUNT(*) as qtdencomenda
                                                    FROM viagem_encomenda ve
                                                    INNER JOIN viagem v ON v.idviagem = ve.idviagem
                                                    WHERE ve.idviagem = ? AND ve.idcontrato = ?";

                                                $stmt_encomendas = $con->prepare($sql_encomendas);
                                                $stmt_encomendas->bind_param("ii", $idviagem, $idcontrato);
                                                $stmt_encomendas->execute();

                                                // Obtenção do resultado
                                                $dadosencomendas = $stmt_encomendas->get_result();
                                                $linha_encomendas = $dadosencomendas->fetch_assoc();

                                                $qtdencomenda = $linha_encomendas['qtdencomenda'];

                                                // Fecha a consulta preparada
                                                $stmt_encomendas->close();
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha['idviagem']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['dataviagem'])); ?></td>
                                                    <td><?php echo $linha['horaviagem']?></td>
                                                    <td><?php echo $linha['corigem']."->".$linha['cdestino']?></td>
                                                    <td><?php echo $linha['descricao']?></td>
                                                    <td><?php echo $linha['obs']?></td>
                                                    <td>
                                                    <a href="encomenda_ver.php?idviagem=<?php echo $linha['idviagem'] ?>"  class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i> </a>
                                                    <?php if($qtdencomenda > 0) {?>
                                                    <a href="pdf_encomenda2.php?idviagem=<?php echo $linha['idviagem'] ?>" target="_blank" class="btn btn-warning btn-circle" role="button"><i class="mdi mdi-package-variant"></i> </a> <?php } ?>
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
 <?php } 
 else { ?>
                                        <table id="" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                            if($total2 > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do { 
                                                $idviagem2 = $linha2['idviagem'];

                                                // Consulta para contar a quantidade de encomendas associadas à viagem e ao contrato
                                                $sql_encomendas2 = "
                                                    SELECT COUNT(*) as qtdencomenda2
                                                    FROM viagem_encomenda ve
                                                    INNER JOIN viagem v ON v.idviagem = ve.idviagem
                                                    WHERE ve.idviagem = ? AND ve.idcontrato = ?";

                                                $stmt_encomendas2 = $con->prepare($sql_encomendas2);
                                                $stmt_encomendas2->bind_param("ii", $idviagem2, $idcontrato);
                                                $stmt_encomendas2->execute();

                                                // Obtenção do resultado
                                                $dadosencomendas2 = $stmt_encomendas2->get_result();
                                                $linha_encomendas2 = $dadosencomendas2->fetch_assoc();

                                                $qtdencomenda2 = $linha_encomendas2['qtdencomenda2'];

                                                // Fecha a consulta preparada
                                                $stmt_encomendas2->close();

                                            ?>
                                                <tr>
                                                    <td><?php echo $linha2['idviagem']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha2['dataviagem'])); ?></td>
                                                    <td><?php echo $linha2['horaviagem']?></td>
                                                    <td><?php echo $linha2['corigem']."->".$linha2['cdestino']?></td>
                                                    <td><?php echo $linha2['descricao']?></td>
                                                    <td><?php echo $linha2['obs']?></td>
                                                    <td>
                                                    <a href="encomenda_ver.php?idviagem=<?php echo $linha2['idviagem'] ?>"  class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i> </a>
                                                    <?php if($qtdencomenda2 > 0) {?>
                                                    <a href="pdf_encomenda2.php?idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-warning btn-circle" role="button"><i class="mdi mdi-package-variant"></i> </a> <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha2 = mysqli_fetch_assoc($dados2)); 
                                                    // fim do if 
                                                            } 
                                            ?> 
                                            </tbody>
                                        </table>
 <?php } ?>
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
                                                        $q = mysqli_query($con,"SELECT * FROM bus order by lugares") or die(mysqli_error());    
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
                                                        <input type="text" class="form-control" id="obs" name="obs">
                                                        <input type="hidden" class="form-control" id="atendente" name="atendente" value="<?php echo $_SESSION['UsuarioNome']?>">
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

                <?php if (!empty($dados)) {
    foreach ($dados as $aqui3) { ?> 
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="viagem_editar2<?php echo $aqui3['idviagem']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="viagem_editar">Editar Viagem pos post</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="viagem_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="motorista1">Motorista 1</label>
                                                    <select class="form-control" name="motorista1" id="motorista1">
                                                        <option value="<?php echo $aqui3['motorista1'] ?>" ><?php echo $aqui3['motorista1'] ?></option>
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
                                                     <label for="motorista2">Motorista 2</label>
                                                    <select class="form-control" name="motorista2" id="motorista2">
                                                        <option value="<?php echo $aqui3['motorista2'] ?>" ><?php echo $aqui3['motorista2'] ?></option>
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
                                                     <label for="idbus">Onibus</label>
                                                    <select class="custom-select form-control" name="idbus" id="idbus" required>
                                                        <option value="<?php echo $aqui3['idbus'] ?>" ><?php echo $aqui3['descricao'] ?></option>
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
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" <?php echo $aqui3['obs'] ?>>
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui3['idviagem'] ?>">
                                                        <input type="hidden" class="form-control" id="editado_por" name="editado_por" value="<?php echo $_SESSION['UsuarioNome']?>">
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="submit" name="confirmar" id="confirmar" class="btn btn-info">Confirmar</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                         <?php  } }  ?> 

                <?php foreach($dados2 as $aqui4){ ?> 
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="viagem_editar<?php echo $aqui4['idviagem']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="viagem_editar">Editar Viagem</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="viagem_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="motorista1">Motorista 1</label>
                                                    <select class="form-control" name="motorista1" id="motorista1">
                                                        <option value="<?php echo $aqui4['motorista1'] ?>" ><?php echo $aqui4['motorista1'] ?></option>
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
                                                     <label for="motorista2">Motorista 2</label>
                                                    <select class="form-control" name="motorista2" id="motorista2">
                                                        <option value="<?php echo $aqui4['motorista2'] ?>" ><?php echo $aqui4['motorista2'] ?></option>
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
                                                     <label for="idbus">Onibus</label>
                                                    <select class="custom-select form-control" name="idbus" id="idbus" required>
                                                        <option value="<?php echo $aqui4['idbus'] ?>" ><?php echo $aqui4['descricao'] ?></option>
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
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" <?php echo $aqui4['obs'] ?>>
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui4['idviagem'] ?>">
                                                        <input type="hidden" class="form-control" id="editado_por" name="editado_por" value="<?php echo $_SESSION['UsuarioNome']?>">
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="submit" name="confirmar" id="confirmar" class="btn btn-info">Confirmar</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
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
