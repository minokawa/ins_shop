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

ini_set( 'display_errors', 1 );
error_reporting(E_ALL);

use Roomify\Bat\Store\SqlLiteDBStore;
use Inspire\Booking\QueryGenerator;
use Inspire\Booking\WorkshopCalendar;
use Inspire\Booking\Program;
use Inspire\Booking\Workshop;

final	class BookingManager{
	use \Inspire\Booking\SingletonTrait;
	private static $plugin_config;
	private static $admin_dashboard;
	private static $template;
	private static $calendar;
	private static $available_programs;
	private static $type = 'workshop';
	private static $location = 'melbourne';
	protected $pdo = NULL;
	protected $data_object = NULL;

	private function __construct() {
		self::$plugin_config = \Inspire\Booking\ConfigLoader::instance();
		self::$admin_dashboard = \Inspire\Booking\Dashboard::instance();
	}

	public function init(){
		$this->read_config();
		$this->setup_plugin();
		date_default_timezone_set('Australia/Brisbane');
	}

	private function read_config() {
		self::$plugin_config->setup([__DIR__], 'plugin_config.yaml');
	}

	private function setup_plugin() {
		self::$admin_dashboard->setup(self::$plugin_config->get('admin'));
		self::$available_programs = self::$plugin_config->get('programs');

		add_action( 'inspire_create_workshop', array($this, 'create_workshops'), 20,1);
		add_action( 'inspire_update_workshop', array($this, 'update_workshop'), 20,1);
		add_action( 'inspire_search_calendar', array($this, 'search_calendar'), 20,1);

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
		foreach(self::$available_programs as $key=>$val){
			$programs[] = new Program($key, 0);
		}
		self::$calendar =  new WorkshopCalendar($programs, $this->data_object);
	}

	public function create_workshops( $args = NULL) {
		$workshops = [];
		foreach(self::$available_programs as $program_key=>$program_val){
			$prog = new Program($program_key,0);
			foreach($program_val['workshops'] as $workshop_key=>$workshop_val){
				$s1 = new \DateTime($workshop_val['date'][0]);
				$s2 = new \DateTime($workshop_val['date'][1]);
				$workshops[] = new Workshop($s1 ,$s2 , $prog, $workshop_val['seats']);
			}
		}
		$response = self::$calendar->addEvents($workshops, Workshop::BAT_DAILY);
	}

	public function update_workshop( $args = NULL) {
		$s1 = new \DateTime('2023-01-01 00:00');
		$s2 = new \DateTime('2023-01-01 12:00');
		$program_id = 2;
		$workshops = self::$calendar->getWorkshops($s1,$s2, true);
		$val = $workshops[$program_id][0]->getValue();
		$val++;
		$workshops[$program_id][0]->setValue($val);
		echo $val;
		$res = $workshops[$program_id][0]->saveEvent($this->data_object,Workshop::BAT_DAILY);
		echo "\n RESULT-" . $res;
	}

	public function search_calendar( $args = NULL) {
		$s1 = new \DateTime('2023-01-01 00:00');
		$s2 = new \DateTime('2023-01-01 12:00');

		//Filter out zero seats
		$filter = array(0);
		$response =	self::$calendar->getFilteredWorkshops($s1, $s2, $filter, array(),false);
		$included = $response->getIncluded();
		$excluded = $response->getExcluded();

		foreach($included as $key => $val){
			var_dump($key);
		}
	}
}
