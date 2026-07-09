<?php
// ── Heading ────────────────────────────────────────────
$h_font = ! empty($settings->heading_font) ? $settings->heading_font : array();
$h_size = ! empty($settings->heading_size) ? intval($settings->heading_size) : '';

// ── Button via shared helper ─────────────────────────
include_once WSBB_PLUGIN_DIR . 'includes/button-style-helpers.php';
$btn = wsbb_get_button_vars($settings, 'btn_');
extract($btn);
?>
/* ── Background image + overlay ──────────────────────── */
<?php if (! empty($settings->bg_image)) :
    $bg_img_src = wp_get_attachment_image_url($settings->bg_image, 'large');
?>
    .fl-node-<?php echo $id; ?> .wsbb-action-inner {
    position: relative;
    background-image: url('<?php echo esc_url($bg_img_src); ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    }
    <?php if (! empty($settings->bg_overlay)) : ?>
        .fl-node-<?php echo $id; ?> .wsbb-action-inner::before {
        content: '';
        position: absolute;
        inset: 0;
        background-color: <?php echo FLBuilderColor::hex_or_rgb($settings->bg_overlay); ?>;
        z-index: 0;
        pointer-events: none;
        }
        .fl-node-<?php echo $id; ?> .wsbb-action-content,
        .fl-node-<?php echo $id; ?> .wsbb-action-btn-wrap {
        position: relative;
        z-index: 1;
        }
    <?php endif; ?>
<?php endif; ?>

/* ── Container width ──────────────────────────────────── */
<?php
$container_width = ! empty($settings->container_width) ? $settings->container_width : 'full';
if ('narrow' === $container_width) : ?>
    .fl-node-<?php echo $id; ?> .wsbb-action-inner {
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    }
<?php elseif ('medium' === $container_width) : ?>
    .fl-node-<?php echo $id; ?> .wsbb-action-inner {
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    }
<?php endif; ?>

/* ── Gap heading–description ──────────────────────────── */
<?php
$gap_hd = isset($settings->gap_head_desc) ? intval($settings->gap_head_desc) : 8;
?>
.fl-node-<?php echo $id; ?> .wsbb-action-desc {
margin-top: <?php echo $gap_hd; ?>px;
}

/* ── Heading ──────────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-action-heading {
<?php if (! empty($h_font['family']) && 'Default' !== $h_font['family']) : ?>
    font-family: <?php echo esc_attr($h_font['family']); ?>;
<?php endif; ?>
<?php if (! empty($h_font['weight'])) : ?>
    font-weight: <?php echo esc_attr($h_font['weight']); ?>;
<?php endif; ?>
<?php if (! empty($settings->heading_color)) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb($settings->heading_color); ?>;
<?php endif; ?>
<?php if ($h_size) : ?>
    font-size: <?php echo $h_size; ?>px;
<?php endif; ?>
}

<?php if (! empty($settings->desc_color)) : ?>
    .fl-node-<?php echo $id; ?> .wsbb-action-desc {
    color: <?php echo FLBuilderColor::hex_or_rgb($settings->desc_color); ?>;
    }
<?php endif; ?>

/* ── Button base ─────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-action-btn {
color: <?php echo $btn_text; ?>;
background-color: <?php echo $btn_bg; ?>;
border-radius: <?php echo $btn_border_radius; ?>px;
border: <?php echo $btn_border_width; ?>px solid <?php echo $btn_border_color ?: 'transparent'; ?>;
padding: <?php echo $pad_v; ?>px <?php echo $pad_h; ?>px;
font-size: <?php echo $font_size; ?>px;
font-weight: <?php echo $font_weight; ?>;
<?php if ($letter_spacing > 0) : ?>
    letter-spacing: <?php echo $letter_spacing; ?>px;
<?php endif; ?>
<?php if ('yes' === $show_shadow) : ?>
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
<?php endif; ?>
}

/* ── Outlined / Ghost → transparent bg ──────────────── */
<?php if ('outlined' === $btn_style || 'ghost' === $btn_style) : ?>
    .fl-node-<?php echo $id; ?> .wsbb-action-btn--<?php echo $btn_style; ?> {
    background: transparent;
    }
<?php endif; ?>

/* ── Button hover ────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-action-btn:hover {
<?php if (! empty($btn_text_hover)) : ?>
    color: <?php echo $btn_text_hover; ?>;
<?php endif; ?>
<?php if (! empty($btn_bg_hover)) : ?>
    background-color: <?php echo $btn_bg_hover; ?>;
<?php endif; ?>
<?php if (! empty($btn_border_hover)) : ?>
    border-color: <?php echo $btn_border_hover; ?>;
<?php endif; ?>
<?php if ('yes' === $shadow_hover) : ?>
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
<?php endif; ?>
}