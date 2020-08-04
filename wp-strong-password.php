<?php
/**
 * Plugin Name: WP strong password
 * Plugin URI:  https://wordpress.org/plugins/wp-strong-password/
 * Description: Plugin force user to use strong password. It works for WP_CLI and WordPress backend.
 * Version:     0.0.3
 * Author:      Abhijit Rakas
 * Author URI:  https://abhijitrakas.dev
 * License:     GPLv2
 * License URI: license.txt
 * Text Domain: wp-strong-pass
 *
 * @package wp-strong-pass
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The url to the plugin directory
 */
define( 'WP_STRONG_PASS_URL', plugin_dir_url( __FILE__ ) );

/**
 * File system path to the plugin directory
 */
define( 'WP_STRONG_PASS_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Function to add js for WordPress backend profile.php page.
 *
 * @param string $hook Name of page.
 *
 * @return void
 */
function wp_strong_pass_add_js( $hook ) {

	if ( 'profile.php' !== $hook ) {
		return;
	}

	$file_name   = 'wp-strong-password.js';
	$js_version  = WP_STRONG_PASS_PATH . '/js/' . $file_name;
	$js_file_url = WP_STRONG_PASS_URL . '/js/' . $file_name;

	wp_enqueue_script( 'wp-strong-password-js', $js_file_url, array( 'password-strength-meter' ), $js_version, true );
}
add_action( 'admin_enqueue_scripts', 'wp_strong_pass_add_js' );

if ( ! class_exists( 'WP_CLI' ) ) {
	return true;
}

/**
 * Require auto loader.
 */
require_once __DIR__ . '/vendor/autoload.php';

use ZxcvbnPhp\Zxcvbn;

/**
 * Function to verify strong password.
 *
 * @return void
 */
function wp_strong_pass_verify() {

	$zxcvbn = new Zxcvbn();

	if ( empty( $_SERVER['argv'] ) ) {
		return;
	}

	$args = wp_unslash( $_SERVER['argv'] ); // phpcs:ignore

	foreach ( $args as $value ) {

		if ( false === stripos( $value, '--user_pass' ) ) {
			continue;
		}

		$split_password_string = explode( '=', $value );

		if ( empty( $split_password_string ) || empty( $split_password_string[1] ) ) {
			continue;
		}

		$strength = $zxcvbn->passwordStrength( $split_password_string[1] );

		if (
			! empty( $strength ) &&
			isset( $strength['score'] ) &&
			! in_array( $strength['score'], [ 4 ], true )
		) {
			WP_CLI::error( 'Weak password strictly prohibited.' );
		}
	}
}
WP_CLI::add_hook( 'before_invoke:user update', 'wp_strong_pass_verify' );
WP_CLI::add_hook( 'before_invoke:user create', 'wp_strong_pass_verify' );
