<?php

class Wsbb_Html extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB HTML', 'wsbb'),
            'description'     => __('Insert custom HTML content.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-html/',
            'url'             => WSBB_MODULES_URL . 'wsbb-html/',
            'icon'            => 'text.svg',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-html', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
    }
}

// Register the module
FLBuilder::register_module('Wsbb_Html', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('HTML Content', 'wsbb'),
                'fields' => array(
                    'html_content' => array(
                        'type'   => 'code',
                        'editor' => 'html',
                        'label'  => __('HTML', 'wsbb'),
                        'rows'   => '12',
                        'default' => '<h2>Your Heading Here</h2>
<p>Your paragraph content goes here.</p>',
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
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-html-inner',
                            'property' => 'background-color',
                        ),
                    ),
                    'text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '',
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-html-inner',
                            'property' => 'color',
                        ),
                    ),
                    'padding' => array(
                        'type'        => 'dimension',
                        'label'       => __('Padding', 'wsbb'),
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-html-inner',
                            'property' => 'padding',
                        ),
                    ),
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '0',
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-html-inner',
                            'property' => 'border-radius',
                        ),
                    ),
                ),
            ),
        ),
    ),
));
