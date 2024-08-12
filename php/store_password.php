<?php
// Incluir o arquivo de conexão com o banco de dados
require('conectar.php');

// Inicializar variáveis para mensagens de erro e sucesso
$errorMessage = '';
$successMessage = '';

// Recuperar o ID do usuário da URL
$userID = isset($_GET['userID']) ? intval($_GET['userID']) : 0;

// Verificar se o ID do usuário é válido
if ($userID <= 0) {
    die('ID de usuário inválido.');
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar os dados do formulário
    $siteName = $_POST['siteName'];
    $url = $_POST['url'];
    $loginName = $_POST['loginName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar os dados
    if (empty($siteName) || empty($password)) {
        $errorMessage = 'O nome do site e a senha são obrigatórios.';
    } else {
        // Caminho da imagem (se aplicável)
        $imagePath = 'front/img/salvar.png'; // Use um valor padrão ou modifique conforme necessário

        // Preparar a consulta SQL
        $sql = "INSERT INTO gerenciadorsenhas.passwords (user_id, site_name, email, name, password, url, midia) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparar a declaração
        if ($stmt = $conn->prepare($sql)) {
            // Vincular parâmetros
            $stmt->bind_param("issssss", $userID, $siteName, $email, $loginName, $password, $url, $imagePath);

            // Executar a declaração
            if ($stmt->execute()) {
                $successMessage = 'Senha armazenada com sucesso!';
            } else {
                $errorMessage = 'Ocorreu um erro ao armazenar a senha. Por favor, tente novamente.';
            }

            // Fechar a declaração
            $stmt->close();
        } else {
            $errorMessage = 'Não foi possível preparar a declaração SQL.';
        }
    }
}

// Recuperar informações salvas para exibir
$savedPasswords = [];
$sql = "SELECT site_name, url, email, name, password FROM gerenciadorsenhas.passwords WHERE user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $savedPasswords[] = $row;
    }

    $stmt->close();
}
?>
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

    <!-- Formulário de adição de senha -->
    <div class="form-container" id="formContainer">
        <form action="" method="post">
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($savedPasswords as $password): ?>
                <tr>
                    <td><a href="<?php echo htmlspecialchars($password['url']); ?>" target="_blank"><?php echo htmlspecialchars($password['site_name']); ?></a></td>
                    <td><?php echo htmlspecialchars($password['name']); ?></td>
                    <td><?php echo htmlspecialchars($password['email']); ?></td>
                    <td><span class="toggle-password" onclick="showPassword(this, '<?php echo htmlspecialchars($password['password']); ?>')">Mostrar</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <script>
        function toggleForm() {
            var form = document.getElementById('formContainer');
            form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
        }

        function cancelForm() {
            document.getElementById('formContainer').style.display = 'none';
        }

        function showPassword(element, password) {
            var cell = element.parentElement;
            cell.innerHTML = password;
            setTimeout(function() {
                cell.innerHTML = '<span class="toggle-password" onclick="showPassword(this, \'' + password + '\')">Mostrar</span>';
            }, 3000);
        }
    </script>
</body>
</html>
