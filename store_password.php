<?php
session_start();
require('php/store_password.php');
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
    <link rel="stylesheet" href="./style/styles-store.css">

    <script src="https://unpkg.com/scrollreveal"></script>

    <title>Senhas</title>
</head>

<body>
    <!-- Cabeçalho -->
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

    <main>
        <!-- Formulário de adição/atualização de senha -->
        <section class="form-container" id="formContainer">
            <form id="passwordForm" action="" method="post">
                <!-- Campos ocultos para identificar ação e ID da senha -->
                <input type="hidden" id="actionType" name="actionType" value="add">
                <input type="hidden" id="passwordId" name="passwordId" value="">

                <!-- Inputs do formulário -->
                <label for="siteName">Nome do Site:</label>
                <input type="text" id="siteName" name="siteName" placeholder="Nome do site" required>

                <label for="url">URL do Site:</label>
                <input type="text" id="url" name="url" placeholder="URL do site">

                <label for="loginName">Nome de Login:</label>
                <input type="text" id="loginName" name="loginName" placeholder="Nome de login">

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="E-mail">

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Senha" required>

                <!-- Mensagens de erro e sucesso -->
                <?php
                if (!empty($errorMessage)) {
                    echo "<p class='message error'>$errorMessage</p>";
                }
                if (!empty($successMessage)) {
                    echo "<p class='message success'>$successMessage</p>";
                }
                ?>

                <!-- Botões do formulário -->
                <button type="submit" class="save-btn">Salvar</button>
                <button type="button" class="cancel-btn" onclick="cancelForm()">Cancelar</button>
            </form>
        </section>

        <!-- Tabela com senhas salvas -->
        <?php if (!empty($savedPasswords)): ?>
            <section class="saved-table" id="savedTable">
                <table>
                    <thead>
                        <tr>
                            <th>Site</th>
                            <th>Login</th>
                            <th>E-mail</th>
                            <th>Senha</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Laço para exibir senhas salvas -->
                        <?php foreach ($savedPasswords as $password): ?>
                            <tr>
                                <td><a href="<?php echo htmlspecialchars($password['url']); ?>"
                                        target="_blank"><?php echo htmlspecialchars($password['site_name']); ?></a></td>
                                <td><?php echo htmlspecialchars($password['name']); ?></td>
                                <td><?php echo htmlspecialchars($password['email']); ?></td>
                                <td><span class="toggle-password"
                                        onclick="showPassword(this, '<?php echo htmlspecialchars($password['password']); ?>')">Mostrar</span>
                                </td>
                                <td class="buttons">
                                    <!-- Botão de atualização de senha estilizado com imagem -->
                                    <button class="Btn" onclick="editPassword(<?php echo htmlspecialchars($password['senhaId']); ?>, 
    '<?php echo htmlspecialchars($password['site_name']); ?>', 
    '<?php echo htmlspecialchars($password['url']); ?>', 
    '<?php echo htmlspecialchars($password['name']); ?>', 
    '<?php echo htmlspecialchars($password['email']); ?>', 
    '<?php echo htmlspecialchars($password['password']); ?>')">

                                        <!-- Imagem personalizada dentro do botão -->
                                        <img src="./img/update.png" alt="Atualizar"
                                            style="height: 21px; width: 21px; z-index:2;">

                                        <span class="BG"></span>
                                    </button>




                                    <!-- Formulário para exclusão de senha com botão estilizado -->
                                    <form action="" method="post" style="display:inline;">
                                        <input type="hidden" name="passwordId"
                                            value="<?php echo htmlspecialchars($password['senhaId']); ?>">
                                        <input type="hidden" name="actionType" value="delete">
                                        <button type="submit" class="bin-button"
                                            onclick="return confirm('Tem certeza que deseja excluir esta senha?')">
                                            <svg class="bin-top" viewBox="0 0 39 7" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <line y1="5" x2="39" y2="5" stroke="white" stroke-width="4"></line>
                                                <line x1="12" y1="1.5" x2="26.0357" y2="1.5" stroke="white" stroke-width="3">
                                                </line>
                                            </svg>
                                            <svg class="bin-bottom" viewBox="0 0 33 39" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <mask id="path-1-inside-1_8_19" fill="white">
                                                    <path
                                                        d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z">
                                                    </path>
                                                </mask>
                                                <path
                                                    d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                                    fill="white" mask="url(#path-1-inside-1_8_19)"></path>
                                                <path d="M12 6L12 29" stroke="white" stroke-width="4"></path>
                                                <path d="M21 6V29" stroke="white" stroke-width="4"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php else: ?>

        <?php endif; ?>

        <!-- Imagem adicionar senha -->
        <img src="./img/sem-itens.png" alt="Adicionar Senha" class="img-no-itens" id="img-senha">

        <!-- Botão para adicionar senha -->
        <button type="button" class="button" <?php echo $button_style; ?> onclick="toggleForm()">
            <span class="button__text">Adicionar</span>
            <span class="button__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="44" fill="none"
                    class="svg">
                    <line y2="19" y1="5" x2="12" x1="12"></line>
                    <line y2="12" y1="12" x2="19" x1="5"></line>
                </svg>
            </span>
        </button>


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

    <!-- Funções JavaScript para manipular formulário e senhas -->
    <script>
        // Função para exibir/esconder o formulário com transição suave
        function toggleForm() {
            var formContainer = document.getElementById('formContainer');
            if (formContainer.classList.contains('show')) {
                formContainer.classList.remove('show');
            } else {
                formContainer.classList.add('show');
            }
        }

        // Função para esconder o formulário
        function cancelForm() {
            var formContainer = document.getElementById('formContainer');
            formContainer.classList.remove('show');
        }

        // Função para editar a senha e exibir o formulário
        function editPassword(id, siteName, url, loginName, email, password) {
            var formContainer = document.getElementById('formContainer');
            formContainer.classList.add('show');

            document.getElementById('actionType').value = 'update';
            document.getElementById('passwordId').value = id;
            document.getElementById('siteName').value = siteName;
            document.getElementById('url').value = url;
            document.getElementById('loginName').value = loginName;
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        // Função para exibir a senha temporariamente
        function showPassword(element, password) {
            element.textContent = password;
            element.style.textDecoration = 'none';
            element.style.cursor = 'default';
            var cell = element.parentElement;
            cell.innerHTML = password;

            setTimeout(function () {
                cell.innerHTML = '<span class="toggle-password" onclick="showPassword(this, \'' + password + '\')">Mostrar</span>';
            }, 3000);
        }

        window.onload = function () {
            const addPasswordBtn = document.getElementById('addPasswordBtn');
            const formContainer = document.getElementById('formContainer');

            addPasswordBtn.addEventListener('click', () => {
                toggleForm();
            });
        }

        // Cria o MutationObserver para observar mudanças no DOM
        const observer = new MutationObserver(verificarTabela);

        // Observa o body para mudanças no filho (no caso, a tabela pode ser removida ou adicionada)
        observer.observe(document.body, { childList: true, subtree: true });

        // Função para verificar se a tabela existe e mostrar/ocultar a imagem
        function verificarTabela() {
            const tabela = document.getElementById('savedTable');
            const imagem = document.getElementById('img-senha');

            if (tabela) {
                imagem.style.display = 'none'; // Oculta a imagem se a tabela existir
            } else {
                imagem.style.display = 'flex'; // Mostra a imagem se a tabela não existir
            }
        }

        // Verifica no carregamento inicial
        document.addEventListener("DOMContentLoaded", verificarTabela);
    </script>
</body>

</html>