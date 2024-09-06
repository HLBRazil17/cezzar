<?php

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
?>