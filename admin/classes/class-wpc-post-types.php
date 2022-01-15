<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WPCargo_Post_Types{
	public static function init(){
		add_action('init', array( __CLASS__, 'wpcargo_post_type' ), 9 );
	}
	public static function wpcargo_post_type(){
		$labels_menu = array(
			'name'					=> _x('Shipment', 'Shipment', 'wpcargo'),
			'singular_name'			=> _x('Shipment', 'Shipment', 'wpcargo'),
			'menu_name' 			=> esc_html__('Shipment', 'wpcargo'),
			'all_items' 			=> esc_html__('All Shipment', 'wpcargo'),
			'view_item' 			=> esc_html__('View Shipment', 'wpcargo'),
			'add_new_item' 			=> esc_html__('Add New Shipment', 'wpcargo'),
			'add_new' 				=> esc_html__('Add Shipment', 'wpcargo'),
			'edit_item' 			=> esc_html__('Edit Shipment', 'wpcargo'),
			'update_item' 			=> esc_html__('Update Shipment', 'wpcargo'),
			'search_items' 			=> esc_html__('Search Shipment', 'wpcargo'),
			'not_found' 			=> esc_html__('Shipment Not found', 'wpcargo'),
			'not_found_in_trash' 	=> esc_html__('Shipment Not found in Trash', 'wpcargo')
		);
		$wpcargo_supports 			= array( 'title', 'author', 'thumbnail', 'revisions' );
		$args_tag         			= array(
			'label' 				=> esc_html__('Shipment', 'wpcargo'),
			'description' 			=> esc_html__('Shipment', 'wpcargo'),
			'labels' 				=> $labels_menu,
			'supports' 				=> $wpcargo_supports,
			'taxonomies' 			=> array( 'wpcargo_shipment', 'post_tag' ),
			'menu_icon' 			=> 'dashicons-location-alt',
			'hierarchical' 			=> true,
			'public' 				=> false,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'show_in_nav_menus' 	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position' 		=> 5,
			'can_export' 			=> true,
			'has_archive' 			=> false,
			'exclude_from_search' 	=> true,
			'publicly_queryable' 	=> false,
			'capability_type' 		=> 'post'
		);
		register_post_type('wpcargo_shipment', $args_tag);
		$labels_cat = array(
			'name' 				=> _x('Category', 'Category', 'wpcargo'),
			'singular_name' 	=> _x('Category', 'Category', 'wpcargo'),
			'search_items' 		=> esc_html__('Search Category', 'wpcargo'),
			'all_items' 		=> esc_html__('All Category', 'wpcargo'),
			'parent_item' 		=> esc_html__('Parent Category', 'wpcargo'),
			'parent_item_colon' => esc_html__('Parent Category:', 'wpcargo'),
			'edit_item' 		=> esc_html__('Edit Category', 'wpcargo'),
			'update_item' 		=> esc_html__('Update Category', 'wpcargo'),
			'add_new_item' 		=> esc_html__('Add New Category', 'wpcargo'),
			'new_item_name' 	=> esc_html__('New Category Name', 'wpcargo'),
			'menu_name' 		=> esc_html__('Category', 'wpcargo')
		);
		$args_cat   = array(
			'hierarchical' 		=> true,
			'labels' 			=> $labels_cat,
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'query_var' 		=> true
		);
		register_taxonomy('wpcargo_shipment_cat', array( 'wpcargo_shipment'	), $args_cat, 20);
	}
}
WPCargo_Post_Types::init();
