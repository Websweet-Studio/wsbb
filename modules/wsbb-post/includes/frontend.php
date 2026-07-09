<?php
$query_source = isset($settings->query_source) ? $settings->query_source : 'custom';
$layout_type  = isset($settings->layout_type) ? $settings->layout_type : 'grid';
$is_custom    = isset($settings->layout_content) && $settings->layout_content === 'custom';
$paged        = get_query_var('paged') ? get_query_var('paged') : 1;

// ── Query ──────────────────────────────────────────────────
$query = null;
$total_pages = 1;

if ($query_source === 'main') {
  global $wp_query;
  $query       = $wp_query;
  $total_pages = $query->max_num_pages;
} else {
  $query_args = Wsbb_Post::build_query_args($settings, $paged);
  $query      = new WP_Query($query_args);
  $total_pages = $query->max_num_pages;
}

// ── Layout classes ─────────────────────────────────────────
$wrapper_class  = 'wsbb-post-wrapper';
$wrapper_class .= ' wsbb-post-' . $layout_type;

$carousel_data = '';
if ($layout_type === 'carousel') {
  $carousel_slides = isset($settings->carousel_slides) ? intval($settings->carousel_slides) : 3;
  $carousel_data = sprintf(
    ' data-slides="%d" data-autoplay="%s" data-autoplay-speed="%s" data-arrows="%s" data-dots="%s" data-loop="%s"',
    $carousel_slides,
    isset($settings->carousel_autoplay) ? $settings->carousel_autoplay : 'yes',
    isset($settings->carousel_autoplay_speed) ? $settings->carousel_autoplay_speed : '4000',
    isset($settings->carousel_arrows) ? $settings->carousel_arrows : 'yes',
    isset($settings->carousel_dots) ? $settings->carousel_dots : 'no',
    isset($settings->carousel_loop) ? $settings->carousel_loop : 'yes'
  );
}

// ── Style: image size ──────────────────────────────────────
$image_size = isset($settings->image_size) ? $settings->image_size : 'medium_large';
?>

<div <?php $module->render_attributes(); ?>>
  <?php if ($query && $query->have_posts()) : ?>

    <?php if ($layout_type === 'carousel') : ?>
      <div class="wsbb-post-carousel">
        <div class="wsbb-post-carousel-track" <?php echo $carousel_data; ?>>
        <?php else : ?>
          <div class="<?php echo esc_attr($wrapper_class); ?>">
          <?php endif; ?>

          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="wsbb-post-item">
              <?php if ($is_custom) : ?>
                <?php echo Wsbb_Post::render_custom_layout($settings->custom_layout, get_the_ID()); ?>
              <?php else : ?>
                <div class="wsbb-post-item-inner">
                  <?php if (isset($settings->show_image) && $settings->show_image === 'yes' && has_post_thumbnail()) : ?>
                    <div class="wsbb-post-image">
                      <a class="wsbb-post-image-link" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail($image_size, array('loading' => 'lazy')); ?>
                      </a>
                    </div>
                  <?php endif; ?>

                  <div class="wsbb-post-content">
                    <?php if ((isset($settings->show_date) && $settings->show_date === 'yes') || (isset($settings->show_author) && $settings->show_author === 'yes')) : ?>
                      <div class="wsbb-post-meta">
                        <?php if (isset($settings->show_date) && $settings->show_date === 'yes') : ?>
                          <span class="wsbb-post-date"><?php echo get_the_date(); ?></span>
                        <?php endif; ?>
                        <?php if (isset($settings->show_author) && $settings->show_author === 'yes') : ?>
                          <span class="wsbb-post-author"><?php the_author(); ?></span>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>

                    <?php if (isset($settings->show_title) && $settings->show_title === 'yes') : ?>
                      <h3 class="wsbb-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                      </h3>
                    <?php endif; ?>

                    <?php if (isset($settings->show_excerpt) && $settings->show_excerpt === 'yes') : ?>
                      <div class="wsbb-post-excerpt">
                        <?php
                        $length = isset($settings->excerpt_length) ? intval($settings->excerpt_length) : 20;
                        echo wp_trim_words(get_the_excerpt(), $length, '...');
                        ?>
                      </div>
                    <?php endif; ?>

                    <?php if (!empty($settings->read_more_text)) :
                      $btn_style = !empty($settings->btn_style) ? $settings->btn_style : 'filled';
                      $btn_size  = !empty($settings->btn_size_preset) ? $settings->btn_size_preset : 'custom';
                      $btn_full  = !empty($settings->btn_full_width) && 'yes' === $settings->btn_full_width;
                      $btn_class = 'wsbb-post-readmore wsbb-post-btn--' . $btn_style . ' wsbb-post-btn-size--' . $btn_size;
                      if ($btn_full) $btn_class .= ' wsbb-post-btn--full';
                    ?>
                      <a class="<?php echo esc_attr($btn_class); ?>" href="<?php the_permalink(); ?>">
                        <?php echo esc_html($settings->read_more_text); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>

          <?php if ($layout_type === 'carousel') : ?>
          </div><!-- .wsbb-post-carousel-track -->

          <?php if (isset($settings->carousel_arrows) && $settings->carousel_arrows === 'yes') : ?>
            <button class="wsbb-carousel-prev" aria-label="<?php esc_attr_e('Previous', 'wsbb'); ?>">‹</button>
            <button class="wsbb-carousel-next" aria-label="<?php esc_attr_e('Next', 'wsbb'); ?>">›</button>
          <?php endif; ?>

          <?php if (isset($settings->carousel_dots) && $settings->carousel_dots === 'yes') : ?>
            <div class="wsbb-carousel-dots"></div>
          <?php endif; ?>
        </div><!-- .wsbb-post-carousel -->
      <?php else : ?>
      </div><!-- .wsbb-post-wrapper -->
    <?php endif; ?>

    <?php if (isset($settings->enable_pagination) && $settings->enable_pagination === 'yes' && $total_pages > 1) : ?>
      <div class="wsbb-post-pagination">
        <?php if ($query_source !== 'main') : ?>
          <?php if (isset($settings->pagination_type) && $settings->pagination_type === 'prev_next') : ?>
            <?php
            $big = 999999999;
            echo paginate_links(array(
              'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
              'format'  => '?paged=%#%',
              'current' => max(1, $paged),
              'total'   => $total_pages,
              'type'    => 'list',
              'prev_text' => '‹ ' . __('Prev', 'wsbb'),
              'next_text' => __('Next', 'wsbb') . ' ›',
            ));
            ?>
          <?php else : ?>
            <?php
            $big = 999999999;
            echo paginate_links(array(
              'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
              'format'  => '?paged=%#%',
              'current' => max(1, $paged),
              'total'   => $total_pages,
              'type'    => 'list',
              'prev_text' => '‹',
              'next_text' => '›',
            ));
            ?>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  <?php else : ?>
    <p class="wsbb-post-empty"><?php _e('No posts found.', 'wsbb'); ?></p>
  <?php endif; ?>
</div>

<?php
if ($query && $query_source !== 'main') {
  wp_reset_postdata();
}
?>