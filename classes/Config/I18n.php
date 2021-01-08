<?php
/**
 * The Plugin Name Plugin
 *
 * @package   Plugin_Name
 * @author    {{author_name}} <{{author_email}}>
 * @copyright {{author_copyright}}
 * @license   {{author_license}}
 * @link      {{author_url}}
 */

namespace ThePluginName\Config;

use ThePluginName\Common\Abstracts\Base;

/**
 * Internationalization and localization definitions
 *
 * @package ThePluginName\Config
 * @since 1.0.0
 */
final class I18n extends Base
{
    /**
     * Load the plugin text domain for translation
     * @docs https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/#loading-text-domain
     *
     * @since 1.0.0
     */
    public function load ()
    {
        load_plugin_textdomain(
            $this->plugin->textDomain(),
            false,
            dirname( plugin_basename( _THE_PLUGIN_NAME_PLUGIN_FILE ) ) . '/languages'
        );
    }

}