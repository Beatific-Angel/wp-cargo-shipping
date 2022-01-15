<?php
/*
 * Plugin Name: WPCargo
 * Plugin URI: http://wptaskforce.com/
 * Description: WPCargo is a WordPress plug-in designed to provide ideal technology solution for your Cargo and Courier Operations. Whether you are an exporter, freight forwarder, importer, supplier, customs broker, overseas agent, or warehouse operator, WPCargo helps you to increase the visibility, efficiency, and quality services of your cargo and shipment business.
 * Author: <a href="http://www.wptaskforce.com/">WPTaskForce</a>
 * Text Domain: wpcargo
 * Domain Path: /languages
 * Version: 6.4.10
 */
/*
	WPCargo - Track and Trace Plugin
	Copyright (C) 2015  WPTaskForce
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	WPCargo Copyright (C) 2015  WPTaskForce
	This program comes with ABSOLUTELY NO WARRANTY; for details type `show w'.
	This is free software, and you are welcome to redistribute it
	under certain conditions; type `show c' for details.
*/
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
	
	
//* Defined constant
define( 'WPCARGO_TEXTDOMAIN', 'wpcargo' );
define( 'WPCARGO_VERSION', '6.4.10' );
define( 'WPCARGO_FILE_DIR', __FILE__  );
define( 'WPCARGO_PLUGIN_URL', plugin_dir_url( WPCARGO_FILE_DIR ) );
define( 'WPCARGO_PLUGIN_PATH', plugin_dir_path( WPCARGO_FILE_DIR ) );
//** Include files
//** Admin
require_once( WPCARGO_PLUGIN_PATH.'admin/wpc-admin.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpcargo.php' );
//** Frontend
require_once( WPCARGO_PLUGIN_PATH.'/includes/packages.php' );
require_once( WPCARGO_PLUGIN_PATH.'/classes/class-wpc-scripts.php' );
require_once( WPCARGO_PLUGIN_PATH.'/classes/class-wpc-shortcode.php' );
require_once( WPCARGO_PLUGIN_PATH.'/classes/class-wpc-print.php' );
//** Load text Domain
add_action( 'plugins_loaded', array( 'WPC_Admin','wpcargo_load_textdomain' ) );
//** Run when plugin installation
//** Add user role
register_activation_hook( WPCARGO_FILE_DIR, array( 'WPC_Admin', 'add_user_role' ) );
register_deactivation_hook( WPCARGO_FILE_DIR, array( 'WPC_Admin', 'remove_user_role' ) );
//** Create track page
register_activation_hook( WPCARGO_FILE_DIR, array( 'WPC_Admin', 'add_wpc_custom_pages' ) );