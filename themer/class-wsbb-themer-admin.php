<?php

/**
 * WSBB Themer - Admin Interface.
 *
 * @since 1.0
 */
final class Wsbb_Themer_Admin
{

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init()
	{
		add_action('admin_menu', __CLASS__ . '::add_admin_menu');
		add_action('add_meta_boxes', __CLASS__ . '::add_meta_boxes');
		add_action('save_post', __CLASS__ . '::save_meta_boxes');
		add_filter('manage_wsbb-themer-layout_posts_columns', __CLASS__ . '::manage_column_headings');
		add_action('manage_wsbb-themer-layout_posts_custom_column', __CLASS__ . '::manage_column_content', 10, 2);
	}

	/**
	 * Add admin menu page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function add_admin_menu()
	{
		add_menu_page(
			__('WSBB Themer', 'wsbb'),
			__('WSBB Themer', 'wsbb'),
			'edit_posts',
			'edit.php?post_type=wsbb-themer-layout',
			'',
			'dashicons-welcome-widgets-menus',
			30
		);
	}

	/**
	 * Add meta boxes to the themer layout edit screen.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function add_meta_boxes()
	{
		add_meta_box(
			'wsbb-themer-layout-type',
			__('Layout Type', 'wsbb'),
			__CLASS__ . '::render_layout_type_meta_box',
			'wsbb-themer-layout',
			'normal',
			'high'
		);

		add_meta_box(
			'wsbb-themer-location-rules',
			__('Location Rules', 'wsbb'),
			__CLASS__ . '::render_location_rules_meta_box',
			'wsbb-themer-layout',
			'normal',
			'high'
		);
	}

	/**
	 * Render the layout type meta box.
	 *
	 * @since 1.0
	 * @param WP_Post $post
	 * @return void
	 */
	static public function render_layout_type_meta_box($post)
	{
		wp_nonce_field('wsbb_themer_save', 'wsbb_themer_nonce');

		$type = get_post_meta($post->ID, '_wsbb_layout_type', true);
		$types = array(
			'header'    => __('Header', 'wsbb'),
			'footer'    => __('Footer', 'wsbb'),
			'singular'  => __('Singular', 'wsbb'),
			'archive'   => __('Archive', 'wsbb'),
			'404'       => __('404 Page', 'wsbb'),
		);
?>
		<select name="wsbb_layout_type" style="width:100%;max-width:300px;">
			<option value=""><?php esc_html_e('Select Type...', 'wsbb'); ?></option>
			<?php foreach ($types as $value => $label) : ?>
				<option value="<?php echo esc_attr($value); ?>" <?php selected($type, $value); ?>>
					<?php echo esc_html($label); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p class="description">
			<?php esc_html_e('Select what kind of layout this is. Headers and footers replace the theme header/footer. Singular overrides single posts/pages. Archive overrides archive pages.', 'wsbb'); ?>
		</p>
<?php
	}

	/**
	 * Render the location rules meta box.
	 *
	 * @since 1.0
	 * @param WP_Post $post
	 * @return void
	 */
	static public function render_location_rules_meta_box($post)
	{
		$locations       = self::get_all_locations();
		$saved_locations = get_post_meta($post->ID, '_wsbb_locations', true);

		if (! is_array($saved_locations)) {
			$saved_locations = array();
		}

		include WSBB_THEMER_DIR . 'admin-edit-location-rules.php';
	}

	/**
	 * Save meta box data.
	 *
	 * @since 1.0
	 * @param int $post_id
	 * @return void
	 */
	static public function save_meta_boxes($post_id)
	{
		if (! isset($_POST['wsbb_themer_nonce'])) {
			return;
		}
		if (! wp_verify_nonce($_POST['wsbb_themer_nonce'], 'wsbb_themer_save')) {
			return;
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		if ('wsbb-themer-layout' !== get_post_type($post_id)) {
			return;
		}
		if (! current_user_can('edit_post', $post_id)) {
			return;
		}

		// Save layout type.
		if (isset($_POST['wsbb_layout_type'])) {
			$type = sanitize_text_field($_POST['wsbb_layout_type']);
			if (in_array($type, array('header', 'footer', 'singular', 'archive', '404'), true)) {
				update_post_meta($post_id, '_wsbb_layout_type', $type);
			} else {
				delete_post_meta($post_id, '_wsbb_layout_type');
			}
		}

		// Save locations.
		if (isset($_POST['wsbb_locations']) && is_array($_POST['wsbb_locations'])) {
			$locations = array_map('sanitize_text_field', wp_unslash($_POST['wsbb_locations']));
			$locations = array_filter($locations);
			$locations = array_values(array_unique($locations));
			update_post_meta($post_id, '_wsbb_locations', $locations);
		} else {
			update_post_meta($post_id, '_wsbb_locations', array());
		}
	}

	/**
	 * Add custom columns to the list table.
	 *
	 * @since 1.0
	 * @param array $columns
	 * @return array
	 */
	static public function manage_column_headings($columns)
	{
		$new_columns = array();

		foreach ($columns as $key => $label) {
			if ('title' === $key) {
				$new_columns[$key] = $label;
				$new_columns['wsbb_type'] = __('Type', 'wsbb');
				$new_columns['wsbb_location'] = __('Location', 'wsbb');
			} else {
				$new_columns[$key] = $label;
			}
		}

		return $new_columns;
	}

	/**
	 * Render custom column content.
	 *
	 * @since 1.0
	 * @param string $column
	 * @param int    $post_id
	 * @return void
	 */
	static public function manage_column_content($column, $post_id)
	{
		if ('wsbb_type' === $column) {
			$type = get_post_meta($post_id, '_wsbb_layout_type', true);
			if ($type) {
				echo esc_html(ucwords($type));
			} else {
				echo '<em>' . esc_html__('None', 'wsbb') . '</em>';
			}
		}

		if ('wsbb_location' === $column) {
			$locations = get_post_meta($post_id, '_wsbb_locations', true);
			if (is_array($locations) && ! empty($locations)) {
				$labels = self::get_location_labels();
				foreach ($locations as $loc) {
					$label = isset($labels[$loc]) ? $labels[$loc] : $loc;
					echo esc_html($label) . '<br />';
				}
			} else {
				echo '<em>' . esc_html__('None', 'wsbb') . '</em>';
			}
		}
	}

	/**
	 * Get all available location options for the admin UI.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_all_locations()
	{
		$locations = array(
			'general' => array(
				'label'     => __('General', 'wsbb'),
				'locations' => array(
					array(
						'value'       => 'general:site',
						'label'       => __('Entire Site', 'wsbb'),
						'type'        => 'general',
						'hasObjects'  => false,
					),
					array(
						'value'       => 'general:single',
						'label'       => __('All Singular', 'wsbb'),
						'type'        => 'general',
						'hasObjects'  => false,
					),
					array(
						'value'       => 'general:archive',
						'label'       => __('All Archives', 'wsbb'),
						'type'        => 'general',
						'hasObjects'  => false,
					),
					array(
						'value'       => 'general:author',
						'label'       => __('Author Archives', 'wsbb'),
						'type'        => 'general',
						'hasObjects'  => false,
					),
					array(
						'value'       => 'general:search',
						'label'       => __('Search Results', 'wsbb'),
						'type'        => 'general',
						'hasObjects'  => false,
					),
					array(
						'value'       => 'general:404',
						'label'       => __('404 Page', 'wsbb'),
						'type'        => 'general',
						'hasObjects'  => false,
					),
				),
				'objects'   => array(),
			),
		);

		// Add post types.
		$post_types = get_post_types(array('public' => true), 'objects');
		foreach ($post_types as $slug => $pt) {
			if (in_array($slug, array('fl-builder-template', 'wsbb-themer-layout', 'attachment'), true)) {
				continue;
			}

			$post_type_key = 'post_types_' . $slug;
			$locations[$post_type_key] = array(
				'label'     => $pt->labels->name,
				'locations' => array(
					array(
						'value'       => 'post:' . $slug,
						'label'       => sprintf(__('All %s', 'wsbb'), $pt->labels->singular_name),
						'type'        => 'post',
						'hasObjects'  => true,
					),
				),
				'objects'   => array(),
			);

			// Add specific posts as objects.
			$posts = get_posts(array(
				'post_type'      => $slug,
				'posts_per_page' => 100,
				'post_status'    => 'publish',
				'no_found_rows'  => true,
				'orderby'        => 'title',
				'order'          => 'ASC',
			));

			if (! empty($posts)) {
				$location_key = 'post:' . $slug;
				$locations[$post_type_key]['objects'][$location_key] = array();
				foreach ($posts as $p) {
					$locations[$post_type_key]['objects'][$location_key][] = array(
						'value' => $p->ID,
						'label' => $p->post_title ? $p->post_title : '#' . $p->ID,
					);
				}
			}

			// Add archive option if post type supports archives.
			if ('post' === $slug || $pt->has_archive) {
				$archive_key = 'archives_' . $slug;
				$locations[$archive_key] = array(
					'label'     => sprintf(__('%s Archives', 'wsbb'), $pt->labels->singular_name),
					'locations' => array(
						array(
							'value'       => 'archive:' . $slug,
							'label'       => sprintf(__('%s Archive', 'wsbb'), $pt->labels->singular_name),
							'type'        => 'archive',
							'hasObjects'  => false,
						),
					),
					'objects'   => array(),
				);
			}

			// Add taxonomies.
			$taxonomies = get_object_taxonomies($slug, 'objects');
			foreach ($taxonomies as $tax_slug => $tax) {
				if (! $tax->public || 'post_format' === $tax_slug) {
					continue;
				}

				$tax_key = 'tax_' . $slug . '_' . $tax_slug;
				$locations[$tax_key] = array(
					'label'     => sprintf('%s %s', $pt->labels->singular_name, $tax->labels->singular_name),
					'locations' => array(
						array(
							'value'       => 'taxonomy:' . $tax_slug,
							'label'       => sprintf(__('%s by %s', 'wsbb'), $pt->labels->singular_name, $tax->labels->singular_name),
							'type'        => 'taxonomy',
							'hasObjects'  => true,
						),
					),
					'objects'   => array(),
				);

				// Add specific terms as objects.
				$terms = get_terms(array(
					'taxonomy'   => $tax_slug,
					'hide_empty' => false,
					'number'     => 100,
				));

				if (! empty($terms) && ! is_wp_error($terms)) {
					$location_key = 'taxonomy:' . $tax_slug;
					$locations[$tax_key]['objects'][$location_key] = array();
					foreach ($terms as $term) {
						$locations[$tax_key]['objects'][$location_key][] = array(
							'value' => $term->term_id,
							'label' => $term->name,
						);
					}
				}
			}
		}

		return $locations;
	}

	/**
	 * Get human-readable labels for all location strings.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_location_labels()
	{
		$labels = array(
			'general:site'    => __('Entire Site', 'wsbb'),
			'general:single'  => __('All Singular', 'wsbb'),
			'general:archive' => __('All Archives', 'wsbb'),
			'general:author'  => __('Author Archives', 'wsbb'),
			'general:search'  => __('Search Results', 'wsbb'),
			'general:404'     => __('404 Page', 'wsbb'),
			'general:date'    => __('Date Archives', 'wsbb'),
		);

		// Add post type labels.
		$post_types = get_post_types(array('public' => true), 'objects');
		foreach ($post_types as $slug => $pt) {
			if (in_array($slug, array('fl-builder-template', 'wsbb-themer-layout', 'attachment'), true)) {
				continue;
			}
			$labels['post:' . $slug] = sprintf(__('All %s', 'wsbb'), $pt->labels->singular_name);
			$labels['archive:' . $slug] = sprintf(__('%s Archive', 'wsbb'), $pt->labels->singular_name);
		}

		// Add taxonomy labels.
		$taxonomies = get_taxonomies(array('public' => true), 'objects');
		foreach ($taxonomies as $slug => $tax) {
			$labels['taxonomy:' . $slug] = sprintf(__('%s Archive', 'wsbb'), $tax->labels->singular_name);
		}

		return $labels;
	}
}

Wsbb_Themer_Admin::init();
