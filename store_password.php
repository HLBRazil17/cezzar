<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Armazenar Senha</title>
    <link rel="stylesheet" href="./Front/styles2.css">
</head>
<body>

    <div class="header">
        <h1>Armazenar Senha</h1>
    </div>

    <!-- Botão para adicionar senha -->
    <img src="./Front/img/salvar.png" style="width: 60px;" alt="Adicionar Senha" class="add-password-btn" onclick="toggleForm()">

    <!-- Formulário de adição/atualização de senha -->
    <div class="form-container" id="formContainer">
        <form id="passwordForm" action="" method="post">
            <input type="hidden" id="actionType" name="actionType" value="add">
            <input type="hidden" id="passwordId" name="passwordId" value="">

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
        </form>
    </div>

    <!-- Tabela com as informações salvas -->
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
                <?php foreach ($savedPasswords as $password): ?>
                <tr>
                    <td><a href="<?php echo htmlspecialchars($password['url']); ?>" target="_blank"><?php echo htmlspecialchars($password['site_name']); ?></a></td>
                    <td><?php echo htmlspecialchars($password['name']); ?></td>
                    <td><?php echo htmlspecialchars($password['email']); ?></td>
                    <td><span class="toggle-password" onclick="showPassword(this, '<?php echo htmlspecialchars($password['password']); ?>')">Mostrar</span></td>
                    <td>
                        <!-- Formulário para atualização -->
                        <button class="update-btn" onclick="editPassword(<?php echo htmlspecialchars($password['senhaId']); ?>, '<?php echo htmlspecialchars($password['site_name']); ?>', '<?php echo htmlspecialchars($password['url']); ?>', '<?php echo htmlspecialchars($password['name']); ?>', '<?php echo htmlspecialchars($password['email']); ?>', '<?php echo htmlspecialchars($password['password']); ?>')">Atualizar</button>
                        <!-- Formulário para exclusão -->
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="passwordId" value="<?php echo htmlspecialchars($password['senhaId']); ?>">
                            <input type="hidden" name="actionType" value="delete">
                            <button type="submit" class="delete-btn" onclick="return confirm('Tem certeza que deseja excluir esta senha?')">Deletar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <script>
        function toggleForm() {
            var formContainer = document.getElementById('formContainer');
            if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                formContainer.style.display = 'block';
            } else {
                formContainer.style.display = 'none';
            }
        }

        function cancelForm() {
            var formContainer = document.getElementById('formContainer');
            formContainer.style.display = 'none';
        }

        function editPassword(id, siteName, url, loginName, email, password) {
            var formContainer = document.getElementById('formContainer');
            formContainer.style.display = 'block';

            document.getElementById('actionType').value = 'update';
            document.getElementById('passwordId').value = id;
            document.getElementById('siteName').value = siteName;
            document.getElementById('url').value = url;
            document.getElementById('loginName').value = loginName;
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        function showPassword(element, password) {
            element.textContent = password;
            element.style.textDecoration = 'none';
            element.style.cursor = 'default';
            var cell = element.parentElement;
            cell.innerHTML = password;
            setTimeout(function() {
                cell.innerHTML = '<span class="toggle-password" onclick="showPassword(this, \'' + password + '\')">Mostrar</span>';
            }, 3000);
        }
    
    </script>
    

    <!-- Botão de Logout -->
     <form action="logout.php" method="post" style="display: inline;">
    <button type="submit" class="logout-btn">Sair</button>
     </form>

</body>
</html>
