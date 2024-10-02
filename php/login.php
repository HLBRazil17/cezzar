<?php
require('conectar.php');
require('functions.php'); 

// Inicializar variáveis para mensagens de erro e sucesso
$errorMessage = '';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar os dados do formulário
    $userIdent = $_POST['userIdent'];
    $userPassword = $_POST['userPassword'];
    
    // Validar os dados
    if (empty($userIdent) || empty($userPassword)) {
        $errorMessage = 'CPF e senha são obrigatórios.';
    } else {
        // Preparar a consulta SQL para verificar o usuário
        $sql = "SELECT userID, userNome, userCpf, userPassword FROM gerenciadorsenhas.users WHERE userToken = ? OR userCpf = ?";
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

                    // Registrar a ação de login
                    logAction($conn, $userID, 'Login', 'Login bem sucedido: ' . $userNome);

                    header("Location: store_password.php");
                    exit();
                } else {
                    $errorMessage = 'Dados invalidos.';
                    
                }
            } else {
                $errorMessage = 'Dados invalidos.';
                
            }

            // Fechar a declaração
            $stmt->close();
        } else {
            $errorMessage = 'Não foi possível preparar a declaração SQL.';
        }
  // Redirecionar após o POST para evitar reenvio do formulário
      /*  header("Location: login.php?error=" . urlencode($errorMessage));
        exit(); */
    } 
}

// Verificar se há uma mensagem de erro via GET
  /* if (isset($_GET['error'])) {
    $errorMessage = urldecode($_GET['error']);
} */

// Incluir o arquivo de visualização (formulário de login)
?>
