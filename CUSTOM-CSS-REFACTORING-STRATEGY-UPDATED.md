# Custom.css Refactoring Strategy - WordPress Kadence Integration

**Date:** December 2, 2025  
**Branch:** phase/css-refactor-consolidation  
**Status:** 🔄 IN PROGRESS - Button variants completed (Phase 3), main refactoring pending  
**Goal:** Align svajana theme with WordPress Kadence theme using consistent --global-palette variables, adopt best Phase 2 styles while preserving preferred custom.css visual treatments

---

## ✅ COMPLETED WORK - DO NOT UNDO

### Phase 3: Button Variants Added (December 2, 2025)

**File Modified:** `resources/css/modern-enhancements.css`  
**Lines Added:** ~130 lines at end of file  
**Status:** ✅ COMPLETED

**Button variants now implemented in modern-enhancements.css:**
- `.btn-success` (Green) - Confirmations, save actions
- `.btn-danger` (Red) - Delete, destructive actions
- `.btn-warning` (Orange/Yellow) - Warnings, cautions
- `.btn-info` (Light Blue) - Informational actions
- `.btn-light` (Light gray) - Secondary/subtle actions
- `.btn-dark` (Dark gray) - Alternative prominent actions
- `.btn-sm`, `.btn-lg` - Size utilities
- `.btn-block` - Full-width button utility
- Enhanced disabled states with opacity and cursor management

**⚠️ IMPORTANT:** When implementing Step 2.3 and Step 3.1 of this document:
- **DO NOT delete button variants from modern-enhancements.css**
- **DO delete button overrides from custom.css lines 1155-1180** (they duplicate primary/secondary only)
- Button variants in modern-enhancements.css provide complete Bootstrap-compatible system
- This work is part of Phase 3 and should be preserved during Phase 2 improvements

**Documentation:** See `PHASE3-IMPLEMENTATION-PLAN.md` for complete implementation details

---

## Executive Summary

### Primary Objective 🎯

**Create seamless visual integration between WordPress Kadence theme and webtrees svajana theme** by:
1. Using identical `--global-palette1` through `--global-palette9` color variables across both platforms
2. Adopting Phase 2's cleaner architecture while preserving custom.css's preferred visual styles
3. Eliminating custom.css overrides by improving Phase 2 base styles directly
4. Reducing !important usage from 377 to <100 through better base style definitions

### The Integration Requirements

**WordPress Kadence Theme Uses:**
- `--global-palette1` through `--global-palette9` for all color theming
- Same variable names must be used in webtrees for consistency
- Users expect identical colors/styling when navigating between WordPress pages and webtrees

**Current State:**
- Both custom.css and Phase 2 (modern-enhancements.css) already use `--global-palette` variables extensively ✅
- Variable definitions are in custom.css :root block (lines 1-70)
- Phase 2 already references these variables (e.g., `--global-palette9` for backgrounds, `--global-palette6` for borders)

### Style Preferences - Best of Both Worlds 🎨

**Adopt from Phase 2:**
1. **Chart Boxes** (modern-enhancements.css lines 109-119):
   - Clean structure with `--global-palette9` background, `--global-palette6` border
   - **BUT:** Increase padding from 0.5rem → 1rem (custom.css preference)
   - **AND:** Softer shadow, possibly 8px radius (custom.css preference)
   - **AND:** Use only --global-palette colors (no hardcoded rgba values)

2. **Buttons** (modern-enhancements.css):
   - Clean Phase 2 button styles WITHOUT custom.css !important overrides
   - **DELETE custom.css lines 1155-1180** (button !important overrides)
   - Ensure Phase 2 buttons already use --global-palette1 (primary), --global-palette2 (hover)

**Preserve from custom.css:**
1. **Cards** (custom.css lines 1495-1525):
   - 8px border radius (softer than Phase 2's 6px)
   - `--global-palette8` borders (light gray)
   - Softer shadow: `0 2px 5px rgba(0, 0, 0, 0.05)` vs Phase 2's `0 1px 3px rgba(0, 0, 0, 0.06)`
   - **Move these preferences INTO Phase 2** (modern-enhancements.css)
   - Use only --global-palette colors throughout

### The Goal 🎯

**Improve Phase 2 (modern-enhancements.css) so custom.css overrides become unnecessary:**
- Update Phase 2 chart boxes with better padding/shadows
- Verify Phase 2 buttons use --global-palette colors cleanly
- Update Phase 2 cards to match custom.css preferred styling
- **THEN delete custom.css overrides** - they're no longer needed
- Result: Cleaner architecture, consistent --global-palette usage, seamless WordPress integration

---

## Phase 3: WordPress Integration & Phase 2 Improvement Plan

### Overview - NEW APPROACH

**Instead of splitting custom.css into modules, we'll:**
1. **Improve Phase 2 (modern-enhancements.css)** with preferred visual styles
2. **Delete custom.css overrides** that become redundant
3. **Keep --global-palette variable names** for WordPress Kadence compatibility
4. **Maintain custom.css** only for WordPress-specific integrations and necessary webtrees overrides

### Architecture After Refactoring

```
resources/css/
  ├── base.css                    (Foundation - unchanged)
  ├── webtrees-menus.css         (Navigation - unchanged)
  ├── custom.css                 (IMPROVED: Variables + WordPress + necessary overrides only)
  ├── modern-components.css      (Components - unchanged)
  ├── modern-enhancements.css    (IMPROVED: Better chart boxes, cards with custom.css preferences)
  └── customizations/
      └── enable-icons.css       (Icons - unchanged)
```

**Key Changes:**
- Phase 2 (modern-enhancements.css) becomes the "source of truth" for component styling
- custom.css keeps: `:root` variables, WordPress Kadence integration, necessary !important overrides
- custom.css LOSES: Component overrides that are now properly handled in Phase 2

---

## STEP 1: Audit & Identify Targets (1 hour)

### 1.1 Specific Deletions from custom.css

**After Phase 2 improvements, DELETE these custom.css sections:**

| Section | Lines | Reason | Safety | Status |
|---------|-------|--------|--------|--------|
| Button overrides (.btn-primary, .btn-secondary) | 1155-1180 | modern-enhancements.css has complete button system (Phase 3 ✅) | ✅ Safe - buttons in modern-enhancements.css | 🔄 Ready to delete |
| Chart box overrides | ~1084+ | Phase 2 improved with padding/shadow | ✅ Safe - test charts | ⏳ Pending Step 2.1 |
| Card style duplicates | TBD | Phase 2 updated with 8px radius/soft shadow | ✅ Safe - test cards | ⏳ Pending Step 2.2 |

**Estimated deletions:** 200-400 lines

**⚠️ NOTE:** Button variants in modern-enhancements.css (Phase 3 work) should NOT be deleted - they provide the complete Bootstrap-compatible system (success, danger, warning, info, light, dark + utilities)

### 1.2 Keep in custom.css

**MUST KEEP these sections:**

1. **:root variables** (lines 1-70): 
   - `--global-palette1` through `--global-palette9` definitions
   - Semantic variables (`--sex-male`, `--sex-female`, etc.)
   - Typography variables (Kadence compatibility)
   - **REASON:** WordPress Kadence theme requires these exact variable names

2. **WordPress-specific integrations**:
   - Kadence header compatibility
   - WordPress widget styling
   - Block editor overrides
   - **REASON:** Only applies to WordPress pages, not webtrees core

3. **Necessary !important overrides**:
   - Icon visibility fixes (Font Awesome conflicts)
   - Webtrees core conflicts that can't be resolved with specificity
   - Accessibility overrides (focus states)
   - **REASON:** Required for functionality/accessibility

---

## STEP 2: Improve Phase 2 (modern-enhancements.css) - 2-3 hours

### 2.1 Chart Boxes - Lines 109-119

**Current Phase 2 (modern-enhancements.css):**
```css
.wt-chart-box {
    background: var(--global-palette9);
    border: 1px solid var(--global-palette6);
    border-radius: 6px;
    padding: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
```

**UPDATE TO (custom.css preferences):**
```css
.wt-chart-box {
    background: var(--global-palette9);
    border: 1px solid var(--global-palette6);
    border-radius: 8px;                              /* 6px → 8px (softer) */
    padding: 1rem;                                   /* 0.5rem → 1rem (more spacious) */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);      /* Softer shadow */
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.wt-chart-box:hover {
    transform: translateY(-1.5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}
```

**Changes:**
- ✅ Padding: 0.5rem → 1rem (better touch targets, more comfortable)
- ✅ Border radius: 6px → 8px (softer aesthetic)
- ✅ Shadow: Slightly softer and more prominent
- ✅ Keeps --global-palette9 (white) background and --global-palette6 (light blue) border

---

### 2.2 Cards - Lines 899-909

**Current Phase 2 (modern-enhancements.css):**
```css
.card {
    border-radius: 6px !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06) !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
}
```

**UPDATE TO (custom.css preferences):**
```css
.card {
    background-color: var(--global-palette9);        /* Explicit white background */
    border-radius: 8px !important;                   /* 6px → 8px (softer) */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05) !important;  /* Softer shadow */
    border: 1px solid var(--global-palette8) !important;   /* Use palette8 (light gray) */
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
}

.card:hover,
.wt-ajax-load:hover > .card {
    transform: translateY(-1.5px) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    border-color: var(--global-palette2) !important;  /* Orange hover accent */
}

.card-header {
    color: var(--global-palette1);                   /* Navy text */
    background-color: var(--global-palette9);        /* White background */
    border-bottom: 1px solid var(--global-palette8); /* Light gray divider */
}
```

**Changes:**
- ✅ Border radius: 6px → 8px (softer aesthetic)
- ✅ Shadow: 0 1px 3px → 0 2px 5px (softer, more prominent)
- ✅ Border: Uses `--global-palette8` instead of `rgba(0, 0, 0, 0.08)`
- ✅ Explicit white background with `--global-palette9`
- ✅ Card header uses navy (`--global-palette1`) text
- ✅ Hover effect uses orange (`--global-palette2`) border accent

---

### 2.3 Buttons - ✅ COMPLETED (Phase 3)

**STATUS:** ✅ Button variants already added to modern-enhancements.css

**What was implemented:**
- Complete Bootstrap-compatible button system added to modern-enhancements.css
- Includes `.btn-primary`, `.btn-secondary`, `.btn-success`, `.btn-danger`, `.btn-warning`, `.btn-info`, `.btn-light`, `.btn-dark`
- Size utilities: `.btn-sm`, `.btn-lg`
- Block utility: `.btn-block`
- Enhanced disabled states
- All buttons use --global-palette colors (palette1 for primary, palette2 for hover)
- Clean implementation without !important where possible

**ACTION REQUIRED:** 
- ✅ **SKIP** adding button styles to Phase 2 (already done)
- ✅ **PROCEED** to Step 3.1 - Delete custom.css button overrides (lines 1155-1180)
- ⚠️ **DO NOT** delete button variants from modern-enhancements.css (needed for complete system)

**See:** `PHASE3-IMPLEMENTATION-PLAN.md` for complete documentation

---

## STEP 3: Delete Redundant custom.css Overrides (30 minutes)

### 3.1 Button Overrides - Lines 1155-1180 ✅ READY TO DELETE

**STATUS:** ✅ Phase 3 button variants completed - safe to delete custom.css overrides

**After verifying modern-enhancements.css has button system (✅ VERIFIED), DELETE:**

```css
/* DELETE THIS ENTIRE BLOCK FROM custom.css */
.btn-primary {
    color: var(--global-palette9) !important;
    background-color: var(--global-palette1) !important;
    border-color: var(--global-palette1) !important;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: var(--global-palette2) !important;
    border-color: var(--global-palette2) !important;
}

/* Also delete .btn-secondary overrides if present */
```

**Why safe to delete:** 
- modern-enhancements.css now has complete button system (8 variants + utilities)
- Includes `.btn-primary` and `.btn-secondary` that custom.css was overriding
- Uses --global-palette colors throughout
- Cleaner implementation without excessive !important

**⚠️ IMPORTANT:** Only delete button overrides from custom.css, NOT the button variants in modern-enhancements.css

---

### 3.2 Chart Box Overrides

**Search custom.css for `.wt-chart-box` and DELETE duplicate definitions.**

**Why safe to delete:** Phase 2 now has improved chart boxes with preferred padding/shadow/radius.

---

### 3.3 Card Overrides - After Phase 2 Update

**After updating Phase 2 cards (Step 2.2), search custom.css for card overrides and DELETE:**

```css
/* DELETE sections that duplicate Phase 2 card styling */
.card {
    background-color: var(--global-palette9);
    border: 1px solid var(--global-palette8);
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}
```

**Why safe to delete:** Phase 2 now has these exact styles.

---

### 3.4 Audit for Other Duplicates

**Process:**
1. Open custom.css
2. For each major selector (`.card`, `.btn`, `.wt-chart-box`, `.table`, etc.):
   - Check if Phase 2 has equivalent/better styling
   - If YES → Delete from custom.css
   - If NO → Keep in custom.css
3. Document any kept overrides with comments explaining WHY

---

## STEP 4: Testing Protocol (2-3 hours)

### 4.1 Component-Specific Testing

**Test each improved component:**

| Component | Test Page | Check Items | Status |
|-----------|-----------|-------------|--------|
| Chart Boxes | Pedigree chart, Family chart | Padding 1rem, radius 8px, soft shadow, --palette9 bg | ⏳ Pending |
| Cards | Home page dashboard, Lists | Radius 8px, --palette8 border, soft shadow, hover effect | ⏳ Pending |
| Buttons | All pages with forms | --palette1 bg, --palette2 hover, 8 variants working, sizes working | ✅ Phase 3 complete - test after custom.css cleanup |
| Button Variants | Forms, modals | All 8 variants (.btn-success through .btn-dark) render correctly | ✅ Phase 3 complete |
| Button Utilities | Various contexts | .btn-sm, .btn-lg, .btn-block work correctly | ✅ Phase 3 complete |
| Card Headers | Statistics blocks | Navy text (--palette1), white bg, light gray divider | ⏳ Pending |

### 4.2 WordPress Integration Testing

**Test on WordPress pages (if integrated):**
- [ ] Kadence header matches webtrees header colors
- [ ] --global-palette colors consistent across WP and webtrees
- [ ] Navigation transitions smoothly between WordPress/webtrees
- [ ] Typography matches (font families, weights)

### 4.3 Visual Regression Testing

**Compare before/after on key pages:**

| Page Type | Pre-Refactor Screenshot | Post-Refactor Screenshot | Match? |
|-----------|------------------------|--------------------------|--------|
| Individual Page | Take screenshot | Take screenshot | [ ] |
| Pedigree Chart | Take screenshot | Take screenshot | [ ] |
| Home Dashboard | Take screenshot | Take screenshot | [ ] |
| Lists (Individuals) | Take screenshot | Take screenshot | [ ] |

**Tool suggestion:** Use browser DevTools screenshot feature or Windows Snipping Tool.

### 4.4 Cross-Browser Testing

Test on:
- [ ] Chrome/Edge (Windows) - Primary browser
- [ ] Firefox (Windows)
- [ ] Safari (Mac/iOS) - if available
- [ ] Mobile Chrome (Android)

### 4.5 Responsive Testing

Test at breakpoints:
- [ ] 320px (Small mobile)
- [ ] 768px (Tablet)
- [ ] 1024px (Small desktop)
- [ ] 1440px (Desktop)
- [ ] 1920px+ (Large desktop)

**Focus on:**
- Chart box spacing/readability
- Card layouts
- Button sizes (touch targets)

---

## STEP 5: Git Workflow (2-3 commits)

### 5.1 Commit Strategy - Separate Improvements

**✅ COMPLETED - Phase 3 (December 2, 2025):**
```powershell
# Already committed - DO NOT UNDO
# Added complete button variant system to modern-enhancements.css
# See: PHASE3-IMPLEMENTATION-PLAN.md
```

**Commit 1: Improve Phase 2 Chart Boxes**
```powershell
git add resources/css/modern-enhancements.css
git commit -m "feat(css): Improve chart boxes - 8px radius, 1rem padding, softer shadows"
```

**Commit 2: Improve Phase 2 Cards**
```powershell
git add resources/css/modern-enhancements.css
git commit -m "feat(css): Update card styling - 8px radius, --global-palette8 borders, soft shadows"
```

**Commit 3: Delete Redundant custom.css Overrides**
```powershell
git add resources/css/custom.css
git commit -m "refactor(css): Remove button/chart/card overrides (now handled in modern-enhancements.css)

- Remove button overrides (lines 1155-1180) - now in modern-enhancements.css with complete variant system
- Remove chart box overrides - improved in modern-enhancements.css
- Remove card overrides - improved in modern-enhancements.css
- Preserve WordPress Kadence integration styles
- Preserve necessary !important overrides"
```

### 5.2 Testing Checkpoint Commits

After each commit, test thoroughly:

```powershell
# After commit 1
git tag -a checkpoint-chart-boxes -m "Chart boxes improved and tested"

# After commit 2
git tag -a checkpoint-cards -m "Cards improved and tested"

# After commit 3
git tag -a checkpoint-cleanup -m "Redundant overrides removed and tested"
```

---

## STEP 6: Rollback Plan (Safety Net)

### 6.1 If Visual Regression Occurs

**Option 1: Revert Single Commit**
```powershell
git revert <commit-hash>  # Revert specific commit
```

**Option 2: Roll Back to Checkpoint**
```powershell
git reset --hard checkpoint-chart-boxes  # Go back to safe checkpoint
```

**Option 3: Full Rollback**
```powershell
git checkout phase/css-refactor-consolidation  # Abandon changes, restart
```

---

## STEP 7: Documentation Updates (30 minutes)

### 7.1 Update IMPLEMENTATION_SUMMARY.md

Add section documenting WordPress integration:

```markdown
## WordPress Kadence Theme Integration

### Color Palette Alignment

The svajana theme uses `--global-palette1` through `--global-palette9` CSS variables that match the WordPress Kadence theme. This ensures seamless visual integration when webtrees is embedded in or linked from a WordPress site.

**Palette Mapping:**
- `--global-palette1`: Navy (#003366) - Primary brand color
- `--global-palette2`: Orange (#ff8800) - Secondary/accent color
- `--global-palette3-5`: Grayscale variants
- `--global-palette6`: Light blue (#99bbdd) - Borders, subtle accents
- `--global-palette7`: Very light blue (#ebf5ff) - Backgrounds
- `--global-palette8`: Light gray (#f5f5f5) - Card borders, dividers
- `--global-palette9`: White (#ffffff) - Backgrounds, text on dark

### Maintaining Integration

When customizing colors:
1. Update `:root` variables in `custom.css` (lines 1-70)
2. Update corresponding Kadence theme palette in WordPress Customizer
3. Test both WordPress and webtrees pages for consistency
```

### 7.2 Update This Strategy Document

Mark as COMPLETED with date and outcomes.

---

## Risk Assessment & Mitigation

### LOW RISK Changes ✅

1. **Increasing padding** (0.5rem → 1rem on chart boxes)
   - **Risk:** Minimal - may require slight layout adjustments
   - **Mitigation:** Test on various chart types
   
2. **Increasing border radius** (6px → 8px)
   - **Risk:** None - purely aesthetic
   - **Mitigation:** Visual comparison before/after

3. **Adjusting shadows** (softer, more prominent)
   - **Risk:** Minimal - may affect perceived depth
   - **Mitigation:** Test on light/dark backgrounds

4. **Replacing hardcoded colors with --global-palette**
   - **Risk:** Minimal - same visual result
   - **Mitigation:** Verify color values match exactly

### MEDIUM RISK Changes ⚠️

1. **Deleting button !important overrides** (custom.css lines 1155-1180)
   - **Risk:** Buttons may revert to webtrees default colors
   - **Mitigation:** Verify Phase 2 buttons already use --global-palette1/2
   - **Rollback:** Easy - restore deleted lines

2. **Deleting chart box overrides**
   - **Risk:** Charts may look different from current design
   - **Mitigation:** Thoroughly test all chart types after Phase 2 update
   - **Rollback:** Easy - restore from git

### Zero RISK - Already Verified ✅

1. **--global-palette variables are already in use**
   - Both Phase 2 and custom.css already reference these variables
   - No compatibility issues expected

2. **Phase 2 already has good base structure**
   - Chart boxes, cards already defined with clean code
   - We're enhancing, not rewriting

---

## Success Criteria

**Before marking this refactoring as COMPLETE:**

### Phase 3 (Button Variants) - ✅ COMPLETED
- [x] Button variant system added to modern-enhancements.css (8 variants + utilities)
- [x] Button styles use --global-palette colors throughout
- [x] Documentation created (PHASE3-IMPLEMENTATION-PLAN.md)

### Phase 2 Improvements - ⏳ PENDING
- [ ] Chart boxes improved in modern-enhancements.css (8px radius, 1rem padding, softer shadows)
- [ ] Cards improved in modern-enhancements.css (8px radius, --global-palette8 borders, soft shadows)
- [ ] custom.css button overrides deleted (lines 1155-1180) ✅ Ready after Phase 3
- [ ] custom.css chart/card overrides deleted (after Phase 2 improvements complete)

### Testing & Validation - ⏳ PENDING
- [ ] All visual regression tests pass (8 page types)
- [ ] Button variants tested across all form types
- [ ] Cross-browser testing complete (4+ browsers)
- [ ] Responsive testing complete (5 breakpoints)
- [ ] WordPress integration tested (if applicable)

### Final Cleanup - ⏳ PENDING
- [ ] !important count reduced to <100
- [ ] Git commits properly documented with tags
- [ ] IMPLEMENTATION_SUMMARY.md updated with WordPress integration docs
- [ ] This strategy document marked COMPLETED

---

## Timeline Estimate

| Phase | Duration | Cumulative |
|-------|----------|------------|
| **Audit & Identify Targets** | 1 hour | 1 hour |
| **Improve Phase 2 Components** | 2-3 hours | 3-4 hours |
| **Delete Redundant Overrides** | 30 min | 4-4.5 hours |
| **Testing** | 2-3 hours | 6-7.5 hours |
| **Documentation** | 30 min | 6.5-8 hours |

**Total:** ~7-8 hours of focused work

**Suggested Schedule:**
- **Session 1 (2-3 hours):** Audit, improve Phase 2 chart boxes and cards
- **Session 2 (2 hours):** Delete custom.css overrides, test components
- **Session 3 (2-3 hours):** Comprehensive testing, documentation

---

## Conclusion

**This refactoring is LOW RISK because:**

1. ✅ We're IMPROVING Phase 2 first, then deleting custom.css overrides
2. ✅ --global-palette variables already in use - no compatibility issues
3. ✅ Small, testable commits with git checkpoints
4. ✅ Easy rollback at any point
5. ✅ Visual design stays nearly identical
6. ✅ WordPress Kadence integration is PRIMARY goal - variables already match
7. ✅ Testing protocol covers all scenarios

**Benefits:**
- 📉 Reduced custom.css size (200-400 lines deleted)
- 📉 Reduced !important usage (from 377 to <100)
- 📈 Improved code maintainability
- 📈 Seamless WordPress Kadence integration
- 📈 Cleaner architecture (Phase 2 as source of truth)
- 📈 Better documentation

**The theme will look virtually identical but be FAR easier to maintain and integrate with WordPress.**

---

## Next Steps

**Progress Update (December 2, 2025):**

### ✅ COMPLETED
1. ✅ **Phase 3: Button variants added** - Complete Bootstrap-compatible button system in modern-enhancements.css
   - See `PHASE3-IMPLEMENTATION-PLAN.md` for details
   - 8 button variants (success, danger, warning, info, light, dark + primary, secondary)
   - Size utilities (.btn-sm, .btn-lg)
   - Block utility (.btn-block)
   - Enhanced disabled states

### 🔄 READY TO PROCEED
2. ✅ **Review this updated strategy** - Confirmed - button work already done
3. ✅ **Verify Phase 2 button implementation** - VERIFIED - modern-enhancements.css has complete system
4. ⏳ **Update Phase 2 chart boxes** - NEXT STEP - Increase padding, softer shadow, 8px radius
5. ⏳ **Update Phase 2 cards** - NEXT STEP - 8px radius, --global-palette8 borders, softer shadows
6. ⏳ **Delete custom.css overrides** - READY - Remove redundant button overrides (lines 1155-1180), then chart/card styles after improvements
7. ⏳ **Test thoroughly** - All page types, browsers, breakpoints
8. ⏳ **Document WordPress integration** - Update IMPLEMENTATION_SUMMARY.md

**Questions Resolved:**

1. ✅ Proceeding with WordPress-focused approach
2. ✅ Phase 3 button implementation verified and complete
3. 🔄 Ready for review after each Phase 2 improvement (commit by commit)
4. 🔄 Visual comparison screenshots recommended before/after

**Ready to proceed with Step 2.1 (Chart Boxes) and Step 2.2 (Cards) after your review! 🚀**

**⚠️ CRITICAL REMINDER:** 
- Do NOT delete button variants from modern-enhancements.css
- Do DELETE button overrides from custom.css lines 1155-1180
- Button work is complete and should be preserved
