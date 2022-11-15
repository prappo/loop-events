<?php
defined( 'ABSPATH' ) || exit;

function loop_events_get_option( string $option, $default = null ) {
	$options = get_option( 'loop_events_config', array() );
	return $options[ $option ] ?? $default;
}

function loop_events_update_option( $option, $new_value ) {
	$config            = get_option( 'loop_events_config', array() );
	$config[ $option ] = $new_value;
	return update_option( 'loop_events_config', $config );
}

function loop_events_is_acf_active() {
	return function_exists( 'get_field' );
}

// Wrap ACF Related functions to avoid multiple checks for ACF existence and possible fatal errors in front-end.
function loop_events_get_field( $field, $default = '', $post_id ) {
	if ( ! loop_events_is_acf_active() ) {
		return $default;
	}

	return get_field( $field, $post_id );
}

function loop_events_show_map_link() {
	$map_data = loop_events_get_field( 'loop_events_map_location' );
	if ( $map_data ) {
		$latitude  = $map_data['center_lat'];
		$longitude = $map_data['center_lng'];
		$map_link  = "https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}";
		?>
		<strong><?php esc_html_e( 'Location: ', 'loop-events' ); ?></strong>
		<a href="<?php echo esc_attr( $map_link ); ?>">
			<?php esc_html_e( 'View on the map', 'loop-events' ); ?>
		</a>
		<?php
	}
}

function loop_events_show_organizer_email() {
	$email = loop_events_get_field( 'loop_events_organizer_email' );
	if ( $email ) :
		?>
		<strong><?php esc_html_e( 'Organizer Email: ', 'loop-events' ); ?></strong>
		<a href="mailto:<?php echo esc_attr( $email ); ?>">
			<?php echo esc_html( $email ); ?>
		</a>	
		<?php
	endif;
}

function loop_events_show_text_field( $label, $field_key ) {
	?>
		<strong><?php echo $label . ': '; ?></strong>
		<?php echo loop_events_get_field( $field_key ); ?>
	<?php
}

function loop_events_show_time() {
	$date_time = loop_events_get_field( 'loop_events_date_and_time' );
	if ( $date_time ) {
		?>
		<strong><?php esc_html_e( 'Starts in: ', 'loop-events' ); ?></strong>
		<?php
		echo human_time_diff( strtotime( $date_time ), time() );
	}
}
