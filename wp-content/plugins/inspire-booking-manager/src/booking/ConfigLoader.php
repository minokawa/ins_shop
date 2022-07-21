<?php
/*
 * @category Class
 * @package  Inspire
 * @author   litolagunday@gmail.com
 */

namespace  Inspire\Booking;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

final class ConfigLoader{
	use \Inspire\Booking\SingletonTrait;
	private static $locator;
	private static $config;

	public function setup($dir,$file){
		self::$locator = new FileLocator($dir);
		$locations = self::$locator->locate($file, null, false);
		self::$config = Yaml::parse(file_get_contents($locations[0]));
	}

	public function get($config_id){
		return self::$config[$config_id];
	}
}
