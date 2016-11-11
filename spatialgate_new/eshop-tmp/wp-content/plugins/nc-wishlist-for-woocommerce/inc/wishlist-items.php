<div class="woocommerce-wishlist-wrapper woocommerce">
<?php wc_print_notices(); ?>
<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
            <?php if($nc_wishlist_settings['nc_wishlist_enable_image']==1): ?>
			<th class="product-thumbnail">&nbsp;</th>
            <?php endif; ?>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
            <?php if($nc_wishlist_settings['nc_wishlist_enable_unit_price']==1): ?>
			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
            <?php endif; ?>
            <?php if($nc_wishlist_settings['nc_wishlist_enable_stock']==1): ?>
            <th class="product-stock"><?php _e( 'Stock', 'woocommerce' ); ?></th>
            <?php endif; ?>
            <?php if($nc_wishlist_settings['nc_wishlist_enable_add_to_cart']==1): ?>
			<th class="product-action"></th>
            <?php endif; ?>
			
		</tr>
	</thead>
	<tbody>

		<?php
		$products=$this->nc_wishlist_post_in_ids();
		if(sizeof($products)>0){
		$loop=new Wp_Query(array("post_type"=>"product","posts_per_page"=>-1,"post__in"=>$products,"order"=>"DESC"));
		while($loop->have_posts()):$loop->the_post(); 

			global $product;
	
				?>
				<tr>

					<td class="product-remove">
						<?php
							echo '<a href="javascript:void(0)" class="nc_wishlist_remove remove"  data-product_id="'.get_the_ID().'" >&times;</a>';
								
						?>
					</td>
				<?php if($nc_wishlist_settings['nc_wishlist_enable_image']==1): ?>
					<td class="product-thumbnail">
					<a href="<?php the_permalink(); ?>"><?php echo $product->get_image(); ?></a>
					</td>
				<?php endif; ?>
					<td class="product-name">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</td>
				<?php if($nc_wishlist_settings['nc_wishlist_enable_unit_price']==1): ?>
					<td class="product-price">
						<?php echo $product->get_price_html(); ?>
					</td>
                 <?php endif; ?>
                 
				<?php
				$stock_status= get_post_meta(get_the_ID(),'_stock_status',true); 
				 if($nc_wishlist_settings['nc_wishlist_enable_stock']==1): ?>
					<td class="product-stock">
					<?php
					 
					 $manage_stock= get_post_meta(get_the_ID(),'_manage_stock',true);
					 if($manage_stock=='no')
					 {
							$stock_message='In Stock';
						 
					 }
					 else
					 {
						 	$stock_message=$product->get_stock_quantity().' in Stock';
					 }
					echo ($stock_status=='instock') ? '<span class="stock in-stock">'.$stock_message.'</span>' : 
					'<span class="stock out-of-stock">Out of Stock</span>';
					?>	
					</td>
                    <?php endif; ?>
                    
                    <?php if($nc_wishlist_settings['nc_wishlist_enable_add_to_cart']==1): ?>
                    <td class="product-price">
					<?php

					if($stock_status=='instock'):
					if($product->is_type('simple'))
					{ 
					echo "<a id='nc_wishlist_add_cart' class='button' href='" . $product->add_to_cart_url() ."'>Add to Cart</a>";
					 }
					else 
					{
						
					 echo "<a id='nc_wishlist_add_cart' class='button' href='" . $product->add_to_cart_url() ."'>Select Options</a>";	
						
					}
					endif;
					?>	
					</td>
			<?php endif; ?>
            
				</tr>
				<?php
		endwhile; wp_reset_query();
		
		}
		else
		{
		echo "<tr><td colspan='6'>No Items found on your wishlist!</td></tr>";
	}
		?>
		

	</tbody>
</table>
</div>