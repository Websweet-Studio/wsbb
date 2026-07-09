<?php

/**
 * WSBB Themer - CPT & Meta Registration.
 *
 * @since 1.0
 */
final class Wsbb_Themer_Cpt {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		add_action( 'init', __CLASS__ . '::register_post_type' );
		add_filter( 'fl_builder_post_types', __CLASS__ . '::enable_builder' );
	}

	/**
	 * Register the themer layout post type.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function register_post_type() {
		register_post_type( 'wsbb-themer-layout', apply_filters( 'wsbb_themer_layout_post_type_args', array(
			'labels'              => array(
				'name'               => _x( 'WSBB Themer Layouts', 'Custom post type label.', 'wsbb' ),
				'singular_name'      => _x( 'Themer Layout', 'Custom post type label.', 'wsbb' ),
				'menu_name'          => _x( 'WSBB Themer', 'Custom post type label.', 'wsbb' ),
				'name_admin_bar'     => _x( 'Themer Layout', 'Custom post type label.', 'wsbb' ),
				'add_new'            => _x( 'Add New', 'Custom post type label.', 'wsbb' ),
				'add_new_item'       => _x( 'Add New Themer Layout', 'Custom post type label.', 'wsbb' ),
				'new_item'           => _x( 'New Themer Layout', 'Custom post type label.', 'wsbb' ),
				'edit_item'          => _x( 'Edit Themer Layout', 'Custom post type label.', 'wsbb' ),
				'view_item'          => _x( 'View Themer Layout', 'Custom post type label.', 'wsbb' ),
				'all_items'          => _x( 'All Themer Layouts', 'Custom post type label.', 'wsbb' ),
				'search_items'       => _x( 'Search Themer Layouts', 'Custom post type label.', 'wsbb' ),
				'not_found'          => _x( 'No themer layouts found.', 'Custom post type label.', 'wsbb' ),
				'not_found_in_trash' => _x( 'No themer layouts found in Trash.', 'Custom post type label.', 'wsbb' ),
			),
			'supports'            => array(
				'title',
				'revisions',
			),
			'menu_icon'           => 'dashicons-welcome-widgets-menus',
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'capabilities'        => array(
				'edit_post'          => 'edit_posts',
				'read_post'          => 'read_posts',
				'delete_post'        => 'delete_posts',
				'edit_posts'         => 'edit_posts',
				'edit_others_posts'  => 'edit_others_posts',
				'publish_posts'      => 'publish_posts',
				'read_private_posts' => 'read_private_posts',
			),
			'map_meta_cap'        => true,
		) ) );

		// Register post meta for layout type.
		register_post_meta( 'wsbb-themer-layout', '_wsbb_layout_type', array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => '__return_true',
		) );

		// Register post meta for location rules.
		register_post_meta( 'wsbb-themer-layout', '_wsbb_locations', array(
			'show_in_rest'  => false,
			'single'        => true,
			'type'          => 'array',
			'auth_callback' => '__return_true',
			'default'       => array(),
		) );
	}

	/**
	 * Enable the builder for the themer layout post type.
	 *
	 * @since 1.0
	 * @param array $post_types
	 * @return array
	 */
	static public function enable_builder( $post_types ) {
		$post_types[] = 'wsbb-themer-layout';
		return $post_types;
	}
}

Wsbb_Themer_Cpt::init();
