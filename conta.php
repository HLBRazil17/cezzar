<?php
require('./php/conta.php');
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
    <link rel="stylesheet" href="./style/styles-account.css">

    <style>
        #securityWordContainer {
            display: none;
        }

        #qrCodeContainer {
            display: none;
            text-align: center;
            margin: 0 0 0 -150px;
        }

        #qrCodeContainer p {
            margin: 20px;
        }
    </style>

    <title>Configurações da Conta</title>
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

                    <!-- Menu de navegação -->
                    <div class="navbar-menu" id="navbarMenu">
                        <a href="store_password.php" class="navbar-item">Controle de Senhas</a>
                        <a href="planos.php" class="navbar-item">Planos</a>
                        <!--    <a href="#" class="navbar-item">Sobre</a>   -->
                        <a href="envia_contato.php" class="navbar-item">Contate-nos</a>
                        <?php if (checkAdminRole($conn, $userID)) { ?>
                            <a href="gerenciador.php" class="navbar-item">Gerenciador</a>
                            <a href="logs.php" class="navbar-item">Logs</a>
                        <?php } ?>
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
                                <a href="conta.php">Detalhes</a>
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

    <div class="settings-page">
        <div class="settings-container card">
            <div class="card__border"></div>
            <h1 class="page-title">Configurações da Conta</h1>

            <div class="settings-section">
                <h2 class="settings-title">Informações Gerais</h2>
                <form id="updateForm" action="" method="post" class="my-form">

                    <div class="form-group">
                        <div class="input-group">
                            <label class="label" for="userNome">Nome</label>
                            <input type="text" id="userNome" name="userNome" class="input"
                                value="<?php echo htmlspecialchars($userNome); ?>" required autocomplete="off">
                            <div></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label class="label" for="userEmail">Email</label>
                            <input type="email" id="userEmail" name="userEmail" class="input"
                                value="<?php echo htmlspecialchars($userEmail); ?>" required autocomplete="off">
                            <div></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label class="label" for="userCpf">CPF</label>
                            <input type="text" id="userCpf" name="userCpf" class="input"
                                value="<?php echo htmlspecialchars($userCpf ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                autocomplete="off">
                            <div></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label class="label" for="userTel">Telefone</label>
                            <input type="text" id="userTel" name="userTel" class="input"
                                value="<?php echo htmlspecialchars($userTel ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                autocomplete="off">
                            <div></div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="settings-section">
                <h2 class="settings-title">Senha</h2>
                <form id="updateForm" action="" method="post" class="my-form">

                    <div class="form-group">
                        <div class="input-group">
                            <label class="label" for="userPassword">Senha</label>
                            <input type="password" id="userPassword" name="userPassword" class="input"
                                placeholder="Deixe em branco para manter a mesma">
                            <div></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label class="label" for="dicaSenha">Dica da Senha</label>
                            <input type="password" id="dicaSenha" name="dicaSenha" class="input"
                                value="<?php echo htmlspecialchars($dicaSenha ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <div></div>
                        </div>
                    </div>

                    <?php if ($hasSecurityWord): ?>
                        <div class="form-group">
                            <div class="input-group">
                                <label class="label" for="oldSecurityWord">Palavra de Segurança Atual</label>
                                <input type="password" id="oldSecurityWord" name="oldSecurityWord" class="input">
                                <div></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <label class="label" for="newSecurityWord" style="margin: 10px 0px 0px -60px;">Adicionar/Alterar
                        Palavra de Segurança</label>
                    <label class="container">
                        <!-- Checkbox com PHP -->
                        <input type="checkbox" id="addSecurityWord" name="addSecurityWord" <?php echo $hasSecurityWord ? 'checked' : ''; ?> onchange="toggleSecurityWordField()">
                        <div class="checkmark"></div>
                    </label>

                    <!-- Div com campo de senha, inicialmente oculta -->
                    <div class="form-group" id="newSecurityWordField" style="display: none;">
                        <div class="input-group">
                            <label class="label" for="newSecurityWord">Nova Palavra de Segurança</label>
                            <input type="password" id="newSecurityWord" name="newSecurityWord" class="input">
                            <div></div>
                        </div>
                    </div>


                </form>
            </div>

            <div class="settings-section">
                <h2 class="settings-title">Autenticação de Dois Fatores</h2>
                <form id="updateForm" action="" method="post" class="my-form" style="margin: 30px auto 30px 250px;">


                    <label class="label" for="newSecurityWord" style="margin: 10px 0px 0px -60px;">Adicionar/Alterar
                        Palavra de Segurança</label>
                    <label class="container">
                        <input type="checkbox" id="enableTwoFactor" name="enableTwoFactor" <?php echo $enableTwoFactor ? 'checked' : ''; ?>>
                        <div class="checkmark"></div>
                    </label>



                    <?php if ($enableTwoFactor == 0): ?>
                        <div class="form-group">
                            <button type="button" id="showQRCodeButton">
                                Mostrar QR Code
                            </button>
                        </div>
                    <?php endif; ?>

                    <div id="qrCodeContainer" style="display: none;">
                        <p>Por segurança só mostramos o QR code uma vez.</p>
                        <p>Escaneie o QR code abaixo com o Google Authenticator:</p>
                        <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code Google Authenticator">
                        <p>Ou, se preferir, insira esta chave manualmente no aplicativo:</p>
                        <strong><?php echo $secret; ?></strong>
                    </div>

                    <div class="form-submit">
                        <button type="submit" id="initialConfirmButton" class="btn button full">Confirmar
                            Informações</button>
                    </div>

                    <!-- Mensagem de sucesso ou erro -->
                    <?php if (!empty($errorMessage)): ?>
                        <div class="error-message" style="padding: 10px; color: red; width:fit-content; margin-left: -10px; font-weight: bold; font-size: 14px; background-color: #fdd; border-radius: 10px;"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($successMessage)): ?>
                        <div class="success-message" style="padding: 10px; color: green; width:fit-content; margin-left: -10px; font-weight: bold; font-size: 14px; background-color: #ddffe0; border-radius: 10px;"><?php echo $successMessage; ?></div>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </div>

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



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>

        document.getElementById("enableTwoFactor").addEventListener("change", function () {
            document.getElementById("initialConfirmButton").style.display = this.checked ? "none" : "inline";
        });

        document.getElementById("showQRCodeButton").addEventListener("click", function () {
            document.getElementById("qrCodeContainer").style.display = "block";
            document.getElementById("initialConfirmButton").style.display = "none";
        });

        document.getElementById('addSecurityWord').addEventListener('change', function () {
            document.getElementById('securityWordContainer').style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('enableTwoFactor').addEventListener('change', function () {
            const qrCodeContainer = document.getElementById('qrCodeContainer');
            const showQRCodeButton = document.getElementById('showQRCodeButton');

            if (this.checked) {
                showQRCodeButton.style.display = 'block';
                qrCodeContainer.style.display = 'none'; // Initially hide QR code
            } else {
                showQRCodeButton.style.display = 'none';
                qrCodeContainer.style.display = 'none'; // Ensure QR code is hidden
            }
        });

        document.getElementById('showQRCodeButton').addEventListener('click', function () {
            const qrCodeContainer = document.getElementById('qrCodeContainer');
            qrCodeContainer.style.display = 'block';


        });

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('addSecurityWord').dispatchEvent(new Event('change'));
            document.getElementById('enableTwoFactor').dispatchEvent(new Event('change'));
        });
        $(document).ready(function () {
            // Máscara para CPF
            $('#userCpf').on('input', function () {
                $(this).val($(this).val().replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{3})(\d)/, '$1.$2-$3'));
            });

            // Máscara para Telefone
            $('#userTel').on('input', function () {
                $(this).val($(this).val().replace(/\D/g, '').replace(/(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2'));
            });
        });

        function toggleSecurityWordField() {
            var checkbox = document.getElementById('addSecurityWord');
            var securityWordField = document.getElementById('newSecurityWordField');

            if (checkbox.checked) {
                securityWordField.style.display = 'block'; // Exibe o campo de senha
            } else {
                securityWordField.style.display = 'none'; // Esconde o campo de senha
            }
        }

        // Inicializa o estado do checkbox ao carregar a página
        document.addEventListener('DOMContentLoaded', function () {
            toggleSecurityWordField();
        });

    </script>

    </script>
    <script src="../script/script2.js"></script>
</body>

</html>