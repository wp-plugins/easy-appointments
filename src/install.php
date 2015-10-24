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
		$this->easy_app_db_version = '1.5.2';
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

$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_meta_fields (
  id int(11) NOT NULL AUTO_INCREMENT,
  type varchar(50) NOT NULL,
  slug varchar(255) NOT NULL,
  label varchar(255) NOT NULL,
  mixed text NOT NULL,
  default_value varchar(50) NOT NULL,
  visible tinyint(4) NOT NULL,
  required tinyint(4) NOT NULL,
  validation varchar(50) NULL,
  position int(11) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate ;
EOT;


$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_fields (
  id int(11) NOT NULL AUTO_INCREMENT,
  app_id int(11) NOT NULL,
  field_id int(11) NOT NULL,
  value varchar(500) DEFAULT NULL,
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
			array('ea_key' => 'custom.css','ea_value' => '','type' => 'default'),
			array('ea_key' => 'show.iagree','ea_value' => '0','type' => 'default'),
			array('ea_key' => 'cancel.scroll','ea_value' => 'calendar','type' => 'default'),
			array('ea_key' => 'multiple.work','ea_value' => '1','type' => 'default'),
			array('ea_key' => 'compatibility.mode','ea_value' => '0','type' => 'default')
		);

		// insert options
		foreach ($wp_ea_options as $row) {
			$wpdb->insert(
				$table_name,
				$row
			);
		}

		$default_fields = $this->migrateFormFields();

		$table_name = $wpdb->prefix . 'ea_meta_fields';

		foreach ($default_fields as $row) {
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

		$charset_collate = $wpdb->get_charset_collate();

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

		if(version_compare( $version, '1.3.0', '<')) {
			// rows data
			$wp_ea_options = array(
				array('ea_key' => 'show.iagree','ea_value' => '0','type' => 'default'),
				array('ea_key' => 'cancel.scroll','ea_value' => 'calendar','type' => 'default')
			);

			$table_name = $wpdb->prefix . 'ea_options';

			// insert options
			foreach ($wp_ea_options as $row) {
				$wpdb->insert(
					$table_name,
					$row
				);
			}

			$version = '1.3.0';
		}

		if(version_compare($version, '1.4.0', '<')) {
			$version = '1.4.0';
		}

		// Migrate to last version
		if(version_compare($version, '1.5.0', '<')) {
			$version = '1.5.0';
			$table_querys = array();

			$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_fields (
  id int(11) NOT NULL AUTO_INCREMENT,
  app_id int(11) NOT NULL,
  field_id int(11) NOT NULL,
  value varchar(500) DEFAULT NULL,
  PRIMARY KEY  (id)
) $charset_collate ;
EOT;

			$table_querys[] = <<<EOT
CREATE TABLE {$table_prefix}ea_meta_fields (
  id int(11) NOT NULL AUTO_INCREMENT,
  type varchar(50) NOT NULL,
  slug varchar(255) NOT NULL,
  label varchar(255) NOT NULL,
  mixed text NOT NULL,
  default_value varchar(50) NOT NULL,
  visible tinyint(4) NOT NULL,
  required tinyint(4) NOT NULL,
  validation varchar(50) NULL,
  position int(11) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate ;
EOT;

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			// add relations
			foreach ($table_querys as $table) {
				dbDelta($table);
			}

			$default_fields = $this->migrateFormFields();

			$table_name = $wpdb->prefix . 'ea_meta_fields';

			$ids = array();

			foreach ($default_fields as $row) {
				$wpdb->insert(
					$table_name,
					$row
				);

				$ids[$row['slug']] = $wpdb->insert_id;
			}

			$this->migrateOldFormValues($ids);
		}

		// Migrate to last version
		if(version_compare($version, '1.5.1', '<')) {
			// rows data
			$wp_ea_options = array(
				array('ea_key' => 'multiple.work','ea_value' => '1','type' => 'default'),
			);

			$table_name = $wpdb->prefix . 'ea_options';

			// insert options
			foreach ($wp_ea_options as $row) {
				$wpdb->insert(
					$table_name,
					$row
				);
			}

			$version = '1.5.1';
		}

		if(version_compare($version, '1.5.2', '<')) {
			// rows data
			$wp_ea_options = array(
				array('ea_key' => 'compatibility.mode','ea_value' => '0','type' => 'default'),
			);

			$table_name = $wpdb->prefix . 'ea_options';

			// insert options
			foreach ($wp_ea_options as $row) {
				$wpdb->insert(
					$table_name,
					$row
				);
			}

			$version = '1.5.2';
		}

		update_option( 'easy_app_db_version', $version );
	}

	private function migrateFormFields()
	{
		$email   = __('EMail', 'easy-appointments');
		$name    = __('Name', 'easy-appointments');
		$phone   = __('Phone', 'easy-appointments');
		$comment = __('Description', 'easy-appointments');

		$data = array();

		// email
		$data[] = array(
			'type'          => EAMetaFields::T_INPUT,
			'slug'          => str_replace('-', '_', sanitize_title('email')),
			'label'         => $email,
			'default_value' => '',
			'validation'    => 'email',
			'mixed'         => '',
			'visible'       => 1,
			'required'      => 1,
			'position'      => 1
			);

		$data[] = array(
			'type'          => EAMetaFields::T_INPUT,
			'slug'          => str_replace('-', '_', sanitize_title('name')),
			'label'         => $name,
			'default_value' => '',
			'validation'    => 'minlength-3',
			'mixed'         => '',
			'visible'       => 1,
			'required'      => 1,
			'position'      => 2
		);

		$data[] = array(
			'type'          => EAMetaFields::T_INPUT,
			'slug'          => str_replace('-', '_', sanitize_title('phone')),
			'label'         => $phone,
			'default_value' => '',
			'validation'    => 'minlength-3',
			'mixed'         => '',
			'visible'       => 1,
			'required'      => 1,
			'position'      => 3
		);

		$data[] = array(
			'type'          => EAMetaFields::T_TEXTAREA,
			'slug'          => str_replace('-', '_', sanitize_title('description')),
			'label'         => $comment,
			'default_value' => '',
			'validation'    => NULL,
			'mixed'         => '',
			'visible'       => 1,
			'required'      => 0,
			'position'      => 4
		);

		return $data;
	}

	/**
	 * Insert all the old values from appointments
	 */
	private function migrateOldFormValues($ids)
	{
		global $wpdb;

		$table_name = 'ea_appointments';

		$models = new EADBModels();
		$apps = $models->get_all_rows($table_name);

		$chunks = array_chunk($apps, 100);

		$rows = array();
		$keys = array('email', 'name', 'phone', 'description');

		$table_name = $wpdb->prefix . 'ea_fields';

		foreach ($chunks as $chunk) {
			// helpers
			$values = array();
			$place_holders = array();

			$query = "INSERT INTO $table_name (app_id, field_id, value) VALUES ";

			// all appointments
			foreach ($chunk as $app) {
				// set insert for every key email, name, phone, description
				foreach ($keys as $key) {
					array_push($values, $app->id, $ids[$key], $app->{$key});
					$place_holders[] = "('%d', '%d', '%s')";
				}
			}

			$query .= implode(', ', $place_holders);
			$wpdb->query( $wpdb->prepare("$query ", $values));
		}
	}
}