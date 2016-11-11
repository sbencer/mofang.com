<?php
/**
 * Template functions used for the site header.
 *
 * @package storefront
 */

if ( ! function_exists( 'storefront_header_widget_region' ) ) {
	/**
	 * Display header widget region
	 * @since  1.0.0
	 */
	function storefront_header_widget_region() {
		if ( is_active_sidebar( 'header-1' ) ) {
		?>
		<div class="header-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'header-1' ); ?>
			</div>
		</div>
		<?php
		}
	}
}

if ( ! function_exists( 'storefront_site_branding' ) ) {
	/**
	 * Display Site Branding
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_site_branding() {
		if ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
			//jetpack_the_site_logo();
			?>
			<div class="site-logo-link">
				<a href="http://www.spatialgate.com.tw/eshop/"><img src="http://www.spatialgate.com.tw/eshop/wp-content/uploads/2016/03/logo_2.jpg" width="270" height="79" alt=""/><a>
			</div>
			<?php
		} 
			else 
				{ ?>
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php if ( '' != get_bloginfo( 'description' ) ) { ?>
					<p class="site-description"><?php echo bloginfo( 'description' ); ?></p>
				<?php } ?>
			</div>
		<?php }
	}
}



if ( ! function_exists( 'storefront_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<button class="menu-toggle" aria-controls="primary-navigation" aria-expanded="false"><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( '選單', 'storefront' ) ) ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'primary',
					'container_class'	=> 'primary-navigation',
					)
			);

			wp_nav_menu(
				array(
					'theme_location'	=> 'handheld',
					'container_class'	=> 'handheld-navigation',
					)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'storefront_secondary_navigation' ) ) {
	/**
	 * Display Secondary Navigation
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_secondary_navigation() {
		?>
		<nav class="secondary-navigation" role="navigation" aria-label="<?php _e( 'Secondary Navigation', 'storefront' ); ?>">
			<?php
				wp_nav_menu(
					array(
						'theme_location'	=> 'secondary',
						'fallback_cb'		=> '',
					)
				);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'storefront_skip_links' ) ) {
	/**
	 * Skip links
	 * @since  1.4.1
	 * @return void
	 */
	function storefront_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php _e( 'Skip to navigation', 'storefront' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'storefront' ); ?></a>
		<?php
	}
}


