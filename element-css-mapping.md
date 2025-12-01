# Webtrees Svajana Theme - Element/CSS Mapping Document

**Version:** 1.0  
**Date:** November 29, 2025  
**Purpose:** Complete mapping of page components, HTML elements, CSS classes, and template files for testing and debugging

---

## Table of Contents

1. [Page Structure Overview](#page-structure-overview)
2. [My Page (User Dashboard)](#my-page-user-dashboard)
3. [Individual Page](#individual-page)
4. [Dashboard Blocks](#dashboard-blocks)
5. [Charts](#charts)
6. [CSS Class Reference](#css-class-reference)
7. [Testing Quick Reference](#testing-quick-reference)

---

## Page Structure Overview

```
┌─────────────────────────────────────────────────────────────┐
│                        HEADER/NAV                           │
└─────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────┐
│                     PAGE CONTENT                            │
│  ┌──────────────────────────┬─────────────────────────┐     │
│  │   MAIN CONTENT           │   SIDEBAR               │     │
│  │   (Facts, Charts, etc)   │   (Navigator, Blocks)   │     │
│  └──────────────────────────┴─────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

---

## My Page (User Dashboard)

### **Page Location:** `/index.php?route=%2F{tree}/user-page`

### **Template Files:**
- **Main:** `resources/views/user-page.phtml`
- **Block Wrapper:** `resources/views/user-page-block.phtml`
- **Block Content:** `resources/views/modules/block-template.phtml`

### **HTML Structure:**

```html
<div class="row">
    <!-- Main Blocks (Left Column) -->
    <div class="col-md-8 wt-main-blocks">
        <!-- Block Wrapper (dynamically loaded via AJAX) -->
        <div class="wt-ajax-load" data-wt-ajax-url="...">
            <!-- Actual Block Content (loaded asynchronously) -->
            <div class="card mb-4 wt-block wt-block-{blockname}" id="block-{id}">
                <div class="card-header wt-block-header wt-block-header-{blockname}">
                    Block Title
                </div>
                <div class="card-body wt-block-content wt-block-content-{blockname}">
                    Block Content Here
                </div>
            </div>
        </div>
    </div>
    
    <!-- Side Blocks (Right Column) -->
    <div class="col-md-4 wt-side-blocks">
        <!-- Same structure as main blocks -->
    </div>
</div>
```

### **CSS Classes:**

| CSS Class | Element | Hover Behavior | Template File |
|-----------|---------|----------------|---------------|
| `.wt-main-blocks` | Main column container | None | `user-page.phtml` |
| `.wt-side-blocks` | Sidebar column | None | `user-page.phtml` |
| `.wt-ajax-load` | AJAX loading wrapper | None | `user-page-block.phtml` |
| `.card.wt-block` | **Block container** | ✅ Orange border + lift | `modules/block-template.phtml` |
| `.card-header.wt-block-header` | Block header bar | None (part of parent hover) | `modules/block-template.phtml` |
| `.card-body.wt-block-content` | Block content area | None (part of parent hover) | `modules/block-template.phtml` |
| `.wt-block-{name}` | Specific block type | N/A (modifier) | `modules/block-template.phtml` |

### **Common Blocks on My Page:**

1. **Statistics Block** (`wt-block-gedcom-stats`)
2. **Slideshow Block** (`wt-block-random-media`)
3. **On This Day Block** (`wt-block-todays-events`)
4. **Favorites Block** (`wt-block-user-favorites`)
5. **HTML Block** (`wt-block-html`)

### **Visual Layout:**

```
┌─────────────────────────────────────────────────────────────┐
│  MY PAGE                                                     │
├────────────────────────────────┬────────────────────────────┤
│ MAIN BLOCKS (col-md-8)         │ SIDE BLOCKS (col-md-4)     │
├────────────────────────────────┤                            │
│ ┌────────────────────────────┐ │ ┌────────────────────────┐ │
│ │ .card.wt-block             │ │ │ .card.wt-block         │ │
│ │ ┌────────────────────────┐ │ │ │ ┌──────────────────┐   │ │
│ │ │.card-header            │ │ │ │ │.card-header      │   │ │
│ │ │ Statistics             │ │ │ │ │ On This Day      │   │ │
│ │ └────────────────────────┘ │ │ │ └──────────────────┘   │ │
│ │ ┌────────────────────────┐ │ │ │ ┌──────────────────┐   │ │
│ │ │.card-body              │ │ │ │ │.card-body        │   │ │
│ │ │.wt-block-content       │ │ │ │ │.wt-block-content │   │ │
│ │ │ • Individuals: 150     │ │ │ │ │ • Event 1        │   │ │
│ │ │ • Families: 75         │ │ │ │ │ • Event 2        │   │ │
│ │ └────────────────────────┘ │ │ │ └──────────────────┘   │ │
│ └────────────────────────────┘ │ └────────────────────────┘ │
└────────────────────────────────┴────────────────────────────┘
```

### **User Testing Terms:**
- "My Page" = User dashboard (home page after login)
- "Statistics block" = Block showing individual/family counts
- "Slideshow" = Random media block
- "On This Day" = Events that happened on current date

---

## Individual Page

### **Page Location:** `/index.php?route=%2F{tree}/individual/{xref}`

### **Template Files:**
- **Main:** `modules_v4/webtrees-svajana/resources/views/individual-page.phtml` (custom override)
- **Tabs:** `modules_v4/webtrees-svajana/resources/views/individual-page-tabs.phtml`
- **Sidebars:** `resources/views/individual-page-sidebars.phtml`
- **Facts:** `resources/views/fact.phtml` or custom `modules_v4/webtrees-svajana/resources/views/fact.phtml`

### **HTML Structure:**

```html
<div class="individual-header">
    <!-- Header with photo, name, dates, relationship -->
    <table id="individual-header-table">
        <!-- Person details -->
    </table>
</div>

<div class="row">
    <!-- Main Content Area (Left) -->
    <div class="col">
        <!-- Navigation Tabs -->
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#facts">Facts & Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#families">Families</a>
            </li>
            <!-- More tabs... -->
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content">
            <div class="tab-pane active" id="facts">
                <!-- Facts Table -->
                <table class="table wt-facts-table">
                    <tbody>
                        <tr>
                            <th class="wt-fact-label">Birth</th>
                            <td class="wt-fact-value">
                                15 Jan 1950
                                <!-- Dropdown icons -->
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown">
                                        <i class="fas fa-search-plus"></i> <!-- Zoom In -->
                                    </a>
                                    <div class="dropdown-menu wt-chart-box-zoom-dropdown">
                                        <!-- Fact details -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="tab-pane" id="families">
                <!-- Families content -->
            </div>
        </div>
    </div>
    
    <!-- Sidebar (Right) -->
    <div class="col-sm-4">
        <!-- Family Navigator -->
        <table class="table table-sm wt-facts-table wt-family-navigator-family">
            <caption class="wt-family-navigator-family-heading">
                Parents and siblings
            </caption>
            <tbody>
                <tr class="wt-family-navigator-parent">
                    <th class="wt-family-navigator-label">Father</th>
                    <td class="wt-family-navigator-name">
                        <a href="#">John Doe</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

### **CSS Classes:**

#### **Tab Navigation:**

| CSS Class | Element | Hover Behavior | Template File |
|-----------|---------|----------------|---------------|
| `.nav.nav-pills` | Tab navigation container | None | `individual-page-tabs.phtml` |
| `.nav-item` | Tab item wrapper | None | Core webtrees |
| `.nav-link` | **Tab link** | ✅ Background + lift | Core webtrees |
| `.nav-link.active` | Active tab | Different styling | Core webtrees |
| `.tab-content` | Tab content container | None | Core webtrees |
| `.tab-pane` | Individual tab panel | None | Core webtrees |
| `.tab-pane.active` | Visible tab | None | Core webtrees |

#### **Facts & Events Table:**

| CSS Class | Element | Hover Behavior | Template File |
|-----------|---------|----------------|---------------|
| `.wt-facts-table` | **Facts table** | ✅ Enhanced shadow | `fact.phtml` / tab content |
| `.wt-facts-table tbody tr` | **Table row** | ✅ Orange left border + bg | N/A (CSS target) |
| `.wt-fact-label` | Fact label cell (e.g., "Birth") | Part of row hover | `fact.phtml` |
| `.wt-fact-value` | Fact value cell | Part of row hover | `fact.phtml` |
| `.wt-facts-table a` | **Links in table** | ✅ Orange color + underline | N/A (CSS target) |

#### **Dropdown Menus (Zoom In / Links):**

| CSS Class | Element | Hover Behavior | z-index | Template File |
|-----------|---------|----------------|---------|---------------|
| `.dropdown` | Dropdown wrapper | None | 1 | `chart-box.phtml` / `fact.phtml` |
| `.dropdown-menu` | **Dropdown popup** | None | **1050** | Core Bootstrap |
| `.wt-chart-box-dropdown` | Chart box dropdown | None | **1060** | `chart-box.phtml` |
| `.wt-chart-box-zoom-dropdown` | **Zoom In popup** | None | **1060** | `chart-box.phtml` |
| `.wt-chart-box-links-dropdown` | **Links popup** | None | **1060** | `chart-box.phtml` |
| `.dropdown-item` | Dropdown menu item | ✅ Background + indent | N/A | Core Bootstrap |

#### **Family Navigator (Sidebar):**

| CSS Class | Element | Hover Behavior | Template File |
|-----------|---------|----------------|---------------|
| `.wt-family-navigator-family` | **Family card/table** | ✅ Orange border + lift | `modules/family_nav/sidebar-family.phtml` |
| `.wt-family-navigator-family-heading` | Caption/heading | None (part of parent) | `modules/family_nav/sidebar-family.phtml` |
| `.wt-family-navigator-parent` | Parent row | Part of card hover | `modules/family_nav/sidebar-family.phtml` |
| `.wt-family-navigator-child` | Child row | Part of card hover | `modules/family_nav/sidebar-family.phtml` |
| `.wt-family-navigator-label` | Label cell (e.g., "Father") | Part of card hover | `modules/family_nav/sidebar-family.phtml` |
| `.wt-family-navigator-name` | Name cell | Part of card hover | `modules/family_nav/sidebar-family.phtml` |
| `.wt-family-navigator-family a` | **Links in navigator** | ✅ Orange color + underline | N/A (CSS target) |

### **Visual Layout:**

```
┌─────────────────────────────────────────────────────────────┐
│  INDIVIDUAL PAGE: John Doe                                   │
├────────────────────────────────┬────────────────────────────┤
│ TABS (.nav.nav-pills)          │ SIDEBAR (.col-sm-4)        │
│ ┌──┬────┬─────────┬──────┐     │                            │
│ │✓ │Fam│Sources  │Notes │     │ ┌────────────────────────┐ │
│ └──┴────┴─────────┴──────┘     │ │.wt-family-navigator-   │ │
│                                 │ │      family            │ │
│ FACTS & EVENTS                  │ │ ┌──────────────────┐   │ │
│ ┌────────────────────────────┐  │ │ │ Parents          │   │ │
│ │.wt-facts-table             │  │ │ ├──────────────────┤   │ │
│ │┌──────────┬───────────────┐│  │ │ │Father: John Sr   │   │ │
│ ││Birth     │15 Jan 1950 🔍││  │ │ │Mother: Mary      │   │ │
│ │├──────────┼───────────────┤│  │ │ ├──────────────────┤   │ │
│ ││Death     │20 Mar 2020 🔍││  │ │ │ Children         │   │ │
│ │├──────────┼───────────────┤│  │ │ │• Jane Doe        │   │ │
│ ││Burial    │Location    🔍││  │ │ │• Bob Doe         │   │ │
│ │└──────────┴───────────────┘│  │ │ └──────────────────┘   │ │
│ └────────────────────────────┘  │ └────────────────────────┘ │
│                                 │                            │
│ FAMILIES TAB                    │                            │
│ ┌────────────────────────────┐  │                            │
│ │.wt-facts-table             │  │                            │
│ │┌──────────┬───────────────┐│  │                            │
│ ││Spouse    │Jane Smith 🔍 ││  │                            │
│ ││          │📋 (links)    ││  │                            │
│ │└──────────┴───────────────┘│  │                            │
│ └────────────────────────────┘  │                            │
└────────────────────────────────┴────────────────────────────┘

Legend:
🔍 = Zoom In icon (opens dropdown with fact details)
📋 = Links icon (opens dropdown with related links)
✓ = Active tab
```

### **User Testing Terms:**
- "Individual page" = Person details page
- "Facts tab" / "Facts & Events" = Tab showing birth, death, etc.
- "Families tab" = Tab showing spouse(s) and children
- "Family Navigator" = Sidebar showing relatives
- "Zoom In icon" = Magnifying glass icon that shows fact details
- "Links icon" = Three dots/menu icon for related links
- "Fact row" = Single row in facts table (e.g., "Birth | 15 Jan 1950")

---

## Dashboard Blocks

### **Common Block Types:**

#### **1. Statistics Block**
- **Module:** `FamilyTreeStatisticsModule`
- **CSS:** `.wt-block-gedcom-stats`
- **Template:** `resources/views/modules/gedcom_stats/statistics.phtml`
- **Content:** Counts of individuals, families, sources, etc.

#### **2. Slideshow Block**
- **Module:** `SlideShowModule`
- **CSS:** `.wt-block-random-media`
- **Template:** `resources/views/modules/random_media/slide-show.phtml`
- **Content:** Random photos from family tree

#### **3. On This Day Block**
- **Module:** `OnThisDayModule`
- **CSS:** `.wt-block-todays-events`
- **Template:** `resources/views/modules/todays_events/...`
- **Content:** Events that happened on current date

#### **4. HTML Block**
- **Module:** `HtmlBlockModule`
- **CSS:** `.wt-block-html`
- **Template:** Custom HTML content
- **Content:** User-defined HTML

### **Block Structure (All Types):**

```html
<div class="card mb-4 wt-block wt-block-{blocktype}" id="block-{id}">
    <div class="card-header wt-block-header wt-block-header-{blocktype}">
        <a class="btn btn-link" href="...">⚙️</a>
        Block Title
    </div>
    <div class="card-body wt-block-content wt-block-content-{blocktype}">
        <!-- Block-specific content -->
        <table class="table wt-facts-table">
            <!-- Statistics content -->
        </table>
    </div>
</div>
```

---

## Charts

### **Chart Box (Pedigree, Hourglass, etc.)**

#### **Template Files:**
- **Main:** `resources/views/chart-box.phtml`
- **Custom:** `modules_v4/webtrees-svajana/resources/views/chart-box.phtml` (if overridden)

#### **HTML Structure:**

```html
<div class="wt-chart-box wt-chart-box-{sex}" data-wt-chart-xref="{xref}">
    <!-- Thumbnail Photo -->
    <div class="wt-chart-box-thumbnail float-start me-1">
        <img src="..." class="wt-chart-box-thumbnail">
    </div>
    
    <!-- Icons (Zoom In, Links) -->
    <div class="wt-chart-box-extra d-print-none float-end ms-1">
        <!-- Zoom In Dropdown -->
        <div class="dropdown position-static wt-chart-box-zoom">
            <a class="wt-chart-box-icon" href="#" data-bs-toggle="dropdown">
                🔍 Zoom in
            </a>
            <div class="dropdown-menu dropdown-menu-end wt-chart-box-dropdown wt-chart-box-zoom-dropdown">
                <!-- Fact summaries -->
                <div>
                    <span class="label">Birth</span>
                    <span class="field">15 Jan 1950</span>
                </div>
            </div>
        </div>
        
        <!-- Links Dropdown -->
        <div class="dropdown position-static wt-chart-box-links">
            <a class="wt-chart-box-icon" href="#" data-bs-toggle="dropdown">
                📋 Links
            </a>
            <div class="dropdown-menu dropdown-menu-end wt-chart-box-dropdown wt-chart-box-links-dropdown">
                <a class="dropdown-item" href="...">Pedigree</a>
                <a class="dropdown-item" href="...">Descendants</a>
            </div>
        </div>
    </div>
    
    <!-- Person Name -->
    <div class="wt-chart-box-name">
        <a href="...">John Doe</a>
    </div>
    
    <!-- Lifespan -->
    <div class="wt-chart-box-lifespan">
        1950–2020
    </div>
    
    <!-- Facts -->
    <div class="wt-chart-box-facts">
        <div class="wt-chart-box-fact small">
            Birth: 15 Jan 1950
        </div>
    </div>
</div>
```

#### **CSS Classes:**

| CSS Class | Element | Hover Behavior | z-index | Template File |
|-----------|---------|----------------|---------|---------------|
| `.wt-chart-box` | **Chart box container** | ✅ Orange border + lift | 1 | `chart-box.phtml` |
| `.wt-chart-box-thumbnail` | Photo thumbnail | Part of parent hover | 1 | `chart-box.phtml` |
| `.wt-chart-box-extra` | Icons container | Part of parent hover | 1 | `chart-box.phtml` |
| `.wt-chart-box-icon` | Icon button | ✅ Hover effect | 10 | `chart-box.phtml` |
| `.wt-chart-box-dropdown` | **Dropdown menu** | None | **1060** | `chart-box.phtml` |
| `.wt-chart-box-zoom-dropdown` | **Zoom In details** | None | **1060** | `chart-box.phtml` |
| `.wt-chart-box-links-dropdown` | **Links menu** | None | **1060** | `chart-box.phtml` |
| `.wt-chart-box-name` | Person name | Part of parent hover | 1 | `chart-box.phtml` |
| `.wt-chart-box-lifespan` | Dates | Part of parent hover | 1 | `chart-box.phtml` |
| `.wt-chart-box a` | **Links in chart box** | ✅ Orange + underline | 10 | N/A (CSS target) |

#### **Visual Layout:**

```
┌──────────────────────────────────┐
│ .wt-chart-box                    │
│ ┌────┐                  ┌──┬──┐ │
│ │📷  │                  │🔍│📋│ │
│ │    │  John Doe        └──┴──┘ │
│ └────┘  1950–2020               │
│         Birth: 15 Jan 1950       │
│         Death: 20 Mar 2020       │
└──────────────────────────────────┘

When clicking 🔍 (Zoom In):
┌──────────────────────────────────┐
│ .dropdown-menu                   │
│ .wt-chart-box-zoom-dropdown      │
│ ┌──────────────────────────────┐ │
│ │ Birth                        │ │
│ │ 15 Jan 1950, London          │ │
│ ├──────────────────────────────┤ │
│ │ Death                        │ │
│ │ 20 Mar 2020, Manchester      │ │
│ └──────────────────────────────┘ │
└──────────────────────────────────┘
```

---

## CSS Class Reference

### **Hover Effect Classes (Modern Enhancements)**

| CSS Class | Hover Effect | Border Color | Transform | z-index |
|-----------|-------------|--------------|-----------|---------|
| `.card` | ✅ Yes | Orange (#ff8800) | translateY(-1.5px) | 1 (relative) |
| `.wt-block` | ✅ Yes | Orange | translateY(-1.5px) | 1 (relative) |
| `.wt-user-block` | ✅ Yes | Orange | translateY(-1.5px) | 1 (relative) |
| `.wt-chart-box` | ✅ Yes | Orange | translateY(-1.5px) | 1 (relative) |
| `.wt-family-navigator-family` | ✅ Yes | Orange | translateY(-1.5px) | 1 (relative) |
| `.wt-facts-table tbody tr` | ✅ Yes | Orange (left) | translateX(2px) | 1 → 20 on hover |
| `.nav-link` | ✅ Yes | N/A | translateY(-1px) | 10 |

### **Link Classes (Clickability)**

| CSS Class | Clickable | z-index | pointer-events |
|-----------|-----------|---------|----------------|
| `.card a` | ✅ Yes | 10 | auto |
| `.wt-block a` | ✅ Yes | 10 | auto |
| `.wt-block-content a` | ✅ Yes | 10 | auto |
| `.wt-facts-table a` | ✅ Yes | 10 | auto |
| `.wt-chart-box a` | ✅ Yes | 10 | auto |
| `.wt-family-navigator-family a` | ✅ Yes | 10 | auto |
| `.nav-link` | ✅ Yes | 10 | auto |
| `.dropdown-item` | ✅ Yes | auto | auto |

### **Dropdown Menu Classes (z-index Stacking)**

| CSS Class | z-index | Purpose |
|-----------|---------|---------|
| `.dropdown-menu` | **1050** | Default dropdown menus |
| `.wt-chart-box-dropdown` | **1060** | Chart box dropdowns (higher priority) |
| `.wt-chart-box-zoom-dropdown` | **1060** | Zoom In details popup |
| `.wt-chart-box-links-dropdown` | **1060** | Links menu popup |
| `.wt-facts-table .dropdown-menu` | **1060** | Dropdowns in facts table |

### **Color Variables**

| Variable | Color | Usage |
|----------|-------|-------|
| `--global-palette1` | #003366 (Navy) | Primary brand color |
| `--global-palette2` | #ff8800 (Orange) | Hover accent, borders |
| `--global-palette3` | #333333 (Dark gray) | Dark text, headings, backgrounds |
| `--global-palette4` | #555555 (Medium gray) | Body text, borders, dividers |
| `--global-palette5` | #888888 (Light gray) | Rarely used (only 1 reference) |
| `--global-palette6` | #99bbdd (Light blue) | Borders, accents |
| `--global-palette7` | #ebf5ff (Pale blue) | Backgrounds |
| `--global-palette8` | #f5f5f5 (Very light gray) | Backgrounds |
| `--global-palette9` | #ffffff (White) | Card backgrounds |

---

## Testing Quick Reference

### **Testing Terminology Map**

When user says → Look for this CSS class:

| User Term | CSS Class | Element Type |
|-----------|-----------|--------------|
| "My Page" | `.wt-main-blocks`, `.wt-side-blocks` | Page containers |
| "Dashboard block" | `.card.wt-block` | Block container |
| "Statistics block" | `.wt-block-gedcom-stats` | Specific block |
| "Slideshow" | `.wt-block-random-media` | Specific block |
| "Individual page" | `.wt-page-title` | Page container |
| "Facts tab" / "Facts & Events" | `.nav-link` + `.wt-facts-table` | Tab + table |
| "Families tab" | `.nav-link` + tab content | Tab + content |
| "Family Navigator" | `.wt-family-navigator-family` | Sidebar table |
| "Fact row" | `.wt-facts-table tbody tr` | Table row |
| "Zoom In icon" | `.wt-chart-box-icon` (dropdown toggle) | Icon button |
| "Zoom In popup" | `.wt-chart-box-zoom-dropdown` | Dropdown menu |
| "Links icon" | `.wt-chart-box-icon` (dropdown toggle) | Icon button |
| "Links popup" | `.wt-chart-box-links-dropdown` | Dropdown menu |
| "Chart box" | `.wt-chart-box` | Chart element |
| "Orange border" | `border-color: var(--global-palette2)` | Hover effect |
| "Lift effect" / "Floating" | `transform: translateY(-1.5px)` | Hover effect |

### **Expected Hover Behaviors by Component**

#### **✅ SHOULD Show Orange Border + Lift:**
1. **My Page blocks** (`.wt-block`, `.wt-user-block`)
2. **Dashboard blocks** - Statistics, Slideshow, On This Day (`.card.wt-block`)
3. **Chart boxes** in Pedigree/Hourglass charts (`.wt-chart-box`)
4. **Family Navigator** cards in sidebar (`.wt-family-navigator-family`)
5. **Generic cards** anywhere (`.card`)

#### **✅ SHOULD Show Orange Left Border + Background:**
1. **Facts & Events table rows** (`.wt-facts-table tbody tr`)

#### **✅ SHOULD Show Subtle Hover:**
1. **Tab navigation links** (`.nav-link`)
2. **Table rows** in general tables

#### **❌ Should NOT Hover (No Effect):**
1. **Page containers** (`.wt-main-blocks`, `.col-md-8`)
2. **Tab content** (`.tab-pane`)
3. **Block headers** (`.card-header`) - hover is on parent `.card`
4. **Dropdown menus** (`.dropdown-menu`) - static, no hover

### **Expected Clickability**

#### **✅ ALL Links MUST Be Clickable:**
- Links inside blocks: `.wt-block-content a`
- Links in facts table: `.wt-facts-table a`
- Links in chart boxes: `.wt-chart-box a`
- Links in family navigator: `.wt-family-navigator-family a`
- Tab links: `.nav-link`
- Dropdown items: `.dropdown-item`

#### **Expected z-index Behavior:**
- **Links inside hover elements:** z-index: 10 (always clickable)
- **Dropdown menus:** z-index: 1050-1060 (appear over everything)
- **Hover containers:** z-index: 1 (relative, allow children to stack)

### **Dropdown Popup Testing:**

When clicking "Zoom In" (🔍) or "Links" (📋) icons:

**✅ Expected Behavior:**
1. Dropdown menu appears
2. Menu is **fully visible** (not clipped)
3. Menu appears **over** subsequent table rows/cards
4. Menu content is readable
5. Links inside menu are clickable
6. Clicking outside closes menu

**❌ Problem Indicators:**
1. Dropdown partially hidden behind next row
2. Dropdown cut off at card boundary
3. Can't click links in dropdown (appears but unresponsive)
4. Dropdown appears under other elements

**If dropdown is clipped:**
- Check z-index of `.dropdown-menu` (should be 1050+)
- Check z-index of `.wt-chart-box-zoom-dropdown` (should be 1060)
- Verify parent elements don't have `overflow: hidden`

---

## File Structure Reference

### **Critical CSS Files (Load Order):**

```
1. resources/css/base.css                         ← Foundation
2. resources/css/webtrees-menus.css              ← Menu styles
3. resources/css/custom.css                       ← Theme config
4. resources/css/modern-components.css            ← Component styles
5. resources/css/modern-enhancements.css          ← 🎯 OUR CHANGES HERE
6. resources/css/customizations/enable-icons.css  ← Icon enables
```

**All hover effect changes are in:** `resources/css/modern-enhancements.css`

### **Critical Template Files:**

```
User Page (My Page):
├── resources/views/user-page.phtml
├── resources/views/user-page-block.phtml
└── resources/views/modules/block-template.phtml

Individual Page:
├── modules_v4/webtrees-svajana/resources/views/individual-page.phtml
├── modules_v4/webtrees-svajana/resources/views/individual-page-tabs.phtml
├── resources/views/individual-page-sidebars.phtml
└── modules_v4/webtrees-svajana/resources/views/fact.phtml

Family Navigator:
└── modules_v4/webtrees-svajana/resources/views/modules/family_nav/sidebar-family.phtml

Chart Boxes:
└── resources/views/chart-box.phtml (or custom override)

Blocks:
├── resources/views/modules/gedcom_stats/statistics.phtml
├── resources/views/modules/random_media/slide-show.phtml
└── resources/views/modules/todays_events/...
```

---

## Debugging Checklist

### **When reporting issues, provide:**

1. **Page Name:** (My Page, Individual Page, Chart Page)
2. **Component:** (Statistics block, Facts table, Family Navigator, Chart box)
3. **Specific Element:** (Card, row, link, dropdown)
4. **Issue Type:**
   - ✅ Hover works / ❌ No hover
   - ✅ Link clickable / ❌ Link not clickable
   - ✅ Dropdown visible / ❌ Dropdown clipped
5. **Expected vs Actual:**
   - Expected: Orange border + lift on hover
   - Actual: Only shadow change, no orange border

### **Example Test Report Format:**

```
Component: Statistics Block
Location: My Page - Main Blocks (left column)
Issue: No orange border on hover
Details:
  ✅ Lift effect works (card moves up)
  ✅ Shadow increases
  ❌ Border stays gray (expected: orange #ff8800)
  ✅ Links inside are clickable
CSS Class: .card.wt-block.wt-block-gedcom-stats
```

---

## Version History

- **v1.0** (Nov 29, 2025) - Initial comprehensive mapping document

---

## Dropdown Z-Index Architecture

### Z-Index Hierarchy (modern-enhancements.css)

Complete stacking order from bottom to top:

| Z-Index | Element | Purpose | CSS Line | Notes |
|---------|---------|---------|----------|-------|
| `1` | Base layer | Default stacking | Throughout | All elements without explicit z-index |
| `10` | Interactive links | Ensure clickability in hover containers | 822, 870, 926, 940, 1417, 1473 | Applied to `<a>` tags inside cards, tables, blocks |
| `20` | Hovered table cells | Lift effect on hover | 832 (DISABLED) | **DISABLED** - Transform creates stacking context that clips dropdowns |
| `1050` | Standard dropdowns | Bootstrap default | 1528 | `.dropdown-menu` base layer |
| `1060` | Chart dropdowns v1 | First attempt at fixing clipping | Superseded | Not sufficient for facts table context |
| `10000` | Navigation sub-menus | Main menu system | webtrees-menus.css | `.sub-menu` in header navigation |
| **`99999`** | **Critical chart dropdowns** | **Final fix for clipping** | **1540-1560** | `.wt-chart-box-zoom-dropdown` and `.wt-chart-box-links-dropdown` |

### Why Z-Index 99999?

**Problem:** Chart box dropdowns were clipping when appearing inside:
- Facts table cells (`<td>`)
- Family Navigator tables
- Chart containers with `overflow` properties
- Elements with CSS transforms creating new stacking contexts

**Failed Solutions:**
1. `z-index: 1050` - Not high enough
2. `z-index: 1060` - Still clipped by parent transforms
3. `transform: none` on hover - Removed lift effect but dropdown still clipped in some contexts

**Working Solution:**
```css
/* modern-enhancements.css lines 1540-1560 */
.wt-chart-box-dropdown,
.wt-chart-box-zoom-dropdown,
.wt-chart-box-links-dropdown {
    z-index: 99999 !important;
    position: absolute !important;
}

/* Required parent container properties */
.wt-chart-box {
    overflow: visible !important;
}

.wt-facts-table td,
.wt-facts-table th,
.wt-facts-table tr {
    overflow: visible !important;
}

.wt-chart-box .dropdown {
    overflow: visible !important;
}
```

**Key Requirements:**
1. **High z-index (99999)** - Above all possible stacking contexts
2. **position: absolute** - Creates new positioning context
3. **overflow: visible** - On ALL parent containers up the DOM tree
4. **!important flags** - Override any conflicting styles from base themes

### Transform Effects and Stacking Contexts

**CSS transforms create new stacking contexts**, which can clip child elements regardless of z-index.

**Elements with DISABLED transform hover effects:**

```css
/* Line 835 - Table rows */
.wt-facts-table tbody tr:hover {
    background-color: rgba(255, 136, 0, 0.08) !important;
    /* transform: translateX(2px) !important; */ /* DISABLED */
}

/* Line 895 - Chart boxes */
.wt-chart-box:hover {
    /* transform: translateY(-1.5px) !important; */ /* DISABLED */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    border-color: var(--global-palette2) !important;
}

/* Line 1414 - Family Navigator */
.wt-family-navigator-family:hover {
    /* transform: translateY(-1.5px) !important; */ /* DISABLED */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    border-color: var(--global-palette2) !important;
}
```

**Elements with ACTIVE transform hover effects:**

```css
/* Lines 919-960 - Cards and blocks (no dropdown children) */
.card:hover,
.wt-ajax-load:hover > .card {
    transform: translateY(-1.5px) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    border-color: var(--global-palette2) !important;
}

/* Lines 1459-1488 - Sidebar blocks */
.wt-block:hover,
.wt-user-block:hover {
    transform: translateY(-1.5px) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    border-color: var(--global-palette2) !important;
}
```

**Decision Matrix:**
- **Enable transform:** Container has NO dropdown children (cards, blocks, images)
- **Disable transform:** Container has dropdown children (chart boxes, tables, family navigator)
- **Alternative effects:** Use box-shadow + border-color instead of transform for consistent hover feedback

### Testing Dropdown Visibility

**Checklist for verifying dropdown z-index fixes:**

1. ✅ **Facts Table** - Individual page → Facts & Events tab
   - Click chart box Zoom icon → Dropdown appears fully above table
   - Click chart box Links icon → Dropdown appears fully above table
   - Verify no clipping at top, bottom, left, or right edges

2. ✅ **Family Navigator** - Individual page → Family Navigator
   - Click chart box Zoom icon → Dropdown appears fully above table
   - Click chart box Links icon → Dropdown appears fully above table
   - Test in "Parents" and "Children" sections

3. ✅ **Charts Page** - Ancestors/Descendants/Pedigree/Hourglass charts
   - Click chart box Zoom icon → Dropdown appears above chart
   - Click chart box Links icon → Dropdown appears above chart
   - Switch layouts (RIGHT/LEFT/UP/DOWN) and retest

4. ✅ **Dashboard Blocks** - Home page blocks with chart boxes
   - Click chart box Zoom icon → Dropdown appears above block
   - Verify z-index 99999 > block z-index

5. ✅ **Navigation Menus** - Header navigation
   - Hover over menu items → Sub-menus appear (z-index 10000)
   - Verify navigation dropdowns appear BELOW chart dropdowns when overlapping

**Browser Testing Matrix:**
- Chrome 120+ ✅
- Firefox 121+ ✅
- Edge 120+ ✅
- Safari 17+ ✅
- Mobile browsers (iOS Safari, Chrome Mobile) ✅

---

## Comprehensive Hover Effects Catalog

### Interactive Element Hover Patterns

All hover effects follow consistent pattern:
- **Duration:** 0.2s
- **Easing:** ease
- **Orange accent:** `--global-palette2` (#ff8800)
- **Transform distance:** 1.5px (when enabled)

#### Cards & Dashboard Blocks

**CSS:** lines 919-960 (cards), 1459-1488 (blocks)

```css
/* Hover state */
.card:hover,
.wt-block:hover,
.wt-user-block:hover {
    transform: translateY(-1.5px) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    border-color: var(--global-palette2) !important;  /* Orange border */
}

/* Base state */
.card,
.wt-block,
.wt-user-block {
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06) !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
}
```

**Visual Effect:**
1. Card lifts 1.5px upward
2. Border changes from light gray to orange
3. Shadow expands from subtle to prominent
4. Cursor changes to default (unless over link inside)

**Testing:** Hover over any dashboard block (Families, Individuals, Statistics) or page card.

#### Tables & Facts Table

**CSS:** lines 826-863

```css
/* Hover state - TRANSFORM DISABLED */
.wt-facts-table tbody tr:hover {
    background-color: rgba(255, 136, 0, 0.08) !important;  /* Subtle orange tint */
    /* transform: translateX(2px) !important; */ /* DISABLED */
}

/* Base state */
.wt-facts-table tbody tr {
    transition: background-color 0.2s ease !important;
    position: relative !important;
}
```

**Visual Effect:**
1. Row background changes to subtle orange tint
2. NO transform (disabled to prevent dropdown clipping)
3. NO orange border on first cell (disabled, was causing layout shift)

**Testing:** Hover over any fact row in Individual page → Facts & Events tab.

#### Chart Boxes

**CSS:** lines 875-905

```css
/* Hover state - TRANSFORM DISABLED, BORDER CHANGE DISABLED */
.wt-chart-box {
    background: var(--global-palette9) !important;
    border: 1px solid var(--global-palette6) !important;
    border-radius: 6px !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06) !important;
    position: relative !important;
    overflow: visible !important;
}

/* No hover effect to prevent dropdown clipping */
```

**Visual Effect:** NONE - All hover effects removed to ensure dropdown functionality.

**Testing:** Chart boxes have NO hover effect. Focus on dropdown visibility instead.

#### Family Navigator

**CSS:** lines 1402-1428

```css
/* Hover state - TRANSFORM DISABLED */
.wt-family-navigator-family:hover {
    /* transform: translateY(-1.5px) !important; */ /* DISABLED */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    border-color: var(--global-palette2) !important;  /* Orange border */
}

/* Base state */
.wt-family-navigator-family {
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06) !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
}
```

**Visual Effect:**
1. NO lift (transform disabled)
2. Border changes to orange
3. Shadow expands
4. Caption does NOT move independently

**Testing:** Hover over family sections in Individual page → Family Navigator.

#### Links with Animated Underline

**CSS:** lines 1575-1595

```css
/* Pseudo-element creates animated underline */
.wt-main-container .wt-page-content a:not(.btn):not(.wt-page-menu-button):not(.card a)::after {
    content: '' !important;
    position: absolute !important;
    bottom: -2px !important;
    left: 0 !important;
    width: 0 !important;
    height: 2px !important;
    background-color: var(--global-palette2) !important;  /* Orange underline */
    transition: width 0.2s ease !important;
}

/* Hover state expands underline */
.wt-main-container .wt-page-content a:not(.btn):not(.wt-page-menu-button):not(.card a):hover::after {
    width: 100% !important;
}
```

**Visual Effect:**
1. Orange underline animates from left to right (0% to 100% width)
2. Text color changes to orange
3. NO underline on buttons, page menu buttons, or links inside cards

**Testing:** Hover over text links in main content area (not navigation or buttons).

#### Buttons

**CSS:** lines 1385-1399

```css
/* Hover state */
.btn-primary:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0, 51, 102, 0.3) !important;
}

/* Active state */
.btn-primary:active {
    transform: translateY(0) !important;
    box-shadow: 0 1px 2px rgba(0, 51, 102, 0.2) !important;
}
```

**Visual Effect:**
1. Button lifts 1px upward (less than cards)
2. Shadow expands
3. Active click pushes button back down (translateY(0))

**Testing:** Hover over any primary button (blue buttons).

#### Page Menu Buttons

**CSS:** lines 1515-1523

```css
/* Hover state */
.wt-page-menu-button:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0, 51, 102, 0.25) !important;
}
```

**Visual Effect:** Same as .btn-primary (1px lift + shadow expansion).

**Testing:** Hover over page menu buttons (e.g., "Add a new fact" on Individual page).

#### Image Thumbnails

**CSS:** lines 1502-1512

```css
/* Hover state */
.img-thumbnail:hover,
.wt-chart-box-thumbnail:hover {
    transform: scale(1.05) !important;  /* 5% enlargement */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
}
```

**Visual Effect:**
1. Image scales up 5% (grows in place)
2. Shadow expands

**Testing:** Hover over profile images in chart boxes or thumbnail galleries.

#### Tab Navigation

**CSS:** lines 1598-1619

```css
/* Hover state on inactive tabs */
.nav-pills .nav-link:not(.active):hover {
    background-color: rgba(255, 136, 0, 0.1) !important;  /* Subtle orange background */
    transform: translateY(-1px) !important;
}

/* Active tab (no hover) */
.nav-pills .nav-link.active {
    background-color: var(--global-palette1) !important;  /* Navy blue */
    color: var(--global-palette9) !important;  /* White text */
    pointer-events: auto !important;
    cursor: default !important;
}
```

**Visual Effect:**
1. Inactive tabs: Subtle orange tint + 1px lift
2. Active tabs: No hover effect (cursor: default)

**Testing:** Hover over inactive tabs in Individual page tab navigation.

#### Enhanced Headings

**CSS:** lines 1368-1381

```css
/* No hover effect - static bottom borders */
.wt-main-container h1 {
    border-bottom: 3px solid var(--global-palette2) !important;  /* Orange */
}

.wt-main-container h2 {
    border-bottom: 2px solid var(--global-palette6) !important;  /* Light blue */
}

.wt-main-container h3 {
    border-bottom: 1px solid var(--global-palette7) !important;  /* Pale blue */
}
```

**Visual Effect:** Static decorative borders - NO hover effect.

**Testing:** Visual inspection of headings (no interaction required).

### Summary Table: Hover Effects by Element

| Element | Transform | Border Color Change | Shadow Change | Other Effects | Status |
|---------|-----------|---------------------|---------------|---------------|--------|
| `.card` | ✅ translateY(-1.5px) | ✅ Orange | ✅ Expand | - | ACTIVE |
| `.wt-block` | ✅ translateY(-1.5px) | ✅ Orange | ✅ Expand | - | ACTIVE |
| `.wt-facts-table tr` | ❌ DISABLED | ❌ DISABLED | ❌ None | ✅ Background tint | ACTIVE (partial) |
| `.wt-chart-box` | ❌ DISABLED | ❌ DISABLED | ❌ None | - | NONE |
| `.wt-family-navigator-family` | ❌ DISABLED | ✅ Orange | ✅ Expand | - | ACTIVE (partial) |
| Content links | ❌ None | ❌ None | ❌ None | ✅ Animated underline | ACTIVE |
| `.btn-primary` | ✅ translateY(-1px) | ❌ None | ✅ Expand | - | ACTIVE |
| `.wt-page-menu-button` | ✅ translateY(-1px) | ❌ None | ✅ Expand | - | ACTIVE |
| `.img-thumbnail` | ✅ scale(1.05) | ❌ None | ✅ Expand | - | ACTIVE |
| `.nav-pills .nav-link` | ✅ translateY(-1px) | ❌ None | ❌ None | ✅ Background tint | ACTIVE |
| Headings (h1-h3) | ❌ None | ❌ None | ❌ None | Static borders | NONE |

**Legend:**
- ✅ ACTIVE - Effect enabled
- ❌ DISABLED - Effect intentionally removed
- ❌ None - Effect not applicable

---

## Notes

- All hover effects use orange color: `#ff8800` (CSS variable: `--global-palette2`)
- Lift effect uses: `transform: translateY(-1.5px)` for containers, `translateY(-1px)` for buttons
- All transitions use: `transition: all 0.2s ease` (or specific properties)
- Dropdown menus have z-index **99999** (critical fix) to prevent clipping
- All links inside hover elements have `z-index: 10` for clickability
- Transform effects are **strategically disabled** on elements with dropdown children to prevent stacking context issues

**For developers:** When adding new components, follow existing patterns:
1. Container gets hover effect (border + shadow, transform only if NO dropdowns inside)
2. Links inside get `z-index: 10` + `pointer-events: auto`
3. Dropdowns get `z-index: 99999` + `position: absolute`
4. Parent containers need `overflow: visible` up the entire DOM tree
5. Use `!important` flags to override base theme styles

**Cross-Reference:**
- **Chart Analysis:** See CHART_ANALYSIS.md "Production Testing Results" section
- **Color Usage:** See COLOR-AUDIT.md for complete palette2 (orange) usage breakdown
- **Interactive Demo:** See style-demo.html "Hover Effects" and "Recent Bug Fixes" sections
- **Testing Checklist:** See TESTING-CHECKLIST.md for comprehensive validation steps
