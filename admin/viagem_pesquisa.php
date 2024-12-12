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
$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID']; 
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
                                <center><h4 class="card-title">Lista de Viagens</h4></center>
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
                                    <?php if($usuario_nivel > 2) { ?>
                                    <div class="form-group m-b-40 col-md-3">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastrarviagem">+ Nova Viagem</button>
                                    </div>
                                <?php } ?>
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

// consulta antes do POST
$sql_dados2 = "SELECT v.idviagem, v.motorista1, v.motorista2, v.dataviagem, v.horaviagem, 
                      b.tipo, b.lugares, b.idbus, b.descricao, v.obs, 
                      c1.nome AS corigem, e1.uf AS uforigem, 
                      c2.nome AS cdestino, e2.uf AS ufdestino, r.idrota
               FROM viagem v
               INNER JOIN rota r ON r.idrota = v.idrota
               INNER JOIN bus b ON b.idbus = v.idbus
               INNER JOIN cidades c1 ON c1.id = r.corigem
               INNER JOIN cidades c2 ON c2.id = r.cdestino
               INNER JOIN estados e1 ON e1.id = r.uforigem
               INNER JOIN estados e2 ON e2.id = r.ufdestino
               WHERE v.dataviagem = ? AND v.idcontrato = ?";

$stmt_dados2 = $con->prepare($sql_dados2);
$stmt_dados2->bind_param("si", $hoje, $idcontrato);
$stmt_dados2->execute();
$dados2 = $stmt_dados2->get_result();

// Transforma os dados em um array
$linha2 = $dados2->fetch_assoc();

// Calcula quantos dados retornaram
$total2 = $dados2->num_rows;

$idviagem2 = $linha2['idviagem'] ?? null; // Verificação para evitar erro se $linha2 estiver vazio

// Assegure-se de que a consulta é executada antes e que $dados é inicializado
//$dados = []; // Inicialize como array vazio para evitar o erro



// ----------------------- Consulta Usuário ----------------------------
$sql_usuarios = "SELECT u.nivel 
                 FROM usuario u 
                 INNER JOIN usuario_contrato uc ON uc.idcontrato = u.idcontrato 
                 WHERE u.id_usuario = ? AND u.idcontrato = ?";

$stmt_usuarios = $con->prepare($sql_usuarios);
$stmt_usuarios->bind_param("ii", $usuarioid, $idcontrato);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->get_result();

// Transforma os dados em um array
$linhausuario = $usuarios->fetch_assoc();

$stmt_usuarios->close();

// ----------------------- Consulta após o POST ------------------------
if ($_POST) { 
    $dataviagem = $_POST['dataviagem'];
    
    // Preparando a consulta para a data de viagem enviada via POST
    $sql_dados = "SELECT v.idviagem, v.motorista1, v.motorista2, v.dataviagem, v.horaviagem, 
                         b.tipo, b.lugares, b.idbus, b.descricao, v.obs, 
                         c1.nome AS corigem, e1.uf AS uforigem, 
                         c2.nome AS cdestino, e2.uf AS ufdestino, r.idrota
                  FROM viagem v
                  INNER JOIN rota r ON r.idrota = v.idrota
                  INNER JOIN bus b ON b.idbus = v.idbus
                  INNER JOIN cidades c1 ON c1.id = r.corigem
                  INNER JOIN cidades c2 ON c2.id = r.cdestino
                  INNER JOIN estados e1 ON e1.id = r.uforigem
                  INNER JOIN estados e2 ON e2.id = r.ufdestino
                  WHERE v.dataviagem = ? AND v.idcontrato = ?";

    $stmt_dados = $con->prepare($sql_dados);
    $stmt_dados->bind_param("si", $dataviagem, $idcontrato);
    $stmt_dados->execute();
    $dados = $stmt_dados->get_result();

    // Transforma os dados em um array
    $linha = $dados->fetch_assoc();

    // Calcula quantos dados retornaram
    $total = $dados->num_rows;
  
    $idviagem3 = $linha['idviagem'] ?? null; // Verificação para evitar erro se $linha estiver vazio    

?>

                                        <table id="" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>          
                                                    <th>Dt. Partida</th>
                                                    <th>Hora Embarq.</th>
                                                    <th>Linha</th>
                                                    <th>Ônibus</th>
                                                    <th>obs</th>
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
                                                    <td><?php echo $linha['descricao']?></td>
                                                    <td><?php echo $linha['obs']?></td>
                                                    <td>
                                                    <a href="passagem.php?idviagem=<?php echo $linha['idviagem'] ?>"  class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i> </a>
                                                    <a href="pdf_passageiros2.php?idviagem=<?php echo $linha['idviagem'] ?>" target="_blank" class="btn btn-primary btn-circle" role="button"><i class="mdi mdi-bus"></i> </a>
                                                    <a href="pdf_passageiros_mae.php?idviagem=<?php echo $linha['idviagem'] ?>" target="_blank" class="btn btn-warning btn-circle" role="button"><i class="mdi mdi-bus"></i> </a>
                                                    <a href="print_listadeer.php?idviagem=<?php echo $linha['idviagem'] ?>" target="_blank" class="btn btn-success btn-circle" role="button"><i class="fa fa-file-archive-o"></i> </a> 
                                                    <?php if($qtdencomenda > 0) {?>
                                                    <a href="pdf_encomendas2.php?idviagem=<?php echo $linha['idviagem'] ?>" target="_blank" class="btn btn-warning btn-circle" role="button"><i class="mdi mdi-package-variant"></i> </a> 
                                            <?php } ?>
                                                    <?php if($linhausuario["nivel"]>=9){ ?> 
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#viagem_editar2<?php echo $linha['idviagem']?>"><i class="fa fa-edit"></i></a> 
                                                    <a class="btn btn-danger btn-circle" onclick="return confirm('Deseja realmente excluir Essa Viagem?!')" href="viagem_deletar.php?idviagem=<?php echo $linha['idviagem'] ?>" role="button"><i class="fa fa-trash-o"></i> </a> <?php } ?>
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
                                                $dadosencomendas2 = mysqli_query($con,"select count(*) as qtdencomenda2
                                                from viagem_encomenda ve
                                                inner join viagem v on v.idviagem = ve.idviagem
                                                where ve.idviagem = $idviagem2") or die(mysqli_error($con)); 

                                                // transforma os dados em um array 
                                                $linha_encomendas2 = mysqli_fetch_assoc($dadosencomendas2); 

                                                $qtdencomenda2 = $linha_encomendas2['qtdencomenda2'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha2['idviagem']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha2['dataviagem'])); ?></td>
                                                    <td><?php echo $linha2['horaviagem']?></td>
                                                    <td><?php echo $linha2['corigem']."->".$linha2['cdestino']?></td>
                                                    <td><?php echo $linha2['descricao']?></td>
                                                    <td><?php echo $linha2['obs']?></td>
                                                    <td>
                                                    <a href="passagem.php?idviagem=<?php echo $linha2['idviagem'] ?>"  class="btn btn-info btn-circle" role="button"><i class="fa fa-search"></i> </a>
                                                    <a href="pdf_passageiros2.php?idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-primary btn-circle" role="button"><i class="mdi mdi-bus"></i> </a>
                                                    <a href="print_listadeer.php?idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-success btn-circle" role="button"><i class="fa fa-file-archive-o"></i> </a> 
                                                    <?php if($qtdencomenda2 > 0) {?>
                                                    <a href="pdf_encomendas2.php?idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-warning btn-circle" role="button"><i class="mdi mdi-package-variant"></i> </a> <?php } ?>
                                                    <?php if($linhausuario["nivel"]==10){ ?> 
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#viagem_editar<?php echo $linha2['idviagem']?>"><i class="fa fa-edit"></i></a> 
                                                    <a class="btn btn-danger btn-circle" onclick="return confirm('Deseja realmente excluir Essa Viagem?!')" href="viagem_deletar.php?idviagem=<?php echo $linha2['idviagem'] ?>" role="button"><i class="fa fa-trash-o"></i> </a> <?php } ?>
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
                                                            // Prepara a consulta SQL
                                                            $sql_rota = "SELECT r.idrota, r.obs, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino 
                                                                         FROM rota r
                                                                         INNER JOIN cidades c1 ON c1.id = r.corigem
                                                                         INNER JOIN cidades c2 on c2.id = r.cdestino
                                                                         INNER JOIN estados e1 on e1.id = r.uforigem
                                                                         INNER JOIN estados e2 on e2.id = r.ufdestino
                                                                         WHERE r.idcontrato = ?";

                                                            // Preparando o statement
                                                            $stmt_rota = $con->prepare($sql_rota);
                                                            $stmt_rota->bind_param("i", $idcontrato); // Vincula o parâmetro do idcontrato
                                                            $stmt_rota->execute();
                                                            $result_rota = $stmt_rota->get_result(); // Obtém o resultado

                                                            // Verifica se há resultados
                                                            if ($result_rota->num_rows > 0) {
                                                                // Loop para preencher o select com as opções de rotas
                                                                while ($line = $result_rota->fetch_assoc()) {
                                                                    echo "<option value='" . $line['idrota'] . "'>" . $line['corigem'] . " -> " . $line['cdestino'] . "</option>";
                                                                }
                                                            } else {
                                                                // Caso não haja resultados
                                                                echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                            }

                                                            // Fecha o statement
                                                            $stmt_rota->close();
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
                                                                // Consulta preparada para selecionar ônibus vinculados ao idcontrato
                                                                $sql_bus = "SELECT idbus, descricao FROM bus WHERE idcontrato = ? ORDER BY lugares";
                                                                $stmt_bus = $con->prepare($sql_bus);
                                                                $stmt_bus->bind_param("i", $idcontrato); // Vincula o parâmetro do idcontrato
                                                                $stmt_bus->execute();
                                                                $result_bus = $stmt_bus->get_result(); // Obtém o resultado

                                                                // Verifica se há resultados
                                                                if ($result_bus->num_rows > 0) {
                                                                    while ($line = $result_bus->fetch_assoc()) {
                                                                        echo "<option value='" . $line['idbus'] . "'>" . $line['descricao'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }

                                                                // Fecha o statement
                                                                $stmt_bus->close();
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
                                                                // Consulta preparada para selecionar motoristas vinculados ao idcontrato
                                                                $sql_motorista = "SELECT nome FROM motorista WHERE idcontrato = ? ORDER BY nome";
                                                                $stmt_motorista = $con->prepare($sql_motorista);
                                                                $stmt_motorista->bind_param("i", $idcontrato); // Vincula o parâmetro do idcontrato
                                                                $stmt_motorista->execute();
                                                                $result_motorista = $stmt_motorista->get_result(); // Obtém o resultado

                                                                // Verifica se há resultados
                                                                if ($result_motorista->num_rows > 0) {
                                                                    while ($line = $result_motorista->fetch_assoc()) {
                                                                        echo "<option value='" . $line['nome'] . "'>" . $line['nome'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }

                                                                // Fecha o statement
                                                                $stmt_motorista->close();
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
                                                        // Consulta preparada para selecionar motoristas vinculados ao idcontrato
                                                        $sql_motorista2 = "SELECT nome FROM motorista WHERE idcontrato = ? ORDER BY nome";
                                                        $stmt_motorista2 = $con->prepare($sql_motorista2);
                                                        $stmt_motorista2->bind_param("i", $idcontrato); // Vincula o parâmetro do idcontrato
                                                        $stmt_motorista2->execute();
                                                        $result_motorista2 = $stmt_motorista2->get_result(); // Obtém o resultado

                                                        // Verifica se há resultados
                                                        if ($result_motorista2->num_rows > 0) {
                                                            while ($line = $result_motorista2->fetch_assoc()) {
                                                                echo "<option value='" . $line['nome'] . "'>" . $line['nome'] . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                        }

                                                        // Fecha o statement
                                                        $stmt_motorista2->close();
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

                <?php foreach($dados as $aqui3){ 
                    $rota = $aqui3['corigem']." - ".$aqui3['uforigem']." - ".$aqui3['cdestino']." - ".$aqui3['ufdestino'];
                    ?> 
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
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="rota">Linha / Rota</label>
                                                            <select class="custom-select form-control" name="idrota" id="idrota" required>
                                                                <option value="<?php echo htmlspecialchars($aqui3['idrota']); ?>">
                                                                    <?php echo htmlspecialchars($rota); ?>
                                                                </option>
                                                                <?php 
                                                                // Prepara a consulta
                                                                $stmt = $con->prepare("SELECT r.idrota, r.obs, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino 
                                                                                    FROM rota r
                                                                                    INNER JOIN cidades c1 ON c1.id = r.corigem
                                                                                    INNER JOIN cidades c2 ON c2.id = r.cdestino
                                                                                    INNER JOIN estados e1 ON e1.id = r.uforigem
                                                                                    INNER JOIN estados e2 ON e2.id = r.ufdestino
                                                                                    where r.idcontrato = $idcontrato");

                                                                // Executa a consulta
                                                                $stmt->execute();

                                                                // Vincula o resultado
                                                                $result = $stmt->get_result();

                                                                if ($result->num_rows > 0) {
                                                                    // Preenche o campo com os resultados
                                                                    while ($line = $result->fetch_assoc()) {
                                                                        echo "<option value='" . htmlspecialchars($line['idrota']) . "'>"
                                                                            . htmlspecialchars($line['corigem']) . " -> " . htmlspecialchars($line['cdestino']) . 
                                                                            "</option>";
                                                                    }
                                                                } else {
                                                                    // Caso não haja resultados
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
                                                            <label for="motorista1">Motorista 1</label>
                                                            <select class="form-control" name="motorista1" id="motorista1">
                                                                <option value="<?php echo $aqui3['motorista1']; ?>"><?php echo $aqui3['motorista1']; ?></option>
                                                                <?php 
                                                                $sql_motorista1 = "SELECT nome FROM motorista WHERE idcontrato = ? ORDER BY nome";
                                                                $stmt_motorista1 = $con->prepare($sql_motorista1);
                                                                $stmt_motorista1->bind_param("i", $idcontrato);
                                                                $stmt_motorista1->execute();
                                                                $result_motorista1 = $stmt_motorista1->get_result();

                                                                if ($result_motorista1->num_rows > 0) {
                                                                    while ($line = $result_motorista1->fetch_assoc()) {
                                                                        echo "<option value='" . $line['nome'] . "'>" . $line['nome'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }
                                                                $stmt_motorista1->close();
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="motorista2">Motorista 2</label>
                                                            <select class="form-control" name="motorista2" id="motorista2">
                                                                <option value="<?php echo $aqui3['motorista2']; ?>"><?php echo $aqui3['motorista2']; ?></option>
                                                                <?php 
                                                                $sql_motorista2 = "SELECT nome FROM motorista WHERE idcontrato = ? ORDER BY nome";
                                                                $stmt_motorista2 = $con->prepare($sql_motorista2);
                                                                $stmt_motorista2->bind_param("i", $idcontrato);
                                                                $stmt_motorista2->execute();
                                                                $result_motorista2 = $stmt_motorista2->get_result();

                                                                if ($result_motorista2->num_rows > 0) {
                                                                    while ($line = $result_motorista2->fetch_assoc()) {
                                                                        echo "<option value='" . $line['nome'] . "'>" . $line['nome'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }
                                                                $stmt_motorista2->close();
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
                                                                <option value="<?php echo $aqui3['idbus']; ?>"><?php echo $aqui3['descricao']; ?></option>
                                                                <?php 
                                                                $sql_bus = "SELECT idbus, descricao FROM bus WHERE idcontrato = ?";
                                                                $stmt_bus = $con->prepare($sql_bus);
                                                                $stmt_bus->bind_param("i", $idcontrato);
                                                                $stmt_bus->execute();
                                                                $result_bus = $stmt_bus->get_result();

                                                                if ($result_bus->num_rows > 0) {
                                                                    while ($line = $result_bus->fetch_assoc()) {
                                                                        echo "<option value='" . $line['idbus'] . "'>" . $line['descricao'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }
                                                                $stmt_bus->close();
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
                                
                         <?php  }  ?> 

                <?php foreach($dados2 as $aqui4){ 
                    $rota = $aqui4['corigem']." - ".$aqui4['uforigem']." - ".$aqui4['cdestino']." - ".$aqui4['ufdestino'];
                    ?> 
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
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="rota">Linha / Rota</label>
                                                            <select class="custom-select form-control" name="idrota" id="idrota" required>
                                                                <option value="<?php echo htmlspecialchars($aqui4['idrota']); ?>">
                                                                    <?php echo htmlspecialchars($rota); ?>
                                                                </option>
                                                                <?php 
                                                                // Prepara a consulta
                                                                $stmt = $con->prepare("SELECT r.idrota, r.obs, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino 
                                                                                    FROM rota r
                                                                                    INNER JOIN cidades c1 ON c1.id = r.corigem
                                                                                    INNER JOIN cidades c2 ON c2.id = r.cdestino
                                                                                    INNER JOIN estados e1 ON e1.id = r.uforigem
                                                                                    INNER JOIN estados e2 ON e2.id = r.ufdestino
                                                                                    where r.idcontrato = $idcontrato");

                                                                // Executa a consulta
                                                                $stmt->execute();

                                                                // Vincula o resultado
                                                                $result = $stmt->get_result();

                                                                if ($result->num_rows > 0) {
                                                                    // Preenche o campo com os resultados
                                                                    while ($line = $result->fetch_assoc()) {
                                                                        echo "<option value='" . htmlspecialchars($line['idrota']) . "'>"
                                                                            . htmlspecialchars($line['corigem']) . " -> " . htmlspecialchars($line['cdestino']) . 
                                                                            "</option>";
                                                                    }
                                                                } else {
                                                                    // Caso não haja resultados
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
                                                     <label for="motorista1">Motorista 1</label>
                                                    <select class="form-control" name="motorista1" id="motorista1">
                                                        <option value="<?php echo $aqui4['motorista1'] ?>" ><?php echo $aqui4['motorista1'] ?></option>
                                                        <?php 
                                                        $q = mysqli_query($con,"SELECT * FROM motorista where idcontrato = $idcontrato order by nome") or die(mysqli_error());    
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
                                                        $q = mysqli_query($con,"SELECT * FROM motorista where idcontrato = $idcontrato order by nome") or die(mysqli_error());    
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
                                                        $q = mysqli_query($con,"SELECT * FROM bus where idcontrato = $idcontrato") or die(mysqli_error());    
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
