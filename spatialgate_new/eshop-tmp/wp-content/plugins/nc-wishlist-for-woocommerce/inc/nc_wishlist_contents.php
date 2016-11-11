 <?php 
$products= $_COOKIE['nc_wihslist_items'];

 $nc_wishlist_settings=get_option('nc_wishlist_settings'); 
 if($nc_wishlist_settings['nc_wishlist_enabling']=='1'){
		$need_to_log_in=$nc_wishlist_settings['nc_wishlist_for'];	
		if($need_to_log_in=='logged_in_users'){
			if(is_user_logged_in())
			{
include_once("wishlist-items.php");
				}
			else
				{
			echo "Please log in to use this feature";
			}
				}
			else
		
			{
        include_once("wishlist-items.php");
			}

 }