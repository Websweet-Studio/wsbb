<?php

class Wsbb_Testimoni extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Testimoni', 'wsbb'),
            'description'     => __('Display testimonials in grid, list, or carousel layout.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Content', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-testimoni/',
            'url'             => WSBB_MODULES_URL . 'wsbb-testimoni/',
            'icon'            => 'format-quote',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-testimoni', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
        $this->add_js('wsbb-testimoni', $this->url . 'js/frontend.js', array('jquery'), WSBB_VERSION, true);
    }
}

// Register the module
FLBuilder::register_module('Wsbb_Testimoni', array(
    'content' => array(
        'title'    => __('Content', 'wsbb'),
        'sections' => array(
            'testimonials' => array(
                'title'  => __('Testimonials', 'wsbb'),
                'fields' => array(
                    'testimoni_items' => array(
                        'type'         => 'form',
                        'label'        => __('Testimonial Items', 'wsbb'),
                        'form'         => 'wsbb_testimoni_form',
                        'preview_text' => __('Testimonial', 'wsbb'),
                        'multiple'     => true,
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
                            'list'     => __('List', 'wsbb'),
                            'carousel' => __('Carousel', 'wsbb'),
                        ),
                        'toggle' => array(
                            'grid' => array(
                                'sections' => array('grid_settings'),
                            ),
                            'list' => array(),
                            'carousel' => array(
                                'sections' => array('carousel_settings'),
                            ),
                        ),
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
                    'carousel_loop' => array(
                        'type'    => 'select',
                        'label'   => __('Infinite Loop', 'wsbb'),
                        'default' => 'yes',
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
                    'card_bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Card Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'card_padding' => array(
                        'type'        => 'dimension',
                        'label'       => __('Card Padding', 'wsbb'),
                        'description' => 'px',
                    ),
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '8',
                        'description' => 'px',
                    ),
                    'avatar_size' => array(
                        'type'        => 'unit',
                        'label'       => __('Avatar Size', 'wsbb'),
                        'default'     => '60',
                        'description' => 'px',
                    ),
                    'text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'name_color' => array(
                        'type'       => 'color',
                        'label'      => __('Name Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'role_color' => array(
                        'type'       => 'color',
                        'label'      => __('Role Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                ),
            ),
            'elements' => array(
                'title'  => __('Elements', 'wsbb'),
                'fields' => array(
                    'show_avatar' => array(
                        'type'    => 'select',
                        'label'   => __('Show Avatar', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'show_name' => array(
                        'type'    => 'select',
                        'label'   => __('Show Name', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'show_role' => array(
                        'type'    => 'select',
                        'label'   => __('Show Role', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'show_text' => array(
                        'type'    => 'select',
                        'label'   => __('Show Testimonial Text', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'show_rating' => array(
                        'type'    => 'select',
                        'label'   => __('Show Rating Stars', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'rating_align' => array(
                        'type'    => 'align',
                        'label'   => __('Rating Alignment', 'wsbb'),
                        'default' => 'center',
                    ),
                ),
            ),
        ),
    ),
));

// Register the testimonial item form
FLBuilder::register_settings_form('wsbb_testimoni_form', array(
    'title' => __('Testimonial Item', 'wsbb'),
    'tabs'  => array(
        'general' => array(
            'title'    => __('General', 'wsbb'),
            'sections' => array(
                'info' => array(
                    'title'  => __('Testimonial Info', 'wsbb'),
                    'fields' => array(
                        'photo' => array(
                            'type'  => 'photo',
                            'label' => __('Photo / Avatar', 'wsbb'),
                        ),
                        'name' => array(
                            'type'  => 'text',
                            'label' => __('Name', 'wsbb'),
                        ),
                        'role' => array(
                            'type'  => 'text',
                            'label' => __('Role / Position', 'wsbb'),
                        ),
                        'text' => array(
                            'type'  => 'textarea',
                            'label' => __('Testimonial Text', 'wsbb'),
                            'rows'  => '4',
                        ),
                        'rating' => array(
                            'type'    => 'select',
                            'label'   => __('Rating', 'wsbb'),
                            'default' => '5',
                            'options' => array(
                                '1' => '1 Star',
                                '2' => '2 Stars',
                                '3' => '3 Stars',
                                '4' => '4 Stars',
                                '5' => '5 Stars',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
));
