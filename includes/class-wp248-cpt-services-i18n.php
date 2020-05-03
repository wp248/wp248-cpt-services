<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       wp248.com
 * @since      1.0.0
 *
 * @package    Wp248_Cpt_Services
 * @subpackage Wp248_Cpt_Services/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp248_Cpt_Services
 * @subpackage Wp248_Cpt_Services/includes
 * @author     wp248 <info@wp248.com>
 */
class Wp248_Cpt_Services_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp248-cpt-services',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
