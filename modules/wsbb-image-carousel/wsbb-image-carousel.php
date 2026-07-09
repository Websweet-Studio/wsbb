<?php

class Wsbb_Image_Carousel extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Image Carousel', 'wsbb'),
            'description'     => __('Image carousel and marquee slider with grid, list layout.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Gallery', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-image-carousel/',
            'url'             => WSBB_MODULES_URL . 'wsbb-image-carousel/',
            'icon'            => 'images-alt2',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-image-carousel', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
        $this->add_js('wsbb-image-carousel', $this->url . 'js/frontend.js', array('jquery'), WSBB_VERSION, true);
    }
}

// Register the module
FLBuilder::register_module('Wsbb_Image_Carousel', array(
    'content' => array(
        'title'    => __('Images', 'wsbb'),
        'sections' => array(
            'images' => array(
                'title'  => __('Select Images', 'wsbb'),
                'fields' => array(
                    'images' => array(
                        'type'  => 'multiple-photos',
                        'label' => __('Select Images', 'wsbb'),
                    ),
                ),
            ),
        ),
    ),
    'layout' => array(
        'title'    => __('Layout', 'wsbb'),
        'sections' => array(
            'mode_section' => array(
                'title'  => __('Mode', 'wsbb'),
                'fields' => array(
                    'slider_mode' => array(
                        'type'    => 'select',
                        'label'   => __('Slider Mode', 'wsbb'),
                        'default' => 'carousel',
                        'options' => array(
                            'carousel' => __('Carousel (Slide)', 'wsbb'),
                            'marquee'  => __('Marquee (Continuous)', 'wsbb'),
                        ),
                        'toggle' => array(
                            'carousel' => array(
                                'sections' => array('carousel_settings'),
                            ),
                            'marquee' => array(
                                'sections' => array('marquee_settings'),
                            ),
                        ),
                    ),
                    'display_mode' => array(
                        'type'    => 'select',
                        'label'   => __('Display Mode', 'wsbb'),
                        'default' => 'grid',
                        'options' => array(
                            'grid'     => __('Grid', 'wsbb'),
                            'list'     => __('List', 'wsbb'),
                            'carousel' => __('Carousel', 'wsbb'),
                        ),
                        'toggle' => array(
                            'grid'     => array('sections' => array('grid_settings')),
                            'list'     => array(),
                            'carousel' => array('sections' => array('grid_settings')),
                        ),
                    ),
                ),
            ),
            'grid_settings' => array(
                'title'  => __('Grid / Rows', 'wsbb'),
                'fields' => array(
                    'rows' => array(
                        'type'    => 'select',
                        'label'   => __('Rows', 'wsbb'),
                        'default' => '1',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                        ),
                    ),
                    'columns' => array(
                        'type'    => 'select',
                        'label'   => __('Columns Per Row', 'wsbb'),
                        'default' => '4',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
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
                        'type'    => 'select',
                        'label'   => __('Slides Per View', 'wsbb'),
                        'default' => '3',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                        ),
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
            'marquee_settings' => array(
                'title'  => __('Marquee Settings', 'wsbb'),
                'fields' => array(
                    'marquee_speed' => array(
                        'type'        => 'unit',
                        'label'       => __('Speed (seconds)', 'wsbb'),
                        'default'     => '20',
                        'description' => __('s per full scroll', 'wsbb'),
                    ),
                    'marquee_direction' => array(
                        'type'    => 'select',
                        'label'   => __('Direction', 'wsbb'),
                        'default' => 'left',
                        'options' => array(
                            'left'  => __('Left to Right', 'wsbb'),
                            'right' => __('Right to Left', 'wsbb'),
                        ),
                    ),
                    'marquee_pause' => array(
                        'type'    => 'select',
                        'label'   => __('Pause on Hover', 'wsbb'),
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
                    'background_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'padding' => array(
                        'type'        => 'dimension',
                        'label'       => __('Padding', 'wsbb'),
                        'description' => 'px',
                    ),
                    'caption_color' => array(
                        'type'       => 'color',
                        'label'      => __('Caption Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '8',
                        'description' => 'px',
                    ),
                    'aspect_ratio' => array(
                        'type'    => 'select',
                        'label'   => __('Aspect Ratio', 'wsbb'),
                        'default' => '16-9',
                        'options' => array(
                            '1-1'      => '1:1 (Square)',
                            '4-3'      => '4:3',
                            '16-9'     => '16:9',
                            '3-2'      => '3:2',
                            'original' => __('Original', 'wsbb'),
                        ),
                    ),
                ),
            ),
        ),
    ),
));
