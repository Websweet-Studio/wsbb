<?php

class Wsbb_Post extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Post', 'wsbb'),
            'description'     => __('Display posts in a customizable grid or list layout.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Posts', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-post/',
            'url'             => WSBB_MODULES_URL . 'wsbb-post/',
            'icon'            => 'schedule',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-post', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
        $this->add_js('wsbb-post', $this->url . 'js/frontend.js', array('jquery'), WSBB_VERSION, true);
    }

    /** All public post types for dropdown. */
    public static function get_post_type_options()
    {
        $post_types = get_post_types(array('public' => true), 'objects');
        $options = array();
        foreach ($post_types as $slug => $pt) {
            $options[$slug] = $pt->labels->singular_name;
        }
        return $options;
    }

    /** All public taxonomies for dropdown (limit to common ones). */
    public static function get_taxonomy_options()
    {
        $taxonomies = get_taxonomies(array('public' => true), 'objects');
        $options = array('' => __('— None —', 'wsbb'));
        foreach ($taxonomies as $slug => $tax) {
            $options[$slug] = $tax->labels->singular_name . ' (' . $slug . ')';
        }
        return $options;
    }

    /** Build taxonomy/author/date WP_Query args from settings. */
    public static function build_query_args($settings, $paged)
    {
        $args = array(
            'post_type'      => $settings->post_type,
            'posts_per_page' => intval($settings->posts_per_page),
            'orderby'        => $settings->orderby,
            'order'          => $settings->order,
            'paged'          => $paged,
        );

        // Taxonomy filter
        if (!empty($settings->taxonomy) && !empty($settings->terms)) {
            $terms = array_map('trim', explode(',', $settings->terms));
            $operator = !empty($settings->terms_operator) ? $settings->terms_operator : 'IN';

            // Auto-detect: if all numeric treat as IDs, else treat as slugs
            $field = 'slug';
            if (array_reduce($terms, function ($carry, $t) {
                return $carry && ctype_digit($t);
            }, true)) {
                $field = 'term_id';
            }

            $args['tax_query'] = array(
                array(
                    'taxonomy' => $settings->taxonomy,
                    'field'    => $field,
                    'terms'    => $terms,
                    'operator' => $operator,
                ),
            );
        }

        // Author filter
        if (!empty($settings->author_type) && $settings->author_type !== 'all') {
            if ($settings->author_type === 'current') {
                $current_user = wp_get_current_user();
                if ($current_user->exists()) {
                    $args['author'] = $current_user->ID;
                }
            } elseif ($settings->author_type === 'specific' && !empty($settings->author_id)) {
                $args['author'] = intval($settings->author_id);
            }
        }

        // Date filter
        if (!empty($settings->date_range) && $settings->date_range !== 'all') {
            switch ($settings->date_range) {
                case 'today':
                    $args['date_query'] = array(array('after' => 'today', 'inclusive' => true));
                    break;
                case 'this_week':
                    $args['date_query'] = array(array('week' => date('W'), 'year' => date('Y')));
                    break;
                case 'this_month':
                    $args['date_query'] = array(array('month' => date('m'), 'year' => date('Y')));
                    break;
                case 'this_year':
                    $args['date_query'] = array(array('year' => date('Y')));
                    break;
                case 'custom':
                    $dq = array();
                    if (!empty($settings->date_after)) {
                        $dq['after'] = $settings->date_after;
                    }
                    if (!empty($settings->date_before)) {
                        $dq['before'] = $settings->date_before;
                    }
                    if (!empty($dq)) {
                        $args['date_query'] = array($dq);
                    }
                    break;
            }
        }

        return $args;
    }

    // ─── Shortcode engine ───────────────────────────────────────

    public static function render_custom_layout($template, $post_id)
    {
        $post = get_post($post_id);
        if (!$post) {
            return '';
        }

        $output = $template;

        // [wsbb-if post:featured_image]...[/wsbb-if]
        $output = preg_replace_callback(
            '/\[wsbb-if\s+post:featured_image\](.*?)\[\/wsbb-if\]/s',
            function ($matches) use ($post_id) {
                if (has_post_thumbnail($post_id)) {
                    return $matches[1];
                }
                return '';
            },
            $output
        );

        // [wsbb post:featured_image size="large" display="tag" linked="yes"]
        $output = preg_replace_callback(
            '/\[wsbb\s+post:featured_image\s+(.*?)\]/',
            function ($matches) use ($post_id) {
                $atts = self::parse_shortcode_atts($matches[1]);
                $size   = isset($atts['size']) ? $atts['size'] : 'large';
                $linked = isset($atts['linked']) && $atts['linked'] === 'yes';
                $display = isset($atts['display']) ? $atts['display'] : 'tag';

                if (!has_post_thumbnail($post_id)) {
                    return '';
                }

                if ($display === 'tag') {
                    $img = get_the_post_thumbnail($post_id, $size, array('loading' => 'lazy'));
                } else {
                    $src = get_the_post_thumbnail_url($post_id, $size);
                    if (!$src) {
                        return '';
                    }
                    $img = '<img src="' . esc_url($src) . '" alt="' . esc_attr(get_the_title($post_id)) . '" loading="lazy" />';
                }

                if ($linked) {
                    $img = '<a href="' . get_permalink($post_id) . '">' . $img . '</a>';
                }

                return $img;
            },
            $output
        );

        // [wsbb post:link text="title"] or text="custom" custom_text="..."
        $output = preg_replace_callback(
            '/\[wsbb\s+post:link\s+(.*?)\]/',
            function ($matches) use ($post_id) {
                $atts = self::parse_shortcode_atts($matches[1]);
                $text = isset($atts['text']) ? $atts['text'] : 'title';
                if ($text === 'title') {
                    $link_text = get_the_title($post_id);
                } elseif ($text === 'custom' && isset($atts['custom_text'])) {
                    $link_text = $atts['custom_text'];
                } else {
                    $link_text = get_the_title($post_id);
                }
                return '<a href="' . get_permalink($post_id) . '">' . esc_html($link_text) . '</a>';
            },
            $output
        );

        // [wsbb post:author_name link="yes"]
        $output = preg_replace_callback(
            '/\[wsbb\s+post:author_name\s+(.*?)\]/',
            function ($matches) use ($post) {
                $atts = self::parse_shortcode_atts($matches[1]);
                $linked = isset($atts['link']) && $atts['link'] === 'yes';
                $author_name = get_the_author_meta('display_name', $post->post_author);
                if ($linked) {
                    return '<a href="' . get_author_posts_url($post->post_author) . '">' . esc_html($author_name) . '</a>';
                }
                return esc_html($author_name);
            },
            $output
        );

        // [wsbb post:date format="F j, Y"]
        $output = preg_replace_callback(
            '/\[wsbb\s+post:date\s+(.*?)\]/',
            function ($matches) use ($post) {
                $atts = self::parse_shortcode_atts($matches[1]);
                $format = isset($atts['format']) ? $atts['format'] : get_option('date_format');
                return get_the_date($format, $post->ID);
            },
            $output
        );

        // [wsbb post:excerpt length="55" more="..."]
        $output = preg_replace_callback(
            '/\[wsbb\s+post:excerpt\s+(.*?)\]/',
            function ($matches) use ($post) {
                $atts   = self::parse_shortcode_atts($matches[1]);
                $length = isset($atts['length']) ? intval($atts['length']) : 55;
                $more   = isset($atts['more']) ? $atts['more'] : '...';
                $excerpt = get_the_excerpt($post);
                if (empty($excerpt)) {
                    $excerpt = wp_trim_words($post->post_content, $length, '');
                }
                return wp_trim_words($excerpt, $length, $more);
            },
            $output
        );

        // [wsbb post:terms_list taxonomy="category" ...]
        $output = preg_replace_callback(
            '/\[wsbb\s+post:terms_list\s+(.*?)\]/',
            function ($matches) use ($post_id) {
                $atts = self::parse_shortcode_atts($matches[1]);
                $taxonomy  = isset($atts['taxonomy']) ? $atts['taxonomy'] : 'category';
                $html_list = isset($atts['html_list']) && $atts['html_list'] === 'yes';
                $display   = isset($atts['display']) ? $atts['display'] : 'name';
                $separator = isset($atts['separator']) ? $atts['separator'] : ', ';
                $limit     = isset($atts['limit']) ? intval($atts['limit']) : 0;
                $linked    = isset($atts['linked']) && $atts['linked'] === 'yes';
                $orderby   = isset($atts['orderby']) ? $atts['orderby'] : 'name';
                $order     = isset($atts['order']) ? $atts['order'] : 'SORT_ASC';
                $order     = str_replace('SORT_', '', $order);

                $terms = wp_get_post_terms($post_id, $taxonomy, array('orderby' => $orderby, 'order' => $order));
                if (is_wp_error($terms) || empty($terms)) {
                    return '';
                }
                if ($limit > 0) {
                    $terms = array_slice($terms, 0, $limit);
                }
                $items = array();
                foreach ($terms as $term) {
                    $text = ($display === 'slug') ? $term->slug : $term->name;
                    if ($linked) {
                        $link = get_term_link($term);
                        if (!is_wp_error($link)) {
                            $text = '<a href="' . esc_url($link) . '">' . esc_html($text) . '</a>';
                        } else {
                            $text = esc_html($text);
                        }
                    } else {
                        $text = esc_html($text);
                    }
                    $items[] = $text;
                }
                if ($html_list) {
                    return '<ul><li>' . implode('</li><li>', $items) . '</li></ul>';
                }
                return implode($separator, $items);
            },
            $output
        );

        // [wsbb post:title]
        $output = preg_replace_callback(
            '/\[wsbb\s+post:title\]/',
            function () use ($post_id) {
                return esc_html(get_the_title($post_id));
            },
            $output
        );

        // [wp_store_thumbnail], [wp_store_price], etc.
        $output = preg_replace_callback(
            '/\[(wp_store_thumbnail|wp_store_price|wp_store_add_to_cart|wp_store_detail|wp_store_add_to_wishlist)\s*(.*?)\]/s',
            function ($matches) use ($post_id) {
                return self::render_wp_store_shortcode($matches[1], $matches[2], $post_id);
            },
            $output
        );

        return $output;
    }

    private static function render_wp_store_shortcode($tag, $atts_string, $post_id)
    {
        static $wps_shortcode = null;
        static $wps_loaded = false;

        if (!$wps_loaded) {
            $wps_loaded = true;
            if (class_exists('\\WpStore\\Frontend\\Shortcode')) {
                $wps_shortcode = new \WpStore\Frontend\Shortcode();
            }
        }

        if (!$wps_shortcode) {
            return '';
        }

        $map = array(
            'wp_store_thumbnail'        => 'render_thumbnail',
            'wp_store_price'            => 'render_price',
            'wp_store_add_to_cart'      => 'render_add_to_cart',
            'wp_store_detail'           => 'render_detail',
            'wp_store_add_to_wishlist'  => 'render_add_to_wishlist',
        );

        if (!isset($map[$tag])) {
            return '';
        }

        $atts = self::parse_shortcode_atts($atts_string);
        if (!isset($atts['id'])) {
            $atts['id'] = $post_id;
        }

        $method = $map[$tag];
        return call_user_func(array($wps_shortcode, $method), $atts);
    }

    private static function parse_shortcode_atts($atts_string)
    {
        $atts = array();
        preg_match_all('/(\w+)\s*=\s*(["\'])([^"\']*)\2/', $atts_string, $matches, PREG_SET_ORDER);
        foreach ($matches as $m) {
            $atts[$m[1]] = $m[3];
        }
        return $atts;
    }
}

// ─── Register Module ──────────────────────────────────────────

$post_type_options = Wsbb_Post::get_post_type_options();
$taxonomy_options  = Wsbb_Post::get_taxonomy_options();

FLBuilder::register_module('Wsbb_Post', array(

    // ─── Tab: Content ────────────────────────────────────────
    'content' => array(
        'title'    => __('Content', 'wsbb'),
        'sections' => array(
            'query' => array(
                'title'  => __('Query', 'wsbb'),
                'fields' => array(
                    'query_source' => array(
                        'type'    => 'select',
                        'label'   => __('Query Source', 'wsbb'),
                        'default' => 'custom',
                        'options' => array(
                            'custom' => __('Custom Query', 'wsbb'),
                            'main'   => __('Main Query', 'wsbb'),
                        ),
                        'toggle' => array(
                            'custom' => array(
                                'fields' => array('post_type', 'posts_per_page', 'orderby', 'order'),
                                'sections' => array('query_filters'),
                            ),
                            'main' => array(),
                        ),
                    ),
                    'post_type' => array(
                        'type'    => 'select',
                        'label'   => __('Post Type', 'wsbb'),
                        'default' => 'post',
                        'options' => $post_type_options,
                    ),
                    'posts_per_page' => array(
                        'type'    => 'unit',
                        'label'   => __('Posts Per Page', 'wsbb'),
                        'default' => '6',
                    ),
                    'orderby' => array(
                        'type'    => 'select',
                        'label'   => __('Order By', 'wsbb'),
                        'default' => 'date',
                        'options' => array(
                            'date'       => __('Date', 'wsbb'),
                            'title'      => __('Title', 'wsbb'),
                            'rand'       => __('Random', 'wsbb'),
                            'modified'   => __('Modified', 'wsbb'),
                            'menu_order' => __('Menu Order', 'wsbb'),
                            'comment_count' => __('Comment Count', 'wsbb'),
                        ),
                    ),
                    'order' => array(
                        'type'    => 'select',
                        'label'   => __('Order', 'wsbb'),
                        'default' => 'DESC',
                        'options' => array(
                            'DESC' => __('Descending', 'wsbb'),
                            'ASC'  => __('Ascending', 'wsbb'),
                        ),
                    ),
                ),
            ),
            'query_filters' => array(
                'title'  => __('Filters', 'wsbb'),
                'fields' => array(
                    'taxonomy' => array(
                        'type'    => 'select',
                        'label'   => __('Filter by Taxonomy', 'wsbb'),
                        'default' => '',
                        'options' => $taxonomy_options,
                        'help'    => __('Choose a taxonomy to filter by, then enter term slugs or IDs below.', 'wsbb'),
                    ),
                    'terms' => array(
                        'type'        => 'text',
                        'label'       => __('Terms', 'wsbb'),
                        'description' => __('Comma-separated slugs or IDs', 'wsbb'),
                        'help'        => __('Enter term slugs (e.g. news, blog) or numeric IDs (e.g. 5, 12) separated by commas.', 'wsbb'),
                    ),
                    'terms_operator' => array(
                        'type'    => 'select',
                        'label'   => __('Terms Operator', 'wsbb'),
                        'default' => 'IN',
                        'options' => array(
                            'IN'     => __('IN — posts in any of these terms', 'wsbb'),
                            'NOT IN' => __('NOT IN — exclude these terms', 'wsbb'),
                            'AND'    => __('AND — posts must have all terms', 'wsbb'),
                        ),
                    ),
                    'author_type' => array(
                        'type'    => 'select',
                        'label'   => __('Filter by Author', 'wsbb'),
                        'default' => 'all',
                        'options' => array(
                            'all'     => __('All Authors', 'wsbb'),
                            'current' => __('Current User', 'wsbb'),
                            'specific' => __('Specific Author ID', 'wsbb'),
                        ),
                        'toggle' => array(
                            'specific' => array(
                                'fields' => array('author_id'),
                            ),
                        ),
                    ),
                    'author_id' => array(
                        'type'    => 'unit',
                        'label'   => __('Author ID', 'wsbb'),
                    ),
                    'date_range' => array(
                        'type'    => 'select',
                        'label'   => __('Filter by Date', 'wsbb'),
                        'default' => 'all',
                        'options' => array(
                            'all'        => __('All Dates', 'wsbb'),
                            'today'      => __('Today', 'wsbb'),
                            'this_week'  => __('This Week', 'wsbb'),
                            'this_month' => __('This Month', 'wsbb'),
                            'this_year'  => __('This Year', 'wsbb'),
                            'custom'     => __('Custom Range', 'wsbb'),
                        ),
                        'toggle' => array(
                            'custom' => array(
                                'fields' => array('date_after', 'date_before'),
                            ),
                        ),
                    ),
                    'date_after' => array(
                        'type'  => 'date',
                        'label' => __('From (start date)', 'wsbb'),
                    ),
                    'date_before' => array(
                        'type'  => 'date',
                        'label' => __('To (end date)', 'wsbb'),
                    ),
                ),
            ),
        ),
    ),

    // ─── Tab: Layout ─────────────────────────────────────────
    'layout' => array(
        'title'    => __('Layout', 'wsbb'),
        'sections' => array(
            'layout_type_section' => array(
                'title'  => __('Layout', 'wsbb'),
                'fields' => array(
                    'layout_type' => array(
                        'type'    => 'select',
                        'label'   => __('Layout Type', 'wsbb'),
                        'default' => 'grid',
                        'options' => array(
                            'grid'     => __('Grid', 'wsbb'),
                            'masonry'  => __('Masonry', 'wsbb'),
                            'list'     => __('List', 'wsbb'),
                            'carousel' => __('Carousel', 'wsbb'),
                        ),
                        'toggle' => array(
                            'grid' => array(
                                'sections' => array('grid_settings'),
                            ),
                            'masonry' => array(
                                'sections' => array('grid_settings'),
                            ),
                            'list' => array(),
                            'carousel' => array(
                                'sections' => array('carousel_settings'),
                            ),
                        ),
                    ),
                    'layout_content' => array(
                        'type'    => 'select',
                        'label'   => __('Content Layout', 'wsbb'),
                        'default' => 'default',
                        'options' => array(
                            'default' => __('Default', 'wsbb'),
                            'custom'  => __('Custom HTML', 'wsbb'),
                        ),
                        'toggle' => array(
                            'default' => array(
                                'sections' => array('elements'),
                            ),
                            'custom' => array(
                                'sections' => array('custom_html', 'custom_css', 'shortcode_ref'),
                            ),
                        ),
                    ),
                ),
            ),
            'custom_html' => array(
                'title'  => __('HTML', 'wsbb'),
                'fields' => array(
                    'custom_layout' => array(
                        'type'    => 'code',
                        'editor'  => 'html',
                        'label'   => __('Post Card HTML', 'wsbb'),
                        'default' => '[wsbb-if post:featured_image]
<div class="wsbb-post-thumbnail">
  [wsbb post:featured_image size="large" display="tag" linked="yes"]
</div>
[/wsbb-if]

<div class="wsbb-post-content">
<h3 class="wsbb-post-heading">[wsbb post:link text="title"]</h3>

<h5 class="wsbb-post-meta">
  By<span class="wsbb-posted-by"> [wsbb post:author_name link="yes"] </span> | <span class="wsbb-meta-date"> [wsbb post:date format="F j, Y"] </span>
</h5>

<div class="wsbb-post-description">
  [wsbb post:excerpt length="55" more="..."]
</div>

<p class="wsbb-read-more-text">
  [wsbb post:link text="custom" custom_text="Read More »"]
</p>
</div>',
                        'rows' => '20',
                        'help' => __('HTML for inner content of each post card. Use [wsbb] shortcodes.', 'wsbb'),
                    ),
                ),
            ),
            'custom_css' => array(
                'title'  => __('CSS', 'wsbb'),
                'fields' => array(
                    'custom_css_field' => array(
                        'type'    => 'code',
                        'editor'  => 'css',
                        'label'   => __('Post Card CSS', 'wsbb'),
                        'default' => '/* === Post Card Styles === */
.wsbb-post-card {
  overflow: hidden;
  background: #fff;
  border: 1px solid #eee;
  border-radius: 8px;
  transition: box-shadow 0.3s ease;
}
.wsbb-post-card:hover {
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
.wsbb-post-thumbnail { overflow: hidden; line-height: 0; }
.wsbb-post-thumbnail img {
  width: 100%; height: 220px;
  object-fit: cover;
  transition: transform 0.35s ease;
}
.wsbb-post-thumbnail a:hover img { transform: scale(1.05); }
.wsbb-post-heading { margin: 16px 0 8px; font-size: 1.15rem; line-height: 1.4; }
.wsbb-post-heading a { color: inherit; text-decoration: none; }
.wsbb-post-heading a:hover { color: #0073aa; }
.wsbb-post-meta { font-size: 0.85rem; color: #888; margin: 0 0 10px; }
.wsbb-posted-by a { color: #888; text-decoration: none; }
.wsbb-posted-by a:hover { color: #0073aa; }
.wsbb-post-description { font-size: 0.95rem; color: #555; line-height: 1.6; margin-bottom: 15px; }
.wsbb-read-more-text { margin: 8px 0 16px; }
.wsbb-read-more-text a {
  display: inline-block; padding: 8px 18px; font-size: 0.9rem;
  font-weight: 600; color: #fff; background: #0073aa;
  border-radius: 4px; text-decoration: none; transition: background 0.2s ease;
}
.wsbb-read-more-text a:hover { background: #005177; color: #fff; }
.wsbb-post-content { padding: 15px; }
.wsbb-post-content > *:first-child { margin-top: 0; }
.wsbb-post-content > *:last-child { margin-bottom: 0; }',
                        'rows' => '18',
                        'help' => __('Custom CSS for styling your post card elements.', 'wsbb'),
                    ),
                ),
            ),
            'shortcode_ref' => array(
                'title'  => __('Shortcodes', 'wsbb'),
                'fields' => array(
                    'shortcode_reference' => array(
                        'type'    => 'raw',
                        'label'   => __('Available Shortcodes', 'wsbb'),
                        'content' => '<div style="background:#f8f9fa;border:1px solid #dee2e6;border-radius:3px;padding:8px 12px;font-family:monospace;font-size:12px;line-height:1.9;">'
                            . '<b>[wsbb post:featured_image size="large" display="tag" linked="yes"]</b> — Featured image. size: thumbnail/medium/large/full<br>'
                            . '<b>[wsbb post:title]</b> — Post title (plain text)<br>'
                            . '<b>[wsbb post:link text="title"]</b> — Linked post title. text="custom" custom_text="Read More"<br>'
                            . '<b>[wsbb post:author_name link="yes"]</b> — Author name<br>'
                            . '<b>[wsbb post:date format="F j, Y"]</b> — Post date (PHP date format)<br>'
                            . '<b>[wsbb post:excerpt length="55" more="..."]</b> — Post excerpt<br>'
                            . '<b>[wsbb-if post:featured_image]...[/wsbb-if]</b> — Conditional block<br>'
                            . '<b>[wsbb post:terms_list taxonomy="category" ...]</b> — Taxonomy terms list'
                            . '</div>',
                    ),
                ),
            ),
            'grid_settings' => array(
                'title'  => __('Grid Settings', 'wsbb'),
                'fields' => array(
                    'columns' => array(
                        'type'    => 'select',
                        'label'   => __('Columns', 'wsbb'),
                        'default' => '3',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                        ),
                    ),
                    'columns_medium' => array(
                        'type'    => 'select',
                        'label'   => __('Columns (Medium)', 'wsbb'),
                        'default' => '2',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                    ),
                    'columns_responsive' => array(
                        'type'    => 'select',
                        'label'   => __('Columns (Small)', 'wsbb'),
                        'default' => '1',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                        ),
                    ),
                ),
            ),
            'carousel_settings' => array(
                'title'  => __('Carousel Settings', 'wsbb'),
                'fields' => array(
                    'carousel_slides' => array(
                        'type'    => 'unit',
                        'label'   => __('Slides Per View', 'wsbb'),
                        'default' => '3',
                    ),
                    'carousel_slides_medium' => array(
                        'type'    => 'select',
                        'label'   => __('Slides (Medium)', 'wsbb'),
                        'default' => '2',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                        ),
                    ),
                    'carousel_slides_responsive' => array(
                        'type'    => 'select',
                        'label'   => __('Slides (Small)', 'wsbb'),
                        'default' => '1',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                        ),
                    ),
                    'carousel_gap' => array(
                        'type'    => 'unit',
                        'label'   => __('Gap', 'wsbb'),
                        'default' => '20',
                    ),
                    'carousel_autoplay' => array(
                        'type'    => 'select',
                        'label'   => __('Autoplay', 'wsbb'),
                        'default' => 'yes',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'carousel_autoplay_speed' => array(
                        'type'    => 'unit',
                        'label'   => __('Autoplay Speed', 'wsbb'),
                        'default' => '4000',
                    ),
                    'carousel_arrows' => array(
                        'type'    => 'select',
                        'label'   => __('Show Arrows', 'wsbb'),
                        'default' => 'yes',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'carousel_dots' => array(
                        'type'    => 'select',
                        'label'   => __('Show Dots', 'wsbb'),
                        'default' => 'no',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'carousel_loop' => array(
                        'type'    => 'select',
                        'label'   => __('Infinite Loop', 'wsbb'),
                        'default' => 'yes',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                ),
            ),
            'elements' => array(
                'title'  => __('Post Elements', 'wsbb'),
                'fields' => array(
                    'show_image' => array(
                        'type'    => 'select',
                        'label'   => __('Show Featured Image', 'wsbb'),
                        'default' => 'yes',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'image_size' => array(
                        'type'    => 'select',
                        'label'   => __('Image Size', 'wsbb'),
                        'default' => 'medium_large',
                        'options' => array(
                            'thumbnail'    => __('Thumbnail', 'wsbb'),
                            'medium'       => __('Medium', 'wsbb'),
                            'medium_large' => __('Medium Large', 'wsbb'),
                            'large'        => __('Large', 'wsbb'),
                            'full'         => __('Full', 'wsbb'),
                        ),
                    ),
                    'show_title' => array(
                        'type'    => 'select',
                        'label'   => __('Show Title', 'wsbb'),
                        'default' => 'yes',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'show_excerpt' => array(
                        'type'    => 'select',
                        'label'   => __('Show Excerpt', 'wsbb'),
                        'default' => 'yes',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'excerpt_length' => array(
                        'type'    => 'unit',
                        'label'   => __('Excerpt Length', 'wsbb'),
                        'default' => '20',
                    ),
                    'show_date' => array(
                        'type'    => 'select',
                        'label'   => __('Show Date', 'wsbb'),
                        'default' => 'yes',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'show_author' => array(
                        'type'    => 'select',
                        'label'   => __('Show Author', 'wsbb'),
                        'default' => 'no',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'read_more_text' => array(
                        'type'    => 'text',
                        'label'   => __('Read More Text', 'wsbb'),
                        'default' => __('Read More', 'wsbb'),
                    ),
                ),
            ),
        ),
    ),

    // ─── Tab: Style ──────────────────────────────────────────
    'style' => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'card' => array(
                'title'  => __('Card', 'wsbb'),
                'fields' => array(
                    'gap' => array(
                        'type'    => 'unit',
                        'label'   => __('Gap', 'wsbb'),
                        'default' => '20',
                    ),
                    'border_radius' => array(
                        'type'    => 'unit',
                        'label'   => __('Border Radius', 'wsbb'),
                        'default' => '8',
                    ),
                ),
            ),
            'image' => array(
                'title'  => __('Image', 'wsbb'),
                'fields' => array(
                    'image_height' => array(
                        'type'    => 'unit',
                        'label'   => __('Image Height', 'wsbb'),
                        'default' => '220',
                    ),
                ),
            ),
            'typography' => array(
                'title'  => __('Typography', 'wsbb'),
                'fields' => array(
                    'title_font' => array(
                        'type'    => 'font',
                        'label'   => __('Title Font', 'wsbb'),
                        'default' => array('family' => 'Default', 'weight' => '600'),
                    ),
                    'title_color' => array(
                        'type'       => 'color',
                        'label'      => __('Title Color', 'wsbb'),
                        'show_reset' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-post-title a',
                            'property' => 'color',
                        ),
                    ),
                    'meta_color' => array(
                        'type'       => 'color',
                        'label'      => __('Meta Color', 'wsbb'),
                        'show_reset' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-post-meta',
                            'property' => 'color',
                        ),
                    ),
                    'excerpt_color' => array(
                        'type'       => 'color',
                        'label'      => __('Excerpt Color', 'wsbb'),
                        'show_reset' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-post-excerpt',
                            'property' => 'color',
                        ),
                    ),
                ),
            ),
            'button' => array(
                'title'  => __('Button', 'wsbb'),
                'fields' => array(
                    'btn_style' => array(
                        'type'    => 'button-group',
                        'label'   => __('Button Style', 'wsbb'),
                        'default' => 'filled',
                        'options' => array(
                            'filled'   => __('Filled', 'wsbb'),
                            'outlined' => __('Outlined', 'wsbb'),
                            'ghost'    => __('Ghost', 'wsbb'),
                        ),
                    ),
                    'btn_border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '4',
                        'description' => 'px',
                    ),
                    'btn_border_width' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Width', 'wsbb'),
                        'default'     => '2',
                        'description' => 'px',
                    ),
                    'btn_border_color' => array(
                        'type'       => 'color',
                        'label'      => __('Border Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_border_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Border Hover Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '0073aa',
                    ),
                    'btn_text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_bg_hover' => array(
                        'type'       => 'color',
                        'label'      => __('Hover Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_text_hover' => array(
                        'type'       => 'color',
                        'label'      => __('Hover Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_size_preset' => array(
                        'type'    => 'button-group',
                        'label'   => __('Size', 'wsbb'),
                        'default' => 'custom',
                        'options' => array(
                            'small'  => __('Small', 'wsbb'),
                            'medium' => __('Medium', 'wsbb'),
                            'large'  => __('Large', 'wsbb'),
                            'custom' => __('Custom', 'wsbb'),
                        ),
                        'toggle' => array(
                            'custom' => array(
                                'fields' => array('btn_padding_h', 'btn_padding_v', 'btn_font_size'),
                            ),
                        ),
                    ),
                    'btn_padding_h' => array(
                        'type'        => 'unit',
                        'label'       => __('Horizontal Padding', 'wsbb'),
                        'default'     => '16',
                        'description' => 'px',
                    ),
                    'btn_padding_v' => array(
                        'type'        => 'unit',
                        'label'       => __('Vertical Padding', 'wsbb'),
                        'default'     => '8',
                        'description' => 'px',
                    ),
                    'btn_font_size' => array(
                        'type'        => 'unit',
                        'label'       => __('Font Size', 'wsbb'),
                        'default'     => '15',
                        'description' => 'px',
                        'responsive'  => true,
                    ),
                    'btn_font_weight' => array(
                        'type'    => 'select',
                        'label'   => __('Font Weight', 'wsbb'),
                        'default' => '600',
                        'options' => array(
                            '400' => '400',
                            '500' => '500',
                            '600' => '600',
                            '700' => '700',
                        ),
                    ),
                    'btn_letter_spacing' => array(
                        'type'        => 'unit',
                        'label'       => __('Letter Spacing', 'wsbb'),
                        'description' => 'px',
                    ),
                    'btn_full_width' => array(
                        'type'    => 'select',
                        'label'   => __('Full Width', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('No', 'wsbb'),
                            'yes' => __('Yes', 'wsbb'),
                        ),
                    ),
                    'btn_box_shadow' => array(
                        'type'    => 'select',
                        'label'   => __('Enable Shadow', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('No', 'wsbb'),
                            'yes' => __('Yes', 'wsbb'),
                        ),
                    ),
                    'btn_shadow_hover' => array(
                        'type'    => 'select',
                        'label'   => __('Shadow on Hover', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('No', 'wsbb'),
                            'yes' => __('Yes', 'wsbb'),
                        ),
                    ),
                ),
            ),
        ),
    ),

    // ─── Tab: Pagination ─────────────────────────────────────
    'pagination' => array(
        'title'    => __('Pagination', 'wsbb'),
        'sections' => array(
            'pagination_settings' => array(
                'title'  => __('Pagination Settings', 'wsbb'),
                'fields' => array(
                    'enable_pagination' => array(
                        'type'    => 'select',
                        'label'   => __('Enable Pagination', 'wsbb'),
                        'default' => 'no',
                        'options' => array('yes' => __('Yes', 'wsbb'), 'no' => __('No', 'wsbb')),
                    ),
                    'pagination_type' => array(
                        'type'    => 'select',
                        'label'   => __('Pagination Type', 'wsbb'),
                        'default' => 'numbers',
                        'options' => array(
                            'numbers'   => __('Numbers', 'wsbb'),
                            'prev_next' => __('Prev / Next', 'wsbb'),
                        ),
                    ),
                    'pagination_align' => array(
                        'type'    => 'align',
                        'label'   => __('Pagination Alignment', 'wsbb'),
                        'default' => 'center',
                    ),
                ),
            ),
        ),
    ),
));
