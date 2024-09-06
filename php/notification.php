<?php 

    $config = require_once 'config.php';
    require_once 'vendor/autoload.php';

    use MercadoPago\Client\Payment\PaymentClient;
    use MercadoPago\MercadoPagoConfig;

    MercadoPagoConfig::setAccessToken($config['accesstoken']);
    $client = new PaymentClient();

    $body   = json_decode(file_get_contents('php://input'));
        
    if(isset($body->data->id)){

        $id = $body->data->id;
        
        $client  = new PaymentClient();
        $payment = $client->get($id);

        $status             = $payment->status;
        $external_reference = $payment->external_reference;
        
        echo '<pre>';
        var_dump($payment);
    
    }