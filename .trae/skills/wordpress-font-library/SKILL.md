---
name: "wordpress-font-library"
description: "WordPress Font Library & typography reference. Invoke when adding/managing custom fonts in WordPress, including Font Library UI, theme.json fontFamilies, @font-face declarations, Google Fonts integration, and programmatic font registration."
---

# WordPress Font Library & Typography

Reference from [WordPress Font Library Docs](https://wordpress.org/documentation/article/the-font-library/) and [theme.json typography schema](https://schemas.wp.org/wp/6.7/theme.json).

## Font Library Overview

Available since WordPress 6.5, extended globally in 7.0 for both block and classic themes. Lives at **Appearance > Fonts**.

Three tabs:
- **Library** — Installed fonts + theme fonts
- **Upload** — Upload .ttf, .otf, .woff, .woff2
- **Install Fonts** — Google Fonts integration (fonts downloaded locally to your site)

**Key detail**: Font Library downloads Google Fonts locally. No external CDN requests at runtime. GDPR-safe by default.

## Method 1: Font Library UI (No-Code)

### Install from Google Fonts

1. **Appearance > Fonts > Install Fonts**
2. Click "Allow access to Google Fonts" (one-time)
3. Search/filter fonts by category
4. Select font → choose variants → Install
5. Font appears in Library tab

### Upload Custom Fonts

1. **Appearance > Fonts > Upload**
2. Drag .ttf, .otf, .woff, .woff2 files
3. WordPress registers them automatically

### Apply Fonts Globally

1. **Appearance > Editor > Styles**
2. Click Typography (pen icon)
3. Select element type: Text, Links, Headings, Captions, Buttons
4. Choose installed font from dropdown
5. Save

### Remove Fonts

- **Deactivate variants**: Check/uncheck in Font Library → Update
- **Delete entirely**: Click font → check font name → Delete → Confirm

**Limitation**: Font settings stored in DB, not theme files. Not version-controlled. Lost on reset.

## Method 2: theme.json `fontFamilies` (Recommended for Theme Devs)

Register fonts in `settings.typography.fontFamilies`. WordPress auto-generates `@font-face` and enqueues files for both editor and frontend.

### Basic System Font

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "fontFamily": "-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif",
          "name": "System Sans-serif",
          "slug": "system-sans"
        }
      ]
    }
  }
}
```

### Custom Web Font with fontFace

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "fontFamily": "\"Inter\", sans-serif",
          "name": "Inter",
          "slug": "inter",
          "fontFace": [
            {
              "fontFamily": "Inter",
              "fontWeight": "400",
              "fontStyle": "normal",
              "src": ["file:./assets/fonts/inter/inter-regular.woff2"]
            },
            {
              "fontFamily": "Inter",
              "fontWeight": "700",
              "fontStyle": "normal",
              "src": ["file:./assets/fonts/inter/inter-bold.woff2"]
            }
          ]
        }
      ]
    }
  }
}
```

Place font files in `assets/fonts/` inside your theme. Use `file:./` prefix — WordPress resolves it to the theme root URL.

### Variable Fonts

```json
{
  "fontFace": [
    {
      "fontFamily": "Playfair Display",
      "fontWeight": "400 900",
      "fontStyle": "normal",
      "src": ["file:./assets/fonts/playfair-display-variable.woff2"]
    },
    {
      "fontFamily": "Playfair Display",
      "fontWeight": "400 900",
      "fontStyle": "italic",
      "src": ["file:./assets/fonts/playfair-display-italic-variable.woff2"]
    }
  ]
}
```

### fontFace Parameters

| Parameter | Description | Example |
|-----------|-------------|---------|
| `fontFamily` | Font family name (no fallback) | `"Inter"` |
| `fontWeight` | Weight or range for variable fonts | `"400"`, `"400 900"` |
| `fontStyle` | `normal` or `italic` | `"normal"` |
| `src` | Array of paths. `file:./` = theme root | `["file:./assets/fonts/inter.woff2"]` |
| `fontDisplay` | font-display strategy | `"swap"`, `"block"`, `"fallback"`, `"optional"` |
| `fontStretch` | Width/stretch range | `"normal"`, `"75% 125%"` |
| `unicodeRange` | Unicode character range | `"U+0025-00FF"` |
| `preview` | Preview URL for font picker | `"https://example.com/preview.png"` |

### Apply Default Fonts to Blocks

```json
{
  "styles": {
    "typography": {
      "fontFamily": "var(--wp--preset--font-family--inter)"
    },
    "blocks": {
      "core/heading": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--playfair-display)"
        }
      },
      "core/code": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--jetbrains-mono)"
        }
      }
    }
  }
}
```

### Disable Font Family Control

```json
{
  "settings": {
    "blocks": {
      "core/paragraph": {
        "typography": {
          "fontFamily": false
        }
      }
    }
  }
}
```

## Method 3: Classic @font-face (Any Theme)

Fully manual. Works with any theme or plugin.

```php
function mytheme_enqueue_fonts() {
    wp_enqueue_style( 'mytheme-custom-fonts',
        get_template_directory_uri() . '/assets/fonts/fonts.css',
        array(),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_fonts' );
add_action( 'enqueue_block_editor_assets', 'mytheme_enqueue_fonts' );
```

Corresponding `fonts.css`:

```css
@font-face {
    font-family: 'Inter';
    src: url('inter/inter-regular.woff2') format('woff2');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
}

@font-face {
    font-family: 'Inter';
    src: url('inter/inter-bold.woff2') format('woff2');
    font-weight: 700;
    font-style: normal;
    font-display: swap;
}
```

## PHP: Programmatic Font Registration

### Filter theme.json fontFamilies

```php
add_filter( 'wp_theme_json_data_theme', function( $theme_json ) {
    $new_data = array(
        'version'  => 3,
        'settings' => array(
            'typography' => array(
                'fontFamilies' => array(
                    array(
                        'fontFamily' => '"Custom Font", sans-serif',
                        'name'       => 'Custom Font',
                        'slug'       => 'custom-font',
                        'fontFace'   => array(
                            array(
                                'fontFamily' => 'Custom Font',
                                'fontWeight' => '400',
                                'fontStyle'  => 'normal',
                                'src'        => array( get_stylesheet_directory_uri() . '/assets/fonts/custom-regular.woff2' ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    );
    return $theme_json->update_with( $new_data );
} );
```

### wp_print_font_faces()

Since WP 6.4, `wp_print_font_faces()` handles printing `@font-face` declarations from theme.json `fontFace` arrays. Called automatically but can be used directly:

```php
add_action( 'wp_head', 'wp_print_font_faces', 20 );
```

### Deregister Font Library Fonts Programmatically

```php
add_filter( 'wp_fonts_get_registered', function( $registered ) {
    // Remove specific font collection
    unset( $registered['google-fonts--inter'] );
    return $registered;
} );
```

## Font Loading Strategies

| `font-display` | Behavior | When to use |
|----------------|----------|-------------|
| `swap` | Text visible immediately in fallback, swaps when font loads | Default. Best UX |
| `block` | Text invisible briefly, then font or fallback | Brand-critical fonts |
| `fallback` | Short block period, if font doesn't load fast → stays on fallback | Performance-sensitive |
| `optional` | Very short block, may never swap on slow connections | Best performance |
| `auto` | Browser default | Avoid — inconsistent across browsers |

## Performance Best Practices

- **Use .woff2** — best compression, all modern browsers support
- **Limit variants** — Regular (400) + Bold (700) is enough for most sites. Each weight adds ~20-50KB
- **Subset fonts** — Strip unused characters if you only support Latin script
- **Preload critical fonts**: `<link rel="preload" href="/font.woff2" as="font" crossorigin>`
- **Use variable fonts** — one file covers all weights/styles. Trade-off: larger single file but fewer HTTP requests
- **Self-host Google Fonts** — Font Library does this automatically. Avoids GDPR issues and external DNS lookups

## Font Library vs theme.json vs Manual

| Approach | Portability | Version Control | Ease | Best For |
|----------|-------------|-----------------|------|----------|
| Font Library UI | No (DB) | No | Highest | End users, quick setup |
| theme.json | Yes | Yes | Medium | Theme developers |
| Classic `@font-face` | Yes | Yes | Low | Plugin devs, maximum control |

## File Structure for Theme Fonts

```
my-theme/
  assets/
    fonts/
      inter/
        inter-regular.woff2
        inter-bold.woff2
      playfair-display/
        playfair-display-variable.woff2
        playfair-display-italic-variable.woff2
  theme.json          # fontFamilies declarations
```

## Google Fonts Helper Tool

[google-webfonts-helper](https://gwfh.mranftl.com/) — Download Google Fonts in .woff2 format with custom subsets, ready for theme.json `file:./` paths.

## Changelog

| WP Version | Change |
|------------|--------|
| 6.0 | `fontFamilies` + `fontFace` in theme.json |
| 6.4 | `wp_print_font_faces()` introduced, `_wp_theme_json_webfonts_handler()` deprecated |
| 6.5 | Font Library UI (Appearance > Fonts) |
| 7.0 | Font Library available for classic themes (was block-themes only) |
