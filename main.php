<?php

/**
 * Plugin Name: Easy Appointments
 * Plugin URI: http://nikolaloncar.com/easy-appointments-wordpress-plugin/
 * Description: Simple managment of Appointments
 * Version: 1.0
 * Author: Nikola Loncar
 * Author URI: http://nikolaloncar.com
 */

define('EA_SRC_DIR', dirname( __FILE__ ) . '/src/');
define('EA_JS_DIR', dirname( __FILE__ ) . '/js/');

define('EA_PLUGIN_URL', plugins_url(null,__FILE__) . '/');

/**
 * Entery point
 */
class EasyAppointment
{

	function __construct()
	{
		// on register hook
		register_activation_hook( __FILE__, array($this, 'install'));
		
		// admin panel
		if(is_admin())
		{
			require_once EA_SRC_DIR . 'admin.php';
			$admin = new EAAdminPanel();
			require_once EA_SRC_DIR . 'report.php';
		} else {
			require_once EA_SRC_DIR . 'frontend.php';
			$frontend = new EAFrontend();
		}

		// ajax hooks
		require_once EA_SRC_DIR . 'ajax.php';
		new EAAjax;

	}

	/**
	 * Installation of DB
	 */
	public function install()
	{
		require_once EA_SRC_DIR . 'install.php';

		$install = new EAInstallTools();

		$install->init_db();
		$install->init_data();
	}
}

$ea_app = new EasyAppointment;
