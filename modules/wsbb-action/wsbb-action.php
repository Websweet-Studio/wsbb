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
            'icon'            => 'megaphone',
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
            'background'  => array(
                'title'  => __('Background', 'wsbb'),
                'fields' => array(
                    'bg_image' => array(
                        'type'  => 'photo',
                        'label' => __('Background Image', 'wsbb'),
                        'show'  => array(
                            'fields' => array('bg_overlay', 'container_width'),
                        ),
                    ),
                    'bg_overlay' => array(
                        'type'       => 'color',
                        'label'      => __('Overlay Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'help'       => __('Semi-transparent overlay on top of bg image.', 'wsbb'),
                    ),
                    'container_width' => array(
                        'type'    => 'select',
                        'label'   => __('Container Width', 'wsbb'),
                        'default' => 'full',
                        'options' => array(
                            'narrow' => __('Narrow', 'wsbb'),
                            'medium' => __('Medium', 'wsbb'),
                            'full'   => __('Full', 'wsbb'),
                        ),
                    ),
                ),
            ),
            'alignment'  => array(
                'title'  => __('Alignment & Animation', 'wsbb'),
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
                    'btn_align' => array(
                        'type'    => 'align',
                        'label'   => __('Button Alignment', 'wsbb'),
                        'default' => 'center',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-btn-wrap',
                            'property' => 'text-align',
                        ),
                    ),
                    'gap_head_desc' => array(
                        'type'        => 'unit',
                        'label'       => __('Gap Heading–Description', 'wsbb'),
                        'default'     => '8',
                        'description' => 'px',
                    ),
                    'enable_animation' => array(
                        'type'    => 'select',
                        'label'   => __('Reveal Animation', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('None', 'wsbb'),
                            'yes' => __('Enabled', 'wsbb'),
                        ),
                        'toggle'  => array(
                            'yes' => array(
                                'fields' => array('animation_type'),
                            ),
                        ),
                    ),
                    'animation_type' => array(
                        'type'    => 'select',
                        'label'   => __('Animation Type', 'wsbb'),
                        'default' => 'fade-up',
                        'options' => array(
                            'fade-in'    => __('Fade In', 'wsbb'),
                            'fade-up'    => __('Fade Up', 'wsbb'),
                            'fade-left'  => __('Fade Left', 'wsbb'),
                            'fade-right' => __('Fade Right', 'wsbb'),
                            'zoom-in'    => __('Zoom In', 'wsbb'),
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
                    'btn_style'      => array(
                        'type'    => 'button-group',
                        'label'   => __('Button Style', 'wsbb'),
                        'default' => 'filled',
                        'options' => array(
                            'filled'   => __('Filled', 'wsbb'),
                            'outlined' => __('Outlined', 'wsbb'),
                            'ghost'    => __('Ghost', 'wsbb'),
                        ),
                    ),
                    'btn_bg_color'   => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
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
                        'show_alpha' => true,
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
                        'show_alpha' => true,
                    ),
                    'btn_border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '4',
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-btn',
                            'property' => 'border-radius',
                        ),
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
                    'btn_size_preset' => array(
                        'type'    => 'button-group',
                        'label'   => __('Size', 'wsbb'),
                        'default' => 'medium',
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
                        'default'     => '24',
                        'description' => 'px',
                    ),
                    'btn_padding_v' => array(
                        'type'        => 'unit',
                        'label'       => __('Vertical Padding', 'wsbb'),
                        'default'     => '12',
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
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-action-btn',
                            'property' => 'font-weight',
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
));
