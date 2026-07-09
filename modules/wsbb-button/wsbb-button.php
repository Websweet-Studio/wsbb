<?php

class Wsbb_Button extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Button', 'wsbb'),
            'description'     => __('Customizable call-to-action button.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-button/',
            'url'             => WSBB_MODULES_URL . 'wsbb-button/',
            'icon'            => 'button',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-button', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
    }
}

FLBuilder::register_module('Wsbb_Button', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('Content', 'wsbb'),
                'fields' => array(
                    'button_text' => array(
                        'type'    => 'text',
                        'label'   => __('Button Text', 'wsbb'),
                        'default' => 'Click Here',
                        'preview' => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-button-text',
                        ),
                    ),
                    'button_link' => array(
                        'type'          => 'link',
                        'label'         => __('Link', 'wsbb'),
                        'placeholder'   => 'https://',
                        'show_target'   => true,
                        'show_nofollow' => true,
                    ),
                    'button_icon' => array(
                        'type'        => 'icon',
                        'label'       => __('Icon', 'wsbb'),
                        'show_remove' => true,
                    ),
                    'icon_position' => array(
                        'type'    => 'select',
                        'label'   => __('Icon Position', 'wsbb'),
                        'default' => 'before',
                        'options' => array(
                            'before' => __('Before Text', 'wsbb'),
                            'after'  => __('After Text', 'wsbb'),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'style' => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'style' => array(
                'title'  => __('Button Style', 'wsbb'),
                'fields' => array(
                    'button_style' => array(
                        'type'    => 'button-group',
                        'label'   => __('Button Style', 'wsbb'),
                        'default' => 'filled',
                        'options' => array(
                            'filled'   => __('Filled', 'wsbb'),
                            'outlined' => __('Outlined', 'wsbb'),
                            'ghost'    => __('Ghost', 'wsbb'),
                        ),
                    ),
                    'align' => array(
                        'type'    => 'align',
                        'label'   => __('Alignment', 'wsbb'),
                        'default' => 'left',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-wrap',
                            'property' => 'text-align',
                        ),
                    ),
                    'full_width' => array(
                        'type'    => 'select',
                        'label'   => __('Full Width', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('No', 'wsbb'),
                            'yes' => __('Yes', 'wsbb'),
                        ),
                    ),
                    'size_preset' => array(
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
                                'fields' => array('padding_h', 'padding_v', 'font_size'),
                            ),
                        ),
                    ),
                ),
            ),
            'colors' => array(
                'title'  => __('Colors', 'wsbb'),
                'fields' => array(
                    'text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'color',
                        ),
                    ),
                    'text_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Hover Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'bg_type' => array(
                        'type'    => 'select',
                        'label'   => __('Background Type', 'wsbb'),
                        'default' => 'solid',
                        'options' => array(
                            'solid'    => __('Solid', 'wsbb'),
                            'gradient' => __('Gradient', 'wsbb'),
                        ),
                        'toggle' => array(
                            'solid'    => array('fields' => array('bg_color')),
                            'gradient' => array('fields' => array('bg_gradient')),
                        ),
                    ),
                    'bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '0073e6',
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'background-color',
                        ),
                    ),
                    'bg_gradient' => array(
                        'type'    => 'gradient',
                        'label'   => __('Background Gradient', 'wsbb'),
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'background-image',
                        ),
                    ),
                    'bg_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Hover Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '005bb5',
                    ),
                ),
            ),
            'border' => array(
                'title'  => __('Border', 'wsbb'),
                'fields' => array(
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'default'     => '4',
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'border-radius',
                        ),
                    ),
                    'border_width' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Width', 'wsbb'),
                        'default'     => '2',
                        'description' => 'px',
                    ),
                    'border_color' => array(
                        'type'       => 'color',
                        'label'      => __('Border Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'border_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Border Hover Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                ),
            ),
            'typography' => array(
                'title'  => __('Typography', 'wsbb'),
                'fields' => array(
                    'button_font' => array(
                        'type'    => 'font',
                        'label'   => __('Font Family', 'wsbb'),
                        'default' => array('family' => 'Default', 'weight' => '600'),
                    ),
                    'font_size' => array(
                        'type'        => 'unit',
                        'label'       => __('Font Size', 'wsbb'),
                        'default'     => '16',
                        'description' => 'px',
                        'responsive'  => true,
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'font-size',
                        ),
                    ),
                    'font_weight' => array(
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
                            'selector' => '.wsbb-button-link',
                            'property' => 'font-weight',
                        ),
                    ),
                    'letter_spacing' => array(
                        'type'        => 'unit',
                        'label'       => __('Letter Spacing', 'wsbb'),
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'letter-spacing',
                        ),
                    ),
                ),
            ),
            'spacing' => array(
                'title'  => __('Spacing', 'wsbb'),
                'fields' => array(
                    'padding_h' => array(
                        'type'        => 'unit',
                        'label'       => __('Horizontal Padding', 'wsbb'),
                        'default'     => '24',
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'padding-left',
                        ),
                    ),
                    'padding_v' => array(
                        'type'        => 'unit',
                        'label'       => __('Vertical Padding', 'wsbb'),
                        'default'     => '12',
                        'description' => 'px',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-button-link',
                            'property' => 'padding-top',
                        ),
                    ),
                ),
            ),
            'shadow' => array(
                'title'  => __('Shadow', 'wsbb'),
                'fields' => array(
                    'box_shadow' => array(
                        'type'    => 'select',
                        'label'   => __('Enable Shadow', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('No', 'wsbb'),
                            'yes' => __('Yes', 'wsbb'),
                        ),
                    ),
                    'shadow_hover' => array(
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
            'animation' => array(
                'title'  => __('Animation', 'wsbb'),
                'fields' => array(
                    'hover_animation' => array(
                        'type'    => 'select',
                        'label'   => __('Hover Animation', 'wsbb'),
                        'default' => 'none',
                        'options' => array(
                            'none' => __('None', 'wsbb'),
                            'pulse'    => __('Pulse', 'wsbb'),
                            'shake'    => __('Shake', 'wsbb'),
                            'glow'     => __('Glow', 'wsbb'),
                            'float'    => __('Float', 'wsbb'),
                        ),
                    ),
                    'tooltip' => array(
                        'type'        => 'text',
                        'label'       => __('Tooltip Text', 'wsbb'),
                        'help'        => __('Shown on hover if filled.', 'wsbb'),
                        'placeholder' => __('Optional tooltip...', 'wsbb'),
                    ),
                ),
            ),
        ),
    ),
));
