<?php
if (!defined('ABSPATH')){
	exit; // Exit if accessed directly
}
//** Admin
require_once( WPCARGO_PLUGIN_PATH.'admin/includes/functions.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/includes/filters.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/includes/ajax-handler.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/includes/hooks.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-admin.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-admin-scripts.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-metabox.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-custom-table.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-print-admin.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-mp-settings.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-export-extend.php' );
//** User Class
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-user.php' );
//** Shipment Map
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-shipment-map.php' );
//** Admin settings
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-admin-settings.php' );
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-email-settings.php' );
//** Create post type
require_once( WPCARGO_PLUGIN_PATH.'admin/classes/class-wpc-post-types.php' );