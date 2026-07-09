# Plan: Improve WSBB Plugin

## Summary
Comprehensive improvement across all 10 modules: fix broken icons, refactor duplicated button CSS logic, add minor security/nice-to-haves, and upgrade 6 stable modules with basic style options.

---

## Phase 1 — Fix Broken Icons (6 modules)

**Problem:** Modules reference `.svg` files that don't exist → BB shows broken/default icon.

**Fix:** Replace `'icon.svg'` with Dashicon name. BB auto-prefixes value with `dashicons-`.

| Module | Current | Dashicon |
|--------|---------|----------|
| wsbb-action | `megaphone.svg` | `megaphone` |
| wsbb-image-carousel | `slides.svg` | `images-alt2` |
| wsbb-heading | `text.svg` | `heading` |
| wsbb-html | `text.svg` | `editor-code` |
| wsbb-gallery | `format-gallery.svg` | `format-gallery` |
| wsbb-testimoni | `format-quote.svg` | `format-quote` |

**Files:** 6 files — `modules/wsbb-{name}/wsbb-{name}.php` line 14 each.

---

## Phase 2 — Minor Fixes & Housekeeping

| Item | What | Where |
|------|------|-------|
| 2a | Add `index.php` to all `css/`, `includes/`, `js/` dirs | ~20 directories across 10 modules |
| 2b | Fix `pagination_type` default `'numbers'` → keep as is (cosmetic only) | Skip — no functional impact |
| 2c | Create `/languages/` dir + `.pot` file for i18n | `languages/wsbb.pot` |

---

## Phase 3 — Upgrade 6 Stable Modules

Add basic Style options (bg_color, padding, border_radius, text_color) to modules that lack them.

### 3a. wsbb-heading
- **Add fields:** background_color, padding (dimension), border_radius
- **frontend.css.php:** Output dynamic CSS for bg, padding, border-radius
- **frontend.css:** No changes needed (base styles fine)

### 3b. wsbb-html
- **Add fields:** (already has bg_color, text_color, padding, border_radius — just need frontend.css.php)
- **frontend.css.php:** Actually output the dynamic CSS (currently only comment)
- **Security:** Wrap `$settings->html_content` with `wp_kses_post()` in frontend.php

### 3c. wsbb-visual-editor
- **Add fields:** (already has bg_color, text_color, padding — just need frontend.css.php)
- **frontend.css.php:** Output dynamic CSS (currently only comment)

### 3d. wsbb-gallery
- **Add fields:** background_color, padding (dimension), caption_color
- **frontend.css.php:** Output dynamic CSS
- **frontend.css:** Minor touch if needed

### 3e. wsbb-testimoni
- **Add fields:** card_bg_color, card_padding, card_border_radius, text_color, name_color, role_color
- **frontend.css.php:** Output dynamic CSS for card styling
- **frontend.css:** Base card styles already exist

### 3f. wsbb-image-carousel
- **Add fields:** background_color, padding, border_radius, caption_color
- **frontend.css.php:** Output dynamic CSS
- **frontend.css:** Already has good base styles

---

## Phase 4 — Refactor Duplicated Button CSS Logic

**Problem:** ~100 lines of identical PHP in `frontend.css.php` of 4 modules (wsbb-button, wsbb-action, wsbb-pricelist, wsbb-post) for Filled/Outlined/Ghost handling with color fallbacks.

**Solution:** Extract into a shared helper file `includes/button-style-helpers.php` included from each module's `frontend.css.php`.

**How:**
1. Create `includes/button-style-helpers.php` with function `wsbb_render_button_css($id, $settings, $prefix)`:
   - Takes settings prefix for flexible field names (e.g. `btn_` vs empty)
   - Handles all variable extraction, style-specific overrides, CSS output
   - Returns nothing — echoes CSS directly
2. Each module's `frontend.css.php` calls: `wsbb_render_button_css($id, $settings, 'btn_')`
3. `wsbb-button` uses empty prefix since its fields are unprefixed (`bg_color` vs `btn_bg_color`)

---

## Files to Change

### Phase 1 — Icons (6 files)
- `modules/wsbb-action/wsbb-action.php:14`
- `modules/wsbb-heading/wsbb-heading.php:14`
- `modules/wsbb-html/wsbb-html.php:14`
- `modules/wsbb-gallery/wsbb-gallery.php:14`
- `modules/wsbb-testimoni/wsbb-testimoni.php:14`
- `modules/wsbb-image-carousel/wsbb-image-carousel.php:14`

### Phase 2 — Housekeeping
- New: ~20 `index.php` files in `*/{css,includes,js}/` directories
- New: `languages/wsbb.pot`

### Phase 3 — Module Upgrades

**wsbb-heading:**
- `modules/wsbb-heading/wsbb-heading.php` — add bg_color, padding, border_radius
- `modules/wsbb-heading/includes/frontend.css.php` — add dynamic CSS for new fields

**wsbb-html:**
- `modules/wsbb-html/includes/frontend.css.php` — output dynamic CSS (currently empty)
- `modules/wsbb-html/includes/frontend.php` — wrap content with `wp_kses_post()`

**wsbb-visual-editor:**
- `modules/wsbb-visual-editor/includes/frontend.css.php` — output dynamic CSS (currently empty)

**wsbb-gallery:**
- `modules/wsbb-gallery/modules/wsbb-gallery.php` — add bg_color, padding, caption_color
- `modules/wsbb-gallery/includes/frontend.css.php` — output dynamic CSS

**wsbb-testimoni:**
- `modules/wsbb-testimoni/wsbb-testimoni.php` — add card_bg_color, card_padding, card_border_radius, text_color, name_color, role_color
- `modules/wsbb-testimoni/includes/frontend.css.php` — output dynamic CSS

**wsbb-image-carousel:**
- `modules/wsbb-image-carousel/wsbb-image-carousel.php` — add bg_color, padding, border_radius, caption_color
- `modules/wsbb-image-carousel/includes/frontend.css.php` — output dynamic CSS

### Phase 4 — Refactor Button (5 files)
- New: `includes/button-style-helpers.php` — shared helper
- `modules/wsbb-button/includes/frontend.css.php` — use helper
- `modules/wsbb-action/includes/frontend.css.php` — use helper
- `modules/wsbb-pricelist/includes/frontend.css.php` — use helper
- `modules/wsbb-post/includes/frontend.css.php` — use helper

---

## Verification
- Open each module in BB editor — icons load correctly (Dashicons)
- Button Filled/Outlined/Ghost works in all 4 modules
- New style fields appear in each module's editor
- Dynamic CSS outputs correct values for new fields
- No PHP errors in debug.log
