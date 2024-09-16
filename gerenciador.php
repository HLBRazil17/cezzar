<?php
session_start();
require './php/gerenciador.php'
    ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <title>Gerenciar Usuários</title>
    <style>
        /* Estilos para células editáveis */
        td[contenteditable="true"] {
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #003b70;
            /* cor de fundo da tabela */
            color: #fff;
            /* cor do texto */
            margin-bottom: 20vh;
            /* distância inferior */
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border: 1px solid #023e8a;
            /* cor das bordas */
        }

        th {
            background-color: #00234d;
            /* cor de fundo do cabeçalho */
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #002f63;
            /* cor das linhas pares */
        }

        tr:hover {
            background-color: #014f86;
            /* cor ao passar o mouse */
        }

        button {
            background-color: #023e8a;
            /* cor dos botões */
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0077b6;
            /* cor ao passar o mouse nos botões */
        }

        button.delete {
            background-color: #d90429;
            /* botão de deletar em vermelho */
        }

        button.delete:hover {
            background-color: #ef233c;
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
                        <a href="index.php" class="navbar-item" data-scroll="planos">Planos</a>
                        <a href="#" class="navbar-item">Sobre</a>
                        <a href="#" class="navbar-item">Contate-nos</a>
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
                                <p>Bem-vindo! <?php echo $_SESSION['userNome']; ?></p>
                                <a href="account.php" style="font-size: 18px;">Detalhes da Conta</a>
                                <a href="./php/logout.php" style="border-bottom: none; font-size: 18px;">Sair da conta</a>
                            <?php else: ?>
                                <p>Bem-vindo!</p>
                                <a href="register.php">Registrar uma Conta</a>
                                <a href="login.php" style="border-bottom: none;">Login em Conta</a>
                            <?php endif; ?>
                        </div>
                    </details>
                </div>
            </div>
            </div>
        </nav>
    </header>

    <div class="header">
        <h1>Gerenciar Usuários</h1>
    </div>

    <!-- Exibir mensagens de sucesso e erro -->

    <?php

    if ($errorMessage): ?>
        <div style="color: red;">
            <?= htmlspecialchars($errorMessage ?? '', ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if ($successMessage): ?>
        <div style="color: green;">
            <?= htmlspecialchars($successMessage ?? '', ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <!-- Formulário de pesquisa -->
    <form method="POST" action="">
        <input type="text" name="searchTerm" value="<?= htmlspecialchars($searchTerm ?? '', ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Pesquisar">
        <button type="submit" name="actionType" value="search">Pesquisar</button>
    </form>

    <!-- Tabela de usuários -->
    <table border="2" style="margin-bottom:20vh;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Role</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['userID'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userNome'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userEmail'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userCpf'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userTel'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['userEstato'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($user['role'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="userID"
                                value="<?= htmlspecialchars($user['userID'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" name="actionType" value="update">Atualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulário de verificação de código -->
    <?php if ($showCodeForm): ?>
        <div id="codeForm">
            <h2>Verifique o Código</h2>
            <form method="POST" action="">
                <input type="hidden" name="userID" value="<?= htmlspecialchars($userToEdit ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" required>
                <button type="submit" name="actionType" value="verifyCode">Verificar Código</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Formulário de edição de usuário -->
    <?php if ($showEditForm && $canEdit): ?>
        <div id="editForm">
            <h2>Editar Usuário</h2>
            <form method="POST" action="">
                <input type="hidden" name="userID" value="<?= htmlspecialchars($_POST['userID'] ?? ''); ?>">
                <label for="userNome">Nome:</label>
                <input type="text" id="userNome" name="userNome"
                    value="<?= htmlspecialchars($userData['userNome'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                <br>
                <label for="userEmail">Email:</label>
                <input type="email" id="userEmail" name="userEmail"
                    value="<?= htmlspecialchars($userData['userEmail'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                <br>
                <label for="userCpf">CPF:</label>
                <input type="text" id="userCpf" name="userCpf"
                    value="<?= htmlspecialchars($userData['userCpf'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <br>
                <label for="userTel">Telefone:</label>
                <input type="text" id="userTel" name="userTel"
                    value="<?= htmlspecialchars($userData['userTel'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <br>
                <label for="userEstato">Status:</label>
                <select id="userEstato" name="userEstato">
                    <option value="Ativo" <?= ($userData['userEstato'] ?? '') === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                    <option value="Inativo" <?= ($userData['userEstato'] ?? '') === 'Inativo' ? 'selected' : '' ?>>Inativo
                    </option>
                </select>
                <br>
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="user" <?= ($userData['role'] ?? '') === 'user' ? 'selected' : '' ?>>user</option>
                    <option value="admin" <?= ($userData['role'] ?? '') === 'admin' ? 'selected' : '' ?>>admin</option>
                </select>

                <br>
                <button type="submit" name="actionType" value="saveChanges">Salvar Alterações</button>
            </form>
        </div>
    <?php endif; ?>

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

    <script src="../script/script2.js"></script>
</body>

</html>