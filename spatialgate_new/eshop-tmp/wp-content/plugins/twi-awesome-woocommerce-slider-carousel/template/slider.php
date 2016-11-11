<?php
  // Woocommerce Default
  if($twi_temp_style == 'woo_style'):
?>
<ul class="products woocommerce twi-grid twi-grid-width-xlarge-1-<?php echo $xlarge; ?> twi-grid-width-large-1-<?php echo $large; ?> twi-grid-width-medium-1-<?php echo $medium; ?> twi-grid-width-small-1-<?php echo $small; ?> twi-grid-width-1-<?php echo $default; ?>">
	<?php
        require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');
		require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/woo.php');
	?>
</ul><!--/.products-->

<?php
   endif;
  // Responsive Grids
  if($twi_temp_style == 'normal'):
?>
<?php
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($nor_font, $nor_style, $nor_weight);
    $links = $gwf->get_font_links();
    $link  = reset($links);
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div class="twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%">
	<?php
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');
	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<div class="item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/normal.php');
       ?>
	</div>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	wp_reset_postdata();
	?>
</div>
<?php endif; ?>

<?php 
   // Only Image
   if($twi_temp_style == 'img_only'):
?>
<?php
    $gwf   = new VP_Site_GoogleWebFont();
    $gwf->add($nor_font, $nor_style, $nor_weight);
    $links = $gwf->get_font_links();
	$link  = reset($links);
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div class="twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%">
	<?php
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');
	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<div class="item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/image_only.php');
       ?>
	</div>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	wp_reset_postdata();
	?>
</div>
<?php endif; ?>

<?php 
   // Hover Effects
   if($twi_temp_style == 'hover'):
?>
<?php
   $gwf   = new VP_Site_GoogleWebFont();
   $gwf->add($ho_font, $ho_style, $ho_weight);
   $links = $gwf->get_font_links();
   $link  = reset($links);
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div class="twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%">
	<?php
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');
	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<div class="item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/hover.php');
       ?>
	</div>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	wp_reset_postdata();
	?>
</div>
<?php endif; ?>

<?php 
   // Hover Effects
   if($twi_temp_style == 'overlay'):
?>
<?php
    $gwf   = new VP_Site_GoogleWebFont();
	$gwf->add($over_font, $over_style, $over_weight);
	$links = $gwf->get_font_links();
	$link  = reset($links);
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<?php if($car_page == 'true'){ ?>
<style type="text/css">.woo_slider_<?php echo $twi_i; ?> .owl-dot.active span{background: <?php echo $pagi_bg_h;?>!important; border:<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>!important;}</style>
<?php } ?>
<div class="twi-woo-slider woocommerce woo_slider_<?php echo $twi_i; ?> <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> <?php if($car_nav=='true'){ echo $nav_pos; } ?>" data-id=".woo_slider_<?php echo $twi_i; ?>" data-autoplay="<?php echo $autoplay; ?>" data-gap="<?php echo $items_gap; ?>" data-l-desk="<?php echo $l_desk; ?>" data-desk="<?php echo $desk; ?>" data-tablet="<?php echo $tablet; ?>" data-phone-big="<?php echo $phone_big; ?>" data-phone="<?php echo $phone; ?>" data-nav="<?php echo $car_nav; ?>" data-page="<?php echo $car_page; ?>" data-hover="<?php echo $car_hover; ?>" data-time="<?php echo $auto_time*1000; ?>" data-nav-bg="<?php echo $nav_bg;?>" data-nav-ar="<?php echo $nav_txt; ?>" data-nav-border="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border; ?>" data-nav-bg-h="<?php echo $nav_bg_h;?>" data-nav-ar-h="<?php echo $nav_txt_h; ?>" data-nav-border-h="<?php echo $nav_bor_wid; ?>px solid <?php echo $nav_border_h; ?>" data-nav-rad="<?php echo $nav_bor_rad; ?>%" data-pagi-bg="<?php echo $pagi_bg;?>" data-pagi-border="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border; ?>" data-pagi-bg-h="<?php echo $pagi_bg_h;?>" data-pagi-border-h="<?php echo $pagi_bor_wid; ?>px solid <?php echo $pagi_border_h; ?>" data-pagi-rad="<?php echo $pagi_bor_rad; ?>%">
	<?php
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');
	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<div class="item">
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/overlay.php');
       ?>
	</div>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	wp_reset_postdata();
	?>
</div>
<?php endif; ?>