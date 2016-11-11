<?php global $pagenow; ?>

 <?php
	    	$nc_wishlist_settings=get_option('nc_wishlist_settings');  	

		?>
	<div class="wrap ajax_cart">
    <h1>NC Wishlist</h1>
    <p class="description">Insert shortcode [nc_wishlist] on page or post to display wishlist items and use shortcode [nc_wishlist_button] to display wishlist button on your products. </p>
    <form method="post" action="<?php admin_url( 'admin.php?page=nc_wishlist' ); ?>" enctype="multipart/form-data">
				<table class="form-table">
				
				<?php wp_nonce_field( "nc_wishlist_page" ); 
				
					if ( $pagenow == 'admin.php' && $_GET['page'] == 'nc_wishlist' ){ ?>
						         
						         <tr>
						            <th>Enable wishlist</th>
						            <td>
						               
						               		<input type="checkbox" <?php echo ($nc_wishlist_settings['nc_wishlist_enabling']=='1') ? " checked": "";?> name="nc_wishlist_enabling" value="1">Enable         								               		
						            
						            </td>
						         </tr>
                                 
                                
                                <tr valign="top" class="single_select_page">
						<th scope="row" class="titledesc">Wishlist Page </th>
						<td class="forminp">
						
                            <?php $args = array(
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
?>
	<select name="nc_wishlist_page">
    <?php foreach($posts_array as $pages){ ?>
	<option  value="<?php echo $pages->ID; ?>" <?php echo ($nc_wishlist_settings['nc_wishlist_page'])==$pages->ID ? " selected='selected'" : ""; ?>><?php echo $pages->post_title; ?></option>
    <?php } ?>

</select>
					</td>
					</tr>
                    <tr valign="top">
						<th scope="row" class="titledesc">
						Wishlist button Position For Single Product Page
												</th>
						<td>
							<select name="nc_wishlist_button_position" id="nc_wishlist_button_position">
									<option value="after_add_to_cart" <?php echo ($nc_wishlist_settings['nc_wishlist_button_position'])=='after_add_to_cart' ? " selected='selected'" : ""; ?>>After "Add to cart"</option>
                                    <option value="after_summary_text" <?php echo ($nc_wishlist_settings['nc_wishlist_button_position'])=='after_summary_text' ? " selected='selected'" : ""; ?> >After summary text</option>
									<option value="use_shortcode" <?php echo ($nc_wishlist_settings['nc_wishlist_button_position'])=='use_shortcode' ? " selected='selected'" : ""; ?> >Use shortcode</option>
																   </select> 						
                                                                 <span class="use_shortcode">  Use shortcode [nc_wishlist_button]</span>
                                                                 
                                                               <script>
															   
															   jQuery(document).ready(function($){
				 <?php $display= ($nc_wishlist_settings['nc_wishlist_button_position'])=='use_shortcode' ? "show" : "hide"; ?>
												$(".use_shortcode").<?php echo $display; ?>();	
															   });
    
                                                               </script>  
                                                                 </td>
					</tr>	
						         <tr>
						            <th>Show Image</th>
						            <td>
						               
			<input type="checkbox" <?php echo ($nc_wishlist_settings['nc_wishlist_enable_image']=='1') ? " checked": "";?> name="nc_wishlist_enable_image" value="1">Show Image
						               
						            </td>
						         </tr>
                                 
                                 
						         
						        <tr>
						            <th>Show "Add to cart" button</th>
						            <td>
						               
			<input type="checkbox" <?php echo ($nc_wishlist_settings['nc_wishlist_enable_add_to_cart']=='1') ? " checked": "";?> name="nc_wishlist_enable_add_to_cart" value="1">Show "Add to cart" button
						               
						            </td>
						         </tr>
                                 
                                 
                                 <tr>
						            <th>Show unit price</th>
						            <td>
						               
			<input type="checkbox" <?php echo ($nc_wishlist_settings['nc_wishlist_enable_unit_price']=='1') ? " checked": "";?> name="nc_wishlist_enable_unit_price" value="1">Show unit price
						               
						            </td>
						         </tr>
						         
						         <tr>
                                 
                                  <tr>
						            <th>Show stock</th>
						            <td>
						               
			<input type="checkbox" <?php echo ($nc_wishlist_settings['nc_wishlist_enable_stock']=='1') ? " checked": "";?> name="nc_wishlist_enable_stock" value="1">Show stock
						               
						            </td>
						         </tr>
                                   <tr>
						            <th>Add to wishlist text</th>
						            <td>
						               
						               		<input type="text" value="<?php echo (!empty($nc_wishlist_settings['nc_wishlist_add_to_wishlist_text'])) ? $nc_wishlist_settings['nc_wishlist_add_to_wishlist_text'] : "";?>" name="nc_wishlist_add_to_wishlist_text" >       								               		
						            
						            </td>
						         </tr>
                                 
                                 
                                  <tr>
						            <th>View wishlist text</th>
						            <td>
						               
						               		<input type="text" value="<?php echo (!empty($nc_wishlist_settings['nc_wishlist_view_wishlist_text'])) ? $nc_wishlist_settings['nc_wishlist_view_wishlist_text'] : "";?>" name="nc_wishlist_view_wishlist_text" >       								               		
						            
						            </td>
						         </tr>
                                 
						         
						         <tr>
                                 
                                 
                                  <tr valign="top" class="single_select_page">
						<th scope="row" class="titledesc">Enable Wishlist for </th>
						<td class="forminp">
							<select name="nc_wishlist_for">

	<option  value="logged_in_users" <?php echo ($nc_wishlist_settings['nc_wishlist_for'])=='logged_in_users' ? " selected='selected'" : ""; ?>>Logged in users</option>
	<option  value="all_users" <?php echo ($nc_wishlist_settings['nc_wishlist_for'])=='all_users' ? " selected='selected'" : ""; ?>>All users</option>

</select>
					</td>
					</tr>
                    
                    
                     <tr>
						            <th>Show in Shop Page</th>
						            <td>
						               
			<input type="checkbox" <?php echo ($nc_wishlist_settings['nc_wishlist_show_in_shop_page']=='1') ? " checked": "";?> name="nc_wishlist_show_in_shop_page" value="1">Show Wishlist Button in Shop Page With Add To Cart Button
						               
						            </td>
						         </tr>
						       
							 <?php
							 
						 }
				
					

				?>
				</table>
					<p class="submit">
	                    <input type="submit" class="button-primary" name="nc_wishlist_submit" value="<?php _e('Save Changes','ajax_cart') ?>" />
	               
	                </p>
		
				</form>
               