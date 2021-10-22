<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/assets/no-timber.html';
		}
	);



	return;
}

/*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	*/
load_theme_textdomain( 'mas', get_template_directory() . '/languages' );

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = 'views';

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = new Timber\Menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();

/**
 * LOAD ACF FUNCTIONS
 */
require get_template_directory() . '/inc/acf/setup.php';


/**
 * Add classes to menus
 */
function prefix_nav_menu_classes($items, $menu, $args) {
    _wp_menu_item_classes_by_context($items);
    return $items;
}
add_filter( 'wp_get_nav_menu_items', 'prefix_nav_menu_classes', 10, 3 );



/**
 * Create namespacing for patternlab patterns paths
 */
add_filter('timber/loader/loader', function($loader){
	$loader->addPath(__DIR__ . "/views/partials/components", "components");
	$loader->addPath(__DIR__ . "/views/partials/blocks", "blocks");
	$loader->addPath(__DIR__ . "/views/partials/elements", "elements");
	$loader->addPath(__DIR__ . "/views/partials/templates", "templates");
	$loader->addPath(__DIR__ . "/views/partials/pages", "pages");
	return $loader;
});



 /**
 * CRITICAL CSSS
 */

function get_include_contents($filename) {
  if (is_file($filename)) {
      ob_start();
      include $filename;
      return ob_get_clean();
  }
  return false;
}


function inline_critical_css() {
	$string = get_include_contents( get_template_directory() . '/assets/css/critical/critical.css' );
	echo '<style type="style/css">'.str_replace('url(..', 'url(' . get_template_directory_uri() . '/assets', $string).'</style>'. "\n";
}
add_action( 'wp_enqueue_scripts', 'inline_critical_css' );

function mas_enqueue_assets() {
  wp_enqueue_style('base', get_template_directory_uri() . '/assets/css/base.min.css' );
}
add_action( 'wp_enqueue_scripts', 'mas_enqueue_assets' );


// Gutenberg custom stylesheet
add_theme_support('editor-styles');
add_editor_style( get_template_directory_uri() . '/assets/css/base.min.css' );