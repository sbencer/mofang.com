<?php
VP_Security::instance()->whitelist_function('twi_woo_st_dep_grid');

function twi_woo_st_dep_grid($value)
{
	if($value === 'twi_woo_grid' || $value === 'twi_woo_mansonry')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_woo_gap');
function twi_woo_gap($value)
{
	if($value === 'twi_woo_grid')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_woo_car_gap');
function twi_woo_car_gap($value)
{
	if($value === 'twi_woo_slider')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_woo_gutter');
function twi_woo_gutter($value)
{
	if($value === 'twi_woo_mansonry')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_slider_dep');

function twi_slider_dep($value)
{
	if($value === 'twi_woo_slider')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_car_nav_set');

function twi_car_nav_set($value)
{
	if($value === 'true')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_get_woo_short');
function twi_get_woo_short()
{
	$wp_posts = get_posts(array(
		'post_type' => 'twi_woo_g_car',
		'posts_per_page' => -1,
	));

	$result = array();
	foreach ($wp_posts as $post)
	{
		$result[] = array('value' => $post->ID, 'label' => $post->post_title);
	}
	return $result;
}
function twi_get_categories()
{
	$taxonomy = 'product_cat';
    $terms = get_terms( $taxonomy, '' );

	$res = array();
	foreach ($terms as $term)
	{
		$res[] = array('value' => $term->slug, 'label' => $term->name);
	}
	return $res;
}
VP_Security::instance()->whitelist_function('pagi_show_fun');

function pagi_show_fun($value)
{
	if($value === 'yes')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('twi_page_show_dep');

function twi_page_show_dep($value)
{
	if($value === 'true')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('woo_grid_pagi_fun');

function woo_grid_pagi_fun($pos,$text1,$bg1,$bor_col1,$bor_width1,$text2,$bg2,$bor_col2,$bor_width2,$bor_rad,$pad){
	ob_start(); ?>
     <style>
		.twi-pagination li a,.twi-pagination li.twi-active span{
			border-radius: <?php echo $bor_rad; ?>%;
			padding: <?php echo $pad; ?>px;
			width: 20px;
            height: 20px;
		}
		.twi-pagination li a{
			border: <?php echo $bor_width1; ?>px solid <?php echo $bor_col1; ?>;
		}
		.twi-pagination li a:hover,.twi-pagination li.twi-active span{
			border: <?php echo $bor_width2; ?>px solid <?php echo $bor_col2; ?>;
		}
		.twi-pagination li a{
			color: <?php echo $text1; ?>;
			background: <?php echo $bg1; ?>;
		}
		.twi-pagination li.twi-active span,.twi-pagination li a:hover{
			background: <?php echo $bg2; ?>;
			color: <?php echo $text2; ?>;
		}
     </style>
     <ul class="twi-pagination twi-pagination-<?php echo $pos; ?>">
	    <li><a href="#" class="prev page-numbers"><i class="twi-icon-chevron-left"></i></a></li>
        <li><a href="#" class="page-numbers">1</a></li>
        <li class="twi-active"><span class="page-numbers current">2</span></li>
        <li><a href="#" class="page-numbers">3</a></li>
        <li><a href="#" class="next page-numbers"><i class="twi-icon-chevron-right"></i></a></li>
    </ul>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_car_nav_fun');

function woo_car_nav_fun($nav_bg,$nav_txt,$nav_border,$nav_bor_wid,$nav_bor_rad,$nav_bg_h,$nav_txt_h,$nav_border_h){
	ob_start(); ?>
     <style>
        .owl-prev,.owl-next {
		    background: <?php echo $nav_bg; ?>;
		    border: <?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>!important;
		    color: <?php echo $nav_txt; ?>;
		    border-radius: <?php echo $nav_bor_rad; ?>%;
		}
		.owl-prev:hover,.owl-next:hover {
		    background: <?php echo $nav_bg_h; ?>;
		    border: <?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>!important;
		    color: <?php echo $nav_txt_h; ?>;
		}
     </style>
     <div class="owl-theme">
	     <div class="owl-controls">
	     	<div class="owl-nav">
	     		<div class="owl-prev" style="">
	     			<i class="twi-icon-chevron-left"></i>
	     		</div>
	     		<div class="owl-next" style="">
	     			<i class="twi-icon-chevron-right"></i>
	     		</div>
	     	</div>
	     </div>
     </div>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_car_pagi_fun');

function woo_car_pagi_fun($pagi_bg,$pagi_border,$pagi_bor_wid,$pagi_bor_rad,$pagi_bg_h,$pagi_border_h){
	ob_start(); ?>
     <style>
		.owl-theme .owl-dots .owl-dot span{
		    background: <?php echo $pagi_bg; ?>;
		    border: <?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>;
		    border-radius: <?php echo $pagi_bor_rad; ?>%;
		}
		.owl-theme .owl-dots .owl-dot span:hover,.owl-theme .owl-dots .owl-dot.active span{
			background: <?php echo $pagi_bg_h; ?>;
			border: <?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>;
		}
     </style>
     <div class="owl-theme">
	     <div class="owl-controls">
	     	<div class="owl-dots">
	     		<div class="owl-dot">
	     			<span></span>
	     		</div>
	     		<div class="owl-dot active">
	     			<span></span>
	     		</div>
	     		<div class="owl-dot">
	     			<span></span>
	     		</div>
	     	</div>
	     </div>
     </div>
	<?php return ob_get_clean();
}
VP_Security::instance()->whitelist_function('woo_no_pre_fun');

function woo_no_pre_fun($value)
{
	if($value === 'normal')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('woo_nor_live_preview');

function woo_nor_live_preview($font,$style,$weight,$nor_bg,$nor_border,$nor_bor_col,$nor_border_width,$nor_con_pos,$h3_col,$h3_col_hover,$h3_font_size,$h3_txt_trans,$fo_color,$fo_size,$star_color,$cart_col,$cart_col_hover,$cart_bg,$cart_bg_hover,$cart_bor,$cart_bor_hover,$cart_bor_wid,$cart_txt_trans,$cart_bor_rad,$cart_fo_size,$sale_bg,$sale_txt,$out_bg,$out_txt,$fe_bg,$fe_txt,$st_si){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font, $style, $weight);
	$links = $gwf->get_font_links();
	$link  = reset($links);
	?>
	<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
     <style>
		.nor .twi-panel{
			color: <?php echo $fo_color; ?>!important;
			background: <?php echo $nor_bg; ?>!important; 
			border:<?php echo $nor_border_width; ?>px solid <?php echo $nor_bor_col; ?>!important;
			border-radius: <?php echo $nor_border; ?>px!important;
		}
       .nor .twi_pro_title a,.nor .twi-panel,.nor .twi_cart a{
			font-family: <?php echo $font; ?>!important;
			font-style: <?php echo $style; ?>!important;
			font-weight: <?php echo $weight; ?>!important;
		}
		.nor .twi_pro_title a{
			text-transform: <?php echo $h3_txt_trans; ?>!important;
			color: <?php echo $h3_col; ?>!important;
			font-size: <?php echo $h3_font_size; ?>px!important;
		}
		.nor .twi_pro_title a:hover{
            color: <?php echo $h3_col_hover; ?>!important;
		}
		.nor .twi-price{
			font-size: <?php echo $fo_size; ?>px!important;
		}
		.nor .twi-rating{
            color: <?php echo $star_color; ?>!important;
            font-size: <?php echo $st_si; ?>px!important;
		}
		.nor .twi_cart a {
		    border: <?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor; ?>!important;
		    color: <?php echo $cart_col; ?>!important;
		    text-transform: <?php echo $cart_txt_trans; ?>!important;
		    background: <?php echo $cart_bg; ?>!important;
		    border-radius: <?php echo $cart_bor_rad; ?>px!important; 
		    font-size: <?php echo $cart_fo_size; ?>px!important;
		}
		.nor .twi_cart a:hover {
		    border: <?php echo $cart_bor_wid; ?>px solid <?php echo $cart_bor_hover; ?>!important;
		    color: <?php echo $cart_col_hover; ?>!important;
		    background: <?php echo $cart_bg_hover; ?>!important;
		}
		.nor .twi-sale{
		  background-color: <?php echo $sale_bg; ?> !important;
		  border-color: <?php echo $sale_bg; ?> !important;
		  color: <?php echo $sale_txt; ?> !important;
		}
		.nor .twi-out{
		  background-color: <?php echo $out_bg; ?> !important;
		  border-color: <?php echo $out_bg; ?> !important;
		  color: <?php echo $out_txt; ?> !important;
		}
		.nor .twi-fea{
		  background-color: <?php echo $fe_bg; ?> !important;
		  border-color: <?php echo $fe_bg; ?> !important;
		  color: <?php echo $fe_txt; ?> !important;
		}
		.nor .twi-fea,.nor .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border; ?>px!important;
		    border-top-left-radius: <?php echo $nor_border; ?>px!important;
		}
		.nor .twi-out {
		    border-top-right-radius: <?php echo $nor_border; ?>px!important;
		    border-bottom-left-radius: <?php echo $nor_border; ?>px!important;
		}
		.nor .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border; ?>px!important;
			border-top-left-radius: <?php echo $nor_border; ?>px!important;
		}
     </style>
     <div class="nor">
	     <div class="twi-panel twi-panel-box twi-text-<?php echo $nor_con_pos; ?>">
				<a class="twi-ui top left attached label teal twi-sale">Sale!</a>
				<a class="twi-ui top right attached label red twi-out">Out of stock</a>
				<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>		    
				<div class="twi-panel-teaser twi-rib">
				   <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>/images/demo.jpg"></a>
			    </div>
			    <div class="twi-details">
				    <h3 class="twi_pro_title">
					    <a href="#">Product 1</a>
				     </h3>
				     <div class="twi-price">
				     	<del><span class="amount">$120.00</span></del> 
				     	<ins><span class="amount">$100.00</span></ins>
				     </div>
				     <div class="twi-rating">
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star-half-o"></i>
				     	<i class="twi-icon-star-o"></i>
			        </div>
			        <div class="twi_cart twi-own-<?php echo $nor_con_pos; ?>">
				     	<a href="#">Add to cart</a>
				    </div>
			</div>
		</div>
	</div>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_img_pre_fun');

function woo_img_pre_fun($value)
{
	if($value === 'img_only')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('woo_img_live_preview');

function woo_img_live_preview($font_img,$style_img,$weight_img,$nor_border_img,$nor_bor_col_img,$nor_border_width_img,$sale_bg_img,$sale_txt_img,$out_bg_img,$out_txt_img,$fe_bg_img,$fe_txt_img){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font_img, $style_img, $weight_img);
	$links_img = $gwf->get_font_links();
	$link_img  = reset($links_img);
	?>
	<link href='<?php echo $link_img; ?>' rel='stylesheet' type='text/css'>
     <style>
		.twi_ho .twi-panel{
			color: <?php echo $fo_color_img; ?>!important; 
			border:<?php echo $nor_border_width_img; ?>px solid <?php echo $nor_bor_col_img; ?>!important;
			font-family: <?php echo $font_img; ?>!important;
			font-style: <?php echo $style_img; ?>!important;
			font-weight: <?php echo $weight_img; ?>!important;
			border-radius: <?php echo $nor_border_img; ?>px!important;
		}
		.twi_ho .twi-sale{
		  background-color: <?php echo $sale_bg_img; ?> !important;
		  border-color: <?php echo $sale_bg_img; ?> !important;
		  color: <?php echo $sale_txt_img; ?> !important;
		}
		.twi_ho .twi-out{
		  background-color: <?php echo $out_bg_img; ?> !important;
		  border-color: <?php echo $out_bg_img; ?> !important;
		  color: <?php echo $out_txt_img; ?> !important;
		}
		.twi_ho .twi-fea{
		  background-color: <?php echo $fe_bg_img; ?> !important;
		  border-color: <?php echo $fe_bg_img; ?> !important;
		  color: <?php echo $fe_txt_img; ?> !important;
		}
		.twi_ho .twi-fea,.twi_ho .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border_img; ?>px!important;
		    border-top-left-radius: <?php echo $nor_border_img; ?>px!important;
		}
		.twi_ho .twi-out {
		    border-top-right-radius: <?php echo $nor_border_img; ?>px!important;
		    border-bottom-left-radius: <?php echo $nor_border_img; ?>px!important;
		}
		.twi_ho .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border_img; ?>px!important;
			border-top-left-radius: <?php echo $nor_border_img; ?>px!important;
		}
     </style>
     <div class="twi_ho">
	     <div class="twi-panel twi-panel-box twi_img_only">
				<a class="twi-ui top left attached label teal twi-sale">Sale!</a>
				<a class="twi-ui top right attached label red twi-out">Out of stock</a>
				<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>		    
				<div class="twi-panel-teaser twi-rib">
				   <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>images/demo.jpg"></a>
			    </div>
		</div>
	</div>
	<?php return ob_get_clean();
}
VP_Security::instance()->whitelist_function('woo_hover_pre_fun');

function woo_hover_pre_fun($value)
{
	if($value === 'hover')
		return true;
	return false;
}
VP_Security::instance()->whitelist_function('woo_hover_live_preview');

function woo_hover_live_preview($font_ho,$style_ho,$weight_ho,$nor_bg_ho,$nor_border_ho,$nor_bor_col_ho,$nor_border_width_ho,$h3_col_ho,$h3_col_hover_ho,$h3_font_size_ho,$h3_txt_trans_ho,$fo_color_ho,$fo_size,$star_color,$cart_col,$cart_col_hover,$cart_bg,$cart_bg_hover,$cart_bor,$cart_bor_hover,$cart_bor_wid_ho,$cart_txt_trans_ho,$cart_bor_rad_ho,$cart_fo_size_ho,$sale_bg_ho,$sale_txt_ho,$out_bg_ho,$out_txt_ho,$fe_bg_ho,$fe_txt_ho,$st_si_ho,$over_eff_ho,$img_eff_ho,$title_an,$price_an,$rating_an,$cart_an){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font_ho, $style_ho, $weight_ho);
	$links_ho = $gwf->get_font_links();
	$link_ho  = reset($links_ho);
	?>
	<link href='<?php echo $link_ho; ?>' rel='stylesheet' type='text/css'>
     <style>
		.admin_hover_wrap .pic-twi-caption{
			background: <?php echo $nor_bg_ho; ?> !important;
			color: <?php echo $fo_color_ho; ?> !important;
		}
		.admin_hover_wrap .pic-twi{
			border: <?php echo $nor_border_width_ho; ?>px solid <?php echo $nor_bor_col_ho; ?>;
			border-radius: <?php echo $nor_border_ho; ?>%;
		}
       .admin_hover_wrap .twi_pro_title a,.admin_hover_wrap .twi-panel,.twi_cart a,.admin_hover_wrap .twi-price,.admin_hover_wrap .twi-sale,.admin_hover_wrap .twi-fea,.admin_hover_wrap .twi-out{
			font-family: <?php echo $font_ho; ?> !important;
			font-style: <?php echo $style_ho; ?> !important;
			font-weight: <?php echo $weight_ho; ?> !important;
		}
		.admin_hover_wrap .twi_pro_title a{
			text-transform: <?php echo $h3_txt_trans_ho; ?> !important;
			color: <?php echo $h3_col_ho; ?> !important;
			font-size: <?php echo $h3_font_size_ho; ?>px !important;
		}
		.admin_hover_wrap .twi_pro_title a:hover{
            color: <?php echo $h3_col_hover_ho; ?> !important;
		}
		.admin_hover_wrap .twi-price{
			font-size: <?php echo $fo_size; ?>px !important;
			color: <?php echo $fo_color_ho; ?> !important;
		}
		.admin_hover_wrap .twi-rating{
            color: <?php echo $star_color; ?> !important;
            font-size: <?php echo $st_si_ho; ?>px !important;
		}
		.admin_hover_wrap .twi_cart a {
		    border: <?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor; ?> !important;
		    color: <?php echo $cart_col; ?> !important;
		    text-transform: <?php echo $cart_txt_trans_ho; ?> !important;
		    background: <?php echo $cart_bg; ?> !important;
		    border-radius: <?php echo $cart_bor_rad_ho; ?>px !important; 
		    font-size: <?php echo $cart_fo_size_ho; ?>px !important;
		}
		.admin_hover_wrap .twi_cart a:hover {
		    border: <?php echo $cart_bor_wid_ho; ?>px solid <?php echo $cart_bor_hover; ?> !important;
		    color: <?php echo $cart_col_hover; ?> !important;
		    background: <?php echo $cart_bg_hover; ?> !important;
		}
		.admin_hover_wrap .twi-sale{
		  background-color: <?php echo $sale_bg_ho; ?> !important;
		  border-color: <?php echo $sale_bg_ho; ?> !important;
		  color: <?php echo $sale_txt_ho; ?> !important;
		}
		.admin_hover_wrap .twi-out{
		  background-color: <?php echo $out_bg_ho; ?> !important;
		  border-color: <?php echo $out_bg_ho; ?> !important;
		  color: <?php echo $out_txt_ho; ?> !important;
		}
		.admin_hover_wrap .twi-fea{
		  background-color: <?php echo $fe_bg_ho; ?> !important;
		  border-color: <?php echo $fe_bg_ho; ?> !important;
		  color: <?php echo $fe_txt_ho; ?> !important;
		}
		.admin_hover_wrap .twi-fea,.admin_hover_wrap .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border_ho; ?>px !important;
		    border-top-left-radius: <?php echo $nor_border_ho; ?>px !important;
		}
		.admin_hover_wrap .twi-out {
		    border-top-right-radius: <?php echo $nor_border_ho; ?>px !important;
		    border-bottom-left-radius: <?php echo $nor_border_ho; ?>px !important;
		}
		.admin_hover_wrap .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border_ho; ?>px !important;
			border-top-left-radius: <?php echo $nor_border_ho; ?>px !important;
		}
     </style>
     <div class="twi_js_code">
	     <script type="text/javascript">
	     jQuery(document).ready(function(){       
		       jQuery('.pic-twi-caption').each(function() {
		         jQuery(this).hover(function(){
		           jQuery( ".twi_cart" ).addClass("animated <?php echo $cart_an; ?>");
		           jQuery( ".twi_pro_title" ).addClass("animated <?php echo $title_an; ?>");
		           jQuery( ".twi-price" ).addClass("animated <?php echo $price_an; ?>");
		           jQuery( ".twi-rating" ).addClass("<?php echo $rating_an; ?>");
		         },function(){
		             jQuery( ".twi_cart" ).removeClass("animated <?php echo $cart_an; ?>");
		             jQuery( ".twi_pro_title" ).removeClass("animated <?php echo $title_an; ?>");
		             jQuery( ".twi-price" ).removeClass("animated <?php echo $price_an; ?>");
		             jQuery( ".twi-rating" ).removeClass("<?php echo $rating_an; ?>");
		         });   
		     });
		 });
	     </script>
	 </div>
     <div class="admin_hover_wrap">
	     <div class="pic-twi twi-overlay-hover">
	            <a class="twi-ui top left attached label teal twi-sale">Sale!</a>
				<a class="twi-ui top right attached label red twi-out">Out of stock</a>
				<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>		    
				<div class="twi-panel-teaser twi-rib">
				   <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>images/demo.jpg" class="<?php echo $img_eff_ho; ?>"></a>
			    </div>
			    <div class="pic-twi-caption <?php echo $over_eff_ho; ?>">
			    <div class="twi-details twi-overlay-panel twi-flex twi-flex-center twi-flex-middle twi-text-center twi-flex-column">
				    <h3 class="twi_pro_title">
					    <a href="#">Product 1</a>
				     </h3>
				     <div class="twi-price">
				     	<del><span class="amount">$120.00</span></del> 
				     	<ins><span class="amount">$100.00</span></ins>
				     </div>
				     <div class="twi-rating">
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star"></i>
				     	<i class="twi-icon-star-half-o"></i>
				     	<i class="twi-icon-star-o"></i>
			        </div>
			        <div class="twi_cart">
				     	<a href="#">Add to cart</a>
				    </div>
			 </div>
		 </div>
		</div>
	</div>
	<?php return ob_get_clean();
}

VP_Security::instance()->whitelist_function('woo_over_pre_fun');

function woo_over_pre_fun($value)
{
	if($value === 'overlay')
		return true;
	return false;
}

VP_Security::instance()->whitelist_function('woo_over_live_preview');

function woo_over_live_preview($font_over,$style_over,$weight_over,$nor_bg_over,$nor_border_over,$nor_bor_col_over,$nor_border_width_over,$h3_col_over,$h3_col_overver_over,$h3_font_size_over,$h3_txt_trans_over,$fo_color_over,$fo_size,$star_color,$cart_col,$cart_col_overver,$cart_bg,$cart_bg_overver,$cart_bor,$cart_bor_overver,$cart_bor_wid_over,$cart_txt_trans_over,$cart_bor_rad_over,$cart_fo_size_over,$sale_bg_over,$sale_txt_over,$out_bg_over,$out_txt_over,$fe_bg_over,$fe_txt_over,$st_si_over){
	ob_start(); 
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($font_over, $style_over, $weight_over);
	$links_over = $gwf->get_font_links();
	$link_over  = reset($links_over);
	?>
	<link href='<?php echo $link_over; ?>' rel='stylesheet' type='text/css'>
     <style>
		.admin_over_wrap .twi-overlay-background{
			background: <?php echo $nor_bg_over; ?> !important;
			color: <?php echo $fo_color_over; ?> !important;
		}
		.admin_over_wrap .twi-overlay{
			border: <?php echo $nor_border_width_over; ?>px solid <?php echo $nor_bor_col_over; ?>;
			border-radius: <?php echo $nor_border_over; ?>%;		
		}
       .admin_over_wrap .twi_pro_title a,.admin_over_wrap .twi-panel,.twi_cart a,.admin_over_wrap .twi-price,.admin_over_wrap .twi-sale,.admin_over_wrap .twi-fea,.admin_over_wrap .twi-out{
			font-family: <?php echo $font_over; ?> !important;
			font-style: <?php echo $style_over; ?> !important;
			font-weight: <?php echo $weight_over; ?> !important;
		}
		.admin_over_wrap .twi_pro_title a{
			text-transform: <?php echo $h3_txt_trans_over; ?> !important;
			color: <?php echo $h3_col_over; ?> !important;
			font-size: <?php echo $h3_font_size_over; ?>px !important;
		}
		.admin_over_wrap .twi_pro_title a:hover{
            color: <?php echo $h3_col_overver_over; ?> !important;
		}
		.admin_over_wrap .twi-price{
			font-size: <?php echo $fo_size; ?>px !important;
			color: <?php echo $fo_color_over; ?> !important;
		}
		.admin_over_wrap .twi-rating{
            color: <?php echo $star_color; ?> !important;
            font-size: <?php echo $st_si_over; ?>px !important;
		}
		.admin_over_wrap .twi_cart a {
		    border: <?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor; ?> !important;
		    color: <?php echo $cart_col; ?> !important;
		    text-transform: <?php echo $cart_txt_trans_over; ?> !important;
		    background: <?php echo $cart_bg; ?> !important;
		    border-radius: <?php echo $cart_bor_rad_over; ?>px !important; 
		    font-size: <?php echo $cart_fo_size_over; ?>px !important;
		}
		.admin_over_wrap .twi_cart a:hover {
		    border: <?php echo $cart_bor_wid_over; ?>px solid <?php echo $cart_bor_overver; ?> !important;
		    color: <?php echo $cart_col_overver; ?> !important;
		    background: <?php echo $cart_bg_overver; ?> !important;
		}
		.admin_over_wrap .twi-sale{
		  background-color: <?php echo $sale_bg_over; ?> !important;
		  border-color: <?php echo $sale_bg_over; ?> !important;
		  color: <?php echo $sale_txt_over; ?> !important;
		}
		.admin_over_wrap .twi-out{
		  background-color: <?php echo $out_bg_over; ?> !important;
		  border-color: <?php echo $out_bg_over; ?> !important;
		  color: <?php echo $out_txt_over; ?> !important;
		}
		.admin_over_wrap .twi-fea{
		  background-color: <?php echo $fe_bg_over; ?> !important;
		  border-color: <?php echo $fe_bg_over; ?> !important;
		  color: <?php echo $fe_txt_over; ?> !important;
		}
		.admin_over_wrap .twi-fea,.admin_overver_wrap .twi-sale {
		    border-bottom-right-radius: <?php echo $nor_border_over; ?>px !important;
		    border-top-left-radius: <?php echo $nor_border_over; ?>px !important;
		}
		.admin_over_wrap .twi-out {
		    border-top-right-radius: <?php echo $nor_border_over; ?>px !important;
		    border-bottom-left-radius: <?php echo $nor_border_over; ?>px !important;
		}
		.admin_over_wrap .twi-panel-teaser img{
			border-top-right-radius: <?php echo $nor_border_over; ?>px !important;
			border-top-left-radius: <?php echo $nor_border_over; ?>px !important;
		}
     </style>
     <div class="admin_over_wrap">
        <figure class="twi-overlay">
        	<a class="twi-ui top left attached label teal twi-sale">Sale!</a>
			<a class="twi-ui top right attached label red twi-out">Out of stock</a>
			<a class="twi-ui bottom right attached label teal twi-fea">Featured</a>
            <a href="#"><img src="<?php echo TWI_AWESOME_WOO_SLIDER_CAROUSEL_URL; ?>images/demo.jpg"></a>
                <figcaption class="twi-overlay-panel twi-overlay-background twi-flex twi-flex-center twi-flex-middle twi-text-center">
                    <div class="twi_pro_detail">
                         <h3 class="twi_pro_title">
					        <a href="#">Product 1</a>
					     </h3>
					     <div class="twi-price">
					     	<del><span class="amount">$120.00</span></del> 
					     	<ins><span class="amount">$100.00</span></ins>
					     </div>
					     <div class="twi-rating">
					     	<i class="twi-icon-star"></i>
					     	<i class="twi-icon-star"></i>
					     	<i class="twi-icon-star"></i>
					     	<i class="twi-icon-star-half-o"></i>
					     	<i class="twi-icon-star-o"></i>
				        </div>
				        <div class="twi_cart">
					     	<a href="#">Add to cart</a>
					    </div>
                    </div>
                </figcaption>
        </figure>
	</div>
	<?php return ob_get_clean();
}
?>