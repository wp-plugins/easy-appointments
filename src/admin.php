<?php

require_once EA_SRC_DIR . 'ajax.php';
require_once EA_SRC_DIR . 'logic.php';
require_once EA_SRC_DIR . 'metafields.php';

/**
 * Admin panel
 */
class EAAdminPanel
{
	
	protected $compatibility_mode;

	function __construct()
	{

		$ajax = new EAAjax();

		// Hook for adding admin menus
		add_action( 'admin_menu', array( $this, 'add_menu_pages' ));

		// Init action
		add_action( 'admin_init', array( $this, 'init' ));
		//add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );

	}

	/**
	 * Init of admin page
	 */
	public function init()
	{

		// admin panel script
		wp_register_script(
			'ea-compatibility-mode',
			EA_PLUGIN_URL . 'js/backbone.sync.fix.js',
			array( 'backbone' ),
			false,
			true
		);

		// admin panel script
		wp_register_script(
			'time-picker',
			EA_PLUGIN_URL . 'js/libs/jquery-ui-timepicker-addon.js',
			array( 'jquery', 'jquery-ui-datepicker' ),
			false,
			true
		);

		// admin panel script
		wp_register_script(
			'ea-settings',
			EA_PLUGIN_URL . 'js/admin.prod.js',
			array( 'jquery', 'ea-datepicker-localization', 'backbone', 'underscore', 'time-picker', 'jquery-ui-sortable'),
			false,
			true
		);

		// appointments panel script
		wp_register_script(
			'ea-appointments',
			EA_PLUGIN_URL . 'js/settings.prod.js',
			array( 'jquery', 'ea-datepicker-localization', 'backbone', 'underscore', 'jquery-ui-datepicker', 'time-picker' ),
			false,
			true
		);

		// report panel script
		wp_register_script(
			'ea-report',
			EA_PLUGIN_URL . 'js/report.prod.js',
			array( 'jquery', 'ea-datepicker-localization', 'backbone', 'underscore', 'time-picker'),
			false,
			true
		);

		wp_register_script(
			'ea-datepicker-localization',
			'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js',
			array( 'jquery' ),
			false,
			true
		);

		// admin style
		wp_register_style(
			'ea-admin-css',
			EA_PLUGIN_URL . 'css/admin.css'
		);

		// report style
		wp_register_style(
			'ea-report-css',
			EA_PLUGIN_URL . 'css/report.css'
		);

		// admin style
		wp_register_style(
			'ea-admin-awesome-css',
			EA_PLUGIN_URL . 'css/font-awesome.css'
		);

		// admin style
		wp_register_style(
			'time-picker',
			EA_PLUGIN_URL . 'css/jquery-ui-timepicker-addon.css'
		);

		wp_register_style(
			'jquery-style',
			EA_PLUGIN_URL . 'css/jquery-ui.css'
		);
	}

	/**
	 * Adds required JS
	 */
	public function add_settings_js()
	{
		$this->compatibility_mode = EALogic::get_option_value('compatibility.mode', 0);

		if(!empty($this->compatibility_mode)) {
			wp_enqueue_script( 'ea-compatibility-mode' );
		}

		wp_enqueue_script( 'ea-settings' );
		wp_enqueue_style( 'ea-admin-css' );
		wp_enqueue_style( 'jquery-style' );
		wp_enqueue_style( 'time-picker' );
		wp_enqueue_style( 'ea-admin-awesome-css' );
	}

	/**
	 * Adds required JS
	 */
	public function add_appointments_js()
	{
		$this->compatibility_mode = EALogic::get_option_value('compatibility.mode', 0);

		if(!empty($this->compatibility_mode)) {
			wp_enqueue_script( 'ea-compatibility-mode' );
		}

		wp_enqueue_script( 'ea-appointments' );
		wp_enqueue_style( 'ea-admin-css' );
		wp_enqueue_style( 'jquery-style' );
		wp_enqueue_style( 'time-picker' );
		wp_enqueue_style( 'ea-admin-awesome-css' );
	}

	/**
	 * JS for report admin page
	 */
	public function add_report_js() {
		if(!empty($this->compatibility_mode)) {
			wp_enqueue_script( 'ea-compatibility-mode' );
		}

		wp_enqueue_script( 'ea-report' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_style( 'ea-admin-awesome-css' );
		wp_enqueue_style( 'ea-report-css' );
		wp_enqueue_style( 'jquery-style' );
	}

	/**
	 * create menu structure
	 */
	public function add_menu_pages()
	{
		// top_level_menu
		add_menu_page(
			'Easy Appointments',
			'Easy Appointments',
			'edit_posts',
			'easy_app_top_level',
			null,
			'dashicons-calendar-alt',
			'10.842015'
		);

		// Rename first 
		$page_app_suffix = add_submenu_page(
			'easy_app_top_level',
			__('Appointments', 'easy-appointments'),
			__('Appointments', 'easy-appointments'),
			'edit_posts',
			'easy_app_top_level',
			array( $this, 'top_level_appointments' )
		);

		// settings
		$page_settings_suffix = add_submenu_page(
			'easy_app_top_level',
			__('Settings', 'easy-appointments') ,
			__('Settings', 'easy-appointments'),
			'edit_posts',
			'easy_app_settings',
			array( $this, 'top_settings_menu' )
		);

		// Overview - report
		$page_report_suffix = add_submenu_page(
			'easy_app_top_level',
			__('Overview', 'easy-appointments'),
			__('Reports', 'easy-appointments'),
			'edit_posts',
			'easy_app_reports',
			array( $this, 'reports_page' )
		);

		add_action( 'load-' . $page_settings_suffix, array( $this, 'add_settings_js' ));
		add_action( 'load-' . $page_app_suffix,      array( $this, 'add_appointments_js' ));
		add_action( 'load-' . $page_report_suffix,   array( $this, 'add_report_js' ));
	}

	/**
	 * Content of appointmets admin page
	 */
	public function top_level_appointments()
	{
		$settings = EALogic::get_options();
		wp_localize_script( 'ea-appointments', 'ea_settings', $settings );

		$screen = get_current_screen();
		$screen->add_help_tab( array(
			 'id'       => 'easyapp_settings_help'
			,'title'    => 'Appointments manager'
			,'content'  => '<p>Use filter for date to reduce output results for appointments. You can filter by <b>location</b>, <b>service</b>, <b>worker</b>, <b>status</b> and <b>date</b>.</p>'
		) );

		$screen->set_help_sidebar('<a href="http://nikolaloncar.com/easy-appointments-wordpress-plugin/easy-appointments-documentation/">More info!</a>');
		
		require_once EA_SRC_DIR . 'templates/appointments.tpl.php';
		require_once EA_SRC_DIR . 'templates/inlinedata.tpl.php';
	}

	/**
	 * Content of top menu page
	 */
	public function reports_page()
	{
		$settings = EALogic::get_options();
		wp_localize_script( 'ea-report', 'ea_settings', $settings );

		$screen = get_current_screen();
		$screen->add_help_tab( array(
			 'id'       => 'easyapp_settings_help'
			,'title'    => 'Time table'
			,'content'  => '<p>Time table report shows free slost for every locaition - service - worker connection on whole month</p>' .
				'<p>There can you see free times an how many slots are taken.</p>'
		) );

		$screen->set_help_sidebar('<a href="http://nikolaloncar.com/easy-appointments-wordpress-plugin/easy-appointments-documentation/">More info!</a>');

		require_once EA_SRC_DIR . 'templates/report.tpl.php';
		require_once EA_SRC_DIR . 'templates/inlinedata.tpl.php';
	}

	/**
	 * Content of top menu page
	 */
	public function top_settings_menu()
	{
		$settings = EALogic::get_options();
		wp_localize_script( 'ea-settings', 'ea_settings', $settings );

		$screen = get_current_screen();
		$screen->add_help_tab( array(
			 'id'       => 'easyapp_settings_help'
			,'title'    => 'Settings'
			,'content'  => '<p>You need to define at least one location, worker and service! Without that widget wont work.</p>'
		) );

		$screen->set_help_sidebar('<a href="http://nikolaloncar.com/easy-appointments-wordpress-plugin/easy-appointments-documentation/">More info!</a>');

		require_once EA_SRC_DIR . 'templates/admin.tpl.php';
		require_once EA_SRC_DIR . 'templates/inlinedata.tpl.php';
	}
}