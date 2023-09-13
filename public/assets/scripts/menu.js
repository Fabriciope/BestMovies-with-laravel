const menuButton = document.getElementById('menu_button');
menuButton.onclick = function () {
    const menu = document.getElementById('menu');
    menu.classList.toggle('hidden');
    menu.classList.toggle('block');
}