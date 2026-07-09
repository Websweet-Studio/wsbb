<?php
$selector = ".fl-node-$id .wsbb-logo-img";
?>
<?php echo $selector; ?> {
<?php if (! empty($settings->logo_width)) : ?>
    max-width: <?php echo esc_attr($settings->logo_width); ?>px;
<?php endif; ?>
}

<?php if (! empty($settings->logo_width_medium)) : ?>
@media (max-width: 992px) {
    <?php echo $selector; ?> {
        max-width: <?php echo esc_attr($settings->logo_width_medium); ?>px;
    }
}
<?php endif; ?>

<?php if (! empty($settings->logo_width_responsive)) : ?>
@media (max-width: 600px) {
    <?php echo $selector; ?> {
        max-width: <?php echo esc_attr($settings->logo_width_responsive); ?>px;
    }
}
<?php endif; ?>
