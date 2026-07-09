<?php

class Wsbb_Pricelist extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Pricelist', 'wsbb'),
            'description'     => __('Pricing table module with features list and CTA button.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-pricelist/',
            'url'             => WSBB_MODULES_URL . 'wsbb-pricelist/',
            'icon'            => 'products',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-pricelist', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
    }
}

FLBuilder::register_module('Wsbb_Pricelist', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('Content', 'wsbb'),
                'fields' => array(
                    'plan_name' => array(
                        'type'    => 'text',
                        'label'   => __('Plan Name', 'wsbb'),
                        'default' => 'Basic Plan',
                        'preview' => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-pricelist-name',
                        ),
                    ),
                    'price'     => array(
                        'type'        => 'text',
                        'label'       => __('Price', 'wsbb'),
                        'default'     => '29',
                        'description' => __('Numbers only, e.g. 29', 'wsbb'),
                        'preview'     => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-pricelist-price-amount',
                        ),
                    ),
                    'currency'  => array(
                        'type'    => 'text',
                        'label'   => __('Currency Symbol', 'wsbb'),
                        'default' => '$',
                        'preview' => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-pricelist-currency',
                        ),
                    ),
                    'currency_position' => array(
                        'type'    => 'select',
                        'label'   => __('Currency Position', 'wsbb'),
                        'default' => 'prefix',
                        'options' => array(
                            'prefix' => __('Before price ($29)', 'wsbb'),
                            'suffix' => __('After price (29$)', 'wsbb'),
                        ),
                    ),
                    'period'    => array(
                        'type'    => 'text',
                        'label'   => __('Period', 'wsbb'),
                        'default' => '/mo',
                        'preview' => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-pricelist-period',
                        ),
                    ),
                    'description' => array(
                        'type'          => 'editor',
                        'label'         => __('Description', 'wsbb'),
                        'default'       => '',
                        'media_buttons' => false,
                        'preview'       => array(
                            'type'     => 'text',
                            'selector' => '.wsbb-pricelist-desc',
                        ),
                    ),
                ),
            ),
            'features' => array(
                'title'  => __('Features', 'wsbb'),
                'fields' => array(
                    'features' => array(
                        'type'     => 'text',
                        'label'    => __('Feature Item', 'wsbb'),
                        'multiple' => true,
                        'limit'    => 20,
                        'default'  => array(
                            'Feature 1',
                            'Feature 2',
                            'Feature 3',
                        ),
                    ),
                ),
            ),
            'button'   => array(
                'title'  => __('Button', 'wsbb'),
                'fields' => array(
                    'btn_text' => array(
                        'type'    => 'text',
                        'label'   => __('Button Text', 'wsbb'),
                        'default' => 'Get Started',
                    ),
                    'btn_link' => array(
                        'type'          => 'link',
                        'label'         => __('Button Link', 'wsbb'),
                        'show_target'   => true,
                        'placeholder'   => 'https://',
                    ),
                ),
            ),
        ),
    ),
    'style' => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'card' => array(
                'title'  => __('Card', 'wsbb'),
                'fields' => array(
                    'card_style' => array(
                        'type'    => 'button-group',
                        'label'   => __('Card Style', 'wsbb'),
                        'default' => 'standard',
                        'options' => array(
                            'standard'  => __('Standard', 'wsbb'),
                            'borderless' => __('Borderless', 'wsbb'),
                            'minimal'   => __('Minimal', 'wsbb'),
                            'elevated'  => __('Elevated', 'wsbb'),
                        ),
                    ),
                    'featured' => array(
                        'type'    => 'select',
                        'label'   => __('Featured / Highlight', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('No', 'wsbb'),
                            'yes' => __('Yes', 'wsbb'),
                        ),
                    ),
                    'featured_label' => array(
                        'type'    => 'text',
                        'label'   => __('Featured Label', 'wsbb'),
                        'default' => 'Popular',
                    ),
                    'bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                    ),
                    'border_color' => array(
                        'type'       => 'color',
                        'label'      => __('Border Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Border Radius', 'wsbb'),
                        'description' => 'px',
                        'default'     => '8',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-pricelist-card',
                            'property' => 'border-radius',
                        ),
                    ),
                    'card_padding' => array(
                        'type'        => 'dimension',
                        'label'       => __('Padding', 'wsbb'),
                        'description' => 'px',
                        'default'     => '32',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-pricelist-card',
                            'property' => 'padding',
                        ),
                    ),
                    'content_align' => array(
                        'type'    => 'align',
                        'label'   => __('Content Alignment', 'wsbb'),
                        'default' => 'left',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-pricelist-card',
                            'property' => 'text-align',
                        ),
                    ),
                    'show_shadow' => array(
                        'type'    => 'select',
                        'label'   => __('Show Shadow on Hover', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                    ),
                    'feature_icon_color' => array(
                        'type'       => 'color',
                        'label'      => __('Feature Icon Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '2e7d32',
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-pricelist-feature-icon::after',
                            'property' => 'border-color',
                        ),
                    ),
                    'highlight_bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Featured Card Accent Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'help'       => __('Overrides button bg color for featured card border/badge.', 'wsbb'),
                    ),
                ),
            ),
            'typography' => array(
                'title'  => __('Typography', 'wsbb'),
                'fields' => array(
                    'name_font' => array(
                        'type'    => 'font',
                        'label'   => __('Plan Name Font', 'wsbb'),
                        'default' => array(
                            'family' => 'Default',
                            'weight' => '600',
                        ),
                    ),
                    'name_color' => array(
                        'type'       => 'color',
                        'label'      => __('Plan Name Color', 'wsbb'),
                        'show_reset' => true,
                        'default'    => '1a1a1a',
                    ),
                    'price_color' => array(
                        'type'       => 'color',
                        'label'      => __('Price Color', 'wsbb'),
                        'show_reset' => true,
                        'default'    => '1a1a1a',
                    ),
                    'period_color' => array(
                        'type'       => 'color',
                        'label'      => __('Period Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'period_size' => array(
                        'type'        => 'unit',
                        'label'       => __('Period Font Size', 'wsbb'),
                        'default'     => '16',
                        'description' => 'px',
                    ),
                    'desc_font' => array(
                        'type'    => 'font',
                        'label'   => __('Description Font', 'wsbb'),
                        'default' => array(
                            'family' => 'Default',
                            'weight' => '400',
                        ),
                    ),
                    'feature_color' => array(
                        'type'       => 'color',
                        'label'      => __('Feature Text Color', 'wsbb'),
                        'show_reset' => true,
                        'default'    => '555555',
                    ),
                ),
            ),
            'button' => array(
                'title'  => __('Button', 'wsbb'),
                'fields' => array(
                    'btn_style' => array(
                        'type'    => 'button-group',
                        'label'   => __('Button Style', 'wsbb'),
                        'default' => 'filled',
                        'options' => array(
                            'filled'   => __('Filled', 'wsbb'),
                            'outlined' => __('Outlined', 'wsbb'),
                            'ghost'    => __('Ghost', 'wsbb'),
                        ),
                    ),
                    'btn_border_radius' => array(
                        'type'        => 'unit',
                        'label'       => __('Button Border Radius', 'wsbb'),
                        'description' => 'px',
                        'default'     => '6',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-pricelist-btn',
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
                    'btn_bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '2962ff',
                    ),
                    'btn_text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_bg_hover' => array(
                        'type'       => 'color',
                        'label'      => __('Hover Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_text_hover' => array(
                        'type'       => 'color',
                        'label'      => __('Hover Text Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'btn_size_preset' => array(
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
                            'selector' => '.wsbb-pricelist-btn',
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
                        'default' => 'yes',
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
