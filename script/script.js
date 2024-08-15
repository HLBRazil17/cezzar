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
