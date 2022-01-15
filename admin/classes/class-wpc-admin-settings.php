<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WPCargo_Admin_Settings{
	private $text_domain = 'wpcargo';
	function __construct(){
		add_action('admin_menu', array( $this, 'add_settings_menu' ), 10 );
		//call register settings function
		add_action( 'admin_init', array( $this,'register_wpcargo_option_settings') );
	}
	public function add_settings_menu(){
		global $wpcargo;
		add_menu_page(
			wpcargo_brand_name(),
			wpcargo_brand_name(),
			'manage_options',
			'wpcargo-settings',
			array( $this, 'add_settings_menu_callback' ),
			'dashicons-book-alt',
			6
		);
		add_submenu_page(
			'wpcargo-settings',
			wpcargo_general_settings_label(),
			wpcargo_general_settings_label(),
			'manage_options',
			'wpcargo-settings'
		);
	}
	function register_wpcargo_option_settings() {
		//register our settings
		register_setting( 'wpcargo_option_settings_group', 'wpcargo_option_settings' );
		register_setting( 'wpcargo_option_settings_group', 'wpcargo_page_settings' );
		register_setting( 'wpcargo_option_settings_group', 'wpcargo_label_header' );
		register_setting( 'wpcargo_option_settings_group', 'wpcargo_user_timezone' );
		register_setting( 'wpcargo_option_settings_group', 'wpcargo_title_numdigit' );
		register_setting( 'wpcargo_option_settings_group', 'wpcargo_title_suffix' );
		register_setting( 'wpcargo_option_settings_group', 'wpcargo_tax' );
	}
	public function add_settings_menu_callback() {
		global $wpcargo;
		$options 					= get_option('wpcargo_option_settings');
		$page_options 				= get_option('wpcargo_page_settings');
		$wpcargo_title_numdigit 	= $wpcargo->number_digit;
		$wpcargo_title_suffix 		= $wpcargo->suffix;
		$tax 	= $wpcargo->tax;
		?>
		<div class="wpcargo-settings">
		  <div class="wrap" id="wpc-left">
		    <h1><?php echo wpcargo_brand_name(); ?> <?php esc_html_e('Settings', 'wpcargo'); ?></h1>
		    <?php
				require_once( WPCARGO_PLUGIN_PATH.'admin/templates/admin-navigation.tpl.php' );
				require_once( WPCARGO_PLUGIN_PATH.'admin/templates/settings-option.tpl.php' );
			?>
			 </div>
			  <div class="wrap" id="wpc-right"> <a href="http://www.wpcargo.com/documentation/" target="_blank" class="wpc-documentation">
			    <div class="wpc-img"> <img src="<?php echo WPCARGO_PLUGIN_URL.'/admin/assets/images/documentation.png'; ?>" /> </div>
			    <div class="wpc-desc">
			      <h3><?php esc_html_e('Get Started Here', 'wpcargo'); ?></h3>
			      <p><?php esc_html_e('Documentation', 'wpcargo'); ?></p>
			    </div>
			    </a> <a href="http://www.wpcargo.com/purchase/" target="_blank" class="wpc-add-ons">
			    <div class="wpc-img"> </div>
			    <div class="wpc-desc">
			      <h3><?php esc_html_e('Add Ons', 'wpcargo'); ?></h3>
			      <p><?php esc_html_e('More Info', 'wpcargo'); ?></p>
			    </div>
			    </a> <a href="https://www.facebook.com/wpcargo/" target="_blank" class="wpc-facebook">
			    <div class="wpc-img"> </div>
			    <div class="wpc-desc">
			      <h3><?php esc_html_e('Facebook', 'wpcargo'); ?></h3>
			      <p><?php esc_html_e('Like our page', 'wpcargo'); ?></p>
			    </div>
			    </a> <a href="http://www.wpcargo.com/" target="_blank" class="wpc-get-support">
			    <div class="wpc-img"> </div>
			    <div class="wpc-desc">
			      <h3><?php esc_html_e('Get Support', 'wpcargo'); ?></h3>
			      <p><?php esc_html_e('Contact Us', 'wpcargo'); ?></p>
			    </div>
			    </a> <a href="http://www.wptaskforce.com/" target="_blank" class="wpc-get-website-hosting">
			    <div class="wpc-img"> </div>
			    <div class="wpc-desc">
			      <h3><?php esc_html_e('Get Website Hosting', 'wpcargo'); ?></h3>
			      <p><?php esc_html_e('Free Website Design', 'wpcargo'); ?></p>
			    </div>
			    </a>
		  </div>
		</div>
		<?php
	}
}
new WPCargo_Admin_Settings;