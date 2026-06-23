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
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-button-wrap">
        <a href="<?php echo esc_url($link); ?>" class="wsbb-button-link"<?php echo $target; ?>>
            <?php if ($icon_position === 'before'): ?>
                <?php echo $icon_html; ?>
            <?php endif; ?>
            <span class="wsbb-button-text"><?php echo esc_html($settings->button_text); ?></span>
            <?php if ($icon_position === 'after'): ?>
                <?php echo $icon_html; ?>
            <?php endif; ?>
        </a>
    </div>
</div>
