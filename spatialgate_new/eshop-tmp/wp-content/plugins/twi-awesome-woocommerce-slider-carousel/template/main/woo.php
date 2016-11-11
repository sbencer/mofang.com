<?php
$loop = new WP_Query( $query_args );
if ( $loop->have_posts() ) {
	while ( $loop->have_posts() ) : $loop->the_post();
		wc_get_template_part( 'content', 'product' );
	endwhile;
} else {
	echo __( 'No products found' );
}
wp_reset_postdata();
?>