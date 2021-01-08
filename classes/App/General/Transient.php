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
 * Class Transient
 *
 * @package ThePluginName\App\General
 * @since 1.0.0
 */
class Transient extends Base
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
    }

    /**
     * Example
     *
     * @return array|string[]
     * @since 1.0.0
     */
    public function getExample (): array
    {
        $output = get_transient( 'plugin_example_transient' );

        if ( ( false !== $output ) && ( is_array( $output ) ) ) {
            // Return the array stored in the transient.
            return $output;
        }

        // Imaginary function to fetch data.
        $results = $this->exampleQuery();
        if ( is_array( $results ) ) {

            // Set our transient to expire in one hour.
            set_transient( 'plugin_example_transient', $results, HOUR_IN_SECONDS );
            return $results;
        }

        // At a minimum, return an empty array.
        return [];
    }

    /**
     * Example
     *
     * @return string[]
     * @since 1.0.0
     */
    public function exampleQuery (): array
    {
        return [
            'test'
        ];
    }
}