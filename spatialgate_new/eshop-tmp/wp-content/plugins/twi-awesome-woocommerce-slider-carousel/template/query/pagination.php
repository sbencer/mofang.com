<?php
if ( $loop->max_num_pages <= 1 )
	return;
if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
 } else if ( get_query_var('page') ) {
    $paged = get_query_var('page');
 } else{
    $paged = 1;
 }
?>
<ul class="twi-pagination twi-pagination-<?php echo $car_pagi_pos; ?> gp<?php echo $twi_i; ?>" data-id= ".gp<?php echo $twi_i; ?>" data-text1="<?php echo $text1; ?>" data-text2="<?php echo $text2; ?>" data-bg1="<?php echo $bg1; ?>" data-bg2="<?php echo $twi_bg2; ?>" data-bor1="<?php echo $bor_width1.'px solid '.$bor_col1; ?>" data-bor2="<?php echo $bor_width2.'px solid '.$bor_col2; ?>" data-rad="<?php echo $bor_rad; ?>%" data-pad="<?php echo $pad; ?>px">
	<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         	=> esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),			
			'format' 		=> '',
			'current'      	=> max( 1, $paged ),
			'total'        	=> $loop->max_num_pages,
			'prev_text' 	=> '<i class="twi-icon-chevron-left"></i>',
			'next_text' 	=> '<i class="twi-icon-chevron-right"></i>',
			'type'			=> 'plain',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) ) );
	?>
</ul>