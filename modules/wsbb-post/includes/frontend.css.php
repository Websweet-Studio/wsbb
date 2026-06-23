<?php
$layout_type = isset($settings->layout_type) ? $settings->layout_type : 'grid';
$is_custom   = isset($settings->layout_content) && $settings->layout_content === 'custom';
$gap         = isset($settings->gap) ? intval($settings->gap) : 20;
?>

/* ===== Grid Layout ===== */
<?php if ($layout_type === 'grid'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  display: grid;
  grid-template-columns: repeat(<?php echo intval($settings->columns); ?>, 1fr);
  gap: <?php echo $gap; ?>px;
  }

  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  grid-template-columns: repeat(<?php echo intval($settings->columns_medium); ?>, 1fr);
  }
  }

  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  grid-template-columns: repeat(<?php echo intval($settings->columns_responsive); ?>, 1fr);
  }
  }
<?php endif; ?>

/* ===== Masonry Layout ===== */
<?php if ($layout_type === 'masonry'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  column-count: <?php echo intval($settings->columns); ?>;
  column-gap: <?php echo $gap; ?>px;
  }

  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  break-inside: avoid;
  margin-bottom: <?php echo $gap; ?>px;
  }

  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  column-count: <?php echo intval($settings->columns_medium); ?>;
  }
  }

  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  column-count: <?php echo intval($settings->columns_responsive); ?>;
  }
  }
<?php endif; ?>

/* ===== List Layout ===== */
<?php if ($layout_type === 'list'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-wrapper {
  display: flex;
  flex-direction: column;
  gap: <?php echo $gap; ?>px;
  }
<?php endif; ?>

/* ===== Carousel Layout ===== */
<?php if ($layout_type === 'carousel'): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  flex: 0 0 calc((100% - (<?php echo intval($settings->carousel_slides); ?> - 1) * <?php echo intval($settings->carousel_gap); ?>px) / <?php echo intval($settings->carousel_slides); ?>);
  }
<?php endif; ?>

/* ===== Common ===== */
.fl-node-<?php echo $id; ?> .wsbb-post-item-inner {
border-radius: <?php echo intval($settings->border_radius); ?>px;
}

<?php if (!$is_custom): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-image img {
  height: <?php echo intval($settings->image_height); ?>px;
  object-fit: cover;
  }
<?php endif; ?>

.fl-node-<?php echo $id; ?> .wsbb-post-pagination {
text-align: <?php echo esc_attr($settings->pagination_align); ?>;
}

/* ===== Custom Card CSS ===== */
<?php if ($is_custom && !empty($settings->custom_css_field)): ?>
  <?php echo $settings->custom_css_field; ?>

<?php endif; ?>