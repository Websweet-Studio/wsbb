<?php
$layout_type = isset($settings->layout_type) ? $settings->layout_type : 'grid';
$gap         = isset($settings->gap) ? intval($settings->gap) : 20;
?>

/* ===== Grid Layout ===== */
<?php if ($layout_type === 'grid'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-testimoni-wrapper {
  display: grid;
  grid-template-columns: repeat(<?php echo intval($settings->columns); ?>, 1fr);
  gap: <?php echo $gap; ?>px;
  }

  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-testimoni-wrapper {
  grid-template-columns: repeat(<?php echo intval($settings->columns_medium); ?>, 1fr);
  }
  }

  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-testimoni-wrapper {
  grid-template-columns: repeat(<?php echo intval($settings->columns_responsive); ?>, 1fr);
  }
  }
<?php endif; ?>

/* ===== List Layout ===== */
<?php if ($layout_type === 'list'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-testimoni-wrapper {
  display: flex;
  flex-direction: column;
  gap: <?php echo $gap; ?>px;
  }
<?php endif; ?>

/* ===== Carousel Layout ===== */
<?php if ($layout_type === 'carousel'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-testimoni-item {
  flex: 0 0 calc((100% - (<?php echo intval($settings->carousel_slides); ?> - 1) * <?php echo intval($settings->carousel_gap); ?>px) / <?php echo intval($settings->carousel_slides); ?>);
  }
<?php endif; ?>

/* ===== Common ===== */
.fl-node-<?php echo $id; ?> .wsbb-testimoni-item-inner {
border-radius: <?php echo intval($settings->border_radius); ?>px;
}

.fl-node-<?php echo $id; ?> .wsbb-testimoni-avatar img {
width: <?php echo intval($settings->avatar_size); ?>px;
height: <?php echo intval($settings->avatar_size); ?>px;
}
