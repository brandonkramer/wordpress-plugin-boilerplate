<?php
/**
 * {{The Plugin Name}}
 *
 * @package   {{the-plugin-name}}
 * @author    {{author_name}} <{{author_email}}>
 * @copyright {{author_copyright}}
 * @license   {{author_license}}
 * @link      {{author_url}}
 */

declare( strict_types = 1 );

namespace ThePluginName\App\Cli;

use ThePluginName\Common\Abstracts\Base;

/**
 * Class Example
 *
 * @package ThePluginName\App\Cli
 * @since 1.0.0
 */
class Example extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This class is only being instantiated if WP_Cli is defined in the requester as requested in the Bootstrap class
		 *
		 * @see Requester::isCli()
		 * @see Bootstrap::__construct
		 */
		if ( class_exists( \WP_CLI ) ) {
			\WP_CLI::add_command( 'plugin_commandname', [ $this, 'commandExample' ] );
		}
	}

	/**
	 * Example command
	 * API reference: https://wp-cli.org/docs/internal-api/
	 *
	 * @param array $args The attributes.
	 * @return void
	 * @since 1.0.0
	 */
	public function commandExample( array $args ) {
		// Message prefixed with "Success: ".
		\WP_CLI::success( $args[0] );
		// Message prefixed with "Warning: ".
		\WP_CLI::warning( $args[0] );
		// Message prefixed with "Debug: ". when '--debug' is used
		\WP_CLI::debug( $args[0] );
		// Message prefixed with "Error: ".
		\WP_CLI::error( $args[0] );
		// Message with no prefix
		\WP_CLI::log( $args[0] );
		// Colorize a string for output
		\WP_CLI::colorize( $args[0] );
		// Halt script execution with a specific return code
		\WP_CLI::halt( $args[0] );
	}
}
