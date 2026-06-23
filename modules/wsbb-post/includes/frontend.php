<?php
$query_source = isset($settings->query_source) ? $settings->query_source : 'custom';

if ($query_source === 'main') {
    global $wp_query;
    $query = $wp_query;
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
} else {
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $query_args = array(
        'post_type'      => $settings->post_type,
        'posts_per_page' => intval($settings->posts_per_page),
        'orderby'        => $settings->orderby,
        'order'          => $settings->order,
        'paged'          => $paged,
    );

    $query = new WP_Query($query_args);
}

$layout_type    = isset($settings->layout_type) ? $settings->layout_type : 'grid';
$is_custom      = isset($settings->layout_content) && $settings->layout_content === 'custom';
$is_carousel    = $layout_type === 'carousel';
?>

<div <?php $module->render_attributes(); ?>>
  <?php if ($query->have_posts()): ?>
    <div class="wsbb-post-wrapper wsbb-post-<?php echo esc_attr($layout_type); ?>">

      <?php if ($is_carousel): ?>
      <div class="wsbb-post-carousel"
           data-slides="<?php echo intval($settings->carousel_slides); ?>"
           data-autoplay="<?php echo esc_attr($settings->carousel_autoplay); ?>"
           data-autoplay-speed="<?php echo intval($settings->carousel_autoplay_speed); ?>"
           data-arrows="<?php echo esc_attr($settings->carousel_arrows); ?>"
           data-dots="<?php echo esc_attr($settings->carousel_dots); ?>">

        <?php if ($settings->carousel_arrows === 'yes'): ?>
        <button class="wsbb-carousel-prev" type="button" aria-label="<?php _e('Previous', 'wsbb'); ?>">&lsaquo;</button>
        <?php endif; ?>

        <div class="wsbb-post-carousel-track">
      <?php endif; ?>

      <?php while ($query->have_posts()): $query->the_post(); ?>
        <article class="wsbb-post-item">
          <div class="wsbb-post-item-inner">
            <?php if ($is_custom): ?>
              <?php echo Wsbb_Post::render_custom_layout($settings->custom_layout, get_the_ID()); ?>
            <?php else: ?>
              <?php if ($settings->show_image === 'yes' && has_post_thumbnail()): ?>
                <div class="wsbb-post-image">
                  <a href="<?php the_permalink(); ?>" class="wsbb-post-image-link">
                    <?php the_post_thumbnail('medium_large', array('loading' => 'lazy')); ?>
                  </a>
                </div>
              <?php endif; ?>

              <div class="wsbb-post-content">
                <?php if ($settings->show_date === 'yes' || $settings->show_author === 'yes'): ?>
                  <div class="wsbb-post-meta">
                    <?php if ($settings->show_date === 'yes'): ?>
                      <span class="wsbb-post-date"><?php echo get_the_date(); ?></span>
                    <?php endif; ?>
                    <?php if ($settings->show_author === 'yes'): ?>
                      <span class="wsbb-post-author"><?php _e('By', 'wsbb'); ?> <?php the_author(); ?></span>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

                <?php if ($settings->show_title === 'yes'): ?>
                  <h3 class="wsbb-post-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h3>
                <?php endif; ?>

                <?php if ($settings->show_excerpt === 'yes'): ?>
                  <div class="wsbb-post-excerpt">
                    <?php echo wp_trim_words(get_the_excerpt(), intval($settings->excerpt_length)); ?>
                  </div>
                <?php endif; ?>

                <?php if (!empty($settings->read_more_text)): ?>
                  <a href="<?php the_permalink(); ?>" class="wsbb-post-readmore">
                    <?php echo esc_html($settings->read_more_text); ?>
                  </a>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </article>
      <?php endwhile; ?>

      <?php if ($is_carousel): ?>
        </div><!-- .wsbb-post-carousel-track -->

        <?php if ($settings->carousel_arrows === 'yes'): ?>
        <button class="wsbb-carousel-next" type="button" aria-label="<?php _e('Next', 'wsbb'); ?>">&rsaquo;</button>
        <?php endif; ?>

        <?php if ($settings->carousel_dots === 'yes'): ?>
        <div class="wsbb-carousel-dots"></div>
        <?php endif; ?>
      </div><!-- .wsbb-post-carousel -->
      <?php endif; ?>

    </div><!-- .wsbb-post-wrapper -->

    <?php if ($settings->enable_pagination === 'yes'): ?>
      <div class="wsbb-post-pagination">
        <?php
        $total_pages = $query->max_num_pages;

        if ($total_pages > 1) {
            $big = 999999999;

            if ($settings->pagination_type === 'numbers') {
                $paginate_args = array(
                    'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'    => '?paged=%#%',
                    'current'   => max(1, $paged),
                    'total'     => $total_pages,
                    'prev_text' => __('&laquo; Prev', 'wsbb'),
                    'next_text' => __('Next &raquo;', 'wsbb'),
                    'type'      => 'plain',
                );
                echo paginate_links($paginate_args);
            } else {
                if ($paged > 1) {
                    echo '<a href="' . get_pagenum_link($paged - 1) . '" class="wsbb-prev">&laquo; ' . __('Previous', 'wsbb') . '</a>';
                }
                if ($paged < $total_pages) {
                    echo '<a href="' . get_pagenum_link($paged + 1) . '" class="wsbb-next">' . __('Next', 'wsbb') . ' &raquo;</a>';
                }
            }
        }
        ?>
      </div>
    <?php endif; ?>

    <?php if ($query_source !== 'main'): ?>
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>
  <?php else: ?>
    <p class="wsbb-post-empty"><?php _e('No posts found.', 'wsbb'); ?></p>
  <?php endif; ?>
</div>
