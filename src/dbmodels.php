<?php

/**
* DataBase models
*/
class EADBModels
{
	/**
	 * WPDB
	 *
	 * @var $wpdb
	 **/
	var $db;

	function __construct()
	{
		global $wpdb;

		$this->db = $wpdb;
	}

	/**
	 * 
	 */
	public function get_all_rows( $table_name, $data = array() )
	{

		$ignore = array( 'action' );

		$where = '';

		$params = array();

		foreach ($data as $key => $value) {
			if(!in_array( $key, $ignore )) {

				$helper = '=';

				// if equal or greater
				if(strpos($value, '+') === 0) {
					$helper = '>=';
					$value = substr($value, 1);

				// if equal or smaller
				} else if(strpos($value, '-') === 0) {
					$helper = '<=';
					$value = substr($value, 1);
				}

				if(in_array( $key , array('from', 'to') )) {
					$key = 'date';
				}

				if(is_numeric($value)) {
					$where .= " AND {$key}{$helper}%d";
				} else {
					$where .= " AND {$key}{$helper}%s";
				}

				$params[] = $value;
			}
		}

		if($where === '') {
			$where = ' AND 1=%d';
			$params[] = 1;
		}

		$query = $this->db->prepare("SELECT * 
			FROM {$this->db->prefix}{$table_name} 
			WHERE 1$where 
			ORDER BY id DESC",
			$params
		);

		return $this->db->get_results($query);
	}

	/**
	 * 
	 */
	public static function get_pre_cache_json( $table_name )
	{
		global $wpdb;

		$query = "SELECT * 
			FROM {$wpdb->prefix}{$table_name} 
			ORDER BY id DESC";
		
		return json_encode($wpdb->get_results($query));
	}

	/**
	 * 
	 */
	public function get_row( $table_name, $id, $output_type = OBJECT )
	{

		$query = $this->db->prepare("SELECT * 
			FROM {$this->db->prefix}{$table_name}
			WHERE id=%d",
			$id
		);
		
		return $this->db->get_row($query, $output_type);
	}

	/**
	 * 
	 */
	public function replace( $table_name, $data, $json = false )
	{

		$table_name = $this->db->prefix . $table_name;

		$types = array();

		foreach ($data as $key => $value) {
			if(substr($key, 0, 1) == '_') {
				// remove key->value
				unset($data[$key]);

				continue;
			}

			$types[] = ( is_numeric($value) ) ? '%d' : '%s';
		}

		$return = $this->db->replace(
			$table_name,
			$data,
			$types 
		);

		if($return == false) {
			return false;
		}

		if($json){
			$output = new stdClass;
			$output->id = "{$this->db->insert_id}";
			return $output;
		}
		
		return $this->db->insert_id;
	}

	/**
	 * 
	 */
	public function delete($table_name, $data, $json = false)
	{

		$table_name = $this->db->prefix . $table_name;
		
		return $this->db->delete( $table_name, array( 'id' => (int)$data['id'] ), array( '%d' ) );
	}

	public function get_next( $options )
	{
		$table_name = $this->db->prefix . 'ea_connections';

		$vars = '';

		foreach ($options as $key => $value) {
			if($key === 'next') {
				continue;
			}

			if(is_numeric($value)) {
				$vars .= " AND $key=%d";
			} else {
				$vars .= " AND $key=%s";
			}
		}

		$query = $this->db->prepare(
			"SELECT DISTINCT {$options['next']} 
			 FROM $table_name 
			 WHERE 1=1$vars",
			 $options
		);

		$next_rows_raw = $this->db->get_results($query, ARRAY_N);

		$next_rows = array();

		foreach ($next_rows_raw as $value) {
			$next_rows[] = $value[0];
		}

		$ids = implode(',', $next_rows);

		if($options['next'] == 'worker') {
			$entity_table = 'staff';
		} else {
			$entity_table = $options['next'] . 's';
		}

		$next_table = $this->db->prefix . "ea_{$entity_table}";

		$query = "SELECT * FROM $next_table WHERE id IN ({$ids})";

		return $this->db->get_results($query);
	}

	/**
	 * Check table name 
	 * @param  [type] $table_name [description]
	 * @return [type]             [description]
	 */
	private static function check_table_name($table_name)
	{
		$tables = array(
			'appointments',
			'connections',
			'locations',
			'options',
			'services',
			'staff'
		);

		return in_array($table_name, $tables);
	}
}