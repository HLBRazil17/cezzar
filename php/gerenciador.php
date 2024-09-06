<?php
require('conectar.php');
require('logAction.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require './lib/vendor/autoload.php';

$errorMessage = '';
$successMessage = '';
$showCodeForm = false;
$showEditForm = false;
$userToEdit = null;
$canEdit = false;
$userData = [];
$searchTerm = '';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

// Obter a role do usuário
$userID = $_SESSION['userID'];
$sql = "SELECT role FROM users WHERE userID = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();
    $stmt->close();

    // Verificar se a role é "admin"
    if ($role !== 'admin') {
        header('Location: ../index.php');
        exit();
    }
} else {
    $errorMessage = 'Não foi possível verificar a permissão do usuário.';
    header('Location: ../index.php');
    exit();
}

// Verifica o id do adm e o nome do adm
$admID = $_SESSION['userID'];
$adminNome = $_SESSION['userNome'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actionType = $_POST['actionType'];

    if ($actionType === 'update') {
        $userID = $_POST['userID'];

        // Buscar o e-mail do usuário
        $emailQuery = $conn->prepare("SELECT userEmail FROM users WHERE userID = ?");
        $emailQuery->bind_param("i", $userID);
        $emailQuery->execute();
        $emailQuery->bind_result($userEmail);
        $emailQuery->fetch();
        $emailQuery->close();

        if ($userEmail) {
            // Gerar código
            $codigo = rand(100000, 999999);

            // Atualizar o código na tabela verification_codes
            $expiryDate = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            $updateCodigoQuery = $conn->prepare("INSERT INTO verification_codes (user_id, codigo, created_at, expiry_date) VALUES (?, ?, NOW(), ?)");
            $updateCodigoQuery->bind_param("iis", $userID, $codigo, $expiryDate);
            $updateCodigoQuery->execute();
            $updateCodigoQuery->close();

            // Enviar o código para o e-mail
            $mailResult = sendCodigoEmail($userEmail, $codigo);
            if ($mailResult === '') {
                $successMessage = 'Código enviado com sucesso para o e-mail do usuário.';
                $showCodeForm = true;
                $userToEdit = $userID;
            } else {
                $errorMessage = $mailResult;
            }
        } else {
            $errorMessage = 'Usuário não encontrado.';
        }
    } elseif ($actionType === 'verifyCode') {
        $userID = $_POST['userID'];
        $inputCodigo = $_POST['codigo'];

        // Buscar o código do usuário
        $codigoQuery = $conn->prepare("SELECT codigo FROM verification_codes WHERE user_id = ? AND codigo = ? AND expiry_date > NOW()");
        $codigoQuery->bind_param("ii", $userID, $inputCodigo);
        $codigoQuery->execute();
        $codigoQuery->bind_result($storedCodigo);
        $codigoQuery->fetch();
        $codigoQuery->close();

        if ($inputCodigo == $storedCodigo) {
            // Deletar o código após uso
            $deleteCodigoQuery = $conn->prepare("DELETE FROM verification_codes WHERE user_id = ? AND codigo = ?");
            $deleteCodigoQuery->bind_param("ii", $userID, $inputCodigo);
            $deleteCodigoQuery->execute();
            $deleteCodigoQuery->close();

            $showEditForm = true;
            $canEdit = true;

            // Buscar dados do usuário para preencher o formulário
            $userQuery = $conn->prepare("SELECT userNome, userEmail, userCpf, userTel, userEstato, role FROM users WHERE userID = ?");
            $userQuery->bind_param("i", $userID);
            $userQuery->execute();
            $userQuery->bind_result($userNome, $userEmail, $userCpf, $userTel, $userEstato, $role);
            $userQuery->fetch();
            $userQuery->close();

            $userData = [
                'userNome' => $userNome,
                'userEmail' => $userEmail,
                'userCpf' => $userCpf,
                'userTel' => $userTel,
                'userEstato' => $userEstato,
                'role' => $role
            ];
        } else {
            $errorMessage = 'Código incorreto ou expirado.';
        }
    } elseif ($actionType === 'saveChanges') {
        $userID = $_POST['userID'];
        $userNome = $_POST['userNome'];
        $userEmail = $_POST['userEmail'];
        $userCpf = $_POST['userCpf'] ?? null;
        $userTel = $_POST['userTel'] ?? null;
        $userEstato = $_POST['userEstato'];
        $role = $_POST['role'];

        // Verificar e atualizar apenas os campos que mudaram
        $userQuery = $conn->prepare("SELECT userNome, userEmail, userCpf, userTel, userEstato, role FROM users WHERE userID = ?");
        $userQuery->bind_param("i", $userID);
        $userQuery->execute();
        $userQuery->bind_result($oldNome, $oldEmail, $oldCpf, $oldTel, $oldEstato, $oldRole);
        $userQuery->fetch();
        $userQuery->close();

        if ($userNome === $oldNome && $userEmail === $oldEmail && $userCpf === $oldCpf && $userTel === $oldTel && $userEstato === $oldEstato && $role === $oldRole) {
            $errorMessage = 'Nenhuma mudança foi feita.';
        } else {
            // Verificar se o e-mail já está em uso por outro usuário
            $emailCheckQuery = $conn->prepare("SELECT userID FROM users WHERE userEmail = ? AND userID != ?");
            $emailCheckQuery->bind_param("si", $userEmail, $userID);
            $emailCheckQuery->execute();
            $emailCheckQuery->bind_result($existingUserID);
            $emailCheckQuery->fetch();
            $emailCheckQuery->close();

            if ($existingUserID) {
                // O e-mail já está em uso por outro usuário
                $errorMessage = 'Este e-mail já está em uso por outro usuário.';
                logAction($conn, $userID, ' Falha Atualização de Usuario', 'Tentou cadastrar com um email ja existente: ' . $userEmail . ' pelo admin: ' . $adminNome . ' (ID: ' . $admID . ')');
            } else {
                // Continue com a atualização se o e-mail não estiver em uso
                $updateQuery = $conn->prepare("UPDATE users SET userNome = ?, userEmail = ?, userCpf = ?, userTel = ?, userEstato = ?, role = ? WHERE userID = ?");
                $updateQuery->bind_param("ssssssi", $userNome, $userEmail, $userCpf, $userTel, $userEstato, $role, $userID);
                $updateQuery->execute();

                if ($updateQuery->affected_rows > 0) {
                    logAction($conn, $userID, 'Atualização de Usuario', 'Informações Atualizadas: ' . $userNome . ' pelo admin: ' . $adminNome . ' (ID: ' . $admID . ')');
                    $successMessage = 'Informações atualizadas com sucesso.';
                } else {
                    $errorMessage = 'Falha ao atualizar as informações.';
                }

                $updateQuery->close();
            }
        }
    } elseif ($actionType === 'search') {
        $searchTerm = $_POST['searchTerm'];
    }
}

// Função para enviar o código por e-mail
function sendCodigoEmail($toEmail, $codigo) {
    $mail = new PHPMailer(true);
    try {
        // Configurações do servidor SMTP
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'ab5297e24d2261';
        $mail->Password = 'ce8f33fcb0479d';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        // Configurações do e-mail
        $mail->setFrom('matheusridrigues2@gmail.com', 'Segurança');
        $mail->addAddress($toEmail);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Código de Atualização';
        $mail->Body    = "Seu código de atualização é <strong>$codigo</strong>.";
        $mail->AltBody = "Seu código de atualização é $codigo.";

        $mail->send();
        return '';
    } catch (Exception $e) {
        return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}

// Buscar todos os usuários com base no termo de pesquisa
if ($searchTerm) {
    $searchQuery = $conn->prepare("SELECT * FROM users WHERE userID LIKE ? OR userNome LIKE ? OR userEmail LIKE ? OR userCpf LIKE ? OR userTel LIKE ? OR userEstato LIKE ? OR role LIKE ?");
    $likeTerm = "%$searchTerm%";
    $searchQuery->bind_param("sssssss", $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm);
    $searchQuery->execute();
    $result = $searchQuery->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $searchQuery->close();

    // Limpar o termo de pesquisa após o processamento
    $searchTerm = '';
    
} else {
    $result = $conn->query("SELECT * FROM users");
    $users = $result->fetch_all(MYSQLI_ASSOC);
}
?>