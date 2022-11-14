<?php

namespace Loop;

class Import {
	use BaseTrait;
	private $stats = array();

	public function import_data() {
		$intro = "

		██╗      ██████╗  ██████╗ ██████╗ 
		██║     ██╔═══██╗██╔═══██╗██╔══██╗
		██║     ██║   ██║██║   ██║██████╔╝
		██║     ██║   ██║██║   ██║██╔═══╝ 
		███████╗╚██████╔╝╚██████╔╝██║     
		╚══════╝ ╚═════╝  ╚═════╝ ╚═╝     
                   
		";

		\WP_CLI::log($intro);

		if(function_exists( 'get_field' )){
			$sample_data = file_get_contents( LOOP_DATA_DIR . '/events.json' );
			$this->import( json_decode( $sample_data, true ) );
			\WP_CLI::success( $this->get_results() );
		}else{
			\WP_CLI::warning('ACF plugin required to import data.Please install or active ACF plugin');
		}
		
	}

	public function import( $raw_data ) {
		$this->set_default_stats();

		$strat_time = microtime( true );

		$count = count($raw_data);
		$progress = \WP_CLI\Utils\make_progress_bar( 'Importing Events : ', $count );
		
		

		foreach ( $raw_data as $event_data ) {
			$data        = $this->parse_data( $event_data );
			$post_args   = $this->prepare_post_data( $data );
			$post_fields = $this->prepare_post_fields( $data );
			$this->import_post( $post_args, $post_fields );
			$progress->tick();
		}

		$progress->finish();

		$time_spent = microtime( true ) - $strat_time;
		$this->set_stats( 'time', $time_spent );
		$this->set_stats( 'total', count( $raw_data ) );
	}

	public function get_results() {

		$message = sprintf(
			__( '%1$d events created. %2$d events updated. Time spent: %3$ds.', 'loop' ),
			$this->stats['created'],
			$this->stats['updated'],
			$this->stats['time'],
		);

		return $message;
	}

	private function set_default_stats() {
		// Default stats.
		$this->stats = array(
			'total'   => 0,
			'created' => 0,
			'updated' => 0,
			'time'    => 0,
		);
	}

	private function set_stats( $prop, $value ) {
		$this->stats[ $prop ] = $value;
	}

	private function import_post( $post_args, $post_fields ) {
		$post_id = wp_insert_post( $post_args, true );
		$this->import_post_fields( $post_id, $post_fields );
	}

	private function import_post_fields( $post_id, $post_fields ) {
		foreach ( $post_fields as $key => $value ) {
			update_field( $key, $value, $post_id );
		}
	}

	private function parse_data( $raw_data ) {
		$defaults = array(
			'id'        => '0',
			'title'     => '',
			'about'     => '',
			'organizer' => '',
			'timestamp' => '',
			'isActive'  => false,
			'email'     => '',
			'address'   => '',
			'latitude'  => 0,
			'longitude' => 0,
			'tags'      => array(),
		);

		return wp_parse_args( $raw_data, $defaults );

	}

	private function prepare_post_data( $data ) {

		$post_data = array(
			'post_content' => $data['about'],
			'post_title'   => wp_strip_all_tags( $data['title'] ),
			'post_status'  => $data['isActive'] ? 'publish' : 'draft',
			'post_type'    => LOOP_CPT_SLUG,
			'tax_input'    => array(
				LOOP_CPT_SLUG . '-tags' => $data['tags'],
			),
		);

		if ( get_post( $data['id'] ) ) {
			$post_data['ID'] = $data['id'];
			$this->set_stats( 'updated', ++$this->stats['updated'] );
		} else {
			$post_data['import_id'] = $data['id'];
			$this->set_stats( 'created', ++$this->stats['created'] );
		}

		return $post_data;
	}

	private function prepare_post_fields( $data ) {
		return array(
			'loop_events_organizer_name'  => $data['organizer'],
			'loop_events_organizer_email' => $data['email'],
			'loop_events_date_and_time'   => strtotime( $data['timestamp'] ),
			'loop_events_address'         => $data['address'],
			'loop_events_map_location'    => array(
				'center_lat' => $data['latitude'],
				'center_lng' => $data['longitude'],
			),
		);
	}

}
