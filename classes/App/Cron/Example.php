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

namespace ThePluginName\App\Cron;

use ThePluginName\Common\Abstracts\Base;
use ThePluginName\Common\Traits\Requester;


/**
 * Class Example
 *
 * @package ThePluginName\App\Cron
 * @since 1.0.0
 */
class Example extends Base
{

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public function init ()
    {
        /**
         * This class is only being instantiated if DOING_CRON is defined in the requester as requested in the Bootstrap class
         *
         * @see Requester::isCron()
         * @see Bootstrap::__construct
         */

        // add_action( 'wp', [ $this, 'activationDeactivationExample' ] );
        // add_action( 'plugin_cronjobs', [ $this, 'cronjobRepeatingFunctionExample' ] );
    }

    /**
     * Activates a scheduled event (if it does not exist already)
     *
     * @since 1.0.0
     */
    public function activationDeactivationExample ()
    {
        if ( !wp_next_scheduled( 'plugin_cronjobs' ) ) {
            wp_schedule_event( time(), 'daily', 'plugin_cronjobs' );
        } else {
            $timestamp = wp_next_scheduled( 'mycronjob' );
            wp_unschedule_event( $timestamp, 'mycronjob' );
        }
    }

    /**
     * The function that gets called with the scheduled event
     *
     * @since 1.0.0
     */
    public function cronjobRepeatingFunctionExample ()
    {
        // do here what needs to be done automatically as per schedule
    }
}