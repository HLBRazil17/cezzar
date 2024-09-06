<?php
require('conectar.php');
require('logAction.php');
// require('admin.php');

$errorMessage = '';
$logs = [];

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



// Consultar logs do banco de dados
$sql = "SELECT id, user_id, action_type, description, created_at FROM logs ORDER BY created_at DESC";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Buscar logs
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
    $stmt->close();
} else {
    $errorMessage = 'Não foi possível preparar a consulta.';
}

?>
