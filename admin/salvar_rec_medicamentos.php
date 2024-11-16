<?php
include_once('../config.php');
$iddentistarec = $_POST['iddentistapost'];
$iddentistaget = $_POST['iddentistaget'];
extract($_POST);
$cad_pagamento = mysqli_query($con,"INSERT INTO receita_medicamento (idrmedicamento,idmedicamento,tamanho,qtd,unidade,modo_usar,idreceita,tipouso) values(NULL,'$idmedicamento','$tamanho','$qtd','$unidade','$modo_usar','$idreceita','$tipouso') ") or die(mysqli_error($con)); 

if($iddentistaget==null){
?>
<meta http-equiv="refresh" content='0;url=cliente_receitas.php?idcliente=<?=$idcliente?>&idreceita=<?=$idreceita?>&iddentista=<?=$iddentistarec?>'>
<?php } else {?>
<meta http-equiv="refresh" content='0;url=cliente_receitas.php?idcliente=<?=$idcliente?>&idreceita=<?=$idreceita?>&iddentista=<?=$iddentistaget?>'>
<?php } ?>