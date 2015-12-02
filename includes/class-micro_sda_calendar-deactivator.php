<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://micro-sda.kl.com.ua/
 * @since      1.0.0
 *
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/includes
 * @author     Kovalenko Rodion <banchey@gmail.com>
 */
class Micro_sda_calendar_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

        delete_option('mc_calendar_email');
		delete_option('mc_calendar_email_send');
		delete_option('mc_calendar_color_month_week');
		delete_option('mc_calendar_color_available_day');
		delete_option('mc_calendar_color_non-available_day');
		delete_option('mc_calendar_color_weekend');
	}

}
