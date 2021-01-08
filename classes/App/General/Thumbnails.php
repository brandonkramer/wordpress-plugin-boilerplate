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

namespace ThePluginName\App\General;

use ThePluginName\Common\Abstracts\Base;

/**
 * Class Thumbnails
 *
 * @package ThePluginName\App\General
 * @since 1.0.0
 */
class Thumbnails extends Base
{


    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public function init ()
    {
        /**
         * This general class is always being instantiated as requested in the Bootstrap class
         *
         * @see Bootstrap::__construct
         *
         * Add plugin code here
         */
        add_image_size( 'small-test-preview', 30, 30 );
    }

}