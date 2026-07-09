<?php
$tag = !empty($settings->heading_tag) ? $settings->heading_tag : 'h2';

$animate    = !empty($settings->enable_animation) && 'yes' === $settings->enable_animation;
$anim_class = '';
if ($animate) {
    $anim_type = !empty($settings->animation_type) ? $settings->animation_type : 'fade-up';
    $anim_class = ' wsbb-animate wsbb-animate--' . $anim_type;
}
?>
<div <?php $module->render_attributes(); ?>>
    <div class="wsbb-heading-wrap<?php echo $anim_class; ?>">
        <<?php echo esc_attr($tag); ?> class="wsbb-heading-text">
            <?php echo esc_html($settings->heading_text); ?>
        </<?php echo esc_attr($tag); ?>>
    </div>
</div>
