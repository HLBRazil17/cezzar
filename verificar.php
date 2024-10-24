<?php
require 'vendor/autoload.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

// Inicie a sessão
session_start();

// Pegar o código inserido pelo usuário
$userInputCode = $_POST['totp_code'];

// Simule um usuário logado (substitua isso pela lógica real)
$userId = 1; // ID do usuário logado

// Aqui você normalmente buscaria a chave secreta do banco de dados.
$secret = 'V5P5VVSB7KLU6LSW6QUGW3D36U======'; 

$g = new GoogleAuthenticator();
if ($g->checkCode($secret, $userInputCode)) {
    echo 'Autenticação bem-sucedida!';
} else {
    echo 'Código inválido. Tente novamente.';
}
?>
