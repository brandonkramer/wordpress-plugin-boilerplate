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

namespace ThePluginName\App\Frontend;

use ThePluginName\Common\Abstracts\Base;

/**
 * Class FormFields
 *
 * @package ThePluginName\App\Frontend
 * @since 1.0.0
 */
class FormFields extends Base
{

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    public function init ()
    {
        /**
         * This frontend class is only being instantiated in the frontend as requested in the Bootstrap class
         *
         * @see Requester::isFrontend()
         * @see Bootstrap::__construct
         *
         * Add plugin code here for form fields specific functions
         */
        add_filter( 'woocommerce_form_field_args', [ $this, 'woocommerceFormFieldArgsExample' ], 10, 3 );
    }

    /**
     * Example
     *
     * @param $data
     * @param $key
     * @param $value
     * @return mixed
     * @since 1.0.0
     */
    public function woocommerceFormFieldArgsExample ( $data, $key, $value )
    {
        if ( 'billing_phone' === $key ) {
            $data[ 'custom_attributes' ][ 'pattern' ] = '^(\\(?\\+?[0-9]*\\)?)?[0-9_\\- \\(\\)]*$';
        }
        return $data;
    }
}