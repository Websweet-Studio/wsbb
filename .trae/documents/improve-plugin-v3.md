# Plan: Improve WSBB Plugin — V3

## Summary
V2 udah selesai (25+ file diubah). Sekarang fokus ke: (1) eksekusi button helper refactor yang masih pending, (2) fitur baru yang high-value di tiap module, (3) performa & DX.

---

## A. Technical Debt (Priority)

### A1. Eksekusi Button Helper Refactor
**Status:** File `includes/button-style-helpers.php` sudah dibuat dengan `wsbb_get_button_vars()` tapi belum dipakai oleh module manapun.

**Tantangan:** wsbb-button pakai field naming berbeda (`button_style`, `bg_color`, tanpa prefix), sementara 3 module lain pakai `btn_` prefix.

**Solusi:**
- Update helper untuk handle 2 mode: panggil dg `btn_` prefix (action/pricelist/post) atau tanpa prefix (button).
- Tambah parameter `$field_map` atau deteksi otomatis prefix.
- Atau: cukup refactor 3 module (action, pricelist, post) yang sudah kompatibel, biarkan wsbb-button tetap inline.

**File affected:**
- `includes/button-style-helpers.php` — perbaiki logic
- `modules/wsbb-action/includes/frontend.css.php` — ganti blok button vars dg include + extract
- `modules/wsbb-pricelist/includes/frontend.css.php` — sama
- `modules/wsbb-post/includes/frontend.css.php` — sama

### A2. Hapus Duplikasi CSS Keyframes
**Status:** `css/frontend.css` punya 5 animation keyframes. `modules/wsbb-button/css/frontend.css` juga punya 2 keyframes (pulse, shake). 2 tempat beda.

**Solusi:** Pindahin keyframes button ke global `css/frontend.css`, hapus dari button CSS.

### A3. PHP 8.x Cleanup
- Ganti `isset()` + `empty()` pattern dengan null coalescing (`??`) dimana clean
- Ganti `!empty($x) ? $x : $default` → `$x ?? $default`

---

## B. Module Feature Gaps (Medium)

### B1. wsbb-heading — Link, Text Shadow, Margin
| Field | Detail |
|-------|--------|
| `heading_link` | URL field + target toggle |
| `heading_link_text` | Optional CTA text after heading |
| `text_shadow` | Color + blur + offset |
| `margin` | Dimension field (top/bottom) |

### B2. wsbb-gallery — Caption Typography, Lightbox, Gap Responsive
| Field | Detail |
|-------|--------|
| `caption_font` | Font family + weight |
| `caption_size` | Font size unit |
| `lightbox_overlay_color` | Color with alpha |
| `gap` → `responsive: true` | Breakpoint-aware gap |

### B3. wsbb-testimoni — Content Alignment, Font per Element
| Field | Detail |
|-------|--------|
| `content_align` | Align per card (left/center/right) |
| `text_font`, `name_font`, `role_font` | Font family per element |

### B4. wsbb-image-carousel — Arrow/Dot Customization
| Field | Detail |
|-------|--------|
| `arrow_color` | Color (default based on theme) |
| `arrow_bg_color` | Color with alpha |
| `dot_color` | Color |
| `dot_active_color` | Color |

### B5. wsbb-pricelist — Currency Position, Per-column Color
| Field | Detail |
|-------|--------|
| `currency_position` | Select: prefix / suffix |
| `highlight_bg_color` | Featured card accent bg color |

### B6. wsbb-post — Sticky Posts, Date Format
| Field | Detail |
|-------|--------|
| `sticky_behavior` | Select: exclude / include / prepend |
| `date_format` | Text field (default: get_option('date_format')) |

---

## C. Cross-Module Features (New)

### C1. AJAX Load More for wsbb-post
Ganti pagination with AJAX load more button option.
- Field: `pagination_style` → numbers / load-more
- JS: intercept link click, fetch next page via `wp_ajax_nopriv_` / `wp_ajax_`
- Output: append items, update nonce
- Complexity: Medium (but high impact for UX)

### C2. Module Presets / Templates
Simpan/load konfigurasi module dari preset.
- Field: `preset` → select with predefined styles
- Example: heading → "Default", "Highlight Box", "Section Title"
- Each preset sets multiple fields at once
- Complexity: Low (just `toggle` or default field sets)

### C3. i18n: Generate .pot File
- Bikin file `languages/wsbb.pot` via `wp i18n make-pot`
- Pastikan Text Domain: wsbb konsisten

### C4. CSS Custom Properties untuk Module Wrapper
- Output CSS variables on `.fl-node-{id}`: `--wsbb-bg`, `--wsbb-text`, `--wsbb-radius`
- Berguna untuk child theme override tanpa CSS specificity fight

---

## D. Admin / UX Improvements

### D1. Module Descriptions
BB module browser kasih deskripsi singkat. Saat ini beberapa module tanpa deskripsi (`''`).

### D2. Default Values Review
Beberapa module punya default values yang kurang optimal:
- wsbb-heading: `default: ''` untuk heading_text (placeholder aja, fine)
- wsbb-html: border_radius default '0' → lebih baik kosong/tidak terpakai
- wsbb-testimoni: gap default '20' → 30 mungkin lebih baik visually

### D3. Consistent Icon Style
Beberapa module pake dashicons yang kurang relevan:
- wsbb-html: 'editor-code' → fine
- wsbb-visual-editor: 'welcome-write-blog' → bisa 'editor-kitchensink'

---

## Prioritization

| Priority | Item | Effort | Impact | Notes |
|----------|------|--------|--------|-------|
| **P0** | A1 Button helper refactor | Small | High | Udah 85% siap, tinggal wiring |
| **P0** | A2 Keyframes dedup | Trivial | Low | Cleanup |
| **P1** | B1 Heading link/text-shadow/margin | Small | Medium | Most-used module |
| **P1** | B5 Pricelist currency pos + highlight | Small | Medium | |
| **P1** | B6 Post sticky + date format | Small | Medium | |
| **P1** | C1 AJAX load more | Medium | High | Game-changer untuk post module |
| **P2** | B2 Gallery caption typo + lightbox | Medium | Medium | |
| **P2** | B4 Image-carousel arrows/dots | Small | Medium | |
| **P2** | C4 CSS custom properties | Small | Low | |
| **P3** | B3 Testimoni font per element | Small | Low | |
| **P3** | C3 .pot file | Trivial | Medium | i18n enabler |
| **P3** | D1-D3 Admin polish | Small | Low | |

---

## Files Affected
- `includes/button-style-helpers.php` — update helper
- `modules/wsbb-action/includes/frontend.css.php` — use helper
- `modules/wsbb-pricelist/includes/frontend.css.php` — use helper
- `modules/wsbb-post/includes/frontend.css.php` — use helper
- `modules/wsbb-heading/wsbb-heading.php` — add fields
- `modules/wsbb-heading/includes/frontend.css.php` — output new CSS
- `modules/wsbb-heading/includes/frontend.php` — render link
- `modules/wsbb-pricelist/wsbb-pricelist.php` — add fields
- `modules/wsbb-pricelist/includes/frontend.php` — currency position
- `modules/wsbb-post/wsbb-post.php` — add fields
- `modules/wsbb-post/includes/frontend.php` — sticky + date logic
- `modules/wsbb-post/js/frontend.js` — AJAX load more
- `modules/wsbb-gallery/wsbb-gallery.php` — add fields
- `modules/wsbb-gallery/includes/frontend.css.php` — new CSS
- `modules/wsbb-image-carousel/wsbb-image-carousel.php` — add fields
- `modules/wsbb-image-carousel/css/frontend.css` — arrow/dot CSS
- `modules/wsbb-button/css/frontend.css` — remove duplicate keyframes
- `css/frontend.css` — add button keyframes
- `languages/wsbb.pot` — new file

---

## Verification
1. PHP syntax lint on all changed files
2. BB editor loads all new fields without JS error
3. Button styles unchanged after refactor (visual regression)
4. AJAX load more works without page reload
5. Responsive breakpoints generate correct media queries
6. No duplicate animation keyframes
