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

namespace ThePluginName\Integrations\Widget;

use ThePluginName\Config\Plugin;
use WP_Widget;

/**
 * Class HTML_Widget
 *
 * @package ThePluginName\Integrations\Widget
 */
class HTML_Widget extends WP_Widget {

	/**
	 * @var array : will be filled with data from the plugin config class
	 * @see Plugin
	 */
	protected $plugin = [];

	/**
	 * Default instance.
	 *
	 * @var   array
	 */
	protected $default_instance = [
		'title'   => '',
		'content' => '',
	];

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * Integration classes instantiates before anything else
		 *
		 * @see Bootstrap::__construct
		 *
		 * Widget is registered via the app/general/widgets class, but it is also
		 * possible to register from this class
		 * @see Widgets
		 */
	}

	/**
	 * Sets up a new HTML widget instance.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin = Plugin::init();
		$widget_ops = [
			'classname'                   => 'widget_html',
			'description'                 => __( 'Displays HTML code with syntax highlighting.', 'the-plugin-name-text-domain' ),
			'customize_selective_refresh' => true,
		];
		$control_ops = [];
		parent::__construct( 'the-plugin-name-text-domain', __( 'HTML Test Widget', 'the-plugin-name-text-domain' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @param array $args Default widget arguments.
	 * @param array $instance Settings for the current instance.
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {

		$instance = array_merge( $this->default_instance, $instance );
		$content = $instance['content'];

		/**
		 * Filters the content of the HTML Code widget.
		 *
		 * @param string $content The widget content.
		 * @param array $instance Settings for the current widget.
		 * @since 0.1.0
		 */
		$content = apply_filters( 'the_plugin_name_html_widget_content', $content, $instance, $this );
		echo $args['before_widget'];
		echo $content;
		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @param array $new_instance New settings for this instance.
	 * @param array $old_instance Old settings for this instance.
	 * @return array $instance     Settings to save or bool false to cancel saving.
	 * @since 1.0.0
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance = array_merge( $this->default_instance, $old_instance );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['content'] = $new_instance['content'];
		} else {
			$instance['content'] = wp_kses_post( $new_instance['content'] );
		}
		return $instance;
	}

	/**
	 * Outputs the HTML Code widget settings form.
	 *
	 * @param array $instance Current widget instance.
	 * @return void
	 * @since 1.0.0
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->default_instance );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" class="screen-reader-text"><?php esc_html_e( 'Content:', 'the-plugin-name-text-domain' ); ?></label>
			<textarea class="widefat html-widget" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"><?php echo esc_textarea( $instance['content'] ); ?></textarea>
		</p>
		<?php
	}
}
