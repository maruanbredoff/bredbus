<?php
// carrega_cidades.php

// Inclua a conexão com o banco de dados
include "../config.php";

// Verifica se o ID do estado foi enviado
if (isset($_POST['estado_id'])) {
    $estado_id = intval($_POST['estado_id']); // Converte para inteiro para segurança

    // Prepara a consulta para buscar cidades com base no estado_id
    $sql = "SELECT id, nome FROM cidades WHERE estado = ? ORDER BY nome";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $estado_id);
    $stmt->execute();
    
    // Armazena os resultados
    $result = $stmt->get_result();
    $cidades = [];

    // Monta um array associativo com os dados das cidades
    while ($cidade = $result->fetch_assoc()) {
        $cidades[] = [
            'id' => $cidade['id'],
            'nome' => $cidade['nome']
        ];
    }

    // Retorna o array de cidades em formato JSON
    echo json_encode($cidades);
} else {
    // Retorna uma resposta vazia se estado_id não for enviado
    echo json_encode([]);
}

// Fecha a conexão e a preparação
$stmt->close();
$con->close();
?>
