<?php
include_once("../config.php");

function retorna($idprocedimento, $con){
	$result_aluno = "SELECT * FROM procedimento where idprocedimento = '$idprocedimento' LIMIT 1";
	$resultado_aluno = mysqli_query($con, $result_aluno);
	if($resultado_aluno->num_rows){
		$row_aluno = mysqli_fetch_assoc($resultado_aluno);
		$valores['valor'] = $row_aluno['valor'];
	}else{
		$valores['valor'] = 'Aluno não encontrado';
	}
	return json_encode($valores);
}

if(isset($_GET['idprocedimento'])){
	echo retorna($_GET['idprocedimento'], $con);
}
?>