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

namespace ThePluginName\Common;

use ThePluginName\App\Frontend\Templates;
use ThePluginName\Common\Abstracts\Base;

/**
 * Main function class for external uses
 *
 * @see the_plugin_name()
 * @package ThePluginName\Common
 */
class Functions extends Base {
	/**
	 * Get plugin data by using the_plugin_name()->getData()
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function getData(): array {
		return $this->plugin->data();
	}

	/**
	 * Get the template instantiated class using the_plugin_name()->templates()
	 *
	 * @return Templates
	 * @since 1.0.0
	 */
	public function templates(): Templates {
		return new Templates();
	}
}
