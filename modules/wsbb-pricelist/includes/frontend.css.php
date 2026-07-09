<?php
// Instance-specific CSS
$selector   = ".fl-node-$id .wsbb-pricelist-card";
$card_style = ! empty( $settings->card_style ) ? $settings->card_style : 'standard';

// ── Button via shared helper ─────────────────────────────
include_once WSBB_PLUGIN_DIR . 'includes/button-style-helpers.php';
$btn = wsbb_get_button_vars($settings, 'btn_');
extract($btn);
?>

/* Card background & border */
<?php if ( ! empty( $settings->bg_color ) ) : ?>
<?php echo $selector; ?> {
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bg_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->border_color ) && 'borderless' !== $card_style && 'minimal' !== $card_style && 'elevated' !== $card_style ) : ?>
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

<?php if ( ! empty( $settings->period_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-period {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->period_color ); ?>;
}
<?php endif; ?>

<?php
$period_size = isset( $settings->period_size ) ? intval( $settings->period_size ) : 0;
if ( $period_size > 0 ) :
?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-period {
    font-size: <?php echo $period_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->desc_font ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-desc {
<?php if ( ! empty( $settings->desc_font['family'] ) && 'Default' !== $settings->desc_font['family'] ) : ?>
    font-family: <?php echo esc_attr( $settings->desc_font['family'] ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->desc_font['weight'] ) ) : ?>
    font-weight: <?php echo esc_attr( $settings->desc_font['weight'] ); ?>;
<?php endif; ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->feature_icon_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-feature-icon {
    background: <?php echo FLBuilderColor::hex_or_rgb( $settings->feature_icon_color ); ?>33;
}
.fl-node-<?php echo $id; ?> .wsbb-pricelist-feature-icon::after {
    border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->feature_icon_color ); ?>;
}
<?php endif; ?>

/* ── Button base ─────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-pricelist-btn {
    color: <?php echo $btn_text; ?>;
    background-color: <?php echo $btn_bg; ?>;
    border-radius: <?php echo $btn_border_radius; ?>px;
    border: <?php echo $btn_border_width; ?>px solid <?php echo $btn_border_color ?: 'transparent'; ?>;
    padding: <?php echo $pad_v; ?>px <?php echo $pad_h; ?>px;
    font-size: <?php echo $font_size; ?>px;
    font-weight: <?php echo $font_weight; ?>;
<?php if ( $letter_spacing > 0 ) : ?>
    letter-spacing: <?php echo $letter_spacing; ?>px;
<?php endif; ?>
<?php if ( 'yes' === $show_shadow ) : ?>
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
<?php endif; ?>
}

/* ── Outlined / Ghost → transparent bg ──────────────── */
<?php if ( 'outlined' === $btn_style || 'ghost' === $btn_style ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-btn--<?php echo $btn_style; ?> {
    background: transparent;
}
<?php endif; ?>

/* ── Button hover ────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-pricelist-btn:hover {
<?php if ( ! empty( $btn_text_hover ) ) : ?>
    color: <?php echo $btn_text_hover; ?>;
<?php endif; ?>
<?php if ( ! empty( $btn_bg_hover ) ) : ?>
    background-color: <?php echo $btn_bg_hover; ?>;
<?php endif; ?>
<?php if ( ! empty( $btn_border_hover ) ) : ?>
    border-color: <?php echo $btn_border_hover; ?>;
<?php endif; ?>
<?php if ( 'yes' === $shadow_hover ) : ?>
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
<?php endif; ?>
}

/* Featured accent */
<?php if ( 'yes' === $settings->featured ) :
    $accent_color = ! empty( $settings->highlight_bg_color ) ? FLBuilderColor::hex_or_rgb( $settings->highlight_bg_color ) : '';
    if ( empty( $accent_color ) && ! empty( $settings->btn_bg_color ) ) {
        $accent_color = FLBuilderColor::hex_or_rgb( $settings->btn_bg_color );
    }
    if ( ! empty( $accent_color ) ) :
?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-card--featured {
    border-color: <?php echo $accent_color; ?>;
}
.fl-node-<?php echo $id; ?> .wsbb-pricelist-badge {
    background: <?php echo $accent_color; ?>;
}
<?php endif; endif; ?>
