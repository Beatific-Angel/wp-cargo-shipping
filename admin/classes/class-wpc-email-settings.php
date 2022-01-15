<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
class WPCargo_Email_Settings{
	private $text_domain = 'wpcargo';
	function __construct(){
	add_action('admin_menu', array( $this, 'add_email_settings_menu' ) );
	//call register settings function
	add_action( 'admin_init', array( $this, 'register_wpcargo_mail_settings') );
	}
	public function add_email_settings_menu(){
		add_submenu_page(
			'wpcargo-settings',
			wpcargo_client_email_settings_label(),
			wpcargo_client_email_settings_label(),
			'manage_options',
			'wpcargo-email-settings',
			array( $this, 'client_email_settings_menu_callback' )
		);
		add_submenu_page(
			'wpcargo-settings',
			wpcargo_admin_email_settings_label(),
			wpcargo_admin_email_settings_label(),
			'manage_options',
			'wpcargo-admin-email-settings',
			array( $this, 'admin_email_settings_menu_callback' )
		);
	}
	public function admin_email_settings_menu_callback(){
		global $wpcargo;
		$wpcargo_admin_mail_active 	= get_option('wpcargo_admin_mail_active');
		$wpcargo_admin_mail_status	= $wpcargo->admin_mail_status;
		$wpcargo_admin_mail_domain	= get_option('wpcargo_admin_mail_domain');
		$wpcargo_admin_mail_to		= get_option('wpcargo_admin_mail_to');
		$wpcargo_admin_mail_subject	= get_option('wpcargo_admin_mail_subject');
		$wpcargo_admin_mail_body	= get_option('wpcargo_admin_mail_body');
		$wpcargo_admin_mail_footer	= get_option('wpcargo_admin_mail_footer');
		$mail_status 				= $wpcargo->mail_status;
		$email_meta_tags 			= wpcargo_email_shortcodes_list();
		?>
	    <div class="wrap">
	        <h1><?php echo wpcargo_admin_email_settings_label(); ?></h1>
	        <style type="text/css">
	        	table#email_meta_tags{
	        		width: 100%;
	        	}
	        	table#email_meta_tags, table#email_meta_tags tr td,table#email_meta_tags tr th{
	        		border:1px solid #000;
	        		border-collapse: collapse;
	        	}
	        </style>
	        <?php
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/admin-navigation.tpl.php' );
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/admin-email-settings-option.tpl.php' );
		?>
	    </div>
	        <?php
	}
	public function client_email_settings_menu_callback(){
		global $wpcargo;
		$options 			= get_option('wpcargo_mail_settings');
		$page_options 		= get_option('wpcargo_email_page_settings');
		$wpcargo_mail_admin	= get_option('wpcargo_mail_admin');
		$wpcargo_mail_domain	= get_option('wpcargo_mail_domain');
		$mail_status 		= $wpcargo->mail_status;
		$email_meta_tags 	= wpcargo_email_shortcodes_list();
		?>
	    <div class="wrap">
	        <h1><?php echo wpcargo_client_email_settings_label(); ?></h1>
	        <style type="text/css">
	        	table#email_meta_tags{
	        		width: 100%;
	        	}
	        	table#email_meta_tags, table#email_meta_tags tr td,table#email_meta_tags tr th{
	        		border:1px solid #000;
	        		border-collapse: collapse;
	        	}
	        </style>
	        <?php
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/admin-navigation.tpl.php' );
			require_once( WPCARGO_PLUGIN_PATH.'admin/templates/email-settings-option.tpl.php' );
		?>
	    </div>
	        <?php
	}
	function register_wpcargo_mail_settings() {
		//Register Client Email Settings
		register_setting( 'wpcargo_mail_settings', 'wpcargo_mail_settings' );
		register_setting( 'wpcargo_mail_settings', 'wpcargo_mail_domain' );
		register_setting( 'wpcargo_mail_settings', 'wpcargo_mail_admin' );
		register_setting( 'wpcargo_mail_settings', 'wpcargo_mail_status' );
		register_setting( 'wpcargo_mail_settings', 'wpcargo_email_page_settings' );
		register_setting( 'wpcargo_mail_settings', 'wpcargo_email_cc' );
		register_setting( 'wpcargo_mail_settings', 'wpcargo_email_bcc' );
		//Register Admin Email Settings
		register_setting( 'wpcargo_admin_mail_settings', 'wpcargo_admin_mail_active' );
		register_setting( 'wpcargo_admin_mail_settings', 'wpcargo_admin_mail_status' );
		register_setting( 'wpcargo_admin_mail_settings', 'wpcargo_admin_mail_domain' );
		register_setting( 'wpcargo_admin_mail_settings', 'wpcargo_admin_mail_to' );
		register_setting( 'wpcargo_admin_mail_settings', 'wpcargo_admin_mail_subject' );
		register_setting( 'wpcargo_admin_mail_settings', 'wpcargo_admin_mail_body' );
		register_setting( 'wpcargo_admin_mail_settings', 'wpcargo_admin_mail_footer' );
	}
}
new WPCargo_Email_Settings;