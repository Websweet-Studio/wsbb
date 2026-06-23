<div <?php $module->render_attributes(); ?>>
  <div class="wsbb-gallery-grid wsbb-gallery-<?php echo esc_attr($settings->layout_style); ?> wsbb-aspect-<?php echo esc_attr($settings->aspect_ratio); ?> wsbb-hover-<?php echo esc_attr($settings->hover_effect); ?>">
    <?php if (!empty($settings->photos)): ?>
      <?php foreach ($settings->photos as $index => $photo_id): ?>
        <?php
          $size = ($settings->layout_style === 'masonry') ? 'large' : 'medium_large';
          $img_data = wp_get_attachment_image_src(intval($photo_id), $size);
          $img_src  = $img_data ? esc_url($img_data[0]) : '';

          $full_data = wp_get_attachment_image_src(intval($photo_id), 'full');
          $full_img  = $full_data ? esc_url($full_data[0]) : $img_src;

          if (empty($img_src)) {
              continue;
          }

          $alt_text   = get_post_meta(intval($photo_id), '_wp_attachment_image_alt', true);
          $caption    = !empty($alt_text) ? esc_html($alt_text) : '';
        ?>
        <div class="wsbb-gallery-item">
          <div class="wsbb-gallery-item-inner">
            <?php if ($settings->enable_lightbox === 'yes'): ?>
              <a href="<?php echo $full_img; ?>"
                 class="wsbb-gallery-link"
                 data-caption="<?php echo $caption; ?>"
                 data-index="<?php echo $index; ?>">
                <img src="<?php echo $img_src; ?>"
                     alt="<?php echo $caption; ?>"
                     loading="lazy" />
              </a>
            <?php else: ?>
              <img src="<?php echo $img_src; ?>"
                   alt="<?php echo $caption; ?>"
                   loading="lazy" />
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <?php if ($settings->enable_lightbox === 'yes'): ?>
  <div class="wsbb-lightbox-overlay">
    <div class="wsbb-lightbox-close">&times;</div>
    <div class="wsbb-lightbox-prev">&lsaquo;</div>
    <div class="wsbb-lightbox-next">&rsaquo;</div>
    <div class="wsbb-lightbox-content">
      <img class="wsbb-lightbox-image" src="" alt="" />
      <div class="wsbb-lightbox-caption"></div>
    </div>
  </div>
  <?php endif; ?>
</div>
