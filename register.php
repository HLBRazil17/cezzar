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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!--import font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!--import css/scroll-->
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="styles-loginReg.css">

    <script src="https://unpkg.com/scrollreveal"></script>

    <title>Registro</title>
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
                        <a href="#" class="navbar-item">Produto</a>
                        <a href="#" class="navbar-item">Planos</a>
                        <a href="#" class="navbar-item">Download</a>
                        <a href="#" class="navbar-item">Sobre</a>
                    </div>
                </div>
                <div class="navbar-right">
                    <a class="navbar-action">Planos Empresariais</a>
                    <img src="./img/user.png" alt="Profile" class="profile-icon">
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <section class="hero">
            <div class="wrapper">
                <form action="" method="post">

                    <h1>Registro</h1>

                    <div class="input-box">
                        <input type="text" id="userNome" name="userNome" placeholder="Digite seu nome" required>
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="email" id="userEmail" name="userEmail" placeholder="Digite seu e-mail" required>
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="text" id="userCpf" name="userCpf" placeholder="Digite seu CPF">
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="tel" id="userTel" name="userTel" placeholder="Digite seu telefone">
                        <br><br>
                    </div>

                    <div class="input-box">
                        <input type="password" id="userPassword" name="userPassword" placeholder="Digite sua senha"
                            required>
                        <br><br>
                    </div>

                    <div class="register-link">
                        <p>Já possui uma conta?</p>
                        <a href="login.php">Login</a>
                    </div>

                    <?php
                    if (!empty($errorMessage)) {
                        echo "<p class='message error'>$errorMessage</p>";
                    }
                    if (!empty($successMessage)) {
                        echo "<p class='message success'>$successMessage</p>";
                    }
                    ?>

                    <button type="submit" class="btn">Registrar</button>
                </form>
            </div>
        </section>
    </main>

    <!--FOOTER-->
    <footer>
    <div class="content">
      <div class="top">
        <div class="logo-details">
          <img class="logo-footer" src="./img/logo-icon.png" alt="logo icon">
          <span class="logo_name"><strong>Protect </strong> Key</span>
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
          <li class="link_name">Company</li>
          <li><a href="#">Home</a></li>
          <li><a href="#">Contact us</a></li>
          <li><a href="#">About us</a></li>
          <li><a href="#">Get started</a></li>
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
        <ul class="box input-box">
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

    <script src="script.js"></script>
</body>

</html>