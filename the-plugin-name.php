<?php
/**
 * The Plugin Name Plugin
 *
 * @package   Plugin_Name
 * @author    {{author_name}} <{{author_email}}>
 * @copyright {{author_copyright}}
 * @license   {{author_license}}
 * @link      {{author_url}}
 *
 * Plugin Name:     The Plugin Name
 * Plugin URI:      https://the-plugin.com
 * Description:     The Plugin Description
 * Version:         0.0.1
 * Author:          The Plugin Author
 * Author URI:      https://the-plugin-author.com
 * Text Domain:     the-plugin-name-text-domain
 * Domain Path:     /languages
 * Requires PHP:    7.0
 * Requires WP:     5.5.0
 * Namespace:       ThePluginName
 */

declare( strict_types = 1 );

/**
 * Define the default root file of the plugin
 *
 * @since 1.0.0
 */
const _THE_PLUGIN_NAME_PLUGIN_FILE = __FILE__;

/**
 * Load PSR4 autoloader
 *
 * @since 1.0.0
 */
$_the_plugin_name_autoloader = plugin_dir_path( _THE_PLUGIN_NAME_PLUGIN_FILE ) . '/vendor/autoload.php';
require $_the_plugin_name_autoloader;

/**
 * Setup hooks (activation, deactivation, uninstall)
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, [ 'ThePluginName\Config\Setup', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'ThePluginName\Config\Setup', 'deactivation' ] );
register_uninstall_hook( __FILE__, [ 'ThePluginName\Config\Setup', 'uninstall' ] );

/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
if ( ! class_exists( '\ThePluginName\Bootstrap' ) ) {
	wp_die( __( 'The Plugin Name is unable to find the Bootstrap class.', 'the-plugin-name-text-domain' ) );
}
add_action(
	'plugins_loaded',
	static function () use ( $_the_plugin_name_autoloader ) {
		/**
		 * @see \ThePluginName\Bootstrap
		 */
		try {
			new \ThePluginName\Bootstrap( $_the_plugin_name_autoloader );
		} catch ( Exception $e ) {
			wp_die( __( 'The Plugin Name is unable to run the Bootstrap class.', 'the-plugin-name-text-domain' ) );
		}
	}
);

/**
 * Create a main function for external uses
 *
 * @return \ThePluginName\Common\Functions
 * @since 1.0.0
 */
function the_plugin_name_function(): \ThePluginName\Common\Functions {
	return new \ThePluginName\Common\Functions();
}
