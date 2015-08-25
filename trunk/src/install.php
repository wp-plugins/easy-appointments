<?php

/**
* Install tools
*
* Create whole DB stracture
*/
class EAInstallTools
{

	/**
	 * DB version
	 */
	private $easy_app_db_version;


	function __construct()
	{
		$this->easy_app_db_version = '1.2.9';
	}

	/**
	 * Create db
	 * @return
	 */
	public function init_db()
	{
		global $wpdb;

		// get table prefix
		$table_prefix = $wpdb->prefix;

		// 	
		$charset_collate = $wpdb->get_charset_collate();

		$table_querys = array();
		$alter_querys = array();

		// whole table struct
		$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_appointments (
  id int(11) NOT NULL AUTO_INCREMENT,
  location int(11) NOT NULL,
  service int(11) NOT NULL,
  worker int(11) NOT NULL,
  name varchar(255) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  phone varchar(45) DEFAULT NULL,
  date date DEFAULT NULL,
  start time DEFAULT NULL,
  end time DEFAULT NULL,
  description text,
  status varchar(45) DEFAULT NULL,
  user int(11) DEFAULT NULL,
  created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  price decimal(10,0) DEFAULT NULL,
  ip varchar(45) DEFAULT NULL,
  session varchar(32) DEFAULT NULL,
  PRIMARY KEY  (id),
  KEY appointments_location (location),
  KEY appointments_service (service),
  KEY appointments_worker (worker)
) $charset_collate ;
EOT;

$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_connections (
  id int(11) NOT NULL AUTO_INCREMENT,
  group_id int(11) DEFAULT NULL,
  location int(11) DEFAULT NULL,
  service int(11) DEFAULT NULL,
  worker int(11) DEFAULT NULL,
  day_of_week varchar(60) DEFAULT NULL,
  time_from time DEFAULT NULL,
  time_to time DEFAULT NULL,
  day_from date DEFAULT NULL,
  day_to date DEFAULT NULL,
  is_working smallint(3) DEFAULT NULL,
  PRIMARY KEY  (id),
  KEY location_to_connection (location),
  KEY service_to_location (service),
  KEY worker_to_connection (worker)
) $charset_collate ;
EOT;

$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_locations (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  address text NOT NULL,
  location varchar(255) DEFAULT NULL,
  cord varchar(255) DEFAULT NULL,
  PRIMARY KEY  (id)
) $charset_collate ;
EOT;

$table_querys[] = <<<EOT
CREATE TABLE IF NOT EXISTS {$table_prefix}ea_options (
  id int(11) NOT NULL AUTO_INCREMENT,
  ea_key varchar(45) DEFAULT NULL,
  ea_value text,
  type varchar(45) DEFAULT NULL,
  PRIMARY KEY  (id)
) $charset_collate ;
EOT;

$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_staff (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(100) DEFAULT NULL,
  description text,
  email varchar(100) DEFAULT NULL,
  phone varchar(45) DEFAULT NULL,
  PRIMARY KEY  (id)
) $charset_collate ;
EOT;

$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_services (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  duration int(11) NOT NULL,
  price decimal(10,0) DEFAULT NULL,
  PRIMARY KEY  (id)
) $charset_collate ;
EOT;

$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_appointments
  ADD CONSTRAINT {$table_prefix}ea_appointments_ibfk_1 FOREIGN KEY (location) REFERENCES {$table_prefix}ea_locations (id) ON DELETE CASCADE,
  ADD CONSTRAINT {$table_prefix}ea_appointments_ibfk_2 FOREIGN KEY (service) REFERENCES {$table_prefix}ea_services (id) ON DELETE CASCADE,
  ADD CONSTRAINT {$table_prefix}ea_appointments_ibfk_3 FOREIGN KEY (worker) REFERENCES {$table_prefix}ea_staff (id) ON DELETE CASCADE;
EOT;
$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_connections
  ADD CONSTRAINT {$table_prefix}ea_connections_ibfk_1 FOREIGN KEY (location) REFERENCES {$table_prefix}ea_locations (id) ON DELETE CASCADE,
  ADD CONSTRAINT {$table_prefix}ea_connections_ibfk_2 FOREIGN KEY (service) REFERENCES {$table_prefix}ea_services (id) ON DELETE CASCADE,
  ADD CONSTRAINT {$table_prefix}ea_connections_ibfk_3 FOREIGN KEY (worker) REFERENCES {$table_prefix}ea_staff (id) ON DELETE CASCADE;
EOT;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// create structure
		foreach ($table_querys as $table_query) {
			dbDelta( $table_query );
		}

		// add relations
		foreach ($alter_querys as $alter_query) {
			$wpdb->query($alter_query);
		}

		update_option( 'easy_app_db_version', $this->easy_app_db_version );
	}

	/**
	 * Insert start data into options
	 * @return [type] [description]
	 */
	public function init_data() {
		global $wpdb;

		// options table
		$table_name = $wpdb->prefix . 'ea_options';

		// rows data
		$wp_ea_options = array(
			array('ea_key' => 'mail.pending','ea_value' => 'pending','type' => 'default'),
			array('ea_key' => 'mail.reservation','ea_value' => 'reservation','type' => 'default'),
			array('ea_key' => 'mail.canceled','ea_value' => 'canceled','type' => 'default'),
			array('ea_key' => 'mail.confirmed','ea_value' => 'confirmed','type' => 'default'),
			array('ea_key' => 'trans.service','ea_value' => 'Service','type' => 'default'),
			array('ea_key' => 'trans.location','ea_value' => 'Location','type' => 'default'),
			array('ea_key' => 'trans.worker','ea_value' => 'Worker','type' => 'default'),
			array('ea_key' => 'trans.done_message','ea_value' => 'Done','type' => 'default'),
			array('ea_key' => 'time_format','ea_value' => '00-24','type' => 'default'),
			array('ea_key' => 'trans.currency','ea_value' => '$','type' => 'default'),
			array('ea_key' => 'pending.email','ea_value' => '','type' => 'default'),
			array('ea_key' => 'price.hide','ea_value' => '0','type' => 'default'),
			array('ea_key' => 'datepicker','ea_value' => 'en-US','type' => 'default'),
			array('ea_key' => 'send.user.email','ea_value' => '0','type' => 'default'),
			array('ea_key' => 'custom.css','ea_value' => '','type' => 'default')
		);

		// insert options
		foreach ($wp_ea_options as $row) {
			$wpdb->insert(
				$table_name,
				$row
			);
		}
	}

	public function update()
	{
		global $wpdb;

		// get table prefix
		$table_prefix = $wpdb->prefix;

		$version = get_option( 'easy_app_db_version', '1.0');

		// Migrate from 1.0 > 1.1
		if( version_compare( $version, '1.1', '<' )) {

			$this->init_db();

			// options table
			$table_name = $wpdb->prefix . 'ea_options';
			// rows data
			$wp_ea_options = array(
				array('ea_key' => 'pending.email','ea_value' => '','type' => 'default'),
				array('ea_key' => 'price.hide','ea_value' => '0','type' => 'default')
			);
			// insert options
			foreach ($wp_ea_options as $row) {
				$wpdb->insert(
					$table_name,
					$row
				);
			}

			$version = '1.1';
		}

		// Migrate from 1.2.1- > 1.2.2
		if(version_compare( $version, '1.2.2', '<' )) {
			$version = '1.2.2';

			$alter_querys = array();

$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_appointments DROP FOREIGN KEY {$table_prefix}ea_appointments_ibfk_1;
EOT;
$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_appointments DROP FOREIGN KEY {$table_prefix}ea_appointments_ibfk_2;
EOT;
$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_appointments DROP FOREIGN KEY {$table_prefix}ea_appointments_ibfk_3;
EOT;
$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_connections DROP FOREIGN KEY {$table_prefix}ea_connections_ibfk_1;
EOT;
$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_connections DROP FOREIGN KEY {$table_prefix}ea_connections_ibfk_2;
EOT;
$alter_querys[] = <<<EOT
ALTER TABLE {$table_prefix}ea_connections DROP FOREIGN KEY {$table_prefix}ea_connections_ibfk_3;
EOT;

$alter_querys[] = <<<EOT
DELETE FROM {$table_prefix}ea_connections 
WHERE 
	location NOT IN (SELECT id FROM {$table_prefix}ea_locations)
	OR
	service NOT IN (SELECT id FROM {$table_prefix}ea_services)
	OR
	worker NOT IN (SELECT id FROM {$table_prefix}ea_staff);
EOT;

$alter_querys[] = <<<EOT
DELETE FROM {$table_prefix}ea_appointments 
WHERE 
	location NOT IN (SELECT id FROM {$table_prefix}ea_locations)
	OR
	service NOT IN (SELECT id FROM {$table_prefix}ea_services)
	OR
	worker NOT IN (SELECT id FROM {$table_prefix}ea_staff);
EOT;

			// add relations
			foreach ($alter_querys as $alter_query) {
				$wpdb->query($alter_query);
			}

			$this->init_db();
		}

		// Migrate from 1.2.2 > 1.2.3
		if(version_compare( $version, '1.2.3', '<' )) {
			$version = '1.2.3';
		}

		// Migrate form 1.2.3 > 1.2.4
		if(version_compare( $version, '1.2.4', '<')) {
			$option = array('ea_key' => 'datepicker','ea_value' => 'en-US','type' => 'default');

			$table_name = $wpdb->prefix . 'ea_options';

			$wpdb->insert(
				$table_name,
				$option
			);

			$version = '1.2.4';
		}

		// Migrate form 1.2.4 > 1.2.7
		if(version_compare( $version, '1.2.7', '<')) {
			$version = '1.2.7';
		}

		// Migrate form 1.2.7 > 1.2.8
		if(version_compare( $version, '1.2.8', '<')) {
			$option = array('ea_key' => 'send.user.email','ea_value' => '0','type' => 'default');

			$table_name = $wpdb->prefix . 'ea_options';

			$wpdb->insert(
				$table_name,
				$option
			);

			$version = '1.2.8';
		}

		// Migrate form 1.2.8 > 1.2.9
		if(version_compare( $version, '1.2.9', '<')) {
			$option = array('ea_key' => 'custom.css','ea_value' => '','type' => 'default');

			$table_name = $wpdb->prefix . 'ea_options';

			$wpdb->insert(
				$table_name,
				$option
			);

			$version = '1.2.9';
		}

		update_option( 'easy_app_db_version', $version );
	}
}