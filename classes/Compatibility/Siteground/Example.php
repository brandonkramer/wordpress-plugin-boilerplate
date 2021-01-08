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

namespace ThePluginName\Compatibility\Siteground;

use ThePluginName\Bootstrap;

/**
 * Class Example
 *
 * @package ThePluginName\Compatibility\Siteground
 * @since 1.0.0
 */
class Example
{

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public function init ()
    {
        /**
         * Add 3rd party compatibility code here.
         * Compatibility classes instantiates after anything else
         *
         * @see Bootstrap::__construct
         */
        add_filter( 'sgo_css_combine_exclude', [ $this, 'excludeCssCombine' ] );
    }

    /**
     * Siteground optimizer compatibility.
     *
     * @param array $exclude_list
     *
     * @return array
     */
    public function excludeCssCombine ( array $exclude_list ): array
    {
        $exclude_list[] = 'plugin-name-frontend-css';

        return $exclude_list;
    }
}