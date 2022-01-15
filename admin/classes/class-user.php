<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class WPCargo_User{
	function __construct(){
		add_action( 'show_user_profile', array( $this, 'extra_profile_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'extra_profile_fields' ) );
		add_action( 'personal_options_update', array( $this, 'save_extra_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_extra_profile_fields' ) );
	}
	function extra_profile_fields( $user ) {
		$current_offset = get_option('gmt_offset');
		$tzstring 		= get_option('timezone_string');
		$check_zone_info = true;
		// Remove old Etc mappings. Fallback to gmt_offset.
		if ( false !== strpos($tzstring,'Etc/GMT') )
			$tzstring = '';
		if ( empty($tzstring) ) { // Create a UTC+- zone if no timezone string exists
			$check_zone_info = false;
			if ( 0 == $current_offset )
				$tzstring = 'UTC+0';
			elseif ($current_offset < 0)
				$tzstring = 'UTC' . $current_offset;
			else
				$tzstring = 'UTC+' . $current_offset;
		}
		$user_timezone = get_user_meta( $user->ID, 'wpc_user_timezone', true );
		$tzstring = $user_timezone ? $user_timezone : $tzstring ;
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/user-profile.tpl.php');
	}	

	function save_extra_profile_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ){
			return false;
		}
		if( isset( $_POST['wpc_user_timezone'] ) ){
			update_user_meta( $user_id, 'wpc_user_timezone', sanitize_text_field( $_POST['wpc_user_timezone'] ) );
		}
		if( isset( $_POST['business_reg'] ) ){
			update_user_meta( $user_id, 'business_reg', wp_strip_all_tags( $_POST['business_reg'] ) );
		}
		
		if( isset( $_POST['gst_account'] ) ){
			update_user_meta( $user_id, 'gst_account', wp_strip_all_tags( $_POST['gst_account'] ) );
		}
		
		if( isset( $_POST['min_notification'] ) ){
			update_user_meta( $user_id, 'min_notification', wp_strip_all_tags( $_POST['min_notification'] ) );
		}
		
		if( isset( $_POST['wpcargo_phone'] ) ){
			update_user_meta( $user_id, 'wpcargo_phone', wp_strip_all_tags( $_POST['wpcargo_phone'] ) );
		}
		if( isset( $_POST['company_logo'] ) ){
			update_user_meta( $user_id, 'company_logo', wp_strip_all_tags( $_POST['company_logo'] ) );
		}	
	}
}
new WPCargo_User;