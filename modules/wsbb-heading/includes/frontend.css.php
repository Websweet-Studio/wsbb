<?php
// Instance-specific CSS

$selector = ".fl-node-$id .wsbb-heading-text";
?>

.fl-node-<?php echo $id; ?> .wsbb-heading-text {
<?php if ( ! empty( $settings->text_color ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color ); ?>;
<?php endif; ?>

<?php if ( ! empty( $settings->font_size ) ) : ?>
    font-size: <?php echo esc_attr( $settings->font_size ); ?>px;
<?php endif; ?>

<?php if ( ! empty( $settings->line_height ) ) : ?>
    line-height: <?php echo esc_attr( $settings->line_height ); ?>;
<?php endif; ?>

<?php if ( ! empty( $settings->letter_spacing ) ) : ?>
    letter-spacing: <?php echo esc_attr( $settings->letter_spacing ); ?>px;
<?php endif; ?>

<?php if ( ! empty( $settings->align ) ) : ?>
    text-align: <?php echo esc_attr( $settings->align ); ?>;
<?php endif; ?>

<?php
// Font family from font field
if ( ! empty( $settings->heading_font ) && ! empty( $settings->heading_font['family'] ) && 'Default' !== $settings->heading_font['family'] ) :
?>
    font-family: <?php echo esc_attr( $settings->heading_font['family'] ); ?>;
<?php endif; ?>

<?php
// Font weight — prefer font field weight, fallback to explicit weight
if ( ! empty( $settings->heading_font ) && ! empty( $settings->heading_font['weight'] ) ) :
?>
    font-weight: <?php echo esc_attr( $settings->heading_font['weight'] ); ?>;
<?php endif; ?>
}
