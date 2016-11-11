<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.1
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public
 * @author     Nabaraj Chapagain <nabarajc6@gmail.com>
 */
class NC_WISHLIST_FOR_WOOCOMMERCE {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	
	/**
	 * The settings data for wishlist
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      array    $nc_wishlist_settings    The settings data for wishlist
	 */
	private $nc_wishlist_settings;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function __construct() {

		$this->plugin_name = 'nc-wishlist-for-woocommerce';
		$this->version = '1.0.1';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function load_dependencies() {


		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-nc-wishlist-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-nc-wishlist-for-woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-nc-wishlist-for-woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-nc-wishlist-for-woocommerce-public.php';

		$this->loader = new NC_WISHLIST_FOR_WOOCOMMERCE_Loader();
       

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new NC_WISHLIST_FOR_WOOCOMMERCE_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new NC_WISHLIST_FOR_WOOCOMMERCE_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_admin, 'nc_wishlist_admin_init' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'nc_wishlist_menu' );
		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 */
	private function define_public_hooks() {
		
		$this->nc_wishlist_settings=get_option('nc_wishlist_settings');	 
		$p=$this->nc_wishlist_settings['nc_wishlist_button_position'];
		
		$plugin_public = new NC_WISHLIST_FOR_WOOCOMMERCE_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'nc_ajax_cart_public_init' );
		$this->loader->add_action( 'wp_ajax_nc_wishlist_action', $plugin_public, 'nc_wishlist_action',1000 );
		$this->loader->add_action( 'wp_ajax_nopriv_nc_wishlist_action', $plugin_public, 'nc_wishlist_action',1000 );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'nc_wishlist_ajax_script' );
		
		// add to wishlist shop page hook	
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'nc_wishlist_button' );
		
		// add to wishlist button position hook
		if($p=='after_add_to_cart'){ $val='after'; } else if($p=='after_summary_text'){ $val='before'; }
		$this->loader->add_action( 'woocommerce_'.$val.'_add_to_cart_form', $plugin_public, 'nc_wishlist_button'  );
		
		// add shortcode hook
		if($p=='use_shortcode')
		add_shortcode( 'nc_wishlist_button', array(&$plugin_public,'nc_wishlist_button') );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
