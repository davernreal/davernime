import './bootstrap';

const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const overlay = document.getElementById('overlay');

if(menuToggle){
    menuToggle.addEventListener('change', function () {
        if (this.checked) {
            mobileMenu.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            mobileMenu.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    });
}

if (overlay) {
    overlay.addEventListener('click', function () {
        menuToggle.checked = false;
        mobileMenu.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
}