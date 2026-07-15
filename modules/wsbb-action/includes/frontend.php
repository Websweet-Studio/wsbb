<?php
$tag       = ! empty($settings->heading_tag) ? $settings->heading_tag : 'h2';
$btn_url   = ! empty($settings->btn_link) ? $settings->btn_link : '#';

$btn_rel_parts = array();
if (! empty($settings->btn_link_target)) {
    $btn_target_attr = ' target="_blank"';
    $btn_rel_parts[] = 'noopener';
    $btn_rel_parts[] = 'noreferrer';
} else {
    $btn_target_attr = '';
}
if (! empty($settings->btn_link_nofollow)) {
    $btn_rel_parts[] = 'nofollow';
}
$btn_rel_attr = !empty($btn_rel_parts) ? ' rel="' . implode(' ', $btn_rel_parts) . '"' : '';
$btn_new_tab  = $btn_target_attr . $btn_rel_attr;
$btn_pos     = ! empty($settings->btn_position) ? $settings->btn_position : 'inline';
$btn_style   = ! empty($settings->btn_style) ? $settings->btn_style : 'filled';
$btn_size    = ! empty($settings->btn_size_preset) ? $settings->btn_size_preset : 'medium';
$btn_full    = ! empty($settings->btn_full_width) && 'yes' === $settings->btn_full_width;
$btn_classes = 'wsbb-action-btn wsbb-action-btn--' . $btn_style . ' wsbb-action-btn-size--' . $btn_size;
if ($btn_full) {
    $btn_classes .= ' wsbb-action-btn--full';
}

$animate = ! empty($settings->enable_animation) && 'yes' === $settings->enable_animation;
$anim_class = '';
if ($animate) {
    $anim_type = ! empty($settings->animation_type) ? $settings->animation_type : 'fade-up';
    $anim_class = ' wsbb-animate wsbb-animate--' . $anim_type;
}
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-action-inner wsbb-action-btn-<?php echo esc_attr($btn_pos); ?><?php echo $anim_class; ?>">
        <div class="wsbb-action-content">
            <?php if (! empty($settings->heading_text)) : ?>
                <h2 class="wsbb-action-heading"><?php echo esc_html($settings->heading_text); ?></h2>
            <?php endif; ?>

            <?php if (! empty($settings->description)) : ?>
                <p class="wsbb-action-desc"><?php echo wp_kses_post($settings->description); ?></p>
            <?php endif; ?>
        </div>

        <?php if (! empty($settings->btn_text)) : ?>
            <div class="wsbb-action-btn-wrap<?php echo $btn_full ? ' wsbb-action-btn-wrap--full' : ''; ?>">
                <a href="<?php echo esc_url($btn_url); ?>" class="<?php echo esc_attr($btn_classes); ?>" <?php echo $btn_new_tab; ?>>
                    <?php echo esc_html($settings->btn_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>