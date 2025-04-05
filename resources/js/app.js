import './bootstrap';

function getIsDarkMode() {
    return localStorage.getItem('isDarkMode') === 'true';
}

function setIsDarkMode(status) {
    localStorage.setItem('isDarkMode', status);
}

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

document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.querySelector('.theme-controller');

    if (getIsDarkMode()) {
        document.documentElement.setAttribute('data-theme', 'dark');
        themeToggle.checked = true;
        
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        themeToggle.checked = false;
    }

    themeToggle.addEventListener('change', function () {
        if (this.checked) {
            document.documentElement.setAttribute('data-theme', 'dark');
            setIsDarkMode(true);
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            setIsDarkMode(false);
        }
    });
});