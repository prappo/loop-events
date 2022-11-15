<?php

namespace Loop;

class Export extends Base {

	use BaseTrait;

	public function init() {
		add_action( 'init', array( $this, 'export_url' ) );
	}

	public function export_url() {
		if ( isset( $_GET['export'] ) && 1 == $_GET['export'] ) {
			echo self::download();
			exit;
		}
	}

	public static function download() {
		$post_data = array();

		$posts = get_posts(
			array(
				'post_type'      => LOOP_CPT_SLUG,
				'orderby'        => 'meta_value_num',
				'meta_key'       => 'loop_events_date_and_time',
				'order'          => 'ASC',
				'posts_per_page' => -1,
				'post_status'    => 'any',
			)
		);

		foreach ( $posts as $post ) {
			$post_data[] = self::parse_data( $post );
		}

		return wp_json_encode( $post_data );
	}

	private static function parse_data( $post_data ) {
		$parsed_data = array(
			'id'        => $post_data->ID,
			'title'     => $post_data->post_title,
			'about'     => $post_data->post_content,
			'organizer' => loop_events_get_field( 'loop_events_organizer_name', null, $post_data->ID ),
			'timestamp' => loop_events_get_field( 'loop_events_date_and_time', null, $post_data->ID ),
			'isActive'  => in_array( $post_data->post_status, array( 'publish' ), true ),
			'email'     => loop_events_get_field( 'loop_events_organizer_email', null, $post_data->ID ),
			'address'   => loop_events_get_field( 'loop_events_address', null, $post_data->ID ),
			'latitude'  => self::parse_map_data( 'center_lat', $post_data->ID ),
			'longitude' => self::parse_map_data( 'center_lng', $post_data->ID ),
			'tags'      => self::parse_tags( $post_data->ID ),
		);

		return $parsed_data;
	}

	private static function parse_map_data( $prop, $post_id ) {
		$map_data = loop_events_get_field( 'loop_events_map_location', null, $post_id );
		return $map_data[ $prop ];
	}

	private static function parse_tags( $post_id ) {
		$tags = get_the_terms( $post_id, LOOP_CPT_SLUG . '-tags' );
		if ( is_array( $tags ) ) {
			return array_column( $tags, 'name' );
		}
		return array();
	}

}
