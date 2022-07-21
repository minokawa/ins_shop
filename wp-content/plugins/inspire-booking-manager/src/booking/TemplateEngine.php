<?php
/**
 * Templater Class Doc Comment
 *
 *
 * @category Class
 * @package  Inspire
 * @author   litolagunday@gmail.com
 */

namespace  Inspire\Booking;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\StringLoaderExtension;

class TemplateEngine {

	private static $twig;

	use \Inspire\Booking\SingletonTrait;

	public function setup($template_dir){
		$file_loader = new FilesystemLoader($template_dir);
		$twig = new Environment($file_loader);
		$string_loader_ext = new StringLoaderExtension();
		$twig->addExtension($string_loader_ext);
		self::$twig = $twig;
	}

	public function render($template, $data){
		return self::$twig->render($template, $data);
	}

	public  function add_filter($filter){
		self::$twig->addFilter($filter);
	}
}

