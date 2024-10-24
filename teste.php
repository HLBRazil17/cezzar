<?php
require 'vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

// Inicie a sessão (caso ainda não esteja iniciada)
session_start();

// Simule um usuário logado (você pode adaptar isso ao seu sistema de autenticação)
$userId = 1; // Substitua pelo ID do usuário logado

// Verifique se o usuário já tem uma chave secreta
// Normalmente, você buscaria a chave secreta do banco de dados. Aqui, vamos simular uma nova geração.
$g = new GoogleAuthenticator();
$secret = 'V5P5VVSB7KLU6LSW6QUGW3D36U======'; 

// Exemplo de código para salvar a chave secreta no banco de dados (substitua pelo seu código real)
/*
$pdo = new PDO('mysql:host=localhost;dbname=seubanco', 'seuusuario', 'suasenha');
$sql = "UPDATE users SET google_auth_secret = :secret WHERE id = :userId";
$stmt = $pdo->prepare($sql);
$stmt->execute(['secret' => $secret, 'userId' => $userId]);
*/

// Gere a URL do QR code para o Google Authenticator
$siteName = 'Protect Key '; // Nome que aparecerá no Google Authenticator
$qrCodeUrl = GoogleQrUrl::generate($siteName, $secret, 'SuaEmpresa');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Google Authenticator</title>
</head>
<body>
    <h1>Configuração de Autenticação de Dois Fatores</h1>
    <p>Escaneie o QR code abaixo com o Google Authenticator:</p>

    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code Google Authenticator">

    <p>Ou, se preferir, insira esta chave manualmente no aplicativo:</p>
    <strong><?php echo $secret; ?></strong>

    <form action="verificar.php" method="post">
        <label for="totp_code">Insira o código do Google Authenticator:</label><br>
        <input type="text" id="totp_code" name="totp_code" required><br><br>
        <button type="submit">Verificar Código</button>
    </form>
</body>
</html>
