<?php
/**
 * Pluginname Class Doc Comment
 *
 * @category Class
 * @package  Inspire
 * @author   litolagunday@gmail.com
 */

namespace Inspire;
use Roomify\Bat\Unit\Unit;
use Roomify\Bat\Event\Event;
use Roomify\Bat\Calendar\Calendar;
use Roomify\Bat\Store\SqlDBStore;
use Roomify\Bat\Store\SqlLiteDBStore;
use Roomify\Bat\Constraint\MinMaxDaysConstraint;
use Inspire\Booking\SetupStore;

final	class BookingManager{
	use \Inspire\Booking\SingletonTrait;
	private static $config;
	private static $admin_dashboard;
	private static $template;
	//private static $course_events;
	protected $pdo = NULL;
	private function __construct() {
		self::$config = \Inspire\Booking\ConfigLoader::instance();
		self::$admin_dashboard = \Inspire\Booking\Dashboard::instance();
	}

	public function init(){
		$this->read_config();
		$this->setup_plugin();
	}

	private function connect() {
		$pdo = NULL;
		if ($this->pdo === NULL) {

			$my_plugin = WP_PLUGIN_DIR . '/inspire-booking-manager';
			$this->pdo = new \PDO("sqlite:".$my_plugin."/store/course_calendar.db");
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
	}

	private function setUp() {
		$this->pdo->exec(SetupStore::createDayTable('FIRST_AID', 'state'));
		$this->pdo->exec(SetupStore::createHourTable('FIRST_AID', 'state'));
		$this->pdo->exec(SetupStore::createMinuteTable('FIRST_AID', 'state'));

		$this->pdo->exec(SetupStore::createDayTable('FIRST_AID', 'seats'));
		$this->pdo->exec(SetupStore::createHourTable('FIRST_AID', 'seats'));
		$this->pdo->exec(SetupStore::createMinuteTable('FIRST_AID', 'seats'));
	}

	private function read_config() {
		self::$config->setup([__DIR__], 'plugin_config.yaml');
	}

	private function setup_plugin() {
		$this->connect();
		$this->setup();

		//UNIT ID< DEFAULT VALUE
		$unit = new Unit(123421,0);
		$start_date = new \DateTime('2023-01-01 00:12');
		$end_date = new \DateTime('2023-01-01 23:00');

		$state_calendar = new Calendar(array($unit), new SqlLiteDBStore($this->pdo, 'FIRST_AID', 'state'));

		$state = new Event($start_date, $end_date, $unit, 0);  //(i.e. unavailable)
		$state_calendar->addEvents(array($state), Event::BAT_DAILY);

		$s1 = new \DateTime('2023-01-01 00:00');
		$s2 = new \DateTime('2023-01-31 12:00');

		$response = $state_calendar->getMatchingUnits($s1, $s2, array(1), array());
		self::$admin_dashboard->setup(self::$config->get('admin'));
	}

}
