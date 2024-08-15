<?php

// VARIÁVEIS PARA CONECTAR AO BANCO DE DADOS
$servername = "localhost";
$username = "root";
$password = "etec2024";
$dbname = "gerenciadorsenhas";

// Criando a conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida!";
}

// Fechando a conexão (opcional)
$conn->close();
?>