<!DOCTYPE html>
<html lang="en">

<head>

<?php 
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i'); 
$datetrat = date('Y-m-d H:i'); 
$datebr = date('d-m-Y H:i'); 
$datebr2 = date('d-m-Y');
$dia = date('d');
$mes = (date('m')+1);
$ano = date('Y');

$datapg = $dia."-".$mes."-".$ano;
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
		<style type="text/css">
			.carregando{
				color:#ff0000;
				display:none;
			}
		</style>
</head>

<body class="fix-header card-no-border">

<?php 
include "../verificanivel.php"; 
include "../funcoes.php"; 
    
    
    if(isset($_GET['idpassagem'])){
        $classb = 'escondida';
        $idpassagem = $_GET['idpassagem'];
        $classd = '';
    }else{
        $classb = '';
        $classd = 'escondida'; 
        $idpassagem = '';
    }
    
    
?>
		<script type='text/javascript'>
			$(document).ready(function(){
				$("select[name='idprocedimento']").change(function(){
					var $valor = $("input[name='valor']");
					$.getJSON('retornaPreco.php',{ 
						idprocedimento: $( this ).val() 
					},function( json ){
						$valor.val( json.valor );
					});
				});
			});
		</script>
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>

<?php
$idcliente = $_GET['idcliente'];
@$total_proced = $_GET['valor'];
@$lastproced_trat = $_GET['id'];
$query = sprintf("SELECT t.nometrat,t.datacadastro,t.idtratamento,t.iddentista,t.datainicio,t.datafim,t.status_tratamento,t.idcliente,d.nome as dentista,st.status from tratamento t 
inner join dentista d on t.iddentista = d.iddentista 
inner join status_tratamento st on st.idstatustrat = t.status_tratamento
where t.idcliente = $idcliente
order by t.idtratamento desc"); 

// executa a query 
$dados = mysqli_query($con,$query) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_array($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados);
    
// ----------------------- Usuario ----------------------------    
// executa a query 
$usuarios = mysqli_query($con,"SELECT nivel FROM usuario where id_usuario=$usuarioid") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linhausuario = mysqli_fetch_assoc($usuarios); 
// --------- Verifica Anamnese ---------------------// 
$query2 = sprintf("SELECT * from anamnese a, clientes c where a.idcliente = c.idcliente and a.idcliente = $idcliente"); 

// executa a query 
$dados2 = mysqli_query($con,$query2) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha2 = mysqli_fetch_array($dados2); 

// calcula quantos dados retornaram 
$total2 = mysqli_num_rows($dados2);

// --------- Verifica Paciente ---------------------// 
$query3 = sprintf("SELECT * from clientes where idcliente = $idcliente"); 

// executa a query 
$dados3 = mysqli_query($con,$query3) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha3 = mysqli_fetch_array($dados3); 
// --------- Evoluções ---------------------// 
$query4 = sprintf("select idcliente, nome from clientes where idcliente = $idcliente"); 

// executa a query 
$dados4 = mysqli_query($con,$query4) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha4 = mysqli_fetch_array($dados4); 

?>
    <div id="main-wrapper">
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Tratamento</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Inicio</a></li>
                        <li class="breadcrumb-item"><?php echo $linha3['nome'] ?></li>
                        <li class="breadcrumb-item active">Tratamento</li>
                    </ol>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
<?php
if($_POST){
      // inicio dos campos da tabela parcelas
      //$idtratamento = $_GET['idtratamento'];
      $valortotal = mysqli_real_escape_string($con,$_POST['valor']);
      $qtdparcelas = mysqli_real_escape_string($con,$_POST['qtdparcelas']);
    // divide a data da venda por partes
      $vencimento = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['vencimento'])));
      $partes = explode("/",$vencimento); 
      $ano = $partes[0]; 
      $mes = $partes[1]; 
      $dia = $partes[2];
    // divide o valor pelo numero de parcelas
      $valor_parcela = mysqli_real_escape_string($con,$_POST['valparcelado']);
      $parcela = 1;
    //fim dos campos da tabela parcelas
      $idformapg = mysqli_real_escape_string($con,$_POST['idformapg']);
      //$idprocedimento = mysqli_real_escape_string($con,$_POST['idprocedimento']);
      //$idprocedimento = implode(', ', $_POST['idprocedimento']);
     // $data_movimento = $_POST['data_movimento'];
      //$dente = mysqli_real_escape_string($con,$_POST['dente']);
      //$face = mysqli_real_escape_string($con,$_POST['face']); 
      $num_doc = mysqli_real_escape_string($con,$_POST['num_doc']);
      $desconto = mysqli_real_escape_string($con,$_POST['desconto']);
      $val_desconto = $total_proced - $desconto;
      $iddentista = mysqli_real_escape_string($con,$_GET['iddentista']);
      $datainicio = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['datainicio'])));
      $datacadastro = mysqli_real_escape_string($con,date('Y/m/d H:i', strtotime($_POST['datacadastro'])));
      $atendente = mysqli_real_escape_string($con,$_POST['atendente']); 
      $nometrat = mysqli_real_escape_string($con,$_POST['nometrat']);   
      $emitente = mysqli_real_escape_string($con,$_POST['emitente']);   
      $agencia = mysqli_real_escape_string($con,$_POST['agencia']);   
      $banco = mysqli_real_escape_string($con,$_POST['banco']);     
      $obs = mysqli_real_escape_string($con,$_POST['obs']);     
    
      $cad = mysqli_query($con,"update tratamento set idcliente = '$idcliente', iddentista='$iddentista', datainicio='$datainicio', status_tratamento = 1, datacadastro = '$datacadastro', atendente='$atendente', nometrat='$nometrat', obs='$obs' where idtratamento = $idtratamento") or die(mysqli_error($con)); 
    
    //Insere na tabela pagamentos
    $cad_pagamento = mysqli_query($con,"INSERT INTO contas_receb_movi (idmovimento,idcliente,idtratamento,valor,data_movimento,idformapg,desconto,qtdparcelas,valor_total) values(NULL,'$idcliente','$idtratamento','$val_desconto','$datetrat','$idformapg','$desconto','$qtdparcelas','$total_proced') ") or die(mysqli_error($con));         

// --------- selecionar ultimo idmovimento ---------------------// 
$query6 = sprintf("select max(idmovimento) as idmovimento from contas_receb_movi"); 

// executa a query 
$dados6 = mysqli_query($con,$query6) or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha6 = mysqli_fetch_array($dados6);
$idmovimentoprox = $linha6['idmovimento']; 
// começa um loop de gravação
while($qtdparcelas >0) {
// realiza a gravação no banco de dados
$data = $ano.'/'.$mes.'/'.$dia;// iguala a data a data da venda
$sqlinsert ="INSERT INTO contas_receber (idparcelas, parcela, idcliente, idmovimento, vencimento, valor, idsituacao, num_doc,emitente,agencia,banco) VALUES (null, '$parcela', '$idcliente', '$idmovimentoprox', '$data', '$valor_parcela','1','$num_doc','$emitente','$agencia','$banco')";
mysqli_query($con,$sqlinsert) or die(mysqli_error($con));
$parcela++;
$qtdparcelas=$qtdparcelas-1;// subtrai 1 a variavel parcela
if($dia >28){
$mes++;
$dia=28;
}
elseif ($mes<12){
$mes++; }// adiciona +1 a variavel mes
else{
$mes = 1;
$ano++;}
}
          if(mysqli_affected_rows($con) == 1){ 
criaLog("Tratamento Cadastrado", "Tratamento numero $idtratamento");
            ?>
             <div class="alert alert-success"> 
                 Cadastro Efetuado com Êxito!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
                    <?php
                  echo "<meta HTTP-EQUIV='refresh' CONTENT='2;URL=atendimento_tratamento.php?idcliente=$idcliente'>";    
            }
          else{ ?>
                <div class="alert alert-danger alert-rounded">
                    <i class="ti-user"></i> Erro. Ocorreu algum problema no Cadastro!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
        <?php }
        }           
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
                                <ul class="nav nav-tabs">
                                      <li class="nav-item">
                                        <a class="nav-link" href="passagem.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-account-outline"></i>Cliente</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="passagem_atendimento.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-hospital"></i>Passagem</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link active" href="passagem_agendar.php?idcliente=<?php echo $idcliente ?>"><i class="mdi mdi-hospital"></i>Nova Passagem</a>
                                      </li>
                                    </ul>
                                    <div id="procedimento">
                                        <button type="button" name="nproced" id="nproced" onclick="return confirm('Deseja realmente cadastrar nova passagem?!')" class="btn btn-trat btn-warning <?=$classb ?>">Nova Passagem</button>
                                    </div>
                                    <div id="divId" class="<?=$classd ?>">
                                    <div class="card-body wizard-content">
                                <form action="<?php $_SERVER['PHP_SELF']?>" class="form" method="post">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cliente">Nome do Cliente</label>
                                                 <label for="idprocedimento">Procedimento</label>
                                                    <input type="hidden" name="idcliente" id="idcliente" value="<?=$idcliente ?>">
                                                    <input type="hidden" class="form-control" id="valortotal" name="valortotal" value="<?=$total_proced ?>">  
                                                    <input type="text" class="form-control" id="cliente" name="cliente" value="<?php echo $linha4['nome'] ?>" readonly> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="origem">Origem</label>
                                                    <input type="text" class="form-control" id="origem" name="origem"> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="destino">Destino</label>
                                                    <input type="text" class="form-control" id="destino" name="destino"> 
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="data_passagem">Data Passagem</label>
                                                        <input type="date" class="form-control" id="data_passagem" name="data_passagem" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="valortotal">Valor Total</label>
                                                        <input type="text" class="form-control" id="valortotal" name="valortotal" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                 <label for="formapg">Qtd Parcelas</label>
                                                    <select class="custom-select form-control" name="qtdparcelas" id="qtdparcelas" onchange="calcularparcelas()" required>
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
										          </select> 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="entrada">Entrada (R$)</label>
                                                    <input type="text" class="form-control" id="entrada" name="entrada" onchange="calcularparcelas()">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="valor">Valor Parcelado</label>
                                                    <input type="text" class="form-control" id="valparcelado" name="valparcelado" onfocus="calcularparcelas()" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                 <label for="idformapg">Forma de Pagamento</label>
                                                    <select class="custom-select form-control" name="idformapg" id="idformapg" required onchange="checkpg()">
                                                        <option>Tipo de Pagamento</option>
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="vencimento">Data 1º Vencimento</label>
                                                    <input type="text" class="form-control" id="vencimento" name="vencimento" value="<?php echo $datapg;?>">
                                                </div>
                                            </div>
                                            
                                            <div id="hiddenpg" class="col-md-2" style="visibility:hidden;">
                                                <div class="form-group">
                                                    <label for="num_doc">Numero</label>
                                                    <input type="text" class="form-control" id="num_doc" name="num_doc"> 
                                                </div>
                                            </div>
                                            <div id="hiddenemitente" class="col-md-2" style="visibility:hidden;">
                                                <div class="form-group">
                                                    <label for="emitente">Emitente</label>
                                                    <input type="text" class="form-control" id="emitente" name="emitente"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="data_cadastro" id="data_cadastro" value="<?php echo $datetrat;?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="atendente" id="atendente" value="<?php echo $_SESSION['UsuarioNome']?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                           <div class="form-group m-b-40 col-md-12">
                                        <input type="submit" class="btn btn-success" value="Cadastrar">
                                        <button type="button" class="btn btn-canc-trat btn-warning">Cancelar</button>
                                        </div>
                                    </section>
                                </form>
                                    </div>
                                <div id="lista_trat">
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Dentista</th>
                                                    <th>Tratamento</th>
                                                    <th>Inicio</th>
                                                    <th>status Tratamento</th>
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
                                                    <td><?php echo $linha['idtratamento']?></td>
                                                    <td><?php echo $linha['dentista']?></td>
                                                    <td><?php echo $linha['nometrat']?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($linha['datainicio'])); ?></td>
                                                    <?php if($linha['status_tratamento']==1) {?>
                                                    <td width="50" align="center"><span class="label label-warning pull-center"><?php echo $linha['status']?></span></td> <?php }
                                                    else { ?>
                                                    <td width="50" align="center"><span class="label label-info pull-center"><?php echo $linha['status']?></span></td>
                                                    <?php
                                                    }?>
                                                    <td width="70"><a class="btn btn-success" onclick="return confirm('Deseja realmente Efetuar este Atendimento?')"  href="atendimento_finaliza.php?idtratamento=<?php echo $linha['idtratamento'] ?>&idcliente=<?php echo $linha['idcliente']?>">Efetuar Atendimento</a> 
                                                    </td>
                                                </tr>
                                            <?php 
                                            // finaliza o loop que vai mostrar os dados 
                                                    }while($linha = mysqli_fetch_array($dados)); 
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

<?php 
include "../rodape.php";
?>

    </div>
		<script type="text/javascript">
		$(function(){
			$('#iddentista').change(function(){
				if( $(this).val() ) {
					$('#idprocedimento').hide();
					$('.carregando').show();
					$.getJSON('procedimento_categoria.php?iddentista=',{iddentista: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">Escolha o Procedimento</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].idprocedimento + '">' + j[i].descricao + '</option>';
						}	
						$('#idprocedimento').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#idprocedimento').html('<option value="">– Escolha o Procedimento –</option>');
				}
			});
		});
		</script>
                    
<script type="text/javascript">
$(document).ready(function() {
    $("#enviar").click(function() {
        var idtratamento = $("#idtratamento").val(),
        var idtratamentoPost = idtratamento.val();
        var evolucao = $("#evolucao").val(),
        var evolucao_Post = evolucao.val();
        var data_evo = $("#data_evo").val(),
        var data_evoPost = data_evo.val();
        var resp_evo = $("#resp_evo").val(),
        var resp_evoPost = resp_evo.val();    
        $.post("jquery_evolucao_cadastra.php", {idtratamento: idtratamentoPost, evolucao: evolucao_Post, data_evo: data_evoPost, resp_evo: resp_evoPost},
        function(data){
         $("#resposta").html(data);
         }
         , "html");
    });
});
</script>
                    
                    
<script>


$('.btn-trat').on('click',function(){
           // $('#idtratamento').val(dados.id);
            //$('#procedimento').slideToggle();
            //$('#lista_trat').slideToggle(); // aparece o div
            //$('#divId').show(); // aparece o div
           $.ajax({method:'post',url:'tratamento_ajax.php',
           dataType: 'json',
           data:{idcliente:$('#idcliente').val(),data_cadastro:$('#data_cadastro').val()},
           success: function(dados){
            $('#idpassagem').val(dados.id);
            $('#procedimento').slideToggle();
            $('#lista_trat').slideToggle(); // aparece o div
            $('#divId').show(); // aparece o div
           }
           });
    
});
    $('.btn-canc-trat').on("click", function() {
    $('#divId').slideToggle();
    $('#tabela-pro').slideToggle();
    $('#procedimento').show();
    $('#lista_trat').show();
			});
</script>
</body>
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
        <link href="../assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
        <script src="../assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <link href="../assets/odontograma/odontograma.css" rel="stylesheet">  
        <style type="text/css">
.escondida {
    display:none;
}
</style>
</html>
