<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Assentos do Ônibus</title>
    <link rel="stylesheet" href="../css/stylesbus.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
include "../funcoes.php"; 
$idviagem = $_GET['idviagem'];                   
$dados2 = mysqli_query($con,"select p.idpassagem, p.embarque, p.desembarque, v.idviagem, v.dataviagem, v.horaviagem, substring_index(c.nome, ' ', 1)  as primeironome, substring_index(c.nome, ' ', -2)  as segundonome, c.sexo, c.nascimento, c.documento, c.celular, p.poltrona, a.nome as agencia, c.idcliente, crm.idmovimento, crm.valor_total, p.hembarque, sc.situacao, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
from passagem p
inner join clientes c on c.idcliente = p.idcliente
inner join viagem v on p.idviagem = v.idviagem
inner join agencia a on a.idagencia = p.idagencia
inner join rota r on r.idrota = v.idrota
inner join contas_receb_movi crm on crm.idpassagem = p.idpassagem
inner join situacao_caixa sc on sc.idsituacao = crm.idsituacao
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where v.idviagem = $idviagem and p.status_passagem <> 4
order by c.nome") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha2 = mysqli_fetch_assoc($dados2); 

// calcula quantos dados retornaram 
$total2 = mysqli_num_rows($dados2);

@$idpassagem = $linha2['idpassagem'];

@$idcliente = $linha2['idcliente'];

//--------------------Seleciona a rota antes da passagem--------                 
$dados_rota = mysqli_query($con,"select v.idviagem, v.dataviagem, v.horaviagem, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
from viagem v
inner join rota r on r.idrota = v.idrota
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where v.idviagem = $idviagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_rota = mysqli_fetch_assoc($dados_rota); 

// calcula quantos dados retornaram 
//@$total_rota = mysqli_num_rows($linha_rota);


//--------------------Seleciona os lugares da viagem--------                 
$dados_bus = mysqli_query($con,"select v.idviagem, v.motorista1, v.motorista2, v.dataviagem, v.horaviagem, b.tipo, b.lugares, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
from viagem v
inner join rota r on r.idrota = v.idrota
inner join bus b on b.idbus = v.idbus
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where v.idviagem = $idviagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_bus = mysqli_fetch_assoc($dados_bus); 


$buslugares = $linha_bus['lugares'];

//--------------------Seleciona as poltronas ocupadas--------                 
$dados_poltrona = mysqli_query($con,"SELECT po.id_poltrona from poltronas_ocupadas po, viagem v, passagem p
where po.idviagem = v.idviagem
and po.idpassagem = p.idpassagem
and p.idviagem = v.idviagem
and po.idviagem = $idviagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_poltrona = mysqli_fetch_assoc($dados_poltrona); 

// calcula quantos dados retornaram 
$total_poltrona = mysqli_num_rows($dados_poltrona);
   
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
                                    <div class="form-group m-b-40 col-md-2">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#viagem_obs">Obs Viagem</button>
                                    </div>
                                </form>
                        <center><h4><b>Passagens Vendidas:</b> <?php echo $total2 ?></h4></center>
                        <br>
<?php $idviagem = $_GET['idviagem']; ?>
        <!-- Elemento escondido para armazenar o ID da viagem -->
    <input type="hidden" id="viagem-id" value="<?php echo $idviagem ?>">
    <div id="layout_onibus">
        <table class="poltrona_esquerda" cellspacing="2" cellpadding="2">
            <tbody id="seat-map">
                <!-- Poltronas serão geradas dinamicamente aqui -->
            </tbody>
        </table>
    </div>
<!-- FIM LAYUT ONIBUS -->

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
                                                    <td width="150"><?php echo $linha2['celular']?></td>
                                                    <td><?php echo $linha2['embarque']?></td>
                                                    <td><?php echo $linha2['hembarque']?></td>
                                                    <td><?php echo $linha2['desembarque']?></td>
                                                    <td width="160"><a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#passagem_cancelar<?php echo $linha2['idpassagem']?>"><i class="fa fa-trash"></i></a>
                                                    <a href="" class="btn btn-info btn-circle" role="button" data-toggle="modal" data-target="#passagem_editar<?php echo $linha2['idpassagem']?>"><i class="fa fa-edit"></i></a> 
                                                    <a href="print_comprovante.php?idpassagem=<?php echo $linha2['idpassagem']?>&idviagem=<?php echo $linha2['idviagem'] ?>" target="_blank" class="btn btn-success btn-circle" role="button"><i class="mdi mdi-receipt"></i> </a>
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
                                    </div>
<!-- ONIBUS--><!-- ONIBUS--><!-- ONIBUS--><!-- ONIBUS--><!-- ONIBUS--><!-- ONIBUS--><!-- ONIBUS-->
<?php 
//--------------------Seleciona a rota antes da passagem--------                 
$dados_rota = mysqli_query($con,"select v.idviagem, v.dataviagem, v.horaviagem, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino
from viagem v
inner join rota r on r.idrota = v.idrota
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where v.idviagem = $idviagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_rota = mysqli_fetch_assoc($dados_rota); 

// calcula quantos dados retornaram 
//@$total_rota = mysqli_num_rows($linha_rota);


?>

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
                                                    <input type="text" class="form-control" name="celular" id="celular" readonly>
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
                                                        <input type="text" class="form-control" id="embarque" name="embarque" required>
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
                                                        $q = mysqli_query($con,"SELECT * FROM formapg order by tipo") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idformapg']."'>".$line['tipo']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
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
                                                        $q = mysqli_query($con,"SELECT * FROM agencia order by nome") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['idagencia']."'>".$line['nome']."</option>";
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
                                        <input type="text" class="form-control" id="documento" name="documento" placeholder="Documento" required>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-3">
                                        <label for="documento">Org Exp.</label>
                                        <input type="text" class="form-control" id="org" name="org" required>
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-5">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" OnKeyPress="formatar('##-#####-####', this)">
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
      $valorpformatado = str_replace(",",".",$valorp_ponto);?> 
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
                                                     <label for="embarque">Embarque</label>
                                                        <input type="text" class="form-control" id="embarque" name="embarque" value="<?php echo $aqui3['embarque'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="hembarque">Hora Emb.</label>
                                                        <input type="text" class="form-control" id="text" name="hembarque" OnKeyPress="formatar('##:##', this)" value="<?php echo $aqui3['hembarque']?> ">
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
                                                        $q = mysqli_query($con,"SELECT p.numero
                                                        FROM poltronas p
                                                        WHERE NOT EXISTS(select *
                                                        FROM poltronas_ocupadas po, passagem pa
                                                          WHERE p.idpoltrona = po.id_poltrona 
                                                          and pa.idpassagem = po.idpassagem
                                                          and pa.status_passagem <> 4
                                                          and pa.idviagem = $idviagem)") or die(mysqli_error());    
                                                        if(mysqli_num_rows($q)){ 
                                                        //faz o loop para preencher o campo criado com os valores retornados na consulta 
                                                        while($line = mysqli_fetch_array($q)) 
                                                        { 
                                                        echo "<option value='".$line['numero']."'>".$line['numero']."</option>";
                                                        } 
                                                        }
                                                         else {//Caso não haja resultados 
                                                        echo "<option value='none'>Nenhum resultado encontrado!</option>"; 
                                                        }   
                                                        ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="valor">Valor</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo $valorp_ponto ?>">
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
            var qtdpoltrona = "<?php echo $buslugares; ?>";
        const idviagem = new URLSearchParams(window.location.search).get('idviagem');
        const totalSeats = qtdpoltrona; // Altere este valor conforme necessário

        function createSeatElement(poltrona) {
            const td = document.createElement('td');
            td.id = `seat-${poltrona}`;
            td.className = 'livre';
            td.textContent = poltrona;
            td.addEventListener('click', () => {
                if (td.classList.contains('livre')) {
                    $('#poltrona').val(poltrona);
                    $('#bookingModal').modal('show');
                }
            });
            return td;
        }

        function generateSeats(totalSeats) {
            const seatMap = document.getElementById('seat-map');
            let row, seatCount = 1;

            for (let i = 1; i <= totalSeats; i += 4) {
                row = document.createElement('tr');

                // Poltronas da esquerda
                row.appendChild(createSeatElement(seatCount++));
                row.appendChild(createSeatElement(seatCount++));

                // Corredor
                const corridor = document.createElement('td');
                corridor.innerHTML = '&nbsp;';
                row.appendChild(corridor);

            // Poltronas da direita (ajustando a ordem para 4, 3)
            if (seatCount + 1 <= totalSeats) row.appendChild(createSeatElement(seatCount + 1));
            if (seatCount <= totalSeats) row.appendChild(createSeatElement(seatCount));
            seatCount += 2;

                seatMap.appendChild(row);
            }
        }

        async function atualizarPoltronasOcupadas() {
            try {
                const response = await fetch(`get_seat_status.php?idviagem=${idviagem}`);
                const data = await response.json();

                data.occupiedSeats.forEach(poltrona => {
                    const seatElement = document.getElementById(`seat-${poltrona}`);
                    if (seatElement) {
                        seatElement.classList.remove('livre');
                        seatElement.classList.add('ocupada');
                    }
                });
            } catch (error) {
                console.error('Erro ao buscar o status das poltronas:', error);
            }
        }

async function buscarClientes(termo) {
    // Verifica se o termo tem pelo menos 3 caracteres
    if (termo.trim().length < 3) {
        alert('Por favor, insira pelo menos 3 caracteres para realizar a busca.');
        return;
    }

    try {
        const response = await fetch(`buscar_clientes.php?termo=${encodeURIComponent(termo)}`);
        const data = await response.json();

        const tbody = document.querySelector('#customerTable tbody');
        tbody.innerHTML = '';

        data.clientes.forEach(cliente => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><button type="button" class="btn btn-primary selecionar-cliente" data-cliente='${JSON.stringify(cliente)}'>Ok</button></td>
                <td>${cliente.nome}</td>
                <td>${cliente.documento}</td>
                <td>${cliente.org}</td>
            `;
            tbody.appendChild(tr);
        });

        // Adiciona evento de clique para os botões de selecionar cliente
        document.querySelectorAll('.selecionar-cliente').forEach(button => {
            button.addEventListener('click', function() {
                const cliente = JSON.parse(this.getAttribute('data-cliente'));
                $('#idcliente').val(cliente.idcliente);
                $('#nome').val(cliente.nome);
                $('#documento').val(cliente.documento);
                $('#org').val(cliente.org);
                $('#mae').val(cliente.mae);
                $('#sexo').val(cliente.sexo);
                $('#celular').val(cliente.celular);
                $('#nascimento').val(cliente.nascimento);
                $('#customerModal').modal('hide');
            });
        });
    } catch (error) {
        console.error('Erro ao buscar clientes:', error);
    }
}



        document.addEventListener('DOMContentLoaded', () => {
            generateSeats(totalSeats);
            atualizarPoltronasOcupadas();

            $('#searchCustomerBtn').on('click', function() {
                $('#customerModal').modal('show');
            });

            $('#searchBtn').on('click', function() {
                const termo = $('#searchInput').val();
                buscarClientes(termo);
            });
        });
    </script>
</body>
</html>
