<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.lorainccc.edu
 * @since             1.0.0
 * @package           Lccc_Campus_Security_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       LCCC Campus Security Plugin
 * Plugin URI:        www.lorainccc.edu
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            David Brattoli
 * Author URI:        www.lorainccc.edu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lccc-campus-security-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lccc-campus-security-plugin-activator.php
 */
function activate_lccc_campus_security_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lccc-campus-security-plugin-activator.php';
	Lccc_Campus_Security_Plugin_Activator::activate();
}

function crime_log_wp_admin_scripts() {
 wp_enqueue_script('jquery-ui-datepicker');

	wp_enqueue_script('jquery-ui-core');
	
	wp_enqueue_script( 'jquery-moment-js', plugin_dir_url( __FILE__ ) . 'js/moment.js', array( 'jquery','jquery-ui-core' ), '1', true );

	wp_enqueue_script( 'jquery-ui-timepicker-addon-js', plugin_dir_url( __FILE__ ) . 'js/jquery-ui-timepicker-addon.js', array( 'jquery','jquery-ui-core','jquery-ui-datepicker' ), '1', true );

		wp_enqueue_script( 'jquery-daterangepicker-js', plugin_dir_url( __FILE__ ) . 'js/jquery.comiseo.daterangepicker.js', array( 'jquery','jquery-ui-core','jquery-moment-js' ), '1', true );
	
		wp_enqueue_script( 'jquery-daterangepicker-js', plugin_dir_url( __FILE__ ) . 'js/jquery.comiseo.daterangepicker.js', array( 'jquery','jquery-ui-core','jquery-ui-daterangepicker' ), '1', true );
	
 wp_enqueue_style( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);

	wp_enqueue_style('jquery-ui-timepicker-addon-style', plugin_dir_url( __FILE__ ) . 'css/jquery-ui-timepicker-addon.css');
}

add_action( 'admin_enqueue_scripts', 'crime_log_wp_admin_scripts' );






$months = array(
    'January',
    'February',
    'March',
    'April',
				'May',
				'June',
				'July',
				'August',
				'September',
				'October',
				'November',
				'December'
);

function lccc_taxonomy_install() {
 global $months;	
    foreach ( (array) $months as $month ) {
        wp_insert_term($month, 'Months');
    }
}
register_activation_hook(__FILE__, 'lccc_taxonomy_install');


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lccc-campus-security-plugin-deactivator.php
 */
function deactivate_lccc_campus_security_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lccc-campus-security-plugin-deactivator.php';
	Lccc_Campus_Security_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lccc_campus_security_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_lccc_campus_security_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lccc-campus-security-plugin.php';

require_once( plugin_dir_path( __FILE__ ).'php/lccc_cs_post_type.php' );

require_once( plugin_dir_path( __FILE__ ).'php/lccc_crime_log_metabox.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lccc_campus_security_plugin() {

	$plugin = new Lccc_Campus_Security_Plugin();
	$plugin->run();

}
run_lccc_campus_security_plugin();
