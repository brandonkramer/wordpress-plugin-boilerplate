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

namespace ThePluginName\Common\Traits;

/**
 * The singleton skeleton trait to instantiate the class only once
 *
 * @package ThePluginName\Common\Traits
 * @since 1.0.0
 */
trait Singleton
{
    private static $instance;

    private final function __construct() {}
    private final function __clone() {}
    private final function __wakeup() {}

    /**
     * @return self
     * @since 1.0.0
     */
    public final static function init(): self
    {
        if(!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}