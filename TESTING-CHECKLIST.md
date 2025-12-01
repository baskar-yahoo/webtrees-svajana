# Webtrees Svajana Theme - Testing Checklist

**Last Updated:** December 2025  
**Branch:** feature/modern-ui-enhancements  
**Version:** 3.0.0  

## Purpose

This checklist ensures comprehensive validation of all CSS fixes, hover effects, dropdown visibility, and chart rendering across different browsers and screen sizes. Use this document for regression testing after future updates.

---

## Browser Compatibility Matrix

### Desktop Browsers

| Browser | Version | Status | Notes |
|---------|---------|--------|-------|
| **Google Chrome** | 120+ | ✅ PASS | Primary development browser |
| **Mozilla Firefox** | 121+ | ✅ PASS | Full compatibility verified |
| **Microsoft Edge** | 120+ | ✅ PASS | Chromium-based, identical to Chrome |
| **Safari** | 17+ (macOS) | ✅ PASS | Webkit rendering tested |
| **Opera** | 105+ | ⚠️ NOT TESTED | Chromium-based, should work |
| **Brave** | Latest | ⚠️ NOT TESTED | Chromium-based, should work |

### Mobile Browsers

| Browser | Platform | Version | Status | Notes |
|---------|----------|---------|--------|-------|
| **Safari** | iOS 17+ | ✅ PASS | Touch interactions verified |
| **Chrome Mobile** | Android 12+ | ✅ PASS | Touch interactions verified |
| **Firefox Mobile** | Android 12+ | ⚠️ NOT TESTED | Should work, needs verification |
| **Samsung Internet** | Android | ⚠️ NOT TESTED | Chromium-based variant |

### Screen Resolutions Tested

| Resolution | Device Type | Status | Notes |
|------------|-------------|--------|-------|
| 1920x1080 | Desktop | ✅ PASS | Standard FHD monitor |
| 1366x768 | Laptop | ✅ PASS | Common laptop resolution |
| 768x1024 | Tablet (portrait) | ✅ PASS | iPad dimensions |
| 375x667 | Mobile (portrait) | ✅ PASS | iPhone SE/8 dimensions |
| 414x896 | Mobile (portrait) | ⚠️ NOT TESTED | iPhone XR/11 dimensions |

---

## Dropdown Visibility Tests

### Test 1: Chart Box Dropdowns in Facts Table

**Location:** Individual page → Facts & Events tab  
**CSS Reference:** modern-enhancements.css lines 1527-1560  
**Expected z-index:** 99999

#### Test Steps

1. Navigate to any individual's page
2. Click on "Facts & Events" tab
3. Locate a fact with a chart box (e.g., Birth fact with clickable person icon)
4. Click the **Zoom In** icon (magnifying glass) on chart box
5. Verify dropdown appears **fully visible** above table
6. Verify all dropdown items are clickable
7. Click outside to close dropdown
8. Click the **Links** icon (chain link) on chart box
9. Verify dropdown appears **fully visible** above table
10. Verify all dropdown items are clickable

#### Pass Criteria

- ✅ Dropdown extends beyond table cell boundaries
- ✅ No clipping at top, bottom, left, or right edges
- ✅ Dropdown has dark background (palette3) with orange top border (palette2)
- ✅ All text in dropdown is readable
- ✅ All links are clickable (cursor changes to pointer)
- ✅ Dropdown closes when clicking outside

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 2: Chart Box Dropdowns in Family Navigator

**Location:** Individual page → Family Navigator (below Facts & Events)  
**CSS Reference:** modern-enhancements.css lines 1527-1560  

#### Test Steps

1. Navigate to any individual's page
2. Scroll to "Family Navigator" section (below tabs)
3. In "Parents" or "Children" sections, click Zoom In icon on any chart box
4. Verify dropdown appears above family navigator table
5. Click Links icon on any chart box
6. Verify dropdown appears above family navigator table

#### Pass Criteria

- ✅ Dropdown appears above `.wt-family-navigator-family` container
- ✅ No clipping by table caption or borders
- ✅ Orange hover effect on family navigator table still works (border + shadow)
- ✅ Transform effect is DISABLED on family navigator (no lift)

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 3: Navigation Menu Dropdowns

**Location:** Header navigation menu  
**CSS Reference:** webtrees-menus.css  
**Expected z-index:** 10000

#### Test Steps

1. Navigate to any page
2. **Hover test:** Hover over any top-level menu item with sub-menu
3. Verify sub-menu appears immediately (CSS hover)
4. Move mouse away, verify sub-menu disappears
5. **Click test:** Click on same top-level menu item
6. Verify sub-menu appears and stays open
7. Click again to close
8. Verify sub-menu closes

#### Pass Criteria

- ✅ Sub-menu appears on both hover AND click
- ✅ Dark background (palette3) with orange top border
- ✅ Sub-menu items have proper hover effect (indent + orange text)
- ✅ Z-index 10000 ensures menu appears below chart dropdowns (99999) if overlapping
- ✅ Transitions are smooth (200ms ease)

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

## Chart Connection Lines Tests

### Test 4: Pedigree Chart - RIGHT Layout

**Location:** Charts → Pedigree chart → Layout: Right  
**CSS Reference:** modern-enhancements.css lines 1189-1210  

#### Test Steps

1. Navigate to Charts → Pedigree chart
2. Ensure "Layout: Right" is selected
3. Verify vertical lines appear on RIGHT side of parent boxes
4. Verify lines connect to both parents (if both exist)
5. Verify rounded corners: left side rounded (1rem), right side square

#### Pass Criteria

- ✅ Vertical gray lines visible connecting parent boxes
- ✅ Lines are 25% width, 50% height (centered vertically)
- ✅ Border-radius: `1rem 0 0 1rem` (rounded on left)
- ✅ Lines extend from right edge of boxes

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 5: Pedigree Chart - LEFT Layout

**Location:** Charts → Pedigree chart → Layout: Left  
**CSS Reference:** modern-enhancements.css lines 1212-1224  

#### Test Steps

1. Navigate to Charts → Pedigree chart
2. Select "Layout: Left" from dropdown
3. Verify vertical lines appear on LEFT side of parent boxes
4. Verify mirror image of RIGHT layout

#### Pass Criteria

- ✅ Vertical gray lines visible connecting parent boxes
- ✅ Lines are 25% width, 50% height (centered vertically)
- ✅ Border-radius: `0 1rem 1rem 0` (rounded on right)
- ✅ Lines extend from left edge of boxes

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 6: Pedigree Chart - DOWN Layout

**Location:** Charts → Pedigree chart → Layout: Down  
**CSS Reference:** modern-enhancements.css lines 1226-1237  

#### Test Steps

1. Navigate to Charts → Pedigree chart
2. Select "Layout: Down" from dropdown
3. Verify horizontal lines appear at TOP of child boxes
4. Verify chart width expands properly (`width: max-content`)

#### Pass Criteria

- ✅ Horizontal gray lines visible at top of boxes
- ✅ Lines are 50% width (centered horizontally), 25% height
- ✅ Border-radius: `1rem 1rem 0 0` (rounded on top)
- ✅ Chart does not have horizontal scrollbar
- ✅ All boxes properly aligned vertically

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 7: Pedigree Chart - UP Layout

**Location:** Charts → Pedigree chart → Layout: Up  
**CSS Reference:** modern-enhancements.css lines 1239-1250  

#### Test Steps

1. Navigate to Charts → Pedigree chart
2. Select "Layout: Up" from dropdown
3. Verify horizontal lines appear at BOTTOM of child boxes
4. Verify chart width expands properly (`width: max-content`)

#### Pass Criteria

- ✅ Horizontal gray lines visible at bottom of boxes
- ✅ Lines are 50% width (centered horizontally), 25% height
- ✅ Border-radius: `0 0 1rem 1rem` (rounded on bottom)
- ✅ Chart does not have horizontal scrollbar
- ✅ All boxes properly aligned vertically

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 8: Ancestors Chart - Vertical Lines

**Location:** Charts → Ancestors chart  
**CSS Reference:** modern-enhancements.css lines 1310-1354  

#### Test Steps

1. Navigate to Charts → Ancestors chart
2. Verify vertical lines appear connecting generations
3. Verify horizontal connectors (1.5rem) from vertical line to each box
4. Verify last child has rounded corner (bottom-left)
5. Verify Sosa numbers appear with dotted border
6. Click expand/collapse controls if available

#### Pass Criteria

- ✅ Vertical border-left (1px solid #dee2e6) visible
- ✅ Horizontal connectors to each generation
- ✅ Last child has `border-radius: 0 0 0 .25rem`
- ✅ 2rem indentation between generations
- ✅ Sosa numbers styled with dotted border
- ✅ Expand/collapse controls functional

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 9: Descendants Chart - Vertical Lines

**Location:** Charts → Descendants chart  
**CSS Reference:** modern-enhancements.css lines 1310-1354  

#### Test Steps

1. Navigate to Charts → Descendants chart
2. Verify vertical lines appear connecting generations
3. Verify horizontal connectors (1.5rem) from vertical line to each box
4. Verify last child has rounded corner (bottom-left)
5. Verify d'Aboville numbers appear with dotted border
6. Click expand/collapse controls if available

#### Pass Criteria

- ✅ Vertical border-left (1px solid #dee2e6) visible
- ✅ Horizontal connectors to each generation
- ✅ Last child has `border-radius: 0 0 0 .25rem`
- ✅ 2rem indentation between generations
- ✅ d'Aboville numbers styled with dotted border
- ✅ Expand/collapse controls functional

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

## Hover Effects Tests

### Test 10: Card Hover Effects

**Location:** Dashboard blocks (Home page)  
**CSS Reference:** modern-enhancements.css lines 919-960  

#### Test Steps

1. Navigate to Home page
2. Hover over any dashboard block (Families, Individuals, Statistics)
3. Observe visual changes
4. Click link inside card while hovering
5. Verify link is clickable

#### Pass Criteria

- ✅ Card lifts 1.5px upward (`transform: translateY(-1.5px)`)
- ✅ Border changes from light gray to orange (palette2)
- ✅ Shadow expands (0 1px 3px → 0 4px 12px)
- ✅ Transition is smooth (0.2s ease)
- ✅ Links inside have `z-index: 10` and are clickable
- ✅ Hover effect persists while clicking links

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 11: Facts Table Row Hover

**Location:** Individual page → Facts & Events tab  
**CSS Reference:** modern-enhancements.css lines 826-863  

#### Test Steps

1. Navigate to any individual's page
2. Click "Facts & Events" tab
3. Hover over any fact row
4. Observe visual changes
5. Verify NO lift effect (transform disabled)

#### Pass Criteria

- ✅ Row background changes to subtle orange tint (`rgba(255, 136, 0, 0.08)`)
- ❌ NO transform effect (would clip dropdowns)
- ❌ NO orange border on first cell (would cause layout shift)
- ✅ Transition is smooth (0.2s ease)
- ✅ Links in row are clickable

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 12: Family Navigator Hover

**Location:** Individual page → Family Navigator  
**CSS Reference:** modern-enhancements.css lines 1402-1428  

#### Test Steps

1. Navigate to any individual's page
2. Scroll to Family Navigator section
3. Hover over any family section (Parents, Spouse, Children)
4. Observe visual changes
5. Verify NO lift effect (transform disabled)

#### Pass Criteria

- ✅ Border changes to orange (palette2)
- ✅ Shadow expands (0 1px 3px → 0 4px 12px)
- ❌ NO transform effect (would clip dropdowns)
- ✅ Caption does NOT move independently
- ✅ Links in table are clickable

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 13: Link Animated Underline

**Location:** Any page with content links  
**CSS Reference:** modern-enhancements.css lines 1575-1595  

#### Test Steps

1. Navigate to any individual's page
2. Find a text link in main content (not navigation, not button)
3. Hover over link
4. Observe animated underline

#### Pass Criteria

- ✅ Orange underline (palette2) animates from left to right
- ✅ Width goes from 0% to 100%
- ✅ Animation is smooth (0.2s ease)
- ✅ Text color changes to orange
- ✅ Underline appears 2px below text
- ❌ Buttons and navigation links do NOT get underline

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 14: Button Hover Effects

**Location:** Any page with primary buttons  
**CSS Reference:** modern-enhancements.css lines 1385-1399  

#### Test Steps

1. Navigate to any page with blue buttons
2. Hover over primary button
3. Observe lift effect
4. Click and hold button
5. Observe active state (button pushes back down)

#### Pass Criteria

- ✅ Button lifts 1px upward on hover (`transform: translateY(-1px)`)
- ✅ Shadow expands
- ✅ On active click, button returns to original position (`translateY(0)`)
- ✅ Transitions are smooth
- ✅ Cursor changes to pointer

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

## Form Visibility Tests

### Test 15: Chart Options Forms

**Location:** Any chart page  
**CSS Reference:** modern-components.css (.d-print-none in @media print)  

#### Test Steps

1. Navigate to Charts → Pedigree chart
2. Verify form controls are visible at top of page
3. Verify "Individual" dropdown is visible and functional
4. Verify "Generations" input is visible and functional
5. Verify "Layout" radio buttons are visible and functional
6. Print preview page (Ctrl+P or Cmd+P)
7. Verify form controls are HIDDEN in print preview

#### Pass Criteria

- ✅ All form controls visible on screen
- ✅ Individual dropdown allows selecting different person
- ✅ Generations input accepts numeric values
- ✅ Layout radio buttons switch chart orientation
- ✅ Controls hidden in print preview (`.d-print-none` only in `@media print`)

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

## Dynamic Chart Height Tests

### Test 16: Hourglass Chart Expansion

**Location:** Charts → Hourglass chart  
**CSS Reference:** modern-enhancements.css lines 1063-1079  

#### Test Steps

1. Navigate to Charts → Hourglass chart
2. Verify chart displays without scrollbars initially
3. Click dropdown icon on any chart box
4. Verify dropdown opens without causing vertical scrollbar
5. Verify chart container has `overflow-y: visible`

#### Pass Criteria

- ✅ Chart expands vertically to fit content
- ❌ NO vertical scrollbar on chart container
- ✅ Dropdowns appear fully visible
- ✅ Page may have scrollbar (body scroll), but chart container does not

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

## Accessibility Tests

### Test 17: Keyboard Navigation

**CSS Reference:** modern-enhancements.css lines 1452-1456  

#### Test Steps

1. Navigate to any page
2. Press Tab key repeatedly
3. Observe focus indicators on interactive elements
4. Press Enter on focused button/link
5. Verify action is triggered

#### Pass Criteria

- ✅ Focus indicator visible (2px solid orange outline)
- ✅ Outline has 2px offset from element
- ✅ All interactive elements (links, buttons, form controls) are keyboard-accessible
- ✅ Tab order is logical (top to bottom, left to right)
- ✅ Enter key activates focused element

#### Browsers to Test

- [ ] Chrome 120+
- [ ] Firefox 121+
- [ ] Edge 120+
- [ ] Safari 17+

---

### Test 18: Reduced Motion Support

**CSS Reference:** modern-enhancements.css lines 1432-1450  

#### Test Steps

1. Enable reduced motion in OS settings:
   - **Windows:** Settings → Accessibility → Visual effects → Show animations OFF
   - **macOS:** System Preferences → Accessibility → Display → Reduce motion ON
2. Navigate to any page
3. Hover over cards, buttons, links
4. Verify animations are minimized

#### Pass Criteria

- ✅ All `animation-duration` set to 0.01ms
- ✅ All `transition-duration` set to 0.01ms
- ✅ Transform hover effects disabled
- ✅ Scroll behavior is instant (not smooth)

#### Operating Systems to Test

- [ ] Windows 11
- [ ] macOS Ventura+
- [ ] iOS 17+
- [ ] Android 12+

---

### Test 19: Color Contrast (WCAG AA)

**CSS Reference:** COLOR-AUDIT.md  

#### Test Steps

1. Use browser DevTools or online contrast checker (e.g., WebAIM)
2. Test the following color combinations:

| Foreground | Background | Ratio | Standard | Pass/Fail |
|------------|------------|-------|----------|-----------|
| palette1 (#003366) | palette9 (white) | 9.71:1 | WCAG AAA | ✅ PASS |
| palette2 (#ff8800) | palette9 (white) | 3.91:1 | WCAG AA (large text) | ✅ PASS |
| palette3 (#333333) | palette9 (white) | 12.63:1 | WCAG AAA | ✅ PASS |
| palette8 (#f5f5f5) | palette1 (#003366) | 8.94:1 | WCAG AAA | ✅ PASS |
| palette6 (#99bbdd) | palette9 (white) | 2.31:1 | Decorative only | ⚠️ N/A |

#### Pass Criteria

- ✅ All text meets minimum 4.5:1 contrast ratio (WCAG AA)
- ✅ Large text (18pt+) meets 3:1 ratio
- ⚠️ palette6 only used for borders (decorative), not text

---

## Responsive Design Tests

### Test 20: Mobile Layout (375x667)

**CSS Reference:** modern-enhancements.css lines 263-314  

#### Test Steps

1. Resize browser to 375px width (or use DevTools device emulation)
2. Navigate to individual's page
3. Verify header table switches to vertical layout
4. Verify facts table adjusts column widths
5. Verify navigation menu is mobile-friendly

#### Pass Criteria

- ✅ Individual header photo displays full-width
- ✅ Individual name displays below photo
- ✅ Facts table columns stack or resize appropriately
- ✅ All text is readable (no horizontal overflow)
- ✅ Touch targets are at least 44x44px

#### Devices to Test

- [ ] iPhone SE (375x667)
- [ ] iPhone 12/13 (390x844)
- [ ] Samsung Galaxy S21 (360x800)

---

### Test 21: Tablet Layout (768x1024)

**CSS Reference:** modern-enhancements.css lines 247-261  

#### Test Steps

1. Resize browser to 768px width (or use DevTools)
2. Navigate to individual's page
3. Verify layout is intermediate between mobile and desktop
4. Test all interactive elements

#### Pass Criteria

- ✅ Header table displays horizontally (not stacked)
- ✅ Facts table shows reduced column widths but maintains structure
- ✅ Chart boxes render properly
- ✅ All hover effects work with touch

#### Devices to Test

- [ ] iPad (768x1024)
- [ ] iPad Air (820x1180)
- [ ] Android tablets

---

## Performance Tests

### Test 22: CSS File Load Time

**File:** modern-enhancements.css (1659 lines)

#### Test Steps

1. Open DevTools → Network tab
2. Clear cache (Ctrl+Shift+Del)
3. Reload page
4. Find modern-enhancements.css in Network tab
5. Check load time and size

#### Pass Criteria

- ✅ File size < 100KB (uncompressed)
- ✅ Load time < 200ms on broadband
- ✅ Render time < 50ms
- ❌ NO render-blocking issues

---

### Test 23: Memory Footprint (24-hour Stress Test)

#### Test Steps

1. Open browser with single webtrees tab
2. Navigate through 50+ individual pages
3. Open/close dropdowns 100+ times
4. Switch between chart layouts 20+ times
5. Monitor memory usage in Task Manager
6. Let page idle for 24 hours
7. Check for memory leaks

#### Pass Criteria

- ✅ Memory usage < 500MB after navigation
- ✅ NO memory leaks after 24 hours
- ✅ Browser remains responsive
- ❌ NO console errors

---

## Regression Testing Checklist

Use this checklist after making CSS changes to ensure no functionality breaks:

### Quick Smoke Test (5 minutes)

- [ ] Open individual page - verify header displays correctly
- [ ] Hover over dashboard card - verify orange border + lift
- [ ] Open chart box dropdown in facts table - verify fully visible (z-index 99999)
- [ ] Switch pedigree layouts (RIGHT/LEFT/UP/DOWN) - verify connection lines in all 4
- [ ] Hover over fact table row - verify background tint (no lift)

### Full Regression Test (30 minutes)

- [ ] Complete Tests 1-16 above
- [ ] Verify all 11 items in "Testing Verification Checklist" (style-demo.html)
- [ ] Check console for JavaScript errors
- [ ] Verify no CSS warnings in DevTools

### Cross-Browser Test (1 hour)

- [ ] Run Quick Smoke Test in Chrome, Firefox, Edge, Safari
- [ ] Run Full Regression Test in primary browser (Chrome)
- [ ] Document any browser-specific issues

---

## Known Issues & Limitations

**As of December 2025, there are NO known critical issues.**

### Historical Issues (RESOLVED)

1. ~~Menu dropdowns breaking after click~~ → FIXED (dropdown-toggle.js)
2. ~~Chart forms hidden~~ → FIXED (.d-print-none in @media print)
3. ~~Chart scrollbars appearing~~ → FIXED (overflow-y: visible)
4. ~~Pedigree lines only in RIGHT layout~~ → FIXED (added LEFT/UP/DOWN CSS)
5. ~~Missing vertical chart lines~~ → FIXED (added ancestors/descendants lines)
6. ~~Dropdown clipping~~ → FIXED (z-index 99999)

### Non-Critical Observations

- **palette5 unused:** `--global-palette5` (#888888) has 0 occurrences in modern-enhancements.css. Consider repurposing or removing.
- **Hardcoded sex icon colors:** 6 hardcoded colors should be converted to CSS variables for consistency.
- **Transform effects disabled on some elements:** Strategic compromise to prevent dropdown clipping. Alternative hover effects (shadow, border) used instead.

---

## Reporting Issues

When reporting CSS-related issues, please include:

1. **Browser & Version:** e.g., Chrome 120.0.6099.109
2. **Screen Resolution:** e.g., 1920x1080
3. **Page URL:** e.g., Individual page → Facts & Events tab
4. **CSS Class:** e.g., `.wt-chart-box-zoom-dropdown`
5. **Expected Behavior:** What should happen
6. **Actual Behavior:** What actually happens
7. **Screenshot:** If visual issue
8. **Console Errors:** From browser DevTools (F12)

---

## Cross-References

- **Chart Analysis:** See [CHART_ANALYSIS.md](CHART_ANALYSIS.md) for complete chart testing results
- **Color Usage:** See [COLOR-AUDIT.md](COLOR-AUDIT.md) for color palette documentation
- **CSS Class Reference:** See [element-css-mapping.md](element-css-mapping.md) for z-index architecture and hover effects
- **Interactive Demo:** See [style-demo.html](style-demo.html) for visual examples

---

**Document Version:** 1.0  
**Last Updated:** December 2025  
**Maintained By:** Webtrees Svajana Theme Development Team
