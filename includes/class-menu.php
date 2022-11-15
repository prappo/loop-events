<?php
namespace Loop;

class Menu extends Base {
    use BaseTrait;

    public function init(){

        add_action('admin_menu', array($this,'settings_menu'));
        
    }

    public function settings_menu(){
       $submenu = add_submenu_page(
            'edit.php?post_type=' . $this->get_post_type(),
            __( 'Settings', 'loop' ),
            __( 'Settings', 'loop' ),
            'manage_options',
            'loop-evnets-settings',
            array($this,'settings_page')
        );

        
        // if($current_screen->base === ''){

        // }
        // Assets::get_instance()->load_assets();
        // add_action('load-'.$submenu, Assets::get_instance()->load_assets() );
    }

    public function settings_page(){
       
        ?>
<div class="loop-events-admin-wrapper">
			<div class="loop-events-admin-header">
				<div class="loop-events-admin-title">
					<h1><?php esc_html_e( 'Loop Events', 'loop-events' ); ?></h1>
				</div>
			</div>
			<div class="loop-events-admin-main">
				<section class="loop-events-settings">
					<h2><?php esc_html_e( 'Import:', 'loop-events' ); ?></h2>
					<label for="loop-events-json-import">
						<?php esc_html_e( 'Select a json file to import events.', 'loop-events' ); ?>
					</label>
						<input type="file" name="loop-events-json" id="loop-events-json" accept=".json">
						<button type="button" id="loop-events-json-import" class="button button-primary"><?php esc_html_e( 'Import', 'loop-events' ); ?></button>
				<?php wp_nonce_field( 'loop_events_settings' ); ?>
				</section>
				<section class="loop-events-settings">
					<h2><?php esc_html_e( 'Export:', 'loop-events' ); ?></h2>
					<button type="button" id="loop-events-json-export" class="button button-primary"><?php esc_html_e( 'Export existing data', 'loop-events' ); ?></button>
				</section>
			</div>
		</div>
        <?
    }
}