<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
class WPCargo_Print_Admin{
	public function __construct() {
		add_action('admin_menu', array( $this, 'wpcargo_print_register_submenu_page' ) );
		add_action('admin_print_header', array( $this, 'wpcargo_print_header_template' ) );
		add_action('admin_print_shipper', array( $this, 'wpcargo_print_shipper_template' ), 10 );
		add_action('admin_print_shipment', array( $this, 'wpcargo_print_shipment_template' ), 10 );
	}
	public function wpcargo_print_register_submenu_page() {
		add_submenu_page(
			NULL,
			wpcargo_print_layout_label(),
			wpcargo_print_layout_label(),
			'edit_posts',
			'wpcargo-print-layout',
			array( $this, 'wpcargo_print_submenu_page_callback' )
		);
		add_submenu_page(
			NULL,
			wpcargo_shipment_label(),
			wpcargo_shipment_label(),
			'edit_posts',
			'wpcargo-print-label',
			array( $this, 'wpcargo_print_label_page_callback' )
		);
	}
	public function wpcargo_print_submenu_page_callback() {
		global $wpdb;
		require_once(WPCARGO_PLUGIN_PATH.'admin/templates/admin-print.tpl.php');
	}
	public function wpcargo_print_header_template($shipment_detail) {
		global $wpdb;
		require_once(WPCARGO_PLUGIN_PATH.'admin/templates/print-details-header.tpl.php');
	}
	public function wpcargo_print_shipper_template($shipment_detail) {
		global $wpdb;
		require_once(WPCARGO_PLUGIN_PATH.'admin/templates/print-details-shipper.tpl.php');
	}
	public function wpcargo_print_shipment_template($shipment_detail) {
		global $wpdb;
		require_once(WPCARGO_PLUGIN_PATH.'admin/templates/print-details-shipment.tpl.php');
	}
	//** Print Label methods
	public function wpcargo_print_label_page_callback(){
		global $wpcargo;
		if( isset( $_GET['id'] ) ){
			$shipmentID = $_GET['id'];
			if( get_post_type( $shipmentID ) != 'wpcargo_shipment' && get_post_status( $shipmentID ) != 'publish' ){
				return false;
			}
			$barcode			= $wpcargo->barcode( $shipmentID );
			$mp_settings 		= get_option('wpc_mp_settings');
			$setting_options 	= get_option('wpcargo_option_settings');
			$packages 			= maybe_unserialize( get_post_meta( $shipmentID,'wpc-multiple-package', TRUE) );
			$logo 				= '';
			if( !empty( $setting_options['settings_shipment_ship_logo'] ) ){
				$logo 		= '<img style="width: 180px;" src="'.$setting_options['settings_shipment_ship_logo'].'">';
			}
			if( get_option('wpcargo_label_header') ){
				$siteInfo = get_option('wpcargo_label_header');
			}else{
				$siteInfo  = $logo;
				$siteInfo .= '<h2 style="margin:0;padding:0;">'.get_bloginfo('name').'</h2>';
				$siteInfo .= '<p style="margin:0;padding:0;font-size: 14px;">'.get_bloginfo('description').'</p>';
				$siteInfo .= '<p style="margin:0;padding:0;font-size: 10px;">'.get_bloginfo('wpurl').'</p>';
			}
			$shipmentDetails 	= array(
				'shipmentID'	=> $shipmentID,
				'barcode'		=> $barcode,
				'packageSettings'	=> $mp_settings,
				'cargoSettings'	=> $setting_options,
				'packages'		=> $packages,
				'logo'			=> $logo,
				'siteInfo'		=> $siteInfo
			);
			$custom_template_path   = get_stylesheet_directory().'/wpcargo/admin-print-label.tpl.php';
			if( file_exists( $custom_template_path ) ){
				$label_template_url = $custom_template_path;
			}else{
				$label_template_url =  apply_filters( 'label_template_url', $this->print_label_template_callback(), $shipmentDetails );
			}
			?>
			<div class="wrap">
				<div class="postbox">
					<div class="inside">
						<script type="text/javascript">
							function wpcargo_print(wpcargo_class) {
								var printContents = document.getElementById(wpcargo_class).innerHTML;
								var originalContents = document.body.innerHTML;
								document.body.innerHTML = printContents;
								window.print();
								document.body.innerHTML = originalContents;
								location.reload(true);
							}
						</script>
						<div id="actions" style="margin-bottom: 12px; text-align: right;">
							<a href="#" class="button button-secondary print" onclick="wpcargo_print('print-label')"><span class="dashicons dashicons-tag"></span> <?php esc_html_e('Print Label', 'wpcargo'); ?></a>
						</div>
						<div id="print-label">
						<style type="text/css">
							div.copy-section {
								border: 2px solid #000;
							    margin-bottom: 18px;
							}
							.copy-section table {
								border-collapse: collapse;
							}
							.copy-section table td.align-center{
								text-align: center;
							}
							.copy-section table td {
							    border: 1px solid #000;
							}
							table tr td{
								padding:6px;
							}
							table tr td.center{
								text-align:center;
							}
							table tr td.bold{
								font-weight: bold;
							}
							@media screen, print{
							}
						</style>
						<?php require_once( $label_template_url ); ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
	public function print_label_template_callback( ){
		return WPCARGO_PLUGIN_PATH.'admin/templates/admin-print-label.tpl.php';
	}
}
$wpcargo_print_admin = new WPCargo_Print_Admin;