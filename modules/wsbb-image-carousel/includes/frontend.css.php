<?php
// Instance-specific CSS
$cols_medium     = ! empty( $settings->columns_medium ) ? intval( $settings->columns_medium ) : 3;
$cols_responsive = ! empty( $settings->columns_responsive ) ? intval( $settings->columns_responsive ) : 1;
$gap_val         = ! empty( $settings->gap ) ? intval( $settings->gap ) : 10;

/* Carousel / grid columns */
if ( ! empty( $settings->display_mode ) && 'carousel' !== $settings->display_mode ) :
    $cols = ! empty( $settings->columns ) ? intval( $settings->columns ) : 4;
?>
.fl-node-<?php echo $id; ?> .wsbb-ic-grid {
    --wsbb-cols: <?php echo $cols; ?>;
    --wsbb-gap: <?php echo $gap_val; ?>px;
}
<?php if ( $cols_medium !== $cols || $cols_responsive !== 1 ) : ?>
@media ( max-width: 992px ) {
    .fl-node-<?php echo $id; ?> .wsbb-ic-grid {
        --wsbb-cols: <?php echo $cols_medium; ?>;
    }
}
@media ( max-width: 600px ) {
    .fl-node-<?php echo $id; ?> .wsbb-ic-grid {
        --wsbb-cols: <?php echo $cols_responsive; ?>;
    }
}
<?php endif; ?>
<?php endif; ?>

/* ── Carousel settings ─────────────────────────────────── */
<?php if ( ! empty( $settings->display_mode ) && 'carousel' === $settings->display_mode ) : ?>
<?php
$slides = ! empty( $settings->carousel_slides ) ? intval( $settings->carousel_slides ) : 3;
$slides_medium = ! empty( $settings->slides_medium ) ? intval( $settings->slides_medium ) : 2;
$slides_resp   = ! empty( $settings->slides_responsive ) ? intval( $settings->slides_responsive ) : 1;
?>
.fl-node-<?php echo $id; ?> .wsbb-ic-carousel {
    --wsbb-slides: <?php echo $slides; ?>;
    --wsbb-gap: <?php echo $gap_val; ?>px;
}
.fl-node-<?php echo $id; ?> .wsbb-ic-track {
    gap: <?php echo $gap_val; ?>px;
}
@media ( max-width: 992px ) {
    .fl-node-<?php echo $id; ?> .wsbb-ic-carousel {
        --wsbb-slides: <?php echo $slides_medium; ?>;
    }
}
@media ( max-width: 600px ) {
    .fl-node-<?php echo $id; ?> .wsbb-ic-carousel {
        --wsbb-slides: <?php echo $slides_resp; ?>;
    }
}
<?php endif; ?>

/* ── Rows ──────────────────────────────────────────────── */
<?php if ( ! empty( $settings->rows ) && 'carousel' !== $settings->display_mode ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-ic-grid {
    grid-template-rows: repeat(<?php echo intval( $settings->rows ); ?>, auto);
}
<?php endif; ?>

/* ── Border radius ─────────────────────────────────────── */
<?php if ( ! empty( $settings->border_radius ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-ic-item img {
    border-radius: <?php echo intval( $settings->border_radius ); ?>px;
}
<?php endif; ?>

/* ── Aspect ratio ──────────────────────────────────────── */
<?php if ( ! empty( $settings->aspect_ratio ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-ic-item,
.fl-node-<?php echo $id; ?> .wsbb-ic-item img {
    aspect-ratio: <?php echo esc_attr( $settings->aspect_ratio ); ?>;
    object-fit: cover;
}
<?php endif; ?>

/* ── Style: box, caption color, bg ─────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-ic-wrapper {
<?php if ( ! empty( $settings->background_color ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->background_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->padding ) ) : ?>
    padding: <?php echo esc_attr( $settings->padding ); ?>;
<?php endif; ?>
}

<?php if ( ! empty( $settings->caption_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-ic-caption {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->caption_color ); ?>;
}
<?php endif; ?>
