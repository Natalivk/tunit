document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.header__hamburger');

    const menu = document.querySelector('.header__main-nav');

    if (hamburger && menu) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            menu.classList.toggle('open');
        });
    }
});