<?php
session_start();
require('./php/login.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Import favicon -->
    <link rel="icon" href="./img/ICON-prokey.ico">

    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Import Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Import CSS/Scroll -->
    <link rel="stylesheet" href="./style/styles.css">
    <link rel="stylesheet" href="./style/styles-loginReg.css">

    <script src="https://unpkg.com/scrollreveal"></script>

    <title>Login</title>
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

    <main class="main-content">
        <section class="hero" style="height: 100vh;">
            <div class="wrapper">
                <form action="" method="post" style="margin-bottom: 40px;">
                    <h1>Login</h1>

                    <?php if (!empty($errorMessage)): ?>
                        <div class='message-overlay'>
                            <div class='message-box'
                                style='background-color: #ff000091; border-radius: 7px; margin: 10px 0; font-size: 18px;'>
                                <span class='close-icon' onclick="this.parentElement.parentElement.style.display='none';">
                                    <i class='fas fa-times'></i>
                                </span>
                                <?php echo htmlspecialchars($errorMessage); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class='message-overlay'>
                            <div class='message-box' style='background-color: green; border-radius: 7px; margin: 10px 0;'>
                                <span class='close-icon' onclick="this.parentElement.parentElement.style.display='none';">
                                    <i class='fas fa-times'></i>
                                </span>
                                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                            </div>
                        </div>
                        <?php unset($_SESSION['success_message']); // Remove a mensagem da sessão após exibi-la ?>
                    <?php endif; ?>

                    <div class="input-box">
                        <input type="text" id="userCpf" name="userIdent" placeholder="Digite seu CPF ou Token" required>
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="password" id="userPassword" name="userPassword" placeholder="Digite sua senha"
                            required>
                        <span class="toggle-password" data-toggle="#userPassword" title="Mostrar/ocultar senha">
                            <i class="fas fa-eye"></i>
                        </span>
                        <br><br>
                    </div>

                    <div class="register-link">
                        <p class="register-link-esqueceu">Não possui uma conta?<br> <a
                                href="./register.php">Registre-se</a></p>
                        <p>Esqueceu a senha?<br> <a href="./esqueceu_senha.php">Obter Dica</a></p>
                    </div>

                    <button type="submit" class="btn">Login</button>
                </form>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="content">
            <div class="top">
                <div class="logo-details">
                    <a href="#"><img class="logo-footer" src="./img/ProtectKey-LOGOW.png" alt="logo icon"></a>
                </div>
                <div class="media-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="link-boxes">
                <ul class="box">
                    <li class="link_name">Companhia</li>
                    <li><a href="#">Página Inicial</a></li>
                    <li><a href="#">Entre em Contato</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Começar Agora</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Serviços</li>
                    <li><a href="#">App design</a></li>
                    <li><a href="#">Web design</a></li>
                    <li><a href="#">Logo design</a></li>
                    <li><a href="#">Banner design</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Conta</li>
                    <li><a href="#">Perfil</a></li>
                    <li><a href="#">Minha conta</a></li>
                    <li><a href="#">Preferências</a></li>
                    <li><a href="#">Compras</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Cursos</li>
                    <li><a href="#">HTML & CSS</a></li>
                    <li><a href="#">JavaScript</a></li>
                    <li><a href="#">Fotografia</a></li>
                    <li><a href="#">Photoshop</a></li>
                </ul>
                <ul class="box input-box-fot">
                    <li class="link_name">Assine</li>
                    <li><input type="email" placeholder="Digite seu email" required></li>
                    <li><input type="submit" value="Assinar"></li>
                </ul>
            </div>
        </div>
        <div class="bottom-details">
            <div class="bottom_text">
                <span class="copyright_text">
                    &copy; <?php echo date("Y"); ?> <a href="#">ProtectKey.</a> Todos os direitos reservados
                </span>
                <span class="policy_terms">
                    <a href="#">Política de Privacidade</a>
                    <a href="#">Termos & Condições</a>
                </span>
            </div>
        </div>
    </footer>

    <script src="./script/script2.js"></script>

    <script>
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function () {
                const input = document.querySelector(this.getAttribute('data-toggle'));
                const icon = this.querySelector('i');

                if (input.getAttribute('type') === 'password') {
                    input.setAttribute('type', 'text');
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.setAttribute('type', 'password');
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>

</body>

</html>