<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class WPC_Shipment_History_Map{
	function __construct(){
		add_action( 'admin_enqueue_scripts', array( $this,'admin_scripts' ) );
		//** Settings
		add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'admin_init', array($this, 'plugin_init') );
		add_action( 'wpc_add_settings_nav', array( $this, 'settings_navigation' ) );
	}
	function admin_menu(){
		add_submenu_page(
			'wpcargo-settings',
			wpcargo_map_settings_label(),
			wpcargo_map_settings_label(),
			'manage_options',
			'admin.php?page=wpc-shmap-settings'
		);
		add_submenu_page(
			NULL,
			wpcargo_map_settings_label(),
			wpcargo_map_settings_label(),
			'manage_options',
			'wpc-shmap-settings',
			array( $this, 'map_settings_callback' )
		);
	}
	function plugin_init(){
		register_setting( 'wpc_shmap_option_group', 'shmap_api' );
		register_setting( 'wpc_shmap_option_group', 'shmap_active' );
		register_setting( 'wpc_shmap_option_group', 'shmap_type' );
		register_setting( 'wpc_shmap_option_group', 'shmap_zoom' );
		register_setting( 'wpc_shmap_option_group', 'shmap_result' );
		register_setting( 'wpc_shmap_option_group', 'shmap_label_color' );
		register_setting( 'wpc_shmap_option_group', 'shmap_label_size' );
		register_setting( 'wpc_shmap_option_group', 'shmap_marker' );
		register_setting( 'wpc_shmap_option_group', 'shmap_country_restrict' );
		register_setting( 'wpc_shmap_option_group', 'shmap_longitude' );
		register_setting( 'wpc_shmap_option_group', 'shmap_latitude' );
	}
	function settings_navigation(){
		$view = $_GET['page'];
		?>
		<a class="nav-tab <?php echo ( $view == 'wpc-shmap-settings') ? 'nav-tab-active' : '' ;  ?>" href="<?php echo admin_url().'admin.php?page=wpc-shmap-settings'; ?>" ><?php echo wpcargo_map_settings_label(); ?></a>
		<?php
	}
	function map_settings_callback(){
		$shmap_api 		= get_option('shmap_api');
		$shmap_active 	= get_option('shmap_active');
		$shmap_type 	= get_option('shmap_type');
		$shmap_zoom 	= get_option('shmap_zoom');
		$shmap_result 	= get_option('shmap_result');
		$shmap_label_color 	= get_option('shmap_label_color');
		$shmap_label_size 	= get_option('shmap_label_size');
		$shmap_marker 	= get_option('shmap_marker');
		$shmap_country_restrict 	= get_option('shmap_country_restrict');
		$shmap_longitude 	= !empty(get_option('shmap_longitude') ) ? get_option('shmap_longitude') : -87.65;
		$shmap_latitude 	= !empty(get_option('shmap_latitude') )  ? get_option('shmap_latitude') : 41.85;
		?>
		<div class="wrap">
        	<h1><?php echo wpcargo_map_settings_label(); ?></h1>
            <?php require_once( WPCARGO_PLUGIN_PATH.'admin/templates/admin-navigation.tpl.php' ); ?>
			<div class="postbox">
				<div class="inside">
					<?php require_once( WPCARGO_PLUGIN_PATH.'admin/templates/history-map-settings.tpl.php' ); ?>
				</div>
			</div>
		</div>
        <?php
	}
	function admin_scripts(){
		$screen 		= get_current_screen();
		$shmap_active 	= get_option('shmap_active');
		if( $screen->post_type == 'wpcargo_shipment' && $screen->base == 'post' && $shmap_active ){
			wp_enqueue_style( 'wpc-shmap-styles', WPCARGO_PLUGIN_URL.'admin/assets/css/shmap-style.css', array(), WPCARGO_VERSION, true );
		}
	}
}
new WPC_Shipment_History_Map;