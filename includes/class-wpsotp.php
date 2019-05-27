<?php

defined( 'ABSPATH' ) || exit;

/**
 * Main WPSOTP Class.
 *
 * @class WPSOTP
 */
class WPSOTP {

	/**
	 * WPSOTP Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();

		do_action( 'wpsotp_loaded' );
	}

	/**
	 * Define Constants.
	 */
	private function define_constants() {
		global $wpdb;

		$this->define( 'WPSOTP_VERSION', '0.0.1' );
		$this->define( 'WPSOTP_HASH_KEY', 'gkMMnAVkA9' );
		$this->define( 'WPSOTP_DB_OTP_TABLE', $wpdb->prefix . "wpsotp_storage" );
		$this->define( 'WPSOTP_API_VERSION', "1" );
		$this->define( 'WPSOTP_API_NAMESPACE', 'wpsotp/v' . WPSOTP_API_VERSION );
		$this->define( 'WPSOTP_API_BASE', "route" );
		$this->define( 'WPSOTP_PLUGIN_PATH', plugin_dir_path( WPSOTP_PLUGIN_FILE ) );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files.
	 */
	public function includes() {
		include_once WPSOTP_PLUGIN_PATH . 'includes/class-wpsotp-db-generator.php';
		include_once WPSOTP_PLUGIN_PATH . 'includes/class-wpsotp-core.php';
		include_once WPSOTP_PLUGIN_PATH . 'includes/class-wpsotp-rest.php';
	}

}

new WPSOTP();