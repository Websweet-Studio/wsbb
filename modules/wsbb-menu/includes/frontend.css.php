<?php
// Instance-specific CSS
$breakpoint = ! empty($settings->mobile_breakpoint) ? intval($settings->mobile_breakpoint) : 768;
?>
/* ── Variables ───────────────────────────────────────── */
.fl-node-<?php echo $id; ?> {
<?php if (! empty($settings->link_color)) : ?>
    --wsbb-menu-link: <?php echo FLBuilderColor::hex_or_rgb($settings->link_color); ?>;
<?php endif; ?>
<?php if (! empty($settings->link_hover_color)) : ?>
    --wsbb-menu-link-hover: <?php echo FLBuilderColor::hex_or_rgb($settings->link_hover_color); ?>;
<?php endif; ?>
<?php if (! empty($settings->link_active_color)) : ?>
    --wsbb-menu-link-active: <?php echo FLBuilderColor::hex_or_rgb($settings->link_active_color); ?>;
<?php endif; ?>
<?php if (! empty($settings->menu_bg)) : ?>
    --wsbb-menu-bg: <?php echo FLBuilderColor::hex_or_rgb($settings->menu_bg); ?>;
<?php endif; ?>
<?php if (! empty($settings->dropdown_bg)) : ?>
    --wsbb-menu-dropdown-bg: <?php echo FLBuilderColor::hex_or_rgb($settings->dropdown_bg); ?>;
<?php endif; ?>
<?php if (! empty($settings->dropdown_link_color)) : ?>
    --wsbb-menu-dropdown-link: <?php echo FLBuilderColor::hex_or_rgb($settings->dropdown_link_color); ?>;
<?php endif; ?>
<?php if (! empty($settings->dropdown_link_hover_color)) : ?>
    --wsbb-menu-dropdown-hover: <?php echo FLBuilderColor::hex_or_rgb($settings->dropdown_link_hover_color); ?>;
<?php endif; ?>
<?php if (! empty($settings->hamburger_color)) : ?>
    --wsbb-menu-hamburger: <?php echo FLBuilderColor::hex_or_rgb($settings->hamburger_color); ?>;
<?php endif; ?>
<?php if (! empty($settings->mobile_menu_bg)) : ?>
    --wsbb-menu-mobile-bg: <?php echo FLBuilderColor::hex_or_rgb($settings->mobile_menu_bg); ?>;
<?php endif; ?>
}

/* ── Nav container ───────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-menu-nav {
<?php if (! empty($settings->menu_bg)) : ?>
    background-color: <?php echo FLBuilderColor::hex_or_rgb($settings->menu_bg); ?>;
<?php endif; ?>
<?php if (! empty($settings->menu_padding)) : ?>
    padding: <?php echo esc_attr($settings->menu_padding); ?>;
<?php endif; ?>
}

<?php if (! empty($settings->menu_align)) : ?>
.fl-node-<?php echo $id; ?> .wsbb-menu-nav { text-align: <?php echo esc_attr($settings->menu_align); ?>; }
.fl-node-<?php echo $id; ?> .wsbb-menu-list { justify-content: flex-<?php
    $map = array('left' => 'start', 'center' => 'center', 'right' => 'end');
    echo isset($map[$settings->menu_align]) ? $map[$settings->menu_align] : 'start';
?>; }
<?php endif; ?>

/* ── Links ───────────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-menu-nav a {
<?php if (! empty($settings->link_color)) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb($settings->link_color); ?>;
<?php endif; ?>
<?php if (! empty($settings->font_size)) : ?>
    font-size: <?php echo esc_attr($settings->font_size); ?>px;
<?php endif; ?>
<?php if (! empty($settings->letter_spacing)) : ?>
    letter-spacing: <?php echo esc_attr($settings->letter_spacing); ?>px;
<?php endif; ?>
<?php if (! empty($settings->text_transform)) : ?>
    text-transform: <?php echo esc_attr($settings->text_transform); ?>;
<?php endif; ?>
<?php if (! empty($settings->menu_font) && ! empty($settings->menu_font['family']) && 'Default' !== $settings->menu_font['family']) : ?>
    font-family: <?php echo esc_attr($settings->menu_font['family']); ?>;
<?php endif; ?>
<?php if (! empty($settings->menu_font) && ! empty($settings->menu_font['weight'])) : ?>
    font-weight: <?php echo esc_attr($settings->menu_font['weight']); ?>;
<?php endif; ?>
    text-decoration: none;
    display: inline-block;
<?php if (isset($settings->link_padding_h)) : ?>
    padding-left: <?php echo esc_attr($settings->link_padding_h); ?>px;
    padding-right: <?php echo esc_attr($settings->link_padding_h); ?>px;
<?php endif; ?>
<?php if (isset($settings->link_padding_v)) : ?>
    padding-top: <?php echo esc_attr($settings->link_padding_v); ?>px;
    padding-bottom: <?php echo esc_attr($settings->link_padding_v); ?>px;
<?php endif; ?>
}

.fl-node-<?php echo $id; ?> .wsbb-menu-nav a:hover,
.fl-node-<?php echo $id; ?> .wsbb-menu-nav a:focus {
<?php if (! empty($settings->link_hover_color)) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb($settings->link_hover_color); ?>;
<?php endif; ?>
}

.fl-node-<?php echo $id; ?> .wsbb-menu-nav .current-menu-item > a,
.fl-node-<?php echo $id; ?> .wsbb-menu-nav .current_page_item > a {
<?php if (! empty($settings->link_active_color)) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb($settings->link_active_color); ?>;
<?php endif; ?>
}

<?php if (! empty($settings->font_size_medium)) : ?>
@media (max-width: 992px) {
    .fl-node-<?php echo $id; ?> .wsbb-menu-nav a {
        font-size: <?php echo esc_attr($settings->font_size_medium); ?>px;
    }
}
<?php endif; ?>

<?php if (! empty($settings->font_size_responsive)) : ?>
@media (max-width: 600px) {
    .fl-node-<?php echo $id; ?> .wsbb-menu-nav a {
        font-size: <?php echo esc_attr($settings->font_size_responsive); ?>px;
    }
}
<?php endif; ?>

/* ── Horizontal Item Spacing ──────────────────────────── */
<?php
$h_spacing = isset($settings->item_spacing) ? intval($settings->item_spacing) : 20;
$v_spacing = isset($settings->item_spacing_v) ? intval($settings->item_spacing_v) : 8;
?>
.fl-node-<?php echo $id; ?> .wsbb-menu--horizontal .wsbb-menu-list > li {
    margin-right: <?php echo $h_spacing; ?>px;
}
.fl-node-<?php echo $id; ?> .wsbb-menu--horizontal .wsbb-menu-list > li:last-child {
    margin-right: 0;
}

.fl-node-<?php echo $id; ?> .wsbb-menu--vertical .wsbb-menu-list > li,
.fl-node-<?php echo $id; ?> .wsbb-menu--vertical .wsbb-menu-list > li > a {
    display: block;
    width: 100%;
}
.fl-node-<?php echo $id; ?> .wsbb-menu--vertical .wsbb-menu-list > li {
    margin-bottom: <?php echo $v_spacing; ?>px;
}

/* ── Dropdown ────────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-menu-nav .sub-menu {
<?php if (! empty($settings->dropdown_bg)) : ?>
    background: <?php echo FLBuilderColor::hex_or_rgb($settings->dropdown_bg); ?>;
<?php endif; ?>
}
.fl-node-<?php echo $id; ?> .wsbb-menu-nav .sub-menu a {
<?php if (! empty($settings->dropdown_link_color)) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb($settings->dropdown_link_color); ?>;
<?php endif; ?>
}
.fl-node-<?php echo $id; ?> .wsbb-menu-nav .sub-menu a:hover {
<?php if (! empty($settings->dropdown_link_hover_color)) : ?>
    color: <?php echo FLBuilderColor::hex_or_rgb($settings->dropdown_link_hover_color); ?>;
<?php endif; ?>
}

/* ── Hamburger ───────────────────────────────────────── */
.fl-node-<?php echo $id; ?> .wsbb-menu-toggle {
    display: none;
}
.fl-node-<?php echo $id; ?> .wsbb-menu-toggle-icon span {
<?php if (! empty($settings->hamburger_color)) : ?>
    background: <?php echo FLBuilderColor::hex_or_rgb($settings->hamburger_color); ?>;
<?php endif; ?>
}

/* ── Mobile ──────────────────────────────────────────── */
<?php if ('vertical' !== $settings->menu_layout) : ?>
@media (max-width: <?php echo $breakpoint; ?>px) {
    .fl-node-<?php echo $id; ?> .wsbb-menu-toggle {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px 0;
        font-size: inherit;
        color: inherit;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-toggle-icon {
        display: flex;
        flex-direction: column;
        gap: 4px;
        width: 24px;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-toggle-icon span {
        display: block;
        height: 2px;
        transition: transform 0.2s, opacity 0.2s;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-toggle[aria-expanded="true"] .wsbb-menu-toggle-icon span:nth-child(1) {
        transform: translateY(6px) rotate(45deg);
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-toggle[aria-expanded="true"] .wsbb-menu-toggle-icon span:nth-child(2) {
        opacity: 0;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-toggle[aria-expanded="true"] .wsbb-menu-toggle-icon span:nth-child(3) {
        transform: translateY(-6px) rotate(-45deg);
    }

    .fl-node-<?php echo $id; ?> .wsbb-menu-nav {
        display: none;
<?php if (! empty($settings->mobile_menu_bg)) : ?>
        background: <?php echo FLBuilderColor::hex_or_rgb($settings->mobile_menu_bg); ?>;
<?php endif; ?>
        padding: 12px 0;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-nav.wsbb-menu--open {
        display: block;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-list {
        flex-direction: column;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-list > li {
        margin-right: 0 !important;
        margin-bottom: <?php echo $v_spacing; ?>px;
    }
    .fl-node-<?php echo $id; ?> .wsbb-menu-nav .sub-menu {
        position: static;
        box-shadow: none;
        padding-left: 16px;
    }
}
<?php endif; ?>
