<?php
// Determine logo source
$logo_url = '';
$logo_id  = 0;

if ('custom' === $settings->logo_type && ! empty($settings->custom_logo)) {
    $logo_id  = $settings->custom_logo;
    $logo_url = wp_get_attachment_image_url($logo_id, 'full');
}

if (empty($logo_url)) {
    $logo_id  = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
}

$has_link = ! empty($settings->logo_link);
$link_target = ! empty($settings->logo_link_target) ? $settings->logo_link_target : '_self';
?>
<div class="wsbb-logo-wrap">
    <?php if ($has_link) : ?>
    <a href="<?php echo esc_url($settings->logo_link); ?>" target="<?php echo esc_attr($link_target); ?>" class="wsbb-logo-link">
    <?php endif; ?>

    <?php if ($logo_url) : ?>
        <img src="<?php echo esc_url($logo_url); ?>" class="wsbb-logo-img" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
    <?php else : ?>
        <span class="wsbb-logo-text"><?php echo esc_html(get_bloginfo('name')); ?></span>
    <?php endif; ?>

    <?php if ($has_link) : ?>
    </a>
    <?php endif; ?>
</div>
