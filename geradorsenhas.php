<?php
function gerarSenha($tamanho = 256, $letrasMaiusculas = true, $letrasMinusculas = true, $numeros = true, $simbolos = true) {
    $caracteres = '';
    
    if ($letrasMaiusculas) {
        $caracteres .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    
    if ($letrasMinusculas) {
        $caracteres .= 'abcdefghijklmnopqrstuvwxyz';
    }
    
    if ($numeros) {
        $caracteres .= '0123456789';
    }
    
    if ($simbolos) {
        $caracteres .= '!@#$%^&*()-_=+[]{}<>?';
    }
    
    if (empty($caracteres)) {
        return '';
    }

    $senha = '';
    $comprimentoCaracteres = strlen($caracteres);
    
    for ($i = 0; $i < $tamanho; $i++) {
        $senha .= $caracteres[rand(0, $comprimentoCaracteres - 1)];
    }
    
    return $senha;
}

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tamanho = isset($_POST['tamanho']) ? (int)$_POST['tamanho'] : 12;
    $letrasMaiusculas = isset($_POST['letrasMaiusculas']);
    $letrasMinusculas = isset($_POST['letrasMinusculas']);
    $numeros = isset($_POST['numeros']);
    $simbolos = isset($_POST['simbolos']);

    $senhaGerada = gerarSenha($tamanho, $letrasMaiusculas, $letrasMinusculas, $numeros, $simbolos);
} else {
    $senhaGerada = '';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Senhas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            background: #ddd;
            border-radius: 5px;
            outline: none;
            margin-bottom: 20px; /* Espaçamento abaixo do controle deslizante */
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #0080ff;
            cursor: pointer;
        }

        .range-value {
            font-size: 18px;
            margin-bottom: 20px; /* Espaçamento abaixo do valor do controle deslizante */
        }

        label {
            margin-bottom: 10px;
            display: block; /* Exibe cada checkbox em uma nova linha */
        }

        button {
            background-color: #0080ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px; /* Espaçamento entre os botões */
        }

        button:hover {
            background-color: #0056b3;
        }

        .senha-gerada {
            margin-top: 20px;
            font-size: 20px;
            word-wrap: break-word;
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 20px;
            }

            button {
                font-size: 14px;
                padding: 8px 16px;
            }

            .range-value {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerador de Senhas</h1>
        <form method="POST">
            <input type="range" id="tamanhoRange" name="tamanho" min="5" max="256" value="5" oninput="atualizarValor()">
            <div class="range-value" id="tamanhoValor">5</div>

            <label>
                <input type="checkbox" name="letrasMaiusculas" checked>
                Incluir letras maiúsculas
            </label>
            <label>
                <input type="checkbox" name="letrasMinusculas" checked>
                Incluir letras minúsculas
            </label>
            <label>
                <input type="checkbox" name="numeros" checked>
                Incluir números
            </label>
            <label>
                <input type="checkbox" name="simbolos" checked>
                Incluir símbolos
            </label>

            <button type="submit">Gerar Senha</button>
        </form>

        <?php if ($senhaGerada): ?>
            <div class="senha-gerada">
                <h2>Senha Gerada:</h2>
                <p><strong id="senhaGeradaTexto"><?php echo htmlspecialchars($senhaGerada); ?></strong></p>
                <button onclick="copiarSenha()">Copiar Senha</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function atualizarValor() {
            var range = document.getElementById("tamanhoRange");
            var valor = document.getElementById("tamanhoValor");
            valor.textContent = range.value;
        }

        function copiarSenha() {
            var senha = document.getElementById("senhaGeradaTexto").textContent;
            navigator.clipboard.writeText(senha).then(function() {
                alert("Senha copiada: " + senha);
            }, function(err) {
                console.error("Erro ao copiar a senha: ", err);
            });
        }
    </script>
</body>
</html>
