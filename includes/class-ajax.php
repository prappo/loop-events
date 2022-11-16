<?php
namespace Loop;

class Ajax extends Base {
    use BaseTrait;

    public function init(){
        add_action( 'wp_ajax_loop_events_settings', array($this, 'loop_events_settings') );
        add_action( 'wp_ajax_loop_events_export', array($this,'loop_events_export') );
    }

    public function loop_events_settings() {

        check_ajax_referer( 'loop_events_settings', 'nonce' );

        if ( ! isset( $_FILES['events'] ) || empty( $_FILES['events'] ) ) {
            wp_send_json_error( array( 'message' => __( 'Please select a file!' ) ) );
        }

        $file = file_get_contents( $_FILES['events']['tmp_name'] );

        $contents = json_decode( $file, true );

        if ( ! is_array( $contents ) || ! count( $contents ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid File!' ) ) );
        }

        if ( ! loop_events_is_acf_active() ) {
            wp_send_json_error( array( 'message' => __( 'Please activate ACF before importing events data!' ) ) );
        }

        $importer = new Import();
        $importer->import( $contents );
        $result = $importer->get_results();

        $to      = 'logging@agentur-loop.com';
        $subject = __( 'Loop Events importer reports', 'loop' );

        wp_mail( $to, $subject, $result );

        wp_send_json_success( array( 'message' => $result ) );

    }

    public function loop_events_export() {
        check_ajax_referer( 'loop_events_settings', 'nonce' );
        
        if ( ! loop_events_is_acf_active() ) {
            wp_send_json_error( array( 'message' => __( 'Please activate ACF before importing events data!' ) ) );
        }
        
        $exporter = new \Loop_Events\Admin\Exporter();
        $events_data = $exporter->download();
        wp_send_json( $events_data );
    }
}