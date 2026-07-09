<?php

class Wsbb_Logo extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Logo', 'wsbb'),
            'description'     => __('Display site logo with customizable size and alignment.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-logo/',
            'url'             => WSBB_MODULES_URL . 'wsbb-logo/',
            'icon'            => 'format-image',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-logo', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
    }
}

// Build available menus list for link field description
$menus = get_registered_nav_menus();

FLBuilder::register_module('Wsbb_Logo', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('Logo', 'wsbb'),
                'fields' => array(
                    'logo_type' => array(
                        'type'    => 'select',
                        'label'   => __('Logo Source', 'wsbb'),
                        'default' => 'customizer',
                        'options' => array(
                            'customizer' => __('Theme Customizer Logo', 'wsbb'),
                            'custom'     => __('Custom Image', 'wsbb'),
                        ),
                        'toggle' => array(
                            'custom' => array(
                                'fields' => array('custom_logo'),
                            ),
                        ),
                    ),
                    'custom_logo' => array(
                        'type'  => 'photo',
                        'label' => __('Logo Image', 'wsbb'),
                    ),
                    'logo_link' => array(
                        'type'          => 'link',
                        'label'         => __('Logo Link', 'wsbb'),
                        'default'       => home_url(),
                        'show_target'   => true,
                        'placeholder'   => home_url(),
                    ),
                ),
            ),
        ),
    ),
    'style' => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'sizing' => array(
                'title'  => __('Size & Alignment', 'wsbb'),
                'fields' => array(
                    'logo_width' => array(
                        'type'        => 'unit',
                        'label'       => __('Logo Max Width', 'wsbb'),
                        'description' => 'px',
                        'responsive'  => true,
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-logo-img',
                            'property' => 'max-width',
                        ),
                    ),
                    'align' => array(
                        'type'    => 'align',
                        'label'   => __('Alignment', 'wsbb'),
                        'default' => 'left',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-logo-wrap',
                            'property' => 'text-align',
                        ),
                    ),
                ),
            ),
        ),
    ),
));
