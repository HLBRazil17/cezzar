<?php
require("conectar.php");
require_once ('./lib/vendor/autoload.php'); // Load Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Definir a chave de criptografia (deve ser mantida em segredo)
$key = 'my_secret_key'; // A chave deve ter 32 bytes para AES-256
$cipher = "AES-256-CBC"; // Cipher method
$iv_length = openssl_cipher_iv_length($cipher); // Comprimento do vetor de inicialização (IV)

// Função para criptografar uma senha usando AES
function encryptPassword($password, $key, $cipher, $iv_length) {
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($password, $cipher, $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Função para descriptografar uma senha usando AES
function decryptPassword($encrypted, $key, $cipher, $iv_length) {
    list($encrypted_data, $iv) = explode('::', base64_decode($encrypted), 2);
    return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
}


// Função para obter o plano do usuário
function getUserPlan($userID, $conn) {
    // Preparar a consulta
    $stmt = $conn->prepare("SELECT plano FROM users WHERE userID = ? LIMIT 1");
    
    // Verificar se a preparação foi bem-sucedida
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Vincular o parâmetro
    $stmt->bind_param('i', $userID);
    
    // Executar a consulta
    $stmt->execute();
    
    // Buscar o resultado
    $result = $stmt->get_result()->fetch_assoc();

    // Verificar se foi encontrado um plano
    if ($result) {
        return $result['plano'];
    } else {
        return 'Nenhum plano encontrado'; // Valor padrão se nenhum plano for encontrado
    }
}

// Função para gerar um token de 6 dígitos
function generateToken($conn) {
    do {
        $token = rand(100000, 999999);
        $sql = "SELECT userID FROM gerenciadorsenhas.users WHERE userToken = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->store_result();
        }
    } while ($stmt->num_rows > 0);
    $stmt->close();
    return $token;
}

// Função para enviar o TOKEN por  e-mail
function sendEmail($to, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Endereço do servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'ab5297e24d2261';
        $mail->Password = 'ce8f33fcb0479d';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        // Configurações do e-mail
        $mail->setFrom('matheusridrigues2@gmail.com', 'Segurança');
        $mail->addAddress($to);
        $mail->Subject = 'Seu Token de Registro';
        $mail->Body    = "Obrigado por se registrar! Aqui está seu token de registro:\n\n";
        $mail->Body   .= "$token";

        // Envia o e-mail
        $mail->send();
        return '';
    } catch (Exception $e) {
        return 'Ocorreu um erro ao enviar o e-mail. Tente cadastrar novamente. Se o erro persistir, contate nosso suporte!';
    }
}

// Função para enviar o código por e-mail
function sendCodigoEmail($toEmail, $codigo) {
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor SMTP
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'ab5297e24d2261';
        $mail->Password = 'ce8f33fcb0479d';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        // Configurações do e-mail
        $mail->setFrom('matheusridrigues2@gmail.com', 'Segurança');
        $mail->addAddress($toEmail);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Código de Atualização';
        $mail->Body    = "Seu código de atualização é <strong>$codigo</strong>.";
        $mail->AltBody = "Seu código de atualização é $codigo.";

        $mail->send();
        return '';
    } catch (Exception $e) {
        return "Erro ao enviar o código: {$mail->ErrorInfo}";
    }
}

function sendDicaSenhaEmail($toEmail, $dicaSenha) {
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor SMTP
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'ab5297e24d2261'; // Substitua pelo seu username
        $mail->Password = 'ce8f33fcb0479d'; // Substitua pela sua senha
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        // Configurações do e-mail
        $mail->setFrom('matheusridrigues2@gmail.com', 'Segurança');
        $mail->addAddress($toEmail);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Dica de Senha';
        $mail->Body    = "Sua dica de senha é: <strong>$dicaSenha</strong>.";
        $mail->AltBody = "Sua dica de senha é: $dicaSenha.";

        $mail->send();
        return ''; // Retorna vazio em caso de sucesso
    } catch (Exception $e) {
        return "Erro ao enviar a dica de senha: {$mail->ErrorInfo}"; // Retorna mensagem de erro
    }
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Pode haver vários IPs aqui
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]); // Retorna o primeiro IP da lista
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
        // Verifica se é o localhost e altera se necessário
        return ($ip === '::1' || $ip === '127.0.0.1') ? 'Localhost' : $ip;
    }
}



function logAction($conn, $userID, $actionType, $description) {
    $userIp = getUserIP(); // Captura o IP do usuário
    $sql = "INSERT INTO gerenciadorsenhas.logs (user_id, action_type, description, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isss", $userID, $actionType, $description, $userIp);
        $stmt->execute();
        if ($stmt->error) {
            error_log("Erro ao inserir log: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Erro ao preparar a declaração SQL: " . $conn->error);
    }
}


// Função para verificar se o usuário tem a role de admin
function checkAdminRole($conn, $userID) {
    $role = ''; // Inicializar a variável para evitar referência indefinida

    // Preparar a consulta SQL
    $sql = "SELECT role FROM users WHERE userID = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();

        // Verificar se a role é "admin"
        if ($role === 'admin') {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Função para validar o CPF, mesmo com formatação
function validarCPF($userCpf) {
    // Remove caracteres especiais (pontos, traços, etc.)
    $userCpf = preg_replace('/[^0-9]/', '', $userCpf); // Remove tudo que não for número

    // Verifica se o CPF tem 11 dígitos
    if (strlen($userCpf) != 11) {
        return false;
    }

    // Verifica se todos os dígitos são iguais (exemplo: 111.111.111-11)
    if (preg_match('/(\d)\1{10}/', $userCpf)) {
        return false;
    }

    // Calcula os dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $userCpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($userCpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

?>

