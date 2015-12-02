<?php

/**
 * Fired during plugin activation
 *
 * @link       http://micro-sda.kl.com.ua/
 * @since      1.0.0
 *
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/includes
 * @author     Kovalenko Rodion <banchey@gmail.com>
 */
class Micro_sda_calendar_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$table=$wpdb->prefix.'micro_sda_calendar';

		$wpdb->query("CREATE TABLE IF NOT EXISTS ".$table." (".
				"id INT(11) NOT NULL auto_increment,".
                "Day INT(11),".
				"Month INT(11),".
				"Year INT(11),".
				"Name TEXT,".
                "Email TEXT,".
				"Fone VARCHAR(50),".
                "Message TEXT,".
                "PRIMARY KEY (id));");

		add_option('mc_calendar_email','Ваша почта');//Настрйоки почты
		add_option('mc_calendar_email_send','no');//Отправка почты

		add_option('mc_calendar_color_month_week','#ffffff');
		add_option('mc_calendar_color_available_day','#1b9700');
		add_option('mc_calendar_color_non-available_day','#97000f');
		add_option('mc_calendar_color_weekend','#1f5300');

	}
}
