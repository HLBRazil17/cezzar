<?php
session_start();
require("php/conectar.php");
require("php/functions.php");
require("php/preference.php");

// Verifica se o usuário está logado
if (isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID']; // Obtém o ID do usuário da sessão
    $userPlan = getUserPlan($userId, $conn); // Obtém o plano do usuário
} else {
    $userPlan = 'Não logado'; // Valor padrão se o usuário não estiver logado
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--import favicon-->
    <link rel="icon" href="./img/ICON-prokey.ico">

    <!--import googleFonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!--import font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--import css/scroll-->
    <link rel="stylesheet" href="./style/styles.css">

    <title>Protect Key</title>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="navbar-container">
                <div class="navbar-left">

                    <div class="logo-container">
                        <a href="index.php"><img src="./img/ProtectKey-LOGOW.png" alt="Protect Key Logo"
                                class="logo"></a>
                        <a href="index.php"><img src="./img/ProtectKey-LOGOB.png" alt="Protect Key Logo Hover"
                                class="logo-hover"></a>
                    </div>

                    <button class="hamburger" id="hamburger">&#9776;</button>
                    <div class="navbar-menu" id="navbarMenu">
                        <a href="store_password.php" class="navbar-item">Senhas</a>
                        <a href="planos.php" class="navbar-item">Planos</a>
                        <!--<a href="#" class="navbar-item">Sobre</a>   -->
                        <a href="envia_contato.php" class="navbar-item">Contate-nos</a>

                        <?php if (isset($_SESSION['userNome'])): ?>
                            <?php if (checkAdminRole($conn, $userId)) { ?>
                                <a href="gerenciador.php" class="navbar-item">Gerenciador</a>
                                <a href="logs.php" class="navbar-item">Logs</a>
                            <?php } ?>

                        <?php endif; ?>


                    </div>
                </div>

                <!--PROFILE ICON-->
                <div class="navbar-right">
                    <details class="dropdown">
                        <summary class="profile-icon">
                            <img src="./img/user.png" alt="Profile">
                        </summary>
                        <div class="dropdown-content">
                            <?php if (isset($_SESSION['userNome'])): ?>
                                <?php
                                // Utiliza strtok para obter a primeira parte antes do espaço
                                $primeiroNome = strtok($_SESSION['userNome'], ' ');
                                ?>
                                <p>Bem-vindo, <?php echo $primeiroNome; ?></p>
                                <a href="account.php"> Detalhes da Conta</a>
                                <a href="logout-back.php" style="border-radius: 15px;">Sair da Conta</a>
                            <?php else: ?>
                                <p>Bem-vindo!</p>
                                <a href="register.php">Registrar</a>
                                <a href="login.php" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">Login</a>
                            <?php endif; ?>
                        </div>
                    </details>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <section class="hero">
            <div class="content">
                <img src="./img/background01.png" alt="Imagem do Protect Key">

                <div class="text">
                    <h1>Seu Gerenciador de Senhas Confiável <svg xmlns="http://www.w3.org/2000/svg" width="65"
                            height="auto" viewBox="0 0 45 45">
                            <polygon fill="#42a5f5"
                                points="29.62,3 33.053,8.308 39.367,8.624 39.686,14.937 44.997,18.367 42.116,23.995 45,29.62 39.692,33.053 39.376,39.367 33.063,39.686 29.633,44.997 24.005,42.116 18.38,45 14.947,39.692 8.633,39.376 8.314,33.063 3.003,29.633 5.884,24.005 3,18.38 8.308,14.947 8.624,8.633 14.937,8.314 18.367,3.003 23.995,5.884">
                            </polygon>
                            <polygon fill="#fff"
                                points="21.396,31.255 14.899,24.76 17.021,22.639 21.428,27.046 30.996,17.772 33.084,19.926">
                            </polygon>
                        </svg>
                    </h1>
                    <p>Mantenha suas senhas seguras e acessíveis com o Protect Key. Armazene, gerencie e compartilhe
                        suas senhas de maneira segura, onde quer que esteja.</p>
                    <div class="hero-buttons">
                        <?php if (isset($_SESSION['userNome'])): ?>
                            <a href="store_password.php" class="btn btn-primary">Salvar Senha</a>
                            <a class="btn btn-secondary" data-scroll="planos">Ver planos e preços</a>
                        <?php else: ?>
                            <a href="register.php" class="btn btn-primary">Iniciar um teste gratuito</a>
                            <a class="btn btn-secondary" data-scroll="planos">Ver planos e preços</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>



        <!-- Seção de Recursos -->
        <section class="features second-section">

            <h2>Recursos Principais</h2>

            <!-- Div para o fundo azul com cantos arredondados -->
            <div class="features blue-background">
                <!-- Título da seção "Recursos Principais" -->

                <!-- Lista de funcionalidades principais -->
                <div class="feature-list">
                    <!-- Item de funcionalidade individual -->
                    <div class="feature-item">
                        <h3>Segurança de Nível Militar</h3>
                        <img src="./img/seguranca-icon.png" alt="Icone de Segurança">
                        <p>Proteja suas senhas com criptografia avançada e autenticação multifator.</p>
                        <ul>
                            <li>Criptografia AES-256</li>
                            <li>Autenticação multifator (MFA)</li>
                            <li>Proteção contra ataques de força bruta</li>
                        </ul>
                        <p>Com a segurança de nível militar, você pode ter certeza de que suas senhas estão protegidas
                            contra qualquer ameaça.</p>
                    </div>
                </div>

                <!-- Item de funcionalidade individual -->
                <div class="feature-item">
                    <h3>Acesso em Qualquer Lugar</h3>
                    <img src="./img/acesso-icon.png" alt="">
                    <p>Acesse suas senhas de qualquer dispositivo, a qualquer momento.</p>
                    <ul>
                        <li>Compatível com dispositivos móveis</li>
                        <li>Acesso offline</li>
                        <li>Sincronização em tempo real</li>
                    </ul>
                    <p>Não importa onde você esteja, você terá acesso às suas senhas sempre que precisar, com ou sem
                        conexão à internet.</p>
                </div>

                <!-- Item de funcionalidade individual -->
                <div class="feature-item">
                    <h3>Compartilhamento Seguro</h3>
                    <img src="./img/compartilhamento-icon.png" alt="">
                    <p>Compartilhe suas senhas com segurança com amigos e familiares.</p>
                    <ul>
                        <li>Compartilhamento criptografado</li>
                        <li>Controle de permissões</li>
                        <li>Revogação de acesso a qualquer momento</li>
                    </ul>
                    <p>Compartilhar senhas nunca foi tão seguro. Você pode controlar quem tem acesso e por quanto tempo.
                    </p>
                </div>
            </div>
        </section>


        <!-- Seção de Testemunhos -->
        <section class="testimonials">
            <h2>O que nossos usuários dizem</h2>
            <div class="testimonial-list">
                <div class="testimonial-item">
                    <p>"O Protect Key facilitou minha vida. Agora posso gerenciar todas as minhas senhas em um só
                        lugar."</p>
                    <h4>Maria Silva</h4>
                </div>
                <div class="testimonial-item">
                    <p>"Muito seguro e fácil de usar. Recomendo a todos."</p>
                    <h4>João Pereira</h4>
                </div>
            </div>
        </section>

        <!-- Seção de Planos e Preços -->
        <section class="pricing" id="planos">
            <h2>Planos e Preços</h2>
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
                    <?php if ($userPlan === 'básico'): ?>
                        <span class="btn">Você já possui um plano</span>
                    <?php else: ?>
                        <a href="" class="btn">Escolher Plano </a>
                    <?php endif; ?>
                </div>


                <!-- Plano Pro -->
                <div class="pricing-item">
                    <h3>Pro</h3>
                    <p>R$14.99/mês</p>
                    <ul>
                        <li>Armazenamento ilimitado de senhas</li>
                        <li>Acesso em múltiplos dispositivos</li>
                        <li>Autenticação multifator</li>
                        <li>Suporte prioritário</li>
                        <li>Relatórios de segurança</li>
                    </ul>
                    <?php if ($userPlan === 'pro'): ?>
                        <span class="btn">Você já possui este plano</span>
                    <?php else: ?>
                        <a href="<?php echo htmlspecialchars($paymentUrlPro); ?>" class="btn btn-primary"
                            target="_blank">Escolher Plano </a>
                    <?php endif; ?>
                </div>

                <!-- Plano Premium -->
                <div class="pricing-item">
                    <h3>Premium</h3>
                    <p>R$24.99/mês</p>
                    <ul>
                        <li>Armazenamento ilimitado de senhas</li>
                        <li>Acesso em múltiplos dispositivos</li>
                        <li>Autenticação multifator</li>
                        <li>Suporte premium 24/7</li>
                        <li>Relatórios avançados</li>
                        <li>Backup e recuperação de dados</li>
                    </ul>
                    <?php if ($userPlan === 'premium'): ?>
                        <span class="btn">Você já possui este plano</span>
                    <?php else: ?>
                        <a href="<?php echo htmlspecialchars($paymentUrlPremium); ?>" class="btn btn-primary"
                            target="_blank">Escolher Plano </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Seção de FAQ -->
        <section class="faq">
            <h2>Perguntas Frequentes</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <h3>Como o Protect Key protege minhas senhas?</h3>
                    <p>Utilizamos criptografia de ponta a ponta para garantir que apenas você tenha acesso às suas
                        senhas.</p>
                </div>
                <div class="faq-item">
                    <h3>Posso compartilhar minhas senhas com outras pessoas?</h3>
                    <p>Sim, você pode compartilhar senhas de forma segura com amigos e familiares.</p>
                </div>
            </div>
        </section>

        <!-- Seção de Contato -->
        <section class="contact">
            <h2>Entre em Contato</h2>
            <p>Tem alguma dúvida? Entre em contato conosco através do e-mail: contato@protectkey.com</p>
        </section>
    </main>


    <!--FOOTER-->
    <footer>
        <div class="content">
            <div class="top">
                <div class="logo-details">
                    <a href="#"><img class="logo-footer" src="./img/ProtectKey-LOGOW.png" alt="logo icon"></a>
                </div>
                <div class="media-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="link-boxes">
                <ul class="box">
                    <li class="link_name">Companhia</li>
                    <li><a href="#">Página Inicial</a></li>
                    <li><a href="#">Entre em Contato</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Começar Agora</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Services</li>
                    <li><a href="#">App design</a></li>
                    <li><a href="#">Web design</a></li>
                    <li><a href="#">Logo design</a></li>
                    <li><a href="#">Banner design</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Account</li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">My account</a></li>
                    <li><a href="#">Prefrences</a></li>
                    <li><a href="#">Purchase</a></li>
                </ul>
                <ul class="box">
                    <li class="link_name">Courses</li>
                    <li><a href="#">HTML & CSS</a></li>
                    <li><a href="#">JavaScript</a></li>
                    <li><a href="#">Photography</a></li>
                    <li><a href="#">Photoshop</a></li>
                </ul>
                <ul class="box input-box-fot">
                    <li class="link_name">Subscribe</li>
                    <li><input type="text" placeholder="Enter your email"></li>
                    <li><input type="button" value="Subscribe"></li>
                </ul>
            </div>
        </div>
        <div class="bottom-details">
            <div class="bottom_text">
                <span class="copyright_text">Copyright © 2021 <a href="#">CodingLab.</a>All rights reserved</span>
                <span class="policy_terms">
                    <a href="#">Privacy policy</a>
                    <a href="#">Terms & condition</a>
                </span>
            </div>
        </div>
    </footer>

    <script>
        document.querySelectorAll('[data-scroll]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('data-scroll');
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    <script src="./script/script.js"></script>

</body>

</html>