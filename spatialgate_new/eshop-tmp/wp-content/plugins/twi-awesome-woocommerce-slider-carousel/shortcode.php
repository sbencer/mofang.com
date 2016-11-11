<?php
function twi_woo_g_c_s_function($twi_woo_short,$content = null ){
	ob_start('twi_woo_removeWhitespace');
	extract( shortcode_atts( array(
		'p_id' => ''
	 ), $twi_woo_short) );

	 $args = array(
			'p' => $p_id, 
			'post_type' => 'twi_woo_g_car'
	 );
	 if($p_id != NULL ){
	 	
	 $the_query = new WP_Query($args);
	 // The Loop
	 if ($the_query->have_posts()) {
	 	while ( $the_query->have_posts() ) {
				$the_query->the_post();

	$i = mt_rand(1,10000);
	$uid = "woo_uid_".$i;
	$twi_i = mt_rand(1, 100000);
	

	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/variables/variables.php');

 	 	if($twi_woo_style == 'twi_woo_grid'){
 	 	     require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/grid.php');
 	 	} //if Grid
 	 	if($twi_woo_style == 'twi_woo_slider' ){
 	 	     require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/slider.php');
 	 	} //if Slider
 	 	if($twi_woo_style == 'twi_woo_mansonry' ){
 	 	     require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/pinterest.php');
 	 	} //if Pinterest

	do_action('twi_woo_g_c_s_function');

	    }
       // Content While Loop
     }
     //if Loop
    }else{
    	echo "<h5 style='color:red;'>You didn't select any any Grid/Slider/Carousel for your woocommerce productss. Please create at least one Grid/Slider/Carousel first.</h5>";
    }
    //if NULL value
    wp_reset_query();
	$content = ob_get_clean();
	return $content;
}
add_shortcode('twi_woo_shortcode','twi_woo_g_c_s_function');
add_filter( 'widget_text', 'do_shortcode');
?>