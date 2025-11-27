/**
 * Webtrees Svajana Theme JS
 * Handles Sticky Header & Mobile Drawer
 * Compatible with webtrees core JavaScript (does not interfere with theme switching, etc.)
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
                // Toggle logo visibility when sticky
                var standardLogos = document.querySelectorAll('.standard-logo');
                var stickyLogos = document.querySelectorAll('.sticky-logo');
                standardLogos.forEach(function(logo) { logo.style.display = 'none'; });
                stickyLogos.forEach(function(logo) { logo.style.display = ''; });
            } else {
                header.classList.remove('is-sticky');
                header.classList.remove('is-hidden'); // Always show at top
                // Show standard logo when not sticky
                var standardLogos = document.querySelectorAll('.standard-logo');
                var stickyLogos = document.querySelectorAll('.sticky-logo');
                standardLogos.forEach(function(logo) { logo.style.display = ''; });
                stickyLogos.forEach(function(logo) { logo.style.display = 'none'; });
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

    // Desktop Dropdown Toggles (for navigation submenus if needed)
    var desktopDropdownToggles = document.querySelectorAll('.primary-navigation .dropdown-nav-toggle');
    desktopDropdownToggles.forEach(function (toggle) {
        var parentLi = toggle.closest('li');
        if (!parentLi) return;
        
        // Hover behavior for desktop
        parentLi.addEventListener('mouseenter', function() {
            var submenu = this.querySelector('.sub-menu');
            if (submenu) {
                submenu.style.display = 'block';
            }
        });
        
        parentLi.addEventListener('mouseleave', function() {
            var submenu = this.querySelector('.sub-menu');
            if (submenu) {
                submenu.style.display = 'none';
            }
        });
    });
});