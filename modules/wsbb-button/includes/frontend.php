<?php
$link = !empty($settings->button_link) ? $settings->button_link : '#';
$target = isset($settings->button_link_target) && $settings->button_link_target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
if (isset($settings->button_link_nofollow) && $settings->button_link_nofollow === 'yes') {
    $target .= ' rel="nofollow"';
}

$icon_html = '';
if (!empty($settings->button_icon)) {
    $icon_html = '<i class="' . esc_attr($settings->button_icon) . ' wsbb-button-icon" aria-hidden="true"></i>';
}

$icon_position = isset($settings->icon_position) ? $settings->icon_position : 'before';
$button_style  = isset($settings->button_style) ? $settings->button_style : 'filled';
$full_width    = isset($settings->full_width) ? $settings->full_width : 'no';
$size_preset   = isset($settings->size_preset) ? $settings->size_preset : 'custom';

$btn_class  = 'wsbb-button-link';
$btn_class .= ' wsbb-button--' . $button_style;
$btn_class .= ' wsbb-button-size--' . $size_preset;
$btn_class .= 'yes' === $full_width ? ' wsbb-button--full' : '';

$hover_anim = isset($settings->hover_animation) ? $settings->hover_animation : 'none';
if ($hover_anim !== 'none') {
    $btn_class .= ' wsbb-btn-hover--' . $hover_anim;
}

$tooltip_attr = '';
if (!empty($settings->tooltip)) {
    $tooltip_attr = ' title="' . esc_attr($settings->tooltip) . '"';
}
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-button-wrap">
        <a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($btn_class); ?>"<?php echo $target . $tooltip_attr; ?>>
            <?php if ($icon_position === 'before') : ?>
                <?php echo $icon_html; ?>
            <?php endif; ?>
            <span class="wsbb-button-text"><?php echo esc_html($settings->button_text); ?></span>
            <?php if ($icon_position === 'after') : ?>
                <?php echo $icon_html; ?>
            <?php endif; ?>
        </a>
    </div>
</div>
