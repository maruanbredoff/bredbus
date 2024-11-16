<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/css_onibus.css">
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
        <script type='text/javascript'>
            $(document).ready(function(){
                $("input[name='nome']").blur(function(){
                    var $cpf = $("input[name='cpf']");
                    var $rg = $("input[name='rg']");
                    var $sexo = $("input[name='sexo']");
                    var $celular = $("input[name='celular']");
                    var $nascimento = $("input[name='nascimento']");
                    var $idcliente = $("input[name='idcliente']");
                    $.getJSON('completarcliente.php',{ 
                        nome: $( this ).val() 
                    },function( json ){
                        $cpf.val( json.cpf );
                        $rg.val( json.rg );
                        $sexo.val( json.sexo );
                        $celular.val( json.celular );
                        $nascimento.val( json.nascimento );
                        $idcliente.val( json.idcliente );
                    });
                });
            });
        </script>
</head>

<body class="fix-header card-no-border">
<?php 
include "../verificanivel.php"; 
include "../funcoes.php"; 

$idviagem = $_GET['idviagem'];                   
$dados2 = mysqli_query($con,"select p.idpassagem, p.embarque, p.desembarque, v.idviagem, v.dataviagem, v.horaviagem, r.corigem, r.cdestino, c.nome, c.sexo, c.nascimento, c.cpf, c.rg, c.celular, p.poltrona, a.nome as agencia, c.idcliente, r.uforigem, r.ufdestino, crm.idmovimento
from passagem p
inner join clientes c on c.idcliente = p.idcliente
inner join viagem v on p.idviagem = v.idviagem
inner join agencia a on a.idagencia = p.idagencia
inner join rota r on r.idrota = v.idrota
inner join contas_receb_movi crm on crm.idpassagem = p.idpassagem
where v.idviagem = $idviagem and p.status_passagem <> 4") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha2 = mysqli_fetch_assoc($dados2); 

// calcula quantos dados retornaram 
$total2 = mysqli_num_rows($dados2);

$idpassagem = $linha2['idpassagem'];

//--------------------Seleciona a rota antes da passagem--------                 
$dados_rota = mysqli_query($con,"select v.idviagem, v.dataviagem, v.horaviagem, r.corigem, r.cdestino, r.uforigem, r.ufdestino
from viagem v
inner join rota r on r.idrota = v.idrota
where v.idviagem = $idviagem") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha_rota = mysqli_fetch_assoc($dados_rota); 

// calcula quantos dados retornaram 
$total_rota = mysqli_num_rows($linha_rota);

//--------------------- Usuario ----------------------------    
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
            
                <div class="col-md-5 align-self-center">
                    <br>
                </div>
            <div class="container-fluid">

<?php
if(isset($_SESSION['msg'])){
echo $_SESSION['msg'];
unset($_SESSION['msg']);
}
if($_POST){
      //Campos tabela passagem
      $idcliente = mysqli_real_escape_string($con,$_POST['idcliente']);
      $embarque = mysqli_real_escape_string($con,$_POST['embarque']);
      $desembarque = mysqli_real_escape_string($con,$_POST['desembarque']);
      $idagencia = mysqli_real_escape_string($con,$_POST['idagencia']);
      $poltrona = mysqli_real_escape_string($con,$_POST['poltrona']);
      $atendente = $_SESSION['UsuarioNome'];
      $idsituacao = mysqli_real_escape_string($con,$_POST['idsituacao']);
      $quem_recebeu = $_SESSION['UsuarioNome'];
      //Campos Tabela Contas_Receber
      $desconto = mysqli_real_escape_string($con,$_POST['desconto']);
      $desconto_ponto = str_replace(".","",$desconto);  
      $descontoformatado = str_replace(",",".",$desconto_ponto);
      //Formata o valores para inserir no BD
      $valor_total = mysqli_real_escape_string($con,$_POST['valor']);
      $valort_ponto = str_replace(".","",$valor_total);  
      $valortformatado = str_replace(",",".",$valort_ponto);

      $valor_restante = $valortformatado - $descontoformatado;
      $valor_pg = $valortformatado - $descontoformatado;
      $idformapg = mysqli_real_escape_string($con,$_POST['idformapg']);
      $qtdparcelas = mysqli_real_escape_string($con,$_POST['qtdparcelas']);
    
    //Insere na tabela pagamentos
    $cad_passagem = mysqli_query($con,"INSERT INTO passagem (idcliente,embarque,desembarque,idagencia,obs,atendente,idviagem, poltrona, status_passagem, valor) values('$idcliente','$embarque','$desembarque','$idagencia','$obs','$atendente','$idviagem','$poltrona', '1',$valortformatado) ") or die(mysqli_error($con));       

// --------- selecionar ultimo idpassagem ---------------------// 
$query6 = sprintf("select max(idpassagem) as idpassagem from passagem"); 

// executa a query 
$dados6 = mysqli_query($con,$query6) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha6 = mysqli_fetch_array($dados6);
$idpassagemprox = $linha6['idpassagem']; 
// verifica se teve entrada
if($idpassagemprox >0) {
//------------Insere na tabela pontronas_ocupadas
$cad_poltronas_ocupadas = mysqli_query($con,"INSERT INTO poltronas_ocupadas (id_poltrona, idpassagem) values('$poltrona','$idpassagemprox') ") or die(mysqli_error($con)); 

//Insere na tabela pagamentos
    $cad_pagamento = mysqli_query($con,"INSERT INTO contas_receb_movi (idcliente,idpassagem,valor_total,desconto,qtdparcelas,data_movimento, idformapg, idsituacao) values('$idcliente','$idpassagemprox','$valortformatado','$descontoformatado','$qtdparcelas', '$date','$idformapg','$idsituacao') ") or die(mysqli_error($con));         
}
// --------- selecionar ultimo idmovimento ---------------------// 
$query6 = sprintf("select max(idmovimento) as idmovimento from contas_receb_movi"); 

// executa a query 
$dados6 = mysqli_query($con,$query6) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha6 = mysqli_fetch_array($dados6);
$idmovimentoprox = $linha6['idmovimento']; 

//verifica a situação do pagamento
if($idsituacao == 2){
    $cad_contas_receber = mysqli_query($con,"INSERT INTO contas_receber (idcliente, idmovimento, data_pg, idsituacao, idformapg, quem_recebeu, valor) 
        VALUES ('$idcliente', '$idmovimentoprox', '$date','2','$idformapg', '$quem_recebeu', '$valor_restante') ") or die(mysqli_error($con));  
}
         if(mysqli_affected_rows($con) == 1){ 
criaLog("Passagem Cadastrada", "Passagem numero $idpassagem");
            ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                  echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=passagem.php?idviagem=$idviagem'>";    
            }
          else{ ?>
                <div class="alert alert-danger alert-rounded">
                    <i class="ti-user"></i> Erro. Ocorreu algum problema no Cadastro!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
        <?php }   
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
                                        <a class="nav-link" href="viagem_encomenda.php?idviagem=<?php echo $idviagem ?>"><i class="mdi mdi-cash-multiple"></i> Encomendas</a>
                                      </li>
                                    </ul>   
                                <div class="card-body">
                                <form class="form-material m-t-40 row" action="" method="post">
                                    <div class="form-group m-b-40 col-md-3">
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cadastrarviagem">+ Nova Passagem</button>
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
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastrarcliente">Novo Cliente</button>
                                    </div>
                                </form>
                                    <div class="table-responsive m-t-40">
                                        <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>POLT.</th>          
                                                    <th>CLIENTE</th>
                                                    <th>RG</th>
                                                    <th>TEL</th>
                                                    <th>EMB.</th>
                                                    <th>DESEM.</th>
                                                    <th>OBS</th>
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
<a href="cliente_cadastro_ver.php?&idcliente=<?php echo $linha2['idcliente']?>"><?php echo $linha2['nome']?></a></td>
                                                    <td><?php echo $linha2['rg']?></td>
                                                    <td><?php echo $linha2['celular']?></td>
                                                    <td><?php echo $linha2['embarque']?></td>
                                                    <td><?php echo $linha2['desembarque']?></td>
                                                    <td><?php echo $linha2['obs']?></td>
                                                    <td><a href="" class="btn btn-danger btn-circle" role="button" data-toggle="modal" data-target="#passagem_cancelar<?php echo $linha2['idpassagem']?>"><i class="fa fa-trash"></i></a></td>
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
        <div id="layout_onibus">
            <table class="poltrona_esquerda" cellspacing="2" cellpadding="2">

                                
                    <tbody><tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_1">1</td> 
                        <td class="livre">2</td> 
                        <!-- Corredor-->
                        <td>&nbsp;</td> 
                        <!-- poltronas direita-->
                        <td class="livre"> 4</td> 
                        <td class="livre"> 3</td> 
                    </tr>
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_5">5</td> 
                        <td class="livre">6</td> 
                        <!-- Corredor-->
                        <td>&nbsp;</td> 
                        <!-- poltronas direita-->
                        <td class="livre"> 8</td> 
                        <td class="livre"> 7</td> 
                    </tr>
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_9">9</td> 
                        <td class="livre">10</td> 
                        <!-- Corredor-->
                        <td>&nbsp;</td> 
                        <!-- poltronas direita-->
                        <td class="livre"> 12</td> 
                        <td class="livre"> 11</td> 
                    </tr>
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_13">13</td> 
                        <td class="livre">14</td> 
                        <!-- Corredor-->
                        <td>&nbsp;</td> 
                        <!-- poltronas direita-->
                        <td class="livre"> 16</td> 
                        <td class="livre"> 15</td> 
                    </tr>
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_17">17</td> 
                        <td class="livre">18</td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 20</td> 
                        <td class="livre"> 19</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_21"> 
                            21 
                        </td> 
                        <td class="livre">
                            22                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 24</td> 
                        <td class="livre"> 23</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_25"> 
                            25 
                        </td> 
                        <td class="livre">
                            26                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 28</td> 
                        <td class="livre"> 27</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_29"> 
                            29 
                        </td> 
                        <td class="livre">
                            30                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 32</td> 
                        <td class="livre"> 31</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_33"> 
                            33 
                        </td> 
                        <td class="livre">
                            34                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 36</td> 
                        <td class="livre"> 35</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_37"> 
                            37 
                        </td> 
                        <td class="livre">
                            38                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 40</td> 
                        <td class="livre"> 39</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_41"> 
                            41 
                        </td> 
                        <td class="livre">
                            42                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 44</td> 
                        <td class="livre"> 43</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_45"> 
                            45 
                        </td> 
                        <td class="livre">
                            46                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class="livre"> 48</td> 
                        <td class="livre"> 47</td> 
                    </tr>
                    
                    <tr> 
                        <!-- poltronas esquerdas-->
                        <td class="livre class_49"> 
                            49 
                        </td> 
                        <td class="livre">
                            50                      </td> 

                        <!-- Corredor-->
                        <td>&nbsp;</td> 

                        <!-- poltronas direita-->
                                                <td class=""> </td> 
                        <td class=""> </td> 
                    </tr>
                                    </tbody></table>
            </div>  <!-- FIM LAYUT ONIBUS -->
                                </div>
                            </div>
                    </div>
                
                </div>

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrarviagem" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrarviagem">Cadastrar Passagem</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="nome">Pesquisar:</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Pesquisa por nome, celular ou rg">
                                                        <input type="hidden" class="form-control" id="idcliente" name="idcliente">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="sexo">Sexo:</label>
                                                        <input type="text" class="form-control" id="sexo" name="sexo" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="celular">Celular:</label>
                                                        <input type="text" class="form-control" id="celular" name="celular" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="cpf">CPF:</label>
                                                        <input type="text" class="form-control" id="cpf" name="cpf" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="rg">Identidade</label>
                                                        <input type="text" class="form-control" id="rg" name="rg" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="nascimento">Dt. Nascimento</label>
                                                        <input type="text" class="form-control" id="nascimento" name="nascimento" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
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
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="embarque">Embarque</label>
                                                        <input type="text" class="form-control" id="embarque" name="embarque" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                     <label for="desembarque">Desembarque</label>
                                                        <input type="text" class="form-control" id="desembarque" name="desembarque">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                     <label for="poltrona">Poltrona</label>
                                                    <select class="form-control" name="poltrona" id="poltrona" required>
                                                        <option value=""></option>
                                                        <?php 
                                                        if($total2 <=0){
                                                        $q = mysqli_query($con,"SELECT p.numero
                                                        FROM poltronas p") or die(mysqli_error());    
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
                                                         }
                                                        else {
                                                        $q = mysqli_query($con,"SELECT p.numero
                                                        FROM poltronas p
                                                        WHERE NOT EXISTS(SELECT *
                                                        FROM poltronas_ocupadas po, passagem pa
                                                        WHERE p.idpoltrona = po.id_poltrona and pa.idpassagem = $idpassagem)") or die(mysqli_error());    
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
                                                       } ?>  
                                                  </select> 
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="valor">Valor</label>
                                                        <input type="text" class="form-control" id="valor" name="valor" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
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
                                                <div id="hiddenparcelas" class="col-md-2" style="visibility:hidden;">
                                                    <div class="form-group">
                                                        <label for="qtdparcelas">Parcelas</label>
                                                        <select class="form-control" name="qtdparcelas" id="qtdparcelas">
                                                            <option value=""></option>
                                                            <option value="1">1x</option>
                                                            <option value="2">2x</option>
                                                            <option value="3">3x</option>
                                                            <option value="4">4x</option>
                                                            <option value="5">5x</option>
                                                            <option value="6">6x</option>
                                                            <option value="7">7x</option>
                                                            <option value="8">8x</option>
                                                            <option value="9">9x</option>
                                                            <option value="10">10x</option>
                                                            <option value="11">11x</option>
                                                            <option value="12">12x</option>
                                                      </select> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                     <label for="valor">Obs</label>
                                                        <input type="text" class="form-control" id="obs" name="obs">
                                                    </div>
                                                </div>
                                            </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                    <button type="submit" name="enviar" id="enviar" class="btn btn-primary">Cadastrar</button>
                                                    <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-success">Salvar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" id="cadastrarcliente" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="cadastrarviagem">Cadastrar Cliente</h4>
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
                                        <input type="date" class="form-control" id="nascimento" name="nascimento" required>
                                        <span class="bar"></span>
                                    </div>
                               
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="sexo">Sexo</label>
                                        <select class="form-control p-0" id="sexo" name="sexo" required>
                                            <option></option>
                                            <option>Masculino</option>
                                            <option>Feminino</option>
                                        </select><span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="cpf">CPF</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" OnKeyPress="formatar('###.###.###-##', this)">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="rg">RG</label>
                                        <input type="text" class="form-control" id="rg" name="rg" placeholder="RG">
                                        <span class="bar"></span>
                                    </div>
                                
                                    <div class="form-group m-b-40 col-md-4">
                                        <label for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" OnKeyPress="formatar('##-#####-####', this)">
                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group m-b-40 col-md-8">
                                        <label for="obs">Observação</label>
                                        <input type="text" class="form-control" id="obs" name="obs" placeholder="Observação">
                                        <input type="hidden" class="form-control" id="data_cadastro" name="data_cadastro" value="<?php echo $datebr ?>">
                                        <input type="hidden" class="form-control" id="atendente" name="atendente" value="<?php echo $_SESSION['UsuarioNome']?>">
                                        <input type="hidden" class="form-control" id="idviagem" name="idviagem" value="<?php echo $idviagem ?>">
                                        <span class="bar"></span>
                                    </div>
                                           <div class="form-group m-b-40 col-md-12">
                                        <input type="submit" class="btn btn-success" value="Cadastrar">
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
                                                    <button type="submit" name="cancelar" id="cancelar" class="btn btn-danger">Confirmar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                    <?php }?>
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
