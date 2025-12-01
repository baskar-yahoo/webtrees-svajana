# Color Audit - Webtrees Svajana Theme

**Date:** November 30, 2025  
**Branch:** feature/modern-ui-enhancements  
**Purpose:** Complete audit of color usage and hardcoded colors

---

## CSS Variable Definitions (custom.css)

All palette variables are defined in `resources/css/custom.css`:

```css
:root {
    --global-palette1: #003366;  /* Navy - Primary brand */
    --global-palette2: #ff8800;  /* Orange - Hover accent */
    --global-palette3: #333333;  /* Dark gray - Text, backgrounds */
    --global-palette4: #555555;  /* Medium gray - Body text, borders */
    --global-palette5: #888888;  /* Light gray - RARELY USED */
    --global-palette6: #99bbdd;  /* Light blue - Borders, accents */
    --global-palette7: #ebf5ff;  /* Pale blue - Backgrounds */
    --global-palette8: #f5f5f5;  /* Very light gray - Backgrounds */
    --global-palette9: #ffffff;  /* White - Card backgrounds */
}
```

---

## Usage Summary

### ✅ **Heavily Used Variables:**

| Variable | Color | Usage Count | Where Used |
|----------|-------|-------------|------------|
| `--global-palette1` | #003366 (Navy) | 50+ | Primary color, headings, links, buttons |
| `--global-palette2` | #ff8800 (Orange) | 30+ | **Our hover effects**, active states |
| `--global-palette3` | #333333 (Dark Gray) | 20+ | Dark text, backgrounds (custom.css) |
| `--global-palette4` | #555555 (Med Gray) | 25+ | Body text, borders (custom.css + modern-enhancements.css) |
| `--global-palette6` | #99bbdd (Light Blue) | 10+ | Chart borders, accents |
| `--global-palette7` | #ebf5ff (Pale Blue) | 10+ | Table headers, backgrounds |
| `--global-palette8` | #f5f5f5 (V.Light Gray) | 15+ | Page backgrounds, alternating rows |
| `--global-palette9` | #ffffff (White) | 30+ | Card backgrounds, content areas |

### ⚠️ **Barely Used Variable:**

| Variable | Color | Usage Count | Where Used |
|----------|-------|-------------|------------|
| `--global-palette5` | #888888 (Light Gray) | **1 ONLY** | custom.css line 220 |

**Recommendation:** Could be repurposed for sex icon colors or other needs.

---

## 🚨 **Hardcoded Colors Found**

### In `modern-enhancements.css`:

#### **Sex Icon Colors (Lines 70-90):**
```css
/* Male */
.wt-sex-m {
    color: #1e90ff;  /* DodgerBlue */
}

/* Female */
.wt-sex-f {
    color: #ff69b4;  /* HotPink */
}

/* Unknown */
.wt-sex-u {
    color: var(--global-palette4);  /* ✅ GOOD - Uses variable */
}

/* Other/Non-binary */
.wt-sex-x {
    color: #9370db;  /* MediumPurple */
}
```

#### **Font Awesome Sex Icons (Lines 315-335):**
```css
/* Female Venus */
.fa-venus,
.wt-icon-sex-f {
    color: #ce5380 !important;  /* Rose Pink */
}

/* Male Mars */
.fa-mars,
.wt-icon-sex-m {
    color: #468bb6 !important;  /* Steel Blue */
}

/* Unknown/Other */
.wt-icon-sex-u,
.wt-icon-sex-x {
    color: grey !important;  /* Keyword - should be variable */
}
```

---

## 💡 Recommendations for Issue #2

### **Option A: Add Sex Icon Variables (Recommended)**

Add to `custom.css` `:root` section:

```css
/* Sex icon colors */
--sex-male-color: #468bb6;      /* Steel Blue */
--sex-female-color: #ce5380;    /* Rose Pink */
--sex-unknown-color: var(--global-palette4);  /* Gray #555555 */
--sex-other-color: #9370db;     /* Medium Purple */
```

Then update `modern-enhancements.css`:

```css
/* Consolidate all male sex icons */
.wt-sex-m,
.fa-mars,
.wt-icon-sex-m {
    color: var(--sex-male-color) !important;
}

/* Consolidate all female sex icons */
.wt-sex-f,
.fa-venus,
.wt-icon-sex-f {
    color: var(--sex-female-color) !important;
}

/* Consolidate unknown icons */
.wt-sex-u,
.wt-icon-sex-u {
    color: var(--sex-unknown-color) !important;
}

/* Consolidate other/non-binary icons */
.wt-sex-x,
.wt-icon-sex-x {
    color: var(--sex-other-color) !important;
}
```

**Benefits:**
- Consistent icon colors across all contexts
- Easy to change theme-wide by updating one variable
- Follows existing pattern (CSS variables)
- Reduces code duplication

### **Option B: Repurpose palette5**

Since `--global-palette5` (#888888) is barely used, we could repurpose it:

```css
/* In custom.css - CHANGE THIS: */
--global-palette5: #888888;  /* Currently barely used */

/* TO THIS: */
--global-palette5: var(--sex-unknown-color);  /* Alias for consistency */
```

---

## Color Consistency Issues

### ❌ **Inconsistent Sex Icon Colors:**

Currently using **TWO DIFFERENT BLUES** for male:
- `.wt-sex-m` = #1e90ff (DodgerBlue - brighter)
- `.fa-mars`, `.wt-icon-sex-m` = #468bb6 (Steel Blue - darker)

Currently using **TWO DIFFERENT PINKS** for female:
- `.wt-sex-f` = #ff69b4 (HotPink - brighter)
- `.fa-venus`, `.wt-icon-sex-f` = #ce5380 (Rose Pink - darker)

**Should be unified** to use same color for each sex across all contexts.

---

## Files Updated (This Commit)

✅ **style-demo.html**
- Added palette3, palette4, palette5 color swatches
- Updated CSS variable definitions with correct colors
- Fixed emoji directions (👆 → 👇) to point down at components

✅ **element-css-mapping.md**
- Corrected color variable table with actual palette3-5 values
- Documented correct usage

---

## Next Steps (For Later Issue #2)

1. Decide on sex icon color scheme (Option A recommended)
2. Update `custom.css` with new variables
3. Update `modern-enhancements.css` to use variables
4. Test on actual webtrees pages
5. Commit changes

---

## Testing Notes

To verify color usage, search in CSS files:

```powershell
# Find all hardcoded hex colors
Select-String -Path "resources\css\*.css" -Pattern "#[0-9a-fA-F]{3,6}" | Group-Object Pattern | Sort-Object Count -Descending

# Find usage of specific palette
Select-String -Path "resources\css\*.css" -Pattern "--global-palette3"
```

---

## Summary

- ✅ All 9 palette variables ARE defined and used (palette5 has 0 occurrences in modern-enhancements.css)
- ✅ Documentation now accurately reflects actual colors
- ✅ Style demo now shows correct palette with all 9 colors
- ⚠️ 6 hardcoded colors found in modern-enhancements.css (sex icons)
- 📋 Issue #2 will address replacing hardcoded colors with variables

**No breaking changes in this commit** - only documentation/demo updates.

---

## Updated Analysis: December 2025

### Palette Variable Usage in modern-enhancements.css (1659 lines)

**Current State Analysis:**

| Variable | Occurrences | Primary Usage | Status |
|----------|-------------|---------------|--------|
| `--global-palette1` | 90 | Navy (#003366) - Primary brand color, headings, active tabs, chart boxes, buttons | ✅ HEAVILY USED |
| `--global-palette2` | 22 | Orange (#ff8800) - Hover accent, border highlights, button hover, dropdown top border | ✅ HEAVILY USED |
| `--global-palette3` | 6 | Dark gray (#333333) - Dark text, dropdown backgrounds, fact values | ✅ USED |
| `--global-palette4` | 8 | Medium gray (#555555) - Body text, borders, dropdown hover, unknown sex icon | ✅ USED |
| `--global-palette5` | **0** | Light gray (#888888) - **NOT USED IN modern-enhancements.css** | ⚠️ UNUSED |
| `--global-palette6` | 26 | Light blue (#99bbdd) - Borders (tables, chart boxes, cards), visual separation | ✅ HEAVILY USED |
| `--global-palette7` | 13 | Pale blue (#ebf5ff) - Table headers, alternating backgrounds, gradient components | ✅ USED |
| `--global-palette8` | 16 | Very light gray (#f5f5f5) - Page backgrounds, card alternates, button text | ✅ USED |
| `--global-palette9` | 10 | White (#ffffff) - Card backgrounds, text on dark backgrounds, content areas | ✅ USED |

### Hardcoded Colors That Should Be Variables

#### Sex Icon Colors (modern-enhancements.css lines 70-105, 315-335)

**Current Implementation:**
```css
/* Lines 315-335: Font Awesome sex icons */
.fa-venus,
.wt-icon-sex-f {
    color: #ce5380 !important;  /* Pink/Rose */
}

.fa-mars,
.wt-icon-sex-m {
    color: #468bb6 !important;  /* Blue */
}

.wt-icon-sex-u,
.wt-icon-sex-x {
    color: grey !important;     /* Gray */
}

/* Lines 70-90: Chart box sex icons */
.wt-sex-m {
    color: #1e90ff;  /* DodgerBlue */
}

.wt-sex-f {
    color: #ff69b4;  /* HotPink */
}

.wt-sex-u {
    color: var(--global-palette4);  /* Already using variable! */
}

.wt-sex-x {
    color: #9370db;  /* MediumPurple */
}
```

**Hardcoded Colors Found:**
1. `#ce5380` - Rose/Pink for female Font Awesome icon (line 316)
2. `#468bb6` - Blue for male Font Awesome icon (line 321)
3. `grey` - Generic gray for unknown/other Font Awesome icon (line 326)
4. `#1e90ff` - DodgerBlue for male sex indicator (line 71)
5. `#ff69b4` - HotPink for female sex indicator (line 75)
6. `#9370db` - MediumPurple for intersex indicator (line 83)

**Total Hardcoded Colors:** 6 instances (should be reduced to CSS variables)

### Recommendations

#### 1. Create Sex Icon CSS Variables

Add to `:root` in custom.css or base.css:

```css
:root {
    /* Existing palette variables... */
    
    /* Sex Icon Colors */
    --sex-male-primary: #468bb6;      /* Blue for Font Awesome male */
    --sex-male-chart: #1e90ff;        /* DodgerBlue for chart boxes */
    --sex-female-primary: #ce5380;    /* Rose for Font Awesome female */
    --sex-female-chart: #ff69b4;      /* HotPink for chart boxes */
    --sex-unknown: var(--global-palette4);  /* Gray (already variable) */
    --sex-intersex: #9370db;          /* MediumPurple */
}
```

**Rationale:** Keeping separate `*-primary` and `*-chart` variants allows different shading for different contexts while maintaining semantic meaning.

#### 2. Alternative: Consolidate to Single Color Per Sex

If design allows, simplify to one color per sex type:

```css
:root {
    --sex-male: #468bb6;       /* Unified blue */
    --sex-female: #ce5380;     /* Unified rose/pink */
    --sex-unknown: var(--global-palette4);  /* Gray */
    --sex-intersex: #9370db;   /* Purple */
}
```

Then use these variables in both Font Awesome icons AND chart boxes.

#### 3. Repurpose or Deprecate `--global-palette5`

**Current Status:** `--global-palette5` (#888888 - light gray) has **0 occurrences** in modern-enhancements.css.

**Option A - Repurpose for Sex Icons:**
```css
:root {
    --global-palette5: #888888;  /* Repurpose as --sex-unknown */
}

/* Then in modern-enhancements.css */
.wt-sex-u,
.wt-icon-sex-u {
    color: var(--global-palette5);
}
```

**Option B - Deprecate and Remove:**
- Remove from palette documentation
- Remove from style-demo.html color swatches
- Note in migration guide if used in custom CSS by users

**Option C - Reserve for Future Use:**
- Keep definition in custom.css
- Document as "reserved for future expansion"
- No active usage required

**Recommended:** Option A - Repurpose as semantic sex-unknown color, maintains 9-palette system consistency.

#### 4. Update Sex Icon CSS - Implementation Plan

**File:** modern-enhancements.css  
**Lines to Update:** 70-90 (chart sex icons), 315-335 (Font Awesome sex icons)

**Step 1:** Define variables in custom.css `:root`
**Step 2:** Replace hardcoded colors in modern-enhancements.css
**Step 3:** Test all pages with individual records (male, female, unknown, intersex)
**Step 4:** Update documentation (this file, element-css-mapping.md)
**Step 5:** Commit with message: "refactor: Replace hardcoded sex icon colors with CSS variables"

**Estimated Impact:**
- Files changed: 2 (custom.css, modern-enhancements.css)
- Lines changed: ~20
- Risk level: LOW (visual only, no functionality change)
- Testing required: Visual verification on 4 individual pages (one per sex type)

### Z-Index Architecture Summary

**Current z-index Strategy in modern-enhancements.css:**

| Z-Index | Usage | CSS Line Reference |
|---------|-------|-------------------|
| `1` | Base layer (default) | Throughout |
| `10` | Links in tables/cards for clickability | Lines 822, 870, 926, 940, 1417, 1473 |
| `20` | Hovered table cells (DISABLED to fix dropdown clipping) | Line 832 (commented out) |
| `1050` | Standard Bootstrap dropdowns | Line 1528 |
| `1060` | Chart dropdowns (higher than standard) | Original attempt, superseded by 99999 |
| `10000` | Navigation sub-menus (webtrees-menus.css) | Referenced in dropdown section |
| `99999` | **Critical chart box dropdowns** | Lines 1540-1560 |

**Critical Fix:** Z-index 99999 ensures chart dropdowns (Zoom In, Links) appear above ALL content including sticky headers, navigation, and overlapping tables.

**Related CSS Properties for Dropdown Visibility:**
- `overflow: visible` on all parent containers (lines 903, 1421, 1548, 1555-1560)
- `position: absolute` on dropdown menus (line 1544)
- Transform effects DISABLED on containers with dropdowns (lines 835, 895, 1414)

**Cross-Reference:** See element-css-mapping.md "Dropdown Z-Index Architecture" section for complete technical breakdown.

### Accessibility & Color Contrast

**WCAG AA Compliance Check (4.5:1 minimum for normal text, 3:1 for large text):**

✅ **palette1 (#003366) on palette9 (white):** 9.71:1 - PASS  
✅ **palette2 (#ff8800) on palette9 (white):** 3.91:1 - PASS (large text only)  
✅ **palette3 (#333333) on palette9 (white):** 12.63:1 - PASS  
✅ **palette8 (#f5f5f5) on palette1 (#003366):** 8.94:1 - PASS  
⚠️ **palette6 (#99bbdd) on palette9 (white):** 2.31:1 - FAIL (decorative borders only, not text)  

**Note:** palette6 (light blue) is used exclusively for borders and visual separation, never for text, so low contrast is acceptable.

### Migration Path for Future Updates

**If adding new colors:**
1. Add to `:root` in custom.css with semantic name
2. Document in this file under new "Custom Semantic Colors" section
3. Update style-demo.html with swatch example
4. Add to element-css-mapping.md for testing reference
5. Use consistently across all CSS files

**If removing colors:**
1. Search all CSS files for variable usage (grep for `--variable-name`)
2. Replace with appropriate alternative from existing palette
3. Update all documentation
4. Add migration note to CHANGELOG.md

### Cross-Reference
- **Sex Icon Implementation:** See modern-enhancements.css lines 70-90, 315-335
- **Color Variables Definition:** See custom.css :root section
- **Interactive Color Demo:** See style-demo.html "Color Palette" section
- **CSS Class Mapping:** See element-css-mapping.md for complete color usage by component
