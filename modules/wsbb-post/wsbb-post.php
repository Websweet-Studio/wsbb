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
            'grid' => array(
                'title'  => __('Grid Settings', 'wsbb'),
                'fields' => array(
                    'layout_style' => array(
                        'type'    => 'select',
                        'label'   => __('Layout Style', 'wsbb'),
                        'default' => 'grid',
                        'options' => array(
                            'grid' => __('Grid', 'wsbb'),
                            'list' => __('List', 'wsbb'),
                        ),
                    ),
                    'columns' => array(
                        'type'    => 'select',
                        'label'   => __('Columns', 'wsbb'),
                        'default' => '3',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
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
            'style' => array(
                'title'  => __('Style', 'wsbb'),
                'fields' => array(
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '8',
                        'description' => 'px',
                    ),
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
                ),
            ),
            'elements' => array(
                'title'  => __('Post Elements', 'wsbb'),
                'fields' => array(
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
