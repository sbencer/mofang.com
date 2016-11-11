<?php

/**
 * @wordpress-plugin
 * Plugin Name:       NC Wishlist for woocommerce
 * Plugin URI:        http://dovecreation.com/
 * Description:       NC Wishlist for woocommerce allow you to add wishlist functionality to your ecommerce store
 * Version:           1.0.1
 * Author:            Nabaraj Chapagain
 * Author URI:        http://dovecreation.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nc-wishlist-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ) { 
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/nc-wishlist-activator.php
 */
function activate_NC_WISHLIST_FOR_WOOCOMMERCE() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nc-wishlist-for-woocommerce-activator.php';
	NC_WISHLIST_FOR_WOOCOMMERCE_Activator::nc_wishlist_page();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/nc-wishlist-deactivator.php
 */
function deactivate_NC_WISHLIST_FOR_WOOCOMMERCE() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nc-wishlist-for-woocommerce-deactivator.php';
	NC_WISHLIST_FOR_WOOCOMMERCE_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_NC_WISHLIST_FOR_WOOCOMMERCE' );
register_deactivation_hook( __FILE__, 'deactivate_NC_WISHLIST_FOR_WOOCOMMERCE' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
 		
	
require plugin_dir_path( __FILE__ ) . 'includes/class-nc-wishlist-for-woocommerce.php';
	

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_nc_wishlist_for_woocommerce() {
   
   
   
	$plugin = new NC_WISHLIST_FOR_WOOCOMMERCE();
	$plugin->run();
	

}
run_nc_wishlist_for_woocommerce();


/**
 * ajax cart settings page link * @since      1.0.0
*/	

 function NC_WISHLIST_FOR_WOOCOMMERCE_settings_link( $links ) 
		{
   			$settings_link = '<a href="admin.php?page=nc_wishlist">' . __( 'Configuration' ) . '</a>';
   			array_push( $links, $settings_link );
  			return $links;
		}
				$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'NC_WISHLIST_FOR_WOOCOMMERCE_settings_link');

	
	}
	
