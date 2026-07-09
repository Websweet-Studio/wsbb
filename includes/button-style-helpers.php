<?php
/**
 * Shared button-style helpers for WSBB modules.
 *
 * Usage: frontend.css.php
 *   include_once WSBB_PLUGIN_DIR . 'includes/button-style-helpers.php';
 *   $btn = wsbb_get_button_vars($settings, 'btn_');  // or '' for unprefixed
 *   extract($btn);
 *   ...CSS using $btn_style, $btn_bg, $btn_text, etc.
 *
 * @param object $settings FLBuilder module settings object.
 * @param string $p       Field name prefix (e.g. 'btn_' or '').
 * @return array          Processed button variables.
 */
function wsbb_get_button_vars( $settings, $p = '' ) {
    $style          = isset( $settings->{ $p . 'style' } ) ? $settings->{ $p . 'style' } : 'filled';
    $bg             = ! empty( $settings->{ $p . 'bg_color' } ) ? FLBuilderColor::hex_or_rgb( $settings->{ $p . 'bg_color' } ) : '#2962ff';
    $text           = ! empty( $settings->{ $p . 'text_color' } ) ? FLBuilderColor::hex_or_rgb( $settings->{ $p . 'text_color' } ) : '#ffffff';
    $bg_hover       = ! empty( $settings->{ $p . 'bg_hover' } ) ? FLBuilderColor::hex_or_rgb( $settings->{ $p . 'bg_hover' } ) : '';
    $text_hover     = ! empty( $settings->{ $p . 'text_hover' } ) ? FLBuilderColor::hex_or_rgb( $settings->{ $p . 'text_hover' } ) : '';
    $border_color   = ! empty( $settings->{ $p . 'border_color' } ) ? FLBuilderColor::hex_or_rgb( $settings->{ $p . 'border_color' } ) : '';
    $border_hover   = ! empty( $settings->{ $p . 'border_hover_color' } ) ? FLBuilderColor::hex_or_rgb( $settings->{ $p . 'border_hover_color' } ) : '';
    $border_radius  = isset( $settings->{ $p . 'border_radius' } ) ? intval( $settings->{ $p . 'border_radius' } ) : 4;
    $border_width   = isset( $settings->{ $p . 'border_width' } ) ? intval( $settings->{ $p . 'border_width' } ) : 2;
    $size_preset    = isset( $settings->{ $p . 'size_preset' } ) ? $settings->{ $p . 'size_preset' } : 'custom';
    $font_weight    = isset( $settings->{ $p . 'font_weight' } ) ? intval( $settings->{ $p . 'font_weight' } ) : 600;
    $letter_spacing = isset( $settings->{ $p . 'letter_spacing' } ) ? floatval( $settings->{ $p . 'letter_spacing' } ) : 0;
    $show_shadow    = isset( $settings->{ $p . 'box_shadow' } ) ? $settings->{ $p . 'box_shadow' } : 'no';
    $shadow_hover   = isset( $settings->{ $p . 'shadow_hover' } ) ? $settings->{ $p . 'shadow_hover' } : 'no';

    // Size preset → padding + font-size
    if ( 'custom' === $size_preset ) {
        $pad_h     = isset( $settings->{ $p . 'padding_h' } ) ? intval( $settings->{ $p . 'padding_h' } ) : 24;
        $pad_v     = isset( $settings->{ $p . 'padding_v' } ) ? intval( $settings->{ $p . 'padding_v' } ) : 12;
        $font_size = isset( $settings->{ $p . 'font_size' } ) ? intval( $settings->{ $p . 'font_size' } ) : 15;
    } else {
        $presets   = array(
            'small'  => array( 'pad_h' => 16, 'pad_v' => 8,  'font_size' => 13 ),
            'medium' => array( 'pad_h' => 24, 'pad_v' => 12, 'font_size' => 15 ),
            'large'  => array( 'pad_h' => 36, 'pad_v' => 16, 'font_size' => 18 ),
        );
        $p2        = $presets[ $size_preset ] ?? $presets['medium'];
        $pad_h     = $p2['pad_h'];
        $pad_v     = $p2['pad_v'];
        $font_size = $p2['font_size'];
    }

    // ── Style-specific overrides ──────────────────────────
    if ( 'outlined' === $style && empty( $border_color ) ) {
        $border_color = $bg;
    }
    if ( 'outlined' === $style ) {
        $text = $border_color;
    }
    if ( 'ghost' === $style ) {
        $text = $bg;
    }
    if ( 'ghost' === $style && empty( $bg_hover ) ) {
        $bg_hover = $bg;
    }
    if ( 'ghost' === $style && empty( $text_hover ) ) {
        $text_hover = '#ffffff';
    }

    return array(
        'btn_style'         => $style,
        'btn_bg'            => $bg,
        'btn_text'          => $text,
        'btn_bg_hover'      => $bg_hover,
        'btn_text_hover'    => $text_hover,
        'btn_border_color'  => $border_color,
        'btn_border_hover'  => $border_hover,
        'btn_border_radius' => $border_radius,
        'btn_border_width'  => $border_width,
        'btn_size_preset'   => $size_preset,
        'pad_h'             => $pad_h,
        'pad_v'             => $pad_v,
        'font_size'         => $font_size,
        'btn_font_weight'   => $font_weight,
        'btn_letter_spacing'=> $letter_spacing,
        'show_shadow'       => $show_shadow,
        'shadow_hover'      => $shadow_hover,
    );
}
