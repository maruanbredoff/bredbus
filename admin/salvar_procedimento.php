<?php
include_once('../config.php');
extract($_POST);
$cad = mysqli_query($con,"INSERT INTO procedimento_tratamento (id,idtratamento, idprocedimento, dente, face, valor, idstatustrat) values(null,'$idtratamento','$idprocedimento','$dente','$face','$valor','1') ") or die(mysqli_error($con)); 
include "../funcoes.php";
criaLog("Procedimento de Tratamento Cadastrado", "Procedimento numero $idprocedimento");
// --------- soma dos procedimentos ---------------------//   
$query_proced_soma = sprintf("SELECT sum(pt.valor) as total FROM procedimento_tratamento pt, tratamento t, procedimento p where pt.idprocedimento = p.idprocedimento and pt.idtratamento = t.idtratamento and pt.idtratamento = $idtratamento"); 

$dados_proced_soma = mysqli_query($con,$query_proced_soma) or die(mysqli_error($con)); 
// transforma os dados em um array 

$linha_proced_soma = mysqli_fetch_array($dados_proced_soma);

$totalproced = $linha_proced_soma['total'];

?>
<meta http-equiv="refresh" content='0;url=tratamento.php?idcliente=<?=$idcliente?>&idtratamento=<?=$idtratamento?>&valor=<?=$totalproced?>'>