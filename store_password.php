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
    <link rel="stylesheet" href="./style/styles-store.css">

    <title>Armazenar Senha</title>
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
                        <a href="#" class="navbar-item">Produto</a>
                        <a href="#" class="navbar-item">Planos</a>
                        <a href="#" class="navbar-item">Download</a>
                        <a href="#" class="navbar-item">Sobre</a>
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
                                <a href="account.php">Conta</a>
                                <form action="logout.php" method="post" style="display: inline;">
                                    <button type="submit" class="logout-btn">Sair</button>
                                </form>
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

    <main>
        <section class="hero02">
            <!-- Formulário de adição/atualização de senha -->
            <div class="form-container" id="formContainer">
                <div class="form-container-background">

                    <form id="passwordForm" action="" method="post">
                        <input type="hidden" id="actionType" name="actionType" value="add">
                        <input type="hidden" id="passwordId" name="passwordId" value="">

                        <label for="siteName">Nome do Site</label>
                        <input type="text" id="siteName" name="siteName" placeholder="Digite o Nome do Site" required>

                        <label for="url">URL do Site</label>
                        <input type="text" id="url" name="url" placeholder="Digite o URL do Site">

                        <label for="loginName">Nome de Login</label>
                        <input type="text" id="loginName" name="loginName" placeholder="Digite o Nome de Login">

                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" placeholder="Digite o E-mail">

                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password" placeholder="Digite a Senha" required>

                        <?php
                        if (!empty($errorMessage)) {
                            echo "<p class='message error'>$errorMessage</p>";
                        }
                        if (!empty($successMessage)) {
                            echo "<p class='message success'>$successMessage</p>";
                        }
                        ?>

                        <button type="submit" class="save-btn">Salvar</button>
                        <button type="button" class="cancel-btn" onclick="cancelForm()">Cancelar</button>

                        <!-- Botão para adicionar senha -->
                        <img src="./img/salvar.png" alt="Adicionar Senha" class="add-password-btn" style="width: 60px;"
                            onclick="toggleForm()">
                    </form>
                </div>
            </div>

            <!-- Tabela com as informações salvas -->
            <?php if (!empty($savedPasswords)): ?>
                <!-- Estrutura de exibição das senhas salvas -->
                <section class="saved-list" id="savedList">
                    <h2>Senhas fracas</h2>
                    <p>Senhas fracas são fáceis de adivinhar. Crie senhas fortes. <a href="#">Veja mais dicas de
                            segurança.</a></p>
                    <div class="password-container">
                        <?php foreach ($savedPasswords as $password): ?>
                            <div class="password-item">
                                <div class="site-info">
                                    <img src="URL_DO_ICONE" alt="Ícone do site">
                                    <span><?php echo htmlspecialchars($password['site_name']); ?></span>
                                </div>
                                <div class="password-info">
                                    <span class="masked-password">********</span>
                                    <form action="" method="post">
                                        <input type="hidden" name="passwordId" value="<?php echo htmlspecialchars($password['senhaId']); ?>">
                                        <input type="hidden" name="actionType" value="update">
                                        <button type="submit" class="action-btn">Alterar senha</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </section>
    </main>

    <!-- Botão de Logout -->
    <form action="logout.php" method="post" style="display: inline;">
        <button type="submit" class="logout-btn">Sair</button>
    </form>

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

</body>

</html>