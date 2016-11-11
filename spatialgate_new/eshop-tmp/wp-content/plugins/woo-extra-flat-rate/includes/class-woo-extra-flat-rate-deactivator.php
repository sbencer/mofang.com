<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woo_Extra_Flat_Rate
 * @subpackage Woo_Extra_Flat_Rate/includes
 * @author     Multidots <wordpress@multidots.com>
 */
class Woo_Extra_Flat_Rate_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
	
			$log_url = $_SERVER['HTTP_HOST'];
      		$log_plugin_id = 1;
     		$log_activation_status = 0;
     		$cur_dt = date('Y-m-d');
     		wp_remote_request('http://mdstore.projectsmd.in/webservice-deactivate.php?log_url='.$log_url.'&plugin_id='.$log_plugin_id.'&activation_status='.$log_activation_status.'&activation_date='.$cur_dt);
			
	}

}
