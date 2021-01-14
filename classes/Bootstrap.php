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

namespace ThePluginName;

use ThePluginName\Common\Abstracts\Base;
use ThePluginName\Common\Traits\Requester;
use ThePluginName\Common\Utils\Errors;
use ThePluginName\Config\Classes;
use ThePluginName\Config\I18n;
use ThePluginName\Config\Requirements;

/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
final class Bootstrap extends Base {

	/**
	 * Determine what we're requesting
	 *
	 * @see Requester
	 */
	use Requester;

	/**
	 * Used to debug the Bootstrap class; this will print a visualised array
	 * of the classes that are loaded with the total execution time if set true
	 *
	 * @var array
	 */
	public $bootstrap = [ 'debug' => false ];

	/**
	 * List of class to init
	 *
	 * @var array : classes
	 */
	public $class_list = [];

	/**
	 * Composer autoload file list
	 *
	 * @var Composer\Autoload\ClassLoader
	 */
	public $composer;

	/**
	 * Requirements class object
	 *
	 * @var Requirements
	 */
	protected $requirements;

	/**
	 * I18n class object
	 *
	 * @var I18n
	 */
	protected $i18n;

	/**
	 * Bootstrap constructor that
	 * - Checks compatibility/plugin requirements
	 * - Defines the locale for this plugin for internationalization
	 * - Load the classes via Composer's class loader and initialize them on type of request
	 *
	 * @param \Composer\Autoload\ClassLoader $composer Composer autoload output.
	 * @throws \Exception
	 * @since 1.0.0
	 */
	public function __construct( $composer ) {
		parent::__construct();
		$this->startExecutionTimer();
		$this->checkRequirements();
		$this->setLocale();
		$this->getClassLoader( $composer );
		$this->loadClasses( Classes::get() );
		$this->debugger();
	}

	/**
	 * Check plugin requirements
	 *
	 * @since 1.0.0
	 */
	public function checkRequirements() {
		$set_timer = microtime( true );
		$this->requirements = new Requirements();
		$this->requirements->check();
		$this->bootstrap['check_requirements'] = $this->stopExecutionTimer( $set_timer );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since 1.0.0
	 */
	public function setLocale() {
		$set_timer = microtime( true );
		$this->i18n = new I18n();
		$this->i18n->load();
		$this->bootstrap['set_locale'] = $this->stopExecutionTimer( $set_timer );
	}

	/**
	 * Get the class loader from Composer
	 *
	 * @param $composer
	 * @since 1.0.0
	 */
	public function getClassLoader( $composer ) {
		$this->composer = $composer;
	}

	/**
	 * Initialize the requested classes
	 *
	 * @param $classes : The loaded classes.
	 * @since 1.0.0
	 */
	public function loadClasses( $classes ) {
		$set_timer = microtime( true );
		foreach ( $classes as $class ) {
			if ( isset( $class['on_request'] ) && is_array( $class['on_request'] )
			) {
				foreach ( $class['on_request'] as $on_request ) {
					if ( ! $this->request( $on_request ) ) {
						continue;
					}
				}
			} elseif ( isset( $class['on_request'] ) && ! $this->request( $class['on_request'] )
			) {
				continue;
			}
			$this->getClasses( $class['init'] );
		}
		$this->initClasses();
		$this->bootstrap['initialized_classes']['timer'] = $this->stopExecutionTimer( $set_timer, 'Total execution time of initialized classes' );
	}

	/**
	 * Init the classes
	 *
	 * @since 1.0.0
	 */
	public function initClasses() {
		$this->class_list = \apply_filters( 'the_plugin_name_initialized_classes', $this->class_list );
		foreach ( $this->class_list as $class ) {
			try {
				$set_timer = microtime( true );
				// phpcs:ignore NeutronStandard.Functions.VariableFunctions.VariableFunction
				$this->bootstrap['initialized_classes'][ $class ] = new $class();
				$this->bootstrap['initialized_classes'][ $class ]->init();
				$this->bootstrap['initialized_classes'][ $class ] = $this->stopExecutionTimer( $set_timer );
			} catch ( \Throwable $err ) {
				\do_action( 'the_plugin_name_class_initialize_failed', $err, $class );
				Errors::wpDie(
					sprintf(  /* translators: %s: php class namespace */
						__( 'Could not load class "%s". The "init" method is probably missing or try a `composer dumpautoload -o` to refresh the autoloader.',
							'the-plugin-name-text-domain'
						), $class
					),
					__( 'Plugin initialize failed', 'the-plugin-name-text-domain' ),
					__FILE__, $err
				);
			}
		}
	}

	/**
	 * Get classes based on the directory automatically using the Composer autoload
	 *
	 * @param string $namespace Class name to find.
	 * @return array Return the classes.
	 * @since 1.0.0
	 */
	public function getClasses( string $namespace ): array {
		$namespace = $this->plugin->namespace() . '\\' . $namespace;
		if ( is_object( $this->composer ) !== false ) {
			$classmap = $this->composer->getClassMap();

			// First we're going to try to load the classes via Composer's Autoload
			// which will improve the performance. This is only possible if the Autoloader
			// has been optimized.
			if ( isset( $classmap[ $this->plugin->namespace() . '\\Bootstrap' ] ) ) {
				if ( ! isset( $this->bootstrap['initialized_classes']['load_by'] ) ) {
					$this->bootstrap['initialized_classes']['load_by'] = 'Autoloader';
				}
				$classes = array_keys( $classmap );
				foreach ( $classes as $class ) {
					if ( 0 !== strncmp( (string) $class, $namespace, strlen( $namespace ) ) ) {
						continue;
					}
					$this->class_list[] = $class;
				}
				return $this->class_list;
			}
		}

		// If the composer.json file is updated then Autoloader is not optimized and we
		// can't load classes via the Autoloader. The `composer dumpautoload -o` command needs to
		// to be called; in the mean time we're going to load the classes differently which will
		// be a bit slower. The plugin needs to be optimized before production-release
		// Errors::writeLog(
		//    [
		//        'title'   => __( '{{The Plugin Name}} classes are not being loaded by Composer\'s Autoloader' ),
		//        'message' => __( 'Try a `composer dumpautoload -o` to optimize the autoloader that will improve the performance on autoloading itself.' )
		//    ]
		//);
		return $this->getByExtraction( $namespace );
	}

	/**
	 * Get classes by file extraction, will only run if autoload fails
	 *
	 * @param $namespace
	 * @return array
	 * @since 1.0.0
	 */
	public function getByExtraction( $namespace ): array {
		if ( ! isset( $this->bootstrap['initialized_classes']['load_by'] ) ) {
			$this->bootstrap['initialized_classes']['load_by'] = 'Extraction; Try a `composer dumpautoload -o` to optimize the autoloader.';
		}
		$find_all_classes = [];
		foreach ( $this->filesFromThisDir() as $file ) {
			$file_data = [
				// phpcs:disable
				// file_get_contents() is only discouraged by PHPCS for remote files
				'tokens'    => token_get_all( file_get_contents( $file->getRealPath() ) ),
				// phpcs:enable
				'namespace' => '',
			];
			$find_all_classes = array_merge( $find_all_classes, $this->extractClasses( $file_data ) );
		}
		$this->classBelongsTo( $find_all_classes, $namespace . '\\' );
		return $this->class_list;
	}

	/**
	 * Extract class from file, will only run if autoload fails
	 *
	 * @param $file_data
	 * @param array $classes
	 * @return array
	 * @since 1.0.0
	 */
	public function extractClasses( $file_data, $classes = [] ): array {
		for ( $index = 0; isset( $file_data['tokens'][ $index ] ); $index++ ) {
			if ( ! isset( $file_data['tokens'][ $index ][0] ) ) {
				continue;
			}
			if ( T_NAMESPACE === $file_data['tokens'][ $index ][0] ) {
				$index += 2; // Skip namespace keyword and whitespace
				while ( isset( $file_data['tokens'][ $index ] ) && is_array( $file_data['tokens'][ $index ] ) ) {
					$file_data['namespace'] .= $file_data['tokens'][ $index++ ][1];
				}
			}
			if ( T_CLASS === $file_data['tokens'][ $index ][0] && T_WHITESPACE === $file_data['tokens'][ $index + 1 ][0] && T_STRING === $file_data['tokens'][ $index + 2 ][0] ) {
				$index += 2; // Skip class keyword and whitespace
				// So it only works with 1 class per file (which should be psr-4 compliant)
				$classes[] = $file_data['namespace'] . '\\' . $file_data['tokens'][ $index ][1];
				break;
			}
		}
		return $classes;
	}

	/**
	 * Get all files from current dir, will only run if autoload fails
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public function filesFromThisDir(): \RegexIterator {
		$files = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( __DIR__ ) );
		$files = new \RegexIterator( $files, '/\.php$/' );
		return $files;
	}

	/**
	 * Checks if class belongs to namespace, will only run if autoload fails
	 *
	 * @param $classes
	 * @param $namespace
	 * @since 1.0.0
	 */
	public function classBelongsTo( $classes, $namespace ) {
		foreach ( $classes as $class ) {
			if ( strpos( $class, $namespace ) === 0 ) {
				$this->class_list[] = $class;
			}
		}
	}

	/**
	 * Start the execution timer of the plugin
	 *
	 * @since 1.0.0
	 */
	public function startExecutionTimer() {
		if ( $this->bootstrap['debug'] === true ) {
			$this->bootstrap['execution_time']['start'] = microtime( true );
		}
	}

	/**
	 * @param $timer
	 * @param string $tag
	 * @return string
	 * @since 1.0.0
	 */
	public function stopExecutionTimer( $timer, $tag = 'Execution time' ): string {
		if ( $this->bootstrap['debug'] === true ) {
			return 'Elapsed: ' . ( microtime( true ) - $this->bootstrap['execution_time']['start'] ) . ' | ' . $tag . ': ' . ( microtime( true ) - $timer );
		} else {
			return '';
		}
	}

	/**
	 * Visual presentation of the classes that are loaded
	 */
	public function debugger() {
		if ( $this->bootstrap['debug'] === true ) {
			$this->bootstrap['execution_time'] =
				'Total execution time in seconds: ' . ( microtime( true ) - $this->bootstrap['execution_time']['start'] );
			add_action( 'shutdown', function () {
				ini_set( 'highlight.comment', '#969896; font-style: italic' );
				ini_set( 'highlight.default', '#FFFFFF' );
				ini_set( 'highlight.html', '#D16568; font-size: 13px; padding: 0; display: block;' );
				ini_set( 'highlight.keyword', '#7FA3BC; font-weight: bold; padding:0;' );
				ini_set( 'highlight.string', '#F2C47E' );
				$output = highlight_string( "<?php\n\n" . var_export( $this->bootstrap, true ), true );
				echo "<div style=\"background-color: #1C1E21; padding:5px; position: fixed; z-index:9999; bottom:0;\">{$output}</div>";
			} );
		}
	}
}
