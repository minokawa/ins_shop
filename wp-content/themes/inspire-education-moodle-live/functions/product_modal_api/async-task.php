<?php

if ( ! class_exists( 'WP_Async_Task' ) ) {
	abstract class WP_Async_Task {
		const LOGGED_IN = 1;
		const LOGGED_OUT = 2;
		const BOTH = 3;
		protected $argument_count = 20;
		protected $priority = 10;
		protected $action;
		protected $_body_data;
		public function __construct( $auth_level = self::BOTH ) {
				if ( empty( $this->action ) ) {
						throw new Exception( 'Action not defined for class ' . __CLASS__ );
				}
				add_action( $this->action, array( $this, 'launch' ), (int) $this->priority, (int) $this->argument_count );
				if ( $auth_level & self::LOGGED_IN ) {
						add_action( "admin_post_wp_async_$this->action", array( $this, 'handle_postback' ) );
				}
				if ( $auth_level & self::LOGGED_OUT ) {
						add_action( "admin_post_nopriv_wp_async_$this->action", array( $this, 'handle_postback' ) );
				}
		}
		public function launch() {
				$data = func_get_args();
				try {
						$data = $this->prepare_data( $data );
				} catch ( Exception $e ) {
						return;
				}
				$data['action'] = "wp_async_$this->action";
				$data['_nonce'] = $this->create_async_nonce();
				$this->_body_data = $data;
				if ( ! has_action( 'shutdown', array( $this, 'launch_on_shutdown' ) ) ) {
						add_action( 'shutdown', array( $this, 'launch_on_shutdown' ) );
				}
		}
		public function launch_on_shutdown() {
			if ( ! empty( $this->_body_data ) ) {
					$cookies = array();
					foreach ( $_COOKIE as $name => $value ) {
							$cookies[] = "$name=" . urlencode( is_array( $value ) ? serialize( $value ) : $value );
					}
					$request_args = array(
							'timeout'   => 0.01,
							'blocking'  => false,
							'sslverify' => apply_filters( 'https_local_ssl_verify', true ),
							'body'      => $this->_body_data,
							'headers'   => array(
									'cookie' => implode( '; ', $cookies ),
							),
					);
					$url = admin_url( 'admin-post.php' );
					wp_remote_post( $url, $request_args );
			}
		}
		public function handle_postback() {
				if ( isset( $_POST['_nonce'] ) && $this->verify_async_nonce( $_POST['_nonce'] ) ) {
						if ( ! is_user_logged_in() ) {
								$this->action = "nopriv_$this->action";
						}
						$this->run_action();
				}

				add_filter( 'wp_die_handler', function() { die(); } );
				wp_die();
		}
		protected function create_async_nonce() {
				$action = $this->get_nonce_action();
				$i      = wp_nonce_tick();
				return substr( wp_hash( $i . $action . get_class( $this ), 'nonce' ), - 12, 10 );
		}
		protected function verify_async_nonce( $nonce ) {
				$action = $this->get_nonce_action();
				$i      = wp_nonce_tick();
				if ( substr( wp_hash( $i . $action . get_class( $this ), 'nonce' ), - 12, 10 ) == $nonce ) {
						return 1;
				}
				if ( substr( wp_hash( ( $i - 1 ) . $action . get_class( $this ), 'nonce' ), - 12, 10 ) == $nonce ) {
						return 2;
				}
				return false;
		}
		protected function get_nonce_action() {
				$action = $this->action;
				if ( substr( $action, 0, 7 ) === 'nopriv_' ) {
						$action = substr( $action, 7 );
				}
				$action = "wp_async_$action";
				return $action;
		}
		abstract protected function prepare_data( $data );
		abstract protected function run_action();
	}
}


class Async_Moodle_Event_Check_Task extends WP_Async_Task {
	protected $action = 'lookup_moodle_event';
	protected function prepare_data( $request_data) {
		return array( 'request_data' => $request_data );
	}
	protected function run_action() {
		do_action( "wp_async_$this->action", '');
	}
}


