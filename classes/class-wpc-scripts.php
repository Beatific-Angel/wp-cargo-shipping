<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
class WPCargo_Scripts{
	function __construct(){
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'wp_print_styles', array( $this, 'dequeue_scripts' ), 100 );
	}
	function frontend_scripts(){
		global $post;
		$page_url = get_the_permalink( );
		// Styles
		wp_register_style('wpcargo-custom-bootstrap-styles', WPCARGO_PLUGIN_URL . 'assets/css/main.min.css', array(), WPCARGO_VERSION );
		wp_register_style('wpcargo-fontawesome-styles', WPCARGO_PLUGIN_URL . 'assets/css/fontawesome.min.css', array(), WPCARGO_VERSION );
		wp_register_style('wpcargo-styles', WPCARGO_PLUGIN_URL . 'assets/css/wpcargo-style.css', array(), WPCARGO_VERSION );	
		wp_register_style('wpcargo-datetimepicker', WPCARGO_PLUGIN_URL . 'admin/assets/css/jquery.datetimepicker.min.css', array(), WPCARGO_VERSION );
		wp_enqueue_style('wpcargo-custom-bootstrap-styles');
		wp_enqueue_style('wpcargo-fontawesome-styles');
		wp_enqueue_style('wpcargo-styles');	
		wp_enqueue_style( 'wpcargo-datetimepicker' );
		// Scripts
		$translation_array = array(
			'ajax_url'  => admin_url( 'admin-ajax.php' ),
			'pageURL' 	=> $page_url
		);
		wp_register_script( 'wpcargo-js', WPCARGO_PLUGIN_URL.'assets/js/wpcargo.js', array( 'jquery' ), WPCARGO_VERSION, false );
		wp_register_script( 'wpcargo-datetimepicker', WPCARGO_PLUGIN_URL . 'admin/assets/js/jquery.datetimepicker.full.min.js', array( 'jquery' ), WPCARGO_VERSION, false );
		wp_localize_script( 'wpcargo-js', 'wpcargoAJAXHandler', $translation_array );
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'wpcargo-js');
		wp_enqueue_script( 'wpcargo-datetimepicker' );
	}
	function dequeue_scripts(){
		// Dequeue Import / Export Add on Style
        wp_dequeue_style('wpc_import_export_css');
	}
}
new WPCargo_Scripts;
add_action('wp_head', function(){
	$options 		= get_option('wpcargo_option_settings');
	$baseColor 		= '#00A924';
	if( $options ){
		if( array_key_exists('wpcargo_base_color', $options) ){
			$baseColor = ( $options['wpcargo_base_color'] ) ? $options['wpcargo_base_color'] : $baseColor ;
		}
	}
	?>
	<style type="text/css">
		:root {
		  --wpcargo: <?php echo $baseColor; ?>;
		}
	</style>
	<?php
});