<?php
/**
 * Pluginname Class Doc Comment
 *
 * @category Class
 * @package  Inspire
 * @author   litolagunday@gmail.com
 */

namespace Inspire;

final	class SubscriptionManager{
	use \Inspire\Subscription\SingletonTrait;
	private static $config;
	private static $admin_dashboard;
	private static $template;

	private function __construct() {
		self::$config = \Inspire\Subscription\ConfigLoader::instance();
		self::$admin_dashboard = \Inspire\Subscription\Dashboard::instance();
	}

	public function init(){
		$this->read_config();
		$this->setup_plugin();
	}

	private function read_config() {
		self::$config->setup([__DIR__], 'plugin_config.yaml');
	}

	private function setup_plugin() {
		self::$admin_dashboard->setup(self::$config->get('admin'));
	}

}
