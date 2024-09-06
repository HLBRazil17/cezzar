<?php 

// Suprimir avisos de depreciação
 error_reporting(E_ALL & ~E_DEPRECATED);

$config = require_once 'config.php';
require_once 'vendor/autoload.php';

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

// Step 2: Set production or sandbox access token
MercadoPagoConfig::setAccessToken($config['accesstoken']);

$client = new PreferenceClient();

try {
    $preference = $client->create([
        "external_reference" => "teste",
        "notification_url" => "https://google.com",
        "items"=> array(
          array(
            "id" => "4567",
            "title" => "Pro",
            "description" => "Armazenamento ilimitado de senhas, acesso em múltiplos dispositivos, autenticação multifator, suporte prioritário e relatórios de segurança.",
            "picture_url" => "http://www.myapp.com/myimage.jpg",
            "category_id" => "eletronico",
            "quantity" => 1,
            "currency_id" => "BRL",
            "unit_price" => 1
          )
        ),
        "default_payment_method_id" => "master",
        "excluded_payment_types" => array(
          array(
            "id" => "ticket"
          )
        ),
        "installments"  => 12,
        "default_installments" => 1
      ]);

    // Capture the URL from the response
    $paymentUrl = $preference->init_point;

} catch (MPApiException $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}
?>


