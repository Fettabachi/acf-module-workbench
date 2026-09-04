<?php
/**
 * Greenhouse Job Board API client for the Open Positions block.
 *
 * @package ACF_Module_Workbench
 */

namespace ACF_Module_Workbench\Open_Positions;

use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const API_ORIGIN      = 'https://boards-api.greenhouse.io';
const CACHE_TTL       = 15 * MINUTE_IN_SECONDS;
const STALE_CACHE_TTL = DAY_IN_SECONDS;

/**
 * Retrieve and normalize published jobs from a public Greenhouse board.
 *
 * @param string $board_token Public Greenhouse board token.
 * @return array{jobs: array<int, array{id: int, title: string, url: string, location: string}>, fetched_at: int, is_stale: bool}|WP_Error
 */
function get_jobs( string $board_token ) {
	$board_token = strtolower( trim( $board_token ) );

	if ( 1 !== preg_match( '/^[a-z0-9_-]{1,100}$/', $board_token ) ) {
		return new WP_Error( 'invalid_board_token', __( 'The Greenhouse board token is invalid.', 'acf-module-workbench' ) );
	}

	$cache_suffix = md5( $board_token );
	$fresh_key    = 'amw_open_positions_' . $cache_suffix;
	$stale_key    = 'amw_open_positions_stale_' . $cache_suffix;
	$failure_key  = 'amw_open_positions_failure_' . $cache_suffix;
	$cached       = get_transient( $fresh_key );

	if ( is_array( $cached ) && isset( $cached['jobs'], $cached['fetched_at'] ) ) {
		$cached['is_stale'] = false;
		return $cached;
	}

	if ( get_transient( $failure_key ) ) {
		return get_stale_jobs_or_error( $stale_key, 'request_paused' );
	}

	$url = API_ORIGIN . '/v1/boards/' . rawurlencode( $board_token ) . '/jobs';

	$response = wp_safe_remote_get(
		$url,
		array(
			'timeout'             => 5,
			'redirection'         => 0,
			'limit_response_size' => 512 * KB_IN_BYTES,
			'headers'             => array( 'Accept' => 'application/json' ),
		)
	);

	if ( is_wp_error( $response ) ) {
		return remember_failure( $stale_key, $failure_key, 'request_failed' );
	}

	if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return remember_failure( $stale_key, $failure_key, 'unexpected_response' );
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! is_array( $data ) || ! isset( $data['jobs'] ) || ! is_array( $data['jobs'] ) ) {
		return remember_failure( $stale_key, $failure_key, 'invalid_response' );
	}

	$jobs = array();

	foreach ( $data['jobs'] as $job ) {
		if ( ! is_array( $job ) ) {
			continue;
		}

		$id       = isset( $job['id'] ) ? absint( $job['id'] ) : 0;
		$title    = isset( $job['title'] ) ? trim( wp_strip_all_tags( (string) $job['title'] ) ) : '';
		$url      = isset( $job['absolute_url'] ) ? esc_url_raw( (string) $job['absolute_url'], array( 'https' ) ) : '';
		$location = isset( $job['location']['name'] ) ? trim( wp_strip_all_tags( (string) $job['location']['name'] ) ) : '';

		if ( ! $id || '' === $title || '' === $url ) {
			continue;
		}

		$jobs[] = array(
			'id'         => $id,
			'title'      => $title,
			'url'        => $url,
			'location'   => $location,
		);
	}

	$payload = array(
		'jobs'       => $jobs,
		'fetched_at' => time(),
		'is_stale'   => false,
	);

	set_transient( $fresh_key, $payload, CACHE_TTL );
	set_transient( $stale_key, $payload, STALE_CACHE_TTL );
	delete_transient( $failure_key );

	return $payload;
}

/**
 * Briefly cache a provider failure before falling back to stale data.
 *
 * @param string $stale_key   Transient key for the longer-lived cache.
 * @param string $failure_key Transient key for the failure backoff.
 * @param string $error_code  Stable internal error code.
 * @return array|WP_Error
 */
function remember_failure( string $stale_key, string $failure_key, string $error_code ) {
	set_transient( $failure_key, 1, 5 * MINUTE_IN_SECONDS );

	return get_stale_jobs_or_error( $stale_key, $error_code );
}

/**
 * Use the last validated response during a temporary provider failure.
 *
 * @param string $stale_key Transient key for the longer-lived cache.
 * @param string $error_code Stable internal error code.
 * @return array|WP_Error
 */
function get_stale_jobs_or_error( string $stale_key, string $error_code ) {
	$stale = get_transient( $stale_key );

	if ( is_array( $stale ) && isset( $stale['jobs'], $stale['fetched_at'] ) ) {
		$stale['is_stale'] = true;
		return $stale;
	}

	return new WP_Error( $error_code, __( 'Open positions are temporarily unavailable.', 'acf-module-workbench' ) );
}
