<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Register a meta box using a class.
*/
class WPCargo_Metabox {
	public $text_domain = 'wpcargo';
	public function __construct() {
		add_filter('wp_mail_content_type', array( $this, 'wpcargo_set_content_type' ));
		if ( is_admin() ) {
			add_action( 'wpcargo_shipper_meta_section', array( $this, 'wpc_shipper_meta_template' ), 10 );
			add_action( 'wpcargo_receiver_meta_section', array( $this, 'wpc_receiver_meta_template' ), 10 );
			add_action( 'wpcargo_shipment_meta_section', array( $this, 'wpc_shipment_meta_template' ), 10 );
			add_filter( 'wpcargo_after_reciever_meta_section_sep', array( $this, 'wpc_after_reciever_meta_sep' ), 10 );
			add_action( 'save_post', array( $this, 'save_metabox' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_metabox'  ) );
			add_action( 'post_submitbox_misc_actions', array( $this, 'shipment_status_display_callback' ) );
		}
		add_action( 'save_post_wpcargo_shipment', array( $this, 'wpcargo_shipment_history_email_template' ), 20, 10  );
		add_filter( 'login_redirect', array( $this, 'wpc_custom_login_redirect' ), 50 );
		add_filter( 'wpcargo_shipment_details_mb', array( $this, 'wpc_shipment_details_mb' ) );
		add_action( 'after_setup_theme', array( $this, 'wpc_remove_admin_bar' ) );
		add_action( 'admin_init',  array( $this, 'wpc_blockusers_init' ) );
	}
	/**
	* Adds the meta box.
	*/
	public function shipment_status_display_callback( $post ){
		global $wpcargo;
		$screen = get_current_screen();
		if( $screen->post_type != 'wpcargo_shipment' ){
			return false;
		}
		$current_status 	= get_post_meta( $post->ID, 'wpcargo_status', TRUE);
		$shipments_update 	= maybe_unserialize( get_post_meta( $post->ID, 'wpcargo_shipments_update', TRUE) );
		$location 			= '';
		if( !empty( $shipments_update ) ){
			$_history = array_pop ( $shipments_update );
			if( array_key_exists( 'location', $_history )){
				$location 	=  $_history['location'];
			}
		}
		ob_start();
			?>
			<div class="misc-pub-section wpc-status-section" style="background-color: #d4d4d4; border-top: 1px solid #757575;border-bottom: 1px solid #757575;">
				<h3 style="border-bottom: 1px solid #757575; padding-bottom: 6px;"><?php esc_html_e( 'Current Status', 'wpcargo' ); ?>: <?php echo wpcargo_html_value( $current_status ); ?></h3>
				<?php foreach( wpcargo_history_fields() as $history_name => $history_value ): ?>
					<p>
						<?php
							$picker_class = '';
							$value = '';
							if( $history_name == 'date' ){
								$picker_class = 'wpcargo-datepicker';
								$value = current_time( $wpcargo->date_format );
							}elseif( $history_name == 'time' ){
								$picker_class = 'wpcargo-timepicker';
								$value = current_time( 'H:i' );
							}
							if( $history_name != 'updated-name' ){
								echo '<label for="'.$history_name.'">'.$history_value['label'].'</label>';
								echo wpcargo_field_generator( $history_value, $history_name, $value, 'history-update '.$picker_class.' status_'.$history_name );
							}
						?>
					</p>
				<?php endforeach; ?>
				<?php do_action('wpcargo_shipment_misc_actions_form', $post ); ?>
			</div>
			<?php
		$output = ob_get_clean();
		echo $output;
	}
	public function add_metabox() {
		global $current_user;
		$wpc_mp_settings = get_option('wpc_mp_settings');
		add_meta_box(
			'wpc_add_meta_box',
			wpcargo_shipment_details_label(),
			array( $this, 'render_metabox' ),
			'wpcargo_shipment'
		);
		add_meta_box(
			'wpcargo_shipment_history',
			apply_filters( 'wpc_shipment_history_header', esc_html__( 'Shipment History', 'wpcargo' ) ),
			array( $this, 'wpc_sh_metabox_callback' ),
			'wpcargo_shipment'
		);
		if ( $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'wpcargo_employee' ) {
			add_meta_box(
				'wpcargo_shipment_designation',
				apply_filters( 'wpc_shipment_history_header', esc_html__( 'Assign shipment to', 'wpcargo' ) ),
				array( $this, 'wpc_sd_metabox_callback' ),
				'wpcargo_shipment',
				'side',
				'high'
			);
		}
		if(!empty($wpc_mp_settings['wpc_mp_enable_admin'])) {
			add_meta_box( 'wpcargo-multiple-package',
				apply_filters( 'wpc_multiple_package_header', esc_html__('Packages', 'wpcargo') ),
				array($this, 'wpc_mp_metabox_callback'),
				'wpcargo_shipment'
			);
		}
	}
	/**
	* Renders the meta box.
	*/
	public function render_metabox( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'wpc_metabox_action', 'wpc_metabox_nonce' );
		$this->wpc_title_autogenerate();
		?>
		<div id="wrap">
			<?php
				do_action('wpcargo_before_metabox_section', 10);
				do_action('wpcargo_shipper_meta_section', 10);
				do_action('wpcargo_receiver_meta_section', 10);
				apply_filters('wpcargo_after_reciever_meta_section_sep', 10 );
				do_action('wpcargo_shipment_meta_section', 10);
				do_action('wpcargo_after_metabox_section', 10);
			?>
		</div>
		<?php
	}
	public function wpc_shipper_meta_template() {
		global $post;
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipper-metabox.tpl.php' );
	}
	public function wpc_receiver_meta_template(){
		global $post;
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/receiver-metabox.tpl.php' );
	}
	public function wpc_shipment_meta_template(){
		global $post, $wpcargo;
		$options 			= get_option('wpcargo_option_settings');
		$wpc_date_format 	= $wpcargo->date_format;
		$wpcargo_expected_delivery_date_picker 	= get_post_meta($post->ID, 'wpcargo_expected_delivery_date_picker', true);
		$wpcargo_pickup_date_picker 			= get_post_meta($post->ID, 'wpcargo_pickup_date_picker', true);
		$shipment_status   		= $options['settings_shipment_status'];
		$shipment_status_list 	= explode(",", $shipment_status);
		$shipment_status_list 	= array_filter( $shipment_status_list );
		$shipment_status_list 	= apply_filters( 'wpcargo_status_option', $shipment_status_list  );
		$shipment_country_des 	= $options['settings_shipment_country'];
		$shipment_country_des_list 	= explode(",", $shipment_country_des);
		$shipment_country_des_list 	= array_filter( $shipment_country_des_list );
		$shipment_country_org 		= $options['settings_shipment_country'];
		$shipment_country_org_list 	= explode(",", $shipment_country_org);
		$shipment_country_org_list 	= array_filter( $shipment_country_org_list );
		$shipment_carrier 			= $options['settings_shipment_wpcargo_carrier'];
		$shipment_carrier_list 	= explode(",", $shipment_carrier);
		$shipment_carrier_list 	= array_filter( $shipment_carrier_list );
		$payment_mode 			= $options['settings_shipment_wpcargo_payment_mode'];
		$payment_mode_list 		= explode(",", $payment_mode);
		$payment_mode_list 		= array_filter( $payment_mode_list );
		$shipment_mode 		= $options['settings_shipment_wpcargo_mode'];
		$shipment_mode_list = explode(",", $shipment_mode);
		$shipment_mode_list = array_filter( $shipment_mode_list );
		$shipment_type 		= $options['settings_shipment_type'];
		$shipment_type_list = explode(",", $shipment_type);
		$shipment_type_list = array_filter( $shipment_type_list );
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipment-metabox.tpl.php' );
	}
	public function wpc_after_reciever_meta_sep(){
		echo '<div class="clear-line"></div>';
	}
	public function wpc_title_autogenerate(){
		global $post, $wpcargo;
		$screen = get_current_screen();
		if( $screen->action && $wpcargo->autogenerate_title ){
			?>
				<script>
					jQuery(document).ready(function($) {
						$( "#titlewrap #title" ).val('<?php echo $wpcargo->create_shipment_number(); ?>');
					});
				</script>
			<?php
		}
	}
	public function excluded_meta_keys(){
		$excluded_meta_keys = array(
									'wpc_metabox_nonce',
									'save',
									'_wpnonce',
									'_wp_http_referer',
									'user_ID',
									'action',
									'originalaction',
									'post_author',
									'post_type',
									'original_post_status',
									'referredby',
									'_wp_original_http_referer',
									'post_ID',
									'meta-box-order-nonce',
									'closedpostboxesnonce',
									'post_title',
									'hidden_post_status',
									'post_status',
									'hidden_post_password',
									'hidden_post_visibility',
									'visibility',
									'post_password',
									'original_publish',
									'original_publish',
									'status_date',
									'status_time',
									'status_location',
									'status_remarks',
									'wpcargo_status',
									'wpcargo_shipments_update'
								);
		return $excluded_meta_keys;
	}
	/**
	* Handles saving the meta box.
	* @param int     $post_id Post ID.
	* @param WP_Post $post    Post object.
	* @return null
	*/
	public function save_metabox( $post_id ) {
		global $wpcargo;
		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['wpc_metabox_nonce'] ) ? $_POST['wpc_metabox_nonce'] : '';
		$nonce_action = 'wpc_metabox_action';
		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
			return;
		}
		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}
		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}
		//save the last status
		$get_last_status 		= get_post_meta($post_id, 'wpcargo_status', true);
		// Get all ecluded meta keys in saving post meta
		$excluded_meta_keys = $this->excluded_meta_keys();
		if( isset( $_POST['wpcargo_employee'] ) && wpc_can_send_email_employee() ){
			$employee_assigned = get_post_meta( $post_id, 'wpcargo_employee', true ) ? get_post_meta( $post_id, 'wpcargo_employee', true ) : 0;
			if( $employee_assigned != $_POST['wpcargo_employee'] ){
				wpcargo_assign_shipment_email( $post_id, $_POST['wpcargo_employee'], 'Employee' );
			}
			update_post_meta( $post_id, 'wpcargo_employee', $_POST['wpcargo_employee'] );
		}
		if( isset( $_POST['agent_fields'] ) && wpc_can_send_email_agent() ){
			$agent_assigned = get_post_meta( $post_id, 'agent_fields', true ) ? get_post_meta( $post_id, 'agent_fields', true ) : 0;
			if( $agent_assigned != $_POST['agent_fields'] ){
				wpcargo_assign_shipment_email( $post_id, $_POST['agent_fields'], 'Agent' );
			}
		}
		if( isset( $_POST['registered_shipper'] ) && wpc_can_send_email_client() ){
			$client_assigned = get_post_meta( $post_id, 'registered_shipper', true ) ? get_post_meta( $post_id, 'registered_shipper', true ) : 0;
			if( $client_assigned != $_POST['registered_shipper'] ){
				wpcargo_assign_shipment_email( $post_id, $_POST['registered_shipper'], 'Client' );
			}
		}
		foreach( $_POST as $key => $value ) {
			if( in_array( $key, $excluded_meta_keys ) ) {
				continue;
			}
			if( is_array( $value ) ) {
				$meta_value  = maybe_serialize( $value );
			} else {
				$meta_value  = sanitize_text_field( $value );
			}
			update_post_meta($post_id, $key, $meta_value);
		}
		$current_user 		= wp_get_current_user();
		$history_array = array();
		foreach( wpcargo_history_fields() as $field_name => $field_value ){
			if( $field_name != 'updated-name' ){
				$history_array[$field_name] = $_POST[$field_name];
			}
		}
		$history_array['updated-name'] = $wpcargo->user_fullname( $current_user->ID );
		// Make sure that it is set.
		$new_history = apply_filters( 'wpcargo_shipment_history_before_save', $history_array, $_POST );
		if( isset( $_POST['status'] ) && $_POST['status'] != '' ){
			if( array_key_exists( 'wpcargo_shipments_update', $_POST ) ){
				$wpcargo_shipments_update = $_POST['wpcargo_shipments_update'];
				$wpcargo_shipments_update[] = $new_history;
			}else{
				$wpcargo_shipments_update = maybe_unserialize( get_post_meta( $post_id, 'wpcargo_shipments_update', true ) );
				$wpcargo_shipments_update[] = $new_history;
			}
			update_post_meta($post_id, 'wpcargo_status', $_POST['status'] );
		}else{
			if( array_key_exists( 'wpcargo_shipments_update', $_POST ) ){
				$wpcargo_shipments_update = $_POST['wpcargo_shipments_update'];
			}
		}
		update_post_meta($post_id, 'wpcargo_shipments_update', maybe_serialize( $wpcargo_shipments_update ) );
		
	}
	public function wpc_mp_metabox_callback($post) {
		wp_nonce_field( 'wpc_mp_inner_custom_box', 'wpc_mp_inner_custom_box_nonce' );
		wpcargo_admin_include_template( 'package-metabox.tpl', $post );
	}
	public function wpc_sh_metabox_callback($post){
		global $wpdb, $wpcargo;
		$current_user 			= wp_get_current_user();
		$shipments 				= maybe_unserialize( get_post_meta( $post->ID, 'wpcargo_shipments_update', true ) );
		$gen_settings 			= $wpcargo->settings;
		$edit_history_role 		= ( array_key_exists( 'wpcargo_edit_history_role', $gen_settings ) ) ? $gen_settings['wpcargo_edit_history_role'] : array();
		$role_intersected 		= array_intersect( $current_user->roles, $edit_history_role );
		$shmap_active 			= get_option('shmap_active');
		$shmap_api      		= trim( get_option('shmap_api') );
		if( $shmap_active && !empty( $shmap_api ) ){
			?>
			<div id="shmap-wrapper" style="margin: 12px 0;">
			<div id="wpcargo-shmap" style="height: 320px;"></div>
			</div>
			<?php
		}
		if( !empty( $role_intersected ) ){
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipment-history-editable.tpl.php' );
		}else{
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/shipment-history.tpl.php' );
		}
	}
	public function wpc_sd_metabox_callback($post) {
		wpcargo_admin_include_template( 'assign-metabox.tpl', $post );
	}
	public function wpcargo_shipment_history_email_template($post_id){
		global $wpcargo;
		if( isset( $_POST['status'] )  && !empty( trim( $_POST['status'] ) ) ){
			do_action( 'wpc_add_sms_shipment_history', $post_id );
			$new_status 	= sanitize_text_field( $_POST['status'] );
			$old_status     = get_post_meta($post_id, 'wpcargo_status', true);
			update_post_meta( $post_id, 'wpcargo_status', $new_status );
			if( $new_status != $old_status ){	
				wpcargo_send_email_notificatio( $post_id, $new_status );
			}
		}
	}
	public function wpcargo_set_content_type( $content_type ) {
		return 'text/html';
	}
	public function wpc_custom_login_redirect( $redirect_to ) {
		$current_user = wp_get_current_user();
		if ( in_array( 'wpcargo_client', $current_user->roles ) ) {
			$redirect_to = get_permalink( get_page_by_path( 'my-account' ) );
		}
		return $redirect_to;
	}
	function wpc_remove_admin_bar() { 
		if (!current_user_can('edit_posts')) { 
			show_admin_bar(false);
		}
	}
	function wpc_blockusers_init() {
		if ( ! current_user_can( 'edit_posts' ) && ( ! wp_doing_ajax() ) ) {
			wp_safe_redirect( site_url() ); 
			exit;
		}
	}
}
$wpcargo_metabox = new WPCargo_Metabox();