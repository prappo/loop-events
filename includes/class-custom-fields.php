<?php

namespace Loop;

class Custom_Fields extends Base {

    use BaseTrait;
    
	public function init() {
		if ( ! $this->is_acf_active() ) {
			return;
		}

		add_action( 'acf/init', array( $this, 'add' ) );
	}

	public function is_acf_active() {
		return function_exists( 'acf_add_local_field_group' );
	}

	public function add() {

		$fields = array(
			array(
				'key'               => 'loop_events_field_organizer_name',
				'label'             => __( 'Organizer Name', 'loop' ),
				'name'              => 'loop_events_organizer_name',
				'type'              => 'text',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '33',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'loop_events_field_organizer_email',
				'label'             => __( 'Organizer Email', 'loop' ),
				'name'              => 'loop_events_organizer_email',
				'type'              => 'email',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '33',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			),
			array(
				'key'               => 'loop_events_field_date_and_time',
				'label'             => __( 'Date and Time', 'loop' ),
				'name'              => 'loop_events_date_and_time',
				'type'              => 'date_time_picker',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '33',
					'class' => '',
					'id'    => '',
				),
				'display_format'    => 'Y-m-d H:i:s',
				'return_format'     => 'Y-m-d H:i:s',
				'first_day'         => 1,
			),
			array(
				'key'               => 'loop_events_field_address',
				'label'             => __( 'Address', 'loop' ),
				'name'              => 'loop_events_address',
				'type'              => 'textarea',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '50',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'maxlength'         => '',
				'rows'              => '',
				'new_lines'         => '',
			),
			array(
				'key'               => 'loop_events_map_location',
				'label'             => __( 'Map Location', 'loop' ),
				'name'              => 'loop_events_map_location',
				'type'              => 'google_map',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '50',
					'class' => '',
					'id'    => '',
				),
				'center_lat'        => '6.814443',
				'center_lng'        => '63.023457',
				'zoom'              => '',
				'height'            => 200,
			),
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'loop_events_group_event_options',
				'title'                 => __( 'Event Options', 'loop' ),
				'fields'                => $fields,
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => LOOP_CPT_SLUG,
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			)
		);

	}
}
