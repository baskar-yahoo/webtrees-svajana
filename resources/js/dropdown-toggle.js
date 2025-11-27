/**
 * Unified Dropdown Toggle Script for Svajana Theme
 * Handles both webtrees dropdowns (.wt-page-menu) and WordPress menu dropdowns (.menu-item-has-children)
 */

(function() {
    'use strict';

    /**
     * Toggle dropdown visibility
     */
    function toggleDropdown(toggle, menu) {
        const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
        
        // Close all other open dropdowns first
        closeAllDropdowns();
        
        if (!isExpanded) {
            // Open this dropdown
            menu.classList.add('show');
            toggle.setAttribute('aria-expanded', 'true');
        }
    }

    /**
     * Close all open dropdowns
     */
    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
            menu.classList.remove('show');
            const toggle = menu.previousElementSibling;
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /**
     * Initialize dropdown handlers
     */
    function initDropdowns() {
        // Handle webtrees dropdowns with data-dropdown-toggle attribute
        document.querySelectorAll('[data-dropdown-toggle]').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const menu = toggle.nextElementSibling;
                if (menu && menu.classList.contains('dropdown-menu')) {
                    toggleDropdown(toggle, menu);
                }
            });
        });

        // Handle WordPress menu dropdowns (.menu-item-has-children)
        document.querySelectorAll('.menu-item-has-children > a').forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                const parent = toggle.parentElement;
                const submenu = parent.querySelector('.sub-menu');
                
                if (submenu) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle submenu visibility
                    const isOpen = submenu.style.display === 'block';
                    
                    // Close all submenus first
                    document.querySelectorAll('.sub-menu').forEach(function(sm) {
                        sm.style.display = 'none';
                    });
                    
                    if (!isOpen) {
                        submenu.style.display = 'block';
                    }
                }
            });
        });
    }

    /**
     * Close dropdowns when clicking outside
     */
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown') && !e.target.closest('.menu-item-has-children')) {
            closeAllDropdowns();
            
            // Close WordPress submenus
            document.querySelectorAll('.sub-menu').forEach(function(submenu) {
                submenu.style.display = 'none';
            });
        }
    });

    /**
     * Close dropdowns on Escape key
     */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            
            // Close WordPress submenus
            document.querySelectorAll('.sub-menu').forEach(function(submenu) {
                submenu.style.display = 'none';
            });
        }
    });

    /**
     * Initialize on DOM ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDropdowns);
    } else {
        initDropdowns();
    }

    /**
     * Re-initialize after AJAX page loads (for webtrees dynamic content)
     */
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length > 0) {
                    initDropdowns();
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
})();
