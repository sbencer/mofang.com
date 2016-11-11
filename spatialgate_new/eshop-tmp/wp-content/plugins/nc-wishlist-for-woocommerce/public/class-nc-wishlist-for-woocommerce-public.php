<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    nc-wishlist-for-woocommerce
 * @subpackage nc-wishlist-for-woocommerce/public
 * @author     Nabaraj Chapagain <nabarajc6@gmail.com>
 */
class NC_WISHLIST_FOR_WOOCOMMERCE_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	/**
	 * The settings data for wishlist
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      array    $nc_wishlist_settings    The settings data for wishlist
	 */
	private $nc_wishlist_settings;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;	
		add_shortcode( 'nc_wishlist', array($this,'nc_wishlist_display_shortcode') );	
	

	}
	

	/**
	 * session start if no started
	 *
	 * @since    1.0.1
	 */	
	
	public function nc_wishlist_register_session()
	{
   		 if( !session_id())
       		 session_start();
	}
	
	
	/**
	 * identifying if user is logged in or not and prepare array for the wishlist table
	 *
	 * @since    1.0.1
	 */		
	
	public function nc_wishlist_post_in_ids()
	{
		global $wpdb;
		$products=array();
		if(is_user_logged_in())
		{
			$user_id=get_current_user_id();
			$ids=$wpdb->get_results( "select product_id from " . $wpdb->prefix . "nc_wishlist  where user_id='$user_id'");	
				foreach($ids as $id)
					{
					$products[]=$id->product_id;	
					}
         }
		else
			{
				$products=$_SESSION['nc_wihslist_items'];	
			} 
						 
				return $products;
	}
	
	/**
	 * function for shortcode
	 *
	 * @since    1.0.1
	 */		
	 public function nc_wishlist_display_shortcode( ) {
		 	$this->nc_wishlist_settings=get_option('nc_wishlist_settings');	 
			if($this->nc_wishlist_settings['nc_wishlist_enabling']!='1')
			return;
			include_once('includes/nc-wishlist-for-woocommerce-contents.php');
				
		 }
		 
	
	/**
	 * nc wishlist button
	 *
	 * @since    1.0.1
	 */			 
		 
	 public function nc_wishlist_button(){
			 $this->nc_wishlist_settings=get_option('nc_wishlist_settings');	
		    if($this->nc_wishlist_settings['nc_wishlist_enabling']!='1')
			return;
			
			global $product,$wpdb;
			$this->nc_wishlist_settings=get_option('nc_wishlist_settings');	
			$logged_in=$this->nc_wishlist_settings['nc_wishlist_for'];
			$show_in_shop=$this->nc_wishlist_settings['nc_wishlist_show_in_shop_page'];
			
			if($this->nc_wishlist_settings['nc_wishlist_for']=='logged_in_users')
			{
			  if(!is_user_logged_in())
			  return;
			}
			
			if($show_in_shop!=1 && (is_shop() || is_tax("product_cat")))
			{
			  
			  return;
				
			}
			
			$product_added=array();
			  if(!is_user_logged_in())
			  {
			 		if(empty($_SESSION['nc_wihslist_items'])): 
			  		else:
					      $product_added=$_SESSION['nc_wihslist_items'];
			  		endif;
			  }
			 else
			 {  
				  $products=$wpdb->get_results ( "select product_id from " . $wpdb->prefix . "nc_wishlist  where user_id=".get_current_user_id());			
				  $i=0;
				     foreach($products as $product_new)
					 {
					    	$product_added[$i]=$product_new->product_id;	
							$i++;	
					}	 
			  }
			 if(!in_array($product->id,$product_added)): ?>
		 				<a href="javascript:void(0)" rel="nofollow" data-product_id="<?php echo $product->id; ?>"
                         id="nc_wishlist_add_<?php echo $product->id; ?>"  class="button add_to_wishlist_button">
						 <?php printf(esc_html('%s',$this->plugin_name),$this->nc_wishlist_settings['nc_wishlist_add_to_wishlist_text']); ?>
						<span class="nc_wishlist_loader" id="nc_wishlist_add_<?php echo $product->id; ?>"  
                        style="display:inline-block;background: url(<?php echo plugin_dir_url( __FILE__ ); ?>images/ajax-loader.gif) no-repeat; 						height:11px; width:16px"></span></a>
						<span id="nc_wishlist_added" class="nc_wishlist_added_<?php echo $product->id; ?>">
						<?php _e('Product Added!',$this->plugin_name); ?></span>
			<?php else: ?>
			  
				 <a href="<?php echo get_permalink(esc_attr($this->nc_wishlist_settings['nc_wishlist_page'])); ?>" 
                 rel="nofollow"   class="button view_wishlist_button">
				 <?php printf(esc_html('%s',$this->plugin_name),$this->nc_wishlist_settings['nc_wishlist_view_wishlist_text']); ?></a> 
				 
			<?php endif;
			 
		}
			 

	/**
	 * add product to wishlist for logged in user
	 * @param    string   $product_id   The id for the product
	 * @since    1.0.1
	 */			 
	  public function nc_wishlist_add_product_to_wishlist_logged_in_user($product_id)
	  {
		  
		    $this->nc_wishlist_settings=get_option('nc_wishlist_settings');	
		    if($this->nc_wishlist_settings['nc_wishlist_enabling']!='1')
			return;
			
			global $wpdb; 
	        $duplicate=$wpdb->get_results ( "select * from " . $wpdb->prefix . "nc_wishlist  where product_id=".$product_id);
			  if(!$duplicate)
			  {
				 
			         $insert=$wpdb->query("insert  into " . $wpdb->prefix . "nc_wishlist(user_id,product_id,wishlist_created) 
					 values('".get_current_user_id( )."','".$product_id."','".date("Y-m-d")."')"); 
				 
							if($insert) echo '[{"response":"success"}]'; exit;
				 }	
				
		} 
		
	/**
	 * session data to table if user logged in after adding products to wishlist
	 *
	 * @since    1.0.1
	 */			
		public	function nc_wishlist_transfer_session_data_to_table_logged_user()
		{
			$this->nc_wishlist_settings=get_option('nc_wishlist_settings');	
		    if($this->nc_wishlist_settings['nc_wishlist_enabling']!='1')
			return;
				
				if(is_user_logged_in() && $_SESSION['nc_wihslist_items'])
				{
				  global $wpdb; 	
				  $products=$_SESSION['nc_wihslist_items'];
				    foreach($products as $prod)
					{
				        $duplicate=$wpdb->get_results ( "select * from " . $wpdb->prefix . "nc_wishlist  where product_id=".$prod);
				             if(!$duplicate)
							 {
				              $insert=$wpdb->query("insert  into " . $wpdb->prefix . "nc_wishlist(user_id,product_id,wishlist_created) 
				              values('".get_current_user_id( )."','".$prod."','".date("Y-m-d")."')"); 
							 }	
					}
					unset($_SESSION['nc_wihslist_items']);
				}
		}
		
		
	/**
	 * add product to wishlist for non logged in user
	 * @param    string   $product_id   The id for the product
	 * @since    1.0.1
	 */	
	 		
		public	function nc_wishlist_add_product_to_wishlist_normal_user($product_id)
		{
						
					$name = "nc_wihslist_items";
					empty($_SESSION[$name])? $value=array() : $value=$_SESSION[$name];
					$product=array(); $new_value=array();
					$product[]=$product_id;
					$new_value=array_merge($value,$product);
					$_SESSION[$name]=$new_value;
					     
						 if($_SESSION[$name]) echo '[{"response":"success"}]';  exit;	
					     
						
						
		}
		
	/**
	 * remove product from wishlist for normal user
	 * @param    string   $product_id   The id for the product
	 * @since    1.0.1
	 */			
		
		public function nc_wishlist_remove_product_from_wishlist_normal_user($product_id)
		{	 
				  $arr = $_SESSION['nc_wihslist_items'];
				  $arr_new = array_diff($arr, array($product_id));
            	  $_SESSION['nc_wihslist_items']=$arr_new;
				  echo '[{"response":"removed"}]';
                  exit;		
				 
		}
		
		
		
	/**
	 * remove product from wishlist for  logged in user
	 * @param    string   $product_id   The id for the product
	 * @since    1.0.1
	 */			
				
		
		public	function nc_wishlist_remove_product_from_wishlist_logged_user($product_id)
		{
				
			global $wpdb; 
			$remove=$wpdb->query("DELETE FROM ".$wpdb->prefix."nc_wishlist WHERE product_id=".$product_id );
			  if($remove) echo '[{"response":"removed"}]';
			  exit;	
				
		}
		
	/**
	 * wishlist action add,remove etc
	 *
	 * @since    1.0.1
	 */				
		public function nc_wishlist_action()
		{
				
				$product_id=$_POST['product_id'];
				$action=$_POST['action_id'];
					if($action=='add' && is_user_logged_in())
					{
					$this->nc_wishlist_add_product_to_wishlist_logged_in_user($product_id);
					}
					
					else if($action=='add' && !is_user_logged_in())
					{
						
					$this->nc_wishlist_add_product_to_wishlist_normal_user($product_id);	
						
					}
					
					else if($action=='remove' && is_user_logged_in())
					{
			
					$this->nc_wishlist_remove_product_from_wishlist_logged_user($product_id);	
						
					}
					
					else if($action=='remove' && !is_user_logged_in())
					{
				
					$this->nc_wishlist_remove_product_from_wishlist_normal_user($product_id);	
						
					}
		 }
		 
	/**
	 * nc wishlist ajax script
	 *
	 * @since    1.0.1
	 */			 
	public function nc_wishlist_ajax_script()
	
	 { 
	
			include_once('includes/nc-wishlist-for-woocommerce-ajax.php');
	
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'-custom-css', plugin_dir_url( __FILE__ ) . 'css/nc-wishlist-for-woocommerce-custom-style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * function to add on init action
	 *
	 * @since    1.0.1
	 */	
	public function nc_ajax_cart_public_init(){

		$this->nc_wishlist_register_session();
		$this->nc_wishlist_transfer_session_data_to_table_logged_user();

		
		}

}
