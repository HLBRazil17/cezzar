<?php
require('conectar.php'); // Conexão com o banco de dados
require("functions.php"); 
require('./lib/vendor/autoload.php');

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['userID'])) {
    header('Location: ../login.php');
    exit();
}

// Obter o ID do usuário a partir da sessão
$userID = $_SESSION['userID'];

// Inicializar variáveis
$securityWord = '';
$hasSecurityWord = false;
$errorMessage = '';
$successMessage = '';
$enableTwoFactor = false;
$secret = '';

// Função para gerar um segredo
function generateSecret() {
    $g = new GoogleAuthenticator();
    return $g->generateSecret();
}

// Função para obter as informações do usuário
function getUserInfo($conn, $userID) {
    $sql = "SELECT userNome, userEmail, userCpf, userTel, securityWord, enableTwoFactor, dicaSenha, secret FROM users WHERE userID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row;
        }
        $stmt->close();
    }
    return null;
}

// Obter as informações do usuário
$userInfo = getUserInfo($conn, $userID);
$userNome = $userInfo['userNome'];
$userEmail = $userInfo['userEmail'];
$userCpf = $userInfo['userCpf'];
$userTel = $userInfo['userTel'];
$securityWord = $userInfo['securityWord'];
$hasSecurityWord = !empty($securityWord);
$enableTwoFactor = $userInfo['enableTwoFactor'] ?? false;
$dicaSenha = $userInfo['dicaSenha'] ?? '';
$secret = $userInfo['secret'] ?? ''; // Obter o segredo do banco de dados

// Verificar se o segredo já existe, caso contrário, gerá-lo e salvá-lo
if (empty($secret)) {
    $secret = generateSecret();
    // Atualizar o segredo no banco de dados
    $updateSecretSql = "UPDATE users SET secret = ? WHERE userID = ?";
    if ($stmt = $conn->prepare($updateSecretSql)) {
        $stmt->bind_param("si", $secret, $userID);
        $stmt->execute();
        $stmt->close();
    }
}

// Gere a URL do QR code para o Google Authenticator
$siteName = 'Protect Key'; // Nome que aparecerá no Google Authenticator
$qrCodeUrl = GoogleQrUrl::generate($siteName, $secret, 'SuaEmpresa');

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($hasSecurityWord) {
        $submittedSecurityWord = trim($_POST['oldSecurityWord'] ?? '');
        if (!password_verify($submittedSecurityWord, $securityWord)) {
            $errorMessage = 'Palavra de segurança incorreta.';
        } 
    }

    if (empty($errorMessage)) {
        $newUserNome = $_POST['userNome'];
        $newUserEmail = $_POST['userEmail'];
        $newUserCpf = $_POST['userCpf'] ?? null; // CPF pode ser null
        $newUserTel = $_POST['userTel'] ?? null; // Tel pode ser null
        $newUserPassword = $_POST['userPassword'];
        $newSecurityWord = trim($_POST['newSecurityWord'] ?? '') ?: $securityWord;
        $newDicaSenha = trim($_POST['dicaSenha'] ?? ''); // Nova dica de senha
        $enableTwoFactor = isset($_POST['enableTwoFactor']) ? 1 : 0;

        // Verificar se o email já está em uso por outro usuário
        $emailCheckSql = "SELECT userID FROM users WHERE userEmail = ? AND userID != ?";
        if ($stmt = $conn->prepare($emailCheckSql)) {
            $stmt->bind_param("si", $newUserEmail, $userID);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $errorMessage = 'Este email já está em uso por outro usuário.';
            } else {
                // Se o CPF for fornecido, verificar duplicidade
                if (!empty($newUserCpf)) {
                    $cpfCheckSql = "SELECT userID FROM users WHERE userCpf = ? AND userID != ?";
                    if ($stmt = $conn->prepare($cpfCheckSql)) {
                        $stmt->bind_param("si", $newUserCpf, $userID);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            $errorMessage = 'Este CPF já está em uso por outro usuário.';
                            logAction($conn, $userID, 'Erro Atualização de Conta', 'O usuário ' . $newUserNome . ' tentou atualizar o CPF para um já existente');
                        }
                    }
                }

                // Continuar a atualização se não houver erros
                if (empty($errorMessage)) {
                    // Hash da senha, se fornecida SHA256
                    if (!empty($newUserPassword)) {
                        $hashedPassword = hash('sha256',$newUserPassword);
                    } else {
                        // Senha permanece a mesma
                        $passwordCheckSql = "SELECT userPassword FROM users WHERE userID = ?";
                        if ($stmt = $conn->prepare($passwordCheckSql)) {
                            $stmt->bind_param("i", $userID);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($row = $result->fetch_assoc()) {
                                $hashedPassword = $row['userPassword'];
                            }
                            $stmt->close();
                        }
                    }

                    // Hash da palavra de segurança, se fornecida
                    if (!empty($newSecurityWord)) {
                        $hashedSecurityWord = password_hash($newSecurityWord, PASSWORD_DEFAULT);
                    } else {
                        // Se não houver nova palavra de segurança, mantenha a existente
                        $hashedSecurityWord = $securityWord; // Mantenha a palavra de segurança atual
                    }

                    // Atualização do banco de dados
                    $updateSql = "UPDATE users SET userNome = ?, userEmail = ?, userCpf = ?, userTel = ?, userPassword = ?, securityWord = ?, dicaSenha = ?, enableTwoFactor = ?, secret = ? WHERE userID = ?";
                    if ($stmt = $conn->prepare($updateSql)) {
                        $stmt->bind_param("sssssssssi", $newUserNome, $newUserEmail, $newUserCpf, $newUserTel, $hashedPassword, $hashedSecurityWord, $newDicaSenha, $enableTwoFactor, $secret, $userID);
                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                            $successMessage = 'Informações atualizadas com sucesso.';
                            logAction($conn, $userID, 'Atualização de Conta', 'Informações atualizadas pelo usuário: ' . $newUserNome);
                            $_SESSION['userNome'] = $newUserNome;

                            // Atualizar variáveis de sessão
                            $userInfo = getUserInfo($conn, $userID);
                            $userNome = $userInfo['userNome'];
                            $userEmail = $userInfo['userEmail'];
                            $userCpf = $userInfo['userCpf'];
                            $userTel = $userInfo['userTel'];
                            $securityWord = $userInfo['securityWord'];
                            $hasSecurityWord = !empty($securityWord);
                            $enableTwoFactor = $userInfo['enableTwoFactor'] ?? false;
                            $dicaSenha = $userInfo['dicaSenha'] ?? '';
                            $secret = $userInfo['secret'] ?? ''; // Atualiza o segredo
                        } else {
                            $errorMessage = 'Nenhuma mudança foi feita.';
                        }
                        $stmt->close();
                    } else {
                        $errorMessage = 'Erro ao atualizar as informações do usuário.';
                    }
                }
            }
        } else {
            $errorMessage = 'Erro ao verificar o email.';
        }
    }
}
?>