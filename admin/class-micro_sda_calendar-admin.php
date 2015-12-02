<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://micro-sda.kl.com.ua/
 * @since      1.0.0
 *
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/admin
 * @author     Kovalenko Rodion <banchey@gmail.com>
 */
class Micro_sda_calendar_Admin {

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
		add_action('admin_menu',array($this,'add_admin_menu'));
		//add_action('admin_enqueue_scripts', array($this,'mc_c_color_picker'));
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
		 * defined in Micro_sda_calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Micro_sda_calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/micro_sda_calendar-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style('wp-color-picker');

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
		 * defined in Micro_sda_calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Micro_sda_calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/micro_sda_calendar-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/micro_sda_calendar-admin.js', array('wp-color-picker'), $this->version, false );



	}
        /**
	     * Register admin menu
         */

	public function add_admin_menu() {
		add_menu_page(
			    'MicroSDA Calendar',
				'MicroSDA Calendar',
				'publish_pages',
				'micro_sda_calendar',
				array($this,'display_admin_index'),
				'dashicons-calendar-alt',
				21
		);

		add_submenu_page(
				'micro_sda_calendar',
				'Settings',
				'Settings',
				'publish_pages',
				'micro_sda_calendar_settings',
				array($this,'display_admin_sub_index')
		);



	}

	public function display_admin_index(){
		require_once 'partials/micro_sda_calendar-admin-display.php';
		admin_general_page_view();
	}
	public function display_admin_sub_index(){
		require_once 'partials/micro_sda_calendar-admin-display.php';
		admin_sub_menu_gage_settings_views();
	}

}
