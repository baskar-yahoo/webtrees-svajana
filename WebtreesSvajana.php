<?php

declare(strict_types=1);

namespace Webtrees\Modules\WebtreesSvajana;

use Exception;
use PDO;
use Fisharebest\Webtrees\Auth;
use Fisharebest\Webtrees\I18N;
use Fisharebest\Webtrees\Menu;
use Fisharebest\Webtrees\Tree;
use Fisharebest\Webtrees\View;
use Fisharebest\Webtrees\Session;
use Fisharebest\Webtrees\FlashMessages;
use Psr\Http\Message\ResponseInterface;
use Fisharebest\Localization\Translation;
use Psr\Http\Message\ServerRequestInterface;
use Fisharebest\Webtrees\Module\MinimalTheme;
use Illuminate\Database\Capsule\Manager as DB;
use Fisharebest\Webtrees\Contracts\UserInterface;
use Fisharebest\Webtrees\Module\ModuleThemeTrait;
use Fisharebest\Webtrees\Module\ModuleConfigTrait;
use Fisharebest\Webtrees\Module\ModuleCustomTrait;
use Fisharebest\Webtrees\Module\ModuleFooterTrait;
use Fisharebest\Webtrees\Module\ModuleGlobalTrait;
use Fisharebest\Webtrees\Module\ModuleThemeInterface;
use Fisharebest\Webtrees\Module\ModuleConfigInterface;
use Fisharebest\Webtrees\Module\ModuleCustomInterface;
use Fisharebest\Webtrees\Module\ModuleFooterInterface;
use Fisharebest\Webtrees\Module\ModuleGlobalInterface;

/**
 * Webtrees Svajana Theme
 * 
 * A robust implementation extending MinimalTheme and implementing 
 * the full suite of Module interfaces for maximum capability.
 */
class WebtreesSvajana extends MinimalTheme implements
    ModuleThemeInterface,
    ModuleCustomInterface,
    ModuleFooterInterface,
    ModuleGlobalInterface,
    ModuleConfigInterface
{
    use ModuleThemeTrait;
    use ModuleCustomTrait;
    use ModuleFooterTrait;
    use ModuleGlobalTrait;
    use ModuleConfigTrait;

    // Defined constant to avoid namespace typos and ensure consistency
    public const CUSTOM_NAMESPACE = 'svajana';

    // Cache the detected prefix
    private static string $wp_prefix = '';

    public function title(): string
    {
        return 'Webtrees Svajana';
    }

    public function description(): string
    {
        return 'Seamless integration with WordPress Kadence Child Theme.';
    }

    /**
     * Define the location of the resources folder.
     */
    public function resourcesFolder(): string
    {
        return __DIR__ . '/resources/';
    }

    public function boot(): void
    {
        // Register a namespace for our views using our CONSTANT.
        View::registerNamespace(self::CUSTOM_NAMESPACE, $this->resourcesFolder() . 'views/');

        // 1. Override the Master Layout (The "Frame")
        View::registerCustomView('::layouts/default', self::CUSTOM_NAMESPACE . '::layouts/default');
        
        // 2. Override individual page views for modern table layout
        View::registerCustomView('::individual-page', self::CUSTOM_NAMESPACE . '::individual-page');
        View::registerCustomView('::individual-page-tabs', self::CUSTOM_NAMESPACE . '::individual-page-tabs');
        View::registerCustomView('::individual-page-menu', self::CUSTOM_NAMESPACE . '::individual-page-menu');
        View::registerCustomView('::individual-page-names', self::CUSTOM_NAMESPACE . '::individual-page-names');
        View::registerCustomView('::individual-page-images', self::CUSTOM_NAMESPACE . '::individual-page-images');
        
        // 3. Override fact views for two-row layout (icon+label / edit links)
        View::registerCustomView('::fact', self::CUSTOM_NAMESPACE . '::fact');
        View::registerCustomView('::fact-edit-links', self::CUSTOM_NAMESPACE . '::fact-edit-links');
        
        // 4. Override chart box with orange dashed border
        View::registerCustomView('::chart-box', self::CUSTOM_NAMESPACE . '::chart-box');
        
        // 5. Override webmanifest for svajana branding
        View::registerCustomView('::webmanifest-json', self::CUSTOM_NAMESPACE . '::webmanifest-json');
        
        // 6. Override module views
        View::registerCustomView('::modules/family_nav/sidebar-family', self::CUSTOM_NAMESPACE . '::modules/family_nav/sidebar-family');
        View::registerCustomView('::modules/statistics-chart/page', self::CUSTOM_NAMESPACE . '::modules/statistics-chart/page');
        View::registerCustomView('::modules/random_media/slide-show', self::CUSTOM_NAMESPACE . '::modules/random_media/slide-show');
    }

    /**
     * List of stylesheets to load.
     */
    public function stylesheets(): array
    {
        return [
            $this->assetUrl('css/base.css'),
            $this->assetUrl('css/webtrees-menus.css'),
            $this->assetUrl('css/custom.css'),
            $this->assetUrl('css/modern-components.css'),
            $this->assetUrl('css/modern-enhancements.css'),
            $this->assetUrl('css/customizations/enable-icons.css'),
        ];
    }

    // --- ModuleConfigInterface Methods ---

    public function defaultConfig(): array
    {
        return [
            'palette' => 'default',
        ];
    }

    // --- ModuleCustomInterface Methods (Admin Settings) ---

    public function adminMenuTitle(): string
    {
        return 'Svajana Theme Settings';
    }

    public function getAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        // DEFENSIVE REGISTRATION
        View::registerNamespace(self::CUSTOM_NAMESPACE, $this->resourcesFolder() . 'views/');

        return $this->viewResponse(self::CUSTOM_NAMESPACE . '::layouts/settings', [
            'title' => $this->title(),
            'module' => $this->title(),
        ]);
    }

    public function postAdminAction(ServerRequestInterface $request): ResponseInterface
    {
        $message = I18N::translate('Settings updated.');
        FlashMessages::addMessage($message, 'success');
        return \Fisharebest\Webtrees\responseFactory()->redirect($this->getConfigLink());
    }

    // --- ModuleGlobalInterface Methods ---

    public function headContent(): string
    {
        // Using Local Assets (Requires files in resources/fonts/)
        return '<!-- Font Awesome icons -->
        <style>
        @font-face {
            font-family: "Font Awesome 5 Free";
            src: url("' . $this->assetUrl('fonts/fa-solid-900.eot') . '");
            src: url("' . $this->assetUrl('fonts/fa-solid-900.eot') . '?#iefix") format("embedded-opentype"),
                 url("' . $this->assetUrl('fonts/fa-solid-900.woff2') . '") format("woff2"),
                 url("' . $this->assetUrl('fonts/fa-solid-900.woff') . '") format("woff"),
                 url("' . $this->assetUrl('fonts/fa-solid-900.ttf') . '") format("truetype"),
                 url("' . $this->assetUrl('fonts/fa-solid-900.svg') . '#fontawesome") format("svg");
            font-style: normal;
            font-weight: 900;
            font-display: block;
        }
        .fa, .fas {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
        }
        </style>';
    }

    public function bodyContent(): string
    {
        return '<script src="' . $this->assetUrl('js/dropdown-toggle.js') . '"></script>';
    }

    /**
     * Calculate and cache relationship between two individuals.
     * Cache key includes individual update timestamps for automatic invalidation.
     * 
     * @param Individual $individual1 First individual
     * @param Individual $individual2 Second individual
     * @param Tree $tree Tree context
     * @return string Relationship name
     */
    public function getRelationshipCached($individual1, $individual2, $tree): string
    {
        // Generate cache key with update timestamps for automatic cache busting
        $cache_key = sprintf(
            'relationship_%d_%s_%s_%d_%d',
            $tree->id(),
            $individual1->xref(),
            $individual2->xref(),
            $individual1->updateTs(),
            $individual2->updateTs()
        );

        $relationship_service = new \Fisharebest\Webtrees\Services\RelationshipService();
        
        // Try to get cached relationship
        $cache = \Fisharebest\Webtrees\Registry::cache()->array();
        $cached = $cache->get($cache_key);
        
        if ($cached !== null) {
            return $cached;
        }
        
        // Calculate relationship
        $relationship = $relationship_service->getCloseRelationshipName($individual1, $individual2);
        
        // Cache the result for 1 hour
        $cache->set($cache_key, $relationship, 3600);
        
        return $relationship;
    }

    public function customTranslations(string $language): array
    {
        return [];
    }

    /**
     * Smart Detection of WordPress Table Prefix using native WordPress configuration.
     * Uses wp-load.php with SHORTINIT to get the authoritative table prefix.
     */
    private static function detectWpPrefix(): string
    {
        if (self::$wp_prefix) {
            return self::$wp_prefix;
        }

        // Define SHORTINIT to load minimal WordPress environment
        if (!defined('SHORTINIT')) {
            define('SHORTINIT', true);
        }

        $root = dirname(__DIR__, 2); // Webtrees root

        // Search for wp-load.php in likely parent directories
        $candidates = [
            $root . '/../wp-load.php',      // Standard
            $root . '/../../wp-load.php',   // Common
        ];

        foreach ($candidates as $file) {
            if (file_exists($file)) {
                ob_start();
                require_once $file;
                ob_end_clean();

                global $table_prefix;
                if (isset($table_prefix)) {
                    self::$wp_prefix = $table_prefix;
                    return $table_prefix;
                }
            }
        }

        // Fallback if WP not found
        return 'wpw4_';
    }

    /**
     * Helper to fetch standard WP Options from the shared DB.
     * Uses Raw PDO to bypass Eloquent auto-prefixing.
     */
    public static function getWpHeaderData(): array
    {
        try {
            $pdo = DB::connection()->getPdo();
            $p = self::detectWpPrefix();

            $fetchOption = function ($name) use ($pdo, $p) {
                $stmt = $pdo->prepare("SELECT option_value FROM {$p}options WHERE option_name = :name LIMIT 1");
                $stmt->execute(['name' => $name]);
                return $stmt->fetchColumn();
            };

            $site_url = $fetchOption('siteurl');
            $blog_name = $fetchOption('blogname');

            $theme_mods_raw = $fetchOption('theme_mods_kadence-child');
            $theme_mods = $theme_mods_raw ? unserialize($theme_mods_raw) : [];

            $palette_raw = $fetchOption('kadence_global_palette');
            $palette_data = $palette_raw ? json_decode($palette_raw, true) : [];

            // RESOLVE COLORS
            $active_palette_key = $palette_data['active'] ?? 'palette';
            $active_colors = $palette_data[$active_palette_key] ?? [];

            $resolveColor = function ($slug) use ($active_colors) {
                foreach ($active_colors as $c) {
                    if (($c['slug'] ?? '') === $slug) return $c['color'];
                }
                return null;
            };

            $primary_color = $resolveColor('palette1') ?? '#003366';
            $secondary_color = $resolveColor('palette2') ?? '#ff8800';
            $footer_bg = $resolveColor('palette8') ?? '#f5f5f5';

            // RESOLVE LOGO (Fix: Lookup ID in posts table)
            $logo_url = '';
            $custom_logo_id = $theme_mods['custom_logo'] ?? 0;

            // --- ADDED LOGIC FOR STICKY LOGO ---
            $sticky_logo_url = '';
            // This key is an educated guess based on Kadence structure.
            // If this key is incorrect, you may need to check your WP database directly.
            $sticky_logo_id = $theme_mods['header_sticky_logo'] ?? $theme_mods['sticky_custom_logo'] ?? 0;
            // -------------------------------------

            /* to resolve stikcy logo commented below and added new logic below
            if ($custom_logo_id) {
                 $stmtLogo = $pdo->prepare("SELECT guid FROM {$p}posts WHERE ID = :id");
                 $stmtLogo->execute(['id' => $custom_logo_id]);
                 $logo_url = $stmtLogo->fetchColumn();
            }
            */
            $fetchLogoUrl = function ($logo_id) use ($pdo, $p) {
                if (!$logo_id) return '';
                $stmtLogo = $pdo->prepare("SELECT guid FROM {$p}posts WHERE ID = :id AND post_type = 'attachment'");
                $stmtLogo->execute(['id' => $logo_id]);
                return $stmtLogo->fetchColumn();
            };

            $logo_url = $fetchLogoUrl($custom_logo_id);
            $sticky_logo_url = $fetchLogoUrl($sticky_logo_id); // Fetch the sticky logo URL

            // Fallback logo logic if ID lookup failed
            if (!$logo_url && isset($theme_mods['custom_logo_url'])) {
                $logo_url = $theme_mods['custom_logo_url'];
            }

            // Fallback Sticky logo logic if ID lookup failed
            if (!$sticky_logo_url && isset($theme_mods['header_sticky_logo_url'])) {
                $sticky_logo_url = $theme_mods['header_sticky_logo_url'];
            }

            // --- NEW: FINAL BACKUP STICKY LOGO URL ---
            if (!$sticky_logo_url) {
                // Replace this URL with the absolute URL to your backup logo file
                $sticky_logo_url = 'https://svajana.org/wp-content/uploads/2025/09/svajana-new-logo-7.png';
            }

            // RESOLVE TYPOGRAPHY
            // Extract font sizes to ensure they match WP exactly
            $brand_size = $theme_mods['brand_typography']['size']['desktop'] ?? 32;
            $brand_unit = $theme_mods['brand_typography']['sizeType'] ?? 'px';

            $menu_size = $theme_mods['primary_navigation_typography']['size']['desktop'] ?? 16;
            $menu_unit = $theme_mods['primary_navigation_typography']['sizeType'] ?? 'px';

            // RESOLVE HERO IMAGE
            $hero_image = $theme_mods['transparent_header_background']['desktop']['image']['url'] ?? '';
            if (!$hero_image) {
                $hero_image = $theme_mods['site_background']['desktop']['image']['url'] ?? '';
            }

            // FALLBACK HERO
            if (!$hero_image) {
                //$hero_image = 'http://localhost/wordpress/wp-content/uploads/2025/09/svrmarriage-10017-scaled.jpg';
                $hero_image = 'https://svajana.org/wp-content/uploads/2025/09/svrmarriage-10017.jpg';
            }

            // FETCH MENU
            $wp_menu_items = [];
            if (isset($theme_mods['nav_menu_locations']['primary'])) {
                $menu_term_id = $theme_mods['nav_menu_locations']['primary'];

                $stmtTax = $pdo->prepare("SELECT term_taxonomy_id FROM {$p}term_taxonomy WHERE term_id = :id AND taxonomy = 'nav_menu'");
                $stmtTax->execute(['id' => $menu_term_id]);
                $tt_id = $stmtTax->fetchColumn();

                if (!$tt_id) {
                    $tt_id = $menu_term_id;
                }

                if ($tt_id) {
                    $wp_menu_items = self::fetchWpMenu($pdo, $tt_id, $site_url, $p);
                }
            }

            return [
                'siteurl'         => $site_url ?: '/',
                'blogname'        => $blog_name ?: 'Webtrees',
                'custom_logo_url' => $logo_url,
                'sticky_logo_url' => $sticky_logo_url, // <-- Add this line
                'theme_mods'      => $theme_mods,
                'palette'         => $palette_data,
                'primary_color'   => $primary_color,
                'secondary_color' => $secondary_color,
                'footer_html'     => '© ' . date('Y') . ' ' . ($blog_name ?: 'Svajana'),
                'footer_bg'       => $footer_bg,
                'wp_menu_items'   => $wp_menu_items,
                'hero_image'      => $hero_image,
                'brand_font_css'  => $brand_size . $brand_unit,
                'menu_font_css'   => $menu_size . $menu_unit,
            ];
        } catch (Exception $e) {
            return [
                'siteurl' => '/',
                'blogname' => 'Webtrees',
                'theme_mods' => [],
                'palette' => [],
                'primary_color'   => '#003366',
                'secondary_color' => '#ff8800',
                'footer_html'     => 'DB Error: ' . $e->getMessage(),
                'footer_bg'       => '#eee',
                'wp_menu_items'   => [],
                'hero_image'      => '',
                'custom_logo_url' => '',
                'sticky_logo_url' => '', // <-- Add this line to the error return as well
                'brand_font_css'  => '2rem',
                'menu_font_css'   => '1rem',
            ];
        }
    }

    /**
     * Recursive Fetcher for WP Menu with Smart Resolver
     */
    private static function fetchWpMenu(PDO $pdo, $term_taxonomy_id, $site_url, $p): array
    {
        $sql = "
            SELECT 
                p.ID, 
                p.post_title, 
                p.post_name, 
                p.menu_order 
            FROM {$p}term_relationships tr
            JOIN {$p}posts p ON tr.object_id = p.ID
            WHERE tr.term_taxonomy_id = :tt_id 
            AND p.post_type = 'nav_menu_item' 
            AND p.post_status = 'publish'
            ORDER BY p.menu_order ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['tt_id' => $term_taxonomy_id]);
        $raw_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($raw_items)) return [];

        $items_by_id = [];
        $tree = [];

        foreach ($raw_items as $raw) {
            $post_id = $raw['ID'];

            $stmtMeta = $pdo->prepare("SELECT meta_key, meta_value FROM {$p}postmeta WHERE post_id = :id");
            $stmtMeta->execute(['id' => $post_id]);
            $metas = $stmtMeta->fetchAll(PDO::FETCH_KEY_PAIR);

            $type = $metas['_menu_item_type'] ?? 'custom';
            $object_id = $metas['_menu_item_object_id'] ?? 0;

            $url = $metas['_menu_item_url'] ?? '#';
            $target = $metas['_menu_item_target'] ?? '';
            $title = !empty($metas['_menu_item_title']) ? $metas['_menu_item_title'] : '';

            // Logic to check if this is the current page (active state)
            $isActive = false;
            // In Webtrees, we can't easily match WP pages, but we can match custom links
            // logic omitted for simplicity, handled via CSS 'active' classes

            if ($type === 'post_type' && $object_id) {
                $stmtPage = $pdo->prepare("SELECT post_title, post_name FROM {$p}posts WHERE ID = :id");
                $stmtPage->execute(['id' => $object_id]);
                $page = $stmtPage->fetch(PDO::FETCH_ASSOC);

                if ($page) {
                    if (empty($title)) {
                        $title = $page['post_title'];
                    }
                    $url = rtrim($site_url, '/') . '/' . $page['post_name'] . '/';
                }
            }

            if (empty($title)) $title = $raw['post_title'];
            if (empty($title)) $title = $raw['post_name'];

            $parent_id = $metas['_menu_item_menu_item_parent'] ?? '0';
            // Map generic WP classes to something we can style if needed
            $classes = $metas['_menu_item_classes'] ?? [];

            $items_by_id[$post_id] = [
                'id' => $post_id,
                'title' => $title,
                'url' => $url,
                'parent' => $parent_id,
                'target' => $target,
                'classes' => $classes,
                'children' => []
            ];
        }

        foreach ($items_by_id as $id => &$item) {
            $parent = $item['parent'];
            if ($parent == '0' || !isset($items_by_id[$parent])) {
                $tree[] = &$item;
            } else {
                $items_by_id[$parent]['children'][] = &$item;
            }
        }

        return $tree;
    }
}
