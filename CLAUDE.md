# CLAUDE.md — cult.society WordPress Theme

This file provides guidance for AI assistants working in this codebase.

## Overview

This is a custom **WordPress theme** named **Cland** (`cult.society`), built on the [Underscores (_s)](https://underscores.me/) starter theme by Automattic. It powers a cultural society website with event management, user profiles, and a favourites system.

- **Theme name:** Cland
- **Text domain:** `cland`
- **Version constant:** `_S_VERSION` defined in `functions.php`
- **Min PHP:** 5.6 | **Min WordPress:** 4.5
- **Key plugins:** The Events Calendar, Ultimate Member

---

## Repository Structure

```
cult.society/
├── assets/
│   ├── css/          # Compiled CSS output + font files (woff/woff2)
│   └── scss/         # SCSS source files (see SCSS section below)
├── functions/        # Modular PHP feature files (auto-loaded by functions.php)
│   ├── enqueue-scripts.php       # Dynamic JS bundling from /modules/
│   ├── enqueue-styles.php        # CSS enqueuing (frontend + editor)
│   ├── disable-comments.php      # Site-wide comment disabling
│   ├── add-bulma-tags-menu-walker.php  # 3 custom Walker_Nav_Menu subclasses
│   ├── get-event-excerpt.php     # Event excerpt helper
│   └── handle-favourites.php     # AJAX favourites system
├── inc/              # Theme includes (loaded by functions.php)
│   ├── template-tags.php         # Custom template tag functions (cland_*)
│   ├── template-functions.php    # Body class & misc hooks
│   ├── customizer.php            # Customizer settings
│   ├── events-list.php           # The Events Calendar integration
│   ├── custom-header.php         # Custom header support
│   └── jetpack.php               # Jetpack compatibility
├── js/
│   ├── bundle.js                 # AUTO-GENERATED — do not edit directly
│   ├── favourites.js             # Favourites system frontend (Fetch API)
│   └── README.md                 # Bundling documentation (French)
├── modules/          # JS source modules — auto-bundled on reload
│   └── handle-menu-mobile.js     # Mobile menu toggle
├── template-parts/   # Reusable PHP template partials
├── ultimate-member/  # Overrides for Ultimate Member plugin templates
├── languages/        # .pot / .po / .mo translation files
├── functions.php     # Theme bootstrap — loads all /functions/ and /inc/ files
├── style.css         # Compiled CSS output (3468 lines) — do not edit directly
└── *.php             # WordPress template hierarchy files
```

---

## Development Setup

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Compiling SCSS

```bash
# Watch mode (development — with source maps)
npm run w
# or
npm run watch

# One-time compile (production — compressed, no source map)
npm run c
# or
npm run compile:css
```

### JavaScript

JS modules in `/modules/` are **automatically bundled** into `js/bundle.js` at runtime by `functions/enqueue-scripts.php` — no manual build step required. Simply add a `.js` file to `/modules/` and it will be included on next page load.

`js/favourites.js` is enqueued separately (not part of the auto-bundle).

---

## Linting

```bash
# PHP — WordPress Coding Standards
composer lint:wpcs

# PHP — Syntax check
composer lint:php

# SCSS
npm run lint:scss

# JavaScript
npm run lint:js
```

There are **no automated tests** — linting is the only quality gate.

---

## PHP Conventions

- **Function prefix:** All custom functions use `cland_` (e.g., `cland_posted_on()`, `cland_post_thumbnail()`).
- **Class naming:** PascalCase (e.g., `Bulma_Tags_Menu_Walker`).
- **Method naming:** snake_case.
- **Escaping:** Always escape output — use `esc_html()`, `esc_url()`, `esc_attr()`, `wp_kses_post()`.
- **Security:** All AJAX handlers must verify nonces (`check_ajax_referer()`). Capability checks where user actions modify data.
- **WordPress hooks:** Use actions/filters per WordPress standards. Register in `functions.php` or the relevant `/functions/` file.
- **Code style:** WPCS-compliant (tabs for indentation, WordPress formatting rules).

---

## JavaScript Conventions

- **Language:** Vanilla ES6 — no framework, no bundler (webpack/rollup not used).
- **DOM access:** `document.querySelector()` / `document.querySelectorAll()`.
- **Events:** `addEventListener()`, use event delegation where appropriate.
- **AJAX:** Fetch API, posting to `ajax_object.ajax_url` with `ajax_object.nonce` (injected via `wp_localize_script()`).
- **UI pattern:** Optimistic updates — update DOM immediately, roll back on error.
- **Naming:** camelCase functions and variables.

---

## SCSS Conventions

- **Variables:** kebab-case (`$color-primary`, `$font-size-base`).
- **Architecture:** modular partials under `assets/scss/`:
  - `_variables.scss`, `_mixins.scss`, `_fonts.scss` — globals
  - `_typography.scss`, `_grid.scss`, `_normalize.scss` — utilities
  - `partials/layout/`, `partials/ui/` — components
- **Naming:** BEM-inspired classes (e.g., `event-item`, `event-col--media`).
- **Units:** Use `rem()` and `cs()` helper functions (defined in mixins) for consistent sizing.
- **Breakpoints:** Mobile-first — use `@include tablet` / `@include desktop` mixins.
- **Compiled output:** `style.css` and `assets/css/main.css` — never edit these directly.

---

## CSS Framework

The theme uses **[Bulma](https://bulma.io/)** grid classes throughout templates:

- Layout: `columns`, `column`, `is-{1–12}`, `is-offset-{n}`
- Spacing: `pb-gap`, `pt-gap`, `mb-gap` (gap-based padding)
- Typography: `typo-h2`, `typo-base`, `typo-small`
- State: `is-open`, `active`, `hide-on-mobile`

---

## Key Features & Files

### Favourites System
- **Backend:** `functions/handle-favourites.php` — AJAX handlers, user meta storage (`favourite_events`).
- **Frontend:** `js/favourites.js` — Fetch-based AJAX, optimistic UI.
- **AJAX action:** `toggle_event_favourite` (nonce: `toggle_event_favourite_nonce`).
- **Storage:** WordPress user meta key `favourite_events` (array of post IDs).

### Event Integration (The Events Calendar)
- Custom post type: `tribe_events`
- Taxonomy: `tribe_events_cat`
- Helpers in `inc/events-list.php` and `functions/get-event-excerpt.php`
- Display data via TEC API: `tribe_get_events()`, `tribe_get_start_date()`, `tribe_get_end_date()`

### Menu Walkers (`functions/add-bulma-tags-menu-walker.php`)
Three custom `Walker_Nav_Menu` subclasses:
- `Bulma_Tags_Menu_Walker` — Homepage tag cloud (6-column Bulma layout)
- `Bulma_Overlay_Menu_Walker` — Mobile overlay menu
- `Bulma_Footer_Menu_Walker` — Footer navigation

### Dynamic JS Bundling
`functions/enqueue-scripts.php` scans `/modules/*.js` and concatenates them into `js/bundle.js` at runtime. Versioning uses `filemtime()` for cache busting. The bundle is also enqueued in the Gutenberg editor.

---

## Localization

- **Text domain:** `cland`
- All user-facing strings use `_e()`, `esc_html__()`, or `esc_html_x()` with the `cland` domain.
- Generate the `.pot` file: `composer make-pot`

---

## Plugin Compatibility

| Plugin | Notes |
|--------|-------|
| The Events Calendar | Deep integration — event queries, display, favourites |
| Ultimate Member | Template overrides in `/ultimate-member/templates/` |
| WooCommerce | Declared compatible (`add_theme_support`) |
| Jetpack | Conditional support in `inc/jetpack.php` |

---

## Git Workflow

- **Main branch:** `master`
- **Feature branches:** `claude/<description>` for AI-assisted work
- No CI/CD pipeline exists — changes go directly to `master` after manual review.
- Commit messages tend to be terse (repo history shows "update" style) — prefer descriptive messages when contributing.

---

## What NOT to Edit Directly

- `style.css` — compiled from SCSS, will be overwritten
- `assets/css/main.css` — compiled from SCSS
- `js/bundle.js` — auto-generated from `/modules/`
- `style-rtl.css` — generated by `npm run compile:rtl`
