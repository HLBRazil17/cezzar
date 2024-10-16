<?php
require("./php/planos.php")
    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--import favicon-->
    <link rel="icon" href="./img/ICON-prokey.ico">

    <!--import googleFonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!--import font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--import css/scroll-->
    <link rel="stylesheet" href="./style/styles.css">

    <title>Protect Key</title>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-container">
                <div class="navbar-left">

                    <div class="logo-container">
                        <a href="index.php"><img src="./img/ProtectKey-LOGOW.png" alt="Protect Key Logo"
                                class="logo"></a>
                        <a href="index.php"><img src="./img/ProtectKey-LOGOB.png" alt="Protect Key Logo Hover"
                                class="logo-hover"></a>
                    </div>

                    <button class="hamburger" id="hamburger">&#9776;</button>
                    <div class="navbar-menu" id="navbarMenu">
                        <?php if (isset($_SESSION['userNome'])): ?>
                            <a href="store_password.php" class="navbar-item">Controle de Senhas</a>
                            <a href="planos.php" class="navbar-item">Planos</a>
                            <a href="envia_contato.php" class="navbar-item">Contate-nos</a>

                        <?php else: ?>
                            <a href="store_password.php" class="navbar-item">Senhas</a>
                            <a href="planos.php" class="navbar-item">Planos</a>
                            <a href="envia_contato.php" class="navbar-item">Contate-nos</a>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['userNome'])): ?>
                            <?php if (checkAdminRole($conn, $userId)) { ?>
                                <a href="gerenciador.php" class="navbar-item">Gerenciador</a>
                                <a href="logs.php" class="navbar-item">Logs</a>
                            <?php } ?>

                        <?php endif; ?>


                    </div>
                </div>

                <!-- PROFILE ICON -->
                <div class="navbar-right">
                    <details class="dropdown">
                        <summary class="profile-icon">
                            <img src="./img/user.png" alt="Profile" class="user">
                            <img src="./img/user02.png" alt="Profile Hover" class="user-hover">
                        </summary>
                        <div class="dropdown-content">
                            <?php if (isset($_SESSION['userNome'])): ?>
                                <?php
                                // Utiliza strtok para obter a primeira parte antes do espaço
                                $primeiroNome = strtok($_SESSION['userNome'], ' ');
                                ?>
                                <p>Bem-vindo, <?php echo $primeiroNome; ?></p>
                                <a href="conta.php"> Detalhes da Conta</a>
                                <a href="./php/logout.php" style="border-radius: 15px;">Sair da Conta</a>
                            <?php else: ?>
                                <p>Bem-vindo!</p>
                                <a href="register.php">Registrar</a>
                                <a href="login.php"
                                    style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">Login</a>
                            <?php endif; ?>
                        </div>
                    </details>
                </div>
            </div>
        </nav>
    </header>

    <section class="pricing" id="planos">
        <h2>Planos e Preços</h2>
        <?php echo htmlspecialchars($userPlan); ?>
        <div class="pricing-list">
            <!-- Plano Básico -->
            <div class="pricing-item">
                <h3>Básico</h3>
                <p>Grátis para sempre</p>
                <ul>
                    <li>Armazenamento limitado de senhas</li>
                    <li>Acesso em um dispositivo</li>
                    <li>Suporte básico</li>
                </ul>
                <?php if ($userPlan === 'básico'): ?>
                    <span class="btn">Você já possui um plano</span>
                <?php else: ?>
                    <a href="" class="btn">Escolher Plano</a>
                <?php endif; ?>
            </div>

            <!-- Plano Pro -->
            <div class="pricing-item">
                <h3>Pro</h3>
                <p>$14.99/mês</p>
                <ul>
                    <li>Armazenamento ilimitado de senhas</li>
                    <li>Acesso em múltiplos dispositivos</li>
                    <li>Autenticação multifator</li>
                    <li>Suporte prioritário</li>
                    <li>Relatórios de segurança</li>
                </ul>
                <?php if ($userPlan === 'pro'): ?>
                    <span class="btn">Você já possui este plano</span>
                <?php else: ?>
                    <a href="<?php echo htmlspecialchars($paymentUrlPro); ?>" class="btn btn-primary"
                        target="_blank">Escolher Plano Pro</a>
                <?php endif; ?>
            </div>

            <!-- Plano Premium -->
            <div class="pricing-item">
                <h3>Premium</h3>
                <p>$24.99/mês</p>
                <ul>
                    <li>Armazenamento ilimitado de senhas</li>
                    <li>Acesso em múltiplos dispositivos</li>
                    <li>Autenticação multifator</li>
                    <li>Suporte premium 24/7</li>
                    <li>Relatórios avançados</li>
                    <li>Backup e recuperação de dados</li>
                </ul>
                <?php if ($userPlan === 'premium'): ?>
                    <span class="btn">Você já possui este plano</span>
                <?php else: ?>
                    <a href="<?php echo htmlspecialchars($paymentUrlPremium); ?>" class="btn btn-primary"
                        target="_blank">Escolher Plano Premium</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>