<?php
require('./php/logs.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--import favicon-->
    <link rel="icon" href="./img/ICON-prokey.ico">

    <!--import googleFonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!--import font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--import css/scroll-->
    <link rel="stylesheet" href="./style/styles.css">
    <link rel="stylesheet" href="./style/styles-loginReg.css">

    <script src="https://unpkg.com/scrollreveal"></script>
    <title>Logs de Atividades</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header class="header">
        <nav class="navbar">
            <div class="navbar-container">
                <div class="navbar-left">
                    <!-- Logo -->
                    <div class="logo-container">
                        <a href="index.php"><img src="./img/ProtectKey-LOGOW.png" alt="Protect Key Logo"
                                class="logo"></a>
                        <a href="index.php"><img src="./img/ProtectKey-LOGOB.png" alt="Protect Key Logo Hover"
                                class="logo-hover"></a>
                    </div>

                    <!-- Botão de menu hambúrguer -->
                    <button class="hamburger" id="hamburger">&#9776;</button>

                    <!-- Menu de navegação -->
                    <div class="navbar-menu" id="navbarMenu">
                        <a href="store_password.php" class="navbar-item">Senhas</a>
                        <a href="planos.php" class="navbar-item">Planos</a>
                     <!--    <a href="#" class="navbar-item">Sobre</a>   -->
                        <a href="#" class="navbar-item">Contate-nos</a>
                        <?php if (checkAdminRole($conn, $userID)) { ?>
                            <a href="gerenciador.php" class="navbar-item">Gerenciador</a>
                            <a href="logs.php" class="navbar-item">Logs</a>
                            <?php } ?>
                    </div>
                </div>

                <!-- Ícone de perfil com dropdown -->
                <div class="navbar-right">
                    <details class="dropdown">
                        <summary class="profile-icon">
                            <img src="./img/user.png" alt="Profile">
                        </summary>
                        <div class="dropdown-content">
                            <!-- Verifica se o usuário está logado -->
                            <?php if (isset($_SESSION['userNome'])): ?>
                                <p>Bem-vindo, <?php echo $_SESSION['userNome']; ?></p>
                                <a href="account.php">Detalhes da Conta</a>
                                <a href="./php/logout.php" style="border-bottom: none;">Sair da Conta</a>
                            <?php else: ?>
                                <p>Bem-vindo!</p>
                                <a href="register.php">Registrar</a>
                                <a href="login.php" style="border-bottom: none;">Login</a>
                            <?php endif; ?>
                        </div>
                    </details>
                </div>
            </div>
        </nav>
    </header>

    <h1>Logs de Atividades</h1>

    <?php if (!empty($errorMessage)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário ID</th>
                <th>Tipo de Ação</th>
                <th>Descrição</th>
                <th>IP</th>
                <th>Data e Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo htmlspecialchars($log['id'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($log['user_id'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($log['action_type'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($log['description'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($log['ip_address'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($log['created_at'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
