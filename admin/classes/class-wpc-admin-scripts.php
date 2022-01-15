<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WPCargo_Admin_Scripts{
	function __construct(){
		add_action( 'admin_enqueue_scripts', array( $this,'admin_scripts' ) );
	}
	
	function admin_scripts() {
		global $pagenow, $wpcargo;
		$screen 			= get_current_screen();

		$options 			= get_option( 'wpc_mp_settings' );
		$vat_percentage 	= !empty($options['wpc_mp_vat_percentage']) ? $options['wpc_mp_vat_percentage'] : '0';
		$translation_array 	= array(
			'ajax_url' 				=> admin_url( 'admin-ajax.php' ),
			'vat_percentage' 		=> '.'.$vat_percentage,
			'deleteElementMessage' 	=> __('Are you sure you want to delete this element?', 'wpcargo' ),
			'autoFillPlaceholder'   => __('--Please Select Client--', 'wpcargo' ),
			'date_format'   		=> $wpcargo->date_format,
			'time_format'   		=> $wpcargo->time_format,
			'datetime_format'   	=> $wpcargo->datetime_format,
		);
		// Register Scripts
		wp_register_script( 'wpcargo-datetimepicker', WPCARGO_PLUGIN_URL . 'admin/assets/js/jquery.datetimepicker.full.min.js', array( 'jquery' ), WPCARGO_VERSION, false );
		wp_register_script( 'wpcargo-repeater-js', WPCARGO_PLUGIN_URL.'admin/assets/js/jquery.repeater.js', array( 'jquery' ), WPCARGO_VERSION, false );
		wp_register_script( 'wpcargo-admin-js', WPCARGO_PLUGIN_URL.'admin/assets/js/wpcargo-admin.js', array( 'jquery' ), WPCARGO_VERSION, false );
		wp_register_script( 'wpcargo-select2-js', WPCARGO_PLUGIN_URL.'admin/assets/js/select2.full.min.js', array( 'jquery' ), WPCARGO_VERSION, false );
		// Register Styles
		wp_register_style('wpcargo-datetimepicker', WPCARGO_PLUGIN_URL . 'admin/assets/css/jquery.datetimepicker.min.css', array(), WPCARGO_VERSION );
		wp_register_style('wpcargo-select2-css', WPCARGO_PLUGIN_URL . 'admin/assets/css/select2.min.css', array(), WPCARGO_VERSION );
		wp_register_style('wpcargo-admin-css', WPCARGO_PLUGIN_URL . 'admin/assets/css/admin-style.css', array(), WPCARGO_VERSION );
		// Enqueue Scripts
		wp_enqueue_script('jquery');
		wp_enqueue_script('wpcargo-datetimepicker');
		if( $screen->id == 'toplevel_page_wpcargo-settings' ){
			wp_enqueue_style( 'wp-color-picker' );
			// Include our custom jQuery file with WordPress Color Picker dependency
			wp_enqueue_script( 'color-picker-handle', WPCARGO_PLUGIN_URL . 'admin/assets/js/color-picker.js', array( 'wp-color-picker' ), false, true );
		}
		
		// Enqueue Styles
		wp_enqueue_style( 'wpcargo-datetimepicker' );
		wp_enqueue_style( 'wpcargo-admin-css' );
		wp_localize_script( 'wpcargo-admin-js', 'wpcargoAJAXHandler', $translation_array );
		wp_enqueue_style( 'wpcargo-multiple-package-style-admin', WPCARGO_PLUGIN_URL. 'admin/assets/css/wpc-mp-admin.css', array(), WPCARGO_VERSION );

		
		//if( $screen->post_type == 'wpcargo_shipment' ){
			wp_enqueue_style( 'wpcargo-select2-css' );
			wp_enqueue_script( 'wpcargo-select2-js');
			wp_enqueue_script( 'wpcargo-repeater-js');
			wp_enqueue_script( 'wpcargo-admin-js');
		//}
		if( isset($_GET['page'] ) && $_GET['page'] == 'wpc-report-export' ) {
			wp_enqueue_script( 'wpcargo-multiselect-export', WPCARGO_PLUGIN_URL. 'admin/assets/js/wpc-multiselect-reports.js' , array( 'jquery' ), WPCARGO_VERSION, false );
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'wpc-autocomplete-ajax', WPCARGO_PLUGIN_URL . 'admin/assets/js/wpc-autocomplete-reports.js', array('jquery'), WPCARGO_VERSION, false );
			wp_localize_script( 'wpc-autocomplete-ajax', 'wpc_ie_ajaxscripthandler', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
		if(isset( $_GET['page'] ) && $_GET['page'] == 'wpcargo-settings' ){
			wp_enqueue_media();
		}
	}
}
new WPCargo_Admin_Scripts;
add_action('admin_head', function(){
	$options 		= get_option('wpcargo_option_settings');
	$baseColor 		= '#00A924';
	if( $options ){
		if( array_key_exists('wpcargo_base_color', $options) ){
			$baseColor = ( $options['wpcargo_base_color'] ) ? $options['wpcargo_base_color'] : $baseColor ;
		}
	}
	?>
	<style type="text/css">
		::root{
			--main-bg-color: #eee; 
		}
		.dashboard_wpcargo_license_helper_page td input.button.button-primary[name="activate"],
		.wpc-cf-setting-admin input#submit.button.button-primary,
		.email-setting-admin-form input#submit.button.button-primary,
		.book-submit input.button.button-primary.button-wpcargo.button-submit,
		#address-list #book .update .edit-address.button.button-quotation,
		.sms-admin-form input#submit.button,
		.sms-admin-form input[type=checkbox]:checked:before,
		.email-setting-admin-form input[type=checkbox]:checked:before,
		.wpc-cf-setting-admin input[type=checkbox]:checked:before,
		#wpcargo-settings-nav .nav-tab-active,
		#wpcargo-settings-nav .nav-tab-active:focus,
		#wpcargo-settings-nav .nav-tab-active:hover,
		#wpcargo-settings-nav .nav-tab:focus,
		#wpcargo-settings-nav .nav-tab:hover,
		.wpc-ie-tab .nav-tab-active, .wpc-ie-tab .nav-tab:hover,
		#wpc-ie-form .button-primary, #wpc-ie-form .button-primary:hover,
		.wpcargo_shipment_page_wpc-ie-export #multi-select-export .col-xs-2 .btn.btn-block,
		.wpcargo_shipment_page_wpc-ie-import #multi-select-export .col-xs-2 .btn.btn-block,
		.wpcargo-settings table.form-table tr #choose-image,
		.wpcargo-settings input.button.button-primary,
		.post-type-wpcargo_shipment form#post input.wpc-add,
		.post-type-wpcargo_shipment form#post #shipment-history .button-primary,
		.post-type-wpcargo_shipment form#post .wpcargo-pod #wpcargo_select_gallery_pod,
		.post-type-wpcargo_shipment form#post .button,
		.post-type-wpcargo_shipment #shipment-history thead th,
		.post-type-wpcargo_shipment #wpcargo-multiple-package thead th,
		.post-type-shipment_container form#post input.wpc-add,
		.post-type-shipment_container form#post .button,
		.post-type-pq_order form#post #pq-add,
		.post-type-pq_order form#post #publish,
		.post-type-pq_order #send-quotation,
		.post-type-parcel form#post #publish,
		#wpc_add_meta_box input[type=checkbox]:checked:before,
		.wpcargo-settings input[type=checkbox]:checked:before,
		#wpc-import-export-checklist #categorychecklist li input[type=checkbox]:checked:before,
		#multi-select-export .col-xs-2 .btn.btn-block,
		input[type=checkbox].wpc-checkbox:checked:before,
		.wpc-button{
			background-color: <?php echo $baseColor; ?> !important;
			color:#fff;
		}
	</style>
	<?php
});