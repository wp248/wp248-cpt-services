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

	/**
	 * setup_plugin_options_menu
	 */
	public function setup_plugin_options_menu()
	{
		if (post_type_exists( 'services' )) {
			add_submenu_page(
				'edit.php?post_type=services',
				__('Services Settings', 'wp248-cpt-services'),
				__('Services Settings', 'wp248-cpt-services'),
				'manage_options',
				'services',
				array($this, 'render_settings_page_content')
			);
		}
		if (!($this->is_menu_item_exists('wp248_menu_settings'))) {
			add_menu_page(
					'WP248',
					__('WP248 Settings', 'wp248-cpt-services'),
					'manage_options',
					'wp248_menu_settings',
					array($this, 'render_settings_page_content'),
					plugins_url('/assets/images/limitlessv-logo-no-bg-logo-20x20.svg', __DIR__)
			);
		}
		if (!($this->is_submenu_item_exists('wp248_menu_settings','wp248_cpt_services/wp248_menu_settings'))) {
			add_submenu_page(
				'wp248_menu_settings',							// The parent_slug
				__('Services Settings', 'wp248-cpt-services'),	// The title to be displayed in the browser window for this page.
				__('Services Settings', 'wp248-cpt-services'),	// The text to be displayed for this menu item
				'manage_options',								// Which type of users can see this menu item
				'wp248_cpt_services/wp248_menu_settings',		// The unique ID - that is, the slug - for this menu item
				array($this, 'render_settings_page_content')	// The name of the function to call when rendering this menu's page
			);
		}
	}

	/**
	 * Check menu item exists
	 * @param string $main_menu_unique_id
	 * @return bool
	 */
	public function is_menu_item_exists($main_menu_unique_id='')
	{
		if (!( empty ( $GLOBALS['admin_page_hooks'][$main_menu_unique_id] ) ))
			return true;
}

	/**
	 * Check sub menu item exists under top menu
	 * @param string $main_menu_unique_id
	 * @param string $submenu_unique_id
	 * @return bool
	 */
	public function is_submenu_item_exists($main_menu_unique_id='', $submenu_unique_id='')
	{
		global $submenu;
		if (isset( $submenu[ $main_menu_unique_id ] )
				&& in_array( $main_menu_unique_id, wp_list_pluck( $submenu[ $main_menu_unique_id ], 2 ) )
		)
			return true;
	}
	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content( $active_tab = '' ) {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'General Settings for Services', 'wp248-cpt-services' ); ?></h2>
			<?php settings_errors(); ?>
			<?php if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else if( $active_tab == 'social_options' ) {
				$active_tab = 'social_options';
			} else if( $active_tab == 'input_examples' ) {
				$active_tab = 'input_examples';
			} else {
				$active_tab = 'display_options';
			} // end if/else ?>
			<h2 class="nav-tab-wrapper">
				<a href="?post_type=services&page=services&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display Options', 'wp248-cpt-services' ); ?></a>
				<a href="?post_type=services&page=services&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'wp248-cpt-services' ); ?></a>
				<a href="?post_type=services&page=services&tab=input_examples" class="nav-tab <?php echo $active_tab == 'input_examples' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Input Examples', 'wp248-cpt-services' ); ?></a>
			</h2>
			<form method="post" action="options.php">

				<?php

				if( $active_tab == 'display_options' ) {

					settings_fields( 'wp248_services_display_options' );
					do_settings_sections( 'wp248_services_display_options' );

				} elseif( $active_tab == 'social_options' ) {

					settings_fields( 'wp248_services_options' );
					do_settings_sections( 'wp248_services_social_options' );

				} else {

					settings_fields( 'wp248_services_input_examples' );
					do_settings_sections( 'wp248_services_input_examples' );

				} // end if/else

				submit_button();

				?>
			</form>

		</div><!-- /.wrap -->
		<?php
	}


	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function default_display_options() {

		$defaults = array(
			'show_header'		=>	'',
			'show_content'		=>	'',
			'show_footer'		=>	'',
		);

		return $defaults;

	}

	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_display_options()
	{
		// If the theme options don't exist, create them.
		if( false == get_option( 'wp248_services_display_options' ) ) {
			$default_array = $this->default_display_options();
			add_option( 'wp248_services_display_options', $default_array );
		}

		add_settings_section(
			'general_settings_section',			            		// ID used to identify this section and with which to register options
			__( 'Display Options', 'wp248-cpt-services' ),	// Title to be displayed on the administration page
			array( $this, 'general_options_callback'),	    		// Callback used to render the description of the section
			'wp248_services_display_options'		            // Page on which to add this section of options
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_header',						        // ID used to identify the field throughout the theme
			__( 'Header', 'wp248-cpt-services' ),		// The label to the left of the option interface element
			array( $this, 'toggle_header_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_services_display_options',	    // The page on which this option will be displayed
			'general_settings_section',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'wp248-cpt-services' ),
			)
		);

		// Finally, we register the fields with WordPress
		register_setting(
			'wp248_services_display_options',
			'wp248_services_display_options'
		);

	}

	/**
	 * This function provides a simple description for the General Options page.
	 *
	 * It's called from the 'wppb-demo_initialize_theme_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function general_options_callback() {
		$options = get_option('wp248_services_display_options');
		/** Dump variable only if debug is enabled */
		if (defined('WP_DEBUG') && WP_DEBUG) {
			var_dump($options);
		}
		echo '<p>' . __( 'Select which areas of content you wish to display.', 'wp248-cpt-services' ) . '</p>';
		echo '<p>' . __( '<small><i>* Check WP248 Elementor theme for instructions</i></small>', 'wp248-cpt-services' ) . '</p>';

	} // en


	/**
	 * This function renders the interface elements for toggling the visibility of the header element.
	 *
	 * It accepts an array or arguments and expects the first element in the array to be the description
	 * to be displayed next to the checkbox.
	 */
	public function toggle_header_callback($args) {

		// First, we read the options collection
		$options = get_option('wp248_services_display_options');

		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_header" name="wp248_services_display_options[show_header]" value="1" ' . checked( 1, isset( $options['show_header'] ) ? $options['show_header'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_header">&nbsp;'  . $args[0] . '</label>';

		echo $html;

	} // end toggle_header_callback

	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_tab2_social_options()
	{
	}
	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_tab2_input_examples()
	{
	}


}
