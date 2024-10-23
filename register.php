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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!--import font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--import css/scroll-->
    <link rel="stylesheet" href="./style/styles.css">
    <link rel="stylesheet" href="./style/styles-loginReg.css">

    <script src="https://unpkg.com/scrollreveal"></script>

    <title>Registro</title>
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-container">
                <div class="navbar-left">

                    <div class="logo-container">
                        <a href="index.php"><img src="./img/ProtectKey-LOGOW.png" alt="Protect Key Logo" class="logo"></a>
                        <a href="index.php"><img src="./img/ProtectKey-LOGOB.png" alt="Protect Key Logo Hover" class="logo-hover"></a>
                    </div>

                    <button class="hamburger" id="hamburger">&#9776;</button>
                    <div class="navbar-menu" id="navbarMenu">
                        <a href="store_password.php" class="navbar-item">Senhas</a>
                        <a href="planos.php" class="navbar-item">Planos</a>
                     <!--    <a href="#" class="navbar-item">Sobre</a>   -->
                        <a href="envia_contato.php" class="navbar-item">Contate-nos</a>
                        
                    </div>
                </div>
                
                <!--PROFILE ICON-->
                <div class="navbar-right">
                    <details class="dropdown">
                        <summary class="profile-icon">
                            <img src="./img/user.png" alt="Profile">
                        </summary>
                        <div class="dropdown-content">
                            <?php if (isset($_SESSION['userNome'])): ?>
                                <p>Bem-vindo, <?php echo $_SESSION['userNome']; ?></p>
                                <a href="conta.php"> Detalhes</a>    
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

    <main class="main-content">
        <section class="hero">
            <div class="wrapper">
                <form action="" method="post">

                    <h1>Registro</h1>

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

                    <div class="input-box">
                        <input type="password" id="userPassword" name="userPassword" placeholder="Digite sua senha*" required>
                        <span class="toggle-password" toggle="#userPassword" title="Mostrar/ocultar senha">
                            <i class="fas fa-eye"></i>
                        </span>
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="password" id="userPasswordRepeat" name="userPasswordRepeat" placeholder="Repita sua senha*" required>
                        <span class="toggle-password" toggle="#userPasswordRepeat">
                            <i class="fas fa-eye"></i>
                            </span>
                        <br><br>
                    </div>

                    <div class="input-box">
                    <input type="password" id="dicaSenha" name="dicaSenha"
                            placeholder="Digite uma dica para a senha*" required>
                        <span class="toggle-password" toggle="#dicaSenha" title="Mostrar/ocultar senha">
                            <i class="fas fa-eye"></i>
                            </span>
                        <br><br>
                    </div>

                        <div id="lengthMessage" class="error-message"></div>
                        <div id="uppercaseMessage" class="error-message"></div>
                        <div id="specialCharMessage" class="error-message"></div>
                        <div id="passwordMatchMessage" class="error-message"></div>

                    <div class="register-link">
                        <p>Já possui uma conta?</p>
                        <a href="login.php">Login</a>
                    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
                    <p class="message success"><?php echo htmlspecialchars($_SESSION['success_message']); ?></p>
                    <?php unset($_SESSION['success_message']); // Remove a mensagem da sessão após exibi-la ?>
                    <?php endif; ?>

                    <?php if (!empty($errorMessage)) : ?>
        <div style="color: red;"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <?php if (!empty($successMessage)) : ?>
        <div style="color: green;"><?php echo $successMessage; ?></div>
    <?php endif; ?>

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
                <ul class="box input-box">
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

    <script>
    // Função para verificar se as senhas coincidem
    function checkPasswordMatch() {
        const password = document.getElementById('userPassword').value;
        const passwordRepeat = document.getElementById('userPasswordRepeat').value;
        const matchMessage = document.getElementById('passwordMatchMessage');

        if (password === passwordRepeat && password !== "") {
            matchMessage.textContent = 'As senhas coincidem.';
            matchMessage.className = 'success-message';
        } else {
            matchMessage.textContent = 'As senhas não coincidem.';
            matchMessage.className = 'error-message';
        }
    }

    // Função para verificar os critérios da senha
    function checkPasswordCriteria() {
        const password = document.getElementById('userPassword').value;

        // Selecionar as divs de mensagens para cada critério
        const lengthMessage = document.getElementById('lengthMessage');
        const uppercaseMessage = document.getElementById('uppercaseMessage');
        const specialCharMessage = document.getElementById('specialCharMessage');

        // Verificar o comprimento da senha
        if (password.length >= 12) {
            lengthMessage.textContent = 'A senha tem pelo menos 12 caracteres.';
            lengthMessage.className = 'success-message';
        } else {
            lengthMessage.textContent = 'A senha deve ter pelo menos 12 caracteres.';
            lengthMessage.className = 'error-message';
        }

        // Verificar se a senha contém pelo menos uma letra maiúscula
        if (/[A-Z]/.test(password)) {
            uppercaseMessage.textContent = 'A senha contém pelo menos uma letra maiúscula.';
            uppercaseMessage.className = 'success-message';
        } else {
            uppercaseMessage.textContent = 'A senha deve conter pelo menos uma letra maiúscula.';
            uppercaseMessage.className = 'error-message';
        }

        // Verificar se a senha contém pelo menos um caractere especial
        if (/[\W_]/.test(password)) {
            specialCharMessage.textContent = 'A senha contém pelo menos um caractere especial.';
            specialCharMessage.className = 'success-message';
        } else {
            specialCharMessage.textContent = 'A senha deve conter pelo menos um caractere especial.';
            specialCharMessage.className = 'error-message';
        }
    }

    // Adicionar event listener aos campos de senha
    document.getElementById('userPassword').addEventListener('input', function() {
        checkPasswordCriteria();  // Verifica os critérios da senha
        checkPasswordMatch();     // Verifica se as senhas coincidem
    });
    
    document.getElementById('userPasswordRepeat').addEventListener('input', checkPasswordMatch);
</script>
  
</body>

</html>
