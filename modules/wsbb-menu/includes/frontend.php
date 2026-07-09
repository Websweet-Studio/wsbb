<?php
if (empty($settings->menu_select)) {
    return;
}

$menu_class  = 'wsbb-menu-nav';
$menu_class .= ' wsbb-menu--' . esc_attr($settings->menu_layout);

$breakpoint = ! empty($settings->mobile_breakpoint) ? intval($settings->mobile_breakpoint) : 768;
$menu_id    = 'wsbb-menu-' . $id;

// Build args for wp_nav_menu
$args = array(
    'menu'            => $settings->menu_select,
    'container'       => 'nav',
    'container_class' => $menu_class,
    'container_id'    => $menu_id,
    'menu_class'      => 'wsbb-menu-list',
    'depth'           => 3,
    'fallback_cb'     => false,
    'echo'            => false,
);

$menu_markup = wp_nav_menu($args);

if (empty($menu_markup)) {
    return;
}

$needs_hamburger = in_array($settings->menu_layout, array('horizontal', 'hamburger'));
?>
<div class="wsbb-menu-wrap">
    <?php if ($needs_hamburger) : ?>
    <button class="wsbb-menu-toggle" aria-expanded="false" aria-controls="<?php echo esc_attr($menu_id); ?>">
        <span class="wsbb-menu-toggle-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
        <span class="wsbb-menu-toggle-label"><?php esc_html_e('Menu', 'wsbb'); ?></span>
    </button>
    <?php endif; ?>

    <?php echo $menu_markup; ?>
</div>
