<?php
// Instance-specific CSS
?>
.fl-node-<?php echo $id; ?> .wsbb-html-inner {
<?php if ( ! empty( $settings->background_color ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->background_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->text_color ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->padding ) ) : ?>
    padding: <?php echo esc_attr( $settings->padding ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->border_radius ) ) : ?>
    border-radius: <?php echo esc_attr( $settings->border_radius ); ?>px;
<?php endif; ?>
}
