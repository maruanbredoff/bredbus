<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Assentos do Ônibus</title>
    <link rel="stylesheet" href="../css/stylesbus.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
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
    <style>
        .error-message2 {
            color: red;
            display: none;
            font-size: 12px;
        }
    </style>
</head>

<body class="fix-header card-no-border">
<?php 
include "../verificanivel.php"; 
include "../funcoes.php"; 

$idcontrato = $_SESSION['ContratoID'];
$usuarioid = $_SESSION['UsuarioID'];
$idviagem = $_GET['idviagem'];

// Consulta principal para dados de passagem e viagem
$sql_dados2 = "SELECT DISTINCT p.idpassagem, r.idrota, p.embarque, p.desembarque, v.idviagem, v.dataviagem, v.horaviagem,
    SUBSTRING_INDEX(c.nome, ' ', 1) AS primeironome, SUBSTRING_INDEX(c.nome, ' ', -2) AS segundonome, 
    c.sexo, c.nascimento, c.documento, c.celular, p.poltrona, a.nome AS agencia, c.idcliente, 
    crm.idmovimento, crm.valor_total, p.hembarque, sc.situacao, c1.nome AS corigem, e1.uf AS uforigem, 
    c2.nome AS cdestino, e2.uf AS ufdestino, COALESCE(pe.nome, p.embarque) AS ponto_embarque, 
    pe.idembarque, v.obs AS obsviagem, c.org, crm.desconto, crm.idsituacao
FROM passagem p
INNER JOIN clientes c ON c.idcliente = p.idcliente
INNER JOIN viagem v ON p.idviagem = v.idviagem
INNER JOIN agencia a ON a.idagencia = p.idagencia
INNER JOIN rota r ON r.idrota = v.idrota
LEFT JOIN pontos_embarque pe ON pe.idembarque = p.idembarque
INNER JOIN contas_receb_movi crm ON crm.idpassagem = p.idpassagem
INNER JOIN situacao_caixa sc ON sc.idsituacao = crm.idsituacao
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 ON c2.id = r.cdestino
INNER JOIN estados e1 ON e1.id = r.uforigem
INNER JOIN estados e2 ON e2.id = r.ufdestino
WHERE v.idviagem = ? AND p.status_passagem <> 4 AND v.idcontrato = ?
ORDER BY c.nome";

$stmt_dados2 = $con->prepare($sql_dados2);
$stmt_dados2->bind_param("ii", $idviagem, $idcontrato);
$stmt_dados2->execute();
$dados2 = $stmt_dados2->get_result();
$linha2 = $dados2->fetch_assoc();
$total2 = $dados2->num_rows;
if ($linha2) {
    $idpassagem = $linha2['idpassagem'];
    $obsviagem = $linha2['obsviagem'];
    $idcliente = $linha2['idcliente'];
} else {
    // Defina valores padrão ou mensagens de aviso se nenhum dado for encontrado
    $idpassagem = null;
    $obsviagem = null;
    $idcliente = null;
}

// Seleciona dados da rota
$sql_dados_rota = "SELECT v.idviagem, v.dataviagem, v.horaviagem, c1.nome AS corigem, e1.uf AS uforigem, 
    c2.nome AS cdestino, e2.uf AS ufdestino
FROM viagem v
INNER JOIN rota r ON r.idrota = v.idrota
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 ON c2.id = r.cdestino
INNER JOIN estados e1 ON e1.id = r.uforigem
INNER JOIN estados e2 ON e2.id = r.ufdestino
WHERE v.idviagem = ? AND v.idcontrato = ?";

$stmt_dados_rota = $con->prepare($sql_dados_rota);
$stmt_dados_rota->bind_param("ii", $idviagem, $idcontrato);
$stmt_dados_rota->execute();
$dados_rota = $stmt_dados_rota->get_result();
$linha_rota = $dados_rota->fetch_assoc();

// Seleciona dados do ônibus e lugares
$sql_dados_bus = "SELECT v.idviagem, v.motorista1, v.motorista2, v.dataviagem, v.horaviagem, 
    b.tipo, b.lugares, c1.nome AS corigem, e1.uf AS uforigem, 
    c2.nome AS cdestino, e2.uf AS ufdestino
FROM viagem v
INNER JOIN rota r ON r.idrota = v.idrota
INNER JOIN bus b ON b.idbus = v.idbus
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 ON c2.id = r.cdestino
INNER JOIN estados e1 ON e1.id = r.uforigem
INNER JOIN estados e2 ON e2.id = r.ufdestino
WHERE v.idviagem = ? AND v.idcontrato = ?";

$stmt_dados_bus = $con->prepare($sql_dados_bus);
$stmt_dados_bus->bind_param("ii", $idviagem, $idcontrato);
$stmt_dados_bus->execute();
$dados_bus = $stmt_dados_bus->get_result();
$linha_bus = $dados_bus->fetch_assoc();
$buslugares = $linha_bus['lugares'];

// Buscar as poltronas já ocupadas
$sql_ocupadas = "SELECT poltrona 
FROM passagem p 
INNER JOIN viagem v ON v.idviagem = p.idviagem
INNER JOIN bus b ON b.idbus = v.idbus
WHERE v.idviagem = ? AND p.status_passagem <> 4 AND v.idcontrato = ?";

$stmt_ocupadas = $con->prepare($sql_ocupadas);
$stmt_ocupadas->bind_param("ii", $idviagem, $idcontrato);
$stmt_ocupadas->execute();
$result_ocupadas = $stmt_ocupadas->get_result();
$ocupadas = [];
while ($row = $result_ocupadas->fetch_assoc()) {
    $ocupadas[] = $row['poltrona'];
}
// Obter a data da viagem atual
$sql_viagem_atual = "SELECT dataviagem FROM viagem WHERE idviagem = ? and idcontrato = ?";
$stmt_viagem_atual = $con->prepare($sql_viagem_atual);
$stmt_viagem_atual->bind_param("ii", $idviagem, $idcontrato);
$stmt_viagem_atual->execute();
$result_viagem_atual = $stmt_viagem_atual->get_result();
$viagem_atual = $result_viagem_atual->fetch_assoc();
$data_viagem_atual = $viagem_atual['dataviagem'];
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
                <div class="row">
                    <div class="col-12">                    
                        <div class="card">
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="passagem.php?idviagem=<?php echo $idviagem ?>"><i class="mdi mdi-hospital"></i>Passagens</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="viagem_financeiro.php?idviagem=<?php echo $idviagem ?>"><i class="mdi mdi-cash-multiple"></i>Financeiro</a>
                                      </li>
                                    </ul>   
                                <div class="card-body">
                                <form class="form-material m-t-40 row" action="" method="post">
                                    <div class="form-group m-b-40 col-md-3">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastrarcliente">Novo Cliente</button>
                                    </div>
                                    <div class="form-group m-b-40 col-md-7">
                                        <table border="1">
                                            <tr>
                                                <td><b>ORIGEM: </b> <i> <?php echo $linha_rota['corigem'] ?> </i> - <?php echo $linha_rota['uforigem'] ?> <b>DESTINO: </b> <i><?php echo $linha_rota['cdestino'] ?></i> - <?php echo $linha_rota['ufdestino']?> <b>DATA PARTIDA: </b> <i> <?php echo date('d/m/Y', strtotime($linha_rota['dataviagem'])); ?> - <?php echo $linha_rota['horaviagem'] ?> </i>
                                                </td>
                                            </tr>
                                        </table>  
                                    </div>
                                    <?php if(isset($linha2) && isset($linha2['obsviagem']) && $linha2['obsviagem']) { ?>
                                    <div class="form-group m-b-40 col-md-2">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#viagem_editar<?php echo $idviagem?>">Editar Viagem </button> 
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group m-b-40 col-md-2">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#viagem_obs">Obs Viagem</button>
                                    </div>
                                <?php } ?>
                                </form>
                        <center><h4><b>Passagens Vendidas:</b> <?php echo $total2 ?></h4></center>
                        <br>
<?php $idviagem = $_GET['idviagem']; ?>
        <!-- Elemento escondido para armazenar o ID da viagem -->
    <input type="hidden" id="viagem-id" value="<?php echo $idviagem ?>">
    <div id="bus-container" class="horizontal"> <!-- Começa como vertical -->
    <div id="seat-map"></div>
</div>
    <!-- FIM LAYOUT ONIBUS -->
<br>

                            <div class="row">
                                   <div class="col-md-5">
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <a href="pdf_passageiros2.php?idviagem=<?php echo $idviagem ?>" target="_blank" class="btn btn-info" role="button">Mapa do Onibus </a>
                                    </div>
                                </div>
                            </div>

                              <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>POLT.</th>          
                                                    <th>CLIENTE</th>
                                                    <th>DOCUMENTO</th>
                                                    <th>ORG</th>
                                                    <th>TEL</th>
                                                    <th>EMB.</th>
                                                    <th>HORA</th>
                                                    <th>DESEM.</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            // se o número de resultados for maior que zero, mostra os dados 
                                            if($total2 > 0) { 
                                            // inicia o loop que vai mostrar todos os dados 
                                                do {  
                                            ?>
                                                <tr>
                                                    <td><?php echo $linha2['poltrona']?></td>
                                                    <td>
                                                    <a href="cliente_cadastro_ver.php?&idcliente=<?php echo $linha2['idcliente']?>"><?php echo $linha2['primeironome']." ".$linha2['segundonome']?></a></td>
                                                    <td><?php echo $linha2['documento']?></td>
                                                    <td><?php echo $linha2['org']?></td>
                                                    <td width="150"><?php echo $linha2['celular']?></td>
                                                    <td><?php echo $linha2['ponto_embarque']?></td>
                                                    <td><?php echo $linha2['hembarque']?></td>
                                                    <td><?php echo $linha2['desembarque']?></td>
                                                    <?php if (strtotime($data_viagem_atual) < strtotime(date('Y-m-d'))) { ?>
                                                    <td>
                                                    <a href="pdf_comprovante2.php?idpassagem=<?php echo $linha2['idpassagem']?>&idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-success btn-circle" role="button"><i class="mdi mdi-receipt"></i> </a>
                                                    <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#passagem_cancelar<?php echo $linha2['idpassagem']?>"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                    <?php } else { ?>
                                                    <td width="200">
                                                        <a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#passagem_cancelar<?php echo $linha2['idpassagem']?>"><i class="fa fa-trash"></i></a>
                                                        <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#passagem_editar<?php echo $linha2['idpassagem']?>"><i class="fa fa-edit"></i></a> 
                                                        <a href="pdf_comprovante2.php?idpassagem=<?php echo $linha2['idpassagem']?>&idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-success btn-circle" role="button"><i class="mdi mdi-receipt"></i> </a>
                                                        <a href="" class="btn btn-warning btn-circle" role="button" data-toggle="modal" data-target="#transferModal<?php echo $linha2['idpassagem']; ?>"><i class="mdi mdi-transfer"></i></a>  
                                                    </td> <?php } ?>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha2 = mysqli_fetch_assoc($dados2)); 
                                                    // fim do if 
                                                            } 
                                            ?> 
                                            </tbody>
                                        </table>
                                    </div>
 <!-- Modal de transferencia de passagem -->
 <?php foreach($dados2 as $aqui5){ ?>
<div class="modal fade" id="transferModal<?php echo $aqui5['idpassagem']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transferir Passageiro</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formTransfer<?php echo $aqui5['idpassagem']; ?>" action="passagem_transferencia.php" method="post" onsubmit="return disableButton(this);">
                    <input type="hidden" name="idpassagem" value="<?php echo $aqui5['idpassagem']; ?>">
                    <div class="form-group">
                        <label for="data_viagem">Selecione a Data:</label>
                        <input type="date" class="form-control" name="data_viagem" id="data_viagem<?php echo $aqui5['idpassagem']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nova_viagem">Selecione a Viagem:</label>
                        <select class="form-control" name="nova_viagem" id="nova_viagem<?php echo $aqui5['idpassagem']; ?>" required>
                            <!-- Opções carregadas dinamicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nova_poltrona">Selecione a Poltrona:</label>
                        <select class="form-control" name="nova_poltrona" id="nova_poltrona<?php echo $aqui5['idpassagem']; ?>" required>
                            <!-- Opções carregadas dinamicamente -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Transferir</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>

    <!-- Modal de adicionar obs a viagem -->
    <div class="modal fade" id="viagem_obs" tabindex="-1" role="dialog" aria-labelledby="viagem_obs" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Cadastrar Passagem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="viagem_obs.php" method="post">
                        <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="valor">Adicione alguma observação para a viagem</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" required>
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $idviagem ?>">
                                                    </div>
                                                </div>
                                            </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Editar obs a viagem -->
    <div class="modal fade" id="viagem_editar<?php echo $idviagem ?>" tabindex="-1" role="dialog" aria-labelledby="viagem_editar" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Editar Passagem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="viagem_obs.php" method="post">
                        <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="valor">Editar Observação</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" value="<?php echo $obsviagem; ?>">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $idviagem ?>">
                                                    </div>
                                                </div>
                                            </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de cadastro de passagem -->
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Cadastrar Passagem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="passagem_cadastrar.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-1">
                                <label for="poltrona">Polt.</label>
                                <input type="text" class="form-control" id="poltrona" name="poltrona" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="customerSearch">Buscar</label>
                                <div class="form-group">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" id="searchCustomerBtn">&nbsp Buscar &nbsp</button>
                                    </div>
                                </div>
                            </div>
                                                <div class="form-group col-md-5">
                                                    <label for="nome">Nome</label>
                                                    <input type="text" class="form-control" name="nome" id="nome" readonly>
                                                        <input type="hidden" class="form-control" id="idcliente" name="idcliente">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $idviagem ?>">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="documento">Documento</label>
                                                    <input type="text" class="form-control" name="documento" id="documento" readonly>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="org">Org. Exp.</label>
                                                    <input type="text" class="form-control" name="org" id="org" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="nascimento">Data de Nascimento</label>
                                                    <input type="text" class="form-control" name="nascimento" id="nascimento" readonly>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="sexo">Sexo</label>
                                                    <input type="text" class="form-control" name="sexo" id="sexo" readonly>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="celular">Celular</label>
                                                    <input type="text" class="form-control" name="celular" id="celular" required readonly>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="mae">Mãe</label>
                                                    <input type="text" class="form-control" name="mae" id="mae" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="embarque">Embarque</label>
                                                        <select class="form-control" name="idembarque" id="idembarque" required>
                                                            <option value=""></option>
                                                            <?php 
                                                            // Prepare a consulta SQL com placeholders
                                                            $sql = "SELECT pe.idembarque, pe.nome 
                                                                    FROM pontos_embarque pe 
                                                                    INNER JOIN rota r ON pe.idrota = r.idrota
                                                                    INNER JOIN viagem v ON v.idrota = r.idrota
                                                                    WHERE v.idviagem = ? AND v.idcontrato = ?
                                                                    GROUP BY pe.idembarque, pe.nome
                                                                    ORDER BY pe.nome";

                                                            // Preparar a instrução
                                                            $stmt = $con->prepare($sql);
                                                            
                                                            // Verifique se a preparação foi bem-sucedida
                                                            if ($stmt) {
                                                                // Vincular os parâmetros
                                                                $stmt->bind_param("ii", $idviagem, $idcontrato);
                                                                
                                                                // Executar a consulta
                                                                $stmt->execute();
                                                                
                                                                // Obter o resultado
                                                                $result = $stmt->get_result();
                                                                
                                                                // Verifique se existem resultados
                                                                if ($result->num_rows > 0) {
                                                                    // Loop para preencher as opções do select com os resultados da consulta
                                                                    while ($line = $result->fetch_assoc()) { 
                                                                        echo "<option value='" . $line['idembarque'] . "'>" . $line['nome'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }
                                                                
                                                                // Fechar a declaração
                                                                $stmt->close();
                                                            } else {
                                                                echo "<option value='none'>Erro na consulta.</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="hembarque">Hora Emb.</label>
                                                        <input type="text" class="form-control" id="hembarque" name="hembarque" OnKeyPress="formatar('##:##', this)" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="desembarque">Desembarque</label>
                                                        <input type="text" class="form-control" id="desembarque" name="desembarque">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Valor</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idformapg">Forma PG</label>
                                                        <select class="form-control" name="idformapg" id="idformapg" required onchange="checkpg()">
                                                            <option value=""></option>
                                                            <?php 
                                                            // Preparar a consulta para forma de pagamento
                                                            $sql_formapg = "SELECT idformapg, tipo FROM formapg ORDER BY tipo";
                                                            $stmt_formapg = $con->prepare($sql_formapg);
                                                            
                                                            if ($stmt_formapg) {
                                                                $stmt_formapg->execute();
                                                                $result_formapg = $stmt_formapg->get_result();
                                                                
                                                                if ($result_formapg->num_rows > 0) {
                                                                    while ($line = $result_formapg->fetch_assoc()) { 
                                                                        echo "<option value='" . $line['idformapg'] . "'>" . $line['tipo'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }
                                                                
                                                                $stmt_formapg->close();
                                                            } else {
                                                                echo "<option value='none'>Erro na consulta.</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="idformapg">Agência</label>
                                                        <select class="form-control" name="idagencia" id="idagencia" required>
                                                            <option value=""></option>
                                                            <?php 
                                                            // Preparar a consulta para as agências
                                                            $sql_agencia = "SELECT idagencia, nome FROM agencia WHERE idcontrato = ? ORDER BY nome";
                                                            $stmt_agencia = $con->prepare($sql_agencia);
                                                            
                                                            if ($stmt_agencia) {
                                                                $stmt_agencia->bind_param("i", $idcontrato);
                                                                $stmt_agencia->execute();
                                                                $result_agencia = $stmt_agencia->get_result();
                                                                
                                                                if ($result_agencia->num_rows > 0) {
                                                                    while ($line = $result_agencia->fetch_assoc()) { 
                                                                        echo "<option value='" . $line['idagencia'] . "'>" . $line['nome'] . "</option>";
                                                                    }
                                                                } else {
                                                                    echo "<option value='none'>Nenhum resultado encontrado!</option>";
                                                                }
                                                                
                                                                $stmt_agencia->close();
                                                            } else {
                                                                echo "<option value='none'>Erro na consulta.</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="desconto">Desconto</label>
                                                        <input type="text" class="form-control" id="desconto" name="desconto" onKeyPress="return(MascaraMoeda(this,'.',',',event))" >
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="idsituacao">Foi Pago?</label>
                                                        <select class="form-control" name="idsituacao" id="idsituacao" required>
                                                            <option value=""></option>
                                                            <option value="2">Sim</option>
                                                            <option value="1">Não</option>
                                                      </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" placeholder="Ex: Pix pago em data e hora tal">
                                                    </div>
                                                </div>
                                            </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrarcliente" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrarcliente">Cadastrar Cliente</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                <form action="cliente_cadastrar.php" method="post">
                                <div class="row">
                                    <div class="form-group m-b-40 col-md-7">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Cliente" required>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-5">
                                        <label for="nascimento">Nascimento</label>
                                        <input type="date" class="form-control" id="nascimento" name="nascimento">
                                        <span class="bar"></span>
                                    </div>
                               
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="sexo">Sexo</label>
                                        <select class="form-control p-0" id="sexo" name="sexo" required>
                                            <option></option>
                                            <option>Masculino</option>
                                            <option>Feminino</option>
                                            <option>Outros</option>
                                        </select><span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-5">
                                        <label for="documento">Documento</label>
                                        <input type="text" class="form-control" name="documento" id="documento2" required>
                                        <div class="error-message2" id="error-message2">Apenas números são permitidos.</div>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="documento">Org Exp.</label>
                                        <input type="text" class="form-control" id="org" name="org" required>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-5">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" OnKeyPress="formatar('##-#####-####', this)" required>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-7">
                                        <label for="celular">Nome Mãe</label>
                                        <input type="text" class="form-control" id="mae" name="mae">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-12">
                                        <label for="obs">Observação</label>
                                        <input type="text" class="form-control" id="obs" name="obs" placeholder="Observação">
                                        <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $datebr ?>">
                                        <input type="hidden" class="form-control" id="atendente" name="atendente" value="<?php echo $_SESSION['UsuarioNome']?>">
                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $idviagem ?>">
                                        <span class="bar"></span>
                                    </div>
                                           <div class="form-group m-b-40 col-md-12">
                                        <input type="submit" class="btn btn-info" value="Cadastrar">
                                        </div>
                                    </div>
                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 


                    <?php foreach($dados2 as $aqui2){ ?>
                                <div class="modal fade bs-example-modal" tabindex="-1" id="passagem_cancelar<?php echo $aqui2['idpassagem']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cancelar_pagamento">Cancelar Pagamento</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="passagem_cancelar.php" method="post">
                                                    <div class="form-group">
                                                        <label for="evolucao" class="control-label">Motivo</label>
                                                        <textarea class="form-control" rows="3" id="mcancelamento" name="mcancelamento" required></textarea>
                                                        <input type="hidden" class="form-control" id="idpassagem" name="idpassagem" value="<?php echo $aqui2['idpassagem'] ?>">
                                                        <input type="hidden" class="form-control" id="cancelado_por" name="cancelado_por" value="<?php echo $_SESSION['UsuarioNome']?>" readonly>
                                                        <input type="hidden" class="form-control" id="idmovimento" name="idmovimento" value="<?php echo $aqui2['idmovimento'] ?>">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui2['idviagem'] ?>">
                                                    </div>
                                                    <button type="submit" name="confirmar" id="confirmar" class="btn btn-info">Confirmar</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    <?php }?>
                    
                <?php foreach($dados2 as $aqui3){ 
      $valor_passagem = $aqui3['valor_total'];
      $valorp_ponto = str_replace(".",",",$valor_passagem);  
      $valorpformatado = str_replace(",",".",$valorp_ponto); ?>

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="passagem_editar<?php echo $aqui3['idpassagem']?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="passagem_editar">Editar Passagem</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="passagem_editar.php" method="post">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                     <label for="idembarque">Embarque</label>
                                                  <select class="form-control" name="idembarque" id="idembarque" required>
                                                        <option value="<?php echo $aqui3['idembarque'] ?>"><?php echo $aqui3['ponto_embarque'] ?></option>
                                                        <?php 
                                                        $q = mysqli_query($con, "SELECT pe.idembarque, pe.nome 
                                                                                 FROM pontos_embarque pe 
                                                                                 INNER JOIN rota r ON pe.idrota = r.idrota
                                                                                 INNER JOIN viagem v ON v.idrota = r.idrota
                                                                                 WHERE v.idviagem = $idviagem
                                                                                 GROUP BY pe.idembarque, pe.nome
                                                                                 ORDER BY pe.nome") or die(mysqli_error($con));    
                                                        
                                                        if (mysqli_num_rows($q) > 0) { 
                                                            while ($line = mysqli_fetch_array($q)) { 
                                                                echo "<option value='" . $line['idembarque'] . "'>" . $line['nome'] . "</option>";
                                                            } 
                                                        } else {
                                                            echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="hembarque">Hora Emb.</label>
                                                        <input type="text" class="form-control" id="hembarque" name="hembarque" OnKeyPress="formatar('##:##', this)" value="<?php echo $aqui3['hembarque']?> ">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="desembarque">Desembarque</label>
                                                        <input type="text" class="form-control" id="desembarque" name="desembarque" value="<?php echo $aqui3['desembarque'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="poltrona">Poltrona</label>
                                                    <select class="form-control" name="poltrona" id="poltrona" required>
                                                    <option value="<?php echo $aqui3['poltrona'] ?>" ><?php echo $aqui3['poltrona'] ?></option>
                                                        <?php
                                                        if($total2 <=0){
                                                            for ($i = 1; $i <= $buslugares; $i++) {
                                                         ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } 
                                                         }
                                                        else {
                                                        for ($i = 1; $i <= $buslugares; $i++): 
                                                                if (!in_array($i, $ocupadas)): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php endif;
                                                        endfor; 
                                                       }?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Valor</label>
                                                        <?php if($aqui3['idsituacao']<>2) {?>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valorp_ponto ?>">
                                                    <?php } else { ?>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valorp_ponto ?>" readonly> 
                                                    <?php }?>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs" <?php echo @$aqui3['obs'] ?>>
                                                        <input type="hidden" class="form-control" id="cancelado_por" name="cancelado_por" value="<?php echo $_SESSION['UsuarioNome']?>" readonly>
                                                        <input type="hidden" class="form-control" id="idmovimento" name="idmovimento" value="<?php echo $aqui3['idmovimento'] ?>">
                                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $aqui3['idviagem'] ?>">
                                                       <input type="hidden" class="form-control" id="idpassagem" name="idpassagem" value="<?php echo $aqui3['idpassagem'] ?>">
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

    <!-- Modal de busca de cliente -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Buscar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="searchInput" placeholder="Nome ou Documento">
                    <button type="button" class="btn btn-primary mt-2" id="searchBtn">Buscar</button>
                    <table class="table mt-3" id="customerTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Órgão</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Resultados da busca serão adicionados aqui -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
	
 <!-- Script para transferencia de passagens. Carrega o formulário de transferência de passagens -->
 <script>
$(document).on('change', '[id^=data_viagem]', function() {
    var data_viagem = $(this).val();
    var modal = $(this).closest('.modal');
    var id_viagem = '<?php echo $idviagem; ?>'; // ID da viagem atual
    var selectViagem = modal.find('[id^=nova_viagem]');
    var selectPoltrona = modal.find('[id^=nova_poltrona]');

    // Resetar os selects
    selectViagem.html('<option value="">Carregando viagens...</option>');
    selectPoltrona.html('<option value="">Selecione uma viagem primeiro</option>');

    // Buscar viagens
    $.ajax({
        url: 'buscar_viagens.php',
        type: 'GET',
        data: { data_viagem: data_viagem, id_viagem: id_viagem },
        success: function(response) {
            selectViagem.html(response);

            // Se houver apenas uma viagem, carregar automaticamente as poltronas
            var firstOption = selectViagem.find('option').first();
            if (firstOption.val() && firstOption.val() !== '') {
                selectViagem.val(firstOption.val()).trigger('change');
            }
        },
        error: function() {
            selectViagem.html('<option value="">Erro ao carregar viagens</option>');
        }
    });
});

$(document).on('change', '[id^=nova_viagem]', function() {
    var nova_viagem = $(this).val();
    var modal = $(this).closest('.modal');
    var selectPoltrona = modal.find('[id^=nova_poltrona]');

    // Resetar o select de poltronas
    selectPoltrona.html('<option value="">Carregando poltronas...</option>');

    // Buscar poltronas
    $.ajax({
        url: 'buscar_poltronas.php',
        type: 'GET',
        data: { nova_viagem: nova_viagem },
        success: function(response) {
            selectPoltrona.html(response);
        },
        error: function() {
            selectPoltrona.html('<option value="">Erro ao carregar poltronas</option>');
        }
    });
});
</script>	
	
<script>
    $(document).ready(function() {
        // Função para buscar o horário de embarque
        function buscarHorario(idembarque, modal) {
            if (idembarque) {
                $.ajax({
                    url: 'buscar_horario_embarque.php',
                    type: 'GET',
                    data: { idembarque: idembarque },
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.horario) {
                                $(modal).find('#hembarque').val(data.horario);  // Atualiza o campo dentro do modal
                            } else {
                                $(modal).find('#hembarque').val('');
                            }
                        } catch (e) {
                            console.error('Erro ao analisar JSON:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na requisição AJAX:', error);
                    }
                });
            }
        }

        // Delegação de eventos para o change no select de idembarque no modal de cadastro e edição
        $(document).on('change', '#bookingModal #idembarque, [id^=passagem_editar] #idembarque', function() {
            var idembarque = $(this).val();
            var modal = $(this).closest('.modal');  // Localiza o modal atual
            buscarHorario(idembarque, modal);  // Passa o modal atual para a função
        });

        // Quando o modal de cadastro ou edição for aberto, carregar o horário de embarque
        $('#bookingModal, [id^=passagem_editar]').on('shown.bs.modal', function () {
            var idembarqueInicial = $(this).find('#idembarque').val();
            var modal = $(this);  // Localiza o modal atual
            if (idembarqueInicial) {
                buscarHorario(idembarqueInicial, modal);  // Passa o modal atual para a função
            }
        });
    });
</script>

<script>
        document.getElementById('documento2').addEventListener('input', function (e) {
            var value = this.value;

            // Remove todos os caracteres que não são números
            this.value = value.replace(/\D/g, '');

            // Se o valor original continha caracteres não numéricos, exibe a mensagem de erro
            if (value !== this.value) {
                document.getElementById('error-message2').style.display = 'block';
            } else {
                document.getElementById('error-message2').style.display = 'none';
            }
        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ViagemID = <?php echo $idviagem; ?>;
    // Função para buscar clientes
    async function buscarClientes(termo) {
        if (termo.trim().length < 3) {
            alert('Por favor, insira pelo menos 3 caracteres para realizar a busca.');
            return;
        }

        try {
            const response = await fetch(`buscar_clientes.php?termo=${encodeURIComponent(termo)}`);
            const data = await response.json();

            const tbody = document.querySelector('#customerTable tbody');
            tbody.innerHTML = ''; // Limpa os resultados anteriores

            if (data.clientes.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">Nenhum cliente encontrado.</td></tr>';
                return;
            }

            data.clientes.forEach(cliente => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <button type="button" class="btn btn-primary selecionar-cliente" data-cliente='${JSON.stringify(cliente)}'>Ok</button>
                    </td>
                    <td>${cliente.nome}</td>
                    <td>${cliente.documento}</td>
                    <td>${cliente.org}</td>
                `;
                tbody.appendChild(tr);
            });

            // Adiciona evento de clique aos botões
            document.querySelectorAll('.selecionar-cliente').forEach(button => {
                button.addEventListener('click', function () {
                    const cliente = JSON.parse(this.getAttribute('data-cliente'));
                    document.querySelector('#idcliente').value = cliente.idcliente;
                    document.querySelector('#nome').value = cliente.nome;
                    document.querySelector('#documento').value = cliente.documento;
                    document.querySelector('#org').value = cliente.org;
                    document.querySelector('#mae').value = cliente.mae;
                    document.querySelector('#sexo').value = cliente.sexo;
                    document.querySelector('#celular').value = cliente.celular;
                    document.querySelector('#nascimento').value = cliente.nascimento;
                    $('#customerModal').modal('hide');
                });
            });
        } catch (error) {
            console.error('Erro ao buscar clientes:', error);
        }
    }
    async function fetchSeatStatus() {
        try {
            const response = await fetch(`get_seat_status.php?idviagem=${ViagemID}`);
            const data = await response.json();

            if (data.error) {
                console.error(data.error);
                return;
            }

            const occupiedSeats = data.occupiedSeats.map(Number) || [];
            const totalSeats = <?php echo $buslugares; ?>;

            ajustarLayout(totalSeats, occupiedSeats);
        } catch (error) {
            console.error('Erro ao buscar o status das poltronas:', error);
        }
    }

    function ajustarLayout(totalSeats, occupiedSeats) {
        const busContainer = document.getElementById('bus-container');
        const seatMap = document.getElementById('seat-map');

        if (window.innerWidth >= 768) {
            busContainer.classList.remove('vertical');
            busContainer.classList.add('horizontal');
            seatMap.classList.add('horizontal');
            generateHorizontalSeatMap(totalSeats, occupiedSeats);
        } else {
            busContainer.classList.remove('horizontal');
            busContainer.classList.add('vertical');
            seatMap.classList.remove('horizontal');
            generateVerticalSeatMap(totalSeats, occupiedSeats);
        }
    }

    function generateHorizontalSeatMap(totalSeats, occupiedSeats) {
        const seatMap = document.getElementById('seat-map');
        seatMap.innerHTML = '';

        const leftWindowSeats = [];
        const leftAisleSeats = [];
        const rightAisleSeats = [];
        const rightWindowSeats = [];

        for (let i = totalSeats; i >= 1; i--) {
            if ((i - 1) % 4 === 0) leftWindowSeats.push(i);
            else if ((i - 2) % 4 === 0) leftAisleSeats.push(i);
            else if ((i - 3) % 4 === 0) rightWindowSeats.push(i);
            else if (i % 4 === 0) rightAisleSeats.push(i);
        }

        // Adicionar poltronas vazias para completar o layout
        while (leftWindowSeats.length > leftAisleSeats.length) {
            leftAisleSeats.unshift(null);
        }
        while (rightWindowSeats.length < leftWindowSeats.length) {
            rightWindowSeats.unshift(null);
        }
        while (rightAisleSeats.length < leftWindowSeats.length) {
            rightAisleSeats.unshift(null);
        }

        const maxRows = Math.max(
            leftWindowSeats.length,
            leftAisleSeats.length,
            rightAisleSeats.length,
            rightWindowSeats.length
        );

        for (let i = 0; i < maxRows; i++) {
            const rowContainer = document.createElement('div');
            rowContainer.className = 'row-container horizontal';

            rowContainer.appendChild(
                leftWindowSeats[i] ? createSeat(leftWindowSeats[i], occupiedSeats) : createEmptySpace()
            );
            rowContainer.appendChild(
                leftAisleSeats[i] ? createSeat(leftAisleSeats[i], occupiedSeats) : createEmptySpace()
            );
            rowContainer.appendChild(createEmptySpace());
            rowContainer.appendChild(
                rightAisleSeats[i] ? createSeat(rightAisleSeats[i], occupiedSeats) : createEmptySpace()
            );
            rowContainer.appendChild(
                rightWindowSeats[i] ? createSeat(rightWindowSeats[i], occupiedSeats) : createEmptySpace()
            );

            seatMap.appendChild(rowContainer);
        }
    }

    function generateVerticalSeatMap(totalSeats, occupiedSeats) {
        const seatMap = document.getElementById('seat-map');
        seatMap.innerHTML = '';

        const rows = Math.ceil(totalSeats / 4);
        for (let row = 1; row <= rows; row++) {
            const rowContainer = document.createElement('div');
            rowContainer.className = 'row-container';

            const seatNumbers = {
                upperWindow: (row - 1) * 4 + 1,
                upperAisle: (row - 1) * 4 + 2,
                lowerWindow: (row - 1) * 4 + 3,
                lowerAisle: (row - 1) * 4 + 4,
            };

            rowContainer.appendChild(
                seatNumbers.upperWindow <= totalSeats
                    ? createSeat(seatNumbers.upperWindow, occupiedSeats)
                    : createEmptySpace()
            );
            rowContainer.appendChild(
                seatNumbers.upperAisle <= totalSeats
                    ? createSeat(seatNumbers.upperAisle, occupiedSeats)
                    : createEmptySpace()
            );
            rowContainer.appendChild(createEmptySpace());
            rowContainer.appendChild(
                seatNumbers.lowerAisle <= totalSeats
                    ? createSeat(seatNumbers.lowerAisle, occupiedSeats)
                    : createEmptySpace()
            );
            rowContainer.appendChild(
                seatNumbers.lowerWindow <= totalSeats
                    ? createSeat(seatNumbers.lowerWindow, occupiedSeats)
                    : createEmptySpace()
            );

            seatMap.appendChild(rowContainer);
        }
    }

    function createSeat(seatNumber, occupiedSeats) {
        const seat = document.createElement('div');
        seat.className = occupiedSeats.includes(seatNumber) ? 'seat occupied' : 'seat';
        seat.textContent = seatNumber;

        if (!occupiedSeats.includes(seatNumber)) {
            seat.addEventListener('click', () => {
                document.getElementById('poltrona').value = seatNumber;
                $('#bookingModal').modal('show');
            });
        }

        return seat;
    }

    function createEmptySpace() {
        const emptySpace = document.createElement('div');
        emptySpace.className = 'aisle';
        return emptySpace;
    }
    // Eventos do modal e botão de busca
    document.querySelector('#searchCustomerBtn').addEventListener('click', () => {
        $('#customerModal').modal('show');
    });

    document.querySelector('#searchBtn').addEventListener('click', () => {
        const termo = document.querySelector('#searchInput').value;
        buscarClientes(termo);
    });
    window.addEventListener('resize', () => fetchSeatStatus());
    fetchSeatStatus();
});
    </script>
</body>
</html>
