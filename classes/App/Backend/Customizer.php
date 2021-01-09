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

namespace ThePluginName\App\Backend;

use WP_Customize_Manager;
use ThePluginName\Common\Abstracts\Base;

/**
 * Class Customizer
 *
 * @package ThePluginName\App\Backend
 * @since 1.0.0
 */
class Customizer extends Base {
	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 *
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here
		 */
		add_action( 'customize_register', [ $this, 'registerControls' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueuePreviewJs' ] );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 * Setup JS integration for live previewing.
	 *
	 * @since 1.0.0
	 */
	public function enqueuePreviewJs() {
		wp_enqueue_script(
			'plugin_test_customizer',
			plugins_url( '/assets/public/js/customizer.js', _THE_PLUGIN_NAME_PLUGIN_FILE ), // phpcs:disable ImportDetection.Imports.RequireImports.Symbol -- this constant is global
			[ 'customize-preview' ],
			$this->plugin->version(),
			true
		);
	}

	/**
	 * Register individual controllers through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 * @since 1.0.0
	 */
	public function registerControls( WP_Customize_Manager $wp_customize ) {
		// Add support for instant previewing of the built-in 'blogname' and 'blogdescription' options
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		// Create a section for related posts
		$wp_customize->add_section( 'related_posts_section', [
			'title'           => __( 'Related posts', 'the-plugin-name-text-domain' ), // required
			'priority'        => 160, // optional (default is 160)
			// Display this only on single posts
			'active_callback' => function (): bool {
				return is_single(); // is_single(), is_page() type checks need to be inside a callback function
			},
		] );
		// Add the setting for the number of related posts
		$wp_customize->add_setting( 'related_posts_number', [
			'transport'         => 'postMessage', // required for selective refresh, default is 'refresh'
			'sanizite_callback' => 'absint', // this can be the name of a function or an anonymous function
			'default'           => 3,
		] );
		// Add a control for the related posts setting
		$wp_customize->add_control( 'related_posts_number', [
			'type'    => 'number', // any HTML5 input type, select, textarea, dropdown-pages
			'section' => 'related_posts_section', // Required, core or custom.
			'label'   => __( 'Number of posts to show', 'the-plugin-name-text-domain' ),
		] );
		// Register a partial for selectively updating the related posts component
		$wp_customize->selective_refresh->add_partial( 'related_posts_number', [
			'selector'            => '.related-posts-container',
			'container_inclusive' => false,
			'render_callback'     => function () {
				$this->displayRelatedPosts(); // you can use this same function in your template
			},
		] );
	}

	/**
	 * Display related posts function
	 *
	 * @since 1.0.0
	 */
	public function displayRelatedPosts() {
		$related_posts = new \WP_Query( [
			'posts_per_page'      => absint( get_theme_mod( 'related_posts_number', 3 ) ),
			'category__in'        => wp_list_pluck( get_the_category(), 'term_id' ),
			'ignore_sticky_posts' => true,
		] ); ?>
		<?php if ( $related_posts->have_posts() ) : ?>
			<div class="related-posts-container">
				<h2><?php esc_html_e( 'Related posts', 'the-plugin-name-text-domain' ); ?></h2>
				<ul class="related-posts-list">
					<?php while ( $related_posts->have_posts() ) : ?>
						<?php $related_posts->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php
		wp_reset_postdata();
	}
}
