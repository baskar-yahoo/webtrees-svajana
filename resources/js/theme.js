/**
 * Webtrees Svajana Theme JS
 * Handles Sticky Header & Mobile Drawer
 */

document.addEventListener('DOMContentLoaded', function () {

    var header = document.getElementById('masthead');
    var lastScrollTop = 0;
    var delta = 5; // Minimum scroll amount to trigger action

    // 1. Smart Scroll Logic (Hide on down, Show on up)
    if (header) {
        window.addEventListener('scroll', function () {
            var st = window.scrollY || document.documentElement.scrollTop;

            // Make sure they scroll more than delta
            if (Math.abs(lastScrollTop - st) <= delta) return;

            // Directional Logic
            if (st > lastScrollTop && st > 10) {
                // Scroll Down > 100px -> HIDE
                header.classList.add('is-hidden');
            } else {
                // Scroll Up -> SHOW
                header.classList.remove('is-hidden');
            }

            // Sticky Background Color Logic
            if (st > 10) {
                header.classList.add('is-sticky');
            } else {
                header.classList.remove('is-sticky');
                header.classList.remove('is-hidden'); // Always show at top
            }

            lastScrollTop = st;
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