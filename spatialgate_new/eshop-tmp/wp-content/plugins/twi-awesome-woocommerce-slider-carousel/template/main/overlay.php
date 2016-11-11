     <div class="twi_woo_over twi_over_<?php echo $twi_i; ?>" data-id=".twi_over_<?php echo $twi_i; ?>" data-font="<?php echo $over_font; ?>" data-style="<?php echo $over_style; ?>" data-weight="<?php echo $over_weight; ?>" data-cap-bg="<?php echo $over_cap_bg; ?>" data-bor="<?php echo $nor_border_width_over; ?>px solid <?php echo $nor_bor_col_over; ?>" data-bor-rad="<?php echo $nor_border_over; ?>%" data-ti-te="<?php echo $h3_txt_trans_over; ?>" data-col="<?php echo $h3_col; ?>" data-col-ho="<?php echo $h3_col_over; ?>" data-font-si="<?php echo $h3_font_size_over; ?>px" data-pr-fo="<?php echo $fo_size; ?>px" data-pr-col="<?php echo $fo_col; ?>" data-rt-fo="<?php echo $rt_size; ?>px" data-rt-col="<?php echo $rt_col; ?>" data-ca-bo="<?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor; ?>" data-ca-bo-ho="<?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor_over; ?>" data-ca-col="<?php echo $cart_col; ?>" data-ca-col-ho="<?php echo $cart_col_over; ?>" data-ca-te="<?php echo $cart_txt_trans_over; ?>" data-ca-bg="<?php echo $cart_bg; ?>" data-ca-bg-ho="<?php echo $cart_bg_over; ?>" data-ca-fo="<?php echo $cart_fo_size_over; ?>px" data-ca-rad="<?php echo $cart_bor_rad_over; ?>px" data-sale-col="<?php echo $sale_txt_over; ?>" data-sale-bg="<?php echo $sale_bg_over; ?>" data-out-col="<?php echo $out_txt_over; ?>" data-out-bg="<?php echo $out_bg_over; ?>" data-fe-col="<?php echo $fe_txt_over; ?>" data-fe-bg="<?php echo $fe_bg_over; ?>">
        <div class="twi-overlay">
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
                <div class="twi-overlay-panel twi-overlay-background twi-flex twi-flex-center twi-flex-middle twi-text-center">
                    <div class="twi_pro_detail">
                         <h3 class="twi_pro_title" data-title="<?php echo $ti_hide; ?>">
						    <a href="<?php echo get_permalink(); ?>">
						        <?php echo get_the_title(); ?>
						     </a>
					     </h3>
					     <div class="twi_price" data-price="<?php echo $pr_hide; ?>"><?php echo $product->get_price_html(); ?></div>
					     <div class="twi_rating" data-rate="<?php echo $ra_hide; ?>"><center><?php echo $product->get_rating_html(); ?></center></div>
					     <div class="twi_cart" data-cart="<?php echo $cart_hide; ?>">
					     	<a href="<?php echo $product->add_to_cart_url(); ?>"><?php echo $product->add_to_cart_text(); ?></a>
					     </div>
                    </div>
                </div>
        </div>
	</div>