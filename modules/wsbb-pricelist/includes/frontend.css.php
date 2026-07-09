<?php
// Instance-specific CSS
$selector = ".fl-node-$id .wsbb-pricelist-card";
?>

<?php if ( ! empty( $settings->bg_color ) ) : ?>
<?php echo $selector; ?> {
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bg_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->border_color ) ) : ?>
<?php echo $selector; ?> {
    border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->border_color ); ?>;
}
<?php endif; ?>

<?php
// Plan name font
if ( ! empty( $settings->name_font ) ) :
?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-name {
<?php if ( ! empty( $settings->name_font['family'] ) && 'Default' !== $settings->name_font['family'] ) : ?>
    font-family: <?php echo esc_attr( $settings->name_font['family'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->name_font['weight'] ) ) : ?>
    font-weight: <?php echo esc_attr( $settings->name_font['weight'] ); ?>;
<?php endif; ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->name_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-name {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->name_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->price_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-price-amount,
.fl-node-<?php echo $id; ?> .wsbb-pricelist-currency {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->price_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->feature_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-feature {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->feature_color ); ?>;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .wsbb-pricelist-btn {
<?php if ( ! empty( $settings->btn_bg_color ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->btn_text_color ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_text_color ); ?>;
<?php endif; ?>
}

<?php if ( ! empty( $settings->btn_bg_hover ) || ! empty( $settings->btn_text_hover ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-btn:hover {
<?php if ( ! empty( $settings->btn_bg_hover ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_hover ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->btn_text_hover ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_text_hover ); ?>;
<?php endif; ?>
}
<?php endif; ?>

<?php if ( 'yes' === $settings->featured && ! empty( $settings->btn_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-card--featured {
    border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_color ); ?>;
}
.fl-node-<?php echo $id; ?> .wsbb-pricelist-badge {
    background: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_color ); ?>;
}
<?php endif; ?>
