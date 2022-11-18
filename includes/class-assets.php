<?php

namespace Loop;

/**
 * Scripts and Styles Class
 */
class Assets extends Base {

	use BaseTrait;

	/**
	 * Class constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_assets' ), 5 );
	}

	public function init(){
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Register our app scripts and styles
	 *
	 * @return void
	 */
	public function register_assets() {
		$this->register_scripts();
		$this->register_styles();
	}

	/**
	 * Load scripts and styles for vue app
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'loop-style' );
		wp_enqueue_script( 'loop-script' );
	}

	/**
	 * Register scripts
	 *
	 * @return void
	 */
	private function register_scripts() {
		wp_register_script( 'loop-script', LOOP_ASSETS_URL . '/js/script.js', false, null, true );
	}

	/**
	 * Register styles
	 *
	 * @return void
	 */
	public function register_styles() {
		wp_register_style( 'loop-style', LOOP_ASSETS_URL . '/css/style.css', null, LOOP_VERSION );
	}
}

