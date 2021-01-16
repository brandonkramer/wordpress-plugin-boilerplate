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

namespace ThePluginName\Common\Traits;

use ThePluginName\Common\Utils\Errors;

/**
 * The requester trait to determine what we request; used to determine
 * which classes we instantiate in the Bootstrap class
 *
 * @see Bootstrap
 *
 * @package ThePluginName\Common\Traits
 * @since 1.0.0
 */
trait Requester {

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, cron, cli, amp or frontend.
	 * @return bool
	 * @since 1.0.0
	 */
	public function request( string $type ): bool {
		switch ( $type ) {
			case 'installing_wp':
				return $this->isInstallingWp();
			case 'frontend':
				return $this->isFrontend();
			case 'backend':
				return $this->isAdminBackend();
			case 'rest':
				return $this->isRest();
			case 'cron':
				return $this->isCron();
			case 'cli':
				return $this->isCli();
			default:
				Errors::wpDie(
					sprintf( /* translators: %s: request function */
						__( 'Unknown request type: %s', 'the-plugin-name-text-domain' ),
						$type
					),
					__( 'Classes are not being correctly requested', 'the-plugin-name-text-domain' ),
					__FILE__
				);
				return false;
		}
	}

	/**
	 * Is installing WP
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function isInstallingWp(): bool {
		return defined( 'WP_INSTALLING' );
	}

	/**
	 * Is frontend
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function isFrontend(): bool {
		return ! $this->isAdminBackend() && ! $this->isCron() && ! $this->isRest();
	}

	/**
	 * Is admin
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function isAdminBackend(): bool {
		return is_user_logged_in() && is_admin();
	}

	/**
	 * Is rest
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function isRest(): bool {
		return defined( 'REST_REQUEST' );
	}

	/**
	 * Is cron
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function isCron(): bool {
		return ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) || defined( 'DOING_CRON' );
	}

	/**
	 * Is cli
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function isCli(): bool {
		return defined( 'WP_CLI' ) && WP_CLI; // phpcs:disable ImportDetection.Imports.RequireImports.Symbol -- this constant is global
	}
}
