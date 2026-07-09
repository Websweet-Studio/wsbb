<?php

class Wsbb_Heading extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Heading', 'wsbb'),
            'description'     => __('Display a heading with customizable tag and style.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-heading/',
            'url'             => WSBB_MODULES_URL . 'wsbb-heading/',
            'icon'            => 'text.svg',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-heading', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
    }
}

// Register the module
FLBuilder::register_module('Wsbb_Heading', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('Content', 'wsbb'),
                'fields' => array(
                    'heading_text' => array(
                        'type'    => 'text',
                        'label'   => __('Heading Text', 'wsbb'),
                        'default' => 'Your Heading Here',
                        'preview' => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-heading-text',
                        ),
                    ),
                    'heading_tag' => array(
                        'type'    => 'select',
                        'label'   => __('HTML Tag', 'wsbb'),
                        'default' => 'h2',
                        'options' => array(
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'style' => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'alignment' => array(
                'title'  => __('Alignment', 'wsbb'),
                'fields' => array(
                    'align' => array(
                        'type'    => 'align',
                        'label'   => __('Alignment', 'wsbb'),
                        'default' => 'left',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-heading-text',
                            'property' => 'text-align',
                        ),
                    ),
                ),
            ),
            'typography' => array(
                'title'  => __('Typography', 'wsbb'),
                'fields' => array(
                    'heading_font' => array(
                        'type'    => 'font',
                        'label'   => __('Font Family', 'wsbb'),
                        'default' => array(
                            'family' => 'Default',
                            'weight' => '700',
                        ),
                    ),
                    'text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-heading-text',
                            'property' => 'color',
                        ),
                    ),
                    'font_size' => array(
                        'type'        => 'unit',
                        'label'       => __('Font Size', 'wsbb'),
                        'description' => 'px',
                        'responsive'  => true,
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-heading-text',
                            'property' => 'font-size',
                        ),
                    ),
                    'line_height' => array(
                        'type'        => 'unit',
                        'label'       => __('Line Height', 'wsbb'),
                        'default'     => '1.3',
                        'description' => '',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-heading-text',
                            'property' => 'line-height',
                        ),
                    ),
                    'letter_spacing' => array(
                        'type'        => 'unit',
                        'label'       => __('Letter Spacing', 'wsbb'),
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-heading-text',
                            'property' => 'letter-spacing',
                        ),
                    ),
                ),
            ),
        ),
    ),
));
