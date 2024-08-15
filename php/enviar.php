<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require './lib/vendor/autoload.php';

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

// Função para enviar e-mail
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
?>
