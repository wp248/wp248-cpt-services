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
class Wp248_Cpt_Services_Admin {

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
		$this->load_dependencies();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp248_Cpt_Services_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp248_Cpt_Services_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp248-cpt-services-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp248_Cpt_Services_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp248_Cpt_Services_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp248-cpt-services-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wp248-cpt-services-setting.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wp248-cpt-services-cpt.php';
	}

	public function register_service_post_type()
	{
		$this->create_custom_post();
		$this->register_tax_service_category();
		flush_rewrite_rules();
	}


	private function register_tax_service_category() {

		/**
		 * Taxonomy: Services Category.
		 */

		$labels = [
			"name" => __( "Categories", "Wp248_Cpt_Services" ),
			"singular_name" => __( "Service Category", "Wp248_Cpt_Services" ),
		];

		$args = [
			"label" => __( "Category", "Wp248_Cpt_Services" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'service_category', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "service_category",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => true,
		];
		register_taxonomy( "service_category", [ "services" ], $args );
	}

	private function create_custom_post()
	{
		/**
		 * Post Type: Services.
		 */

		$labels = [
			"name" => __( "Services", "Wp248_Cpt_Services" ),
			"singular_name" => __( "Service", "Wp248_Cpt_Services" ),
		];

		$args = [
			"label" => __( "Services", "Wp248_Cpt_Services" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "services", "with_front" => true ],
			"query_var" => true,
			"supports" => [ "title", "editor", "thumbnail" ],
		];

		register_post_type( "services", $args );
	}


}
