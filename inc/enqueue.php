<?php
/**
 * Frontend assets.
 *
 * @package CR_Practice
 */

namespace CR_Practice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue the source CSS without requiring a build process.
 */
function enqueue_assets(): void {
	$stylesheet_path = get_theme_file_path( '/assets/css/theme.css' );
	$theme           = wp_get_theme();
	$version         = file_exists( $stylesheet_path ) ? (string) filemtime( $stylesheet_path ) : $theme->get( 'Version' );

	wp_enqueue_style(
		'cr-practice',
		get_theme_file_uri( '/assets/css/theme.css' ),
		array(),
		$version
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );
