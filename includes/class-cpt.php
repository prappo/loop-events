<?php

namespace Loop;

class CPT extends Base {

	use BaseTrait;

	public function init() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
	}

	public function register_post_type() {

		$labels = array(
			'name'                  => _x( 'Events', 'Post type general name', 'loop' ),
			'singular_name'         => _x( 'Event', 'Post type singular name', 'loop' ),
			'menu_name'             => _x( 'Events', 'Admin Menu text', 'loop' ),
			'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'loop' ),
			'add_new'               => __( 'Add New', 'loop' ),
			'add_new_item'          => __( 'Add New Event', 'loop' ),
			'new_item'              => __( 'New Event', 'loop' ),
			'edit_item'             => __( 'Edit Event', 'loop' ),
			'view_item'             => __( 'View Event', 'loop' ),
			'all_items'             => __( 'All Events', 'loop' ),
			'search_items'          => __( 'Search Events', 'loop' ),
			'parent_item_colon'     => __( 'Parent Events:', 'loop' ),
			'not_found'             => __( 'No events found.', 'loop' ),
			'not_found_in_trash'    => __( 'No events found in Trash.', 'loop' ),
			'insert_into_item'      => _x( 'Insert into event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'loop' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'loop' ),
			'filter_items_list'     => _x( 'Filter events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'loop' ),
			'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'loop' ),
			'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'loop' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_in_rest'       => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'menu_icon'          => 'dashicons-calendar',
			'supports'           => array( 'title', 'editor' ),
			'taxonomies'         => array( 'loop-event-tags' ),
		);

		register_post_type( $this->get_post_type(), $args );
	}

	public function register_taxonomies() {

		$labels = array(
			'name'          => _x( 'Tags', 'taxonomy general name', 'loop' ),
			'singular_name' => _x( 'Tag', 'taxonomy singular name', 'loop' ),
			'search_items'  => __( 'Search Tags', 'loop' ),
			'all_items'     => __( 'All Tags', 'loop' ),
			'edit_item'     => __( 'Edit Tag', 'loop' ),
			'update_item'   => __( 'Update Tag', 'loop' ),
			'add_new_item'  => __( 'Add New Tag', 'loop' ),
			'new_item_name' => __( 'New Tag Name', 'loop' ),
			'menu_name'     => __( 'Tag', 'loop' ),
		);

		$args = array(
			'hierarchical'      => false, // Tag.
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);
		register_taxonomy( 
			$this->get_post_type() . '-tags', 
			$this->get_post_type(), 
			$args );
	}
}
