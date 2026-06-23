<?php
$aspect = isset($settings->aspect_ratio) ? $settings->aspect_ratio : '16-9';
?>

/* ===== Aspect Ratio ===== */
<?php if ($aspect !== 'original'): ?>
.fl-node-<?php echo $id; ?> .wsbb-ic-img {
  aspect-ratio: <?php echo str_replace('-', '/', $aspect); ?>;
  object-fit: cover;
}
<?php endif; ?>

/* ===== Border Radius ===== */
.fl-node-<?php echo $id; ?> .wsbb-ic-img {
  border-radius: <?php echo intval($settings->border_radius); ?>px;
}

/* ===== Grid Columns ===== */
<?php $display_mode = isset($settings->display_mode) ? $settings->display_mode : 'grid'; ?>
<?php if ($display_mode === 'list'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-ic-list {
    --wsbb-cols: 1;
  }
<?php endif; ?>

@media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-ic-grid {
    --wsbb-cols: <?php echo intval($settings->columns_medium); ?>;
  }
}

@media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-ic-grid {
    --wsbb-cols: <?php echo intval($settings->columns_responsive); ?>;
  }
}
