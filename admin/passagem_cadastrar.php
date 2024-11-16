<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
  // Destrói a sessão por segurança
  session_destroy();
  // Redireciona o visitante de volta pro login
  header("Location: ../restrita.php"); exit;
}
$date2 = date('Y-m-d H:i'); 
include "../verificanivel.php";
include "../config.php"; 
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


include "../funcoes.php";

// Dados da tabela cliente
$nome = mysqli_real_escape_string($con,$_POST['nome']);
$documento = mysqli_real_escape_string($con,$_POST['documento']);
$sexo = mysqli_real_escape_string($con,$_POST['sexo']);
$org = mysqli_real_escape_string($con,$_POST['org']);
$mae = mysqli_real_escape_string($con,$_POST['mae']);
 //$nascimento = $_POST['rg'];
//$nascimento = mysqli_real_escape_string($con,date('Y/m/d', strtotime($_POST['nascimento']))); 
$celular = mysqli_real_escape_string($con,$_POST['celular']);
//Fim dos dados da tabela cliente
      $idviagem = mysqli_real_escape_string($con,$_POST['idviagem']);
      $idcliente = mysqli_real_escape_string($con,$_POST['idcliente']);
      $idembarque = mysqli_real_escape_string($con,$_POST['idembarque']);
      $desembarque = mysqli_real_escape_string($con,$_POST['desembarque']);
      $idagencia = mysqli_real_escape_string($con,$_POST['idagencia']);
      $poltrona = mysqli_real_escape_string($con,$_POST['poltrona']);
      $hembarque = mysqli_real_escape_string($con,$_POST['hembarque']);
      $atendente = $_SESSION['UsuarioNome'];
      $idsituacao = mysqli_real_escape_string($con,$_POST['idsituacao']);
      $obs = mysqli_real_escape_string($con,$_POST['obs']);
      $quem_recebeu = $_SESSION['UsuarioNome'];
      //Campos Tabela Contas_Receber
      $desconto = mysqli_real_escape_string($con,$_POST['desconto']);
      $desconto_ponto = str_replace(".","",$desconto);  
      $descontoformatado = str_replace(",",".",$desconto_ponto);
      //Formata o valores para inserir no BD
      $valor_total = mysqli_real_escape_string($con,$_POST['valor']);
      $valort_ponto = str_replace(".","",$valor_total);  
      $valortformatado = str_replace(",",".",$valort_ponto);

      $valor_restante = ((float)$valortformatado - (float)$descontoformatado);
      $valor_pg = ((float)$valortformatado - (float)$descontoformatado);
      $idformapg = mysqli_real_escape_string($con,$_POST['idformapg']);
      //$qtdparcelas = mysqli_real_escape_string($con,$_POST['qtdparcelas']);
    
$dados = mysqli_query($con,"select distinct p.idpassagem, r.idrota, p.embarque, p.desembarque, v.idviagem, v.dataviagem, v.horaviagem, substring_index(c.nome, ' ', 1)  as primeironome, substring_index(c.nome, ' ', -2)  as segundonome, c.sexo, c.nascimento, c.documento, c.celular, p.poltrona, a.nome as agencia, c.idcliente, crm.idmovimento, crm.valor_total, p.hembarque, sc.situacao, c1.nome as corigem, e1.uf as uforigem, c2.nome as cdestino, e2.uf as ufdestino, COALESCE(pe.nome, p.embarque) AS ponto_embarque, pe.idembarque
from passagem p
inner join clientes c on c.idcliente = p.idcliente
inner join viagem v on p.idviagem = v.idviagem
inner join agencia a on a.idagencia = p.idagencia
inner join rota r on r.idrota = v.idrota
left join pontos_embarque pe on pe.idembarque = p.idembarque
inner join contas_receb_movi crm on crm.idpassagem = p.idpassagem
inner join situacao_caixa sc on sc.idsituacao = crm.idsituacao
INNER JOIN cidades c1 ON c1.id = r.corigem
INNER JOIN cidades c2 on c2.id = r.cdestino
INNER JOIN estados e1 on e1.id = r.uforigem
INNER JOIN estados e2 on e2.id = r.ufdestino
where v.idviagem = $idviagem and p.status_passagem <> 4
order by p.poltrona") or die(mysqli_error($con)); 

// transforma os dados em um array 
$linha = mysqli_fetch_assoc($dados); 

// calcula quantos dados retornaram 
$total = mysqli_num_rows($dados);

@$idclienteantes = $linha['idcliente'];                              


if($valortformatado > 300){
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Valor muito alto para uma passagem <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  }  
else {

// --------- selecionar poltronas ocupadas ---------------------// 

// executa a query 
$dados_poltronas = mysqli_query($con,"SELECT poltrona from passagem 
where idviagem = $idviagem and idcliente = $idcliente
and status_passagem <> 4") or die(mysqli_error($con));  

$linha_poltronass = mysqli_fetch_array($dados_poltronas);       

$total_poltronas = mysqli_num_rows($dados_poltronas);

if($total_poltronas) { 
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>O mesmo cliente não pode ter mais de 1 poltrona! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";  }
               else {

    //Insere na tabela passagem
    $cad_passagem = mysqli_query($con,"INSERT INTO passagem (idcliente,idembarque,desembarque,idagencia,obs,atendente,idviagem, poltrona, status_passagem, valor, data_cadastro, hembarque) values('$idcliente','$idembarque','$desembarque','$idagencia','$obs','$atendente','$idviagem','$poltrona', '1',$valortformatado, '$date2','$hembarque')") or die(mysqli_error($con));       
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
$cad_poltronas_ocupadas = mysqli_query($con,"INSERT INTO poltronas_ocupadas (id_poltrona, idpassagem, idviagem) values('$poltrona','$idpassagemprox','$idviagem') ") or die(mysqli_error($con)); 

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
    $cad_contas_receber = mysqli_query($con,"INSERT INTO contas_receber (idcliente, idmovimento, data_pg, idsituacao, idformapg, quem_recebeu, valor, obs) 
        VALUES ('$idcliente', '$idmovimentoprox', '$date2','2','$idformapg', '$quem_recebeu', '$valor_restante', '$obs') ") or die(mysqli_error($con));  
}
         if(mysqli_affected_rows($con) == 1){ 
criaLog("Passagem Cadastrada", "Passagem numero $idpassagem");


    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Passagem Cadastrada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: cliente_imagens.php?idcliente=$idcliente");
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=passagem.php?idviagem=$idviagem'>";               
            }
          else{ 
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao Cadastrar Passagem <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    //header("Location: agenda.php");               
               echo "<meta HTTP-EQUIV='refresh' CONTENT='5;URL=passagem.php?idviagem=$idviagem'>";  }
}
}
?>
        </div>

    </div>