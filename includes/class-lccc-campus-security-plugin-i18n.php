<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.lorainccc.edu
 * @since      1.0.0
 *
 * @package    Lccc_Campus_Security_Plugin
 * @subpackage Lccc_Campus_Security_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Lccc_Campus_Security_Plugin
 * @subpackage Lccc_Campus_Security_Plugin/includes
 * @author     David Brattoli <dbrattoli@lorainccc.edu>
 */
class Lccc_Campus_Security_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'lccc-campus-security-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
