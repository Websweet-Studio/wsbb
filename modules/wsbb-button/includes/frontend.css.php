<?php
// ── Colors ──────────────────────────────────────────────
$text_color       = !empty($settings->text_color) ? FLBuilderColor::hex_or_rgb($settings->text_color) : '#ffffff';
$text_hover_color = !empty($settings->text_hover_color) ? FLBuilderColor::hex_or_rgb($settings->text_hover_color) : '';
$bg_type          = isset($settings->bg_type) ? $settings->bg_type : 'solid';
$bg_color         = !empty($settings->bg_color) ? FLBuilderColor::hex_or_rgb($settings->bg_color) : '#0073e6';
$bg_hover_color   = !empty($settings->bg_hover_color) ? FLBuilderColor::hex_or_rgb($settings->bg_hover_color) : '#005bb5';

// ── Border ──────────────────────────────────────────────
$border_radius      = isset($settings->border_radius) ? intval($settings->border_radius) : 4;
$border_width       = isset($settings->border_width) ? intval($settings->border_width) : 2;
$border_color       = !empty($settings->border_color) ? FLBuilderColor::hex_or_rgb($settings->border_color) : '';
$border_hover_color = !empty($settings->border_hover_color) ? FLBuilderColor::hex_or_rgb($settings->border_hover_color) : '';

// ── Spacing ─────────────────────────────────────────────
$size_preset = isset($settings->size_preset) ? $settings->size_preset : 'custom';

// Only use custom padding/font when size_preset is 'custom'
if ($size_preset === 'custom') {
    $pad_h     = isset($settings->padding_h) ? intval($settings->padding_h) : 24;
    $pad_v     = isset($settings->padding_v) ? intval($settings->padding_v) : 12;
    $font_size = isset($settings->font_size) ? intval($settings->font_size) : 16;
} else {
    $presets = array(
        'small'  => array('pad_h' => 16, 'pad_v' => 8, 'font_size' => 13),
        'medium' => array('pad_h' => 24, 'pad_v' => 12, 'font_size' => 15),
        'large'  => array('pad_h' => 36, 'pad_v' => 16, 'font_size' => 18),
    );
    $p = $presets[$size_preset];
    $pad_h     = $p['pad_h'];
    $pad_v     = $p['pad_v'];
    $font_size = $p['font_size'];
}

$font_weight      = isset($settings->font_weight) ? intval($settings->font_weight) : 600;
$letter_spacing   = isset($settings->letter_spacing) ? floatval($settings->letter_spacing) : 0;
$button_style     = isset($settings->button_style) ? $settings->button_style : 'filled';
$show_shadow      = isset($settings->box_shadow) ? $settings->box_shadow : 'no';
$shadow_hover     = isset($settings->shadow_hover) ? $settings->shadow_hover : 'no';
?>

/* ── Base ──────────────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-button-link {
    color: <?php echo $text_color; ?>;
    border-radius: <?php echo $border_radius; ?>px;
    padding: <?php echo $pad_v; ?>px <?php echo $pad_h; ?>px;
    font-size: <?php echo $font_size; ?>px;
    font-weight: <?php echo $font_weight; ?>;
    <?php if ($letter_spacing > 0): ?>
    letter-spacing: <?php echo $letter_spacing; ?>px;
    <?php endif; ?>

    <?php if ($bg_type === 'gradient' && !empty($settings->bg_gradient)): ?>
    background-image: <?php echo FLBuilderColor::gradient($settings->bg_gradient); ?>;
    <?php else: ?>
    background-color: <?php echo $bg_color; ?>;
    <?php endif; ?>

    border: <?php echo $border_width; ?>px solid <?php echo $border_color ?: 'transparent'; ?>;
    transition: background 0.3s, color 0.3s, border-color 0.3s, box-shadow 0.3s;

    <?php if ('yes' === $show_shadow): ?>
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    <?php endif; ?>
}

/* ── Ghost style → transparent bg ──────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-button--ghost {
    background: transparent !important;
}

/* ── Hover ─────────────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-button-link:hover {
    <?php if (!empty($text_hover_color)): ?>
    color: <?php echo $text_hover_color; ?>;
    <?php endif; ?>
    background-color: <?php echo $bg_hover_color; ?>;

    <?php if (!empty($border_hover_color)): ?>
    border-color: <?php echo $border_hover_color; ?>;
    <?php endif; ?>

    <?php if ('yes' === $shadow_hover): ?>
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    <?php endif; ?>
}

/* ── Font family ──────────────────────────────────────── */
<?php if (!empty($settings->button_font)): ?>
.fl-node-<?php echo $id; ?> .wsbb-button-link {
<?php if (!empty($settings->button_font['family']) && 'Default' !== $settings->button_font['family']): ?>
    font-family: <?php echo esc_attr($settings->button_font['family']); ?>;
<?php endif; ?>
}
<?php endif; ?>
