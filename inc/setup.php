<?php
/**
 * Theme setup.
 *
 * @package CR_Practice
 */

namespace CR_Practice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register core theme features.
 */
function setup(): void {
	load_theme_textdomain( 'cr-practice', get_theme_file_path( '/languages' ) );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'cr-practice' ),
		)
	);
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );
