<?php
require('conectar.php');

session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

// Obter a role do usuário
$userID = $_SESSION['userID'];
$sql = "SELECT role FROM users WHERE userID = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();

    // Verificar se a role é "admin"
    if ($role !== 'admin') {
        header('Location: index.html');
        exit();
    }
} else {
    $errorMessage = 'Não foi possível verificar a permissão do usuário.';
    header('Location: index.html');
    exit();
}
?>