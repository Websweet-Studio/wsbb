<?php
// Instance-specific CSS
?>

/* ── Grid columns ─────────────────────────────────────── */
<?php if ( ! empty( $settings->columns ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-grid {
    --wsbb-cols: <?php echo intval( $settings->columns ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->columns_medium ) ) : ?>
@media ( max-width: 992px ) {
    .fl-node-<?php echo $id; ?> .wsbb-gallery-grid {
        --wsbb-cols: <?php echo intval( $settings->columns_medium ); ?>;
    }
}
<?php endif; ?>

<?php if ( ! empty( $settings->columns_responsive ) ) : ?>
@media ( max-width: 600px ) {
    .fl-node-<?php echo $id; ?> .wsbb-gallery-grid {
        --wsbb-cols: <?php echo intval( $settings->columns_responsive ); ?>;
    }
}
<?php endif; ?>

<?php if ( ! empty( $settings->gap ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-grid {
    gap: <?php echo intval( $settings->gap ); ?>px;
}
<?php endif; ?>

/* ── Aspect ratio ──────────────────────────────────────── */
<?php if ( ! empty( $settings->aspect_ratio ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner {
    aspect-ratio: <?php echo esc_attr( $settings->aspect_ratio ); ?>;
    object-fit: cover;
}
<?php endif; ?>

/* ── Layout style: masonry ─────────────────────────────── */
<?php if ( ! empty( $settings->layout_style ) && 'masonry' === $settings->layout_style ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-grid {
    column-count: <?php echo intval( $settings->columns ?: 3 ); ?>;
    column-gap: <?php echo intval( $settings->gap ?: 10 ); ?>px;
    display: block;
}
.fl-node-<?php echo $id; ?> .wsbb-gallery-item {
    break-inside: avoid;
    margin-bottom: <?php echo intval( $settings->gap ?: 10 ); ?>px;
}
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner {
    aspect-ratio: auto;
    display: block;
    width: 100%;
    height: auto;
}
<?php endif; ?>

/* ── Border radius ─────────────────────────────────────── */
<?php if ( ! empty( $settings->border_radius ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner,
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner img {
    border-radius: <?php echo intval( $settings->border_radius ); ?>px;
}
<?php endif; ?>

/* ── Hover effect ──────────────────────────────────────── */
<?php if ( ! empty( $settings->hover_effect ) && 'zoom' === $settings->hover_effect ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner img {
    transition: transform 0.3s;
}
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner:hover img {
    transform: scale(1.1);
}
<?php elseif ( ! empty( $settings->hover_effect ) && 'fade' === $settings->hover_effect ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner {
    transition: opacity 0.3s;
}
.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner:hover {
    opacity: 0.7;
}
<?php endif; ?>

/* ── Style: box, caption color, bg ─────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-gallery-grid {
<?php if ( ! empty( $settings->background_color ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->background_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->padding ) ) : ?>
    padding: <?php echo esc_attr( $settings->padding ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->caption_color ) ) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->caption_color ); ?>;
<?php endif; ?>
}
