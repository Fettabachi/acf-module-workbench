<?php
/**
 * ACF block registration.
 *
 * @package CR_Practice
 */

namespace CR_Practice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the theme's ACF blocks from their metadata.
 */
function register_acf_blocks(): void {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	register_block_type( get_theme_file_path( '/parts/modules/content-media' ) );
	register_block_type( get_theme_file_path( '/parts/modules/feature-cards' ) );
	register_block_type( get_theme_file_path( '/parts/modules/accordion' ) );
}
add_action( 'init', __NAMESPACE__ . '\\register_acf_blocks' );
