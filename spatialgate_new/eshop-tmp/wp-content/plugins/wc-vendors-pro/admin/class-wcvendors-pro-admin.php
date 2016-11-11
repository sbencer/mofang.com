<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/admin
 * @author     Jamie Madden <support@wcvendors.com>
 */

class WCVendors_Pro_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wcvendors_pro    The ID of this plugin.
	 */
	private $wcvendors_pro;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Script suffix for debugging 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $suffix    script suffix for including minified file versions 
	 */
	private $suffix;

	/**
	 * Is the plugin in debug mode 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $debug    plugin is in debug mode 
	 */
	private $debug;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $wcvendors_pro       The name of this plugin.
	 * @param    string    $version    		The version of this plugin.
	 */
	public function __construct( $wcvendors_pro, $version, $debug ) {

		$this->wcvendors_pro 	= $wcvendors_pro;
		$this->version 			= $version;
		$this->debug 			= $debug; 
		$this->base_dir			= plugin_dir_url( __FILE__ ); 
		$this->plugin_base_dir	= plugin_dir_path( dirname(__FILE__) ); 
		$this->suffix		 	= $this->debug ? '' : '.min';

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'postbox' );
		wp_enqueue_media();

		wp_enqueue_script( $this->wcvendors_pro, $this->base_dir . 'assets/js/wcvendors-pro-admin'.$this->suffix.'.js', array( 'jquery' ), $this->version, true );

		// Select 2 (3.5.2 branch)
		wp_register_script( 'select2', 				$this->base_dir . '../includes/assets/lib/select2/select2' . $this->suffix	 . '.js', array( 'jquery' ), '3.5.2', true );
		wp_enqueue_script( 'select2'); 

		//Select2 3.5.4
		wp_enqueue_style( 'select2-css', 	$this->base_dir . '../includes/assets/css/select2' . $this->suffix . '.css', array(), '4.3.0', 'all' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 * @return   array 			Action links
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . WCVendors_Pro::$wcvendors_id . '&tab=pro' ) . '">' . __( 'Settings', 'wcvendors-pro' ) . '</a>'
				),
			$links
			);

	} // add_action_links()

	/**
	 * Lock a vendor out of the wp-admin
	 *
	 * @since    1.0.0
	*/
	public function admin_lockout( ) { 

		if ( WCVendors_Pro::get_option( 'disable_wp_admin_vendors' ) ) { 

			$capability = apply_filters( 'wcv_admin_lockout_capability', 'administrator' ); 

			if ( ! current_user_can( $capability ) && ! defined( 'DOING_AJAX' ) ) {
				add_action( 'admin_init',     array( $this, 'admin_redirect' ) );
			} else {
				return; 
			}
		} 

	} // admin_lockout() 

	/**
	 * Redirect to pro dashboard if attempting to access wordpress dashboard
	 *
	 * @since    1.0.0
	*/
	public function admin_redirect( ) { 

		$redirect_page = apply_filters( 'wcv_admin_lockout_redirect_url', get_permalink( WCVendors_Pro::get_option( 'dashboard_page_id' ) ) ); 
		wp_redirect( $redirect_page ); 

	} //admin_redirect() 


	/**
	 * Output system status information for pro 
	 *
	 * @since    1.0.3
	*/
	public function wcvendors_pro_system_status( ) { 

		$free_dashboard_page 	= WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' );
		$pro_dashboard_page 	= WCVendors_Pro::get_option( 'dashboard_page_id' ); 
		$feedback_form_page 	= WCVendors_Pro::get_option( 'feedback_page_id' ); 
		 
		$vendor_shop_permalink  = WC_Vendors::$pv_options->get_option( 'vendor_shop_permalink' );

		$woocommerce_override   = locate_template( 'woocommerce.php' );

		include_once('partials/wcvendors-pro-system-status.php'); 

	} // wcvendors_pro_system_status() 

	public function wcvendors_pro_template_status() { 


		include_once( 'partials/wcvendors-pro-template-status.php' ); 
	}

	/**
	 * Load the new wc vendors shipping module 
	 *
	 * @since    1.1.0
	*/
	public function wcvendors_pro_shipping_init( ){ 

		if ( ! class_exists( 'WCVendors_Pro_Shipping_Method' ) ){ 
			include('class-wcvendors-pro-shipping.php'); 
		} 

	} // wcvendors_pro_shipping_init()

	/**
	 * Add the new wc vendors shipping module 
	 *
	 * @since    1.1.0
	 * @param    array    $methods      The shipping methods array.
	 * @return   array    $methods    	The updated shipping methods array.
	*/
	public function wcvendors_pro_shipping_method( $methods ) {

		$methods[] = 'WCVendors_Pro_Shipping_Method'; 
		return $methods;

	}	

	/**
	 * Check the options updated and update permalinks if required. 
	 *
	 * @since   1.1.0
	 * @param   array    $options      The options array.
	 * @param   string   $tabname      The tabname being updated.
	*/
	public function options_updated( $options, $tabname ){ 

		if ( $tabname == sanitize_title( __( 'Pro', 'wcvendors' ) )) {

			// Check the vendor store permalink. 
			$vendor_store_slug_old = WC_Vendors::$pv_options->get_option( 'vendor_store_slug' );
			$vendor_store_slug_new = $options[ 'vendor_store_slug' ];
			if ( $vendor_store_slug_old != $vendor_store_slug_new ) {
				update_option( WC_Vendors::$id . '_flush_rules', true );
			}

			// Check the product management capability. 
			$products_disabled_setting		= WC_Vendors::$pv_options->get_option( 'product_management_cap' );
			$products_disabled_option		= $options[ 'product_management_cap' ];
			if ( $products_disabled_setting != $products_disabled_option ) {
				update_option( WC_Vendors::$id . '_flush_rules', true );
			}

			// Check the order management capability. 
			$orders_disabled_setting		= WC_Vendors::$pv_options->get_option( 'order_management_cap' );
			$orders_disabled_option			= $options[ 'order_management_cap' ];
			if ( $orders_disabled_setting != $orders_disabled_option ) {
				update_option( WC_Vendors::$id . '_flush_rules', true );
			}

			// Check the coupon management capability. 
			$coupons_disabled_setting		= WC_Vendors::$pv_options->get_option( 'shop_coupon_management_cap' );
			$coupons_disabled_option		= $options[ 'shop_coupon_management_cap' ];
			if ( $coupons_disabled_setting != $coupons_disabled_option ) {
				update_option( WC_Vendors::$id . '_flush_rules', true );
			}

			// Check the ratings management capability. 
			$ratings_disabled_setting		= WC_Vendors::$pv_options->get_option( 'ratings_management_cap' );
			$ratings_disabled_option		= $options[ 'ratings_management_cap' ];
			if ( $ratings_disabled_setting != $ratings_disabled_option ) {
				update_option( WC_Vendors::$id . '_flush_rules', true );
			}

		}

	} //options_updated ()

}
