function handleMenuMobile() {
    const menuButton = document.querySelector('.menu-button');
    const menuMobile = document.querySelector('.menu-mobile');
    const open = menuButton.querySelector('.open');
    const close = menuButton.querySelector('.close');

    menuButton.addEventListener('click', () => {
        console.log('ok');

        if (menuButton.classList.contains('is-open')) {
            open.style.display = 'block';
            close.style.display = 'none';
            menuButton.classList.remove('is-open');
            closeMenu();
        } else {
            menuButton.classList.add('is-open');
            open.style.display = 'none';
            close.style.display = 'block';
            openMenu();
        }

    })



    function openMenu() {
        menuMobile.classList.add('active');
    }

    function closeMenu() {
        menuMobile.classList.remove('active');
    }

}


document.addEventListener('DOMContentLoaded', () => {
    handleMenuMobile();
})
