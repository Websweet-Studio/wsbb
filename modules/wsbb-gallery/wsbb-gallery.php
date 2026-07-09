<?php

class Wsbb_Gallery extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Gallery', 'wsbb'),
            'description'     => __('Image gallery with lightbox modal.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Gallery', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-gallery/',
            'url'             => WSBB_MODULES_URL . 'wsbb-gallery/',
            'icon'            => 'format-gallery',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-gallery', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
        $this->add_js('wsbb-gallery', $this->url . 'js/frontend.js', array('jquery'), WSBB_VERSION, true);
    }
}

// Register the module
FLBuilder::register_module('Wsbb_Gallery', array(
    'general' => array(
        'title'    => __('Photos', 'wsbb'),
        'sections' => array(
            'photos' => array(
                'title'  => __('Gallery Photos', 'wsbb'),
                'fields' => array(
                    'photos' => array(
                        'type'  => 'multiple-photos',
                        'label' => __('Select Photos', 'wsbb'),
                    ),
                ),
            ),
        ),
    ),
    'layout' => array(
        'title'    => __('Layout', 'wsbb'),
        'sections' => array(
            'style' => array(
                'title'  => __('Style', 'wsbb'),
                'fields' => array(
                    'background_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-gallery-grid',
                            'property' => 'background-color',
                        ),
                    ),
                    'padding' => array(
                        'type'        => 'dimension',
                        'label'       => __('Padding', 'wsbb'),
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-gallery-grid',
                            'property' => 'padding',
                        ),
                    ),
                    'caption_color' => array(
                        'type'       => 'color',
                        'label'      => __('Caption Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-gallery-link',
                            'property' => 'color',
                        ),
                    ),
                    'layout_style' => array(
                        'type'    => 'select',
                        'label'   => __('Gallery Style', 'wsbb'),
                        'default' => 'grid',
                        'options' => array(
                            'grid'    => __('Grid (Uniform)', 'wsbb'),
                            'masonry' => __('Masonry', 'wsbb'),
                        ),
                    ),
                    'aspect_ratio' => array(
                        'type'    => 'select',
                        'label'   => __('Aspect Ratio', 'wsbb'),
                        'default' => '4-3',
                        'options' => array(
                            '4-3'      => '4:3',
                            '16-9'     => '16:9',
                            '1-1'      => '1:1 (Square)',
                            '3-2'      => '3:2',
                            'original' => __('Original', 'wsbb'),
                        ),
                        'show' => array(
                            'fields' => array('layout_style'),
                            'options' => array(
                                'layout_style' => array('grid'),
                            ),
                        ),
                    ),
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '4',
                        'description' => 'px',
                    ),
                    'hover_effect' => array(
                        'type'    => 'select',
                        'label'   => __('Hover Effect', 'wsbb'),
                        'default' => 'zoom',
                        'options' => array(
                            'zoom'  => __('Zoom In', 'wsbb'),
                            'fade'  => __('Fade', 'wsbb'),
                            'none'  => __('None', 'wsbb'),
                        ),
                    ),
                ),
            ),
            'grid' => array(
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
                        'default'     => '10',
                        'description' => 'px',
                    ),
                ),
            ),
        ),
    ),
    'lightbox' => array(
        'title'    => __('Lightbox', 'wsbb'),
        'sections' => array(
            'lightbox_settings' => array(
                'title'  => __('Lightbox Settings', 'wsbb'),
                'fields' => array(
                    'enable_lightbox' => array(
                        'type'    => 'select',
                        'label'   => __('Enable Lightbox', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                ),
            ),
        ),
    ),
));
