<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class WPC_MP_Settings {
	public function __construct(){
		add_action( 'admin_menu', array($this, 'mp_add_admin_menu') );
		add_action( 'admin_init', array($this, 'wpc_mp_settings_init') );
		add_action('wpc_add_settings_nav', array( $this, 'wpc_mp_add_settings_nav') );
	}
	public function mp_add_admin_menu() {
		add_submenu_page( 'wpcargo-settings', esc_html__( 'Multiple Package Settings', 'wpcargo' ), esc_html__( 'Multiple Package Settings', 'wpcargo' ), 'manage_options', 'admin.php?page=wpc-multiple-package');
		add_submenu_page( NULL, 'Multiple Package Settings', 'Multiple Package Settings', 'manage_options', 'wpc-multiple-package', array($this, 'mp_options_page') );
	}
	public function wpc_mp_settings_init(  ) {
		register_setting( 'wpc_mp_pluginPage', 'wpc_mp_settings' );
		add_settings_section(
			'wpc_mp_pluginPage_section',
			'',
			array($this, 'wpc_mp_settings_section_callback'),
			'wpc_mp_pluginPage'
		);
		add_settings_field(
			'wpc_mp_enable_admin',
			esc_html__( 'Enable Multiple Package on Admin?', 'wpcargo' ),
			array( $this, 'wpc_mp_enable_admin_render' ),
			'wpc_mp_pluginPage',
			'wpc_mp_pluginPage_section'
		);
		add_settings_field(
			'wpc_mp_enable_frontend',
			esc_html__( 'Enable Multiple Package on Results?', 'wpcargo' ),
			array( $this, 'wpc_mp_enable_frontend_render' ),
			'wpc_mp_pluginPage',
			'wpc_mp_pluginPage_section'
		);
		add_settings_field(
			'wpc_mp_enable_dimension_unit',
			esc_html__( 'Enable Dimension Unit?', 'wpcargo' ),
			array( $this, 'wpc_mp_enable_dimension_unit_render' ),
			'wpc_mp_pluginPage',
			'wpc_mp_pluginPage_section'
		);
		add_settings_field(
			'wpc_mp_dimension_unit',
			esc_html__( 'Dimension Unit', 'wpcargo' ),
			array( $this, 'wpc_mp_dimension_unit_render' ),
			'wpc_mp_pluginPage',
			'wpc_mp_pluginPage_section'
		);
		add_settings_field(
			'wpc_mp_weight_unit',
			esc_html__( 'Weight Unit', 'wpcargo' ),
			array( $this, 'wpc_mp_weight_unit_render' ),
			'wpc_mp_pluginPage',
			'wpc_mp_pluginPage_section'
		);
		add_settings_field(
			'wpc_mp_piece_type',
			esc_html__( 'Piece Type Selection', 'wpcargo' ),
			array( $this, 'wpc_mp_piece_type_render' ),
			'wpc_mp_pluginPage',
			'wpc_mp_pluginPage_section'
		);
	}
	public function wpc_mp_enable_admin_render(  ) {
	$options = get_option( 'wpc_mp_settings' );
		?>
		<input type='checkbox' name='wpc_mp_settings[wpc_mp_enable_admin]' <?php isset($options['wpc_mp_enable_admin']) ? checked( $options['wpc_mp_enable_admin'] , 1 ) : ''; ?> value='1'>
		<p><i><?php esc_html_e('If checked you will enable the multiple package on your shipment admin dashboard.', 'wpcargo' ); ?></i></p>
		<?php
	}
	public function wpc_mp_enable_frontend_render(  ) {
	$options = get_option( 'wpc_mp_settings' );
		?>
		<input type='checkbox' name='wpc_mp_settings[wpc_mp_enable_frontend]' <?php isset($options['wpc_mp_enable_frontend']) ? checked( $options['wpc_mp_enable_frontend'], 1 ) : ''; ?> value='1'>
		<p><i><?php esc_html_e('If checked you will enable the multiple package on your shipment results.', 'wpcargo'); ?></i></p>
		<?php
	}
	public function wpc_mp_enable_dimension_unit_render(  ) {
	$options = get_option( 'wpc_mp_settings' );
		?>
		<input type='checkbox' name='wpc_mp_settings[wpc_mp_enable_dimension_unit]' <?php isset($options['wpc_mp_enable_dimension_unit']) ? checked( $options['wpc_mp_enable_dimension_unit'], 1 ) : ''; ?> value='1'>
		<p><i><?php esc_html_e('If checked you will enable the dimension unit.', 'wpcargo'); ?></i></p>
		<?php
	}
	public function wpc_mp_dimension_unit_render() {
	$options = get_option( 'wpc_mp_settings' );
		?>
		<input type='text' name='wpc_mp_settings[wpc_mp_dimension_unit]' value='<?php echo $options['wpc_mp_dimension_unit']; ?>'>
		<p><i><?php esc_html_e('This will be display in the package Dimension. Example: mm, cm, inch, etc. The default is cm.', 'wpcargo'); ?></i></p>
		<?php
	}
	public function wpc_mp_weight_unit_render() {
	$options = get_option( 'wpc_mp_settings' );
		?>
		<input type='text' name='wpc_mp_settings[wpc_mp_weight_unit]' value='<?php echo $options['wpc_mp_weight_unit']; ?>'>
		<p><i><?php esc_html_e('This will be display in the package Weight. Example: lbs, g, gr, kg, etc. The default is lbs.', 'wpcargo'); ?></i></p>
		<?php
	}
	public function wpc_mp_piece_type_render() {
	$options = get_option( 'wpc_mp_settings' );
		?>
		<textarea cols='40' rows='5' name='wpc_mp_settings[wpc_mp_piece_type]'><?php echo $options['wpc_mp_piece_type']; ?></textarea>
		<p><i><?php esc_html_e('This will be the selection for the Piece Type for the Package Information section. Comma separated ( Ex. Pallet, Carton, Crate, Loose, Others)', 'wpcargo'); ?></i></p>
		<?php
	}
	public function wpc_mp_settings_section_callback(  ) {
		echo '<p class="description">'.esc_html__( 'Settings for Multiple Package, please fill out the fields below.', 'wpcargo' ).'</p>';
	}
	public function mp_options_page(  ) {
		?><h1><?php esc_html_e('Multiple Package', 'wpcargo'); ?></h1><?php
		require_once( WPCARGO_PLUGIN_PATH.'admin/templates/admin-navigation.tpl.php' );
		?>
		<div class="postbox">
			<div class="inside">
				<form action='options.php' method='post'>
					<?php
					settings_fields( 'wpc_mp_pluginPage' );
					do_settings_sections( 'wpc_mp_pluginPage' );
					submit_button();
					?>
				</form>
			</div>
		</div>
		<?php
	}
	public function wpc_mp_add_settings_nav() {
		$view = $_GET['page'];
		?>
		<a class="nav-tab <?php echo ( $view == 'wpc-multiple-package') ? 'nav-tab-active' : '' ;  ?>" href="<?php echo admin_url().'admin.php?page=wpc-multiple-package'; ?>" ><?php esc_html_e('Multiple Package Settings', 'wpcargo'); ?></a>
		<?php
	}
}
$wpc_wpc_mp_settings = new WPC_MP_Settings;