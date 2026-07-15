# Custom HTML Content Layout Tabs Spec

## Why

Saat Content Layout = "Custom HTML" di modul wsbb-post, editor HTML dan CSS terpisah di section berbeda. User ingin keduanya dalam bentuk tab (tab HTML, tab CSS) agar lebih rapi dan mudah diakses.

## What Changes

- Gabung section `custom_html` (HTML editor) dan `custom_css` (CSS editor) jadi satu section baru bertab
- Tambah toggle field `layout_content_mode` dengan opsi "HTML" dan "CSS" sebagai tab switcher
- HTML editor dan CSS editor masing-masing muncul sesuai tab aktif
- Hapus section `custom_html` dan `custom_css` terpisah, ganti dengan section `custom_layout_editor`
- Hapus key `sections` `custom_html` dan `custom_css` dari toggle `layout_content`

## Impact

- Affected specs: wsbb-post module registration
- Affected code: `wsbb-post.php` (field definitions), `frontend.php` (render custom layout - no change needed)

## MODIFIED Requirements

### Requirement: Content Layout Custom HTML fields

**Reason**: Gabung HTML & CSS editor dalam satu section bertab

#### Scenario: Tab switching works

- **WHEN** Content Layout = "Custom HTML"
- **THEN** muncul section baru "Custom Layout Editor" dgn field `layout_content_mode` bertipe `button-group` opsi "HTML" / "CSS"
- **AND** saat tab "HTML" aktif, field `custom_layout` (HTML editor) tampil
- **AND** saat tab "CSS" aktif, field `custom_css_field` (CSS editor) tampil
- **AND** section `custom_html` dan `custom_css` yg lama dihapus dari toggle `layout_content`

### REMOVED Requirements

### Requirement: Separate sections for HTML and CSS

**Reason**: Digantikan oleh section tab tunggal
**Migration**: Field `custom_layout` dan `custom_css_field` tetap ada, hanya restruktur UI grouping-nya.
