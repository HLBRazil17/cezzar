<?php
session_start();
require('./php/register.php');
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
    <link rel="stylesheet" href="./style/styles-loginReg.css">
    <script src="https://unpkg.com/scrollreveal"></script>

    <title>Registro</title>
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

    <main class="main-content">
        <section class="hero">
            <div class="wrapper">
                <form action="" method="post">

                    <h1>Registro</h1>

                    <?php
                    if (!empty($errorMessage)) {
                        echo "<p style='background-color: #ff000091; border-radius: 7px; padding: 10px; margin: 10px 0;'>$errorMessage</p>";
                    }
                    if (!empty($successMessage)) {
                        echo "<p style='background-color: green; border-radius: 7px; padding: 10px; margin: 10px 0;'>$successMessage</p>";
                    }
                    ?>





                    <div class="input-box">
                        <input type="text" id="userNome" name="userNome" placeholder="Digite seu nome*" required>
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="email" id="userEmail" name="userEmail" placeholder="Digite seu e-mail*" required>
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="text" id="userCpf" name="userCpf" placeholder="Digite seu CPF">
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="userTel" id="userTel" name="userTel" placeholder="Digite seu telefone">
                        <br><br>
                    </div>

                    <!-- SENHA COM VIZUALIZAÇÃO-->
                    <div class="input-box">
                        <input type="password" id="userPassword" name="userPassword" placeholder="Digite sua senha*"
                            required>
                        <span class="toggle-password" toggle="#userPassword" title="Mostrar/ocultar senha">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>


                    <div class="input-box">
                        <input type="password" id="userPasswordRepeat" name="userPasswordRepeat"
                            placeholder="Repita sua senha*" required>
                        <span class="toggle-password" toggle="#userPasswordRepeat">
                            <i class="fas fa-eye"></i>
                        </span>
                        <br><br>
                    </div>

                    <div id="passwordMatchMessage" class="error-message" style="display: none;"></div>


                    <div class="input-box">
                        <input type="password" id="dicaSenha" name="dicaSenha"
                            placeholder="Digite uma dica para a senha*" required>
                        <span class="toggle-password" toggle="#dicaSenha" title="Mostrar/ocultar senha">
                            <i class="fas fa-eye"></i>
                        </span>
                        <br><br>
                    </div>


                    <div class="register-link">
                        <p>Já possui uma conta?</p>
                        <a href="login.php">Login</a>
                    </div>

                    <button type="submit" class="btn">Registrar</button>
                </form>
            </div>
        </section>
    </main>

    <!--FOOTER-->
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
                    <li class="link_name">Services</li>
                    <li><a href="#">App design</a></li>
                    <li><a href="#">Web design</a></li>
                    <li><a href="#">Logo design</a></li>
                    <li><a href="#">Banner design</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Account</li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">My account</a></li>
                    <li><a href="#">Prefrences</a></li>
                    <li><a href="#">Purchase</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Courses</li>
                    <li><a href="#">HTML & CSS</a></li>
                    <li><a href="#">JavaScript</a></li>
                    <li><a href="#">Photography</a></li>
                    <li><a href="#">Photoshop</a></li>
                </ul>
                <ul class="box input-box-fot">
                    <li class="link_name">Subscribe</li>
                    <li><input type="text" placeholder="Enter your email"></li>
                    <li><input type="button" value="Subscribe"></li>
                </ul>
            </div>
        </div>
        <div class="bottom-details">
            <div class="bottom_text">
                <span class="copyright_text">Copyright © 2021 <a href="#">CodingLab.</a>All rights reserved</span>
                <span class="policy_terms">
                    <a href="#">Privacy policy</a>
                    <a href="#">Terms & condition</a>
                </span>
            </div>
        </div>
    </footer>

    <script src="./script/script2.js"></script>
</body>

</html>