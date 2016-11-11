		<div class="pic-twi twi-overlay-hover twi_ho_eff twi_ho_<?php echo $twi_i; ?>" data-id=".twi_ho_<?php echo $twi_i; ?>" data-font="<?php echo $ho_font; ?>" data-style="<?php echo $ho_style; ?>" data-weight="<?php echo $ho_weight; ?>" data-cap-bg="<?php echo $ho_cap_bg; ?>" data-img-eff="<?php echo $ho_img_eff; ?>" data-bor="<?php echo $nor_border_width_ho; ?>px solid <?php echo $nor_bor_col_ho; ?>" data-bor-rad="<?php echo $nor_border_ho; ?>%" data-ti-te="<?php echo $h3_txt_trans_ho; ?>" data-col="<?php echo $h3_col; ?>" data-col-ho="<?php echo $h3_col_ho; ?>" data-font-si="<?php echo $h3_font_size_ho; ?>px" data-pr-fo="<?php echo $fo_size; ?>px" data-pr-col="<?php echo $fo_col; ?>" data-rt-fo="<?php echo $rt_size; ?>px" data-rt-col="<?php echo $rt_col; ?>" data-ca-bo="<?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor; ?>" data-ca-bo-ho="<?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor_hover; ?>" data-ca-col="<?php echo $cart_col; ?>" data-ca-col-ho="<?php echo $cart_col_hover; ?>" data-ca-te="<?php echo $cart_txt_trans_ho; ?>" data-ca-bg="<?php echo $cart_bg; ?>" data-ca-bg-ho="<?php echo $cart_bg_hover; ?>" data-ca-fo="<?php echo $cart_fo_size_ho; ?>px" data-ca-rad="<?php echo $cart_bor_rad_ho; ?>px" data-sale-col="<?php echo $sale_txt_ho; ?>" data-sale-bg="<?php echo $sale_bg_ho; ?>" data-out-col="<?php echo $out_txt_ho; ?>" data-out-bg="<?php echo $out_bg_ho; ?>" data-fe-col="<?php echo $fe_txt_ho; ?>" data-fe-bg="<?php echo $fe_bg_ho; ?>">
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
		    <div class="pic-twi-caption twi_ho_anima <?php echo $over_eff_ho; ?>" data-cart="animated <?php echo $cart_an; ?>" data-title="animated <?php echo $title_an; ?>" data-price="animated <?php echo $price_an; ?>" data-rating="animated <?php echo $rating_an; ?>">
			    <div class="twi-details twi-overlay-panel twi-flex twi-flex-center twi-flex-middle twi-text-center twi-flex-column">
				    <h3 class="twi_pro_title" data-title="<?php echo $ti_hide; ?>">
					    <a href="<?php echo get_permalink(); ?>">
					        <?php echo get_the_title(); ?>
					     </a>
				     </h3>
				     <div class="twi_price" data-price="<?php echo $pr_hide; ?>"><?php echo $product->get_price_html(); ?></div>
				     <div class="twi_rating" data-rate="<?php echo $ra_hide; ?>"><?php echo $product->get_rating_html(); ?></div>
				     <div data-cart="<?php echo $cart_hide; ?>">
				        <a rel="nofollow" href="<?php echo $product->add_to_cart_url(); ?>" data-quantity="<?php echo isset( $quantity ) ? $quantity : 1; ?>" data-product_id="<?php echo $product->id; ?>" data-product_sku="<?php echo $product->get_sku; ?>" class=" add_to_cart_button "><img src="http://www.spatialgate.com.tw/eshop/wp-content/uploads/2016/04/icon_cart_buy.png" width="27px" height="27px" alt=""/></a>
				     </div>
			   </div>
			</div>
		</div>