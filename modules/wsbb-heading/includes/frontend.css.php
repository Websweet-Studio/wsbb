<?php
// Instance-specific CSS
$selector = ".fl-node-$id .wsbb-heading-text";
?>

<?php echo $selector; ?> {
<?php if ( ! empty( $settings->text_color ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color ); ?>;
<?php endif; ?>

<?php if ( ! empty( $settings->font_size ) ) : ?>
    font-size: <?php echo esc_attr( $settings->font_size ); ?>px;
<?php endif; ?>

<?php if ( ! empty( $settings->font_size_medium ) ) : ?>
@media ( max-width: 992px ) {
    <?php echo $selector; ?> {
        font-size: <?php echo esc_attr( $settings->font_size_medium ); ?>px;
    }
}
<?php endif; ?>

<?php if ( ! empty( $settings->font_size_responsive ) ) : ?>
@media ( max-width: 600px ) {
    <?php echo $selector; ?> {
        font-size: <?php echo esc_attr( $settings->font_size_responsive ); ?>px;
    }
}
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

/* ── Box ──────────────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-heading-wrap {
<?php if ( ! empty( $settings->background_color ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->background_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->padding ) ) : ?>
    padding: <?php echo esc_attr( $settings->padding ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->border_radius ) ) : ?>
    border-radius: <?php echo esc_attr( $settings->border_radius ); ?>px;
<?php endif; ?>
}
