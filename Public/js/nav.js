const burger = document.querySelector('.navbar__burger');
const menu = document.querySelector('.navbar__menu');
const icon = burger.querySelector('.navbar__burger .burger');

function closeMenu() {
    menu.classList.remove('navbar__menu--open');
    burger.setAttribute('aria-expanded', false);
    burger.setAttribute('aria-label', 'Ouvrir le menu de navigation');
    icon.classList.replace('fa-xmark', 'fa-bars');
}

burger.addEventListener('click', () => {
    const isOpen = menu.classList.toggle('navbar__menu--open');
    burger.setAttribute('aria-expanded', isOpen);
    burger.setAttribute('aria-label', isOpen ? 'Fermer le menu de navigation' : 'Ouvrir le menu de navigation');
    icon.classList.toggle('fa-bars', !isOpen);
    icon.classList.toggle('fa-xmark', isOpen);
});

document.querySelectorAll('.navbar__link').forEach(link => {
    link.addEventListener('click', closeMenu);
});

document.addEventListener('click', (e) => {
    if (!e.target.closest('.navbar')) closeMenu();
});