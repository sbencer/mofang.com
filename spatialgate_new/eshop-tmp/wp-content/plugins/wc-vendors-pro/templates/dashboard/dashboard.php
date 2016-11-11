<?php
/**
 * The template for displaying the main Pro Dashboard
 *
 * Override this template by copying it to yourtheme/wc-vendors/dashboard/
 *
 * @package    WCVendors_Pro
 * @version    1.1.1
 */
?>

<!-- Load the Overview section of the dashboard page -->
<?php wc_get_template( 'overview.php', array('store_report' => $store_report ), 'wc-vendors/dashboard/reports/', WCVendors_Pro::get_path() . 'templates/dashboard/reports/' ); ?>

<!-- Load the reports and tables section of the dashboard page -->
<?php wc_get_template( 'reports.php', array('store_report' => $store_report ), 'wc-vendors/dashboard/reports/', WCVendors_Pro::get_path() . 'templates/dashboard/reports/' ); ?>
