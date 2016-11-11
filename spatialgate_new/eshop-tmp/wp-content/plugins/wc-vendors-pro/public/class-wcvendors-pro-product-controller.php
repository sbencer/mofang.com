<?php
/**
 * The main WCVendors Pro Product Controller class
 *
 * This is the main controller class for products, all actions are defined in this class. 
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/public
 * @author     Jamie Madden <support@wcvendors.com>
 */
class WCVendors_Pro_Product_Controller {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wcvendors_pro    The ID of this plugin.
	 */
	private $wcvendors_pro;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Is the plugin in debug mode 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $debug    plugin is in debug mode 
	 */
	private $debug;

	/**
	 * Is the plugin base directory 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $base_dir  string path for the plugin directory 
	 */
	private $base_dir;

	/**
	 * Max number of pages for pagination 
	 *
	 * @since    1.2.4
	 * @access   public
	 * @var      int    $max_num_pages  interger for max number of pages for the query
	 */
	public $max_num_pages; 

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wcvendors_pro     The name of the plugin.
	 * @param      string    $version    		The version of this plugin.
	 * @param      bool 	 $debug    			If the plugin is currently in debug mode 
	 */
	public function __construct( $wcvendors_pro, $version, $debug ) {

		$this->wcvendors_pro 	= $wcvendors_pro;
		$this->version 			= $version;
		$this->debug 			= $debug; 
		$this->base_dir			= plugin_dir_path( dirname(__FILE__) ); 
 
	}

	/**
	 *  Process the form submission from the front end. 
	 *
	 * @since    1.0.0
	 */
	public function process_submit() { 

		if ( ! isset( $_POST[ '_wcv-save_product' ] ) || !wp_verify_nonce( $_POST[ '_wcv-save_product' ], 'wcv-save_product' ) || !is_user_logged_in() ) { 
			return; 
		}

		$can_submit_live = WC_Vendors::$pv_options->get_option( 'can_submit_live_products' ); 
		$can_edit_approved = WC_Vendors::$pv_options->get_option( 'can_edit_approved_products' ); 
		$trusted_vendor = ( get_user_meta( get_current_user_id(), '_wcv_trusted_vendor', true ) == 'on' ) ? true: false;
		$untrusted_vendor = ( get_user_meta( get_current_user_id(), '_wcv_untrusted_vendor', true ) == 'on' ) ? true: false;

		if ( $trusted_vendor ) $can_submit_live = true; 
		if ( $untrusted_vendor ) $can_submit_live = false; 

		$text = array( 'notice' => '', 'type' => 'success' ); 

		if ( isset( $_POST[ 'post_id' ] ) && is_numeric( $_POST[ 'post_id' ]) ) { 
		
			$post_id = $this->save_product( (int) ( $_POST[ 'post_id' ] ) ); 

			if ( $post_id ) {

				$view 	= get_permalink( $post_id );  

				if ( $can_submit_live ) { 
					$text['notice'] = sprintf( __( 'Product Updated. <a href="%s">View product.</a>', 'wcvendors-pro' ), $view );
				} elseif( $can_edit_approved ) {
					$text['notice'] = sprintf( __( 'Product Updated. <a href="%s">View product.</a>', 'wcvendors-pro' ), $view );
				} else { 
					$text['notice'] = sprintf( __( 'Product submitted for review. <a href="%s">Preview product.</a>', 'wcvendors-pro' ), $view );
				}

			} else { 
				$text['notice'] = __( 'There was a problem editing the product.', 'wcvendors-pro' );
				$text['type'] = 'error'; 
			}

		} else  { 

			$post_id = $this->save_product(); 

			$view 	= get_permalink( $post_id ); 

			if ( $post_id ) { 
				if ( isset( $_POST[ 'draft_button' ] )) { 
					if ( $can_submit_live ) { 
						$text['notice'] = sprintf( __( 'Product draft saved.', 'wcvendors-pro' ), $view );
					} else { 
						$text['notice'] = sprintf( __( 'Product draft saved, pending review.', 'wcvendors-pro' ), $view );
					}
				} else { 
					if ( $can_submit_live ) { 
						$text['notice'] = sprintf( __( 'Product Added. <a href="%s">View product.</a>', 'wcvendors-pro' ), $view );
					} else { 
						$text['notice'] = sprintf( __( 'Product submitted for review. <a href="%s">Preview product.</a>', 'wcvendors-pro' ), $view );
					}
				}
			} else { 
				$text['notice'] = __( 'There was a problem adding the product.', 'wcvendors-pro' );
				$text['type'] = 'error'; 
			}				
		}
		
		wc_add_notice( $text['notice'], $text['type'] ); 
		
	} // process_submit() 

	/**
	 *  Process the delete action 
	 *
	 * @since    1.0.0
	 */
	public function process_delete( ) { 

		global $wp; 

		if ( isset( $wp->query_vars[ 'object' ] ) ) {

			$object 	= get_query_var( 'object' ); 
			$action 	= get_query_var( 'action' ); 
			$id 		= get_query_var( 'object_id' ); 
			
			if ( $object == 'product' && $action == 'delete' && is_numeric( $id ) ) { 

				if ( $id != null ) { 
					if ( WCVendors_Pro_Dashboard::check_object_permission( 'products', $id ) == false ) { 
						return false; 
					} 
				}

				if ( WCVendors_Pro::get_option( 'vendor_product_trash' ) == 0 || null === WCVendors_Pro::get_option( 'vendor_product_trash' ) ) { 
					$update = wp_update_post( array( 'ID' => $id, 'post_status' => 'trash' ) ); 
				} else { 
					$update = wp_delete_post( $id ); 					
				}

				if (is_object( $update ) || is_numeric( $update ) ) { 
					$text = __( 'Product Deleted.', 'wcvendors-pro' );
				} else { 
					$text = __( 'There was a problem deleting the product.', 'wcvendors-pro' ); 
				}

				wc_add_notice( $text ); 

				wp_safe_redirect( WCVendors_Pro_Dashboard::get_dashboard_page_url( 'product' ) ); 
				exit;
			}

	    }
	} // process_delete() 

	/**
	 *  Save a new product 
	 * 
	 * @since    1.0.0
	 * @param 	 int 	$post_id
	 * @return   mixed 	$post_id or WP_Error
	 */
	public function save_product( $post_id = 0 ) {

		// error_log( print_r( $_POST, true ) );

		// Work on adding filters and option checks to publish to draft instead of straight to live 
		$can_submit_live = WC_Vendors::$pv_options->get_option( 'can_submit_live_products' ); 
		$can_edit_live = WC_Vendors::$pv_options->get_option( 'can_edit_published_products' ); 
		$can_edit_approved = WC_Vendors::$pv_options->get_option( 'can_edit_approved_products' ); 

		$post_status = ''; 
		
		if ( isset( $_POST[ 'draft_button' ] ) ) { 
			$post_status = 'draft'; 
		} else { 
			
			$post_status = $can_submit_live ? 'publish' : 'pending'; 

			if ( 0 !== $post_id ) {

				$post_status = ( $can_edit_live && $can_submit_live || $can_edit_approved ) ? 'publish' : 'pending'; 
			} 
		}

		// Bypass globals for live product submissions 
		$trusted_vendor = ( get_user_meta( get_current_user_id(), '_wcv_trusted_vendor', true ) == 'on' ) ? true: false;
		$untrusted_vendor = ( get_user_meta( get_current_user_id(), '_wcv_untrusted_vendor', true ) == 'on' ) ? true: false;
		
		if ( $trusted_vendor ) $post_status = 'publish'; 
		if ( $untrusted_vendor ) $post_status = 'pending'; 

		$_product = array(
			'post_title'   => wc_clean( $_POST[ 'post_title' ] ),
			'post_status'  => $post_status,
			'post_type'    => 'product',
			'post_excerpt' => ( isset( $_POST[ 'post_excerpt' ] ) ? $_POST[ 'post_excerpt' ] : '' ),
			'post_content' => ( isset( $_POST[ 'post_content' ] ) ? $_POST[ 'post_content' ] : '' ),
			'post_author'  => get_current_user_id(),
		);

		if ( 0 !== $post_id ) { 
			$_product['ID'] = $post_id; 
			$product_id = wp_update_post( $_product, true );
		} else { 
			// Attempts to create the new product
			$product_id = wp_insert_post( $_product, true );
		}

		// Checks for an error in the product creation
		if ( is_wp_error( $product_id ) ) {
			return null; 
		}

		// Featured Image 
		if ( isset( $_POST[ '_featured_image_id' ] ) && '' !== $_POST[ '_featured_image_id' ] ) { 
			set_post_thumbnail( $product_id, (int) $_POST[ '_featured_image_id' ] ); 
		} else { 
			delete_post_thumbnail( $product_id ); 
		}

		// // Gallery Images 
		if ( isset( $_POST[ 'product_image_gallery' ] ) && '' !== $_POST[ 'product_image_gallery' ] ) {
				update_post_meta( $product_id, '_product_image_gallery', $_POST[ 'product_image_gallery' ] );
		} else { 
			update_post_meta( $product_id, '_product_image_gallery', '' );
		}
		
		// Categories 
		if ( isset( $_POST[ 'product_cat' ] ) && is_array( $_POST[ 'product_cat' ] ) ) { 
			$categories = array_map( 'intval', $_POST[ 'product_cat' ] ); 
			$categories = array_unique( $categories ); 

			wp_set_post_terms( $product_id, $categories, 'product_cat' ); 
		} else { 
			// No categories selected so reset them
			wp_set_post_terms( $product_id, null, 'product_cat' ); 
		}

		//  Tags 
		if ( isset( $_POST[ 'product_tags' ] ) && '' !== $_POST[ 'product_tags' ] ) {

			$post_tags = explode(',', $_POST[ 'product_tags' ] ); 
			$tags = array(); 

			foreach ( $post_tags as $post_tag ) {
				$existing_tag = get_term( $post_tag, 'product_tag' );  

				if ( $existing_tag != null ) { 
					$tags[] = $existing_tag->slug; 
				} else { 
					$tags[] = $post_tag; 
				}
			}

			$tags = array_unique( $tags ); 
			$tags = implode( ',', $tags ); 

			wp_set_post_terms( $product_id, $tags, 'product_tag' ); 
		} else { 
			// No tags selected so reset them
			wp_set_post_terms( $product_id, null, 'product_tag' ); 
		}

		// Base product saved now save all meta fields 
		$this->save_meta( $product_id ); 

		do_action( 'wcv_save_product', $product_id ); 

		return $product_id; 
	} // save_product()


	/**
	 *  Save product meta 
	 * 
	 * @since    1.0.0
	 * @param 	 int 	$post_id
	 */
	public function save_meta( $post_id ) { 

		global $wpdb;

		// Add any default post meta
		add_post_meta( $post_id, 'total_sales', '0', true );

		// Set catalog visibility
		if ( isset( $_POST['_private_listing'] ) ) { 
			update_post_meta( $post_id, '_visibility', 'hidden' );
			update_post_meta( $post_id, '_private_listing', $_POST['_private_listing'] );
		} else { 
			update_post_meta( $post_id, '_visibility', 'visible' );
			delete_post_meta( $post_id, '_private_listing' );
		}
		

		// Get types
		$product_type    = empty( $_POST['product-type'] ) ? 'simple' : sanitize_title( stripslashes( $_POST['product-type'] ) );
		$is_downloadable = isset( $_POST['_downloadable'] ) ? 'yes' : 'no';
		$is_virtual      = isset( $_POST['_virtual'] ) ? 'yes' : 'no';

		// Product type + Downloadable/Virtual
		wp_set_object_terms( $post_id, $product_type, 'product_type' );
		update_post_meta( $post_id, '_downloadable', $is_downloadable );
		update_post_meta( $post_id, '_virtual', $is_virtual );

		// Update post meta
		if ( isset( $_POST['_regular_price'] ) ) {
			update_post_meta( $post_id, '_regular_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
		}

		if ( isset( $_POST['_sale_price'] ) ) {
			update_post_meta( $post_id, '_sale_price', ( $_POST['_sale_price'] === '' ? '' : wc_format_decimal( $_POST['_sale_price'] ) ) );
		}

		if ( isset( $_POST['_tax_status'] ) ) {
			update_post_meta( $post_id, '_tax_status', wc_clean( $_POST['_tax_status'] ) );
		}

		if ( isset( $_POST['_tax_class'] ) ) {
			update_post_meta( $post_id, '_tax_class', wc_clean( $_POST['_tax_class'] ) );
		}
	
		// Featured
		if ( update_post_meta( $post_id, '_featured', isset( $_POST['_featured'] ) ? 'yes' : 'no' ) ) {
			delete_transient( 'wc_featured_products' );
		}

		// Dimensions
		if ( 'no' == $is_virtual ) {

			$shipping_details = array(); 

			if ( isset( $_POST['_shipping_fee_national'] ) && '' !=  $_POST['_shipping_fee_national'] ) {
				$shipping_details['national'] =  wc_format_decimal( $_POST['_shipping_fee_national'] ); 
			} else {
				$shipping_details['national'] = ''; 
			}

			if ( isset( $_POST['_shipping_fee_international'] ) && '' != $_POST['_shipping_fee_international'] ) {
				$shipping_details['international'] =  wc_format_decimal( $_POST['_shipping_fee_international'] ); 
			} else{ 
				$shipping_details['international'] = ''; 
			}

			if ( isset( $_POST['_handling_fee'] ) && '' != $_POST['_handling_fee'] ) {
				$shipping_details['handling_fee'] = sanitize_text_field( $_POST['_handling_fee'] );
			} else { 
				$shipping_details['handling_fee'] = ''; 
			}

			if ( isset( $_POST['_shipping_fee_national_qty'] ) && '' != $_POST['_shipping_fee_national_qty'] ) {
				$shipping_details['national_qty_override'] = $_POST['_shipping_fee_national_qty']; 
			} else { 
				$shipping_details['national_qty_override'] = ''; 
			}

			if ( isset( $_POST['_shipping_fee_national_disable'] ) && '' != $_POST['_shipping_fee_national_disable'] ) {
				$shipping_details['national_disable'] = $_POST['_shipping_fee_national_disable']; 
			} else { 
				$shipping_details['national_disable'] = ''; 
			}

			if ( isset( $_POST['_shipping_fee_national_free'] ) && '' != $_POST['_shipping_fee_national_free'] ) {
				$shipping_details['national_free'] = $_POST['_shipping_fee_national_free']; 
			} else { 
				$shipping_details['national_free'] = ''; 
			}

			if ( isset( $_POST['_shipping_fee_international_qty'] ) && '' != $_POST['_shipping_fee_international_qty'] ) {
				$shipping_details['international_qty_override'] = $_POST['_shipping_fee_international_qty']; 
			} else { 
				$shipping_details['international_qty_override'] = ''; 
			}

			if ( isset( $_POST['_shipping_fee_international_disable'] ) && '' != $_POST['_shipping_fee_international_disable'] ) {
				$shipping_details['international_disable'] = $_POST['_shipping_fee_international_disable']; 
			} else { 
				$shipping_details['international_disable'] = ''; 
			}

			if ( isset( $_POST['_shipping_fee_international_free'] ) && '' != $_POST['_shipping_fee_international_free'] ) {
				$shipping_details['international_free'] = $_POST['_shipping_fee_international_free']; 
			} else { 
				$shipping_details['international_free'] = ''; 
			}

			if ( ! empty( $shipping_details ) ) { 
				update_post_meta( $post_id, '_wcv_shipping_details',  $shipping_details  );
			} else { 
				delete_post_meta( $post_id, '_wcv_shipping_details' ); 
			}

			if ( isset( $_POST['_weight'] ) ) {
				update_post_meta( $post_id, '_weight', ( '' === $_POST['_weight'] ) ? '' : wc_format_decimal( $_POST['_weight'] ) );
			}

			if ( isset( $_POST['_length'] ) ) {
				update_post_meta( $post_id, '_length', ( '' === $_POST['_length'] ) ? '' : wc_format_decimal( $_POST['_length'] ) );
			}

			if ( isset( $_POST['_width'] ) ) {
				update_post_meta( $post_id, '_width', ( '' === $_POST['_width'] ) ? '' : wc_format_decimal( $_POST['_width'] ) );
			}

			if ( isset( $_POST['_height'] ) ) {
				update_post_meta( $post_id, '_height', ( '' === $_POST['_height'] ) ? '' : wc_format_decimal( $_POST['_height'] ) );
			}

			// shipping rates 
			$shipping_rates = array();

			if ( isset( $_POST['_wcv_shipping_fees'] ) ) {
				$shipping_countries    	= isset( $_POST['_wcv_shipping_countries'] ) ? $_POST['_wcv_shipping_countries'] : array(); 
				$shipping_states    	= isset( $_POST['_wcv_shipping_states'] ) ? $_POST['_wcv_shipping_states'] : array();
				$shipping_fees     		= isset( $_POST['_wcv_shipping_fees'] )  ? $_POST['_wcv_shipping_fees'] : array();
				$shipping_fee_count 	= sizeof( $shipping_fees );

				for ( $i = 0; $i < $shipping_fee_count; $i ++ ) {
					if ( $shipping_fees[ $i ] != '' ) {
						$country       = wc_clean( $shipping_countries[ $i ] ); 
						$state         = wc_clean( $shipping_states[ $i ] );
						$fee           = wc_format_decimal( $shipping_fees[ $i ] );
						$shipping_rates[ $i ] = array(
							'country'	=> $country,
							'state' 	=> $state, 
							'fee' 		=> $fee,
						);
					}
				}
				update_post_meta( $post_id, '_wcv_shipping_rates',  $shipping_rates  );
			} else { 

				delete_post_meta( $post_id, '_wcv_shipping_rates' );
			}

			


		} else {
			update_post_meta( $post_id, '_weight', '' );
			update_post_meta( $post_id, '_length', '' );
			update_post_meta( $post_id, '_width', '' );
			update_post_meta( $post_id, '_height', '' );
		}

		// Save shipping class
		if ( isset( $_POST['product_shipping_class'] ) ) {
			$product_shipping_class = $_POST['product_shipping_class'] > 0 && $product_type != 'external' ? absint( $_POST['product_shipping_class'] ) : '';
			wp_set_object_terms( $post_id, $product_shipping_class, 'product_shipping_class');
		} 

		// Unique SKU
		if ( isset( $_POST['_sku'] ) ) {

			$sku     = get_post_meta( $post_id, '_sku', true );
			$new_sku = wc_clean( stripslashes( $_POST['_sku'] ) );

			if ( '' == $new_sku ) {
				update_post_meta( $post_id, '_sku', '' );
			} elseif ( $new_sku !== $sku ) {

				if ( ! empty( $new_sku ) ) {

					$unique_sku = wc_product_has_unique_sku( $post_id, $new_sku );

					if ( ! $unique_sku ) {
						WC_Admin_Meta_Boxes::add_error( __( 'Product SKU must be unique.', 'woocommerce' ) );
					} else {
						update_post_meta( $post_id, '_sku', $new_sku );
					}
				} else {
					update_post_meta( $post_id, '_sku', '' );
				}
			}
		}

		// Save Attributes
		$attributes = array();

		if ( isset( $_POST['attribute_names'] ) && isset( $_POST['attribute_values'] ) ) {

			$attribute_names  = $_POST['attribute_names'];
			$attribute_values = $_POST['attribute_values'];

			$attribute_names_count = sizeof( $attribute_names );

			if ( isset( $_POST['attribute_variation'] ) ) {
				$attribute_variation = $_POST['attribute_variation'];
			}

			$pos = 0; 

			for ( $i = 0; $i < $attribute_names_count; $i++ ) {

				if ( ! $attribute_names[ $i ] ) {
					continue;
				}

				$is_variation = isset( $attribute_variation[ $i ] ) ? 1 : 0;

				if ( isset( $attribute_values[ $i ] ) ) {

					// Select based attributes - Format values (posted values are slugs)
					$values = array_map( 'sanitize_title', $attribute_values[ $i ] );

					// Remove empty items in the array
					$values = array_filter( $values, 'strlen' );

				} else {
					$values = array();
				}

				// Update post terms
				if ( taxonomy_exists( $attribute_names[ $i ] ) ) {
					wp_set_object_terms( $post_id, $values, $attribute_names[ $i ] );
				}

				if ( $values ) {
					// Add attribute to array, but don't set values
					// TODO: add filters for position, visible 
					$attributes[ sanitize_title( $attribute_names[ $i ] ) ] = array(
						'name'         => wc_clean( $attribute_names[ $i ] ),
						'value'        => '',
						'position'     => $pos,
						'is_visible'   => 1, 
						'is_variation' => $is_variation,
						'is_taxonomy'  => 1
					);
				}
				$pos++; 
			}
		}

		if ( ! function_exists( 'attributes_cmp' ) ) {
			function attributes_cmp( $a, $b ) {
				if ( $a['position'] == $b['position'] ) {
					return 0;
				}

				return ( $a['position'] < $b['position'] ) ? -1 : 1;
			}
		}
		uasort( $attributes, 'attributes_cmp' );

		update_post_meta( $post_id, '_product_attributes', $attributes );


		// Sales and prices
		if ( in_array( $product_type, apply_filters( 'wcv_product_meta_types',  array( 'variable', 'grouped' ) ) ) ) {

			// Variable and grouped products have no prices
			update_post_meta( $post_id, '_regular_price', '' );
			update_post_meta( $post_id, '_sale_price', '' );
			update_post_meta( $post_id, '_sale_price_dates_from', '' );
			update_post_meta( $post_id, '_sale_price_dates_to', '' );
			update_post_meta( $post_id, '_price', '' );

		} else {

			$date_from = isset( $_POST['_sale_price_dates_from'] ) ? wc_clean( $_POST['_sale_price_dates_from'] ) : '';
			$date_to   = isset( $_POST['_sale_price_dates_to'] ) ? wc_clean( $_POST['_sale_price_dates_to'] ) : '';

			// Dates
			if ( $date_from ) {
				update_post_meta( $post_id, '_sale_price_dates_from', strtotime( $date_from ) );
			} else {
				update_post_meta( $post_id, '_sale_price_dates_from', '' );
			}

			if ( $date_to ) {
				update_post_meta( $post_id, '_sale_price_dates_to', strtotime( $date_to ) );
			} else {
				update_post_meta( $post_id, '_sale_price_dates_to', '' );
			}

			if ( $date_to && ! $date_from ) {
				update_post_meta( $post_id, '_sale_price_dates_from', strtotime( 'NOW', current_time( 'timestamp' ) ) );
			}

			// Update price if on sale
			if ( isset( $_POST['_sale_price'] ) && '' !== $_POST['_sale_price'] && '' == $date_to && '' == $date_from ) {
				update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_sale_price'] ) );
			} else {
				update_post_meta( $post_id, '_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
			}

			if ( '' !== $_POST['_sale_price'] && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
				update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_sale_price'] ) );
			}

			if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
				update_post_meta( $post_id, '_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
				update_post_meta( $post_id, '_sale_price_dates_from', '' );
				update_post_meta( $post_id, '_sale_price_dates_to', '' );
			}
		}


		// Sold Individually
		if ( ! empty( $_POST['_sold_individually'] ) ) {
			update_post_meta( $post_id, '_sold_individually', 'yes' );
		} else {
			update_post_meta( $post_id, '_sold_individually', '' );
		}

		// Stock Data
		if ( isset( $_POST['_stock_status'] ) ) { 

			if ( 'yes' === get_option( 'woocommerce_manage_stock' ) ) {

				$manage_stock = 'no';
				$backorders   = 'no';
				$stock_status = wc_clean( $_POST['_stock_status'] );

				if ( 'external' === $product_type ) {

					$stock_status = 'instock';

				} elseif ( 'variable' === $product_type ) {

					// Stock status is always determined by children so sync later
					$stock_status = '';

					if ( ! empty( $_POST['_manage_stock'] ) ) {
						$manage_stock = 'yes';
						$backorders   = wc_clean( $_POST['_backorders'] );
					}

				} elseif ( 'grouped' !== $product_type && ! empty( $_POST['_manage_stock'] ) ) {
					$manage_stock = 'yes';
					$backorders   = wc_clean( $_POST['_backorders'] );
				}

				update_post_meta( $post_id, '_manage_stock', $manage_stock );
				update_post_meta( $post_id, '_backorders', $backorders );

				if ( $stock_status ) {
					wc_update_product_stock_status( $post_id, $stock_status );
				}

				if ( ! empty( $_POST['_manage_stock'] ) ) {
					wc_update_product_stock( $post_id, wc_stock_amount( $_POST['_stock'] ) );
				} else {
					update_post_meta( $post_id, '_stock', '' );
				}

			} else {
				wc_update_product_stock_status( $post_id, wc_clean( $_POST['_stock_status'] ) );
			}
		} else { 
			// Set default to be instock if not managed at all.
			wc_update_product_stock_status( $post_id, wc_clean( 'instock' ) );
		}


		// Downloadable options
		if ( 'yes' == $is_downloadable ) {

			$_download_limit = absint( $_POST['_download_limit'] );
			if ( ! $_download_limit ) {
				$_download_limit = ''; // 0 or blank = unlimited
			}

			$_download_expiry = absint( $_POST['_download_expiry'] );
			if ( ! $_download_expiry ) {
				$_download_expiry = ''; // 0 or blank = unlimited
			}

			// file paths will be stored in an array keyed off md5(file path)
			$files = array();

			if ( isset( $_POST['_wc_file_urls'] ) ) {
				$file_names    = isset( $_POST['_wc_file_names'] ) ? $_POST['_wc_file_names'] : array();
				$file_urls     = isset( $_POST['_wc_file_urls'] )  ? array_map( 'trim', $_POST['_wc_file_urls'] ) : array();
				$file_url_size = sizeof( $file_urls );

				for ( $i = 0; $i < $file_url_size; $i ++ ) {
					if ( ! empty( $file_urls[ $i ] ) ) {
						$file_url            = ( 0 !== strpos( $file_urls[ $i ], 'http' ) ) ? wc_clean( $file_urls[ $i ] ) : esc_url_raw( $file_urls[ $i ] );
						$file_name           = wc_clean( $file_names[ $i ] );
						$file_hash           = md5( $file_url );
						$files[ $file_hash ] = array(
							'name' => $file_name,
							'file' => $file_url
						);
					}
				}
			}

			// grant permission to any newly added files on any existing orders for this product prior to saving
			do_action( 'woocommerce_process_product_file_download_paths', $post_id, 0, $files );

			update_post_meta( $post_id, '_downloadable_files', $files );
			update_post_meta( $post_id, '_download_limit', $_download_limit );
			update_post_meta( $post_id, '_download_expiry', $_download_expiry );

			if ( isset( $_POST['_download_type'] ) ) {
				update_post_meta( $post_id, '_download_type', wc_clean( $_POST['_download_type'] ) );
			}
		}

		// Product url
		if ( 'external' == $product_type ) {

			if ( isset( $_POST['_product_url'] ) ) {
				update_post_meta( $post_id, '_product_url', esc_url_raw( $_POST['_product_url'] ) );
			}

			if ( isset( $_POST['_button_text'] ) ) {
				update_post_meta( $post_id, '_button_text', wc_clean( $_POST['_button_text'] ) );
			}
		}

		// Upsells
		if ( isset( $_POST['upsell_ids'] ) ) {
			$upsells = array();
			$ids     = explode( ',' ,  $_POST['upsell_ids'] );

			if ( ! empty( $ids ) ) {
				foreach ( $ids as $id ) {
					if ( $id && $id > 0 ) {
						$upsells[] = $id;
					}
				}

				update_post_meta( $post_id, '_upsell_ids', $upsells );
			} else {
				delete_post_meta( $post_id, '_upsell_ids' );
			}
		}

		// Cross sells
		if ( isset( $_POST['crosssell_ids'] ) ) {
			$crosssells = array();
			$ids        = explode( ',' ,  $_POST['crosssell_ids'] );

			if ( ! empty( $ids ) ) {
				foreach ( $ids as $id ) {
					if ( $id && $id > 0 ) {
						$crosssells[] = $id;
					}
				}

				update_post_meta( $post_id, '_crosssell_ids', $crosssells );
			} else {
				delete_post_meta( $post_id, '_crosssell_ids' );
			}
		}

		// To be used to allow custom hidden meta keys 
		$wcv_custom_hidden_metas = array_intersect_key( $_POST, array_flip(preg_grep('/^_wcv_custom_product_/', array_keys( $_POST ) ) ) );

		if ( !empty( $wcv_custom_hidden_metas ) ) { 

			foreach ( $wcv_custom_hidden_metas as $key => $value ) {
				update_post_meta( $post_id, $key, $value ); 	
			}

		}	

		// To be used to allow custom meta keys 
		$wcv_custom_metas = array_intersect_key( $_POST, array_flip(preg_grep('/^wcv_custom_product_/', array_keys( $_POST ) ) ) );

		if ( !empty( $wcv_custom_metas ) ) { 

			foreach ( $wcv_custom_metas as $key => $value ) {
				update_post_meta( $post_id, $key, $value ); 	
			}

		}	


		do_action( 'wcv_save_product_meta', $post_id ); 

	} // save_meta() 



	/**
	 * Search for products and echo json
	 *
	 * @since 1.0.0
	 * @param string $x (default: '')
	 * @param string $post_types (default: array('product'))
	 */
	public static function json_search_products( $x = '', $post_types = array( 'product' ) ) {

		ob_start();

		check_ajax_referer( 'wcv-search-products', 'security' );

		$term = (string) wc_clean( stripslashes( $_GET['term'] ) );

		if ( empty( $term ) ) {
			die();
		}

		$args = array(
			'post_type'      => $post_types,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'post_author'	 => get_current_user_id(), 
			's'              => $term,
			'fields'         => 'ids'
		);

		if ( is_numeric( $term ) ) {

			$args2 = array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'post__in'       => array( 0, $term ),
				'fields'         => 'ids'
			);

			$args3 = array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'post_parent'    => $term,
				'fields'         => 'ids'
			);

			$args4 = array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'     => '_sku',
						'value'   => $term,
						'compare' => 'LIKE'
					)
				),
				'fields'         => 'ids'
			);

			$posts = array_unique( array_merge( get_posts( $args ), get_posts( $args2 ), get_posts( $args3 ), get_posts( $args4 ) ) );

		} else {

			$args2 = array(
				'post_type'      => $post_types,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_query'     => array(
					array(
					'key'     => '_sku',
					'value'   => $term,
					'compare' => 'LIKE'
					)
				),
				'fields'         => 'ids'
			);

			$posts = array_unique( array_merge( get_posts( $args ), get_posts( $args2 ) ) );

		}

		$found_products = array();

		if ( $posts ) {
			foreach ( $posts as $post ) {
				$product = wc_get_product( $post );
				$found_products[ $post ] = rawurldecode( $product->get_formatted_name() );
			}
		}

		$found_products = apply_filters( 'woocommerce_json_search_found_products', $found_products );

		wp_send_json( $found_products );

	}


	/**
	 * Search for product tags and echo json
	 *
	 * @since 1.0.0
	 * @param string $x (default: '')
	 * @param string $post_types (default: array('product'))
	 */
	public static function json_search_product_tags( ) {

		$tag_taxonomy = 'product_tag'; 

		ob_start();

		check_ajax_referer( 'wcv-search-product-tags', 'security' );

		$term = (string) wc_clean( stripslashes( $_GET['term'] ) );

		if ( empty( $term ) ) {
			die();
		}

		$args = apply_filters( 'wcv_json_search_tags_args', 
			array(
				'orderby'           => 'name', 
			    'hide_empty'        => false, 
			    'fields'            => 'all', 
			    'search'            => $term, 
			    'fields'			=> 'ids'
			)
		);

		$tags = get_terms( $tag_taxonomy, $args ); 

		$found_tags = array(); 

		if ( $tags ) { 

			foreach ( $tags as $tag ) {
				$product_tag = get_term( $tag, $tag_taxonomy );
				$found_tags[ $tag ] = rawurldecode( $product_tag->name );
			}
		}

		$found_tags = apply_filters( 'wcv_json_search_found_tags', $found_tags );

		wp_send_json( $found_tags );
	} 


	/**
	 * Product status text for output on front end. 
	 *
	 * @since    1.0.0
	 * @param      string    $status     product post status  
	 */
	public static function product_status( $status ) 
	{ 

		$product_status = apply_filters( 'wcv_product_status', array( 
				'publish' 	=> __( 'Online', 			'wcvendors-pro' ), 
				'future' 	=> __( 'Scheduled', 		'wcvendors-pro' ), 
				'draft' 	=> __( 'Draft', 			'wcvendors-pro' ), 
				'pending' 	=> __( 'Pending Approval', 	'wcvendors-pro' ), 
				'private' 	=> __( 'Admin Only', 		'wcvendors-pro' ), 
				'trash' 	=> __( 'Trash', 			'wcvendors-pro' ), 
			)
		); 

		return $product_status[ $status ]; 

	} // product_status()



	/**
	 *  Update Table Headers for display of product post type 
	 * 
	 * @since    1.0.0
	 * @param 	 array 	$headers  array passed via filter 
	 */
	public function table_columns( $columns ) {

		$columns = array( 
					'ID'  		=> __( 'ID', 									'wcvendors-pro' ), 
					'tn'  		=> __( '<i class="fa fa-picture-o"></i>', 		'wcvendors-pro' ), 
					'details'  	=> __( 'Details', 								'wcvendors-pro' ), 
					'price'  	=> __( '<i class="fa fa-shopping-cart"></i>', 	'wcvendors-pro' ), 
					'status'  	=> __( 'Status', 								'wcvendors-pro' ), 
				); 

		return apply_filters( 'wcv_product_table_columns', $columns ); 

	} // table_columns() 

	/**
	 *  Manipulate the table data 
	 * 
	 * @since    1.0.0
	 * @param 	 array 	$rows  			array of wp_post objects passed by the filter 
	 * @param 	 mixed 	$result_object  the wp_query object 
	 * @return   array  $new_rows   	array of stdClass objects passed back to the filter 
	 */
	public function table_rows( $rows, $result_object ) {

		$new_rows = array(); 

		$this->max_num_pages = $result_object->max_num_pages; 

		$can_edit = WC_Vendors::$pv_options->get_option( 'can_edit_published_products');
		$can_edit_approved = WC_Vendors::$pv_options->get_option( 'can_edit_approved_products' ); 
		$disable_delete = WC_Vendors::$pv_options->get_option( 'delete_product_cap');
		$trusted_vendor = ( get_user_meta( get_current_user_id(), '_wcv_trusted_vendor', true ) == 'on' ) ? true: false;
		$untrusted_vendor = ( get_user_meta( get_current_user_id(), '_wcv_untrusted_vendor', true ) == 'on' ) ? true: false;

		if ( $trusted_vendor ) 		$can_edit = true; 
		if ( $untrusted_vendor ) 	$can_edit = false; 

		foreach ( $rows as $row ) {

			$product = wc_get_product( $row->ID ); 

			$new_row = new stdClass(); 

			$row_actions = apply_filters( 'wcv_product_table_row_actions' , array( 
				'edit'  	=> 
						apply_filters( 'wcv_product_table_row_actions_edit', array(  
							'label' 	=> __( 'Edit', 	'wcvendors-pro' ), 
							'class'		=> '', 
							'url' 		=> WCVendors_Pro_Dashboard::get_dashboard_page_url( 'product/edit/' . $product->id ), 
						) ), 
				'delete'  	=> 
						apply_filters( 'wcv_product_table_row_actions_delete', array( 
							'label' 	=> __( 'Delete', 'wcvendors-pro' ), 
							'class'		=> 'confirm_delete', 
							'custom'	=> array( 'data-confirm_text' => __( 'Delete product?', 'wcvendors-pro')  ), 
							'url' 		=> WCVendors_Pro_Dashboard::get_dashboard_page_url( 'product/delete/' . $product->id ), 
						) ), 
				'view'  => 
						apply_filters( 'wcv_product_table_row_actions_view', array( 
							'label' 	=> __( 'View', 	'wcvendors-pro' ), 
							'class'		=> '', 
							'url' 		=> get_permalink( $product->id ), 
							'target' 	=> '_blank' 
						) ),		
				)
			); 

			// Check if you can edit published products or the product is variable
			if (  !$can_edit && $row->post_status == 'publish' || $product->product_type == 'variable' ) { 
				unset( $row_actions[ 'edit' ] ); 
			} 

			// Check if you can delete the product 
			if ( $disable_delete ) unset( $row_actions[ 'delete' ] ); 

			$new_row->ID	 		= $row->ID; 
			$new_row->tn 			= get_the_post_thumbnail( $row->ID, array(120,120) );  
			$new_row->details 		= apply_filters( 'wcv_product_row_details' , sprintf('<h4>%s</h4> %s %s <br />%s %s <br />' , $product->get_title(), __( 'Categories:', 'wcvendors-pro' ),$product->get_categories(), __('Tags:', 'wcvendors-pro'), $product->get_tags() ) ); 
			$new_row->price  		= wc_price( $product->get_display_price() ) . $product->get_price_suffix(); 
			$new_row->status 		= sprintf('%s <br /> %s', WCVendors_Pro_Product_Controller::product_status( $row->post_status ), date_i18n( get_option( 'date_format' ), strtotime( $row->post_date ) ) );
			$new_row->row_actions 	= $row_actions; 
			$new_rows[] = $new_row; 
		} 

		return apply_filters( 'wcv_product_table_rows' , $new_rows ); 

	} // table_rows() 


	/**
	 *  Change the column that actions are displayed in 
	 * 
	 * @since    1.0.0
	 * @param 	 string $column  		column passed from filter 
	 * @return   string $new_column   	new column passed back to filter 
	 */
	public function table_action_column( $column ) {

		$new_column = 'details'; 

		return apply_filters( 'wcv_product_table_action_column', $new_column ); 

	}

	/**
	 *  Add actions before and after the table 
	 * 
	 * @since    1.0.0
	 */
	public function table_actions() {

		$pagination_wrapper = apply_filters( 'wcv_product_paginate_wrapper', array( 
			'wrapper_start'	=> '<nav class="woocommerce-pagination">', 
			'wrapper_end'	=> '</nav>', 
			)
		); 

		$add_url = apply_filters( 'wcv_add_product_url', WCVendors_Pro_Dashboard::get_dashboard_page_url( 'product/edit/' ) ); 
		include('partials/product/wcvendors-pro-table-actions.php');
	}

	/**
	 *  Change the column that actions are displayed in 
	 * 
	 * @since    1.0.0
	 * @param 	 string $column  		column passed from filter 
	 * @return   string $new_column   	new column passed back to filter 
	 */
	public function table_no_data_notice( $notice ) {

		$notice = __( 'No products found.', 'wcvendors-pro' );

		return apply_filters( 'wcv_product_table_no_data_notice', $notice ); 

	}

	/**
	 *  Posts per page 
	 * 
	 * @since    1.2.4
	 * @param 	 int 	$post_num  	number of posts to display from the admin options. 
	 */
	public function table_posts_per_page( $per_page ) {

		return WC_Vendors::$pv_options->get_option( 'products_per_page' ); 

	} //table_posts_per_page()

}