<?php
// Instance-specific CSS
$cols_resp = ! empty( $settings->columns_responsive ) ? intval( $settings->columns_responsive ) : 1;
?>

<?php if ( ! empty( $settings->columns ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-testimoni-grid {
    --wsbb-cols: <?php echo intval( $settings->columns ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->columns_medium ) ) : ?>
@media ( max-width: 992px ) {
    .fl-node-<?php echo $id; ?> .wsbb-testimoni-grid {
        --wsbb-cols: <?php echo intval( $settings->columns_medium ); ?>;
    }
}
<?php endif; ?>

<?php if ( ! empty( $settings->columns_responsive ) ) : ?>
@media ( max-width: 600px ) {
    .fl-node-<?php echo $id; ?> .wsbb-testimoni-grid {
        --wsbb-cols: <?php echo $cols_resp; ?>;
    }
}
<?php endif; ?>

<?php if ( ! empty( $settings->gap ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-testimoni-grid {
    gap: <?php echo intval( $settings->gap ); ?>px;
}
<?php endif; ?>

/* ── Avatar size ───────────────────────────────────────── */
<?php if ( ! empty( $settings->avatar_size ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-testimoni-avatar img {
    width: <?php echo intval( $settings->avatar_size ); ?>px;
    height: <?php echo intval( $settings->avatar_size ); ?>px;
}
<?php endif; ?>

/* ── Card style ────────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-testimoni-item-inner {
<?php if ( ! empty( $settings->card_bg_color ) ) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->card_bg_color ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->card_padding ) ) : ?>
    padding: <?php echo esc_attr( $settings->card_padding ); ?>;
<?php endif; ?>
<?php if ( ! empty( $settings->border_radius ) ) : ?>
    border-radius: <?php echo intval( $settings->border_radius ); ?>px;
<?php endif; ?>
}

/* ── Typography colors ─────────────────────────────────── */
<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-testimoni-text {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->name_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-testimoni-name {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->name_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->role_color ) ) : ?>
.fl-node-<?php echo $id; ?> .wsbb-testimoni-role {
    color: <?php echo FLBuilderColor::hex_or_rgb( $settings->role_color ); ?>;
}
<?php endif; ?>
