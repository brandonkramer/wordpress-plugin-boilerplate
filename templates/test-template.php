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
?>
<p>
    <?php
    /**
     * @see \ThePluginName\App\Frontend\Templates
     * @var $args
     */
    echo __( 'This is being loaded inside the footer from The Plugin Name in the templates class', 'the-plugin-text-domain' ) . ' ' . $args[ 'arbitrary_data' ][ 'text' ];
    ?>
</p>
