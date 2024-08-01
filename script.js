// script.js
document.getElementById('hamburger').addEventListener('click', function() {
    var menu = document.getElementById('navbarMenu');
    if (menu.style.right == '0px') {
        menu.style.right = '-100%';
    } else {
        menu.style.right = '0px';
    }
});

document.addEventListener('click', function(e) {
    var menu = document.getElementById('navbarMenu');
    var hamburger = document.getElementById('hamburger');
    // Verifica se o clique não foi no hamburger e nem no menu aberto
    if (!hamburger.contains(e.target) && !menu.contains(e.target) && menu.style.right == '0px') {
        menu.style.right = '-100%'; // Fecha o menu
    }
});