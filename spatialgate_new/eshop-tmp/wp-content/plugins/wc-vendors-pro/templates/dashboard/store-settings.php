<?php
/**
 * The template for displaying the store settings form
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/
 *
 * @package    WCVendors_Pro
 * @version    1.2.3
 */

$settings_social 		= (array) WC_Vendors::$pv_options->get_option( 'hide_settings_social' );
$social_total = count( $settings_social ); 
$social_count = 0; 
foreach ( $settings_social as $value) { if ( 1 == $value ) $social_count +=1;  }

?>

<h3><?php _e( 'Settings', 'wcvendors-pro' ); ?></h3>

<form method="post" action="" class="wcv-form"> 

<?php WCVendors_Pro_Store_Form::form_data(); ?>

<div class="wcv-tabs top" data-prevent-url-change="true">

	<?php WCVendors_Pro_Store_Form::store_form_tabs( ); ?>

	<!-- Store Settings Form -->
	
	<div class="tabs-content" id="store">

		<!-- Store Name -->
		<?php WCVendors_Pro_Store_Form::store_name( $store_name ); ?>

		<?php do_action( 'wcvendors_settings_after_shop_name' ); ?>

		<!-- Store Description -->
		<?php WCVendors_Pro_Store_Form::store_description( $store_description ); ?>	
		
		<?php do_action( 'wcvendors_settings_after_shop_description' ); ?>
		<br />

		<!-- Seller Info -->
		<?php WCVendors_Pro_Store_Form::seller_info( ); ?>	
		
		
		<?php do_action( 'wcvendors_settings_after_seller_info' ); ?>

		<br />

		<!-- Company URL -->
		<?php WCVendors_Pro_Store_Form::company_url( ); ?>

		<!-- Store Phone -->
		<?php WCVendors_Pro_Store_Form::store_phone( ); ?>

		<?php WCVendors_Pro_Store_Form::store_address( ); ?>

	</div>

	<div class="tabs-content" id="payment">
		<!-- Paypal address -->
		<?php do_action( 'wcvendors_settings_before_paypal' ); ?>

		<?php WCVendors_Pro_Store_Form::paypal_address( ); ?>

		<?php do_action( 'wcvendors_settings_after_paypal' ); ?>
	</div>

	<div class="tabs-content" id="branding">
		<?php do_action( 'wcvendors_settings_before_branding' ); ?>

		<!-- Store Banner -->
		<?php WCVendors_Pro_Store_Form::store_banner( ); ?>	

		<!-- Store Icon -->
		<?php WCVendors_Pro_Store_Form::store_icon( ); ?>	

		<?php do_action( 'wcvendors_settings_after_branding' ); ?>
	</div>

	<div class="tabs-content" id="shipping">

		<?php do_action( 'wcvendors_settings_before_shipping' ); ?>

		<!-- Shipping Rates -->
		<?php WCVendors_Pro_Store_Form::shipping_rates( ); ?>
		
		<?php do_action( 'wcvendors_settings_after_shipping' ); ?>

	</div>

	<?php if ( $social_count != $social_total ) :  ?> 
		<div class="tabs-content" id="social">
			<!-- Twitter -->
			<?php WCVendors_Pro_Store_Form::twitter_username( ); ?>
			<!-- Instagram -->
			<?php WCVendors_Pro_Store_Form::instagram_username( ); ?>
			<!-- Facebook -->
			<?php WCVendors_Pro_Store_Form::facebook_url( ); ?>
			<!-- Linked in -->
			<?php WCVendors_Pro_Store_Form::linkedin_url( ); ?>
			<!-- Youtube URL -->
			<?php WCVendors_Pro_Store_Form::youtube_url( ); ?>
			<!-- Pinterest URL -->
			<?php WCVendors_Pro_Store_Form::pinterest_url( ); ?>
			<!-- Google+ URL -->
			<?php WCVendors_Pro_Store_Form::googleplus_url( ); ?>
		</div>
	<?php endif; ?>

	<!-- </div> -->
		<!-- Submit Button -->
		<!-- DO NOT REMOVE THE FOLLOWING TWO LINES -->
		<?php WCVendors_Pro_Store_Form::save_button( __( 'Save Changes', 'wcvendors-pro') ); ?>
</div>
	</form>
