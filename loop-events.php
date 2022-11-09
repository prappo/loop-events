<?php

/**
 * Plugin Name: Loop Events
 * Description: Events import and show plugin
 * Plugin URI:  https://agentur-loop.com
 * Version:     1.0.0
 * Author:      Prappo
 * Author URI:  https://prappo.dev
 * Text Domain: loop
 *
 * @package loop
 */

use Loop\BaseTrait;

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . '/bootstrap.php';

/**
 * Plugin's main class
 */
final class Loop_Events {

	use BaseTrait;

	/**
	 * Constructor of this class
	 */
	public function __construct() {
		define( 'LOOP_DIR', plugin_dir_path( __FILE__ ) );
		define( 'LOOP_URL', plugin_dir_url( __FILE__ ) );
		define( 'LOOP_ASSETS_URL', LOOP_URL . '/assets' );
		define( 'LOOP_CPT_SLUG', 'loop-events' );
	}

	/**
	 * ---------------------------------
	 *  Main execution point where the
	 *       plugin will fire up
	 * ---------------------------------
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init() {
		if ( is_admin() ) {
			
			// $this->add_menu();
		}

		add_action( 'init', array( $this, 'i18n' ) );
	}

	private function add_menu() {
		add_action( 'admin_menu', array( \Loop\Menu::get_instance(), 'init' ) );
	}

	/**
	 * Loads a plugin’s translated strings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function i18n() {
		load_plugin_textdomain( 'loop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

function loop_events_init() {
	Loop_Events::get_instance()->init();
}

add_action( 'plugins_loaded', 'loop_events_init' );
