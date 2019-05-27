<?php
/**
 * Plugin Name: WP Simple OTP
 * Plugin URI: https://wp-otp.github.io
 * Description: WP Plain WordPress OTP Generator
 * Version: 0.0.1
 * Author: Zain Sohail
 *
 * Text Domain: wpsotp
 *
 * @package WPSOTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'WPSOTP_PLUGIN_FILE' ) ) {
    define( 'WPSOTP_PLUGIN_FILE', __FILE__ );
}

// Include the main WPSOTP class.
if ( ! class_exists( 'WPSOTP' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-wpsotp.php';
}
