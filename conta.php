<?php
require('./php/conta.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações da Conta</title>
    <link rel="stylesheet" href="">
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
        <label for="enableTwoFactor">Ativar Autenticação de Dois Fatores</label>
        <br>

        <?php if ($enableTwoFactor == 0): // Verifica se o enableTwoFactor é 0 ?>
        <!-- Botão para mostrar o QR Code -->
        <button type="button" id="showQRCodeButton">Mostrar QR Code</button>
        <?php endif; ?>
        
        <!-- Contêiner para o QR Code -->
        <div id="qrCodeContainer">
        <p>Por segurança so mostramos o QR code uma vez</p>
        <p>Escaneie o QR code abaixo com o Google Authenticator:</p>

<img src="<?php echo $qrCodeUrl; ?>" alt="QR Code Google Authenticator">

<p>Ou, se preferir, insira esta chave manualmente no aplicativo:</p>
<strong><?php echo $secret; ?></strong>

        </div>

        <button type="submit">Confirmar Informações</button>
    </form>

    <script>
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
            
            setTimeout(() => {
                qrCodeContainer.style.display = 'none';
            }, 5000); // Hide QR code after 5 seconds
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addSecurityWord').dispatchEvent(new Event('change'));
            document.getElementById('enableTwoFactor').dispatchEvent(new Event('change'));
        });
    </script>
    <script src="../script/script2.js"></script>
</body>
</html>
