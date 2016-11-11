<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.1
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/admin/includes
 */
?>
<?php 

global $pagenow; 
$this->nc_wishlist_settings=get_option('nc_wishlist_settings');  
?>
	<div class="wrap ajax_cart">
    <h1><?php _e('NC Wishlist',$this->plugin_name); ?></h1>
    <p class="description"><?php printf( esc_html__( 'Insert shortcode %1$s on page or post to display wishlist items and use shortcode %2$s to display wishlist button on your products.', 'my-text-domain' ), '[nc_wishlist]', '[nc_wishlist_button]' ); ?> </p>
    <form method="post" action="<?php admin_url( 'admin.php?page=nc_wishlist' ); ?>" enctype="multipart/form-data">
				<table class="form-table">
				
				<?php wp_nonce_field( "nc_wishlist_page" ); 
				
					if ( $pagenow == 'admin.php' && $_GET['page'] == 'nc_wishlist' ){ ?>
						         
						         <tr>
						            <th><?php _e('Enable wishlist',$this->plugin_name); ?></th>
						            <td>
						               
						               		<input type="checkbox" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_enabling'])=='1') ? " checked": "";?> name="nc_wishlist_enabling" value="1"><?php _e('Enable',$this->plugin_name); ?>       								               		
						            
						            </td>
						         </tr>
                                 
                                
                                <tr valign="top" class="single_select_page">
						<th scope="row" class="titledesc"><?php _e('Wishlist Page ',$this->plugin_name); ?></th>
						<td class="forminp">
						
      <?php $posts_array=$this->nc_wishlist_admin_pages_display(); ?>                      
	<select name="nc_wishlist_page">
    <?php foreach($posts_array as $pages){ ?>
	<option  value="<?php echo $pages->ID; ?>" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_page']))==$pages->ID ? " selected='selected'" : ""; ?>><?php   _e( $pages->post_title, $this->plugin_name ); ?></option>
    <?php } ?>

</select>
					</td>
					</tr>
                    <tr valign="top">
						<th scope="row" class="titledesc">
                        <?php _e('Wishlist button Position For Single Product Page',$this->plugin_name); ?>
						
												</th>
						<td>
							<select name="nc_wishlist_button_position" id="nc_wishlist_button_position">
									<option value="after_add_to_cart" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_button_position']))=='after_add_to_cart' ? " selected='selected'" : ""; ?>><?php _e('After "Add to cart"',$this->plugin_name); ?></option>
                                    <option value="after_summary_text" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_button_position']))=='after_summary_text' ? " selected='selected'" : ""; ?> ><?php _e('After summary text',$this->plugin_name); ?></option>
									<option value="use_shortcode" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_button_position']))=='use_shortcode' ? " selected='selected'" : ""; ?> ><?php _e('Use shortcode',$this->plugin_name); ?></option>
																   </select> 						
                                                                 <span class="use_shortcode"><?php _e('Use shortcode [nc_wishlist_button]',$this->plugin_name); ?> </span>
                                                                 
                                                               <script>
															   
															   jQuery(document).ready(function($){
				 <?php $display= ($this->nc_wishlist_settings['nc_wishlist_button_position'])=='use_shortcode' ? "show" : "hide"; ?>
												$(".use_shortcode").<?php printf( esc_html__('%s',$this->plugin_name), $display); ?>;	
															   });
    
                                                               </script>  
                                                                 </td>
					</tr>	
						         <tr>
						            <th><?php _e('Show Image',$this->plugin_name); ?></th>
						            <td>
						               
			<input type="checkbox" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_enable_image'])=='1') ? " checked": "";?> name="nc_wishlist_enable_image" value="1"><?php _e('Show Image',$this->plugin_name); ?>
						               
						            </td>
						         </tr>
                                 
                                 
						         
						        <tr>
						            <th><?php _e('Show "Add to cart" button',$this->plugin_name); ?></th>
						            <td>
						               
			<input type="checkbox" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_enable_add_to_cart'])=='1') ? " checked": "";?> name="nc_wishlist_enable_add_to_cart" value="1"><?php _e('Show "Add to cart" button',$this->plugin_name); ?>
						               
						            </td>
						         </tr>
                                 
                                 
                                 <tr>
						            <th><?php _e('Show unit price',$this->plugin_name); ?></th>
						            <td>
						               
			<input type="checkbox" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_enable_unit_price'])=='1') ? " checked": "";?> name="nc_wishlist_enable_unit_price" value="1"><?php _e('Show unit price',$this->plugin_name); ?>
						               
						            </td>
						         </tr>
						         
						         <tr>
                                 
                                  <tr>
						            <th><?php _e('Show stock',$this->plugin_name); ?></th>
						            <td>
						               
			<input type="checkbox" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_enable_stock'])=='1') ? " checked": "";?> name="nc_wishlist_enable_stock" value="1"><?php _e('Show stock',$this->plugin_name); ?>
						               
						            </td>
						         </tr>
                                   <tr>
						            <th><?php _e('Add to wishlist text',$this->plugin_name); ?></th>
						            <td>
						               
						               		<input type="text" value="<?php echo (!empty($this->nc_wishlist_settings['nc_wishlist_add_to_wishlist_text'])) ? esc_attr($this->nc_wishlist_settings['nc_wishlist_add_to_wishlist_text']) : "";?>" name="nc_wishlist_add_to_wishlist_text" >       								               		
						            
						            </td>
						         </tr>
                                 
                                 
                                  <tr>
						            <th><?php _e('View wishlist text',$this->plugin_name); ?></th>
						            <td>
						               
						               		<input type="text" value="<?php echo (!empty($this->nc_wishlist_settings['nc_wishlist_view_wishlist_text'])) ? esc_attr($this->nc_wishlist_settings['nc_wishlist_view_wishlist_text']) : "";?>" name="nc_wishlist_view_wishlist_text" >       								               		
						            
						            </td>
						         </tr>
                                 
						         
						         <tr>
                                 
                                 
                                  <tr valign="top" class="single_select_page">
						<th scope="row" class="titledesc"> <?php _e('Enable Wishlist for',$this->plugin_name); ?></th>
						<td class="forminp">
							<select name="nc_wishlist_for">

	<option  value="logged_in_users" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_for']))=='logged_in_users' ? " selected='selected'" : ""; ?>><?php _e('Logged in users',$this->plugin_name); ?></option>
	<option  value="all_users" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_for']))=='all_users' ? " selected='selected'" : ""; ?>><?php _e('All users',$this->plugin_name); ?></option>

</select>
					</td>
					</tr>
                    
                    
                     <tr>
						            <th> <?php _e('Show in Shop Page',$this->plugin_name); ?></th>
						            <td>
						               
			<input type="checkbox" <?php echo (esc_attr($this->nc_wishlist_settings['nc_wishlist_show_in_shop_page'])=='1') ? " checked": "";?> name="nc_wishlist_show_in_shop_page" value="1"><?php _e('Show Wishlist Button in Shop Page With Add To Cart Button',$this->plugin_name); ?>
						               
						            </td>
						         </tr>
						       
							 <?php
							 
						 }
				
					

				?>
				</table>
					<p class="submit">
	                    <input type="submit" class="button-primary" name="nc_wishlist_submit" value="<?php _e('Save Changes',$this->plugin_name) ?>" />
	               
	                </p>
		
				</form>
               