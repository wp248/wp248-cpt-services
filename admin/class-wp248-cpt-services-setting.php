<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       wp248.com
 * @since      1.0.0
 *
 * @package    Wp248_Cpt_Services
 * @subpackage Wp248_Cpt_Services/admin
 */


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp248_Cpt_Services
 * @subpackage Wp248_Cpt_Services/admin
 * @author     wp248 <info@wp248.com>
 */

class Wp248_Cpt_Services_Setting {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	public function PluginMenu()
	{
		if (post_type_exists( 'services' )) {
			add_submenu_page(
				'edit.php?post_type=services',
				__('Services Settings', 'menu-services-settings'),
				__('Services Settings', 'menu-services-settings'),
				'manage_options',
				'services',
				array($this, 'RenderPage')
			);
		}
	}

	public function RenderPage(){
		?>
		<div class='wrap'>
			<h2>General Settings for Services</h2>
		</div>
		<?php
	}
}
