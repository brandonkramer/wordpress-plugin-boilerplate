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
?>
<p>
    <?php
    /**
     * @see \ThePluginName\App\Frontend\Templates
     * @var $args
     */
    echo __( 'This is being loaded inside "wp_footer" from the templates class', 'the-plugin-name-text-domain' ) . ' ' . $args[ 'data' ][ 'text' ];
    ?>
</p>
