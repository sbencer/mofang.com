<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since      1.0.1
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public/includes
 */
?>
<?php 	$this->nc_wishlist_settings=get_option('nc_wishlist_settings');	 ?>
 <script type="text/javascript">  
  jQuery.noConflict();
	jQuery(document).ready(function($){	
	 $("span.nc_wishlist_loader").hide();
	 $("#nc_wishlist_message").hide();
	 $('span#nc_wishlist_added').hide();
	 

     $('.add_to_wishlist_button').click(function(){
		 var id_new=$(this).attr("id");
		 $("span#"+id_new).show();
		var prod_id= $(this).attr("data-product_id");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: { action: "nc_wishlist_action", 
				product_id: prod_id,
				action_id : "add"
           		  },
			success: function(result)				{
			if (result[0].response == 'success') {	
			$("span#"+id_new).hide();
			$('a#'+id_new).text('Product added!');
			$('.nc_wishlist_added_'+prod_id).css("display","block");
			$('a#'+id_new).attr('href','<?php echo get_permalink($this->nc_wishlist_settings['nc_wishlist_page']); ?>')
			.text('<?php echo 	$this->nc_wishlist_settings['nc_wishlist_view_wishlist_text']; ?>').attr("id","");
			setTimeout(function(){$('.nc_wishlist_added_'+prod_id).fadeOut(); }, 500);

			
			}
			
				}
       				 });
						  });
			  
		 $('.nc_wishlist_remove').click(function(){
		var prod_id= $(this).attr("data-product_id");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: { action: "nc_wishlist_action", 
				product_id: prod_id,
				action_id : "remove"
           		  },
			success: function(result)				{
			if (result[0].response == 'removed') {
				
				location.href="<?php get_permalink($this->nc_wishlist_settings['nc_wishlist_page']); ?>";
				}
		
				}
       				 });
						  });
				  	 
    							});
	</script>