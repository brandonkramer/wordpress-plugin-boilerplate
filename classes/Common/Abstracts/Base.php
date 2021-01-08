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

namespace ThePluginName\Common\Abstracts;

use ThePluginName\Config\Plugin;

/**
 * The Base class which can be extended by other classes to load in default methods
 *
 * @package ThePluginName\Common\Abstracts
 * @since 1.0.0
 */
abstract class Base
{
    /**
     * @var array : will be filled with data from the plugin config class
     * @see Plugin
     */
    protected $plugin = [];

    /**
     * Base constructor.
     *
     * @since 1.0.0
     */
    public function __construct ()
    {
        $this->plugin = Plugin::init();
    }
}