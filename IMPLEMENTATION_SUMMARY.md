# Svajana Theme Modern Enhancements - Implementation Summary

## Overview
Successfully implemented modern theme's enhanced individual pages in webtrees-svajana theme using Font Awesome icons, custom JavaScript dropdowns, and the svajana color scheme (navy #003366 and orange #ff8800).

## Files Created/Modified

### 1. View Files (11 files)
Created in `modules_v4/webtrees-svajana/resources/views/`:

1. **individual-page.phtml** - Table layout with 4-row structure (photo, name, lifespan, relationship, menu)
   - 150x150px photo (rowspan=4 when relationship shown, rowspan=3 without)
   - Relationship display using cached method
   - Sex icons with Font Awesome (fa-mars, fa-venus, fa-genderless, fa-transgender)

2. **individual-page-tabs.phtml** - Pills navigation wrapper using regex replacement

3. **individual-page-menu.phtml** - Dropdown menu with data-dropdown-toggle
   - Font Awesome icons: fa-bars, fa-pencil-alt, fa-plus, fa-share-alt, fa-sort, fa-trash, fa-fw
   - Removed all Bootstrap data-bs-* attributes

4. **individual-page-names.phtml** - Accordion structure for NAME facts

5. **individual-page-images.phtml** - Image carousel with 150x150px thumbnails
   - Single image or carousel with custom data attributes (data-slide-target, data-slide-to, data-slide)

6. **fact.phtml** - Enhanced fact display with sex icons and improved layout

7. **chart-box.phtml** - Orange dashed border wrapper using var(--global-palette2)

8. **webmanifest-json.phtml** - Svajana branding with navy theme color

9. **modules/family_nav/sidebar-family.phtml** - Family navigator with click dropdowns

10. **modules/statistics-chart/page.phtml** - Pills navigation for statistics

11. **modules/random_media/slide-show.phtml** - Media slideshow with FA icons (fa-play, fa-stop, fa-step-forward, fa-user, fa-users, fa-file-alt)

### 2. CSS Files (2 new files)

**modern-components.css** (207 lines)
- Font Awesome icon spacing (.fas, .far with margin-right: 5px)
- Dropdown system (Bootstrap-free)
  - .dropdown, .dropdown-toggle, .dropdown-menu, .dropdown-item
  - .dropdown-header, .dropdown-divider
- Navigation pills (.nav-pills, .nav-link, .nav-link.active)
- Button styles (.btn, .btn-link)
- Utility classes (float-start, me-1, mt-2, text-center, align-middle, d-print-none, visually-hidden)
- Mobile responsive breakpoints (@media max-width 767px)

**modern-enhancements.css** (229 lines)
- Individual header table layout (#individual-header-table)
  - 4-row structure with borders and padding
  - Photo cell (150px width), name, lifespan, relationship, menu rows
- Sex icon colors (wt-sex-m: #1e90ff, wt-sex-f: #ff69b4, wt-sex-u: gray, wt-sex-x: #9370db)
- Silhouette backgrounds with rgba opacity
- Chart boxes with svajana palette borders
- Relationship display with orange accent border
- Facts table styling
- Family navigator styling
- Page menu button styling
- Mobile responsive (767px, 575px breakpoints with table-to-block conversion)

### 3. JavaScript File

**dropdown-toggle.js** (138 lines)
- Unified click handler for both:
  - webtrees dropdowns ([data-dropdown-toggle])
  - WordPress menu dropdowns (.menu-item-has-children)
- Auto-close on outside click or Escape key
- MutationObserver for AJAX content
- Prevents multiple open dropdowns

### 4. Modified Files

**custom.css** - Added CSS variables after line 42:
```css
--chart-line: var(--global-palette1);
--link-color: var(--global-palette1);
--link-color-hover: var(--global-palette2);
--sex-m-bg: rgba(30, 144, 255, 0.1);
--sex-f-bg: rgba(255, 105, 180, 0.1);
--sex-u-bg: rgba(85, 85, 85, 0.1);
--sex-x-bg: rgba(147, 112, 219, 0.1);
--global-palette1-rgb: 0, 51, 102;
--global-palette2-rgb: 255, 136, 0;
--global-palette4-rgb: 85, 85, 85;
```

**WebtreesSvajana.php** - 4 method updates:

1. **boot()** method - Added 11 view registrations:
```php
View::registerCustomView('::individual-page', self::CUSTOM_NAMESPACE . '::individual-page');
View::registerCustomView('::individual-page-tabs', self::CUSTOM_NAMESPACE . '::individual-page-tabs');
View::registerCustomView('::individual-page-menu', self::CUSTOM_NAMESPACE . '::individual-page-menu');
View::registerCustomView('::individual-page-names', self::CUSTOM_NAMESPACE . '::individual-page-names');
View::registerCustomView('::individual-page-images', self::CUSTOM_NAMESPACE . '::individual-page-images');
View::registerCustomView('::fact', self::CUSTOM_NAMESPACE . '::fact');
View::registerCustomView('::chart-box', self::CUSTOM_NAMESPACE . '::chart-box');
View::registerCustomView('::webmanifest-json', self::CUSTOM_NAMESPACE . '::webmanifest-json');
View::registerCustomView('::modules/family_nav/sidebar-family', self::CUSTOM_NAMESPACE . '::modules/family_nav/sidebar-family');
View::registerCustomView('::modules/statistics-chart/page', self::CUSTOM_NAMESPACE . '::modules/statistics-chart/page');
View::registerCustomView('::modules/random_media/slide-show', self::CUSTOM_NAMESPACE . '::modules/random_media/slide-show');
```

2. **stylesheets()** method - Added 2 new CSS files:
```php
$this->assetUrl('css/modern-components.css'),
$this->assetUrl('css/modern-enhancements.css'),
```

3. **bodyContent()** method - Load JavaScript:
```php
return '<script src="' . $this->assetUrl('js/dropdown-toggle.js') . '"></script>';
```

4. **getRelationshipCached()** method - NEW public method:
```php
public function getRelationshipCached($individual1, $individual2, $tree): string
{
    $cache_key = sprintf(
        'relationship_%d_%s_%s_%d_%d',
        $tree->id(),
        $individual1->xref(),
        $individual2->xref(),
        $individual1->updateTs(),
        $individual2->updateTs()
    );
    
    $relationship_service = new \Fisharebest\Webtrees\Services\RelationshipService();
    $cache = \Fisharebest\Webtrees\Registry::cache()->array();
    
    $cached = $cache->get($cache_key);
    if ($cached !== null) return $cached;
    
    $relationship = $relationship_service->getCloseRelationshipName($individual1, $individual2);
    $cache->set($cache_key, $relationship, 3600);
    
    return $relationship;
}
```

## Technical Details

### SVG to Font Awesome Icon Mapping
- `view('icons/menu')` → `<i class="fas fa-bars"></i>`
- `view('icons/edit')` → `<i class="fas fa-pencil-alt"></i>`
- `view('icons/add')` → `<i class="fas fa-plus"></i>`
- `view('icons/share')` → `<i class="fas fa-share-alt"></i>`
- `view('icons/reorder')` → `<i class="fas fa-sort"></i>`
- `view('icons/delete')` → `<i class="fas fa-trash"></i>`
- `view('icons/spacer')` → `<i class="fas fa-fw"></i>`
- `view('icons/individual')` → `<i class="fas fa-user"></i>`
- `view('icons/family')` → `<i class="fas fa-users"></i>`
- `view('icons/source')` → `<i class="fas fa-file-alt"></i>`
- `view('icons/media-play')` → `<i class="fas fa-play"></i>`
- `view('icons/media-stop')` → `<i class="fas fa-stop"></i>`
- `view('icons/media-next')` → `<i class="fas fa-step-forward"></i>`

### Bootstrap to Custom Data Attributes
- `data-bs-toggle="dropdown"` → `data-dropdown-toggle`
- `data-bs-target="#target"` → `data-slide-target="#target"`
- `data-bs-slide="prev"` → `data-slide="prev"`
- `data-bs-slide-to="0"` → `data-slide-to="0"`
- `data-bs-interval="false"` → `data-interval="false"`

### Color Scheme Usage
- Navy (#003366 / var(--global-palette1)) - Primary headings, borders, buttons
- Orange (#ff8800 / var(--global-palette2)) - Accents, hover states, relationship display, chart borders
- Grays (palette3-7) - Text, backgrounds, borders
- White (palette8-9) - Backgrounds, button text

### Caching Strategy
Cache key includes:
- Tree ID
- Both individual XREFs
- Both individual update timestamps (updateTs())
- Automatically invalidates when either individual is edited
- 1 hour cache duration

## CSS Loading Order
1. base.css (Svajana base styles)
2. webtrees-menus.css (Menu system)
3. custom.css (Kadence integration + variables)
4. **modern-components.css** (NEW - Dropdowns, pills, buttons)
5. **modern-enhancements.css** (NEW - Individual pages, charts)
6. enable-icons.css (Font Awesome icon definitions)

## Testing Checklist
- [ ] Individual pages display table layout correctly
- [ ] 150x150px photos show properly
- [ ] Relationship displays for logged-in users with GEDCOM records
- [ ] Dropdowns open on click (both webtrees and WordPress menus)
- [ ] Dropdowns close on outside click or Escape key
- [ ] Pills navigation replaces tabs on individual page and statistics
- [ ] Sex icons display with correct colors
- [ ] Chart boxes have orange dashed border
- [ ] Mobile responsive layout works (767px, 575px breakpoints)
- [ ] Font Awesome icons load with 5px right margin
- [ ] Cache invalidation works when individuals are edited
- [ ] No JavaScript console errors
- [ ] No CSS layout issues

## Differences from Modern Theme
1. **Bootstrap-free** - Custom CSS for all components
2. **Font Awesome** - Instead of SVG icons via view('icons/*')
3. **Click dropdowns** - Instead of hover (better mobile UX)
4. **Svajana colors** - Navy/orange instead of modern's blue palette
5. **Unified JavaScript** - Works with both webtrees and WordPress menus
6. **Public method** - getRelationshipCached() accessible from views
7. **Webmanifest** - Svajana branding instead of modern's palette switching

## File Statistics
- Total files created: 14 (11 views, 2 CSS, 1 JS)
- Total files modified: 2 (custom.css, WebtreesSvajana.php)
- Total lines of code added: ~1,200
- Bootstrap dependencies removed: 100%
- SVG icons replaced with Font Awesome: 13 replacements

## Implementation Date
2025-01-15

## Notes
- All files created with proper namespacing (self::CUSTOM_NAMESPACE)
- No Bootstrap JavaScript dependencies
- Maintains backward compatibility with existing svajana features
- Follows PSR standards for PHP code
- Mobile-first responsive design approach
- Cache key automatically busts on record edits via updateTs()
