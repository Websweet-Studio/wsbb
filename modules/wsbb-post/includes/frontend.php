<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$query_args = array(
    'post_type'      => $settings->post_type,
    'posts_per_page' => intval($settings->posts_per_page),
    'orderby'        => $settings->orderby,
    'order'          => $settings->order,
    'paged'          => $paged,
);

$query = new WP_Query($query_args);
?>

<div <?php $module->render_attributes(); ?>>
  <?php if ($query->have_posts()): ?>
    <div class="wsbb-post-grid wsbb-post-<?php echo esc_attr($settings->layout_style); ?>">
      <?php while ($query->have_posts()): $query->the_post(); ?>
        <article class="wsbb-post-item">
          <div class="wsbb-post-item-inner">
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
                    <span class="wsbb-post-date">
                      <?php echo get_the_date(); ?>
                    </span>
                  <?php endif; ?>
                  <?php if ($settings->show_author === 'yes'): ?>
                    <span class="wsbb-post-author">
                      <?php _e('By', 'wsbb'); ?> <?php the_author(); ?>
                    </span>
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
          </div>
        </article>
      <?php endwhile; ?>
    </div>

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
                $prev_args = array(
                    'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'  => '?paged=%#%',
                    'current' => max(1, $paged),
                    'total'   => $total_pages,
                    'type'    => 'plain',
                );

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

    <?php wp_reset_postdata(); ?>
  <?php else: ?>
    <p class="wsbb-post-empty"><?php _e('No posts found.', 'wsbb'); ?></p>
  <?php endif; ?>
</div>
