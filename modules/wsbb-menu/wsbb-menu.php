<?php

class Wsbb_Menu extends FLBuilderModule
{
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __('WSBB Menu', 'wsbb'),
            'description'     => __('Display a WordPress navigation menu with advanced layout options.', 'wsbb'),
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
        $this->add_js('wsbb-menu', $this->url . 'js/frontend.js', array('jquery'), WSBB_VERSION, true);
    }

    /**
     * Get WordPress menus as options array.
     */
    public static function _get_menus()
    {
        $options = array('' => __('— Select Menu —', 'wsbb'));
        $menus   = wp_get_nav_menus();
        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }
        return $options;
    }
}

/**
 * Custom walker for WSBB Menu module.
 * Adds toggle buttons for submenus, similar to FL_Menu_Module_Walker.
 */
// phpcs:ignore Generic.Files.OneObjectStructurePerFile.MultipleFound
class Wsbb_Menu_Walker extends Walker_Nav_Menu
{

    protected $parent_id;

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent  = ($depth) ? str_repeat("\t", $depth) : '';
        $output .= $indent . '<ul class="sub-menu">';
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $this->parent_id = $item->ID;

        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $args   = (object) $args;

        $classes   = empty($item->classes) ? array() : (array) $item->classes;
        $submenu   = $args->has_children ? ' wsbb-has-submenu' : '';
        $icon      = $args->menu_class;

        // Check icon class in menu_class
        $has_none_icon = strpos($icon, 'wsbb-submenu-icon-none') !== false;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = ' class="' . esc_attr($class_names) . $submenu . '"';

        $item_id = 'menu-item-' . $item->ID;
        $output .= $indent . '<li id="' . $item_id . '"' . $class_names . '>';

        $attributes  = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
        $attributes .= in_array('current-menu-item', $classes) ? ' aria-current="page"' : '';

        // Wrap in container if has children
        if ($args->has_children) {
            $output .= '<div class="wsbb-has-submenu-container">';
        }

        $item_output  = $args->before;
        $item_output .= '<a ' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';

        if ($args->has_children && ! $has_none_icon) {
            $item_output .= '<button class="wsbb-submenu-toggle" aria-haspopup="menu" aria-expanded="false" aria-label="' . esc_attr($item->title) . ' submenu toggle"></button>';
        }

        $item_output .= $args->after;
        $item_output .= $args->has_children ? '</div>' : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        $output .= '</li>';
    }

    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        $id_field = $this->db_fields['id'];
        if (is_object($args[0])) {
            $args[0]->has_children = ! empty($children_elements[$element->$id_field]);
        }
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}

FLBuilder::register_module('Wsbb_Menu', array(
    'general' => array(
        'title'    => __('General', 'wsbb'),
        'sections' => array(
            'menu' => array(
                'title'  => __('Menu', 'wsbb'),
                'fields' => array(
                    'menu_select' => array(
                        'type'    => 'select',
                        'label'   => __('Select Menu', 'wsbb'),
                        'default' => '',
                        'options' => Wsbb_Menu::_get_menus(),
                    ),
                    'menu_layout' => array(
                        'type'    => 'select',
                        'label'   => __('Layout', 'wsbb'),
                        'default' => 'horizontal',
                        'options' => array(
                            'horizontal' => __('Horizontal', 'wsbb'),
                            'vertical'   => __('Vertical', 'wsbb'),
                            'accordion'  => __('Accordion', 'wsbb'),
                            'hamburger'  => __('Hamburger (Always)', 'wsbb'),
                        ),
                        'toggle' => array(
                            'horizontal' => array(
                                'fields' => array('mobile_breakpoint'),
                            ),
                        ),
                    ),
                    'submenu_icon' => array(
                        'type'    => 'select',
                        'label'   => __('Submenu Icon', 'wsbb'),
                        'default' => 'arrow',
                        'options' => array(
                            'arrow' => __('Arrow', 'wsbb'),
                            'plus'  => __('Plus', 'wsbb'),
                            'none'  => __('None', 'wsbb'),
                        ),
                    ),
                    'menu_name' => array(
                        'type'    => 'text',
                        'label'   => __('Menu Name', 'wsbb'),
                        'default' => __('Menu', 'wsbb'),
                        'help'    => __('Used for ARIA label and responsive toggle button text.', 'wsbb'),
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
            'responsive' => array(
                'title'  => __('Responsive', 'wsbb'),
                'fields' => array(
                    'responsive_toggle' => array(
                        'type'    => 'select',
                        'label'   => __('Responsive Toggle', 'wsbb'),
                        'default' => 'hamburger',
                        'options' => array(
                            'hamburger'       => __('Hamburger Icon', 'wsbb'),
                            'hamburger_label' => __('Hamburger Icon + Label', 'wsbb'),
                            'menu_button'     => __('Menu Button', 'wsbb'),
                            'none'            => __('None', 'wsbb'),
                        ),
                        'toggle' => array(
                            'none' => array(
                                'fields' => array('stack_mobile'),
                            ),
                        ),
                    ),
                    'stack_mobile' => array(
                        'type'    => 'select',
                        'label'   => __('Stack on Mobile', 'wsbb'),
                        'default' => 'yes',
                        'options' => array(
                            'yes' => __('Yes', 'wsbb'),
                            'no'  => __('No', 'wsbb'),
                        ),
                        'help' => __('When set to Yes, horizontal menu items stack vertically on mobile.', 'wsbb'),
                    ),
                    'mobile_breakpoint' => array(
                        'type'        => 'unit',
                        'label'       => __('Breakpoint', 'wsbb'),
                        'description' => 'px',
                        'default'     => '768',
                    ),
                ),
            ),
        ),
    ),
    'style' => array(
        'title'    => __('Style', 'wsbb'),
        'sections' => array(
            'menu' => array(
                'title'  => __('Menu', 'wsbb'),
                'fields' => array(
                    'menu_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Menu Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'show_separators' => array(
                        'type'    => 'select',
                        'label'   => __('Show Separators', 'wsbb'),
                        'default' => 'no',
                        'options' => array(
                            'no'  => __('No', 'wsbb'),
                            'yes' => __('Yes', 'wsbb'),
                        ),
                        'toggle' => array(
                            'yes' => array(
                                'fields' => array('separator_color'),
                            ),
                        ),
                    ),
                    'separator_color' => array(
                        'type'       => 'color',
                        'label'      => __('Separator Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                ),
            ),
            'links' => array(
                'title'  => __('Links', 'wsbb'),
                'fields' => array(
                    'link_color' => array(
                        'type'       => 'color',
                        'label'      => __('Link Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
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
                    ),
                    'link_hover_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Link Hover Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'link_active_color' => array(
                        'type'       => 'color',
                        'label'      => __('Active Link Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'link_padding_h' => array(
                        'type'        => 'unit',
                        'label'       => __('Link Horizontal Padding', 'wsbb'),
                        'description' => 'px',
                        'default'     => '14',
                    ),
                    'link_padding_v' => array(
                        'type'        => 'unit',
                        'label'       => __('Link Vertical Padding', 'wsbb'),
                        'description' => 'px',
                        'default'     => '12',
                    ),
                    'item_spacing' => array(
                        'type'        => 'unit',
                        'label'       => __('Item Spacing (Horizontal)', 'wsbb'),
                        'description' => 'px',
                        'default'     => '0',
                    ),
                    'item_spacing_v' => array(
                        'type'        => 'unit',
                        'label'       => __('Item Spacing (Vertical)', 'wsbb'),
                        'description' => 'px',
                        'default'     => '0',
                    ),
                    'menu_padding' => array(
                        'type'        => 'text',
                        'label'       => __('Menu Padding', 'wsbb'),
                        'default'     => '',
                        'help'        => __('CSS padding value e.g. 10px 20px', 'wsbb'),
                    ),
                ),
            ),
            'typography' => array(
                'title'  => __('Typography', 'wsbb'),
                'fields' => array(
                    'menu_font' => array(
                        'type'    => 'font',
                        'label'   => __('Font', 'wsbb'),
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
                            'selector' => '.wsbb-menu-nav a',
                            'property' => 'font-size',
                        ),
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
                    'letter_spacing' => array(
                        'type'        => 'unit',
                        'label'       => __('Letter Spacing', 'wsbb'),
                        'description' => 'px',
                    ),
                ),
            ),
            'dropdown' => array(
                'title'  => __('Dropdowns', 'wsbb'),
                'fields' => array(
                    'dropdown_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Dropdown Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'dropdown_link_color' => array(
                        'type'       => 'color',
                        'label'      => __('Dropdown Link Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'dropdown_link_hover_color' => array(
                        'type'       => 'color',
                        'label'      => __('Dropdown Hover Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'dropdown_link_hover_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Dropdown Hover Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                ),
            ),
            'mobile' => array(
                'title'  => __('Mobile', 'wsbb'),
                'fields' => array(
                    'toggle_color' => array(
                        'type'       => 'color',
                        'label'      => __('Toggle Icon Color', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                    'mobile_menu_bg' => array(
                        'type'       => 'color',
                        'label'      => __('Mobile Menu Background', 'wsbb'),
                        'show_reset' => true,
                        'show_alpha' => true,
                    ),
                ),
            ),
        ),
    ),
));
