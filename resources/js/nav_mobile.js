document.addEventListener('DOMContentLoaded', function () {
    setupMenu();
});

function setupMenu() {
    const menuButton = document.querySelector('.menu-button');
    const menuList = document.getElementById('menuList');
    const body = document.body; 

    if (!menuButton || !menuList) return;

    menuButton.addEventListener('click', function (event) {
        event.stopPropagation();
        menuList.classList.toggle('hidden');
        body.classList.toggle('overflow-hidden', !menuList.classList.contains('hidden')); 
    });

    // Fechar o menu ao clicar fora dele
    document.addEventListener('click', function (event) {
        if (!menuButton.contains(event.target) && !menuList.contains(event.target) && !menuList.classList.contains('hidden')) {
            menuList.classList.add('hidden');
            body.classList.remove('overflow-hidden'); 
        }
    });

    // Fechar o menu e permitir a rolagem ao redimensionar a janela
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            menuList.classList.add('hidden');
            body.classList.remove('overflow-hidden'); 
        }
    });
}
