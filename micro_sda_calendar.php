<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://micro-sda.kl.com.ua/
 * @since             1.0.0
 * @package           Micro_sda_calendar
 *
 * @wordpress-plugin
 * Plugin Name:       MicroSDA_сalendar
 * Plugin URI:        http://micro-sda.kl.com.ua/
 * Description:       This calendar orders. This calendar allows you to place orders computed at a certain date. Use this "[calendar_shortcode]" simple short code on you page.
 * Version:           1.0.0
 * Author:            Kovalenko Rodion
 * Author URI:        http://micro-sda.kl.com.ua/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       micro_sda_calendar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-micro_sda_calendar-activator.php
 */
function activate_micro_sda_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-micro_sda_calendar-activator.php';
	Micro_sda_calendar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-micro_sda_calendar-deactivator.php
 */
function deactivate_micro_sda_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-micro_sda_calendar-deactivator.php';
	Micro_sda_calendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_micro_sda_calendar' );
register_deactivation_hook( __FILE__, 'deactivate_micro_sda_calendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-micro_sda_calendar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_micro_sda_calendar() {

	$plugin = new Micro_sda_calendar();
	$plugin->run();

}
run_micro_sda_calendar();
