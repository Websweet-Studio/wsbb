.fl-node-<?php echo $id; ?> .wsbb-gallery-grid {
  gap: <?php echo intval($settings->gap); ?>px;
}

.fl-node-<?php echo $id; ?> .wsbb-gallery-item-inner {
  border-radius: <?php echo intval($settings->border_radius); ?>px;
}

<?php if ($settings->layout_style === 'masonry'): ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-masonry {
  column-count: <?php echo intval($settings->columns); ?>;
  column-gap: <?php echo intval($settings->gap); ?>px;
}

.fl-node-<?php echo $id; ?> .wsbb-gallery-masonry .wsbb-gallery-item {
  margin-bottom: <?php echo intval($settings->gap); ?>px;
}

@media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-gallery-masonry {
    column-count: <?php echo intval($settings->columns_medium); ?>;
  }
}

@media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-gallery-masonry {
    column-count: <?php echo intval($settings->columns_responsive); ?>;
  }
}
<?php else: ?>
.fl-node-<?php echo $id; ?> .wsbb-gallery-item {
  flex: 0 0 calc((100% - (<?php echo intval($settings->columns); ?> - 1) * <?php echo intval($settings->gap); ?>px) / <?php echo intval($settings->columns); ?>);
  max-width: calc((100% - (<?php echo intval($settings->columns); ?> - 1) * <?php echo intval($settings->gap); ?>px) / <?php echo intval($settings->columns); ?>);
}

@media (max-width: 992px) {
  .fl-node-<?php echo $id; ?> .wsbb-gallery-item {
    flex: 0 0 calc((100% - (<?php echo intval($settings->columns_medium); ?> - 1) * <?php echo intval($settings->gap); ?>px) / <?php echo intval($settings->columns_medium); ?>);
    max-width: calc((100% - (<?php echo intval($settings->columns_medium); ?> - 1) * <?php echo intval($settings->gap); ?>px) / <?php echo intval($settings->columns_medium); ?>);
  }
}

@media (max-width: 600px) {
  .fl-node-<?php echo $id; ?> .wsbb-gallery-item {
    flex: 0 0 calc((100% - (<?php echo intval($settings->columns_responsive); ?> - 1) * <?php echo intval($settings->gap); ?>px) / <?php echo intval($settings->columns_responsive); ?>);
    max-width: calc((100% - (<?php echo intval($settings->columns_responsive); ?> - 1) * <?php echo intval($settings->gap); ?>px) / <?php echo intval($settings->columns_responsive); ?>);
  }
}
<?php endif; ?>
