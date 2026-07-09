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
	 * Render WSBB main admin page.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function render_main_page()
	{
		$all_layouts = get_posts(array(
			'post_type'      => 'wsbb-themer-layout',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'no_found_rows'  => true,
			'orderby'        => 'date',
			'order'          => 'DESC',
		));

		$counts = array(
			'total'    => count($all_layouts),
			'header'   => 0,
			'footer'   => 0,
			'singular' => 0,
			'archive'  => 0,
			'404'      => 0,
		);

		foreach ($all_layouts as $layout) {
			$type = get_post_meta($layout->ID, '_wsbb_layout_type', true);
			if (isset($counts[$type])) {
				$counts[$type]++;
			}
		}

		$recent     = array_slice($all_layouts, 0, 5);
		$bb_version = defined('FL_BUILDER_VERSION') ? FL_BUILDER_VERSION : '-';
		$bb_type    = defined('FL_BUILDER_LITE') && FL_BUILDER_LITE ? 'Lite' : 'Pro';
		$labels     = self::get_location_labels();

		$module_count = 0;
		$module_dir   = WP_PLUGIN_DIR . '/wsbb/modules/';
		if (is_dir($module_dir)) {
			$module_count = count(glob($module_dir . 'wsbb-*', GLOB_ONLYDIR));
		}

		// Pinterest-style CSS
		$css = '
.wsbb-stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:32px}
.wsbb-stat-card{background:#fff;border-radius:16px;padding:24px;display:flex;align-items:center;gap:16px}
.wsbb-stat-icon{width:48px;height:48px;border-radius:9999px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.wsbb-stat-icon .dashicons{font-size:22px;width:22px;height:22px}
.wsbb-stat-icon--total{background:#f6f6f3;color:#000}
.wsbb-stat-icon--header{background:#ffe6e8;color:#cc001f}
.wsbb-stat-icon--footer{background:#f6f6f3;color:#62625b}
.wsbb-stat-icon--singular{background:#f6f6f3;color:#211922}
.wsbb-stat-icon--archive{background:#f6f6f3;color:#33332e}
.wsbb-stat-icon--404{background:#ffe6e8;color:#9e0a0a}
.wsbb-stat-num{font-size:28px;font-weight:700;line-height:1.2;color:#000}
.wsbb-stat-label{font-size:14px;font-weight:600;color:#62625b}
.wsbb-sec-title{font-size:18px;font-weight:600;line-height:1.3;color:#000;margin:0 0 16px}
.wsbb-actions{display:flex;gap:8px;margin-bottom:32px}
.wsbb-btn{display:inline-flex;align-items:center;justify-content:center;height:40px;padding:0 20px;border-radius:16px;font-size:14px;font-weight:700;line-height:1;text-decoration:none;border:none;cursor:pointer;transition:background .15s;box-sizing:border-box}
.wsbb-btn-primary{background:#e60023;color:#fff}
.wsbb-btn-primary:hover,.wsbb-btn-primary:focus{background:#cc001f;color:#fff}
.wsbb-btn-secondary{background:#e5e5e0;color:#000}
.wsbb-btn-secondary:hover,.wsbb-btn-secondary:focus{background:#c8c8c1;color:#000}
.wsbb-table-wrap{background:#fff;border-radius:16px;overflow:hidden;margin-bottom:32px}
.wsbb-table{width:100%;border-collapse:collapse}
.wsbb-table th{font-size:14px;font-weight:700;color:#000;text-align:left;padding:12px 20px;border-bottom:1px solid #dadad3}
.wsbb-table td{font-size:16px;color:#33332e;padding:14px 20px;border-bottom:1px solid #e5e5e0}
.wsbb-table tr:last-child td{border-bottom:none}
.wsbb-table a{color:#211922;font-weight:600;text-decoration:none}
.wsbb-table a:hover{color:#e60023}
.wsbb-badge{display:inline-block;padding:4px 12px;border-radius:9999px;font-size:12px;font-weight:700;white-space:nowrap}
.wsbb-badge-header{background:#f6f6f3;color:#000}
.wsbb-badge-footer{background:#f6f6f3;color:#62625b}
.wsbb-badge-singular{background:#f6f6f3;color:#211922}
.wsbb-badge-archive{background:#f6f6f3;color:#33332e}
.wsbb-badge-404{background:#ffe6e8;color:#9e0a0a}
.wsbb-info-list{background:#fff;border-radius:16px;padding:4px 0;max-width:560px;margin-bottom:32px}
.wsbb-info-item{display:flex;padding:12px 24px;border-bottom:1px solid #e5e5e0}
.wsbb-info-item:last-child{border-bottom:none}
.wsbb-info-label{width:180px;font-size:14px;font-weight:600;color:#000;flex-shrink:0}
.wsbb-info-value{font-size:14px;color:#33332e}
.wsbb-empty{background:#fff;border-radius:16px;padding:48px 24px;text-align:center;color:#62625b;font-size:16px;margin-bottom:32px}
@media(max-width:1200px){.wsbb-stats-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:782px){.wsbb-stats-grid{grid-template-columns:1fr}}
';
		echo '<style>' . $css . '</style>';

		echo '<div class="wrap">';
		echo '<div class="wsbb-header" style="margin-bottom:32px">';
		echo '<h1 style="font-size:28px;font-weight:700;line-height:1.2;color:#000;margin:0 0 4px">WSBB Dashboard</h1>';
		echo '<p style="font-size:16px;color:#62625b;margin:0">' . esc_html__('Beaver Builder Themer Layouts', 'wsbb') . '</p>';
		echo '</div>';

		// Stats cards
		$card_types = array(
			'total'    => array('dashicons-admin-site',     'wsbb-stat-icon--total',    __('Total Layouts', 'wsbb')),
			'header'   => array('dashicons-arrow-up-alt',   'wsbb-stat-icon--header',   __('Header', 'wsbb')),
			'footer'   => array('dashicons-arrow-down-alt', 'wsbb-stat-icon--footer',   __('Footer', 'wsbb')),
			'singular' => array('dashicons-admin-post',     'wsbb-stat-icon--singular', __('Singular', 'wsbb')),
			'archive'  => array('dashicons-category',       'wsbb-stat-icon--archive',  __('Archive', 'wsbb')),
			'404'      => array('dashicons-warning',        'wsbb-stat-icon--404',      __('404 Page', 'wsbb')),
		);

		echo '<div class="wsbb-stats-grid">';
		foreach ($card_types as $type_key => $card) {
			echo '<div class="wsbb-stat-card">';
			echo '<div class="wsbb-stat-icon ' . esc_attr($card[1]) . '"><span class="dashicons ' . esc_attr($card[0]) . '"></span></div>';
			echo '<div>';
			echo '<div class="wsbb-stat-num">' . (int) $counts[$type_key] . '</div>';
			echo '<div class="wsbb-stat-label">' . esc_html($card[2]) . '</div>';
			echo '</div>';
			echo '</div>';
		}
		echo '</div>';

		// Quick actions
		$new_url = admin_url('post-new.php?post_type=wsbb-themer-layout');
		$all_url = admin_url('edit.php?post_type=wsbb-themer-layout');
		echo '<div class="wsbb-actions">';
		echo '<a href="' . esc_url($new_url) . '" class="wsbb-btn wsbb-btn-primary">' . esc_html__('Add New Layout', 'wsbb') . '</a>';
		echo '<a href="' . esc_url($all_url) . '" class="wsbb-btn wsbb-btn-secondary">' . esc_html__('View All Layouts', 'wsbb') . '</a>';
		echo '</div>';

		// Recent layouts
		echo '<h2 class="wsbb-sec-title">' . esc_html__('Recent Layouts', 'wsbb') . '</h2>';
		if (empty($recent)) {
			echo '<div class="wsbb-empty">' . esc_html__('No layouts yet. Create your first one!', 'wsbb') . '</div>';
		} else {
			echo '<div class="wsbb-table-wrap"><table class="wsbb-table">';
			echo '<thead><tr>';
			echo '<th>' . esc_html__('Title', 'wsbb') . '</th>';
			echo '<th>' . esc_html__('Type', 'wsbb') . '</th>';
			echo '<th>' . esc_html__('Locations', 'wsbb') . '</th>';
			echo '<th>' . esc_html__('Date', 'wsbb') . '</th>';
			echo '</tr></thead><tbody>';

			foreach ($recent as $layout) {
				$type      = get_post_meta($layout->ID, '_wsbb_layout_type', true);
				$locations = get_post_meta($layout->ID, '_wsbb_locations', true);
				$edit_link = get_edit_post_link($layout->ID);

				$loc_labels = array();
				if (is_array($locations)) {
					foreach ($locations as $loc) {
						$loc_labels[] = isset($labels[$loc]) ? $labels[$loc] : $loc;
					}
				}

				echo '<tr>';
				echo '<td><a href="' . esc_url($edit_link) . '">' . esc_html($layout->post_title) . '</a></td>';
				echo '<td><span class="wsbb-badge wsbb-badge-' . esc_attr($type) . '">' . esc_html(ucfirst($type ?: '-')) . '</span></td>';
				echo '<td>' . esc_html(implode(', ', $loc_labels) ?: '-') . '</td>';
				echo '<td>' . esc_html(get_the_date('Y-m-d', $layout)) . '</td>';
				echo '</tr>';
			}
			echo '</tbody></table></div>';
		}

		// System info
		echo '<h2 class="wsbb-sec-title">' . esc_html__('System Info', 'wsbb') . '</h2>';
		echo '<div class="wsbb-info-list">';
		echo '<div class="wsbb-info-item"><span class="wsbb-info-label">WSBB Version</span><span class="wsbb-info-value">' . esc_html(WSBB_VERSION) . '</span></div>';
		echo '<div class="wsbb-info-item"><span class="wsbb-info-label">Beaver Builder</span><span class="wsbb-info-value">' . esc_html($bb_type . ' ' . $bb_version) . '</span></div>';
		echo '<div class="wsbb-info-item"><span class="wsbb-info-label">' . esc_html__('Modules Loaded', 'wsbb') . '</span><span class="wsbb-info-value">' . (int) $module_count . '</span></div>';
		echo '<div class="wsbb-info-item"><span class="wsbb-info-label">Themer CPT</span><span class="wsbb-info-value">' . (post_type_exists('wsbb-themer-layout') ? esc_html__('Registered', 'wsbb') : esc_html__('Not registered', 'wsbb')) . '</span></div>';
		echo '</div>';

		echo '</div>';
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
			'WSBB',
			'WSBB',
			'read',
			'wsbb-menu',
			__CLASS__ . '::render_main_page',
			'dashicons-admin-generic',
			30
		);

		add_submenu_page(
			'wsbb-menu',
			__('WSBB Themer', 'wsbb'),
			__('WSBB Themer', 'wsbb'),
			'read',
			'edit.php?post_type=wsbb-themer-layout',
			''
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
