# Menu Filtering Implementation Guide

## ✅ Implementation Complete

Menu filtering has been successfully added to the **WebtreesSvajana** theme module where it belongs!

---

## 🎯 What Was Added

### New Methods in WebtreesSvajana.php

#### 1. `filterMenuByAuthState(array $menu_items): array`
Filters a flat array of menu items based on login state.

**Usage:**
```php
$filtered = WebtreesSvajana::filterMenuByAuthState($menu_items);
```

#### 2. `filterMenuTree(array $menu_items): array`
Recursively filters menu tree including nested children.

**Usage:**
```php
$filtered = WebtreesSvajana::filterMenuTree($menu_items);
```

---

## 🔄 Automatic Filtering

The `getWpHeaderData()` method now **automatically filters menus** before returning them:

```php
// In getWpHeaderData()
if ($tt_id) {
    $wp_menu_items = self::fetchWpMenu($pdo, $tt_id, $site_url, $p);
    
    // Auto-filter based on Auth::check()
    $wp_menu_items = self::filterMenuTree($wp_menu_items);
}
```

**This means:**
- ✅ Menu items are filtered at the data layer
- ✅ View templates receive pre-filtered menus
- ✅ No additional filtering needed in views
- ✅ Login shows ONLY when logged out
- ✅ Logout shows ONLY when logged in

---

## 📝 Required WordPress Configuration

### Add CSS Classes to Menu Items

In **WordPress Admin → Appearance → Menus:**

1. Click **"Screen Options"** (top right)
2. Enable **"CSS Classes"** checkbox
3. For your **Login** menu item:
   - Add CSS class: `menu-item-login`
4. For your **Logout** menu item:
   - Add CSS class: `menu-item-logout`
5. Click **"Save Menu"**

**Supported CSS Classes:**
- `menu-item-login` or `login-link` → Shows only when NOT logged in
- `menu-item-logout` or `logout-link` → Shows only when logged in

---

## 🎨 How It Works

### Authentication Detection
```php
$user_logged_in = Auth::check(); // Webtrees authentication check
```

### Filtering Logic
```php
// For Login items
if ($is_login && $user_logged_in) {
    return false; // Hide login when already logged in
}

// For Logout items
if ($is_logout && !$user_logged_in) {
    return false; // Hide logout when not logged in
}
```

---

## 🔍 Architecture

### Correct Separation of Concerns

```
webtrees-svajana/            ← THEME MODULE
├── WebtreesSvajana.php      
│   ├── getWpHeaderData()    ← Fetches WordPress data
│   ├── fetchWpMenu()        ← Builds menu structure
│   ├── filterMenuTree()     ✅ NEW - Filters by auth state
│   └── filterMenuByAuthState() ✅ NEW - Simple filter
└── resources/views/
    └── layouts/
        └── _menu.phtml      ← Renders filtered menu

wordpress_sso/               ← AUTH MODULE
├── WordPressSsoLogout.php   ← Handles logout
└── sso_logout.php           ← Bridge script
```

**Why this is correct:**
- Theme = Presentation layer (what user sees)
- SSO Module = Authentication layer (who user is)
- Menu filtering = Presentation concern → Belongs in theme

---

## 🧪 Testing

### Test Case 1: Logged Out User
```
Expected Menu Items:
✅ Home
✅ Family Tree
✅ Login (visible)
❌ Logout (hidden)
```

### Test Case 2: Logged In User
```
Expected Menu Items:
✅ Home
✅ Family Tree
❌ Login (hidden)
✅ Logout (visible)
```

### Manual Testing Steps

1. **Log out** of Webtrees
2. View the site menu
3. Verify **Login** appears, **Logout** does not
4. **Log in** to Webtrees
5. View the site menu
6. Verify **Logout** appears, **Login** does not

---

## 📊 Performance

**Impact:** Minimal
- Filtering happens once per page load
- Simple array operations (O(n) complexity)
- No database queries
- Menu data already cached by WordPress

---

## 🔧 Customization

### Add Custom Filter Logic

If you need to filter based on other criteria:

```php
// In WebtreesSvajana.php
public static function customMenuFilter(array $menu_items): array
{
    $user = Auth::user();
    
    return array_filter($menu_items, function($item) use ($user) {
        $classes = $item['classes'] ?? [];
        
        // Example: Hide admin items from non-admins
        if (in_array('admin-only', $classes)) {
            return $user && $user->getPreference('canadmin') === '1';
        }
        
        // Example: Hide family tree items if no tree selected
        if (in_array('requires-tree', $classes)) {
            return Session::get('tree_id') !== null;
        }
        
        return true;
    });
}
```

### Filter at Different Points

```php
// In view template (if needed for specific override)
$wp_data = WebtreesSvajana::getWpHeaderData();
$menu = $wp_data['wp_menu_items']; // Already filtered!

// Optional: Additional filtering
$menu = array_filter($menu, function($item) {
    // Your custom logic
    return true;
});
```

---

## 🐛 Troubleshooting

### Issue: Both Login and Logout Show

**Cause:** CSS classes not set on WordPress menu items

**Solution:**
1. Go to WordPress Admin → Appearance → Menus
2. Enable "CSS Classes" in Screen Options
3. Add `menu-item-login` to Login item
4. Add `menu-item-logout` to Logout item
5. Save menu

### Issue: Neither Login nor Logout Show

**Cause:** Both items might have wrong CSS classes

**Solution:**
Check the `$item['classes']` array - ensure classes are strings in array format:
```php
// Correct format in WordPress database
$item['classes'] = ['menu-item-login', 'nav-link'];
```

### Issue: Auth::check() Always Returns False

**Cause:** wordpress_sso module might not be creating Webtrees session properly

**Solution:**
1. Check wordpress_sso module is enabled
2. Verify SSO login flow completes successfully
3. Check `Auth::id()` returns a user ID when logged in

---

## 📚 Related Documentation

- [WebtreesSvajana Theme Documentation](README.md)
- [WordPress SSO Module - Authentication Flow](../../wordpress_sso/AUTHENTICATION-FLOW.md)
- [WordPress Menu System](https://developer.wordpress.org/themes/functionality/navigation-menus/)

---

## ✅ Summary

✅ Menu filtering implemented in **correct location** (theme module)  
✅ Automatic filtering in `getWpHeaderData()`  
✅ No changes needed in view templates  
✅ Supports nested menu structures  
✅ Follows proper separation of concerns  
✅ Minimal performance impact  

**Status:** Production ready! 🚀
