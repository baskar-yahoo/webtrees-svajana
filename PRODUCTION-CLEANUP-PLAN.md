# Webtrees-Svajana Module - Production Cleanup Plan

**Date**: February 4, 2026  
**Module**: webtrees-svajana (Theme Module)  
**Current Status**: 50 total files (16 root files + 34 resource files)  
**Target**: Clean production structure with archived reference documentation

---

## Current File Analysis

### Root-Level Files (16 files)

#### 🟢 **PRODUCTION FILES (3 files - KEEP)**
These are essential for module operation:

1. **module.php** (0 KB) - Module registration file
2. **WebtreesSvajana.php** (24 KB) - Core theme module with menu filtering
3. **README.md** (2 KB) - Essential user documentation

#### 🟡 **PRODUCTION DOCUMENTATION (1 file - KEEP)**
Recently created, essential for configuration:

4. **MENU-FILTERING-GUIDE.md** (6 KB) - WordPress menu CSS class configuration

#### 🔴 **ARCHIVE CANDIDATES (11 files - 278 KB total)**
Development/analysis documentation - valuable for reference but not needed in production:

1. **CHART_ANALYSIS.md** (17 KB) - Chart styling analysis
2. **COLOR-AUDIT.md** (14 KB) - Color palette audit
3. **css-review-next-steps.md** (6 KB) - CSS refactoring notes
4. **CUSTOM-AG-ANALYSIS.md** (15 KB) - Custom AG theme analysis
5. **custom-ag-vs-custom-comparison.html** (34 KB) - Theme comparison demo
6. **CUSTOM-CSS-REFACTORING-STRATEGY-UPDATED.md** (25 KB) - CSS refactoring strategy
7. **element-css-mapping.md** (46 KB) - Element-to-CSS mapping reference
8. **IMPLEMENTATION_SUMMARY.md** (26 KB) - Implementation notes
9. **PHASE3-IMPLEMENTATION-PLAN.md** (9 KB) - Future development plan
10. **PR_BODY_PHASE2.md** (2 KB) - Pull request template
11. **style-demo.html** (61 KB) - Style testing demo
12. **TESTING-CHECKLIST.md** (23 KB) - Testing procedures

#### 🟢 **RESOURCES FOLDER (34 files - KEEP ALL)**
All production assets required for theme operation:
- **css/** - 7 CSS files (base, custom, modern-components, etc.)
- **fonts/** - Font Awesome files
- **js/** - 2 JavaScript files (dropdown-toggle.js, theme.js)
- **views/** - 25 template files (.phtml)

---

## Cleanup Actions

### Action 1: Create Archive Directory
```powershell
New-Item -ItemType Directory -Path "archive" -Force
```

### Action 2: Move Reference Documentation (11 files)
```powershell
$archiveFiles = @(
    'CHART_ANALYSIS.md',
    'COLOR-AUDIT.md',
    'css-review-next-steps.md',
    'CUSTOM-AG-ANALYSIS.md',
    'custom-ag-vs-custom-comparison.html',
    'CUSTOM-CSS-REFACTORING-STRATEGY-UPDATED.md',
    'element-css-mapping.md',
    'IMPLEMENTATION_SUMMARY.md',
    'PHASE3-IMPLEMENTATION-PLAN.md',
    'PR_BODY_PHASE2.md',
    'style-demo.html',
    'TESTING-CHECKLIST.md'
)

foreach ($file in $archiveFiles) {
    Move-Item -Path $file -Destination "archive\" -Force
}
```

### Action 3: Update .gitignore
Add exclusion for archive directory:
```gitignore
# Local reference documentation (not for version control)
/archive/
```

---

## Final Structure (After Cleanup)

### Production Files Only (39 files)
```
webtrees-svajana/
├── .gitignore (updated)
├── module.php
├── WebtreesSvajana.php
├── README.md
├── MENU-FILTERING-GUIDE.md
├── archive/ (11 reference docs - excluded from git)
│   ├── CHART_ANALYSIS.md
│   ├── COLOR-AUDIT.md
│   ├── css-review-next-steps.md
│   ├── CUSTOM-AG-ANALYSIS.md
│   ├── custom-ag-vs-custom-comparison.html
│   ├── CUSTOM-CSS-REFACTORING-STRATEGY-UPDATED.md
│   ├── element-css-mapping.md
│   ├── IMPLEMENTATION_SUMMARY.md
│   ├── PHASE3-IMPLEMENTATION-PLAN.md
│   ├── PR_BODY_PHASE2.md
│   ├── style-demo.html
│   └── TESTING-CHECKLIST.md
└── resources/
    ├── css/ (7 files)
    ├── fonts/ (Font Awesome files)
    ├── js/ (2 files)
    └── views/ (25 template files)
```

---

## Git Impact Summary

### Before Cleanup
- **Total tracked files**: 50 files
- **Root markdown/HTML files**: 16 files
- **Documentation overhead**: ~278 KB of reference docs mixed with production code

### After Cleanup
- **Total tracked files**: 39 files (22% reduction)
- **Root files**: 5 essential files only
- **Clean separation**: Production code vs. local reference documentation

### Git Changes Expected
```
Changes to be committed:
  modified:   .gitignore
  deleted:    CHART_ANALYSIS.md
  deleted:    COLOR-AUDIT.md
  deleted:    css-review-next-steps.md
  deleted:    CUSTOM-AG-ANALYSIS.md
  deleted:    custom-ag-vs-custom-comparison.html
  deleted:    CUSTOM-CSS-REFACTORING-STRATEGY-UPDATED.md
  deleted:    element-css-mapping.md
  deleted:    IMPLEMENTATION_SUMMARY.md
  deleted:    PHASE3-IMPLEMENTATION-PLAN.md
  deleted:    PR_BODY_PHASE2.md
  deleted:    style-demo.html
  deleted:    TESTING-CHECKLIST.md
```

---

## Recommended Git Commit Messages

### Single Comprehensive Commit
```
chore: archive reference documentation for cleaner production structure

- Move 11 development/analysis docs to archive/ directory
- Update .gitignore to exclude archive/ from version control
- Retain 4 essential production files (module.php, WebtreesSvajana.php, README.md, MENU-FILTERING-GUIDE.md)
- Preserve all resources/ folder for theme operation
- Reduces tracked files from 50 to 39 (22% reduction)
- Improves repository cleanliness while maintaining local reference access

Files archived (278 KB total):
- CSS analysis docs (CHART_ANALYSIS.md, COLOR-AUDIT.md, etc.)
- Implementation notes (IMPLEMENTATION_SUMMARY.md, PHASE3-IMPLEMENTATION-PLAN.md)
- Testing artifacts (style-demo.html, TESTING-CHECKLIST.md, custom-ag-vs-custom-comparison.html)
```

---

## Benefits of This Cleanup

### 1. **Repository Cleanliness**
- Clear distinction between production code and development notes
- Easier for new developers to identify essential files
- Reduced clutter in root directory

### 2. **Preserved Local Reference**
- All analysis documents remain accessible in `archive/`
- No information loss - just better organization
- Can be referenced when needed for future development

### 3. **Git Efficiency**
- 22% fewer tracked files (50 → 39)
- Smaller repository size for clones
- Faster git operations
- Cleaner git logs

### 4. **Professional Structure**
- Production-ready appearance
- Clear file purpose (no confusion about what's needed vs. what's reference)
- Follows best practices for module distribution

### 5. **Maintenance Benefits**
- Essential files immediately identifiable
- No accidentally editing archived documentation
- Clear separation for deployment scripts

---

## Verification Steps

After running cleanup commands:

```powershell
# Verify archive directory
Get-ChildItem archive\ | Select-Object Name

# Verify production root files
Get-ChildItem -File | Where-Object { $_.Name -notlike '.git*' } | Select-Object Name

# Verify resources intact
Get-ChildItem resources\ -Recurse -File | Measure-Object | Select-Object Count

# Check git status
git status
```

Expected results:
- ✅ 11 files in archive/
- ✅ 5 files in root (module.php, WebtreesSvajana.php, README.md, MENU-FILTERING-GUIDE.md, .gitignore)
- ✅ 34 files in resources/
- ✅ Git shows 12 deletions (11 docs + .gitignore modification)

---

## Notes

### What This Cleanup Does NOT Touch
- **resources/** folder - Completely untouched (all CSS, JS, fonts, views preserved)
- **module.php** - Essential module registration
- **WebtreesSvajana.php** - Core theme module with menu filtering
- **README.md** - User-facing documentation
- **MENU-FILTERING-GUIDE.md** - WordPress configuration guide (recently created)

### Archive Access
Files in `archive/` remain accessible for:
- Future CSS refactoring reference
- Understanding implementation decisions
- Testing procedures documentation
- Color palette decisions
- Element mapping reference

### No Data Loss
This is pure reorganization - no files deleted, only moved to `archive/` and excluded from git tracking.

---

## Execution Checklist

- [ ] Create `archive/` directory
- [ ] Move 11 reference documentation files
- [ ] Update `.gitignore` with `/archive/`
- [ ] Verify resources/ folder untouched
- [ ] Run `git status` to confirm changes
- [ ] Review git diff for .gitignore
- [ ] Commit changes with descriptive message
- [ ] Verify module still loads correctly in Webtrees

---

**Status**: Ready for execution  
**Risk Level**: Low (no production code affected, only organizational changes)  
**Rollback**: Simple - `git restore` the moved files if needed before commit
