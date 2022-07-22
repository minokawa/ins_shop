<?php
namespace Inspire\Booking;
final class Dashboard {
	use \Inspire\Booking\SingletonTrait;
	private static $config = [];
	private static $template;

	public function setup($config){
		self::$config = $config;
		self::$template =  \Inspire\Booking\TemplateEngine::instance();
		self::$template->setup( __DIR__ . '/../templates');
		self::$template->add_filter(new \Twig\TwigFilter('html_entity_decode','html_entity_decode'));

		add_action('admin_menu', array (self::$instance, 'setup_dashboard_menu'),0);
		add_action('acf/save_post', array (self::$instance,'update_options') ,0,1);
		add_action('acf/input/admin_head', array($this, 'custom_screen_ui'), 20);

	}

	public function setup_dashboard_menu() {
			$args = ['page_title' => self::$config['name'],'menu_slug' => self::$config['slug'],'capability' => 'manage_options','position' => 2,'parent_slug' => '',	'icon_url' => 'dashicons-clipboard','redirect' => false,'post_id' => self::$config['slug'],'autoload' => true,];
			acf_add_options_page( $args );
	}

	public function custom_screen_ui() {
		$screen = get_current_screen();
		$plugin_screen_id = 'toplevel_page_' . self::$config['slug'];
		if ($screen->id == $plugin_screen_id ) {
			add_meta_box('submitdiv', 'booking Manager Actions', array($this, 'action_box'), 'acf_options_page', 'side', 'high');
			add_meta_box('debug-box-' . self::$config['slug'], 'Setup Overview', array($this, 'debug_box'), 'acf_options_page', 'normal', 'high');
		}
	}

	public function action_box($post, $args=array()) {
		$other_attributes = array( 'id' => 'booking-button-deploy' );
		echo '<div style="padding: 20px;display: flex;align-content: space-between;justify-content: space-evenly;    flex-direction: column;">';
			submit_button( 'Save Bookings Setup', 'primary', 'booking-save', false,array( 'id' => 'booking-button-submit', 'style' => 'width:100%; display:block' ));
		echo '</div>';
	}

	public function debug_box($post, $args=array()) {
		$mock_data['dump'] = '---';
		echo self::$template->render('dashboard.html.twig', $mock_data);
	}

	public function update_options($post_id) {

		do_action( 'inspire_update_course_calendar',123);
	}

}
