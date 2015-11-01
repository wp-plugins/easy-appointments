<?php

/**
 * Class responsible for App logic
 * reservation, free times...
 */
class EALogic
{

	function __construct()
	{

	}

	/**
	 * Retrive all open slots / times
	 * @param  int $location Location
	 * @param  int $service  Service
	 * @param  int $worker   Worker
	 * @param  datetime $day DateTime
	 * @param  int $app_id   Previus appointment
	 * @param  bool $check_current_day   Previus appointment
	 * @return array         Array of free times
	 */
	public function get_open_slots($location = null, $service = null, $worker = null, $day = null, $app_id = null, $check_current_day = true)
	{
		global $wpdb;

		$day_of_week = date('l', strtotime($day));

		$query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}ea_connections WHERE 
			location=%d AND 
			service=%d AND 
			worker=%d AND 
			day_of_week LIKE %s AND 
			is_working = 1 AND 
			(day_from IS NULL OR day_from < %s) AND 
			(day_to IS NULL OR day_to > %s)",
			$location, $service, $worker, "%{$day_of_week}%", $day, $day
		);

		$open_days = $wpdb->get_results($query);

		$working_hours = array();

		$serviceObj = $this->get_service($service);

		$is_current_day = (date('Y-m-d') == $day);
		$time_now = current_time( 'timestamp', false );

		// times
		foreach ($open_days as $working_day) {

			$upper_time = strtotime($working_day->time_to);

			$counter = 0;

			while(true) {
				$temp_time = strtotime($working_day->time_from);

				$temp_time += $serviceObj->duration * 60 * $counter++;

				if($temp_time < $upper_time) {
					$current_time = date('H:i', $temp_time);

					if($check_current_day && $is_current_day && $time_now > $temp_time) {
						continue;
					}

					if(!array_key_exists($current_time, $working_hours)) {
						$working_hours[$current_time] = 1;
					} else {
						$working_hours[$current_time] += 1;
					}
				} else {
					break;
				}
			}
		}

		// remove non-working time
		$this->remove_closed_slots($working_hours, $location, $service, $worker, $day, $serviceObj->duration);

		// remove already reserved times
		$this->remove_reserved_slots($working_hours, $location, $service, $worker, $day, $serviceObj->duration, $app_id);

		// format time
		return $this->format_time($working_hours);
	}

	/**
	 * Remove times when is not working
	 * @param  array    &$slots           Free slots
	 * @param  int      $location         Location
	 * @param  int      $service          Service
	 * @param  int      $worker           Worker
	 * @param  Datetiem $day              DateTime
	 * @param  time     $service_duration Service duration in minuts
	 * @return null
	 */
	private function remove_closed_slots(&$slots, $location = null, $service = null, $worker = null, $day = null, $service_duration)
	{
		global $wpdb;

		$day_of_week = date('l', strtotime($day));

		$query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}ea_connections WHERE 
			location=%d AND 
			service=%d AND 
			worker=%d AND 
			day_of_week LIKE %s AND 
			is_working = 0 AND 
			(day_from IS NULL OR day_from < %s) AND 
			(day_to IS NULL OR day_to > %s)",
			$location, $service, $worker, "%{$day_of_week}%", $day, $day
		);

		$closed_days = $wpdb->get_results($query);


		// check all no working times
		foreach ($closed_days as $working_day) {

			$lower_time = strtotime($working_day->time_from);
			$upper_time = strtotime($working_day->time_to);

			$counter = 0;

			// check slots
			foreach ($slots as $temp_time => $value) {
				$current_time = strtotime($temp_time);
				$current_time_end = strtotime("$temp_time + $service_duration minute");

				if($lower_time < $current_time && $upper_time <= $current_time) {
					// before
				} else if($lower_time >= $current_time_end && $upper_time > $current_time_end) {
					// after
				} else {
					// remove slot
					$slots[$temp_time] = $value - 1;
				}
			}
		}
	}

	/**
	 * Can make reservation for that ip
	 * @param  string $ip IP adress of the caller
	 * @return boolean    Can make reservation
	 */
	public function can_make_reservation($ip)
	{
		global $wpdb;

		$query = $wpdb->prepare(
			"SELECT id AS no_apps FROM {$wpdb->prefix}ea_appointments WHERE 
				ip=%s AND 
				status IN ('abandoned', 'pending') AND
				created >= now() - INTERVAL 1 DAY",
				$ip
		);

		$appIds = $wpdb->get_col($query);

		return (count($appIds) < 4);
	}

	/**
	 * Remove times that are reserved
	 * @param  array    &$slots           Free slots
	 * @param  int      $location         Location
	 * @param  int      $service          Service
	 * @param  int      $worker           Worker
	 * @param  Datetiem $day              DateTime
	 * @param  time     $service_duration Service duration in minuts
	 */
	private function remove_reserved_slots(&$slots, $location, $service, $worker, $day, $service_duration, $app_id = -1)
	{
		global $wpdb;

		if($app_id == "") {
			$app_id = -1;
		}

		$day_of_week = date('l', strtotime($day));

		$multiple = self::get_option_value('multiple.work', '1');

		$query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}ea_appointments WHERE 
			((location=%d AND service=%d) OR '{$multiple}' = '0') AND 
			worker=%d AND 
			date = %s AND
			id <> %d AND 
			status NOT IN ('abandoned','canceled')",
			$location, $service, $worker, $day, $app_id
		);

		$appointments = $wpdb->get_results($query);

		// check all no working times
		foreach ($appointments as $app) {
			$lower_time = strtotime($app->start);
			$upper_time = strtotime($app->end);

			// check slots
			foreach ($slots as $temp_time => $value) {
				$current_time = strtotime($temp_time);
				$current_time_end = strtotime("$temp_time + $service_duration minute");


				if($lower_time < $current_time && $upper_time <= $current_time) {
					// before
				} else if($lower_time >= $current_time_end && $upper_time > $current_time_end) {
					// after
				} else {

					// Cross time - remove one slot
					$slots[$temp_time] = $value - 1;
				}
			}
		}
	}

	/**
	 * Return services
	 */
	public function get_service($service_id)
	{
		$dbmod = new EADBModels();
		return $dbmod->get_row('ea_services', $service_id);
	}

	/**
	 * Get all status
	 */
	public static function getStatus() 
	{
		$status = array();

		$status['pending']     = __('pending', 'easy-appointments');
		$status['reservation'] = __('reservation', 'easy-appointments');
		$status['abandoned']   = __('abandoned', 'easy-appointments');
		$status['canceled']    = __('canceled', 'easy-appointments');
		$status['confirmed']   = __('confirmed', 'easy-appointments');

		return $status;
	}

	/**
	 * Retrive option from database
	 */
	public static function get_option_value($key, $default = null)
	{
		global $wpdb;

		if($default == null) {
			$default = $key;
		}

		$table_name = $wpdb->prefix . 'ea_options';

		$query_template = 
			"SELECT * 
			 FROM $table_name
			 WHERE `ea_key`=%s AND `type`=%s";

		$query = $wpdb->prepare(
			$query_template, $key, 'custom'
		);

		$result = $wpdb->get_row($query);

		if($result == null) {
			$query = $wpdb->prepare(
				$query_template, $key, 'default'
			);

			$result = $wpdb->get_row($query);
		}

		if(empty($result)) {
			return $default;
		}

		return $result->ea_value;
	}

	public static function get_options()
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'ea_options';

		$query = 
			"SELECT ea_key, ea_value 
			 FROM $table_name";

		$output = $wpdb->get_results($query, OBJECT_K);

		$result = array();

		foreach ($output as $key => $value) {
			$result[$key] = $value->ea_value;
		}

		return $result;
	}

	/**
	 * Sending mail with every status change
	 */
	public static function send_status_change_mail($app_id)
	{
		global $wpdb;

		$dbmodels = new EADBModels();

		$table_name = 'ea_appointments';

		$app = $dbmodels->get_row( $table_name, $app_id );

		$app_array = $dbmodels->get_appintment_by_id( $app_id );

		$params = array();
		
		foreach ($app_array as $key => $value) {
			$params["#$key#"] = $value;
		}

		$body_template = EALogic::get_option_value( 'mail.' . $app->status, 'mail' );

		$body = str_replace(array_keys($params), array_values($params) , $body_template);

		if(array_key_exists('email', $app_array)) {
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $app_array['email'], 'Reservation #' . $app_id, $body, $headers );
		}
	}

	/**
	 * Send email notification
	 */
	public static function send_notification($data)
	{
		$emails = self::get_option_value('pending.email', '');

		if($emails == '') {
			return;
		}

		$dbmodels = new EADBModels();

		$app_id = $data['id'];

		$data = $dbmodels->get_appintment_by_id( $app_id);

		$meta = $dbmodels->get_all_rows('ea_meta_fields', array(), array('position' => 'ASC'));

		ob_start();

		require EA_SRC_DIR . 'templates/mail.notification.tpl.php';

		$mail_content = ob_get_clean();

		$headers = array('Content-Type: text/html; charset=UTF-8');

		wp_mail( $emails, __('New Reservation #', 'easy-appointments') . $app_id, $mail_content, $headers );
	}

	/**
	 * Time format function
	 * @param  array &$times Array of slots
	 * @return array         Result times array
	 */
	public function format_time(&$times)
	{
		$result = array();

		$format = $this->get_option_value('time_format');

		foreach ($times as $time => $count) {
			switch ($format) {
				case '00-24':
					$result[] = array(
						'count' => $count,
						'value' => $time,
						'show'  => $time
					);
					break;
				case 'am-pm':
					$result[] = array(
						'count' => $count,
						'value' => $time,
						'show' => date("h:i a", strtotime($time))
					);
					break;
				default:
					$result[] = $time;
					break;
			}
		}

		return $result;
	}
}