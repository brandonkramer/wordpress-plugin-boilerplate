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

declare( strict_types = 1 );

namespace ThePluginName\App\Rest;

use ThePluginName\Common\Abstracts\Base;

/**
 * Class Example
 *
 * @package ThePluginName\App\Rest
 * @since 1.0.0
 */
class Example extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This class is only being instantiated if REST_REQUEST is defined in the requester as requested in the Bootstrap class
		 *
		 * @see Requester::isRest()
		 * @see Bootstrap::__construct
		 */

		if ( class_exists( 'WP_REST_Server' ) ) {
			add_action( 'rest_api_init', [ $this, 'addPluginRestApi' ] );
		}
	}

	/**
	 * @since 1.0.0
	 */
	public function addPluginRestApi() {
		$this->addCustomField();
		$this->addCustomRoute();
	}

	/**
	 * Examples
	 *
	 * @since 1.0.0
	 */
	public function addCustomField() {
		register_rest_field(
			'demo',
			$this->plugin->textDomain() . '_text',
			[
				'get_callback'    => [ $this, 'getTextField' ],
				'update_callback' => [ $this, 'updateTextField' ],
				'schema'          => [
					'description' => __( 'Text field demo of Post type', 'the-plugin-name-text-domain' ),
					'type'        => 'string',
				],
			]
		);
	}

	/**
	 * Examples
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function addCustomRoute() {
		// Only an example with 2 parameters
		register_rest_route(
			'wp/v2',
			'/calc',
			[
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => [ $this, 'sum' ],
				'args'     => [
					'first'  => [
						'default'           => 10,
						'sanitize_callback' => 'absint',
					],
					'second' => [
						'default'           => 1,
						'sanitize_callback' => 'absint',
					],
				],
			]
		);
	}

	/**
	 * Examples
	 *
	 * @param array $post_obj Post ID.
	 * @return string
	 * @since 1.0.0
	 */
	public function getTextField( array $post_obj ): string {
		$post_id = $post_obj['id'];

		return get_post_meta( $post_id, $this->plugin->textDomain() . '_text', true );
	}

	/**
	 * Examples
	 *
	 * @param string $value Value.
	 * @param \WP_Post $post Post object.
	 * @param string $key Key.
	 * @return \WP_Error
	 * @since 1.0.0
	 */
	public function updateTextField( string $value, \WP_Post $post, string $key ): \WP_Error {
		$post_id = update_post_meta( $post->ID, $key, $value );

		if ( false === $post_id ) {
			return new \WP_Error(
				'rest_post_views_failed',
				\__( 'Failed to update post views.', 'the-plugin-name-text-domain' ),
				[ 'status' => 500 ]
			);
		}

		return true;
	}

	/**
	 * Examples
	 *
	 * @param array $data Values.
	 * @return array
	 * @since 1.0.0
	 */
	public function sum( array $data ): array {
		return [ 'result' => $data['first'] + $data['second'] ];
	}
}
