---
name: "beaver-builder-modules"
description: "Provides Beaver Builder custom module development reference. Invoke when building or debugging custom BB modules, including class registration, settings forms, frontend rendering, CSS/JS enqueuing, and field type configuration."
---

# Beaver Builder Custom Modules

Reference documentation from [Beaver Builder 2.11 Developer Docs](https://docs.wpbeaverbuilder.com/beaver-builder/developer/custom-modules/).

## 01: Create a Plugin

Create a plugin in `/wp-content/plugins/` with a unique folder name (lowercase, dashes), e.g., `my-builder-modules/`. Inside, create a same-name PHP file, e.g., `my-builder-modules.php`.

```php
/**
 * Plugin Name: My Custom Modules
 * Plugin URI: http://www.mywebsite.com
 * Description: Custom modules for the Beaver Builder Plugin.
 * Version: 1.0
 * Author: Your Name
 * Author URI: http://www.mywebsite.com
 */

define( 'MY_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'MY_MODULES_URL', plugins_url( '/', __FILE__ ) );

function my_load_module_examples() {
  if ( class_exists( 'FLBuilder' ) ) {
      // Include your custom modules here.
  }
}

add_action( 'init', 'my_load_module_examples' );
```

## 02: Add a Module to Your Plugin

Create a module folder inside your plugin folder (lowercase, dashes, unique), e.g., `my-module/`. Inside, create a PHP file with the same name, e.g., `my-module.php`.

**IMPORTANT: Module folder and file names MUST be prefixed** to avoid conflicts with core modules. For example, if your name is John and you want a "button" module, use `john-button/john-button.php`.

```php
class MyModuleClass extends FLBuilderModule {
  public function __construct() {
    parent::__construct(array(
      'name'            => __( 'My Module', 'fl-builder' ),
      'description'     => __( 'A totally awesome module!', 'fl-builder' ),
      'group'           => __( 'My Group', 'fl-builder' ),
      'category'        => __( 'My Category', 'fl-builder' ),
      'dir'             => MY_MODULES_DIR . 'my-module/',
      'url'             => MY_MODULES_URL . 'my-module/',
      'icon'            => 'button.svg',
      'editor_export'   => true, // Defaults to true and can be omitted.
      'enabled'         => true, // Defaults to true and can be omitted.
      'partial_refresh' => false, // Defaults to false and can be omitted.
      'include_wrapper' => false, // Defaults to true but is recommended to be set to false.
      'block_editor'    => false, // v2.11: set true to make module work in WP block editor.
    ));
  }
}
```

Include the module in your main plugin file:

```php
function my_load_module_examples() {
  if ( class_exists( 'FLBuilder' ) ) {
      require_once 'my-module/my-module.php';
  }
}
```

## 03: Define Module Settings

Register your module via `FLBuilder::register_module`. Structure: tabs > sections > fields.

```php
FLBuilder::register_module( 'MyModuleClass', array(
  'my-tab-1' => array(
    'title'    => __( 'Tab 1', 'fl-builder' ),
    'sections' => array(
      'my-section-1' => array(
        'title'  => __( 'Section 1', 'fl-builder' ),
        'fields' => array(
          'my-field-1' => array(
            'type'  => 'text',
            'label' => __( 'Text Field 1', 'fl-builder' ),
          ),
          'my-field-2' => array(
            'type'  => 'text',
            'label' => __( 'Text Field 2', 'fl-builder' ),
          ),
        ),
      ),
    ),
  ),
) );
```

**IMPORTANT: Tab, section, and field slugs must be unique.**

## 04: Module Settings CSS & JavaScript

Customize the settings panel with CSS and JS. Entry points:

- **CSS**: `my-plugin/my-module/css/settings.css`
- **JavaScript**: `my-plugin/my-module/js/settings.js`

These load only when the module's settings panel is open. Use `FLBuilder.addHook( 'settings-form-init', callback )` in settings.js.

## 05: Module HTML

Place `frontend.php` in the module's `/includes/` directory:

```
my-plugin/my-module/includes/frontend.php
```

Available variables:

- `$module` — Instance of your module class (extends `FLBuilderModule`)
- `$id` — The module's node ID string
- `$settings` — Object containing saved module settings

```html
<div class="fl-example-text">
  <?php echo $settings->textarea_field; ?> <?php $module->example_method(); ?>
</div>
```

## 06: Module CSS

Three entry points for CSS:

### Global CSS: `my-plugin/my-module/css/frontend.css`

Styles applied to ALL module instances within a layout.

### Global Responsive CSS: `my-plugin/my-module/css/frontend.responsive.css`

Styles applied at the responsive breakpoint.

### Instance CSS: `my-plugin/my-module/includes/frontend.css.php`

CSS rendered per instance. Variables: `$module`, `$id`, `$settings`.

```css
.fl-node-<?php echo $id; ?> {
  background-color: #<?php echo $settings->bg_color; ?>;
}
```

### Auto CSS

Fields with `preview` type `css` can opt into auto-css with `auto` => `true`. Works for most simple CSS and compound fields: `border`, `dimension`.

```php
'preview' => array(
  'type' => 'css',
  'auto' => true,
  'property' => 'display'
)
```

## 07: Module JavaScript

Two entry points:

### Global JS: `my-plugin/my-module/js/frontend.js`

Applied to ALL module instances.

### Instance JS: `my-plugin/my-module/includes/frontend.js.php`

Rendered per instance. Variables: `$module`, `$id`, `$settings`.

```js
console.log("Module ID: <?php echo $id; ?>");
console.log("Text: <?php echo $settings->text_field; ?>");
```

## 08: Module Property Reference

| Property           | Type         | Description                                                                                                                                                   |
| ------------------ | ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `$name`            | string       | Module name shown in BB's module list                                                                                                                         |
| `$description`     | string       | Short description (not currently shown in UI)                                                                                                                 |
| `$category`        | string       | Category in BB's module list                                                                                                                                  |
| `$group`           | string       | Group in BB's group selector. Omit for Standard Modules group                                                                                                 |
| `$dir`             | string       | Directory path to module (include trailing slash)                                                                                                             |
| `$url`             | string       | URL path to module (include trailing slash)                                                                                                                   |
| `$icon`            | string       | Dashicon name (e.g. `'products'`, `'welcome-write-blog'`). BB auto-adds `dashicons-` prefix. For SVG, must be registered separately. Default icon if omitted. |
| `$editor_export`   | bool         | Set false to prevent export to default WP editor                                                                                                              |
| `$enabled`         | bool         | Set false to hide from BB's module list                                                                                                                       |
| `$node`            | string       | Module's unique permanent ID                                                                                                                                  |
| `$partial_refresh` | bool         | Enable partial refresh                                                                                                                                        |
| `$include_wrapper` | bool         | Recommended false. When false, render attributes in frontend.php: `<div <?php $module->render_attributes(); ?>>`                                              |
| `$accepts`         | string/array | Array of module slugs allowed to nest inside, or `'all'`. Default empty (no nesting). NEW in 2.11                                                             |
| `$block_editor`    | bool         | NEW in 2.11: Set true to make module work in WordPress block editor                                                                                           |

## 09: Module Method Reference

### `add_css( $handle, $src, $deps, $ver, $media )`

Register/enqueue styles. Only loads when module is present. Like `wp_enqueue_style`.

```php
$this->add_css( 'font-awesome' ); // already registered
$this->add_css( 'example-lib', $this->url . 'css/example-lib.css' );
```

### `add_js( $handle, $src, $deps, $ver, $in_footer )`

Register/enqueue scripts. Only loads when module is present. Like `wp_enqueue_script`.

```php
$this->add_js( 'jquery-bxslider' ); // already registered
$this->add_js( 'example-lib', $this->url . 'js/example-lib.js', array(), '', true );
```

### `remove()`

Override to run logic when module is removed from the page.

### `delete()`

Override to run logic when module is deleted/updated. Called more often than `remove()`. Use for clearing photo cache.

### `enqueue_scripts()`

Override to conditionally enqueue scripts/styles:

```php
public function enqueue_scripts() {
  if ( $this->settings && $this->settings->link_type == 'lightbox' ) {
      $this->add_js( 'jquery-magnificpopup' );
      $this->add_css( 'jquery-magnificpopup' );
  }
}
```

### `update( $settings )`

Override to modify settings before save. Must return `$settings`:

```php
public function update( $settings ) {
  if ( empty( $settings->my_field ) )
      $settings->my_field = 'Default Text';
  return $settings;
}
```

### `filter_settings( $settings )` — NEW in 2.11

Override to transform settings before they are consumed by Beaver Builder. Use for backwards-compatible settings migration.

```php
public function filter_settings( $settings ) {
  if ( isset( $settings->old_setting ) ) {
    $settings->new_setting = do_something_with_old_setting( $settings->old_setting );
    unset( $settings->old_setting );
  }
  return $settings;
}
```

## 10: Setting Fields Reference

> CAUTION: Do NOT use `type` or `connection` as field keys — reserved for internal use.

### Align field

Button group for left/center/right. Returns left, center, or right unless custom values defined.

```php
'text-align' => array(
    'type'    => 'align',
    'label'   => 'Text Align',
    'default' => 'center',
    'values'  => array(        // Optional custom return values
        'left'   => '0 auto 0 0',
        'center' => '0 auto',
        'right'  => '0 0 0 auto',
    ),
    'preview' => array(
        'type'     => 'css',
        'selector' => '.my-selector',
        'property' => 'text-align',
    ),
),
```

### Border field

Compound field for border construction. Returns array of border data.

```php
'my_border' => array(
    'type'       => 'border',
    'label'      => 'My Border',
    'responsive' => true,
    'preview'    => array(
        'type'     => 'css',
        'selector' => '.my-selector',
    ),
),
```

Render with helper in `frontend.css.php`:

```php
FLBuilderCSS::border_field_rule( array(
    'settings'     => $settings,
    'setting_name' => 'my_border',
    'selector'     => ".fl-node-$id .my-selector",
) );
```

### Button Group field

Group of buttons, single selection.

```php
'my_setting' => array(
    'type'    => 'button-group',
    'label'   => 'My Setting',
    'default' => 'two',
    'options' => array(
        'one'   => 'One',
        'two'   => 'Two',
        'three' => 'Three',
    ),
),
```

Options: `align_icons` (vertical), `icons` (custom SVG per option), `appearance` (padded), `fill_space` (true).

### Code field

Ace editor for code.

```php
'my_code_field' => array(
  'type'   => 'code',
  'editor' => 'html',
  'rows'   => '18'
),
```

### Color field

Color picker with optional alpha and reset.

```php
'my_color_field' => array(
  'type'       => 'color',
  'label'      => __( 'Color Picker', 'fl-builder' ),
  'default'    => '333333',
  'show_reset' => true,
  'show_alpha' => true
),
```

Rendering helpers:

- `FLBuilderColor::hex_or_rgb( $settings->field )` — ensures correct color format
- `FLBuilderCSS::rule()` — render CSS rule conditionally:

```php
FLBuilderCSS::rule( array(
    'enabled'  => 'flat' === $settings->style && ! empty( $settings->bg_hover_color ),
    'selector' => ".fl-builder-content .fl-node-$id a.fl-button:hover",
    'props'    => array(
        'background-color' => FLBuilderColor::hex_or_rgb( $settings->bg_hover_color ),
    ),
) );
```

### Date field

Native browser date picker, optional min/max.

```php
'my_date' => array(
    'type'  => 'date',
    'label' => 'My Date',
    'min'   => '2000-01-01',
    'max'   => '2018-12-31',
),
```

### Dimension field

Four number inputs (top/right/bottom/left). Returns individual values with key prefix. E.g., key `margin` returns `$settings->margin_top`, `$settings->margin_right`, `$settings->margin_bottom`, `$settings->margin_left`.

```php
'margin' => array(
    'type'        => 'dimension',
    'label'       => 'Margins',
    'description' => 'px',
),
```

Render with `FLBuilderCSS::dimension_field_rule()`:

```php
FLBuilderCSS::dimension_field_rule( array(
    'settings'     => $settings,
    'setting_name' => 'padding',
    'selector'     => ".fl-node-$id .some-element",
    'unit'         => 'px',
    'props'        => array(
        'padding-top'    => 'padding_top',
        'padding-right'  => 'padding_right',
        'padding-bottom' => 'padding_bottom',
        'padding-left'   => 'padding_left',
    ),
) );
```

Supports custom unit selects and popup value sliders.

### Editor field

WordPress editor with optional media buttons.

```php
'my_editor_field' => array(
  'type'          => 'editor',
  'media_buttons' => true,
  'wpautop'       => true
),
```

For oEmbed, set `wpautop` to false and output:

```php
global $wp_embed;
echo wpautop( $wp_embed->autoembed( $settings->text ) );
```

### Font field

Font family and weight selects. Returns array with `family` and `weight`.

```php
'my_font_field' => array(
  'type'    => 'font',
  'label'   => __( 'Font', 'fl-builder' ),
  'default' => array(
    'family' => 'Helvetica',
    'weight' => 300
  )
),
```

### Form field

Nested form launched from an existing form. FORM FIELDS CANNOT BE NESTED.

First register the form:

```php
FLBuilder::register_settings_form('my_form_field', array(
  'title' => __('My Form Field', 'fl-builder'),
  'tabs'  => array(
    'general' => array(
      'title'    => __('General', 'fl-builder'),
      'sections' => array(
        'general' => array(
          'title'  => '',
          'fields' => array(
            'label' => array(
              'type'  => 'text',
              'label' => __('Label', 'fl-builder')
            )
          )
        ),
      )
    )
  )
));
```

Then reference it:

```php
'my_form_field' => array(
  'type'         => 'form',
  'label'        => __('My Form', 'fl-builder'),
  'form'         => 'my_form_field',
  'preview_text' => 'label',
)
```

### Gradient field

Compound field for gradients. Returns array of gradient data.

```php
'my_gradient' => array(
    'type'    => 'gradient',
    'label'   => 'Gradient',
    'preview' => array(
        'type'     => 'css',
        'selector' => '.my-selector',
        'property' => 'background-image',
    ),
),
```

Render in `frontend.css.php`:

```php
background-image: <?php echo FLBuilderColor::gradient( $settings->my_gradient ); ?>
```

### Icon field

Icon selector. Returns class names like `fa fa-flag`.

```php
'my_icon_field' => array(
  'type'        => 'icon',
  'label'       => __( 'Icon Field', 'fl-builder' ),
  'show_remove' => true
),
```

Can toggle other fields/sections/tabs:

```php
'icon' => array(
    'type'  => 'icon',
    'label' => 'My Icon',
    'show'  => array(
        'fields'   => array( 'field_1', 'field_2' ),
        'sections' => array( 'section_1', 'section_2' ),
        'tabs'     => array( 'tab_1', 'tab_2' ),
    ),
),
```

### Link field

URL input with post selector button.

```php
'my_link_field' => array(
  'type'        => 'link',
  'label'       => __('Link Field', 'fl-builder'),
  'placeholder' => __( 'http://www.example.com', 'fl-builder' ),
),
```

Enable Target/NoFollow/Download checkboxes:

```php
'link' => array(
  'type'          => 'link',
  'label'         => 'Link',
  'show_target'   => true,
  'show_nofollow' => true,
  'show_download' => true,
),
```

### Loop Settings

Not a single field but a collection forming a tab. Reference the loop settings UI file:

```php
'my_loop_settings' => array(
  'title' => __( 'Loop Settings', 'fl-builder' ),
  'file'  => FL_BUILDER_DIR . 'includes/ui-loop-settings.php',
)
```

Query in `frontend.php`:

```php
$query = FLBuilderLoop::query( $settings );
if ( $query->have_posts() ) {
  while ( $query->have_posts() ) {
      $query->the_post();
  }
}
wp_reset_postdata();
```

Pagination: `FLBuilderLoop::pagination( $query );`

### Multiple Audios field

WordPress media lightbox for multiple audio file selection.

### Multiple Photos field

WordPress media lightbox for multiple photo selection.

### Photo field

Single photo selection with WordPress media lightbox.

```php
'my_photo_field' => array(
  'type'  => 'photo',
  'label' => __( 'Photo Field', 'fl-builder' ),
),
```

### Select field

Dropdown select.

```php
'my_select' => array(
    'type'    => 'select',
    'label'   => 'My Select',
    'default' => 'option-2',
    'options' => array(
        'option-1' => 'Option 1',
        'option-2' => 'Option 2',
    ),
),
```

### Service field

External API integration field type. Returns connected service data.

### Text field

Basic text input.

```php
'my_text_field' => array(
  'type'    => 'text',
  'label'   => __( 'Text Field', 'fl-builder' ),
  'default' => 'Default text',
),
```

### Textarea field

Multi-line text area.

```php
'my_textarea_field' => array(
  'type'  => 'textarea',
  'label' => __( 'Textarea Field', 'fl-builder' ),
  'rows'  => 6,
),
```

### Time field

Native browser time picker.

```php
'my_time' => array(
    'type'  => 'time',
    'label' => 'My Time',
),
```

### Typography field

Compound field for typography controls. Returns array of typography data.

```php
'my_typography' => array(
    'type'       => 'typography',
    'label'      => 'Typography',
    'responsive' => true,
    'preview'    => array(
        'type'     => 'css',
        'selector' => '.my-selector',
    ),
),
```

Render with `FLBuilderCSS::typography_field_rule()`:

```php
FLBuilderCSS::typography_field_rule( array(
    'settings'     => $settings,
    'setting_name' => 'typography',
    'selector'     => ".fl-node-$id .some-element",
) );
```

### Unit field

Number input with unit selector (px, em, %, vw, vh).

```php
'my_unit_field' => array(
  'type'        => 'unit',
  'label'       => 'Unit Field',
  'description' => 'px',
  'responsive'  => true,
),
```

## 11: Responsive Fields Reference

Fields supporting responsive breakpoints: `align`, `border`, `button-group`, `dimension`, `photo`, `select`, `typography`, `unit`.

Simple enable:

```php
'font_size' => array(
  'type'        => 'unit',
  'label'       => 'Font Size',
  'responsive'  => true,
),
```

Granular per-breakpoint config:

```php
'font_size' => array(
  'type'        => 'unit',
  'label'       => 'Font Size',
  'responsive'  => array(
    'placeholder' => array(
      'default'    => 36, // Extra Large
      'large'      => 26, // Large Breakpoint
      'medium'     => 20, // Medium Breakpoint
      'responsive' => 16, // Small Breakpoint
    ),
  ),
),
```

CSS helper for responsive rules:

```php
FLBuilderCSS::responsive_rule( array(
  'settings'     => $settings,
  'setting_name' => 'align',
  'selector'     => ".fl-node-$id .some-element",
  'prop'         => 'text-align',
) );
```

## 12: Repeater Fields Reference

A field that can be duplicated, reordered, and deleted. Works with all field types EXCEPT: Border, Editor, Loop Settings, Photo, Service, Typography.

Return value: array of values for each repeated field.

```php
'my_text_field' => array(
  'type'     => 'text',
  'label'    => __( 'My Text Field', 'fl-builder' ),
  'limit'    => 5, // limit the number of repeaters (optional)
  'multiple' => true,
),
```

To render repeater values in frontend.php:

```php
foreach ( $settings->my_text_field as $item ) {
    echo $item;
}
```

## 13: Sanitize Field Values

Provide a sanitization callback for field values:

```php
'my_field' => array(
    'type'       => 'text',
    'label'      => 'My Field',
    'sanitize'   => 'sanitize_text_field',
),
```

Or use a custom callback:

```php
'my_field' => array(
    'type'     => 'text',
    'label'    => 'My Field',
    'sanitize' => 'my_custom_sanitize_function',
),
```

## 14: Create Custom Fields

Register a custom field type:

```php
add_action( 'fl_builder_custom_fields', function() {
    require_once __DIR__ . '/fields/my-custom-field.php';
} );
```

The custom field file must define `settings`, `preview`, `sanitize`, `update`, and optionally `filter_settings` methods.

## 15: Helpers (NEW in 2.11)

### CSS Rendering Helpers

`FLBuilderCSS` class provides methods to render CSS rules in `frontend.css.php`.

**`FLBuilderCSS::rule()`** — Single rule for single device:

```php
FLBuilderCSS::rule( array(
  'selector' => ".fl-node-$id .some-element",
  'media'    => 'max-width: 980px', // Optional. 'default', 'medium', 'responsive' or custom
  'enabled'  => 'bar' === $settings->foo, // Optional condition
  'props'    => array(
    'background-image'    => $settings->bg_image_src,
    'background-repeat'   => $settings->bg_repeat_responsive,
  ),
) );
```

**`FLBuilderCSS::responsive_rule()`** — Single property for all breakpoints:

```php
FLBuilderCSS::responsive_rule( array(
  'settings'     => $settings,
  'setting_name' => 'align',
  'selector'     => ".fl-node-$id .some-element",
  'prop'         => 'text-align',
) );
```

**`FLBuilderCSS::dimension_field_rule()`** — Dimension field for all breakpoints:

```php
FLBuilderCSS::dimension_field_rule( array(
  'settings'     => $settings,
  'setting_name' => 'padding',
  'selector'     => ".fl-node-$id .some-element",
  'unit'         => 'px',
  'props'        => array(
    'padding-top'    => 'padding_top',
    'padding-right'  => 'padding_right',
    'padding-bottom' => 'padding_bottom',
    'padding-left'   => 'padding_left',
  ),
) );
```

**`FLBuilderCSS::typography_field_rule()`** — Typography field for all breakpoints:

```php
FLBuilderCSS::typography_field_rule( array(
  'settings'     => $settings,
  'setting_name' => 'typography',
  'selector'     => ".fl-node-$id .some-element",
) );
```

**`FLBuilderCSS::border_field_rule()`** — Border field for all breakpoints:

```php
FLBuilderCSS::border_field_rule( array(
  'settings'     => $settings,
  'setting_name' => 'item_border',
  'selector'     => ".fl-node-$id .some-element",
) );
```

### Settings Compatibility Helper

Override `filter_settings()` in module class for backwards-compatible settings migration:

```php
class FLExampleModule extends FLBuilderModule {
  public function filter_settings( $settings ) {
    // Convert old setting to new setting
    if ( isset( $settings->old_setting ) ) {
      $settings->new_setting = do_something_with_old_setting( $settings->old_setting );
      unset( $settings->old_setting );
    }
    // Change an existing setting
    if ( isset( $settings->existing_setting ) ) {
      $settings->existing_setting = do_something( $settings->existing_setting );
    }
    return $settings;
  }
}
```

## 16: Live Preview Reference

Preview types: `css`, `attribute`, `text`, `callback`, `none`.

### CSS Preview

```php
'my_color' => array(
  'type'    => 'color',
  'label'   => 'My Color',
  'preview' => array(
    'type'      => 'css',
    'selector'  => '.my-selector',
    'property'  => 'color',
    'important' => true, // Optional
  ),
),
```

Multiple CSS rules from one field:

```php
'preview' => array(
  'type'  => 'css',
  'rules' => array(
    array( 'selector' => '.selector-1', 'property' => 'color' ),
    array( 'selector' => '.selector-2', 'property' => 'background-color' ),
  ),
),
```

### Attribute Preview

```php
'my_text' => array(
  'type'    => 'text',
  'label'   => 'My Text',
  'preview' => array(
    'type'      => 'attribute',
    'attribute' => 'data-foo',
    'selector'  => '.my-selector',
  ),
),
```

### Callback Preview

```php
'my_color' => array(
  'type'    => 'color',
  'preview' => array(
    'type'     => 'callback',
    'callback' => 'myPreviewCallback',
  ),
),
```

JS callback:

```js
function myPreviewCallback(args) {
  // args contains: module, node, settings, preview, field
}
```

### JavaScript Events

```js
// Fires after layout render (save)
$(".fl-builder-content").on("fl-builder.layout-rendered", myCallback);

// Fires after preview render (edit)
$(".fl-builder-content").on("fl-builder.preview-rendered", myCallback);
```

## 17: Partial Refresh Reference

Enable partial refresh to avoid full page refreshes when editing module settings.

Module requirements:

- Set `'partial_refresh' => true` in module constructor
- Implement proper selectors in UI
- Avoid complex dynamic JS on initial load

## 18: Override Modules

Override built-in BB modules by copying the module folder to your plugin and modifying:

1. Copy the module folder from BB plugin (e.g., `bb-plugin/modules/heading/`)
2. Place in your custom plugin's module directory
3. BB will use your version instead of the default

```php
add_action( 'init', function() {
    if ( class_exists( 'FLBuilder' ) ) {
        require_once __DIR__ . '/modules/heading/heading.php';
    }
} );
```

## 19: Localization

Use WordPress i18n functions with the `fl-builder` text domain:

```php
__( 'My Text', 'fl-builder' );
_e( 'My Text', 'fl-builder' );
```

## 20: Module Aliases (NEW in 2.11)

Create pre-configured copies of modules without writing a new module from scratch:

```php
FLBuilder::register_module_alias( 'my-original-module-slug', 'my-alias-slug', array(
    'name'     => __( 'My Pre-configured Module', 'fl-builder' ),
    'settings' => array(
        'my_field' => 'Pre-configured value',
    ),
) );
```

## Container Modules (NEW in 2.11)

Modules that accept other modules as children (like rows and columns).

### Setup

```php
class MyModule extends FLBuilderModule {
  public function __construct() {
    parent::__construct( array(
      'name'            => __( 'My Container', 'fl-builder' ),
      'include_wrapper' => false, // Recommended
      'accepts'         => 'all', // Accept all module types
      // 'accepts'      => array( 'heading', 'rich-text', 'button' ), // Specific modules
      'template'        => array( // Optional: default child modules
        array( 'heading', array( 'heading' => 'Lorem Ipsum', 'tag' => 'h3' ) ),
        array( 'rich-text', array( 'text' => 'Default content.' ) ),
      ),
    ) );
  }
}
```

### Render

```php
// frontend.php
$custom_attrs = array(
  'class' => array( 'my-container-class' ),
);
?>
<div <?php $module->render_attributes( $custom_attrs ); ?>>
    <?php $module->render_children(); ?>
</div>
```

For nested child wrappers:

```php
$module->render_children_with_wrapper( 'div', array(
    'class' => array( 'my-child-wrapper' ),
) );
```

### Child Template Format

```php
// [ $slug, $settings, $children ]
array(
    array( 'heading', array( 'heading' => 'Title', 'tag' => 'h2' ) ),
    array( 'button', array( 'text' => 'Click' ), array( /* nested children if this is a container */ ) ),
)
```

## Module Blocks (NEW in 2.11)

Make modules work in the WP block editor. Set `'block_editor' => true` in module config:

```php
class MyModule extends FLBuilderModule {
  public function __construct() {
    parent::__construct( array(
      'name'         => __( 'My Module' ),
      'block_editor' => true,
    ) );
  }
}
```

Enabled modules are selectable at: **Settings > Beaver Builder > Blocks**.

## Responsive iFrame UI (NEW in 2.11)

The builder now uses a two-window architecture: parent window (UI/toolbar/settings) + iframe (page content).

### Accessing Windows

```js
// From iframe → parent
const win = window.parent;

// From parent → iframe
const win = FLBuilder.UIIFrame.getIFrameWindow();
```

### Selecting Elements with jQuery

```js
// Access parent UI from iframe
$(".fl-builder-bar", parent.window.document);
$("body", parent.window.document).find(".fl-builder-bar");

// Access iframe UI from parent
var win = FLBuilder.UIIFrame.getIFrameWindow();
$(".fl-row", win.document);
```

### Triggering Events Across Windows

```js
// Trigger parent events from iframe
parent.window.jQuery(".fl-button").trigger("click");

// Trigger iframe events from parent
var win = FLBuilder.UIIFrame.getIFrameWindow();
win.jQuery(".fl-row").trigger("mouseenter");
```

### TinyMCE

```js
// Settings forms (render in parent)
const t = parent.window.tinymce;

// Inline editing (render in iframe)
const t = tinymce;
```

### Enqueuing in Parent Window

```php
add_action( 'fl_builder_ui_enqueue_scripts', function() {
    // Enqueue builder UI assets.
} );
```

### Disabling iFrame UI

```php
add_filter( 'fl_builder_iframe_ui_enabled', '__return_false' );
```

### Helper Methods

| JS Method                            | Description                        |
| ------------------------------------ | ---------------------------------- |
| `FLBuilder.UIIFrame.isEnabled`       | True if iFrame UI is enabled       |
| `FLBuilder.UIIFrame.isUIWindow`      | True if executing in parent window |
| `FLBuilder.UIIFrame.isIFrameWindow`  | True if executing in iframe window |
| `FLBuilder.UIIFrame.getIFrameWindow` | Returns iframe window object       |

| PHP Method                             | Description                                   |
| -------------------------------------- | --------------------------------------------- |
| `FLBuilderUIIFrame::is_enabled`        | True if iFrame UI is enabled                  |
| `FLBuilderUIIFrame::is_ui_request`     | True if current request is for parent window  |
| `FLBuilderUIIFrame::is_iframe_request` | True if current request is for iframe content |

## Module Deprecations

When deprecating a module, set `'enabled' => false` and provide a migration path using `filter_settings()`.

## Basic Module File Structure

```
my-plugin/
  my-plugin.php              # Main plugin file
  my-module/
    my-module.php             # Module class (extends FLBuilderModule)
    includes/
      frontend.php            # HTML render
      frontend.css.php        # Instance CSS (optional)
      frontend.js.php         # Instance JS (optional)
    css/
      frontend.css            # Global CSS (optional)
      frontend.responsive.css # Responsive CSS (optional)
      settings.css            # Settings panel CSS (optional)
    js/
      frontend.js             # Global JS (optional)
      settings.js             # Settings panel JS (optional)
```
