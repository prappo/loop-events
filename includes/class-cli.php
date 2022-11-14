<?php

namespace Loop;

class CLI extends Base {

	use BaseTrait;

	public function init() {

		// Check if WP_CLI exists or not
		// Becase WP_CLI class is only avilable for CLI.

		if ( ! class_exists( 'WP_CLI' ) ) {
			return;
		}

		// Add command for CLI
		\WP_CLI::add_command( 'import-events', array( $this, 'execute_command' ) );
	}

	/**
	 * Import loop events Ex. wp import-events
	 */
	public function execute_command() {
		
		Import::get_instance()->import_data();
		
	}

}
