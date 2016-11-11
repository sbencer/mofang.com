<?php

/**
 * Fired during plugin activation
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public
 * @author     Nabaraj Chapagain <nabarajc6@gmail.com>
 */
class NC_WISHLIST_FOR_WOOCOMMERCE_Activator {

		/**
	 * Create wishlist page on plugin install
	 *
	 * @since    1.0.1
	 */   
    public function  nc_wishlist_page(){
				$page = get_page_by_path( 'wishlist' );
				if(!$page):
					$post = array(
 					 'post_content'   => '[nc_wishlist]',
 					 'post_name'      => 'wishlist',
  					 'post_title'     => 'Wishlist',
 					 'post_status'    => 'publish',
  					 'post_type'      => 'page',
					 );  
					wp_insert_post( $post );
					endif;
				}


}
