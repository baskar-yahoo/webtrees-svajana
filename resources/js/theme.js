/**
 * Webtrees Svajana Theme JS
 * Handles Sticky Header & Mobile Drawer
 */

document.addEventListener('DOMContentLoaded', function () {

    // 1. Sticky Header Logic
    var header = document.getElementById('masthead');
    var lastScrollTop = 0;

    if (header) {
        window.addEventListener('scroll', function () {
            var currentScroll = window.scrollY || document.documentElement.scrollTop;

            if (currentScroll > 50) {
                header.classList.add('is-sticky');
            } else {
                header.classList.remove('is-sticky');
            }
        }, { passive: true });
    }

    // 2. Mobile Drawer Logic
    var toggleBtn = document.querySelector('.mobile-menu-toggle');
    var drawer = document.getElementById('mobile-drawer');
    var closeBtn = document.querySelector('.drawer-close');
    var backdrop = document.querySelector('.mobile-drawer-backdrop');

    function toggleDrawer() {
        if (!drawer) return;
        drawer.classList.toggle('is-open');
        document.body.style.overflow = drawer.classList.contains('is-open') ? 'hidden' : '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', toggleDrawer);
    if (closeBtn) closeBtn.addEventListener('click', toggleDrawer);
    if (backdrop) backdrop.addEventListener('click', toggleDrawer);

    // Mobile Dropdown Toggles (Accordion)
    var dropdownToggles = document.querySelectorAll('.mobile-drawer-content .dropdown-nav-toggle');
    dropdownToggles.forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var parentLi = this.closest('li');
            parentLi.classList.toggle('is-open');
        });
    });
});