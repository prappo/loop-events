<?php
namespace Loop;

class Menu extends Base {
	use BaseTrait;

	public function init() {

		add_action( 'admin_menu', array( $this, 'import_export_menu' ) );

	}

	public function import_export_menu() {
		add_submenu_page(
			'edit.php?post_type=' . $this->get_post_type(),
			__( 'Import & Export events', 'loop' ),
			__( 'Import & Export events', 'loop' ),
			'manage_options',
			'loop-evnets-import-export',
			array( $this, 'impport_export_page' )
		);

	}

	public function impport_export_page() {

		?>
		<div class="loop-events-admin-wrapper">
			<div class="loop-events-admin-header">
				<div class="loop-events-admin-title">
					<h1>
						<?php esc_html_e( 'Loop Events Options', 'loop' ); ?>
					</h1>
				</div>
			</div>
			<div class="loop-events-admin-main">
				<section class="loop-events-settings">
					<h2>
						<?php esc_html_e( 'Import', 'loop' ); ?>
					</h2>
					<label for="loop-events-json-import">
						<?php esc_html_e( 'Select a json file to import events.', 'loop' ); ?>
					</label>
					<input type="file" name="loop-events-json" id="loop-events-json" accept=".json">
					<button type="button" id="loop-events-json-import" class="button button-primary">
						<?php esc_html_e( 'Import events', 'loop' ); ?>
					</button> 
				<?php wp_nonce_field( 'loop_events_settings' ); ?>
				</section>

				<section class="loop-events-settings">
					<h2>
						<?php esc_html_e( 'Export events', 'loop' ); ?>
					</h2>
					<button type="button" id="loop-events-json-export" class="button button-primary">
						<?php esc_html_e( 'Export existing data', 'loop' ); ?>
					</button>
				</section>
			</div>
		</div>
		<?php
	}
}
