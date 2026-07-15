# Plan: Insert Shortcode Button di Post Card HTML Editor

> **Status: BLOCKED** — 2026-07-15
> Tombol toolbar belum muncul di builder. Sudah dicoba 3 pendekatan:
> 1. `registerModuleHelper` + query DOM iframe → `.data('editor')` tidak accessible (Ace di parent)
> 2. `addHook('settings-form-init')` + parent-window jQuery → hook timing / form not ready
> 3. `window.parent.jQuery` + `this.getForm()` cross-window → masih belum muncul
>
> **Akar masalah:** Ace editor & `.data('editor')` milik parent window, settings.js jalan di iframe. Bridge via `window.parent` seharusnya bekerja di BB (UABB tidak inject toolbar ke Ace editor, mereka hanya conditional show/hide fields). BB core (`fl-builder-node-code-settings.js`) juga tidak inject toolbar ke Ace.
>
> **Kemungkinan penyelidikan selanjutnya:**
> - Cek apakah `$this->add_js()` benar-benar enqueue di builder context
> - Cek console browser untuk error JS
> - Coba inject langsung via `wp_enqueue_script` di hook `wp_enqueue_scripts` + `FLBuilderModel::is_builder_active()` (seperti pattern `fl-builder-node-code-settings.php`)
> - Gunakan MutationObserver untuk detect kapan Ace editor muncul di DOM parent
> - Coba inject CSS & toolbar via `fl_builder_ui_enqueue_scripts` + polling `setInterval`

## Summary
Tambah tombol "+" di atas Ace editor field `custom_layout` (Post Card HTML) yg saat diklik menampilkan daftar shortcode yg bisa dipilih lalu disisipkan ke posisi kursor.

## Current State
- Field `custom_layout` bertipe `code` (Ace editor HTML) — bare editor tanpa toolbar
- Daftar shortcode hanya tampil di section `shortcode_ref` sbg referensi statis (read-only raw HTML)
- User harus copas manual shortcode dari referensi ke editor
- Tidak ada `settings.js` di module wsbb-post maupun di plugin wsbb

## Proposed Changes

### 1. Buat `js/settings.js` — Toolbar + Shortcode Picker

File baru: `modules/wsbb-post/js/settings.js`

**Apa yg dilakukan:**
- Hook ke `FLBuilder.addHook('settings-form-init', ...)` 
- Cari `.fl-field` untuk `custom_layout` (field HTML editor)
- Inject toolbar div dengan tombol "+" (insert shortcode) di atas Ace editor
- Saat "+" diklik, render dropdown daftar shortcode di bawah tombol
- Setiap item shortcode: label + preview (shortcode text)
- Saat item diklik, insert shortcode text ke posisi kursor di Ace editor (`editor.session.insert(pos, text)`)
- Posisi kursor didapat via `editor.getCursorPosition()` 
- Dropdown menutup setelah insert

**Daftar shortcode (hardcoded di JS):**
1. `[wsbb post:featured_image size="large" display="tag" linked="yes"]`
2. `[wsbb post:title]`
3. `[wsbb post:link text="title"]`
4. `[wsbb post:author_name link="yes"]`
5. `[wsbb post:date format="F j, Y"]`
6. `[wsbb post:excerpt length="55" more="..."]`
7. `[wsbb-if post:featured_image]...[/wsbb-if]` — wrap selected text if any
8. `[wsbb post:terms_list taxonomy="category" separator=", " linked="yes"]`
9. `[wsbb post:terms_list taxonomy="post_tag" separator=", " linked="yes"]`
10. `[wsbb post:link text="custom" custom_text="Read More »"]`

**Styling:** Inline CSS di JS untuk toolbar, tombol, dropdown (kecil, ga perlu file CSS terpisah)

### 2. Enqueue settings.js

Di `modules/wsbb-post/wsbb-post.php` — method `enqueue_scripts()`:
- Tambah baris untuk enqueue settings.js via `$this->add_js()` hanya di builder
- Atau pakai hook `fl_builder_ui_enqueue_scripts` di file yg sama

**Aktualnya:** BB module constructor punya parameter `'js'` untuk load JS di builder. Tapi method `enqueue_scripts()` juga available dan bisa detek `FLBuilderModel::is_builder_active()`. Pendekatan paling reliable:

```php
public function enqueue_scripts() {
    // ... existing CSS/JS ...
    if (class_exists('FLBuilderModel') && FLBuilderModel::is_builder_active()) {
        $this->add_js('wsbb-post-settings', $this->url . 'js/settings.js', array('jquery'), WSBB_VERSION, true);
    }
}
```

## Files Affected
| File | Action |
|---|---|
| `modules/wsbb-post/js/settings.js` | **CREATE** — shortcode picker logic |
| `modules/wsbb-post/wsbb-post.php` | **MODIFY** — enqueue settings.js di builder |

## Files NOT Affected
- `includes/frontend.php` — no change needed
- `css/frontend.css` — no change needed
- `js/frontend.js` — no change needed

## Assumptions & Decisions
- Daftar shortcode hardcoded di JS (sinkron manual dgn yg ada di `render_custom_layout()`)
- Tidak pakai CSS file terpisah — styling inline via JS biar self-contained
- Dropdown sederhana (bukan modal/popup kompleks) — klik item → insert → tutup
- Hanya untuk `custom_layout` field (HTML editor), bukan `custom_css_field`
- Tidak perlu custom field type BB — cukup settings.js hook

## Verification
1. Buka BB builder, edit modul WSBB Post → pilih Content Layout = "Custom HTML"
2. Di section "Custom Layout Editor" tab HTML, ada tombol "+" di atas editor
3. Klik "+" → muncul dropdown daftar shortcode
4. Klik shortcode → tersisip di posisi kursor
5. Klik di luar dropdown → dropdown menutup
6. Tidak ada error JS di console
