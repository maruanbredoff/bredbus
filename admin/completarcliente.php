<?php
include_once("conexao.php");

function retorna($nome, $conn){
	$result_aluno = "SELECT * FROM clientes WHERE nome like '%$nome%' or celular like '%$nome%' or documento like '%$nome%'";
	$resultado_aluno = mysqli_query($conn, $result_aluno);
	if($resultado_aluno->num_rows){
		$row_aluno = mysqli_fetch_assoc($resultado_aluno);
		$valores['documento'] = $row_aluno['documento'];
		$valores['org'] = $row_aluno['org'];
		$valores['sexo'] = $row_aluno['sexo'];
		$valores['nome'] = $row_aluno['nome'];
		$valores['mae'] = $row_aluno['mae'];
		$valores['celular'] = $row_aluno['celular'];
		$valores['nascimento'] = $row_aluno['nascimento'];
		$valores['idcliente'] = $row_aluno['idcliente'];
	}else{
		$valores['nome'] = 'Cliente não encontrado';
	}
	return json_encode($valores);
}

if(isset($_GET['nome'])){
	echo retorna($_GET['nome'], $conn);
}
?>