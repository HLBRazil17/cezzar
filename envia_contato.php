<?php
session_start(); // Inicia a sessão para acessar os dados do usuário logado

require("./php/functions.php");
require("./php/conectar.php");

$successMessage = '';
$errorMessage = '';
$userNome = '';
$userEmail = '';
$userID = '';

// Verifica se o usuário está logado
if (isset($_SESSION['userNome']) && isset($_SESSION['userEmail'])) {
    $userNome = $_SESSION['userNome']; // Nome do usuário logado
    $userEmail = $_SESSION['userEmail']; // E-mail do usuário logado 
    $userID = $_SESSION['userID'];
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validações básicas
    if (empty($name) || empty($email) || empty($message)) {
        $errorMessage = 'Por favor, preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Por favor, insira um e-mail válido.';
    } else {
        // Conteúdo do e-mail
        $subject = 'Novo Pedido de Suporte - ' . $name;
        $bodyContent = "<h1>Pedido de Suporte Recebido</h1>
                        <p>Olá,</p>
                        <p>Você recebeu um novo pedido de suporte através do formulário de contato.</p>
                        <p><strong>Nome do Usuário:</strong> {$name}</p>
                        <p><strong>E-mail do Usuário:</strong> {$email}</p>
                        <p><strong>Mensagem:</strong></p>
                        <blockquote>{$message}</blockquote>
                        <p>Por favor, entre em contato com o usuário para fornecer a assistência necessária.</p>
                        <p>Atenciosamente,<br>Equipe de Suporte</p>";
        // Envia o e-mail utilizando a função sendEmail
        $result = sendEmail('ProtectKey@gmail.com', $subject, $bodyContent);

        if ($result === '') {
            logAction($conn, $userID, 'Suporte', 'Suporte de conta:' . $_SESSION['userNome'] . ' ');
            // Redireciona após o envio do e-mail
            header('Location: envia_contato.php?success=1');
            exit();
        } else {
            $errorMessage = $result;
        }
    }
}

// Mensagem de sucesso para exibir se redirecionado
if (isset($_GET['success'])) {
    $successMessage = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
}
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!--import font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--import css/scroll-->
    <link rel="stylesheet" href="./style/styles.css">

    <title>Protect Key</title>

    <style>
        main {
            background: linear-gradient(160deg, #090c30 0%, #1e2a91 50%, #3d84d6c7 100%);
        }

        .form {
            display: flex;
            flex-direction: column;
            align-self: center;
            font-family: inherit;
            gap: 10px;
            padding-inline: 2em;
            padding-bottom: 0.4em;
            background-color: #171717;
            //background-color: #0a192f;
            border-radius: 20px;
        }

        .form-heading {
            text-align: center;
            margin: 2em;
            color: #64ffda;
            font-size: 1.2em;
            background-color: transparent;
            align-self: center;
        }

        .form-field {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5em;
            border-radius: 10px;
            padding: 0.6em;
            border: none;
            outline: none;
            color: white;
            background-color: #171717;
            box-shadow: inset 2px 5px 10px rgb(5, 5, 5);
        }

        .input-field {
            background: none;
            border: none;
            outline: none;
            width: 100%;
            color: #ccd6f6;
            padding-inline: 1em;
        }

        .sendMessage-btn {
            cursor: pointer;
            margin-bottom: 3em;
            padding: 1em;
            border-radius: 10px;
            border: none;
            outline: none;
            background-color: transparent;
            color: #64ffda;
            font-weight: bold;
            outline: 1px solid #64ffda;
            transition: all ease-in-out 0.3s;
        }

        .sendMessage-btn:hover {
            transition: all ease-in-out 0.3s;
            background-color: #64ffda;
            color: #000;
            cursor: pointer;
            box-shadow: inset 2px 5px 10px rgb(5, 5, 5);
        }

        .form-card1 {
            background-image: linear-gradient(163deg, #64ffda 0%, #64ffda 100%);
            border-radius: 22px;
            transition: all 0.3s;
            margin: 10vh 25vw;
        }

        .form-card1:hover {
            box-shadow: 0px 0px 30px 1px rgba(100, 255, 218, 0.3);
        }

        .form-card2 {
            border-radius: 0;
            transition: all 0.2s;
        }

        .form-card2:hover {
            transform: scale(0.98);
            border-radius: 20px;
        }
    </style>
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
                    <div class="navbar-menu" id="navbarMenu">
                        <?php if (isset($_SESSION['userNome'])): ?>
                            <a href="store_password.php" class="navbar-item">Controle de Senhas</a>
                            <a href="planos.php" class="navbar-item">Planos</a>
                            <a href="envia_contato.php" class="navbar-item">Contate-nos</a>

                        <?php else: ?>
                            <a href="store_password.php" class="navbar-item">Controle de Senhas</a>
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
                                    style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;"
                                    class="dropdown-content-a2">Login</a>
                            <?php endif; ?>
                        </div>
                    </details>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="form-card1">
            <div class="form-card2">
                <!-- Formulário de contato com PHP -->
                <form class="form" action="envia_contato.php" method="POST">
                    <p class="form-heading">Get In Touch</p>

                    <!-- Exibe mensagens de sucesso ou erro -->
                    <div class="message">
                        <?php if ($successMessage): ?>
                            <p class="success-message"><?php echo $successMessage; ?></p>
                        <?php elseif ($errorMessage): ?>
                            <p class="error-message"><?php echo $errorMessage; ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Campo Nome -->
                    <div class="form-field">
                        <input type="text" id="name" name="name" class="input-field" placeholder="Name"
                            value="<?php echo htmlspecialchars($userNome); ?>" <?php echo $userNome ? 'readonly' : 'required'; ?> />
                    </div>

                    <!-- Campo E-mail -->
                    <div class="form-field">
                        <input type="email" id="email" name="email" class="input-field" placeholder="Email"
                            value="<?php echo htmlspecialchars($userEmail); ?>" <?php echo $userEmail ? 'readonly' : 'required'; ?> />
                    </div>

                    <!-- Campo Assunto -->
                    <div class="form-field">
                        <input type="text" id="subject" name="subject" class="input-field" placeholder="Subject"
                            required />
                    </div>

                    <!-- Campo Mensagem -->
                    <div class="form-field">
                        <textarea id="message" name="message" rows="3" class="input-field" placeholder="Message"
                            required></textarea>
                    </div>

                    <!-- Botão de envio -->
                    <button type="submit" class="sendMessage-btn">Send Message</button>
                </form>
            </div>
        </div>
    </main>


    <!--FOOTER-->
    <footer>
        <div class="content">
            <div class="top">
                <div class="logo-details">
                    <a href="#"><img class="logo-footer" src="./img/ProtectKey-LOGOW.png" alt="logo icon"></a>
                </div>
            </div>
            <div class="link-boxes">
                <ul class="box">
                    <li class="link_name">Companhia</li>
                    <li><a href="#">Página Inicial</a></li>
                    <li><a href="./register.php">Começar Agora</a></li>
                    <li><a href="./planos.php">Planos</a></li>
                    <li><a href="./envia_contato.php">Entrar em Contato</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Serviços</li>
                    <li><a href="./store_password.php">Gerenciar Senhas</a></li>
                    <li><a href="./store_password.php">Gerar uma Senha</a></li>
                    <li><a href="./store_password.php">Criar uma Senha</a></li>
                    <li><a href="./store_password.php">Inserir um Documento</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Conta</li>
                    <li><a href="./conta.php">Configurações Gerais</a></li>
                    <li><a href="./esqueceu_senha.php">Esqueci Minha Senha</a></li>
                    <li><a href="./conta.php">Alterar Senha</a></li>
                </ul>
                <ul class="box input-box-fot">
                    <li class="link_name">Registre-se</li>
                    <li><input type="text" placeholder="Insira seu E-mail"></li>
                    <li><input type="button" value="Registrar"></li>
                </ul>
            </div>
        </div>
        <div class="bottom-details">
            <div class="bottom_text">
                <span class="copyright_text">Copyright © 2024 <a href="#">Protect Key</a>Todos os direitos
                    reservados.</span>
            </div>
        </div>
    </footer>
</body>

</html>