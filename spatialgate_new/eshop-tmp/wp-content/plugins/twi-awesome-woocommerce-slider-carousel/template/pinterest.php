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
<ul class="twi-grid woocommerce <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> twi-grid-width-xlarge-1-<?php echo $xlarge; ?> twi-grid-width-large-1-<?php echo $large; ?> twi-grid-width-medium-1-<?php echo $medium; ?> twi-grid-width-small-1-<?php echo $small; ?> twi-grid-width-1-<?php echo $default; ?>" data-twi-grid="{gutter:<?php echo $gutter; ?>,animation:false}">
	<?php
    require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');

	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<li>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/normal.php');
       ?>
	</li>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	?>
</ul>
<?php 
if($car_pagi == 'yes'){
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/pagination.php'); 
}
endif; 
wp_reset_postdata();
?>

<?php
  // Image Only
  if($twi_temp_style == 'img_only'):
?>
<?php
    $gwf   = new VP_Site_GoogleWebFont();
    $gwf->add($nor_font, $nor_style, $nor_weight);
    $links = $gwf->get_font_links();
	$link  = reset($links);
?>
<link href='<?php echo $link; ?>' rel='stylesheet' type='text/css'>
<ul class="twi-grid woocommerce <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> twi-grid-width-xlarge-1-<?php echo $xlarge; ?> twi-grid-width-large-1-<?php echo $large; ?> twi-grid-width-medium-1-<?php echo $medium; ?> twi-grid-width-small-1-<?php echo $small; ?> twi-grid-width-1-<?php echo $default; ?>" data-twi-grid="{gutter:<?php echo $gutter; ?>,animation:false}">
	<?php
    require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');

	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<li>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/image_only.php');
       ?>
	</li>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	?>
</ul>
<?php 
if($car_pagi == 'yes'){
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/pagination.php'); 
}
endif; 
wp_reset_postdata();
?>

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
<ul class="twi-grid woocommerce <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> twi-grid-width-xlarge-1-<?php echo $xlarge; ?> twi-grid-width-large-1-<?php echo $large; ?> twi-grid-width-medium-1-<?php echo $medium; ?> twi-grid-width-small-1-<?php echo $small; ?> twi-grid-width-1-<?php echo $default; ?> twi-grid-small twi-grid-match" data-twi-grid-margin>
	<?php
    require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');

	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<li>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/hover.php');
       ?>
	</li>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	?>
</ul>
<?php 
if($car_pagi == 'yes'){
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/pagination.php'); 
}
endif; 
wp_reset_postdata();
?>

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
<ul class="twi-grid woocommerce <?php if($twi_full=='yes'){ echo 'twi-forced-fullwidth';}else{ echo 'undefine'; } ?> twi-grid-width-xlarge-1-<?php echo $xlarge; ?> twi-grid-width-large-1-<?php echo $large; ?> twi-grid-width-medium-1-<?php echo $medium; ?> twi-grid-width-small-1-<?php echo $small; ?> twi-grid-width-1-<?php echo $default; ?>" data-twi-grid="{gutter:<?php echo $gutter; ?>,animation:false}">
	<?php
    require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/query.php');

	$loop = new WP_Query( $query_args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();
		global $product;
	?>
	<li>
       <?php
         require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/main/overlay.php');
       ?>
	</li>
	<?php 
      endwhile;
		} else {
			echo __( 'No products found' );
		}
	?>
</ul>
<?php 
if($car_pagi == 'yes'){
	require (TWI_AWESOME_WOO_SLIDER_CAROUSEL_DIR .'/template/query/pagination.php'); 
}
endif; 
wp_reset_postdata();
?>
