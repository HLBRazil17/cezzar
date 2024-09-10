<?php
// caminho python (Mudar isso para como esta o seu)
$pythonCaminho = 'C:\Users\DS 2024 - 38\Desktop\TCC\TCC-2024\otp.py';

// monta o comando para executar o script Python
$command = escapeshellcmd("python \"$pythonCaminho\"");

// coloca o python pra trabalhar, e pega o resltado da saida
$output = shell_exec($command);

// dividir cada resultado com uma "|"
list($codigo_otp, $link, $validade) = explode('|', $output);

// mostra os resultados do arquivo python
echo "Código OTP: $codigo_otp<br>";
echo "Provisioning URI: $link<br>";
echo "Validade: $validade<br>";

// verifica se foi gerado o arquivo
if (file_exists('qrcode.png')) {
    // exibir imgem qrcode
    echo '<h2>QR Code:</h2>';
    echo '<img src="qrcode.png" alt="QR Code">';
} else {
    echo 'O QR code não foi gerado.';
}
?>
