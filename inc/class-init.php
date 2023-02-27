<?php
/**
 * Class KotwSearchs_Init
 */
if ( !class_exists( 'KotwSearchs_Init' ) ):
class KotwSearchs_Init {


	public static $plugin_prefix = 'KotwSearchs';

	/**
	 * @var string $prefix
	 */
	public $prefix = 'KotwSearchs';


	/**
	 * @var string $plugin_url
	 */
	public $plugin_url;


	/**
	 * @var string $plugin_path
	 */
	public $plugin_path;


	/**
	 * @var string $text_domain
	 */
	public $text_domain;


	/**
	 * @var array
	 * Options Array for the whole plugin.
	 */
	public $options;


	/**
	 * @var api_url.
	 * Path to the api directory.
	 */
	public $api_url;

	/**
	 * KotwSearchs_Init constructor.
	 */
	public function __construct() {
		$this->plugin_url   = dirname( plugin_dir_url(__FILE__) );
		$this->plugin_path  = dirname( plugin_dir_path( __FILE__ ) );
		$this->text_domain  = 'KotwSearch';
	}
	/**
	 * main_imports
	 * Imports the main files for the plugin.
	 */
	public function main_imports() {
		require_once $this->plugin_path . '/inc/classes/class-search-kotw-main.php';
		require_once $this->plugin_path . '/inc/classes/class-kotw-custom-tax.php';
		require_once $this->plugin_path . '/inc/class-enqueue-scripts.php';
		require_once $this->plugin_path . '/inc/class-shortcodes.php';
		require_once $this->plugin_path . '/inc/class-ajax.php';
	}

	/**
	 *  Code to be run after plugin is activated.
	 */
	public static function activate() {
		update_option( 'KotwSearchs_plugin_activated', date('d-m-Y H:i') );
	}

	/**
	 * Code to be run after plugin is deactivated.
	 */
	public static function deactivate() {
		update_option( 'KotwSearchs_plugin_deactivated', date('d-m-Y H:i') );
	}

	/**
	 * Code to be run after plugin is uninstalled.
	 */
	public static function uninstall() {
		delete_option( 'KotwSearchs_plugin_activated' );
		delete_option( 'KotwSearchs_plugin_deactivated' );
	}
}


endif;