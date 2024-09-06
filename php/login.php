<?php
// Incluir o arquivo de conexão com o banco de dados
require('conectar.php');

// Inicializar variáveis para mensagens de erro e sucesso
$errorMessage = '';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar os dados do formulário
    $userIdent = $_POST['userIdent'];
    $userPassword = $_POST['userPassword'];
    
    // Validar os dados
    if (empty($userIdent) || empty($userPassword)) {
        $errorMessage = 'Nome/CPF e senha são obrigatórios.';
    } else {
        // Preparar a consulta SQL para verificar o usuário
        $sql = "SELECT userID, userNome, userCpf, userPassword FROM gerenciadorsenhas.users WHERE (userCpf = ? OR userToken = ?)";
        if ($stmt = $conn->prepare($sql)) {
            // Vincular parâmetros
            $stmt->bind_param("ss", $userIdent, $userIdent);
            $stmt->execute();
            $stmt->store_result();
            
            // Verificar se o usuário existe
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($userID, $userNome, $userCpf, $storedHash);
                $stmt->fetch();
                
                // Verificar a senha fornecida pelo usuário com o hash MD5 armazenado
                if (md5($userPassword) === $storedHash) {
                    // Login bem-sucedido
                    session_start();
                    $_SESSION['userID'] = $userID;
                    $_SESSION['userNome'] = $userNome;
                    header("Location: store_password.php?userID=$userID"); // Redirecionar para a página de registro com o ID do usuário
                    exit();
                } else {
                    $errorMessage = 'Senha inválida.';
                }
            } else {
                $errorMessage = 'CPF ou Token inválido.';
            }

            // Fechar a declaração
            $stmt->close();
        } else {
            $errorMessage = 'Não foi possível preparar a declaração SQL.';
        }
    }
}
?>

