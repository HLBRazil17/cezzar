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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contate-nos</title>
    <link rel="stylesheet" href="./style/styles2.css">
</head>
<body>

    <div class="contact-container">
        <h1>Contate-nos</h1>

        <!-- Exibe mensagens de sucesso ou erro -->
        <div class="message">
            <?php if ($successMessage): ?>
                <p class="success-message"><?php echo $successMessage; ?></p>
            <?php elseif ($errorMessage): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </div>

        <form action="envia_contato.php" method="POST">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userNome); ?>" <?php echo $userNome ? 'readonly' : 'required'; ?>>
                <span class="small-text">Por favor, preencha com o nome da sua conta.</span>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>" <?php echo $userEmail ? 'readonly' : 'required'; ?>>
                <span class="small-text">Por favor, preencha com o e-mail da sua conta, mas caso tenha perdido acesso ao e-mail, informe o seu novo e-mail no corpo da mensagem.</span>
            </div>
            <div class="form-group">
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" rows="6" required></textarea>
                <span class="small-text">Por favor, explique de forma breve o motivo de entrar em contato.</span>
                <br>
                <span class="small-text">Caso tenha um telefone cadastrado, tentaremos entrar em contato por ele; caso não, iremos contatá-lo pelo e-mail.</span>
            </div>
            <button type="submit">Enviar</button>
        </form>

        <!-- Link para WhatsApp -->
        <div class="whatsapp-contact">
            <p>Se preferir, você pode entrar em contato diretamente pelo WhatsApp:</p>
            <a href="https://wa.me/5518997423619?text=Olá!%20Preciso%20de%20suporte." target="_blank">Converse comigo no WhatsApp</a>
        </div>
    </div>
</body>
</html>
