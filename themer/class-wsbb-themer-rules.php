<?php

/**
 * WSBB Themer - Location Matching Engine.
 *
 * @since 1.0
 */
final class Wsbb_Themer_Rules {

	/**
	 * Cache for current page locations.
	 *
	 * @since 1.0
	 * @access private
	 * @var array|null
	 */
	static private $current_page_location = null;

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function init() {
		// No hooks needed for now — all utility methods.
	}

	/**
	 * Returns the location strings for the current page,
	 * ordered from most specific to least specific.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function get_current_page_location() {
		if ( null !== self::$current_page_location ) {
			return self::$current_page_location;
		}

		$locations = array( 'general:site' );

		if ( is_singular() ) {
			$locations[] = 'general:single';
			$locations[] = 'post:' . get_post_type();
			$locations[] = 'post:' . get_post_type() . ':' . get_the_ID();
		} elseif ( is_404() ) {
			$locations[] = 'general:404';
		} elseif ( is_search() ) {
			$locations[] = 'general:search';
		} elseif ( is_archive() || is_home() ) {
			$locations[] = 'general:archive';

			if ( is_category() ) {
				$locations[] = 'taxonomy:category';
				$locations[] = 'taxonomy:category:' . get_queried_object_id();
			} elseif ( is_tag() ) {
				$locations[] = 'taxonomy:post_tag';
				$locations[] = 'taxonomy:post_tag:' . get_queried_object_id();
			} elseif ( is_tax() ) {
				$qo = get_queried_object();
				if ( is_object( $qo ) && isset( $qo->taxonomy ) ) {
					$locations[] = 'taxonomy:' . $qo->taxonomy;
					$locations[] = 'taxonomy:' . $qo->taxonomy . ':' . $qo->term_id;
				}
			} elseif ( is_post_type_archive() ) {
				$post_type = get_query_var( 'post_type' );
				if ( is_array( $post_type ) ) {
					$post_type = reset( $post_type );
				}
				$locations[] = 'archive:' . $post_type;
			} elseif ( is_author() ) {
				$locations[] = 'general:author';
			} elseif ( is_date() ) {
				$locations[] = 'general:date';
			}
		}

		self::$current_page_location = $locations;
		return $locations;
	}

	/**
	 * Get matching published layouts for a given type.
	 *
	 * @since 1.0
	 * @param string $type Layout type: header, footer, singular, archive, 404.
	 * @return array Array of WP_Post objects matched, keyed by post ID.
	 */
	static public function get_matching_layouts( $type ) {
		$current = self::get_current_page_location();

		$posts = get_posts( array(
			'post_type'      => 'wsbb-themer-layout',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_key'       => '_wsbb_layout_type',
			'meta_value'     => $type,
			'no_found_rows'  => true,
			'orderby'        => 'title',
			'order'          => 'ASC',
		) );

		if ( empty( $posts ) ) {
			return array();
		}

		$matched = array();

		foreach ( $posts as $post ) {
			$saved = get_post_meta( $post->ID, '_wsbb_locations', true );

			if ( ! is_array( $saved ) || empty( $saved ) ) {
				continue;
			}

			// Check from most specific to least specific.
			foreach ( $current as $loc ) {
				if ( in_array( $loc, $saved, true ) ) {
					$matched[ $post->ID ] = $post;
					break;
				}
			}
		}

		return $matched;
	}

	/**
	 * Get matching header layout.
	 *
	 * @since 1.0
	 * @return WP_Post|null
	 */
	static public function get_matching_header() {
		$layouts = self::get_matching_layouts( 'header' );
		return ! empty( $layouts ) ? reset( $layouts ) : null;
	}

	/**
	 * Get matching footer layout.
	 *
	 * @since 1.0
	 * @return WP_Post|null
	 */
	static public function get_matching_footer() {
		$layouts = self::get_matching_layouts( 'footer' );
		return ! empty( $layouts ) ? reset( $layouts ) : null;
	}

	/**
	 * Get matching content layout IDs (singular, archive, or 404).
	 *
	 * @since 1.0
	 * @return array Array of layout post IDs.
	 */
	static public function get_current_page_content_ids() {
		if ( is_singular() ) {
			$layouts = self::get_matching_layouts( 'singular' );
		} elseif ( is_archive() || is_home() || is_search() ) {
			$layouts = self::get_matching_layouts( 'archive' );
		} elseif ( is_404() ) {
			$layouts = self::get_matching_layouts( '404' );
		} else {
			$layouts = array();
		}

		return ! empty( $layouts ) ? array_keys( $layouts ) : array();
	}

	/**
	 * Reset cached current page location.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function reset_cache() {
		self::$current_page_location = null;
	}
}

Wsbb_Themer_Rules::init();
