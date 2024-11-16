<?php
// Inicia a sessão apenas se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verifica se o usuário está logado e se o idcontrato está disponível na sessão
if (!isset($_SESSION['UsuarioID']) || !isset($_SESSION['ContratoID'])) {
    // Redireciona para a página de login se o usuário não estiver autenticado
    header("Location: index.php");
    exit();
}

// Define uma variável para o idcontrato atual, disponível para uso em outras páginas
$contrato_id = $_SESSION['ContratoID'];
$contrato_nome=  $_SESSION['ContratoNome'];

// Define o tempo limite de sessão em segundos (60 minutos)
define('TEMPO_LIMITE_SESSAO', 900); 

// Verifica se o usuário está logado
if (isset($_SESSION['UsuarioID'])) {
    // Verifica se a última atividade foi registrada
    if (isset($_SESSION['ultima_atividade'])) {
        // Calcula o tempo desde a última atividade
        $tempo_inativo = time() - $_SESSION['ultima_atividade'];

        // Verifica se o tempo inativo excede o limite
        if ($tempo_inativo > TEMPO_LIMITE_SESSAO) {
            // Tempo limite atingido, desloga o usuário
            session_unset(); // Remove as variáveis da sessão
            session_destroy(); // Destroi a sessão

            // Redireciona para index.php com um parâmetro indicando que a sessão expirou
            header("Location: /bredbus?mensagem=expirada");
            exit;
        }
    }

    // Atualiza o horário da última atividade para o horário atual
    $_SESSION['ultima_atividade'] = time();
} else {
    // Caso o usuário não esteja logado, redireciona para a página de login
    header("Location: /bredbus");
    exit;
}
?>
