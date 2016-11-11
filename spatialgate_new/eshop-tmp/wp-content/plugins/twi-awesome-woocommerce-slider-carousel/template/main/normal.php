		<div class="twi-text-<?php echo $nor_con_pos; ?> twi-panel twi-panel-box twi_woo_nor twi_nor_<?php echo $twi_i; ?>" data-id=".twi_nor_<?php echo $twi_i; ?>" data-font="<?php echo $nor_font; ?>" data-style="<?php echo $nor_style; ?>" data-weight="<?php echo $nor_weight; ?>" data-fo-color="<?php echo $fo_color; ?>" data-nor-bg="<?php echo $nor_bg; ?>" data-fo-size="<?php echo $fo_size; ?>px" data-nor-border="<?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>" data-ti-trans="<?php echo $h3_txt_trans; ?>" data-ti-col="<?php echo $h3_col; ?>" data-ti-si="<?php echo $h3_font_size; ?>px" data-ti-col-h="<?php echo $h3_col_hover; ?>" data-cart-bor="<?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor; ?>" data-cart-bor-h="<?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor_hover; ?>" data-cart-col="<?php echo $cart_col; ?>" data-cart-col-h="<?php echo $cart_col_hover; ?>" data-cart-trans="<?php echo $cart_txt_trans; ?>" data-cart-bg="<?php echo $cart_bg; ?>" data-cart-bg-h="<?php echo $cart_bg_hover; ?>" data-cart-rad="<?php echo $cart_bor_rad; ?>px" data-cart-si="<?php echo $cart_fo_size; ?>px" data-star-col="<?php echo $star_color; ?>" data-sale-col="<?php echo $sale_txt; ?>" data-sale-bg="<?php echo $sale_bg; ?>" data-out-col="<?php echo $out_txt; ?>" data-out-bg="<?php echo $out_bg; ?>" data-fe-col="<?php echo $fe_txt; ?>" data-fe-bg="<?php echo $fe_bg; ?>" data-main-bor="<?php echo $nor_border; ?>px" data-st-si="<?php echo $st_si; ?>px">
			<?php 
			   if($rib_dis == 'yes'){
			      require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/rib/rib.php'); 
			   }
			?>
		    <div class="twi-panel-teaser <?php if( $rib_dis == 'yes' && !$product->is_featured() && ($product->is_on_sale() || !$product->is_in_stock()) ){ echo 'twi-rib'; } if(!$product->is_featured() && ($product->is_on_sale() && !$product->is_in_stock()) ){echo "undefine"; } ?>">
			    	<a href="<?php echo get_permalink(); ?>">
			        <?php if(has_post_thumbnail()) {
				            echo get_the_post_thumbnail($loop->post->ID, 'shop_single' ); 
				         }else{ 
				         	echo woocommerce_placeholder_img( 'shop_single' );
				        } 
			        ?>
			        </a>
		    </div>
		    <div class="twi-details">
			    <h3 class="twi_pro_title" data-title="<?php echo $ti_hide; ?>">
				    <a href="<?php echo get_permalink(); ?>">
				        <?php echo get_the_title(); ?>
				     </a>
			     </h3>
			     <div class="twi_price" data-price="<?php echo $pr_hide; ?>"><?php echo $product->get_price_html(); ?></div>
			     <div class="twi_rating twi-own-<?php echo $nor_con_pos; ?>" data-rate="<?php echo $ra_hide; ?>"><?php echo $product->get_rating_html(); ?></div>
			     <div class="twi_cart twi-own-<?php echo $nor_con_pos; ?>" data-cart="<?php echo $cart_hide; ?>">
			     	<a href="<?php echo $product->add_to_cart_url(); ?>"><?php echo $product->add_to_cart_text(); ?></a>
			     </div>
		   </div>
		</div>