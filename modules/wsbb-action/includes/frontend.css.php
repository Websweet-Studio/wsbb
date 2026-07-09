<?php
// Instance-specific CSS
?>
.fl-node-<?php echo $id; ?> .wsbb-action-heading {
<?php if ( ! empty( $settings->heading_font ) && ! empty( $settings->heading_font['family'] ) && 'Default' !== $settings->heading_font['family'] ) : ?>
    font-family: <?php echo esc_attr( $settings->heading_font['family'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->heading_font ) && ! empty( $settings->heading_font['weight'] ) ) : ?>
    font-weight: <?php echo esc_attr( $settings->heading_font['weight'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->heading_color ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->heading_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->heading_size ) ) : ?>
    font-size: <?php echo esc_attr( $settings->heading_size ); ?>px;
<?php endif; ?>
}

<?php if ( ! empty( $settings->desc_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-action-desc {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->desc_color ); ?>;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .wsbb-action-btn {
<?php if ( ! empty( $settings->btn_bg_color ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->btn_text_color ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_text_color ); ?>;
<?php endif; ?>
}

<?php if ( ! empty( $settings->btn_bg_hover ) || ! empty( $settings->btn_text_hover ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-action-btn:hover {
<?php if ( ! empty( $settings->btn_bg_hover ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_hover ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->btn_text_hover ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_text_hover ); ?>;
<?php endif; ?>
}
<?php endif; ?>
