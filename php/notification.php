<?php 

// Incluir a configuração do Mercado Pago, autoload e funções
session_start(); // Inicia a sessão para acessar os dados do usuário logado
$config = require_once 'config.php';
require_once '../vendor/autoload.php';
require_once("./conectar.php");

use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

// Configurar o token de acesso
MercadoPagoConfig::setAccessToken($config['accesstoken']);
$client = new PaymentClient();

// Definir um valor padrão para $userID caso não haja um usuário logado
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : 1; // Assumir 1 como ID do administrador

// Receber os dados da notificação enviada pelo Mercado Pago
$body = json_decode(file_get_contents('php://input'));

// Verificar se o ID do pagamento foi enviado
if (isset($body->data->id)) {

    $paymentId = $body->data->id; // ID do pagamento enviado pela notificação

    try {
        // Consultar o pagamento pelo ID
        $payment = $client->get($paymentId);

        // Capturar status e referência externa do pagamento
        $status = $payment->status;
        $external_reference = $payment->external_reference;

        // Processar de acordo com o status do pagamento
        switch ($status) {
            case 'approved':
                // Pagamento aprovado - Registrar log no banco de dados
                logAction($conn, $userID, 'Pagamento', "Pagamento aprovado: ID $paymentId, Referência $external_reference");
                break;

            case 'pending':
                // Pagamento pendente - Registrar log no banco de dados
                logAction($conn, $userID, 'Pagamento', "Pagamento pendente: ID $paymentId, Referência $external_reference");
                break;

            case 'rejected':
                // Pagamento rejeitado - Registrar log no banco de dados
                logAction($conn, $userID, 'Pagamento', "Pagamento rejeitado: ID $paymentId, Referência $external_reference");
                break;

            default:
                // Outros status de pagamento (ex: in_process, cancelled) - Registrar log no banco de dados
                logAction($conn, $userID, 'Pagamento', "Outro status: ID $paymentId, Status: $status, Referência $external_reference");
                break;
        }

        // Opcional: Exibir os dados do pagamento para depuração
        echo '<pre>';
        var_dump($payment);

    } catch (MPApiException $e) {
        // Registrar erro de API no banco de dados
        logAction($conn, $userID, 'Erro', "Erro ao consultar pagamento: " . $e->getMessage());
        echo 'Erro: ' . htmlspecialchars($e->getMessage());
        exit;
    }

} else {
    // Notificação inválida ou sem ID - Registrar log no banco de dados
    logAction($conn, $userID, 'Erro', "Notificação inválida: " . json_encode($body));
}

http_response_code(200); // Retorna 200 OK para o Mercado Pago

function logAction($conn, $userID, $actionType, $description) {
    $userIp = getUserIP(); // Captura o IP do usuário
    $sql = "INSERT INTO gerenciadorsenhas.logs (user_id, action_type, description, ip_address, created_at) VALUES (?, ?, ?, ?, NOW())";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isss", $userID, $actionType, $description, $userIp);
        $stmt->execute();
        if ($stmt->error) {
            error_log("Erro ao inserir log: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Erro ao preparar a declaração SQL: " . $conn->error);
    }
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Pode haver vários IPs aqui
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]); // Retorna o primeiro IP da lista
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
        // Verifica se é o localhost e altera se necessário
        return ($ip === '::1' || $ip === '127.0.0.1') ? 'Localhost' : $ip;
    }
}