<?php

/**
 * Report class
 */
class EAReport
{

	private $logic;

	function __construct() {
		$this->logic = new EALogic();
	}

	/**
	 * Main function for reports
	 * @param  string $report Report type
	 * @param  array $params  All params for report
	 * @return array          Report data
	 */
	public function get($report, $params) {
		$result = null;

		switch ($report) {
			case 'overview':

				$result = $this->get_whole_month_slots(
					$params['location'],
					$params['service'],
					$params['worker'],
					$params['month'],
					$params['year']
				);

				break;

			default:
				# code...
				break;
		}

		return $result;
	}

	/**
	 * Get open times for whole month
	 * 
	 * @param  int $location    Location
	 * @param  int $service     Service
	 * @param  int $worker      Worker
	 * @param  string $month    Month
	 * @param  string $year     Year
	 * @return array            Result for report
	 */
	public function get_whole_month_slots($location, $service, $worker, $month, $year) {

		$result = array();

		$num_of_days = date('t', strtotime($year . '-' . $month . '-01'));
		for( $i=1; $i<= $num_of_days; $i++) {
			$day = $year . "-". sprintf("%02d", $month) . "-". str_pad($i,2,'0', STR_PAD_LEFT);

			$result[$day] = $this->logic->get_open_slots($location, $service, $worker, $day, null, false);
		}

		return $result;
	}

	/**
	 * 
	 */
	public function get_available_dates($location, $service, $worker, $month, $year) {
		$slots = $this->get_whole_month_slots($location, $service, $worker, $month, $year);

		$currentDate = date('Y-m-d');

		$result = array();

		foreach ($slots as $key => $value) {
			if($currentDate > $key) {
				continue;
			}

			if(count($value) == 0) {
				$result[$key] = 'no-slots';
				continue;
			}

			$has_free = false;
			foreach ($value as $k => $v) {
				if( ((int) $v['count']) > 0 ) {
					$result[$key] = 'free';
					$has_free = true;
					break;
				}
			}

			if(!$has_free) {
				$result[$key] = 'busy';
			}
		}

		return $result;
	}
}