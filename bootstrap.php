<?php

defined( 'ABSPATH' ) || exit;

class Loop_Bootstrap {

	private static $instance;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private $required_files = array(
		'trait',
		'class-base',
		'helper',
		'class-cpt',
		'class-cli',
		'class-custom-fields',
		'class-import',
		'class-export',
		'class-assets',
		'class-menu',
	);

	private $bootstrap_files_list = array( 
		'class-cpt', 
		'class-cli', 
		'class-custom-fields', 
		'class-assets',
		'class-export',
		'class-menu',
	);

	public function __construct() {
		$this->import_core_files()->init_core();
	}

	private function import_core_files() {
		foreach ( $this->required_files as $cf ) {
			require_once plugin_dir_path( __FILE__ ) . '//includes/' . $cf . '.php';
		}
		return $this;
	}

	/**
	 * -----------------------------------------------
	 * Loading and initializing core files that is
	 * private and for internal use
	 * -----------------------------------------------
	 *
	 * @since 1.0.0
	 * @return this
	 */
	private function init_core() {
		foreach ( $this->bootstrap_files_list as $bootstrap_file ) {
			$class_name = '\Loop\\' . ucfirst( str_replace( '-', '_', str_replace( 'class-', '', $bootstrap_file ) ) );
			$class_name::get_instance()->init();
		}
		return $this;
	}

}

global $loop_events;
$loop_events = Loop_Bootstrap::get_instance();
