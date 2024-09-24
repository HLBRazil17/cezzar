<?php
require("./php/planos.php")
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Planos e Preços para nossos serviços">
    <meta name="author" content="">
    <title>Planos e Preços</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .header h1 {
            margin: 0;
        }

        .pricing {
            text-align: center;
            padding: 50px 20px;
        }

        .pricing h2 {
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #333;
        }

        .pricing-list {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .pricing-item {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .pricing-item:hover {
            transform: translateY(-10px);
        }

        .pricing-item h3 {
            margin: 0 0 10px;
            font-size: 2em;
            color: #333;
        }

        .pricing-item p {
            font-size: 1.2em;
            color: #666;
            margin: 0 0 20px;
        }

        .pricing-item ul {
            list-style: none;
            padding: 0;
            margin: 0 0 20px;
            text-align: left;
        }

        .pricing-item ul li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .pricing-item ul li:last-child {
            border-bottom: none;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        </style>
</head>

<body>
    <header class="header">
        <h1>Planos e Preços</h1>
    </header>

    <section class="pricing" id="planos">
        <h2>Planos e Preços</h2>
        <?php echo htmlspecialchars($userPlan); ?>
        <div class="pricing-list">
            <!-- Plano Básico -->
            <div class="pricing-item">
                <h3>Básico</h3>
                <p>Grátis para sempre</p>
                <ul>
                    <li>Armazenamento limitado de senhas</li>
                    <li>Acesso em um dispositivo</li>
                    <li>Suporte básico</li>
                </ul>
                <?php if ($userPlan === 'básico') : ?>
                    <span class="btn">Você já possui um plano</span>
                <?php else : ?>
                    <a href="" class="btn">Escolher Plano</a>
                <?php endif; ?>
            </div>

            <!-- Plano Pro -->
            <div class="pricing-item">
                <h3>Pro</h3>
                <p>$14.99/mês</p>
                <ul>
                    <li>Armazenamento ilimitado de senhas</li>
                    <li>Acesso em múltiplos dispositivos</li>
                    <li>Autenticação multifator</li>
                    <li>Suporte prioritário</li>
                    <li>Relatórios de segurança</li>
                </ul>
                <?php if ($userPlan === 'pro') : ?>
                    <span class="btn">Você já possui este plano</span>
                <?php else : ?>
                     <a href="<?php echo htmlspecialchars($paymentUrlPro); ?>" class="btn btn-primary" target="_blank">Escolher Plano Pro</a>
                <?php endif; ?>
            </div>

            <!-- Plano Premium -->
            <div class="pricing-item">
                <h3>Premium</h3>
                <p>$24.99/mês</p>
                <ul>
                    <li>Armazenamento ilimitado de senhas</li>
                    <li>Acesso em múltiplos dispositivos</li>
                    <li>Autenticação multifator</li>
                    <li>Suporte premium 24/7</li>
                    <li>Relatórios avançados</li>
                    <li>Backup e recuperação de dados</li>
                </ul>
                <?php if ($userPlan === 'premium') : ?>
                    <span class="btn">Você já possui este plano</span>
                <?php else : ?>
                    <a href="<?php echo htmlspecialchars($paymentUrlPremium); ?>" class="btn btn-primary" target="_blank">Escolher Plano Premium</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>