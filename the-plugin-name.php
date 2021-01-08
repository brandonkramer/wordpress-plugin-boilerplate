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

/**
 * 1. Define the default root file path of the plugin
 * 2. Require composer's PSR4 autoloader
 * 3. Hook in our activation/deactivation/uninstall setup classes
 * 4. Init the bootstrap class
 */

/*
|--------------------------------------------------------------------------
| Define the default root file and path of the plugin
|--------------------------------------------------------------------------
*/
define( '_THE_PLUGIN_NAME_PLUGIN_FILE', __FILE__ );
define( '_THE_PLUGIN_NAME_PLUGIN_ROOT', plugin_dir_path( _THE_PLUGIN_NAME_PLUGIN_FILE ) );

/*
|--------------------------------------------------------------------------
| Load PSR4 autoloader
|--------------------------------------------------------------------------
*/
if ( !file_exists( $_the_plugin_name_autoloader = _THE_PLUGIN_NAME_PLUGIN_ROOT . '/vendor/autoload.php' ) ) {
    wp_die( __( 'The Plugin Name is unable to locate autoloader.', 'the-plugin-name-text-domain' ) );
}
$_the_plugin_name_autoloader = require_once( $_the_plugin_name_autoloader );

/*
|--------------------------------------------------------------------------
| Setup hooks (activation, deactivation, uninstall)
|--------------------------------------------------------------------------
*/
register_activation_hook( __FILE__, [ 'ThePluginName\Config\Setup', 'activation' ] );
register_deactivation_hook( __FILE__, [ 'ThePluginName\Config\Setup', 'deactivation' ] );
register_uninstall_hook( __FILE__, [ 'ThePluginName\Config\Setup', 'uninstall' ] );

/*
|--------------------------------------------------------------------------
| Bootstrap the plugin
|--------------------------------------------------------------------------
*/
if ( !class_exists( '\ThePluginName\Bootstrap' ) ) {
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

/*
|--------------------------------------------------------------------------
| Create a main function for external uses
|--------------------------------------------------------------------------
*/
function the_plugin_name (): \ThePluginName\Common\Functions
{
    /**
     * @see \ThePluginName\Common\Functions
     */
    return new \ThePluginName\Common\Functions();
}