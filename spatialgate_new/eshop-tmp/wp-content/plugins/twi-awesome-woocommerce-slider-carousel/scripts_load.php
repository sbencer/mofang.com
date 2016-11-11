<?php
/**
  * Loading CSS 
*/

function twi_awesome_woo_car_slider_css(){
     wp_enqueue_style( 'framework_woo_css', plugins_url( '/css/frameworks.min.css' , __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'twi_awesome_woo_car_slider_css' );

/**
  * Loading Javascript 
*/

function twi_awesome_woo_car_slider_js(){
	    wp_enqueue_script( 'framework_woo_js', plugins_url( '/js/frameworks.min.js' , __FILE__ ) , array('jquery') , false, false);
	    wp_enqueue_script( 'twi_woo_script', plugins_url( '/js/script.js' , __FILE__ ) , array('jquery') , false, true);
}
add_action( 'wp_enqueue_scripts', 'twi_awesome_woo_car_slider_js' );

/**
  * Loading Admin CSS 
*/
add_action( 'admin_print_styles', 'twi_woo_admin_css' );
add_action( 'wp_enqueue_scripts', 'twi_woo_admin_css' );
function twi_woo_admin_css(){
   if( is_admin() ) {
    wp_enqueue_style(
        "twi-woo-admin-twicss", 
        plugins_url( '/css/frameworks.min.css' , __FILE__ ), 
        false, 
        false, 
        "all"
    );
   }
}


require_once (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/conditional_js.php');