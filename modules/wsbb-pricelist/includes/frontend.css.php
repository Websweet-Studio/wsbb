<?php
// Instance-specific CSS
$selector    = ".fl-node-$id .wsbb-pricelist-card";
$btn_style   = ! empty( $settings->btn_style ) ? $settings->btn_style : 'filled';
$card_style  = ! empty( $settings->card_style ) ? $settings->card_style : 'standard';

// ── Button colors ───────────────────────────────────────
$btn_bg            = ! empty( $settings->btn_bg_color ) ? FLBuilderColor::hex_or_rgb( $settings->btn_bg_color ) : '#2962ff';
$btn_text          = ! empty( $settings->btn_text_color ) ? FLBuilderColor::hex_or_rgb( $settings->btn_text_color ) : '#ffffff';
$btn_bg_hover      = ! empty( $settings->btn_bg_hover ) ? FLBuilderColor::hex_or_rgb( $settings->btn_bg_hover ) : '';
$btn_text_hover    = ! empty( $settings->btn_text_hover ) ? FLBuilderColor::hex_or_rgb( $settings->btn_text_hover ) : '';

$btn_border_radius = isset( $settings->btn_border_radius ) ? intval( $settings->btn_border_radius ) : 6;
$btn_border_width  = isset( $settings->btn_border_width ) ? intval( $settings->btn_border_width ) : 2;
$btn_border_color  = ! empty( $settings->btn_border_color ) ? FLBuilderColor::hex_or_rgb( $settings->btn_border_color ) : '';
$btn_border_hover  = ! empty( $settings->btn_border_hover_color ) ? FLBuilderColor::hex_or_rgb( $settings->btn_border_hover_color ) : '';

$btn_size_preset   = isset( $settings->btn_size_preset ) ? $settings->btn_size_preset : 'custom';
if ( 'custom' === $btn_size_preset ) {
    $pad_h     = isset( $settings->btn_padding_h ) ? intval( $settings->btn_padding_h ) : 24;
    $pad_v     = isset( $settings->btn_padding_v ) ? intval( $settings->btn_padding_v ) : 12;
    $font_size = isset( $settings->btn_font_size ) ? intval( $settings->btn_font_size ) : 15;
} else {
    $presets = array(
        'small'  => array( 'pad_h' => 16, 'pad_v' => 8,  'font_size' => 13 ),
        'medium' => array( 'pad_h' => 24, 'pad_v' => 12, 'font_size' => 15 ),
        'large'  => array( 'pad_h' => 36, 'pad_v' => 16, 'font_size' => 18 ),
    );
    $p        = $presets[ $btn_size_preset ];
    $pad_h    = $p['pad_h'];
    $pad_v    = $p['pad_v'];
    $font_size = $p['font_size'];
}

$font_weight     = isset( $settings->btn_font_weight ) ? intval( $settings->btn_font_weight ) : 600;
$letter_spacing  = isset( $settings->btn_letter_spacing ) ? floatval( $settings->btn_letter_spacing ) : 0;
$show_shadow     = isset( $settings->btn_box_shadow ) ? $settings->btn_box_shadow : 'no';
$shadow_hover    = isset( $settings->btn_shadow_hover ) ? $settings->btn_shadow_hover : 'no';

// ── Style-specific overrides ──────────────────────────
// Outlined: fallback border_color ke bg_color
if ( 'outlined' === $btn_style && empty( $btn_border_color ) ) {
    $btn_border_color = $btn_bg;
}
// Outlined: text color selalu ikut border
if ( 'outlined' === $btn_style ) {
    $btn_text = $btn_border_color;
}
// Ghost: text_color pakai bg_color
if ( 'ghost' === $btn_style ) {
    $btn_text = $btn_bg;
}
// Ghost: fallback bg_hover ke bg_color
if ( 'ghost' === $btn_style && empty( $btn_bg_hover ) ) {
    $btn_bg_hover = $btn_bg;
}
// Ghost: hover text jadi putih biar kontras
if ( 'ghost' === $btn_style && empty( $btn_text_hover ) ) {
    $btn_text_hover = '#ffffff';
}
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
<?php if ( 'yes' === $settings->featured && ! empty( $settings->btn_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-pricelist-card--featured {
    border-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_color ); ?>;
}
.fl-node-<?php echo $id; ?> .wsbb-pricelist-badge {
    background: <?php echo FLBuilderColor::hex_or_rgb( $settings->btn_bg_color ); ?>;
}
<?php endif; ?>
