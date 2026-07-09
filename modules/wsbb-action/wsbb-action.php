<?php

class Wsbb_Action extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Action', 'wsbb'),
            'description'     => __('Call-to-action module with heading, text, and button.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-action/',
            'url'             => WSBB_MODULES_URL . 'wsbb-action/',
            'icon'            => 'megaphone.svg',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-action', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
    }
}

FLBuilder::register_module('Wsbb_Action', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('Content', 'wsbb'),
                'fields' => array(
                    'heading_text' => array(
                        'type'    => 'text',
                        'label'   => __('Heading', 'wsbb'),
                        'default' => 'Your Action Title',
                        'class'   => 'wsbb-input-heading',
                        'preview' => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-action-heading',
                        ),
                    ),
                    'description' => array(
                        'type'          => 'editor',
                        'label'         => __('Description', 'wsbb'),
                        'default'       => 'Your action description here.',
                        'media_buttons' => false,
                        'preview'       => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-action-desc',
                        ),
                    ),
                    'btn_text'    => array(
                        'type'    => 'text',
                        'label'   => __('Button Text', 'wsbb'),
                        'default' => 'Learn More',
                        'preview' => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-action-btn',
                        ),
                    ),
                    'btn_link'    => array(
                        'type'          => 'link',
                        'label'         => __('Button Link', 'wsbb'),
                        'show_target'   => true,
                        'placeholder'   => 'https://',
                    ),
                ),
            ),
        ),
    ),
    'style'   => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'alignment'  => array(
                'title'  => __('Alignment', 'wsbb'),
                'fields' => array(
                    'content_align' => array(
                        'type'    => 'align',
                        'label'   => __('Content Alignment', 'wsbb'),
                        'default' => 'center',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-inner',
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
                        'label'   => __('Heading Font', 'wsbb'),
                        'default' => array(
                            'family' => 'Default',
                            'weight' => '700',
                        ),
                    ),
                    'heading_color' => array(
                        'type'       => 'color',
                        'label'      => __('Heading Color', 'wsbb'),
                        'show_reset' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-heading',
                            'property' => 'color',
                        ),
                    ),
                    'heading_size'  => array(
                        'type'        => 'unit',
                        'label'       => __('Heading Size', 'wsbb'),
                        'description' => 'px',
                        'responsive'  => true,
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-heading',
                            'property' => 'font-size',
                        ),
                    ),
                    'desc_color'    => array(
                        'type'       => 'color',
                        'label'      => __('Description Color', 'wsbb'),
                        'show_reset' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-desc',
                            'property' => 'color',
                        ),
                    ),
                ),
            ),
            'button'     => array(
                'title'  => __('Button', 'wsbb'),
                'fields' => array(
                    'btn_position'   => array(
                        'type'    => 'button-group',
                        'label'   => __('Button Position', 'wsbb'),
                        'default' => 'inline',
                        'options' => array(
                            'inline'  => __('Beside Content', 'wsbb'),
                            'stacked' => __('Below Description', 'wsbb'),
                        ),
                    ),
                    'btn_bg_color'   => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'default'    => '2962ff',
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-btn',
                            'property' => 'background-color',
                        ),
                    ),
                    'btn_text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'default'    => 'ffffff',
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-btn',
                            'property' => 'color',
                        ),
                    ),
                    'btn_bg_hover'   => array(
                        'type'       => 'color',
                        'label'      => __('Hover Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_text_hover'  => array(
                        'type'       => 'color',
                        'label'      => __('Hover Text Color', 'wsbb'),
                        'show_reset' => true,
                    ),
                ),
            ),
        ),
    ),
));
