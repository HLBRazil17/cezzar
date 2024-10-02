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
        <input type="text" id="dicaSenha" name="dicaSenha" value="<?php echo htmlspecialchars($dicaSenha ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <br>
        <?php if ($hasSecurityWord): ?>
            <label for="oldSecurityWord">Palavra de Segurança Atual:</label>
            <input type="text" id="oldSecurityWord" name="oldSecurityWord">
            <br>
        <?php endif; ?>
        <input type="checkbox" id="addSecurityWord" name="addSecurityWord" <?php echo $hasSecurityWord ? '' : ''; ?>>
        <label for="addSecurityWord">Adicionar/Alterar Palavra de Segurança</label>
        <br>
        <div id="securityWordContainer">
            <label for="newSecurityWord">Nova Palavra de Segurança:</label>
            <input type="text" id="newSecurityWord" name="newSecurityWord">
        </div>

        <input type="checkbox" id="enableTwoFactor" name="enableTwoFactor" <?php echo $enableTwoFactor ? 'checked' : ''; ?>>
        <label for="enableTwoFactor">Ativar Autenticação de Dois Fatores</label>
        <br>

        <!-- Botão para mostrar o QR Code -->
        <button type="button" id="showQRCodeButton" style="display: none;">Mostrar QR Code</button>
        
        <!-- Contêiner para o QR Code -->
        <div id="qrCodeContainer">
            <?php
            // caminho python (Mudar isso para como está o seu)
            $pythonCaminho = 'C:\Users\mathe\Downloads\gerenciador2\php\otp.py';

            // monta o comando para executar o script Python
            $command = escapeshellcmd("python \"$pythonCaminho\"");

            // coloca o python pra trabalhar, e pega o resultado da saída
            $output = shell_exec($command);

            // dividir cada resultado com uma "|"
            list($codigo_otp, $link, $validade) = explode('|', $output);

            // verifica se foi gerado o arquivo
            if (file_exists('./img/qrcode.png')) {
                // exibir imagem qrcode
                echo '<h2>QR Code:</h2>';
                echo '<img src="./img/qrcode.png" alt="QR Code">';
            } else {
                echo 'O QR code não foi gerado.';
            }
            ?>
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
            }, 3000); // Hide QR code after 3 seconds
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('addSecurityWord').dispatchEvent(new Event('change'));
            document.getElementById('enableTwoFactor').dispatchEvent(new Event('change'));
        });
    </script>
    <script src="../script/script2.js"></script>
</body>
</html>
