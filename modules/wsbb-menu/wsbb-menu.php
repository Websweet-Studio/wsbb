<?php

class Wsbb_Menu extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Menu', 'wsbb'),
            'description'     => __('Display a WordPress navigation menu with responsive hamburger toggle.', 'wsbb'),
            'group'           => __('WSBB Modules', 'wsbb'),
            'category'        => __('Layout', 'wsbb'),
            'dir'             => WSBB_MODULES_DIR . 'wsbb-menu/',
            'url'             => WSBB_MODULES_URL . 'wsbb-menu/',
            'icon'            => 'list',
            'editor_export'   => true,
            'enabled'         => true,
            'partial_refresh' => false,
            'include_wrapper' => false,
        ));
    }

    public function enqueue_scripts()
    {
        $this->add_css('wsbb-menu', $this->url . 'css/frontend.css', array(), WSBB_VERSION);
        if (in_array($this->settings->menu_layout, array('horizontal', 'hamburger'))) {
            $this->add_js('wsbb-menu', $this->url . 'js/frontend.js', array('jquery'), WSBB_VERSION, true);
        }
    }
}

// Build available menus list for settings
$nav_menus = array('' => __('— Select Menu —', 'wsbb'));
$all_menus = wp_get_nav_menus();
foreach ($all_menus as $menu) {
    $nav_menus[$menu->slug] = $menu->name;
}

FLBuilder::register_module('Wsbb_Menu', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'content' => array(
                'title'  => __('Menu', 'wsbb'),
                'fields' => array(
                    'menu_select' => array(
                        'type'    => 'select',
                        'label'   => __('Select Menu', 'wsbb'),
                        'default' => '',
                        'options' => $nav_menus,
                    ),
                    'menu_layout' => array(
                        'type'    => 'select',
                        'label'   => __('Layout', 'wsbb'),
                        'default' => 'horizontal',
                        'options' => array(
                            'horizontal' => __('Horizontal', 'wsbb'),
                            'vertical'   => __('Vertical', 'wsbb'),
                            'hamburger'  => __('Hamburger (Always)', 'wsbb'),
                        ),
                        'toggle' => array(
                            'horizontal' => array(
                                'fields' => array('mobile_breakpoint'),
                            ),
                        ),
                    ),
                    'menu_align' => array(
                        'type'    => 'align',
                        'label'   => __('Alignment', 'wsbb'),
                        'default' => 'left',
                        'preview' => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-menu-nav',
                            'property' => 'text-align',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'style' => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'colors' => array(
                'title'  => __('Colors', 'wsbb'),
                'fields' => array(
                    'link_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '333333',
                        'preview'    => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-menu-nav a',
                            'property' => 'color',
                        ),
                    ),
                    'link_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Hover Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '0073e6',
                    ),
                    'link_active_color' => array(
                        'type'       => 'color',
                        'label'      => __('Active/Current Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'menu_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Menu Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'dropdown_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Dropdown Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => 'ffffff',
                    ),
                    'dropdown_link_color' => array(
                        'type'       => 'color',
                        'label'      => __('Dropdown Link Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'dropdown_link_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Dropdown Link Hover Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                ),
            ),
            'typography' => array(
                'title'  => __('Typography', 'wsbb'),
                'fields' => array(
                    'menu_font' => array(
                        'type'    => 'font',
                        'label'   => __('Font', 'wsbb'),
                        'default' => array('family' => 'Default', 'weight' => '500'),
                    ),
                    'font_size' => array(
                        'type'        => 'unit',
                        'label'       => __('Font Size', 'wsbb'),
                        'default'     => '16',
                        'description' => 'px',
                        'responsive'  => true,
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-menu-nav a',
                            'property' => 'font-size',
                        ),
                    ),
                    'letter_spacing' => array(
                        'type'        => 'unit',
                        'label'       => __('Letter Spacing', 'wsbb'),
                        'description' => 'px',
                    ),
                    'text_transform' => array(
                        'type'    => 'select',
                        'label'   => __('Text Transform', 'wsbb'),
                        'default' => 'none',
                        'options' => array(
                            'none'       => __('None', 'wsbb'),
                            'uppercase'  => __('Uppercase', 'wsbb'),
                            'lowercase'  => __('Lowercase', 'wsbb'),
                            'capitalize' => __('Capitalize', 'wsbb'),
                        ),
                    ),
                ),
            ),
            'spacing' => array(
                'title'  => __('Spacing', 'wsbb'),
                'fields' => array(
                    'item_spacing' => array(
                        'type'        => 'unit',
                        'label'       => __('Item Spacing (Horizontal)', 'wsbb'),
                        'description' => 'px',
                        'default'     => '20',
                        'preview'     => array(
                            'type'     => 'css',
                            'selector' => '.wsbb-menu-nav > li',
                            'property' => 'margin-right',
                        ),
                    ),
                    'item_spacing_v' => array(
                        'type'        => 'unit',
                        'label'       => __('Item Spacing (Vertical)', 'wsbb'),
                        'description' => 'px',
                        'default'     => '8',
                    ),
                    'link_padding_h' => array(
                        'type'        => 'unit',
                        'label'       => __('Link Horizontal Padding', 'wsbb'),
                        'description' => 'px',
                        'default'     => '0',
                    ),
                    'link_padding_v' => array(
                        'type'        => 'unit',
                        'label'       => __('Link Vertical Padding', 'wsbb'),
                        'description' => 'px',
                        'default'     => '8',
                    ),
                    'menu_padding' => array(
                        'type'        => 'dimension',
                        'label'       => __('Container Padding', 'wsbb'),
                        'description' => 'px',
                    ),
                ),
            ),
            'mobile' => array(
                'title'  => __('Mobile', 'wsbb'),
                'fields' => array(
                    'mobile_breakpoint' => array(
                        'type'        => 'unit',
                        'label'       => __('Mobile Breakpoint', 'wsbb'),
                        'description' => 'px',
                        'default'     => '768',
                        'help'        => __('Switch to hamburger menu below this width.', 'wsbb'),
                    ),
                    'hamburger_color' => array(
                        'type'       => 'color',
                        'label'      => __('Hamburger Icon Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => '333333',
                    ),
                    'mobile_menu_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Mobile Menu Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                        'default'    => 'ffffff',
                    ),
                ),
            ),
        ),
    ),
));
