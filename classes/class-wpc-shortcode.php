<?php
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}
class WPCargo_Track_Form{
	function __construct() {
		add_shortcode('wpcargo_trackform', array( $this, 'wpcargo_trackform' ) );
		add_shortcode('wpcargo_trackresults', array( $this, 'wpcargo_trackform'));
		add_action('wpcargo_track_form', array( $this, 'wpcargo_trackform_template' ), 10, 1 );
		add_action('wpcargo_track_result_form', array( $this, 'wpcargo_trackform_result_template' ), 10 );
		add_action('wpcargo_track_header_details', array( $this, 'wpcargo_trackform_result_header_details_template' ), 10, 1 );
		add_action('wpcargo_track_shipper_details', array( $this, 'wpcargo_trackform_result_shipper_details_template' ), 10, 1 );
		add_action('wpcargo_track_shipment_details', array( $this, 'wpcargo_trackform_result_shipment_details_template' ), 10 , 1);
		// Client Account Shortcode
		add_shortcode('wpcargo_account', array( $this, 'account_shortcode_callback') );
		add_shortcode('wpc-ca-account', array( $this, 'account_shortcode_callback') );
	}
	function wpcargo_trackform($atts) {
			$attr = shortcode_atts( array(
				'id' => '',
				'show' => 1
			), $atts );
			ob_start();
			do_action('wpcargo_before_track_result_form', 10);
			if( isset( $_REQUEST['wpcargo_tracking_number'] ) ){
				if( $attr['show'] ){
					do_action('wpcargo_track_form', $attr, 10);
				}
				do_action('wpcargo_track_result_form', 10);
			}else{
				do_action('wpcargo_track_form', $attr, 10);
			}
			do_action('wpcargo_after_track_result_form', 10);
			$output = ob_get_clean();
			return $output;
	}
	public function wpcargo_trackform_template( $atts ){
		global $wpdb;
		$template_path = apply_filters( 'wpcargo_track_form_template_path', WPCARGO_PLUGIN_PATH.'templates/track-form.tpl.php' );
		require_once( $template_path );
	}
	public function wpcargo_trackform_result_template(){
		global $wpdb;
		$shipment_number = $_REQUEST['wpcargo_tracking_number'];
		require_once(WPCARGO_PLUGIN_PATH.'templates/result-form.tpl.php');
	}
	public function wpcargo_trackform_result_shipment_details_template( $shipment ){
		global $wpdb;
		require_once(WPCARGO_PLUGIN_PATH.'templates/result-form-shipment-details.tpl.php');
	}
	public function wpcargo_trackform_result_shipper_details_template( $shipment ){
		global $wpdb;
		require_once(WPCARGO_PLUGIN_PATH.'templates/result-form-shipper-details.tpl.php');
	}
	public function wpcargo_trackform_result_header_details_template( $shipment ){
		global $wpdb, $wpcargo;
		$shipment_id	= $shipment->ID;
		$tracknumber	= $shipment->post_title;
		$url_barcode	= $wpcargo->barcode_url( $shipment_id );
		require_once(WPCARGO_PLUGIN_PATH.'templates/result-form-header-details.tpl.php');
	}
	// Account shortcode callback
	public function account_shortcode_callback(){
		global $wpdb, $wpcargo;
		ob_start();
		$get_results = $wpdb->get_results("SHOW TABLES LIKE '".$wpdb->prefix."wpcargo_custom_fields'");
		$plugins = get_option ( 'active_plugins', array () );
		if( !is_user_logged_in() ){
			?>
			<div class="wpcargo-login" style="width: 450px; margin: 0 auto;">
				<?php wp_login_form(); ?>
			</div>
			<?php
			return false;
		}
		$user_id			= get_current_user_id();
		$user_info 			= get_userdata( $user_id );
		$user_full_name		= $wpcargo->user_fullname( $user_id );
		$shipment_sort 		= isset( $_GET['sort'] ) ? $_GET['sort'] : 'all' ;
		$paged				= ( get_query_var('paged')) ? get_query_var('paged') : 1;
		$shipment_args = apply_filters( 'wpcargo_account_query', array(
			'post_type' 		=> 'wpcargo_shipment',
			'posts_per_page' 	=> 12,
			'orderby' 			=> 'date',
			'order' 			=> 'DESC',
			'paged' 			=> $paged,
			'meta_query' 		=> array(
						'relation' => 'OR',
						array(
							'key' => 'registered_shipper',
							'value' => $user_id
						),
						array(
							'key' => 'registered_receiver',
							'value' => $user_id
						),
					)
			), $shipment_sort
		);
		$shipment_query  	= new WP_Query($shipment_args);
		if(!empty($get_results) && is_array($plugins) && in_array('wpcargo-custom-field-addons/wpcargo-custom-field.php', $plugins) ){
			require_once( WPCARGO_PLUGIN_PATH.'templates/account-cf.tpl.php' );
		}else{
			require_once( WPCARGO_PLUGIN_PATH.'templates/account.tpl.php' );
		}
		// Reset Post Data
		wp_reset_postdata();
		$output = ob_get_clean();
		return $output;
	}
}
$wpcargo_track_form = new WPCargo_Track_Form();