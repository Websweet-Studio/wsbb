# Plan: Improve WSBB Plugin — V2

## Summary
Plugin udah cukup mature dengan 10 module. Phase 1-4 sebelumnya (icon fix, housekeeping, module upgrade, button refactor) udah selesai. Sekarang fokus ke improvement lanjutan: fitur baru di tiap module, polish UX, dan beberapa gap yang masih kurang.

---

## A. Module-Specific Improvements

### A1. wsbb-heading
| Improvement | Detail |
|-------------|--------|
| **Responsive font-size** | Field `font_size` udah ada `responsive: true`, tapi di frontend.css.php belum output media query untuk breakpoint. Fix kecil. |
| **Link/Anchor** | Opsi bikin heading jadi link (href + target) |
| **Text shadow** | Opsi text shadow sederhana (color + blur) |
| **Margin** | Opsi margin (top/bottom) biar spacing lebih fleksibel |

### A2. wsbb-html
| Improvement | Detail |
|-------------|--------|
| **Typography section** | Font family, font size, line height, text alignment — biar konten HTML bisa di-style tanpa CSS manual |
| **Max-width** | Opsi batasi lebar konten |
| **Border** | Tambah border width/color/radius (border_radius udah ada) |

### A3. wsbb-visual-editor
| Improvement | Detail |
|-------------|--------|
| **Border radius** | Belum ada field border_radius — tambah |
| **Typography** | Font family, line height (text_color udah ada) |
| **Max-width** | Opsi batasi lebar konten |

### A4. wsbb-gallery
| Improvement | Detail |
|-------------|--------|
| **Caption typography** | Font size, font family, align untuk caption |
| **Lightbox customization** | Overlay bg color, close button color |
| **Filter by categories** | Opsi filter gambar (kalo pake taxonomy) — advanced |
| **Gap responsive** | Columns udah responsive, gap belum responsive |

### A5. wsbb-testimoni
| Improvement | Detail |
|-------------|--------|
| **Gap antara items** | Field gap untuk grid (belum ada) |
| **Carousel gap** | Field gap untuk carousel (belum ada) |
| **Star color** | Rating star color customization |
| **Font family per element** | Text font, name font, role font |
| **Card border** | Border width/color untuk card (udah ada border_radius) |
| **Content alignment** | Align untuk tiap card (kiri/tengah/kanan) |

### A6. wsbb-image-carousel
| Improvement | Detail |
|-------------|--------|
| **Caption typography** | Font family, size, color (caption_color udah ada) |
| **Carousel gap** | Gap antara slides (belum ada) |
| **Arrow/dot customization** | Warna, ukuran arrow dan dot |
| **Image object-fit** | Cover/contain/fill — biar gambar konsisten |
| **Caption toggle** | Show/hide caption per image |

### A7. wsbb-button
| Improvement | Detail |
|-------------|--------|
| **Animation** | Pulse, shake, glow efek on hover |
| **Icon only mode** | Tombol icon aja tanpa teks |
| **Tooltip** | Tooltip text on hover |
| **Button group** | Multiple buttons in row — advanced |

### A8. wsbb-action
| Improvement | Detail |
|-------------|--------|
| **Background image** | Opsi background image untuk CTA section |
| **Overlay color** | Overlay gradient/warna di atas bg image |
| **Container width** | Opsi batasi lebar konten (narrow/medium/full) |
| **Reveal animation** | Fade-in/up on scroll (pake IntersectionObserver) |
| **Gap heading-desc** | Spacing antara heading dan description |
| **Button alignment separate** | Align button terpisah dari content align |

### A9. wsbb-pricelist
| Improvement | Detail |
|-------------|--------|
| **Desc font typography** | Font family, size, color untuk description |
| **Currency position** | Pilihan prefix ($) atau suffix (€) |
| **Highlight color per column** | Featured card bg accent color |
| **Feature icon** | Check/cross icon untuk tiap feature (udah ada placeholder span) |
| **Feature color per item** | Warna teks feature individual — advanced |
| **Period typography** | Font size/color untuk period (/mo) |
| **Columns responsive** | Columns count responsive (belum ada) |
| **Gap between cards** | Gap grid (belum ada) |

### A10. wsbb-post
| Improvement | Detail |
|-------------|--------|
| **Card bg color** | Background color untuk card |
| **Card border** | Border width/color untuk card item |
| **Exclude current post** | Opsi exclude post yang sedang dilihat |
| **Sticky posts** | Opsi handle sticky posts (ignore/prepend) |
| **Load more button** | Alternatif pagination: AJAX load more |
| **Custom date format** | Opsi format tanggal (udah ada show_date doang) |
| **Columns gap responsive** | Gap field responsive |
| **Image border radius** | Border radius terpisah untuk image |

---

## B. Cross-Module / Global Improvements

### B1. Reveal Animation on Scroll
- Tambah field `enable_animation` (yes/no) + `animation_type` (fade-in, fade-up, fade-left, fade-right, zoom-in)
- Pake IntersectionObserver native (no library needed)
- Output CSS untuk animasi di frontend.css.php
- Bisa dipilih per module instance

### B2. Schema Markup (Structured Data)
- **wsbb-pricelist:** Output `Product` + `Offer` schema
- **wsbb-testimoni:** Output `Review` schema
- **wsbb-post:** Output `Article` / `BlogPosting` schema
- Opsi toggle enable/disable schema biar nggak spam

### B3. Responsive Visibility
- Tiap module bisa dikasih opsi: hide on desktop/tablet/mobile
- Mirip kaya BB native visibility tapi per device

### B4. i18n Readiness
- Generate `.pot` file yang proper untuk translation
- Pastikan semua string udah pake `__()` / `_e()`

### B5. CSS Custom Properties
- Output CSS variables (`--wsbb-{module}-{property}`) untuk dynamic styling
- Berguna kalo user mau override dari child theme

### B6. PHP 8.x Compatibility
- Cek dan fix potensi warning (null coalescing, typed properties, etc.)
- Saat ini udah cukup baik, tapi beberapa isset() bisa di-simplify

---

## C. Technical Debt / Refactoring

### C1. Shared animation helper
- Kalau B1 jalan, extract animation logic ke shared helper kaya button-style-helpers.php

### C2. Responsive breakpoint constants
- Bikin array breakpoint reusable (desktop: 992, tablet: 768, mobile: 480) biar konsisten di semua module

### C3. Security audit
- `wp_kses_post()` udah dipasang di wsbb-html frontend.php
- Cek module lain: visual-editor output perlu `wp_kses_post()` juga untuk `$settings->editor_content`
- Pastikan semua output pake escaping function

---

## Prioritization

| Priority | Item | Effort | Impact |
|----------|------|--------|--------|
| P0 | A10 wsbb-post: card bg/border, exclude current post | Small | Medium |
| P0 | A9 wsbb-pricelist: columns responsive, gap, feature icon | Small | Medium |
| P0 | A5 wsbb-testimoni: gap, star color | Small | Medium |
| P1 | A1 wsbb-heading: responsive font-size fix | Trivial | Low |
| P1 | A3 wsbb-visual-editor: border-radius | Trivial | Low |
| P1 | A6 wsbb-image-carousel: caption typography, gap | Small | Medium |
| P1 | A8 wsbb-action: bg image, overlay, container width | Medium | High |
| P1 | Security audit (C3) | Small | High |
| P2 | B1 Reveal animation | Medium | High |
| P2 | B2 Schema markup | Medium | Medium |
| P2 | B3 Responsive visibility | Medium | Medium |
| P3 | A7 wsbb-button: animation, tooltip | Small | Low |
| P3 | C1-C3 Technical debt | Small | Low |
| P3 | A2 wsbb-html: typography section | Small | Low |

---

## Files Potentially Affected
- `modules/wsbb-*/wsbb-*.php` — Register fields
- `modules/wsbb-*/includes/frontend.css.php` — Dynamic CSS
- `modules/wsbb-*/includes/frontend.php` — HTML output
- `modules/wsbb-*/css/frontend.css` — Base CSS
- `modules/wsbb-*/js/frontend.js` — JS (carousel, animation)
- `includes/` — Shared helpers

---

## Verification
- Each field appears in BB editor correctly
- Dynamic CSS outputs correct values
- No PHP/JS errors in console
- Mobile responsive works as expected
- Visual regression: existing layouts not broken
