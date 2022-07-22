<?php
/**
 * Pluginname Class Doc Comment
 *
 * @category Class
 * @package  Inspire
 * @author   litolagunday@gmail.com
 */

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
	private static $course_name = 'firstaid';
	private static $category = 'WORKSHOPS';
	protected $pdo = NULL;
	protected $data_object = NULL;

	private function __construct() {
		self::$config = \Inspire\Booking\ConfigLoader::instance();
		self::$admin_dashboard = \Inspire\Booking\Dashboard::instance();
	}

	public function init(){
		$this->read_config();
		$this->setup_plugin();
		date_default_timezone_set('Australia/Brisbane');
	}

	private function read_config() {
		self::$config->setup([__DIR__], 'plugin_config.yaml');
	}

	private function setup_plugin() {
		self::$admin_dashboard->setup(self::$config->get('admin'));
		add_action( 'inspire_setup_workshops', array($this, 'inspire_setup_workshops'), 20,1);
		add_action( 'inspire_search_workshop_calendar', array($this, 'search_workshop_calendar'), 20,1);
		$this->connect();
		$this->setup_workshop_database();
		$this->load_calendar();
	}

	private function connect() {
		$pdo = NULL;
		if ($this->pdo === NULL) {
			$my_plugin = WP_PLUGIN_DIR . '/inspire-booking-manager';
			$this->pdo = new \PDO("sqlite:".$my_plugin."/store/workshop_calendar.db");
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->data_object = new SqlLiteDBStore($this->pdo, self::$category , self::$course_name);
		}
	}

	private function setup_workshop_database( $args = NULL) {
		$this->pdo->exec(QueryGenerator::createDayTable(self::$category, self::$course_name));
		$this->pdo->exec(QueryGenerator::createHourTable(self::$category, self::$course_name));
		$this->pdo->exec(QueryGenerator::createMinuteTable(self::$category, self::$course_name));
	}

	private function load_calendar() {
		$this->data_object->day_table = 'inspire_'.self::$category.'_day_' . self::$course_name;
		$this->data_object->hour_table = 'inspire_'.self::$category.'_hour_' . self::$course_name;
		$this->data_object->minute_table = 'inspire_'.self::$category.'_minute_' . self::$course_name;

		$seat_id = 1; $seat_default_status = 0;
		$program1 = new Program(1, $seat_default_status);
		$program2 = new Program(2, $seat_default_status);
		$program3 = new Program(3, $seat_default_status);
		self::$calendar =  new WorkshopCalendar(array($program1,$program2,$program3), $this->data_object);
		$s1 = new \DateTime('2023-01-01 00:00');
		$s2 = new \DateTime('2023-03-31 24:00');
		self::$calendar->getEvents($s1,$s2,true);
	}

	public function inspire_setup_workshops( $args = NULL) {
		$s1 = new \DateTime('2023-01-01 00:00');
		$s2 = new \DateTime('2023-03-31 24:00');
		$program_1 = new Program(1,20);
		$program_2 = new Program(2,20);
		$program_3 = new Program(3,20);

		$workshop1 = new Workshop($s1 ,$s2 , $program_1, 20);
		$workshop2  = new Workshop($s1 ,$s2 , $program_2, 20);
		$workshop3  = new Workshop($s1 ,$s2 , $program_3, 20);

		$response = self::$calendar->addEvents(array(	$workshop1, $workshop2, $workshop3), Workshop::BAT_DAILY);
		var_dump($response);
	}

	public function search_workshop_calendar( $args = NULL) {
		$s1 = new \DateTime('2023-01-01 00:00');
		$s2 = new \DateTime('2023-01-31 12:00');
		$filter = array(1,0);
		$response =	self::$calendar->getFilteredUnits($s1, $s2, $filter, array(),false);
		$included = $response->getIncluded();
		$excluded = $response->getExcluded();
		var_dump($excluded);
		foreach($included as $key => $val){
			var_dump($key);
		}
	}
}
