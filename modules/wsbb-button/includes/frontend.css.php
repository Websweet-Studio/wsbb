<?php
// Default values — applied even when settings are not explicitly saved
$text_color      = !empty($settings->text_color) ? FLBuilderColor::hex_or_rgb($settings->text_color) : '#ffffff';
$bg_type         = isset($settings->bg_type) ? $settings->bg_type : 'solid';
$bg_color        = !empty($settings->bg_color) ? FLBuilderColor::hex_or_rgb($settings->bg_color) : '#0073e6';
$bg_hover_color  = !empty($settings->bg_hover_color) ? FLBuilderColor::hex_or_rgb($settings->bg_hover_color) : '#005bb5';
$border_radius   = isset($settings->border_radius) ? intval($settings->border_radius) : 4;
$pad_h           = isset($settings->padding_h) ? intval($settings->padding_h) : 24;
$pad_v           = isset($settings->padding_v) ? intval($settings->padding_v) : 12;
$font_size       = isset($settings->font_size) ? intval($settings->font_size) : 16;
$font_weight     = isset($settings->font_weight) ? intval($settings->font_weight) : 600;
?>

.fl-node-<?php echo $id; ?> .wsbb-button-link {
    color: <?php echo $text_color; ?>;
    border-radius: <?php echo $border_radius; ?>px;
    padding: <?php echo $pad_v; ?>px <?php echo $pad_h; ?>px;
    font-size: <?php echo $font_size; ?>px;
    font-weight: <?php echo $font_weight; ?>;
    <?php if ($bg_type === 'gradient' && !empty($settings->bg_gradient)): ?>
    background-image: <?php echo FLBuilderColor::gradient($settings->bg_gradient); ?>;
    <?php else: ?>
    background-color: <?php echo $bg_color; ?>;
    <?php endif; ?>
}

.fl-node-<?php echo $id; ?> .wsbb-button-link:hover {
    background: <?php echo $bg_hover_color; ?>;
}
