<?php
/**
 * Public component workbench metadata and page discovery.
 *
 * @package ACF_Module_Workbench
 */

namespace ACF_Module_Workbench;

use WP_Post;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const WORKBENCH_REPOSITORY_URL = 'https://github.com/Fettabachi/acf-module-workbench';

/**
 * Get the public metadata for each component in display order.
 *
 * @return array<string, array<string, mixed>>
 */
function get_workbench_components(): array {
	return array(
		'acf/content-media' => array(
			'title'           => __( 'Content Media', 'acf-module-workbench' ),
			'summary'         => __( 'Pairs focused editorial copy with responsive, accessible imagery.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this flexible split-layout component when a story needs supporting imagery without tying the content to a specific page or campaign.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Heading, body copy, image, and image position.', 'acf-module-workbench' ),
				__( 'Optional eyebrow and call to action.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Semantic content order remains logical when the visual media position changes.', 'acf-module-workbench' ),
				__( 'Optional fields disappear cleanly without leaving empty wrappers.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/content-media',
			'docs_path'       => 'docs/components/content-media.md',
		),
		'acf/feature-cards' => array(
			'title'           => __( 'Feature Cards', 'acf-module-workbench' ),
			'summary'         => __( 'Organizes a concise set of benefits or capabilities into responsive cards.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component to make several related capabilities easy to scan while retaining a clear section introduction and reading order.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy and a repeatable set of feature cards.', 'acf-module-workbench' ),
				__( 'Purposeful card content without arbitrary visual controls.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'The card grid adapts from one column to wider multi-column layouts.', 'acf-module-workbench' ),
				__( 'Module-scoped styles protect the component when it moves between themes.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/feature-cards',
			'docs_path'       => 'docs/components/feature-cards.md',
		),
		'acf/accordion' => array(
			'title'           => __( 'Accessible Accordion', 'acf-module-workbench' ),
			'summary'         => __( 'Reveals structured supporting content with keyboard-friendly controls.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use the accordion when visitors benefit from scanning a short set of questions or topics before choosing which details to read.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section introduction and repeatable question-and-answer items.', 'acf-module-workbench' ),
				__( 'A concise collapsed-row label keeps longer sets manageable.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Native buttons expose expanded state and associated panel relationships.', 'acf-module-workbench' ),
				__( 'Content remains available without JavaScript and motion respects user preferences.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/accordion',
			'docs_path'       => 'docs/components/accessible-accordion.md',
		),
		'acf/tabbed-content' => array(
			'title'           => __( 'Tabbed Content', 'acf-module-workbench' ),
			'summary'         => __( 'Switches between related content panels while preserving accessible navigation.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use tabs for a small group of parallel topics when visitors are likely to compare or move between them in place.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy and repeatable tab labels with panel content.', 'acf-module-workbench' ),
				__( 'An expanded editor gives each tab item and its rich content room outside the constrained Gutenberg sidebar.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Keyboard behavior follows the expected tab and arrow-key interaction model.', 'acf-module-workbench' ),
				__( 'The unenhanced page retains readable content instead of depending on JavaScript.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/tabbed-content',
			'docs_path'       => 'docs/components/tabbed-content.md',
		),
		'acf/curated-content-grid' => array(
			'title'           => __( 'Curated Content Grid', 'acf-module-workbench' ),
			'summary'         => __( 'Gives editors direct control over a selected and ordered collection of posts.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this grid when editorial judgment—not recency or taxonomy alone—should determine which stories appear and in what order.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy and an ordered relationship field for published posts.', 'acf-module-workbench' ),
				__( 'The selected post remains the source of truth for its title, image, excerpt, date, and categories.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Unavailable or duplicate posts are discarded before rendering.', 'acf-module-workbench' ),
				__( 'Cards handle missing images and excerpts without breaking their layout.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/curated-content-grid',
			'docs_path'       => 'docs/components/curated-content-grid.md',
		),
		'acf/filtered-content-grid' => array(
			'title'           => __( 'Filtered Content Grid', 'acf-module-workbench' ),
			'summary'         => __( 'Lets visitors narrow a responsive post collection by category.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component for a larger content collection where lightweight, in-page category filtering makes exploration faster.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy, result limits, and the categories available to the collection.', 'acf-module-workbench' ),
				__( 'Published WordPress posts supply the card content.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'All results remain visible when JavaScript is unavailable.', 'acf-module-workbench' ),
				__( 'Enhanced controls communicate their selected state and result changes.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/filtered-content-grid',
			'docs_path'       => 'docs/components/filtered-content-grid.md',
		),
		'acf/campaign-hero' => array(
			'title'           => __( 'Campaign Hero', 'acf-module-workbench' ),
			'summary'         => __( 'Combines campaign messaging, proof points, and art-directed responsive media.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this expressive hero for a focused campaign that needs a strong opening message, clear action, and responsive supporting artwork.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Campaign copy, call to action, proof points, and an optional desktop image.', 'acf-module-workbench' ),
				__( 'An expanded editor keeps the tabbed field groups readable without crowding the Gutenberg sidebar.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Local art-directed assets provide dependable desktop and mobile compositions.', 'acf-module-workbench' ),
				__( 'The component requires no JavaScript and preserves meaningful content order.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/campaign-hero',
			'docs_path'       => 'docs/components/campaign-hero.md',
		),
		'acf/inline-media' => array(
			'title'           => __( 'Inline Media', 'acf-module-workbench' ),
			'summary'         => __( 'Pairs editorial context with an accessible, user-initiated video experience.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component when video supports a story but should not autoplay, overwhelm the page, or exclude visitors who need captions or a transcript.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Context copy, video, poster, captions, transcript, and media position.', 'acf-module-workbench' ),
				__( 'Media Library metadata supplies the accessible file information.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Native video controls remain available before enhancement.', 'acf-module-workbench' ),
				__( 'The optional transcript and poster-led play treatment remain keyboard accessible.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/inline-media',
			'docs_path'       => 'docs/components/inline-media.md',
		),
		'acf/pricing-tables' => array(
			'title'           => __( 'Pricing Tables', 'acf-module-workbench' ),
			'summary'         => __( 'Compares product plans with responsive cards and progressive billing controls.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component to make plan differences, recurring prices, and recommended options understandable without hiding the default offer.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy, billing labels, plan pricing, features, emphasis, and links.', 'acf-module-workbench' ),
				__( 'An expanded editor gives complex plan data enough space to remain usable.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Default prices remain readable without JavaScript.', 'acf-module-workbench' ),
				__( 'Native radios and pressed-state plan controls expose selection to keyboard and assistive-technology users.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/pricing-tables',
			'docs_path'       => 'docs/components/pricing-tables.md',
		),
		'acf/open-positions' => array(
			'title'           => __( 'Open Positions', 'acf-module-workbench' ),
			'summary'         => __( 'Keeps a branded careers page synchronized with a public Greenhouse job board.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component when a recruiting team manages openings in Greenhouse but the website needs current jobs presented in its own design system.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy, a live public Greenhouse board token, result limit, link label, and empty state.', 'acf-module-workbench' ),
				__( 'Full-width fields keep the integration settings readable in Gutenberg.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Server-side requests validate and cache a deliberately small provider response.', 'acf-module-workbench' ),
				__( 'Validated stale data and failure backoff protect the page during temporary outages.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/open-positions',
			'docs_path'       => 'docs/components/open-positions.md',
		),
	);
}

/**
 * Collect registered workbench block names, including nested blocks.
 *
 * @param array<int, array<string, mixed>> $blocks Parsed blocks.
 * @return array<int, string>
 */
function get_workbench_block_names( array $blocks ): array {
	$names = array();

	foreach ( $blocks as $block ) {
		if ( ! empty( $block['blockName'] ) && is_string( $block['blockName'] ) ) {
			$names[] = $block['blockName'];
		}

		if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
			$names = array_merge( $names, get_workbench_block_names( $block['innerBlocks'] ) );
		}
	}

	return array_values( array_unique( $names ) );
}

/**
 * Find the first workbench component demonstrated by a page.
 *
 * @param WP_Post|int|null $post Page object or ID.
 * @return array<string, mixed>|null
 */
function get_workbench_component_for_post( $post = null ): ?array {
	$post = get_post( $post );

	if ( ! $post instanceof WP_Post ) {
		return null;
	}

	$components = get_workbench_components();
	$block_names = get_workbench_block_names( parse_blocks( $post->post_content ) );

	foreach ( array_keys( $components ) as $block_name ) {
		if ( in_array( $block_name, $block_names, true ) ) {
			return array_merge(
				$components[ $block_name ],
				array(
					'block_name' => $block_name,
					'page'       => $post,
				)
			);
		}
	}

	return null;
}

/**
 * Match published pages to component metadata in the intended display order.
 *
 * @return array<int, array<string, mixed>>
 */
function get_workbench_component_pages(): array {
	$components = get_workbench_components();
	$matches    = array();
	$front_id   = (int) get_option( 'page_on_front' );
	$query      = new WP_Query(
		array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'orderby'                => 'ID',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	foreach ( $query->posts as $page ) {
		if ( ! $page instanceof WP_Post || $front_id === (int) $page->ID ) {
			continue;
		}

		$block_names = get_workbench_block_names( parse_blocks( $page->post_content ) );

		foreach ( array_keys( $components ) as $block_name ) {
			if ( isset( $matches[ $block_name ] ) || ! in_array( $block_name, $block_names, true ) ) {
				continue;
			}

			$matches[ $block_name ] = array_merge(
				$components[ $block_name ],
				array(
					'block_name' => $block_name,
					'page'       => $page,
				)
			);
		}
	}

	$ordered = array();

	foreach ( array_keys( $components ) as $block_name ) {
		if ( isset( $matches[ $block_name ] ) ) {
			$ordered[] = $matches[ $block_name ];
		}
	}

	return $ordered;
}

/**
 * Build a public GitHub URL for a repository path.
 *
 * @param string $path Repository-relative path.
 * @param bool   $directory Whether the path represents a directory.
 * @return string
 */
function get_workbench_repository_url( string $path, bool $directory = false ): string {
	$route = $directory ? 'tree' : 'blob';
	$path  = implode( '/', array_map( 'rawurlencode', explode( '/', ltrim( $path, '/' ) ) ) );

	return WORKBENCH_REPOSITORY_URL . '/' . $route . '/main/' . $path;
}
