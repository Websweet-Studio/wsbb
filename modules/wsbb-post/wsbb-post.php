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
            'icon'            => 'schedule.svg',
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

    /**
     * Render custom layout with [wsbb ...] shortcodes.
     */
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

        // [wsbb post:link text="title"] or [wsbb post:link text="custom" custom_text="Read More »"]
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

        // [wsbb post:title]
        $output = preg_replace_callback(
            '/\[wsbb\s+post:title\]/',
            function () use ($post_id) {
                return esc_html(get_the_title($post_id));
            },
            $output
        );

        return $output;
    }

    /**
     * Parse shortcode attribute string into associative array.
     */
    private static function parse_shortcode_atts($atts_string)
    {
        $atts = array();
        preg_match_all('/(\w+)\s*=\s*"([^"]*)"/', $atts_string, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $atts[$match[1]] = $match[2];
        }
        return $atts;
    }
}

// Register the module
FLBuilder::register_module('Wsbb_Post', array(
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
                            ),
                            'main' => array(),
                        ),
                    ),
                    'post_type' => array(
                        'type'    => 'select',
                        'label'   => __('Post Type', 'wsbb'),
                        'default' => 'post',
                        'options' => array(
                            'post' => __('Post', 'wsbb'),
                            'page' => __('Page', 'wsbb'),
                        ),
                    ),
                    'posts_per_page' => array(
                        'type'        => 'unit',
                        'label'       => __('Posts Per Page', 'wsbb'),
                        'default'     => '6',
                        'description' => '',
                    ),
                    'orderby' => array(
                        'type'    => 'select',
                        'label'   => __('Order By', 'wsbb'),
                        'default' => 'date',
                        'options' => array(
                            'date'     => __('Date', 'wsbb'),
                            'title'    => __('Title', 'wsbb'),
                            'rand'     => __('Random', 'wsbb'),
                            'modified' => __('Modified', 'wsbb'),
                            'menu_order' => __('Menu Order', 'wsbb'),
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
        ),
    ),
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
                                'sections' => array('style', 'elements'),
                            ),
                            'custom' => array(
                                'sections' => array('custom_layout_section'),
                            ),
                        ),
                    ),
                ),
            ),
            'custom_layout_section' => array(
                'title'  => __('Custom HTML Layout', 'wsbb'),
                'fields' => array(
                    'custom_layout' => array(
                        'type'    => 'code',
                        'editor'  => 'html',
                        'label'   => __('Post Card HTML', 'wsbb'),
                        'default' => '[wsbb-if post:featured_image]
<div class="wsbb-post-thumbnail wsbb-post-section">
  [wsbb post:featured_image size="large" display="tag" linked="yes"]
</div>
[/wsbb-if]

<h3 class="wsbb-post-heading wsbb-post-section">[wsbb post:link text="title"]</h3>

<h5 class="wsbb-post-meta wsbb-post-section">
  By<span class="wsbb-posted-by"> [wsbb post:author_name link="yes"] </span> | <span class="wsbb-meta-date"> [wsbb post:date format="F j, Y"] </span>
</h5>

<div class="wsbb-post-description wsbb-post-section">
  [wsbb post:excerpt length="55" more="..."]
</div>

<p class="wsbb-read-more-text">
  [wsbb post:link text="custom" custom_text="Read More »"]
</p>',
                        'rows' => '20',
                        'help'    => __('HTML for inner content of each post card. Use [wsbb] shortcodes. See reference below.', 'wsbb'),
                    ),
                    'shortcode_reference' => array(
                        'type'    => 'raw',
                        'label'   => __('Available Shortcodes', 'wsbb'),
                        'content' => '<div style="background:#f8f9fa;border:1px solid #ddd;border-radius:4px;padding:12px;font-size:13px;line-height:1.7;max-height:360px;overflow-y:auto;">
<table style="width:100%;border-collapse:collapse;">
<thead><tr style="background:#e9ecef;"><th style="padding:6px 8px;text-align:left;border:1px solid #ddd;">Shortcode</th><th style="padding:6px 8px;text-align:left;border:1px solid #ddd;">Keterangan</th></tr></thead>
<tbody>
<tr><td style="padding:4px 8px;border:1px solid #ddd;"><code>[wsbb post:featured_image size="large" display="tag" linked="yes"]</code></td><td style="padding:4px 8px;border:1px solid #ddd;">Featured image. <code>size</code>: thumbnail/medium/large/full, <code>display</code>: tag|url, <code>linked</code>: yes|no</td></tr>
<tr><td style="padding:4px 8px;border:1px solid #ddd;"><code>[wsbb post:title]</code></td><td style="padding:4px 8px;border:1px solid #ddd;">Judul post (plain text, tanpa link)</td></tr>
<tr><td style="padding:4px 8px;border:1px solid #ddd;"><code>[wsbb post:link text="title"]</code></td><td style="padding:4px 8px;border:1px solid #ddd;">Link ke post dengan teks judul. <code>text="custom" custom_text="Read More"</code></td></tr>
<tr><td style="padding:4px 8px;border:1px solid #ddd;"><code>[wsbb post:author_name link="yes"]</code></td><td style="padding:4px 8px;border:1px solid #ddd;">Nama author. <code>link</code>: yes|no</td></tr>
<tr><td style="padding:4px 8px;border:1px solid #ddd;"><code>[wsbb post:date format="F j, Y"]</code></td><td style="padding:4px 8px;border:1px solid #ddd;">Tanggal post. <code>format</code>: PHP date format (default: WP date format)</td></tr>
<tr><td style="padding:4px 8px;border:1px solid #ddd;"><code>[wsbb post:excerpt length="55" more="..."]</code></td><td style="padding:4px 8px;border:1px solid #ddd;">Excerpt. <code>length</code>: jumlah kata, <code>more</code>: suffix teks</td></tr>
<tr><td style="padding:4px 8px;border:1px solid #ddd;"><code>[wsbb-if post:featured_image]...[/wsbb-if]</code></td><td style="padding:4px 8px;border:1px solid #ddd;">Conditional: tampilkan konten di dalamnya hanya jika post punya featured image</td></tr>
</tbody>
</table>
</div>',
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
                    'gap' => array(
                        'type'        => 'unit',
                        'label'       => __('Gap', 'wsbb'),
                        'default'     => '20',
                        'description' => 'px',
                    ),
                ),
            ),
            'carousel_settings' => array(
                'title'  => __('Carousel Settings', 'wsbb'),
                'fields' => array(
                    'carousel_slides' => array(
                        'type'        => 'unit',
                        'label'       => __('Slides Per View', 'wsbb'),
                        'default'     => '3',
                        'description' => '',
                    ),
                    'carousel_gap' => array(
                        'type'        => 'unit',
                        'label'       => __('Gap', 'wsbb'),
                        'default'     => '20',
                        'description' => 'px',
                    ),
                    'carousel_autoplay' => array(
                        'type'    => 'select',
                        'label'   => __('Autoplay', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'carousel_autoplay_speed' => array(
                        'type'        => 'unit',
                        'label'       => __('Autoplay Speed', 'wsbb'),
                        'default'     => '4000',
                        'description' => 'ms',
                    ),
                    'carousel_arrows' => array(
                        'type'    => 'select',
                        'label'   => __('Show Arrows', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'carousel_dots' => array(
                        'type'    => 'select',
                        'label'   => __('Show Dots', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                ),
            ),
            'style' => array(
                'title'  => __('Style', 'wsbb'),
                'fields' => array(
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '8',
                        'description' => 'px',
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
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'image_height' => array(
                        'type'        => 'unit',
                        'label'       => __('Image Height', 'wsbb'),
                        'default'     => '220',
                        'description' => 'px',
                    ),
                    'show_title' => array(
                        'type'    => 'select',
                        'label'   => __('Show Title', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'show_excerpt' => array(
                        'type'    => 'select',
                        'label'   => __('Show Excerpt', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'excerpt_length' => array(
                        'type'        => 'unit',
                        'label'       => __('Excerpt Length', 'wsbb'),
                        'default'     => '20',
                        'description' => __('words', 'wsbb'),
                    ),
                    'show_date' => array(
                        'type'    => 'select',
                        'label'   => __('Show Date', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'show_author' => array(
                        'type'    => 'select',
                        'label'   => __('Show Author', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
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
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'pagination_type' => array(
                        'type'    => 'select',
                        'label'   => __('Pagination Type', 'wsbb'),
                        'default' => 'numbers',
                        'options' => array(
                            'numbers'  => __('Numbers', 'wsbb'),
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
