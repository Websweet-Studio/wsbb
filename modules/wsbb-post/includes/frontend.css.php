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
<?php if ($layout_type === 'carousel'):
  $carousel_gap = isset($settings->carousel_gap) ? intval($settings->carousel_gap) : 20;
  $carousel_slides = isset($settings->carousel_slides) ? intval($settings->carousel_slides) : 3;
  $carousel_slides_medium = isset($settings->carousel_slides_medium) ? intval($settings->carousel_slides_medium) : 2;
  $carousel_slides_responsive = isset($settings->carousel_slides_responsive) ? intval($settings->carousel_slides_responsive) : 1;
?>
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  flex: 0 0 calc((100% - (<?php echo $carousel_slides; ?> - 1) * <?php echo $carousel_gap; ?>px) / <?php echo $carousel_slides; ?>);
  }

  .fl-node-<?php echo $id; ?> .wsbb-post-carousel-track {
  gap: <?php echo $carousel_gap; ?>px;
  }

  @media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  flex: 0 0 calc((100% - (<?php echo $carousel_slides_medium; ?> - 1) * <?php echo $carousel_gap; ?>px) / <?php echo $carousel_slides_medium; ?>);
  }
  }

  @media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-item {
  flex: 0 0 calc((100% - (<?php echo $carousel_slides_responsive; ?> - 1) * <?php echo $carousel_gap; ?>px) / <?php echo $carousel_slides_responsive; ?>);
  }
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

/* ===== Style Tab: Typography ===== */
<?php if (!empty($settings->title_font)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-title a {
  <?php if (!empty($settings->title_font['family']) && 'Default' !== $settings->title_font['family']): ?>
    font-family: <?php echo esc_attr($settings->title_font['family']); ?>;
  <?php endif; ?>
  <?php if (!empty($settings->title_font['weight'])): ?>
    font-weight: <?php echo esc_attr($settings->title_font['weight']); ?>;
  <?php endif; ?>
  }
<?php endif; ?>

<?php if (!empty($settings->title_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-title a {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->title_color); ?>;
  }
<?php endif; ?>

<?php if (!empty($settings->meta_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-meta,
  .fl-node-<?php echo $id; ?> .wsbb-post-date,
  .fl-node-<?php echo $id; ?> .wsbb-post-author {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->meta_color); ?>;
  }
<?php endif; ?>

<?php if (!empty($settings->excerpt_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-excerpt {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->excerpt_color); ?>;
  }
<?php endif; ?>

<?php if (!empty($settings->readmore_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-readmore {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->readmore_color); ?>;
  }
<?php endif; ?>

<?php if (!empty($settings->readmore_hover_color)): ?>
  .fl-node-<?php echo $id; ?> .wsbb-post-readmore:hover {
  color: <?php echo FLBuilderColor::hex_or_rgb($settings->readmore_hover_color); ?>;
  }
<?php endif; ?>

/* ===== Custom Card CSS ===== */
<?php if ($is_custom && !empty($settings->custom_css_field)): ?>
  <?php echo $settings->custom_css_field; ?>

<?php endif; ?>