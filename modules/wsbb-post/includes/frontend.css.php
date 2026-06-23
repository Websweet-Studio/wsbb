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
<?php if ($is_custom && !empty($settings->custom_css)): ?>
<?php
  // Scope user CSS to this module instance to prevent leaking to other modules
  $css = $settings->custom_css;
  $css = preg_replace_callback(
    '/([^{}]+)(\{[^}]*\})/',
    function ($m) use ($id) {
      $selector = trim($m[1]);
      // Skip comment-only lines (no actual selector)
      if ($selector === '' || strpos($selector, '/*') === 0) {
        if (strpos(trim($m[2]), '/*') === false) {
          return '.fl-node-' . $id . ' ' . $m[2];
        }
        return $m[0];
      }
      return '.fl-node-' . $id . ' ' . $selector . ' ' . $m[2];
    },
    $css
  );
  echo $css;
?>
<?php endif; ?>
