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
<?php if ( ! empty( $settings->font_size ) ) : ?>
	font-size: <?php echo intval( $settings->font_size ); ?>px;
<?php endif; ?>
<?php if ( ! empty( $settings->line_height ) ) : ?>
	line-height: <?php echo esc_attr( $settings->line_height ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->text_align ) ) : ?>
	text-align: <?php echo esc_attr( $settings->text_align ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->html_font ) ) : ?>
	<?php if ( ! empty( $settings->html_font['family'] ) && 'Default' !== $settings->html_font['family'] ) : ?>
	font-family: <?php echo esc_attr( $settings->html_font['family'] ); ?>;
	<?php endif; ?>
	<?php if ( ! empty( $settings->html_font['weight'] ) ) : ?>
	font-weight: <?php echo esc_attr( $settings->html_font['weight'] ); ?>;
	<?php endif; ?>
<?php endif; ?>
}
