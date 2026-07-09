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
            'icon'            => 'price-tag.svg',
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
                    'btn_bg_color' => array(
                        'type'       => 'color',
                        'label'      => __('Background Color', 'wsbb'),
                        'show_reset' => true,
                        'default'    => '2962ff',
                    ),
                    'btn_text_color' => array(
                        'type'       => 'color',
                        'label'      => __('Text Color', 'wsbb'),
                        'show_reset' => true,
                        'default'    => 'ffffff',
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
                    ),
                ),
            ),
        ),
    ),
));
