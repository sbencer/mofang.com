<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since      1.0.1
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public/includes
 */

	$this->nc_wishlist_settings=get_option('nc_wishlist_settings');	 
		$need_to_log_in=$this->nc_wishlist_settings['nc_wishlist_for'];	

		if($need_to_log_in=='logged_in_users')
		{
			if(is_user_logged_in())
				{
				require("nc-wishlist-for-woocommerce-wishlist-items.php");
				}
			else
				{
				echo "Please log in to use this feature";
				echo do_shortcode("[woocommerce_my_account]");
			}
		}
		else
		
		{
       		  require("nc-wishlist-for-woocommerce-wishlist-items.php");
		}
