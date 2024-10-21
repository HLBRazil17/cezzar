<?php
session_start();

if (isset($_SESSION['userNome'])) {
    $userID = $_SESSION['userID'];
    $userNome = $_SESSION['userNome'];

    // Argumentos passados para o script Python
    $arg1 = escapeshellarg($userID);
    $arg2 = escapeshellarg($userNome);

    // Executa o script Python
    $output = shell_exec("python connect.py $arg1 $arg2 2>&1");
} else {
    // Redireciona para login se a sessão não estiver ativa
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação 2FA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        pre {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Autenticação 2FA</h1>

        <?php if (isset($output)): ?>
            <h2>Resultado da Execução:</h2>
            <pre><?php echo htmlspecialchars($output); ?></pre>
        <?php else: ?>
            <p>Erro ao executar o script Python.</p>
        <?php endif; ?>
    </div>
</body>
</html>
