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

namespace ThePluginName;

use ThePluginName\Common\Abstracts\Base;
use ThePluginName\Common\Traits\Requester;
use ThePluginName\Common\Utils\Errors;
use ThePluginName\Config\I18n;
use ThePluginName\Config\Requirements;

/**
 * Bootstrap the plugin
 *
 * @since 1.0.0
 */
final class Bootstrap extends Base
{

    /**
     * Determine what we're requesting
     *
     * @see Requester
     */
    use Requester;

    /**
     * List of class to init
     *
     * @var array : classes
     */
    public $classList = [];

    /**
     * List of initialized class to init
     *
     * @var array : classes
     */
    public $initialized = [];

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
    public function __construct ( $composer )
    {
        parent::__construct();

        $this->requirements();
        $this->setLocale();
        $this->getClassLoader( $composer );
        $this->loadClasses( [
            [ 'init' => 'Integrations' ],
            [ 'init' => 'App\\Rest', 'on_request' => 'rest' ],
            [ 'init' => 'App\\Cli', 'on_request' => 'cli' ],
            [ 'init' => 'App\\Cron', 'on_request' => 'cron' ],
            [ 'init' => 'App\\General' ],
            [ 'init' => 'App\\Frontend', 'on_request' => 'frontend' ],
            [ 'init' => 'App\\Backend', 'on_request' => 'backend' ],
            [ 'init' => 'Compatibility' ]
        ] );
    }

    /**
     * Check plugin requirements
     *
     * @since 1.0.0
     */
    public function requirements ()
    {
        $this->requirements = new Requirements();
        $this->requirements->check();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * @since 1.0.0
     */
    public function setLocale ()
    {
        $this->i18n = new I18n();
        $this->i18n->load();
    }

    /**
     * Get the class loader from Composer
     *
     * @param $composer
     * @since 1.0.0
     */
    public function getClassLoader ( $composer )
    {
        $this->composer = $composer;
    }

    /**
     * Initialize the requested classes
     *
     * @param $classes : The loaded classes.
     * @since 1.0.0
     */
    public function loadClasses ( $classes )
    {
        foreach ( $classes as $class ) {
            if ( isset( $class[ 'on_request' ] ) && is_array( $class[ 'on_request' ] )
            ) {
                foreach ( $class[ 'on_request' ] as $on_request ) {
                    if ( !$this->request( $on_request ) ) continue;
                }
            } elseif ( isset( $class[ 'on_request' ] ) && !$this->request( $class[ 'on_request' ] )
            ) {
                continue;
            }
            $this->getClasses( $class[ 'init' ] );
        }
        $this->initClasses();
    }

    /**
     * Init the classes
     *
     * @since 1.0.0
     */
    public function initClasses ()
    {
        $this->classList = \apply_filters( 'the_plugin_name_initialized_classes', $this->classList );
        foreach ( $this->classList as $class ) {
            try {
                $this->initialized[ $class ] = new $class;
                $this->initialized[ $class ]->init();
            } catch ( \Throwable $err ) {
                \do_action( 'the_plugin_name_class_initialize_failed', $err, $class );
                Errors::wpDie(
                    sprintf( __( 'Could not load class "%s". The "init" method is probably missing or try a `composer dumpautoload -o` to refresh the autoloader.',
                        'the-plugin-name-text-domain' ), $class ),
                    __( 'Plugin initialize failed', 'the-plugin-name-text-domain' ),
                    __FILE__, $err );
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
    public function getClasses ( string $namespace ): array
    {
        if ( is_object( $this->composer ) !== false ) {
            $prefix    = $this->composer->getPrefixesPsr4();
            $classmap  = $this->composer->getClassMap();
            $namespace = $this->plugin->namespace() . '\\' . $namespace;

            // First we're going to try to load the classes via Composer's Autoload
            // which will improve the performance. This is only possible if the Autoloader
            // has been optimized.
            if ( isset( $classmap[ $this->plugin->namespace() . '\\Bootstrap' ] ) ) {

                $classes = array_keys( $classmap );
                foreach ( $classes as $class ) {
                    if ( 0 !== strncmp( (string)$class, $namespace, strlen( $namespace ) ) ) {
                        continue;
                    }
                    $this->classList[] = $class;
                }
                return $this->classList;
            }
        }

        // If the composer.json file is updated then Autoloader is not optimized and we
        // can't load classes via the Autoloader. The `composer dumpautoload -o` command needs to
        // to be called; in the mean time we're going to load the classes differently which will
        // be a bit slower. The plugin needs to be optimized before production-release
        // Errors::writeLog(
        //    [
        //        'title'   => __( 'The plugin classes are not being loaded by Composer\'s Autoloader' ),
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
    public function getByExtraction ( $namespace ): array
    {
        echo 'init Classes by Extraction <BR>';
        $find_all_classes = [];
        foreach ( $this->filesFromThisDir() as $file ) {
            $file_data        = [
                'tokens'    => token_get_all( file_get_contents( $file->getRealPath() ) ),
                'namespace' => ''
            ];
            $find_all_classes = array_merge( $find_all_classes, $this->extractClasses( $file_data ) );
        }
        $this->classBelongsTo( $find_all_classes, $namespace . '\\' );
        return $this->classList;
    }

    /**
     * Extract class from file, will only run if autoload fails
     *
     * @param $file_data
     * @param array $classes
     * @return array
     * @since 1.0.0
     */
    public function extractClasses ( $file_data, $classes = [] ): array
    {
        for ( $index = 0; isset( $file_data[ 'tokens' ][ $index ] ); $index++ ) {
            if ( !isset( $file_data[ 'tokens' ][ $index ][ 0 ] ) ) continue;
            if ( T_NAMESPACE === $file_data[ 'tokens' ][ $index ][ 0 ] ) {
                $index += 2; // Skip namespace keyword and whitespace
                while ( isset( $file_data[ 'tokens' ][ $index ] ) && is_array( $file_data[ 'tokens' ][ $index ] ) ) {
                    $file_data[ 'namespace' ] .= $file_data[ 'tokens' ][ $index++ ][ 1 ];
                }
            }
            if ( T_CLASS === $file_data[ 'tokens' ][ $index ][ 0 ] && T_WHITESPACE === $file_data[ 'tokens' ][ $index + 1 ][ 0 ] && T_STRING === $file_data[ 'tokens' ][ $index + 2 ][ 0 ] ) {
                $index += 2; // Skip class keyword and whitespace
                // So it only works with 1 class per file (which should be psr-4 compliant)
                $classes[] = $file_data[ 'namespace' ] . '\\' . $file_data[ 'tokens' ][ $index ][ 1 ];
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
    public function filesFromThisDir (): \RegexIterator
    {
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
    public function classBelongsTo ( $classes, $namespace )
    {
        foreach ( $classes as $class ) {
            if ( strpos( $class, $namespace ) === 0 ) {
                $this->classList[] = $class;
            }
        }
    }
}