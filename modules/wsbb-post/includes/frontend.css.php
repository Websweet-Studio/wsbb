.fl-node-<?php echo $id; ?> .wsbb-post-grid {
  gap: <?php echo intval($settings->gap); ?>px;
}

<?php if ($settings->layout_style === 'grid'): ?>
.fl-node-<?php echo $id; ?> .wsbb-post-grid {
  display: grid;
  grid-template-columns: repeat(<?php echo intval($settings->columns); ?>, 1fr);
}

@media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-grid {
    grid-template-columns: repeat(<?php echo intval($settings->columns_medium); ?>, 1fr);
  }
}

@media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-post-grid {
    grid-template-columns: repeat(<?php echo intval($settings->columns_responsive); ?>, 1fr);
  }
}
<?php else: ?>
.fl-node-<?php echo $id; ?> .wsbb-post-grid {
  display: flex;
  flex-direction: column;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .wsbb-post-item-inner {
  border-radius: <?php echo intval($settings->border_radius); ?>px;
}

.fl-node-<?php echo $id; ?> .wsbb-post-image img {
  height: <?php echo intval($settings->image_height); ?>px;
  object-fit: cover;
}

.fl-node-<?php echo $id; ?> .wsbb-post-pagination {
  text-align: <?php echo esc_attr($settings->pagination_align); ?>;
}
