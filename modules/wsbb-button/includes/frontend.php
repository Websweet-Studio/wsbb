<?php
$link = !empty($settings->button_link) ? $settings->button_link : '#';
$target = isset($settings->button_link_target) && $settings->button_link_target === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
if (isset($settings->button_link_nofollow) && $settings->button_link_nofollow === 'yes') {
    $target .= ' rel="nofollow"';
}
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-button-wrap">
        <a href="<?php echo esc_url($link); ?>" class="wsbb-button-link"<?php echo $target; ?>>
            <span class="wsbb-button-text"><?php echo esc_html($settings->button_text); ?></span>
        </a>
    </div>
</div>
