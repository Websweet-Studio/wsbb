<?php

/**
 * WSBB Themer - Frontend Rendering.
 *
 * @since 1.0
 */
final class Wsbb_Themer_Renderer
{

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init()
	{
		add_action('wp', __CLASS__ . '::setup_header_footer');
		add_filter('template_include', __CLASS__ . '::override_template_include', 999);
		add_filter('body_class', __CLASS__ . '::body_class');
	}

	/**
	 * Check if current page is a themer layout (being edited or previewed).
	 *
	 * @since 1.0
	 * @return bool
	 */
	static private function is_editing_layout()
	{
		return 'wsbb-themer-layout' === get_post_type();
	}

	/**
	 * Setup header and footer hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function setup_header_footer()
	{
		// Don't apply themer on the layout's own page (prevents self-replacement).
		if (self::is_editing_layout()) {
			return;
		}

		$header = Wsbb_Themer_Rules::get_matching_header();
		$footer = Wsbb_Themer_Rules::get_matching_footer();

		// Handle header replacement.
		if (! is_null($header)) {
			if (defined('FL_THEME_VERSION')) {
				// BB Theme support.
				add_filter('fl_header_enabled', '__return_false');
				add_action('fl_before_header', __CLASS__ . '::render_header', 999);
			} else {
				// Generic theme support — hook into get_header.
				add_action('get_header', __CLASS__ . '::render_header');
			}
		}

		// Handle footer replacement.
		if (! is_null($footer)) {
			if (defined('FL_THEME_VERSION')) {
				// BB Theme support.
				add_filter('fl_footer_enabled', '__return_false');
				add_action('fl_after_content', __CLASS__ . '::render_footer', 11);
			} else {
				// Generic theme support.
				add_action('get_footer', __CLASS__ . '::render_footer');
			}
		}
	}

	/**
	 * Override template_include for themer layouts.
	 *
	 * @since 1.0
	 * @param string $template
	 * @return string
	 */
	static public function override_template_include($template)
	{
		// When editing a header/footer layout, use custom editor template.
		if (self::is_editing_layout()) {
			$type = get_post_meta(get_the_ID(), '_wsbb_layout_type', true);
			if ('header' === $type) {
				return WSBB_THEMER_DIR . 'template-header.php';
			}
			if ('footer' === $type) {
				return WSBB_THEMER_DIR . 'template-footer.php';
			}
			// Singular/archive/404: let theme render normally for context preview.
			return $template;
		}

		$ids = Wsbb_Themer_Rules::get_current_page_content_ids();
		if (empty($ids) || is_embed()) {
			return $template;
		}

		return WSBB_THEMER_DIR . 'content.php';
	}

	/**
	 * Render header layout.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_header()
	{
		$header = Wsbb_Themer_Rules::get_matching_header();

		if (is_null($header)) {
			return;
		}

		// Prevent infinite loop if get_header is called within a header layout.
		remove_action('get_header', __CLASS__ . '::render_header');

		$attrs = array(
			'data-type' => 'header',
			'role'      => 'banner',
		);

		FLBuilder::render_content_by_id($header->ID, 'header', $attrs);
	}

	/**
	 * Render footer layout.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_footer()
	{
		$footer = Wsbb_Themer_Rules::get_matching_footer();

		if (is_null($footer)) {
			return;
		}

		// Prevent infinite loop if get_footer is called within a footer layout.
		remove_action('get_footer', __CLASS__ . '::render_footer');

		$attrs = array(
			'data-type' => 'footer',
		);

		FLBuilder::render_content_by_id($footer->ID, 'footer', $attrs);
	}

	/**
	 * Render content layout.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_content()
	{
		$ids = Wsbb_Themer_Rules::get_current_page_content_ids();

		if (empty($ids)) {
			return;
		}

		$layout_id = $ids[0];

		do_action('wsbb_themer_before_render_content', $layout_id);

		FLBuilder::render_content_by_id($layout_id, 'div', array(
			'data-type' => 'content',
		));

		do_action('wsbb_themer_after_render_content', $layout_id);
	}

	/**
	 * Add body classes for active themer layouts.
	 *
	 * @since 1.0
	 * @param array $classes
	 * @return array
	 */
	static public function body_class($classes)
	{
		// Don't add themer body classes on layout edit/preview pages.
		if (self::is_editing_layout()) {
			return $classes;
		}

		$header = Wsbb_Themer_Rules::get_matching_header();
		$footer = Wsbb_Themer_Rules::get_matching_footer();
		$ids    = Wsbb_Themer_Rules::get_current_page_content_ids();

		if ($header || $footer || ! empty($ids)) {
			$classes[] = 'wsbb-themer-active';
		}
		if ($header) {
			$classes[] = 'wsbb-layout-header';
		}
		if ($footer) {
			$classes[] = 'wsbb-layout-footer';
		}
		if (! empty($ids)) {
			$classes[] = 'wsbb-layout-content';
		}

		return $classes;
	}
}

Wsbb_Themer_Renderer::init();
