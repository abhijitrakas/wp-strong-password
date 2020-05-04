<?php
/**
 * Plugin Name: WordPress strong password
 * Plugin URI:  https://wordpress.org/plugins/wp-strong-password/
 * Description: Plugin to force user to use strong password. It works for WP_CLI and WordPress backend.
 * Version:     0.0.1
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

require_once __DIR__ . '/class-wp-restrict-easy-password.php';

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

	foreach( $_SERVER["argv"] as $value ) {
		if ( false !== stripos( $value, '--user_pass' ) ) {
			$split_password_string = explode( '=', $value );

			if ( ! empty( $split_password_string) && ! empty( $split_password_string[1] ) ) {
				$strength = $zxcvbn->passwordStrength( $split_password_string[1] );

				if (
					! empty( $strength ) &&
					! empty( $strength['score'] ) &&
					! in_array( $strength['score'], [4], true )
				) {
					WP_CLI::error( 'Weak password strictly prohibited.' );
				}
			}
		}
	}
}
WP_CLI::add_hook( 'before_invoke:user update', 'wp_strong_pass_verify' );
