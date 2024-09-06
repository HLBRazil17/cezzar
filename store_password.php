<?php
session_start();
require './php/store_password.php';
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
                        <a href="index.php" class="navbar-item" data-scroll="planos">Planos</a>
                        <a href="#" class="navbar-item">Sobre</a>
                        <a href="#" class="navbar-item">Contate-nos</a>
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
                                <a href="account.php">Detalhes</a>
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


    <!-- Formulário de adição/atualização de senha -->
    <div class="form-container" id="formContainer">
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
    </div>

    <!-- Tabela com senhas salvas -->
    <?php if (!empty($savedPasswords)): ?>
        <div class="saved-table" id="savedTable">
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
                            <td>
                                <!-- Botão de atualização de senha -->
                                <button class="update-btn"
                                    onclick="editPassword(<?php echo htmlspecialchars($password['senhaId']); ?>, '<?php echo htmlspecialchars($password['site_name']); ?>', '<?php echo htmlspecialchars($password['url']); ?>', '<?php echo htmlspecialchars($password['name']); ?>', '<?php echo htmlspecialchars($password['email']); ?>', '<?php echo htmlspecialchars($password['password']); ?>')">Atualizar</button>
                                <!-- Formulário para exclusão de senha -->
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="passwordId"
                                        value="<?php echo htmlspecialchars($password['senhaId']); ?>">
                                    <input type="hidden" name="actionType" value="delete">
                                    <button type="submit" class="delete-btn"
                                        onclick="return confirm('Tem certeza que deseja excluir esta senha?')">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Exibe a imagem se não houver senhas salvas -->
        <img src="./img/sem-itens.png" alt="Adicionar Senha" class="img-no-itens">
    <?php endif; ?>

    <!-- Botão para adicionar senha -->
    <button type="button" class="button" onclick="toggleForm()">
        <span class="button__text">Adicionar</span>
        <span class="button__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2"
                stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="44" fill="none"
                class="svg">
                <line y2="19" y1="5" x2="12" x1="12"></line>
                <line y2="12" y1="12" x2="19" x1="5"></line>
            </svg></span>
    </button>


    <!-- Funções JavaScript para manipular formulário e senhas -->
    <script>

        // Função para exibir/esconder o formulário com transição suave
        function toggleForm() {
            var formContainer = document.getElementById('formContainer');
            // Alterna a classe 'show' que controla a visibilidade
            if (formContainer.classList.contains('show')) {
                formContainer.classList.remove('show'); // Esconde o formulário
            } else {
                formContainer.classList.add('show'); // Mostra o formulário
            }
        }

        // Função para esconder o formulário
        function cancelForm() {
            var formContainer = document.getElementById('formContainer');
            formContainer.classList.remove('show'); // Esconde o formulário
        }

        // Função para editar a senha e exibir o formulário
        function editPassword(id, siteName, url, loginName, email, password) {
            var formContainer = document.getElementById('formContainer');
            formContainer.classList.add('show'); // Mostra o formulário

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

            // Após 3 segundos, oculta novamente
            setTimeout(function () {
                cell.innerHTML = '<span class="toggle-password" onclick="showPassword(this, \'' + password + '\')">Mostrar</span>';
            }, 3000);
        }

        // Certifique-se de que o DOM está completamente carregado
        window.onload = function () {
            const addPasswordBtn = document.getElementById('addPasswordBtn');
            const formContainer = document.getElementById('formContainer');

            // Evento de clique no botão para mostrar/ocultar o formulário
            addPasswordBtn.addEventListener('click', () => {
                toggleForm();
            });
        }
    </script>

</body>

</html>