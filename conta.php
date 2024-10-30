<?php
require('./php/conta.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações da Conta</title>
    <link rel="stylesheet" href="./style/styles.css">
    <style>
        #securityWordContainer {
            display: none;
        }
        #qrCodeContainer {
            display: none;
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

    <h2>Atualizar informações</h2>

    <!-- Mensagem de sucesso ou erro -->
    <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <?php if (!empty($successMessage)): ?>
        <div class="success-message"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <form id="updateForm" action="" method="post">
    <label for="userNome">Nome:</label>
    <input type="text" id="userNome" name="userNome" value="<?php echo htmlspecialchars($userNome); ?>" required>
    <br>
    <label for="userEmail">Email:</label>
    <input type="email" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($userEmail); ?>" required>
    <br>
    <label for="userCpf">CPF:</label>
    <input type="text" id="userCpf" name="userCpf" value="<?php echo htmlspecialchars($userCpf ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <br>
    <label for="userTel">Telefone:</label>
    <input type="text" id="userTel" name="userTel" value="<?php echo htmlspecialchars($userTel ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <br>
    <label for="userPassword">Senha:</label>
    <input type="password" id="userPassword" name="userPassword" placeholder="Deixe em branco para manter a mesma">
    <br>
    <label for="dicaSenha">Dica da Senha:</label>
    <input type="password" id="dicaSenha" name="dicaSenha" value="<?php echo htmlspecialchars($dicaSenha ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <br>
    <?php if ($hasSecurityWord): ?>
        <label for="oldSecurityWord">Palavra de Segurança Atual:</label>
        <input type="password" id="oldSecurityWord" name="oldSecurityWord">
        <br>
    <?php endif; ?>
    <input type="checkbox" id="addSecurityWord" name="addSecurityWord" <?php echo $hasSecurityWord ? '' : ''; ?>>
    <label for="addSecurityWord">Adicionar/Alterar Palavra de Segurança</label>
    <br>
    <div id="securityWordContainer">
        <label for="newSecurityWord">Nova Palavra de Segurança:</label>
        <input type="password" id="newSecurityWord" name="newSecurityWord">
    </div>

    <input type="checkbox" id="enableTwoFactor" name="enableTwoFactor" <?php echo $enableTwoFactor ? 'checked' : ''; ?>>
    <label for="enableTwoFactor">Ativar/Desativar Autenticação de Dois Fatores</label>
    <br>

    <?php if ($enableTwoFactor == 0): ?>
        <!-- Botão para mostrar o QR Code -->
        <button type="button" id="showQRCodeButton">Mostrar QR Code</button>
    <?php endif; ?>
    
    <!-- Contêiner para o QR Code -->
    <div id="qrCodeContainer" style="display: none;">
        <p>Por segurança só mostramos o QR code uma vez</p>
        <p>Escaneie o QR code abaixo com o Google Authenticator:</p>
        <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code Google Authenticator">
        <p>Ou, se preferir, insira esta chave manualmente no aplicativo:</p>
        <strong><?php echo $secret; ?></strong>
        <br>
        <button type="submit" id="confirmButton">Confirmar Informações</button>
    </div>

    <!-- Botão de confirmação inicial, escondido com JavaScript -->
    <button type="submit" id="initialConfirmButton">Confirmar Informações</button>
</form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>

document.getElementById("enableTwoFactor").addEventListener("change", function() {
        document.getElementById("initialConfirmButton").style.display = this.checked ? "none" : "inline";
    });

    document.getElementById("showQRCodeButton").addEventListener("click", function() {
        document.getElementById("qrCodeContainer").style.display = "block";
        document.getElementById("initialConfirmButton").style.display = "none";
    });

        document.getElementById('addSecurityWord').addEventListener('change', function() {
            document.getElementById('securityWordContainer').style.display = this.checked ? 'block' : 'none';
        });

        document.getElementById('enableTwoFactor').addEventListener('change', function() {
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

        document.getElementById('showQRCodeButton').addEventListener('click', function() {
            const qrCodeContainer = document.getElementById('qrCodeContainer');
            qrCodeContainer.style.display = 'block';
            
            
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addSecurityWord').dispatchEvent(new Event('change'));
            document.getElementById('enableTwoFactor').dispatchEvent(new Event('change'));
        });
        $(document).ready(function() {
        // Máscara para CPF
        $('#userCpf').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{3})(\d)/, '$1.$2-$3'));
        });

        // Máscara para Telefone
        $('#userTel').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, '').replace(/(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2'));
        });
    });
</script>

    </script>
    <script src="../script/script2.js"></script>
</body>
</html>
