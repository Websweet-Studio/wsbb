<?php
if (empty($settings->menu_select)) {
    return;
}

$layout       = $settings->menu_layout;
$menu_name    = ! empty($settings->menu_name) ? $settings->menu_name : __('Menu', 'wsbb');
$toggle       = ! empty($settings->responsive_toggle) ? $settings->responsive_toggle : 'hamburger';
$has_toggle   = 'none' !== $toggle;
$submenu_icon = ! empty($settings->submenu_icon) ? $settings->submenu_icon : 'arrow';
$wrap_class   = 'wsbb-menu-wrap';
$menu_id      = 'wsbb-menu-' . $id;

// Wrapper classes
$wrap_class .= ' wsbb-menu-' . $layout;
if ('hamburger' === $layout) {
    $wrap_class .= ' wsbb-menu-hamburger-always';
}
if ('accordion' === $layout) {
    $wrap_class .= ' wsbb-menu-accordion';
    $has_toggle = false;
}

// Build menu class for wp_nav_menu
$nav_class  = 'wsbb-menu-nav wsbb-menu--' . esc_attr($layout);
$menu_class = 'wsbb-menu-list';

// Submenu icon class
$icon_menu_class = '';
if ('none' !== $submenu_icon && 'expanded' !== $layout) {
    $icon_menu_class = ' wsbb-submenu-icon-' . $submenu_icon;
}
$menu_class .= $icon_menu_class;

// Separator class
$show_sep = ! empty($settings->show_separators) && 'yes' === $settings->show_separators;
if ($show_sep) {
    $menu_class .= ' wsbb-has-separators';
}

$args = array(
    'menu'            => $settings->menu_select,
    'container'       => false,
    'menu_class'      => $menu_class,
    'menu_id'         => $menu_id . '-list',
    'depth'           => 3,
    'fallback_cb'     => false,
    'echo'            => false,
    'walker'          => new Wsbb_Menu_Walker(),
);

$menu_markup = wp_nav_menu($args);

if (empty($menu_markup)) {
    return;
}

?>
<div class="<?php echo esc_attr($wrap_class); ?>">
    <?php if ($has_toggle) : ?>
        <?php
        $btn_class = 'wsbb-menu-toggle';
        if ('menu_button' === $toggle) {
            $btn_class .= ' wsbb-menu-toggle--button';
        } elseif ('hamburger_label' === $toggle) {
            $btn_class .= ' wsbb-menu-toggle--label';
        } else {
            $btn_class .= ' wsbb-menu-toggle--icon';
        }
        ?>
        <button class="<?php echo esc_attr($btn_class); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr($menu_id); ?>">
            <?php if ('menu_button' !== $toggle) : ?>
                <span class="wsbb-menu-toggle-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            <?php endif; ?>
            <?php if ('hamburger' !== $toggle) : ?>
                <span class="wsbb-menu-toggle-label"><?php echo esc_html($menu_name); ?></span>
            <?php endif; ?>
        </button>
    <?php endif; ?>

    <nav class="<?php echo esc_attr($nav_class); ?>" id="<?php echo esc_attr($menu_id); ?>" aria-label="<?php echo esc_attr($menu_name); ?>" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
        <?php echo $menu_markup; ?>
    </nav>
</div>