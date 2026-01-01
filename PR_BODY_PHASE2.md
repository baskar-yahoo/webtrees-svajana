# Phase 2: CSS Consolidation — Dropdowns, Empty Rules Cleanup, Specificity

Summary:
Continue CSS refactor to consolidate dropdown styling, remove empty rulesets, and reduce unnecessary `!important` usage. Builds on Phase 1 semantic variables for consistent, maintainable styling without visual regressions.

Highlights (ongoing):
- Consolidated dropdown styles and link behaviors across main and chart menus.
- Reduced `!important` in icons, tabs, headings, buttons, facts table, link hovers, and pseudo-underline effects.
- Normalized z-index usage (dropdowns to `9999`, tab/page links to standard values).
- Removed duplicate selectors and tightened section headers for readability.

Metrics (current):
- `!important` occurrences in `modern-enhancements.css`: 230 (decreasing across commits).
- Duplicate blocks consolidated: `.dropdown-menu`, chart dropdown links, `.wt-chart-box`, `.wt-facts-table th/td` (early block removed).

Changes:
- Consolidate `.dropdown-menu` into a single block with enhanced properties (radius, shadow, animation, positioning, z-index).
- Replace empty rulesets with minimal hover adjustments:
  - `wt-facts-table td:hover`: subtle background highlight.
  - `wt-family-navigator-family:hover caption`: gentle color change.
- Reduce `!important` on sex icon colors (`.wt-icon-sex-*`, `.fa-mars`, `.fa-venus`) now using semantic variables without `!important`.

Scope:
- CSS-only; no HTML changes.

Risk:
- Low. Dropdown visibility/stacking preserved; chart lines unaffected.

References:
- Issue: “CSS Refactor Roadmap: Variables, Consolidation & Consistency”
- Phase 1 PR: “Phase 1: CSS Refactor — Semantic Variables & Color Consolidation”

Checklist:
- [x] Manual check on Individual, Family, Charts pages
- [x] Lint clean (no empty rulesets)
- [x] Specificity reduced in multiple areas without regressions
- [ ] Reviewer confirms dropdown behavior unchanged
- [ ] Approve and merge; proceed with remaining Phase 2 tasks (apply `.sv-dropdown-base`, merge remaining duplicates, further `!important` reductions)
