<?php
$tag = !empty($settings->heading_tag) ? $settings->heading_tag : 'h2';
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-heading-wrap">
        <<?php echo esc_attr($tag); ?> class="wsbb-heading-text">
            <?php echo esc_html($settings->heading_text); ?>
        </<?php echo esc_attr($tag); ?>>
    </div>
</div>
