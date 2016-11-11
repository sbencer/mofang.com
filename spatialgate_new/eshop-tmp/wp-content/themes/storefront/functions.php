<?php
/**
 * storefront engine room
 *
 * @package storefront
 */

/**
 * Initialize all the things.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woothemes/theme-customisations
 */
add_action( 'init', 'custom_remove_footer_credit', 10 );

function custom_login_logo() { ?>
<style>
.login h1 a {
	background-image:url(http://www.spatialgate.com.tw/eshop/wp-content/uploads/2016/03/LOGO橫板15X5web.png) !important;
	background-size: inherit !important;
	width: 330px; 
}
</style>
<?php
}
add_action('login_head', 'custom_login_logo');
/* WordPress登錄界面Logo鏈接修改開始 */
function custom_loginlogo_url($url) {
	return get_bloginfo('url');
}
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
/* WordPress登錄界面Logo鏈接修改結束 */


function custom_dashboard_footer () {
     echo '2016©次元角落購物網 | 網頁製作：Holga Web Stdio';
  }
add_filter('admin_footer_text', 'custom_dashboard_footer');

add_filter( 'woocommerce_enable_deprecated_additional_flat_rates', '__return_true' );

add_action( 'wp_enqueue_scripts', 'jk_remove_sticky_checkout', 99 );

function jk_remove_sticky_checkout() {
wp_dequeue_script( 'storefront-sticky-payment' );
}

// WooCommerce 台灣結帳表單 城市下拉選項
 
add_filter('woocommerce_states', 'cwp_woocommerce_tw_states');
 
function cwp_woocommerce_tw_states($states) {
 
	$states['TW'] = array(
		        '基隆市' => '基隆市',
		        '台北市' => '台北市',
		        '新北市' => '新北市',
		        '宜蘭縣' => '宜蘭縣',
		        '桃園市' => '桃園市',
		        '新竹市' => '新竹市',
		        '新竹縣' => '新竹縣',
		        '苗栗縣' => '苗栗縣',
		        '台中市' => '台中市',
		        '彰化縣' => '彰化縣',
		        '南投縣' => '南投縣',
		        '雲林縣' => '雲林縣',
		        '嘉義市' => '嘉義市',
		        '嘉義縣' => '嘉義縣',
		        '台南市' => '台南市',
		        '高雄市' => '高雄市',
		        '屏東縣' => '屏東縣',
		        '花蓮縣' => '花蓮縣',
		        '台東縣' => '台東縣',
		        '澎湖' => '澎湖',
		        '金門' => '金門',
		        '馬祖' => '馬祖',
		        '離島地區' => '離島地區',
			);
 
	return $states;
}

add_filter('woocommerce_default_address_fields', 'cwp_custom_address_fields');
function cwp_custom_address_fields($fields) {

	$fields2['last_name'] = $fields['last_name'];
	$fields2['last_name']['class'] = array('form-row-wide');
	$fields2['first_name'] = $fields['first_name'];
	$fields2['first_name']['class'] = array('form-row-wide');
	$fields2['state'] = $fields['state'];
	$fields2['state']['class'] = array('form-row-wide');
	$fields2['city'] = $fields['city'];
	$fields2['city']['class'] = array('form-row-first');
	$fields2['postcode'] = $fields['postcode'];
	$fields2['postcode']['class'] = array('form-row-last');
	$fields2['address_1'] = $fields['address_1'];
	$fields2['address_1']['class'] = array('form-row-wide');
	$fields2['email'] = $fields['email'];
	$fields2['phone'] = $fields['phone'];
	//$fields2['country'] = $fields['country'];
	//$fields2['company'] = $fields['company'];
	//$fields2['address_2'] = $fields['address_2'];

	return $fields2;
}



add_filter('allowed_redirect_hosts','allow_ms_parent_redirect');
function allow_ms_parent_redirect($allowed)
{
    $allowed[] = 'www.spatialgate.com.tw/eshop/';
    return $allowed;
}


?>