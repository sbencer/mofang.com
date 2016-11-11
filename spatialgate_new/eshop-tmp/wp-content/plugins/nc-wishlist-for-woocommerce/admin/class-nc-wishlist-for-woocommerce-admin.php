<?php

/**
 * The admin-specific functionality of the plugin.
 *
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.1
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/admin
 * @author     Nabaraj Chapagain <nabarajc6@gmail.com>
 */
class NC_WISHLIST_FOR_WOOCOMMERCE_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;	
	
	/**
	 * The settings data for wishlist
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      array    $nc_wishlist_settings    The settings data for wishlist
	 */
	private $nc_wishlist_settings;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	/**
	 * Register submenu for the plugin
	 *
	 * @since    1.0.1
	 */	
	
	public function  nc_wishlist_menu(){
			$settings=add_submenu_page('woocommerce', 'NC Wishlist Settings', 'NC Wishlist Settings', 'manage_options', 'nc_wishlist',
			array($this, 'nc_wishlist_settings_form'));
			add_action( "load-{$settings}", array($this,'nc_wishlist_settings_page') );
	
   }
   
 	/**
	 * Wishlist setting form for admin
	 *
	 * @since    1.0.1
	 */	  
   
   	public function nc_wishlist_settings_form(){
				include_once('includes/nc-wishlist-for-woocommerce-settings-form.php');
			}
   
   
   	/**
	 * the default values of wishlist settings page
	 *
	 * @since    1.0.1
	 */
	public function nc_wishlist_setting_default(  ) {	
	
	if( !get_option( 'nc_wishlist_settings' ) ) :
		$this->nc_wishlist_settings=array();
		$this->nc_wishlist_settings['nc_wishlist_enabling']='1';
		$this->nc_wishlist_settings['nc_wishlist_page']='';
		$this->nc_wishlist_settings['nc_wishlist_enable_image']='1';
		$this->nc_wishlist_settings['nc_wishlist_button_position']='after-add-to-cart';
		$this->nc_wishlist_settings['nc_wishlist_enable_add_to_cart']='1';
		$this->nc_wishlist_settings['nc_wishlist_enable_unit_price']='1';
		$this->nc_wishlist_settings['nc_wishlist_enable_stock']='1';
		$this->nc_wishlist_settings['nc_wishlist_add_to_wishlist_text']='Add to Wishlist';
		$this->nc_wishlist_settings['nc_wishlist_view_wishlist_text']='Browse Wishlist';
		$this->nc_wishlist_settings['nc_wishlist_for']='all_users';
		$this->nc_wishlist_settings['nc_wishlist_show_in_shop_page']='0';

		add_option( 'nc_wishlist_settings',$this->nc_wishlist_settings,'','yes');
	    endif;
	}

   

				
	/**
	 * Create table for wishlists
	 *
	 * @since    1.0.1
	 */				
	public function nc_wishlist_create_table(){
					
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name= $wpdb->prefix."nc_wishlist";

		$sql = "CREATE TABLE $table_name (
 		 id mediumint(9) NOT NULL AUTO_INCREMENT,
 		 user_id mediumint(9) NOT NULL ,
 		 product_id mediumint(9) NOT NULL,
		 wishlist_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  UNIQUE KEY id (id)
			) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
				
					}
					
	/**
	 * Create table for wishlists
	 *
	 * @since    1.0.1
	 */						
	public	function nc_wishlist_settings_page() {
			if ( $_POST["nc_wishlist_submit"]) :
			check_admin_referer( "nc_wishlist_page" );
			$this->nc_wishlist_save_settings();
			$param = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
			wp_redirect(admin_url('admin.php?page=nc_wishlist&'.$param));
			exit;
			endif;
	}
				
	/**
	 * Save setting for wishlist admin
	 *
	 * @since    1.0.1
	 */								
	public function nc_wishlist_save_settings(){
        
			$this->nc_wishlist_settings=array();
			if ( isset ( $_GET['page'] )=='nc_wishlist'):
				$this->nc_wishlist_settings['nc_wishlist_enabling']=$_POST['nc_wishlist_enabling'];
				$this->nc_wishlist_settings['nc_wishlist_page']=$_POST['nc_wishlist_page'];
				$this->nc_wishlist_settings['nc_wishlist_button_position']=$_POST['nc_wishlist_button_position'];
				$this->nc_wishlist_settings['nc_wishlist_enable_image']=$_POST['nc_wishlist_enable_image'];
				$this->nc_wishlist_settings['nc_wishlist_enable_add_to_cart']=$_POST['nc_wishlist_enable_add_to_cart'];
				$this->nc_wishlist_settings['nc_wishlist_enable_unit_price']=$_POST['nc_wishlist_enable_unit_price'];
				$this->nc_wishlist_settings['nc_wishlist_enable_stock']=$_POST['nc_wishlist_enable_stock'];
				$this->nc_wishlist_settings['nc_wishlist_add_to_wishlist_text']=$_POST['nc_wishlist_add_to_wishlist_text'];;
				$this->nc_wishlist_settings['nc_wishlist_view_wishlist_text']=$_POST['nc_wishlist_view_wishlist_text'];;
				$this->nc_wishlist_settings['nc_wishlist_for']=$_POST['nc_wishlist_for'];
				$this->nc_wishlist_settings['nc_wishlist_show_in_shop_page']=$_POST['nc_wishlist_show_in_shop_page'];
			   //update option
			   update_option( "nc_wishlist_settings", 	$this->nc_wishlist_settings );

			endif;
		}
		
	/**
	 * nc wishlist functionate initiate
	 *
	 * @since    1.0.1
	 */								
	public function nc_wishlist_admin_init(){
		
		$this->nc_wishlist_setting_default();
		$this->nc_wishlist_create_table();
		$this->nc_wishlist_settings_page();

		}
	
	/**
	 * nc wishlist functionate initiate
	 *
	 * @since    1.0.1
	 */	
	 	
	public function nc_wishlist_admin_pages_display()
	{
	   $args = array
	       (
	      'posts_per_page'   => -1,
	      'offset'           => 0,
	      'category'         => '',
		     'category_name'    => '',
		     'orderby'          => 'date',
		     'order'            => 'DESC',
		     'include'          => '',
		     'exclude'          => '',
		     'meta_key'         => '',
		     'meta_value'       => '',
		     'post_type'        => 'page',
		     'post_mime_type'   => '',
		     'post_parent'      => '',
		     'author'	   => '',
		     'post_status'      => 'publish',
		     'suppress_filters' => true 
			);
			$posts_array = get_posts( $args );
			
			
		return  $posts_array;
		
	}
	

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

}
