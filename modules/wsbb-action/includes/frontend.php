<?php
$tag       = ! empty($settings->heading_tag) ? $settings->heading_tag : 'h2';
$btn_url   = ! empty($settings->btn_link) ? $settings->btn_link : '#';
$btn_rel   = ! empty($settings->btn_link_nofollow) ? ' rel="nofollow"' : '';
$btn_new_tab = ! empty($settings->btn_link_target) ? ' target="_blank"' : '';
$btn_pos     = ! empty($settings->btn_position) ? $settings->btn_position : 'inline';
$btn_style   = ! empty($settings->btn_style) ? $settings->btn_style : 'filled';
$btn_size    = ! empty($settings->btn_size_preset) ? $settings->btn_size_preset : 'medium';
$btn_full    = ! empty($settings->btn_full_width) && 'yes' === $settings->btn_full_width;
$btn_classes = 'wsbb-action-btn wsbb-action-btn--' . $btn_style . ' wsbb-action-btn-size--' . $btn_size;
if ($btn_full) {
    $btn_classes .= ' wsbb-action-btn--full';
}
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-action-inner wsbb-action-btn-<?php echo esc_attr($btn_pos); ?>">
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
                <a href="<?php echo esc_url($btn_url); ?>" class="<?php echo esc_attr($btn_classes); ?>" <?php echo $btn_rel . $btn_new_tab; ?>>
                    <?php echo esc_html($settings->btn_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>