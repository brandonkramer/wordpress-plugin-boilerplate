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

namespace ThePluginName\App\Backend;

use ThePluginName\Common\Abstracts\Base;

/**
 * Class Notices
 *
 * @package ThePluginName\App\Backend
 * @since 1.0.0
 */
class Notices extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This backend class is only being instantiated in the backend as requested in the Bootstrap class
		 *
		 * @see Requester::isAdminBackend()
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here for admin notices specific functions
		 */
		add_action( 'admin_notices', [ $this, 'exampleAdminNotice' ] );
	}

	/**
	 * Example admin notice
	 *
	 * @since 1.0.0
	 */
	public function exampleAdminNotice() {
		global $pagenow;
		if ( $pagenow === 'options-general.php' ) {
			echo '<div class="notice notice-warning is-dismissible">
             <p>' . __( 'This is an example of a notice that appears on the settings page.', 'the-plugin-name-text-domain' ) . '</p>
         </div>';
		}
	}
}
