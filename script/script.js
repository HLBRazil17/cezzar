// script.js

document.getElementById('userCpf').addEventListener('input', function (e) {
    let cpf = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito

    if (cpf.length > 11) {
        cpf = cpf.substring(0, 11); // Limita o tamanho máximo a 11 dígitos
    }

    // Formatação do CPF, começando apenas após o 6º dígito
    if (cpf.length > 6) {
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2'); // Insere o primeiro ponto
        cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2'); // Insere o segundo ponto
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Insere o traço antes dos dois últimos dígitos
    }

    e.target.value = cpf; // Atualiza o valor do input
});

document.getElementById('userTel').addEventListener('input', function (e) {
    let tel = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
    if (tel.length > 11) {
        tel = tel.substring(0, 11); // Limita o tamanho a 11 dígitos para telefones com 9 dígitos
    }

    // Formatação do telefone
    tel = tel.replace(/^(\d{2})(\d)/g, '($1) $2'); // Adiciona parênteses ao redor do DDD
    tel = tel.replace(/(\d{4})(\d)/, '$1-$2'); // Adiciona um traço após os quatro primeiros dígitos

    e.target.value = tel; // Atualiza o valor do input
});

//função de suavizar o scrool
function smoothScrollTo(target, duration) {
    const start = window.pageYOffset;
    const end = target.getBoundingClientRect().top + window.pageYOffset;
    const distance = end - start;
    let startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        const timeElapsed = currentTime - startTime;
        const progress = Math.min(timeElapsed / duration, 1);
        const easing = easeInOutQuad(progress);
        window.scrollTo(0, start + distance * easing);

        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    }

    function easeInOutQuad(t) {
        return t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;
    }

    requestAnimationFrame(animation);
}

// Exemplo de uso: Rolar suavemente para um elemento com ID "section1" em 1500ms
document.querySelector('a[href="#section1"]').addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    smoothScrollTo(target, 1500);
});


//script store_password
function toggleForm() {
    var formContainer = document.getElementById('formContainer');
    if (formContainer.style.display === 'none' || formContainer.style.display === '') {
        formContainer.style.display = 'block';
    } else {
        formContainer.style.display = 'none';
    }
}

function cancelForm() {
    var formContainer = document.getElementById('formContainer');
    formContainer.style.display = 'none';
}

function editPassword(id, siteName, url, loginName, email, password) {
    var formContainer = document.getElementById('formContainer');
    formContainer.style.display = 'block';

    document.getElementById('actionType').value = 'update';
    document.getElementById('passwordId').value = id;
    document.getElementById('siteName').value = siteName;
    document.getElementById('url').value = url;
    document.getElementById('loginName').value = loginName;
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}

function showPassword(element, password) {
    element.textContent = password;
    element.style.textDecoration = 'none';
    element.style.cursor = 'default';
    var cell = element.parentElement;
    cell.innerHTML = password;
    setTimeout(function () {
        cell.innerHTML = '<span class="toggle-password" onclick="showPassword(this, \'' + password + '\')">Mostrar</span>';
    }, 3000);
}
