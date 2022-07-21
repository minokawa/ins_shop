<?php
namespace Inspire\Booking;

trait SingletonTrait{

	protected static $instance = null;

	protected function __construct() {}

	final public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	private function __clone() {}

	final public function __wakeup() {
		die();
	}
}
