<?php
session_start();
include "config.php";
global $con;

if (isset($_GET['etapa'])) {
    if ($_GET['etapa'] === 'validar_codigo' && isset($_SESSION['codigo_cliente'])) {
        // Validação do ID do Contrato (idcontrato) inserido
        $idcontrato = mysqli_real_escape_string($con, $_SESSION['codigo_cliente']);
        
        // Verifica se o idcontrato existe na tabela usuario_contrato
        $query = "SELECT idcontrato, nome FROM usuario_contrato WHERE idcontrato = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $idcontrato, );
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // idcontrato válido, armazena o ID do contrato e marca como validado
      		$contrato = $result->fetch_assoc();
            $_SESSION['ContratoID'] = $contrato['idcontrato'];
			$_SESSION['ContratoNome'] = $contrato['nome'];  // Armazena o nome na sessão
            $_SESSION['ContratoValidado'] = true;  // Sinaliza que o contrato foi validado
            header("Location: login_usuario.php");  // Redireciona para a próxima etapa de login
            exit();
        } else {
            // Redireciona para index.php com um parâmetro indicando que a sessão expirou
            header("Location: /bredbus?mensagem=contratoerrado");
            session_unset();
            session_destroy();
            exit();
        }
    } elseif ($_GET['etapa'] === 'login_usuario') {
        // Validação de Usuário e Senha Vinculados ao Contrato
        $usuario = mysqli_real_escape_string($con, $_POST['usuario']);
        $senha = mysqli_real_escape_string($con, $_POST['senha']);
        $contrato_id = $_SESSION['ContratoID'];

        // Consulta para validar o login, status ativo e necessidade de alteração de senha
		$sql = "SELECT u.id_usuario, u.u_nome, u.usuario, u.nivel, u.altera_senha, u.u_nivel, uc.nome AS contrato_nome, uc.idcontrato AS ContratoID
        FROM usuario u
        JOIN usuario_nivel un ON u.nivel = un.idnivel
        JOIN usuario_contrato uc ON u.idcontrato = uc.idcontrato  -- Vinculação com usuario_contrato
        WHERE u.usuario = ? 
          AND u.senha = ? 
          AND u.idcontrato = ? 
          AND u.ativo = 1 
        LIMIT 1";
        
        $stmt = $con->prepare($sql);
        $senha_hash = SHA1($senha);  // Criação do hash SHA1 para a senha
        $stmt->bind_param("ssi", $usuario, $senha_hash, $contrato_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows != 1) {
                        // Redireciona para index.php com um parâmetro indicando que a sessão expirou
            header("Location: /bredbus/login_usuario.php?mensagem=loginerrado");
            exit();
        } else {
            // Dados do usuário encontrados
            $resultado = $result->fetch_assoc();

// Após o login bem-sucedido
$_SESSION['UsuarioID'] = $resultado['id_usuario'];
$_SESSION['usuario'] = $resultado['usuario'];
$_SESSION['UsuarioNome'] = $resultado['u_nome'];
$_SESSION['UsuarioNivel'] = $resultado['nivel'];
$_SESSION['DescricaoNivel'] = $resultado['u_nivel'];
$_SESSION['ContratoID'] = $resultado['ContratoID'];  // Armazena o idcontrato na sessão
$_SESSION['ContratoNome'] = $resultado['contrato_nome'];  // Nome associado ao contrato, se necessário
            
            // Verifica se é necessário alterar a senha no primeiro login
            if ($resultado['altera_senha'] == '1') {
                header("Location: primeiro_login.php");  // Redireciona para a página de alteração de senha
                exit();
            } else {
                header("Location: admin/inicio.php");  // Redireciona para a página inicial do sistema
                exit();
            }
        }
    }
}
?>
