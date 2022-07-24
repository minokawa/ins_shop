<?php
/**
 * Pluginname Class Doc Comment
 *
 * @location Class
 * @package  Inspire
 * @author   litolagunday@gmail.com
 */

 // Program =  The educational content - {Course | Course_Unit | Any Permuttion of the two}
 // Workshop = Is the bookable event where the program will be held , (Program + Date + Location)
 // WorkshopCalendar = Is the collection of workshops, itemized for a date range, resposionble for searching and managing

namespace Inspire;

use Roomify\Bat\Store\SqlLiteDBStore;
use Inspire\Booking\QueryGenerator;
use Inspire\Booking\WorkshopCalendar;
use Inspire\Booking\Program;
use Inspire\Booking\Workshop;

final	class BookingManager{
	use \Inspire\Booking\SingletonTrait;
	private static $config;
	private static $admin_dashboard;
	private static $template;
	private static $calendar;
	private static $program_config;
	private static $type = 'workshop';
	private static $location = 'melbourne';
	protected $pdo = NULL;
	protected $data_object = NULL;

	private function __construct() {
		self::$config = \Inspire\Booking\ConfigLoader::instance();
		self::$admin_dashboard = \Inspire\Booking\Dashboard::instance();
	}

	public function init(){
		$this->setup_plugin();
	}

	private function setup_plugin() {
		date_default_timezone_set('Australia/Brisbane');

		self::$config->setup([__DIR__], 'plugin_config.yaml');
		self::$admin_dashboard->setup(self::$config->get('admin'));
		self::$program_config = self::$config->get('programs');

		add_action( 'inspire_create_workshop', array($this, 'load_workshops'), 20,1);
		add_action( 'inspire_update_workshop', array($this, 'update_workshop'), 20,1);
		add_action( 'inspire_search_calendar', array($this, 'get_program_events_month'), 20,1);

		$this->connect();
		$this->maybe_initialize_database();
		$this->load_programs();
	}

	private function connect() {
		$pdo = NULL;
		if ($this->pdo === NULL) {
			$my_plugin = WP_PLUGIN_DIR . '/inspire-booking-manager';
			$this->pdo = new \PDO("sqlite:".$my_plugin."/store/workshop_calendar.db");
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->data_object = new SqlLiteDBStore($this->pdo, self::$location , self::$type);
			$this->data_object->day_table = 'inspire_'.self::$location.'_day_' . self::$type;
			$this->data_object->hour_table = 'inspire_'.self::$location.'_hour_' . self::$type;
			$this->data_object->minute_table = 'inspire_'.self::$location.'_minute_' . self::$type;
		}
	}

	private function maybe_initialize_database( $args = NULL) {
		$this->pdo->exec(QueryGenerator::createDayTable(self::$location, self::$type));
		$this->pdo->exec(QueryGenerator::createHourTable(self::$location, self::$type));
		$this->pdo->exec(QueryGenerator::createMinuteTable(self::$location, self::$type));
	}

	private function load_programs() {
		$programs = [];
		foreach(self::$program_config as $key=>$val){ $programs[] = new Program($key, 0); }
		self::$calendar =  new WorkshopCalendar($programs, $this->data_object);
	}

	public function load_workshops( $args = NULL) {
		$workshops = [];
		foreach(self::$program_config as $p_key=>$p_val){
			$p = new Program($p_key,1);
			foreach($p_val['workshops'] as $w_key=>$w_val){
				$s1 = new \DateTime($w_val['date'][0]);
				$s2 = new \DateTime($w_val['date'][1]);
				$workshops[] = new Workshop($s1 ,$s2 , $p, $w_val['seats']);
			}
		}
		$response = self::$calendar->addEvents($workshops, Workshop::BAT_DAILY);
	}

	public function update_workshop_storage( $args = NULL) {
		$s1 = new \DateTime($args['s1']);
		$s2 = new \DateTime($args['s2']);
		$pid = $args['pid'];
		$workshops = self::$calendar->getWorkshops($s1,$s2, true);
		$val = $workshops[$pid][0]->getValue();
		$val--;
		$workshops[$pid][0]->setValue($val);
		$res = $workshops[$pid][0]->saveEvent($this->data_object,Workshop::BAT_DAILY);

	}

	public function get_program_events_month(array $args){
		$s1 = $args['year'].'-'.$args['month'].'-01 00:00' ;
		$start_date = new \DateTime($s1);
		$end_date = new \DateTime(date("Y-m-t", strtotime($s1)) . ' 23:59');
		$workshops = self::$calendar->getWorkshops($start_date,$end_date, Workshop::BAT_DAILY);
		$program_events_month = $workshops[$args['pid']]['bat_day'][$args['year']][$args['month']];

	}
}
