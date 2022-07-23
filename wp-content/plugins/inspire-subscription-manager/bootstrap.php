<?php
/**
 * The plugin bootstrap file
 *
 *
 * @wordpress-plugin
 * Plugin Name:     Inspire Subscriptions Manager
 * Plugin URI:      http://codes.lagunday.com/li2-plugin
 * Description:     A toolbox for managing Subscriptions of woo products
 * Author:          litolagunday@gmail.com
 * Author URI:      http://codes.lagunday.com
 * Version:         0.1.0
 *
 * @package         Inspire
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

if ( ! defined( 'INSPIRE_SUBSCRIPTION_MANAGER' ) ) {
	define( 'INSPIRE_SUBSCRIPTION_MANAGER', plugin_dir_url(  __DIR__  . '/bootstrap.php' ) );
}

function inspire_subscription_php_requirements_error() {
	$class = 'notice notice-error';
	$message = INSPIRE_SUBSCRIPTION_MANAGER . ' requires PHP 7.4 or above. And ACF Fields' ;

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

function inspire_subscription_plugin_requirements_error() {
	$class = 'notice notice-error';
	$message = INSPIRE_SUBSCRIPTION_MANAGER . ' requires ACF Fields and Woo Subscriptions enabled.' ;

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

//Check requirements
$php_version = phpversion();

$requirements_failed = false;

if (version_compare($php_version, "7.4") === -1) {
    add_action( 'admin_notices', 'inspire_subscription_php_requirements_error' );
    $requirements_failed = true;
}

if( ! class_exists('ACF') ) {
	add_action( 'admin_notices', 'inspire_subscription_plugin_requirements_error' );
	$requirements_failed = true;
}


if ($requirements_failed) {
	return;
}

//Create Plugin Instance
$plugin = \Inspire\SubscriptionManager::instance();
$plugin->init();

