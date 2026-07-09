# Plan: WSBB Themer — Simplified Beaver Themer Implementation

## Summary
Integrasi themer functionality ke WSBB: user bisa bikin header, footer, singular, archive, dan 404 layouts pake Beaver Builder. Simplified version — fokus ke fitur esensial, skip advanced features.

---

## Exploration Findings

### BB Plugin Core Infrastructure
BB premium (`bb-plugin`) sudah menyediakan kelas themer core di `extensions/fl-theme-builder-core/`:
- `FLThemeBuilderLayoutData` — mengelola current page layouts (caching, sorting, filtering)
- `FLThemeBuilderRulesLocation` — location matching engine (SQL queries, preview system)

Kelas2 ini sudah loaded otomatis saat BB premium aktif. Tapi mereka hardcode ke CPT slug `fl-theme-layout` dan meta key `_fl_theme_builder_locations`.

### bb-theme-builder Plugin
Plugin resmi menyediakan:
- CPT `fl-theme-layout` registration
- Frontend rendering (header/footer hooks, `template_include` override)
- Admin UI (meta boxes, list table custom columns)
- Theme support (BB Theme, Genesis, GeneratePress, Storefront)
- Extensions (ACF, WooCommerce, TEC, EDD)

### WSBB Plugin Patterns
- Modular class structure per component
- `Wsbb_Loader` pattern untuk action/filter registry
- `wsbb.php` loads modules via `wsbb_load_modules()` on `init:99`
- Consistent naming: `class-wsbb-{component}.php`

### Key Decision
Gunakan CPT slug **`wsbb-themer-layout`** dengan implementasi location matching sendiri (sederhana). Tidak reuse BB core classes (mereka hardcode ke `fl-theme-layout`). Dependensi BB hanya: `FLBuilder::render_content_by_id()`.

---

## Architecture

```
WSBB Plugin
  ├── wsbb.php                          ── Tambah hook untuk load themer
  ├── themer/                           ── NEW direktori
  │   ├── class-wsbb-themer.php         ── Bootstrap: load semua themer classes
  │   ├── class-wsbb-themer-cpt.php     ── Register CPT + meta
  │   ├── class-wsbb-themer-rules.php   ── Location matching engine (sederhana)
  │   ├── class-wsbb-themer-renderer.php── Frontend rendering
  │   ├── class-wsbb-themer-admin.php   ── Meta boxes, admin UI
  │   ├── admin-edit-location-rules.php ── Location rules UI template
  │   └── content.php                   ── Template override
  └── (existing modules unchanged)
```

---

## Proposed Changes

### NEW — 7 files

#### 1. `themer/class-wsbb-themer.php` — Bootstrap
**What:**
- Define constants: `WSBB_THEMER_DIR`, `WSBB_THEMER_URL`
- Load semua themer classes
- Central init method

**Why:** Central loader, consistent with WSBB patterns.

**File structure:**
```php
class Wsbb_Themer {
    static public function init() {
        if ( ! class_exists( 'FLBuilder' ) ) return;
        // Load files
        require_once WSBB_THEMER_DIR . 'class-wsbb-themer-cpt.php';
        require_once WSBB_THEMER_DIR . 'class-wsbb-themer-rules.php';
        require_once WSBB_THEMER_DIR . 'class-wsbb-themer-renderer.php';
        if ( is_admin() ) {
            require_once WSBB_THEMER_DIR . 'class-wsbb-themer-admin.php';
        }
    }
}
```

#### 2. `themer/class-wsbb-themer-cpt.php` — Post Type + Meta
**What:**
- Register CPT `wsbb-themer-layout`:
  - `public => false`, `show_ui => true`
  - `show_in_menu => false` (ditambah via admin menu terpisah)
  - `supports => ['title', 'revisions']`
  - Tambah ke `fl_builder_post_types` filter
- Register post meta (via `register_post_meta`):
  - `_wsbb_layout_type` (string: header/footer/singular/archive/404)
  - `_wsbb_locations` (serialized array location strings)

**Why:** Foundation storage untuk semua themer layouts. CPT slug berbeda dari bb-theme-builder (`fl-theme-layout`) jadi tidak konflik.

**Location format:**
- `general:site` — Entire site
- `general:single` — All singular
- `general:archive` — All archives
- `general:author` — Author archives
- `general:search` — Search results
- `general:404` — 404 page
- `post:{post_type}` — All posts of type (e.g. `post:page`, `post:post`)
- `post:{post_type}:{id}` — Specific post (e.g. `post:page:42`)
- `archive:{post_type}` — Post type archive (e.g. `archive:post`)
- `taxonomy:{taxonomy}` — All terms (e.g. `taxonomy:category`)
- `taxonomy:{taxonomy}:{term_id}` — Specific term

#### 3. `themer/class-wsbb-themer-rules.php` — Location Matching
**What:**
- `get_current_page_location()` — determine current page location string (array of matched locations from most to least specific)
- `get_matching_layouts($type)` — query published `wsbb-themer-layout` posts:
  - `meta_key = _wsbb_layout_type` = $type
  - `meta_key = _wsbb_locations` LIKE match against current page locations
  - Prioritaskan: specific object > post type > general type > general:site
- `get_matching_header()` / `get_matching_footer()` — convenience methods
- `get_current_page_content_ids()` — for singular/archive/404

**Location detection logic:**
```php
function get_current_page_location() {
    $locations = array( 'general:site' );
    
    if ( is_singular() ) {
        $locations[] = 'general:single';
        $locations[] = 'post:' . get_post_type();
        $locations[] = 'post:' . get_post_type() . ':' . get_the_ID();
    } elseif ( is_archive() || is_home() ) {
        $locations[] = 'general:archive';
        if ( is_category() ) {
            $locations[] = 'taxonomy:category';
            $locations[] = 'taxonomy:category:' . get_queried_object_id();
        } elseif ( is_tag() ) {
            $locations[] = 'taxonomy:post_tag';
            $locations[] = 'taxonomy:post_tag:' . get_queried_object_id();
        } elseif ( is_tax() ) {
            $qo = get_queried_object();
            $locations[] = 'taxonomy:' . $qo->taxonomy;
            $locations[] = 'taxonomy:' . $qo->taxonomy . ':' . $qo->term_id;
        } elseif ( is_post_type_archive() ) {
            $locations[] = 'archive:' . get_query_var('post_type');
        } elseif ( is_author() ) {
            $locations[] = 'general:author';
        } elseif ( is_date() ) {
            $locations[] = 'general:date';
        } elseif ( is_search() ) {
            $locations[] = 'general:search';
        }
    } elseif ( is_404() ) {
        $locations[] = 'general:404';
    } elseif ( is_search() ) {
        $locations[] = 'general:search';
    }
    
    return $locations;
}
```

**Matching query:**
```php
function get_matching_layouts( $type ) {
    $current = self::get_current_page_location();
    
    $posts = get_posts(array(
        'post_type' => 'wsbb-themer-layout',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_wsbb_layout_type',
                'value' => $type,
            ),
        ),
    ));
    
    // Filter by location: cari match dari most specific ke least
    $matched = array();
    foreach ( $posts as $post ) {
        $saved = get_post_meta( $post->ID, '_wsbb_locations', true ) ?: array();
        foreach ( $current as $loc ) {
            if ( in_array( $loc, $saved ) ) {
                $matched[ $post->ID ] = $post;
                break;
            }
        }
    }
    
    return $matched;
}
```

**Why:** Core engine — determines which layout to show on which page. Simplified: no raw SQL, use `get_posts()` + PHP array filtering.

#### 4. `themer/class-wsbb-themer-renderer.php` — Frontend Rendering
**What:**
- `init()` — Hook ke `template_include` (priority 999), theme hooks (BB Theme actions, generic fallbacks)
- `override_template_include()` — For singular/archive/404: return path to `content.php`
- `render_header()` — Cari header layout, render via `FLBuilder::render_content_by_id()`, hook ke `get_header()` atau BB Theme hooks
- `render_footer()` — Sama untuk footer
- `render_content()` — For singular/archive/404 content layouts
- Theme support:
  - BB Theme: `fl_header_enabled` filter, `fl_before_header` action, `fl_after_content` action
  - Generic: `wp_body_open` (header), `wp_footer` (footer via `get_footer()`)
- Tambah body class `wsbb-themer-active` dan `wsbb-layout-{type}`

**Why:** Connects layouts to actual page output. Simplified: skip CSS/JS bundling, sticky/shrink/overlay header features.

#### 5. `themer/class-wsbb-themer-admin.php` — Admin Interface
**What:**
- `init()` — Hook ke `add_meta_boxes`, `save_post`, admin menu
- `add_admin_menu()` — Submenu "WSBB Themer" di menu Beaver Builder, atau menu sendiri
- Meta box "Layout Type": dropdown sederhana (header/footer/singular/archive/404)
- Meta box "Location Rules": include rules with add/remove
- `save_meta_boxes()` — Save handlers
- Custom columns di list table: Type, Location

**Simplify location UI:**
- Pre-populated dropdowns (no AJAX):
  - Group: General (Entire Site, All Singular, All Archives, 404, Search, Author)
  - Group: Post Types (Page, Post, dll — auto dari `get_post_types()`)
  - Group: Archives (Post Archives, Page Archives, dll)
  - Group: Taxonomies (Category, Tag, dll)
- "Specific" sub-select: dropdown untuk milih specific post/term (tanpa AJAX search — cukup semua item untuk post type dengan < 100 posts)
- Multiple locations: simple JS add/remove buttons
- No exclusion rules, no user rules, no custom template rules (v1)

**Why:** Admin UI to create and manage themer layouts. Simplified: no AJAX, no multiselect, no BB User Access dependency.

#### 6. `themer/admin-edit-location-rules.php` — Location Rules UI Template
**What:**
- HTML template untuk location rules meta box
- Dropdown location group → auto-populate location type dropdown
- "Add Rule" button → append location row
- Table showing current rules with "Remove" button
- Simple inline JavaScript untuk add/remove (no wp-util templates)

**Why:** Reusable template untuk location rules admin UI.

#### 7. `themer/content.php` — Template Override
**What:**
```php
<?php
// Full page override for singular/archive/404 layouts
get_header();
Wsbb_Themer_Renderer::render_content();
get_footer();
?>
```

**Why:** Simple replacement for `template_include` when content layout matches.

---

### MODIFIED — 1 file

#### 8. `wsbb.php`
**What:** Add action to load themer after BB is available (same pattern as `wsbb_load_modules`):
```php
add_action( 'init', 'wsbb_load_themer', 100 );
function wsbb_load_themer() {
    if ( class_exists( 'FLBuilder' ) ) {
        require_once WSBB_PLUGIN_DIR . 'themer/class-wsbb-themer.php';
        Wsbb_Themer::init();
    }
}
```

**Why:** Bootstrap themer functionality. Priority 100 = after modules (99).

---

## What's NOT Included (Out of Scope for v1)

| Feature | Reason |
|---------|--------|
| Part/Hook layouts | Complex, needs hook registry UI |
| Exclusion rules | Just include rules is enough |
| User rules (role/login) | Complexity not worth it |
| Sticky/shrink/overlay header | Additional JS/CSS needed |
| Frontend edit override mode | Advanced feature |
| CSS/JS bundling | BB handles this per-layout |
| Default template imports | User creates own layouts |
| Theme support for Genesis/GP/Storefront | BB Theme + generic fallback |
| WooCommerce/TEC/ACF extensions | Plugin-specific, skip |
| Admin bar integration | Nice-to-have, later |
| Location search AJAX | Pre-populated dropdowns suffice |
| Custom template rules | Skip for v1 |

---

## Implementation Order

1. `themer/class-wsbb-themer.php` — Bootstrap
2. `themer/class-wsbb-themer-cpt.php` — CPT + meta
3. `wsbb.php` — Add load hook
4. `themer/class-wsbb-themer-rules.php` — Location matching
5. `themer/class-wsbb-themer-renderer.php` — Frontend rendering
6. `themer/class-wsbb-themer-admin.php` — Admin meta boxes
7. `themer/admin-edit-location-rules.php` — Location rules UI
8. `themer/content.php` — Template override

---

## Verification

1. CPT `wsbb-themer-layout` muncul di admin menu
2. BB editor works di themer layouts (via `fl_builder_post_types` filter)
3. Create header layout → assign `general:site` → replaces theme header
4. Create singular layout → assign `post:post` → overrides single post
5. Create archive layout → assign `archive:post` → overrides blog page
6. Create 404 layout → renders on non-existent page
7. Admin meta boxes save/load correctly
8. All existing WSBB modules work inside themer layouts

---

## Notes
- Rendering via `FLBuilder::render_content_by_id()` — sama dengan BB themer official
- WSBB modules (button, heading, action, dll) work INSIDE themer layouts automatically
- Location data stored as serialized array via `wp_postmeta` (no custom tables)
- Performance: simple `get_posts()` queries + PHP matching; adequate for most sites
