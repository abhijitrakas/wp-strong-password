<?php
/**
 * File to restrict user from setting weak password.
 *
 * @package wp-strong-pass
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
