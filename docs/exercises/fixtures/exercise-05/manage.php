<?php
/**
 * Import or remove the Exercise 05 content fixtures.
 *
 * Run with WP-CLI:
 * wp eval-file manage.php import
 * wp eval-file manage.php verify
 * wp eval-file manage.php cleanup --apply
 *
 * @package CR_Practice
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit( "Run this file through WP-CLI.\n" );
}

$fixture_key   = '_cr_practice_exercise_fixture';
$fixture_value = '05-curated-content-grid';
$term_key      = '_cr_practice_exercise_fixture';
$action        = isset( $args[0] ) ? (string) $args[0] : '';
$apply_cleanup = in_array( '--apply', $args, true );

/**
 * Return a fixture category ID, creating the category when necessary.
 *
 * @param string $name Category name.
 * @param string $slug Category slug.
 * @param string $term_key Fixture term-meta key.
 * @param string $fixture_key Fixture post-meta key.
 * @param string $fixture_value Fixture marker value.
 * @return int
 */
function cr_practice_exercise_05_category_id( string $name, string $slug, string $term_key, string $fixture_key, string $fixture_value ): int {
	$term = get_term_by( 'slug', $slug, 'category' );

	if ( $term instanceof WP_Term ) {
		if ( $fixture_value !== get_term_meta( $term->term_id, $term_key, true ) ) {
			$assigned_post_ids = get_objects_in_term( $term->term_id, 'category' );
			$fixture_post_ids  = array_filter(
				$assigned_post_ids,
				static function ( int $post_id ) use ( $fixture_key, $fixture_value ): bool {
					return $fixture_value === get_post_meta( $post_id, $fixture_key, true );
				}
			);

			if ( empty( $assigned_post_ids ) || count( $assigned_post_ids ) !== count( $fixture_post_ids ) ) {
				WP_CLI::error( sprintf( 'Refusing to reuse unrelated category with slug "%s".', $slug ) );
			}

			update_term_meta( $term->term_id, $term_key, $fixture_value );
			WP_CLI::log( sprintf( 'Recovered fixture marker for category %s.', $slug ) );
		}

		return (int) $term->term_id;
	}

	$created = wp_insert_term(
		$name,
		'category',
		array(
			'slug' => $slug,
		)
	);

	if ( is_wp_error( $created ) ) {
		WP_CLI::error( $created->get_error_message() );
	}

	update_term_meta( (int) $created['term_id'], $term_key, $fixture_value );

	return (int) $created['term_id'];
}

/**
 * Find an existing local attachment by its post slug.
 *
 * @param string $slug Attachment post slug.
 * @return int
 */
function cr_practice_exercise_05_attachment_id( string $slug ): int {
	$attachment = get_page_by_path( $slug, OBJECT, 'attachment' );

	return $attachment instanceof WP_Post ? (int) $attachment->ID : 0;
}

if ( 'import' === $action ) {
	$author_ids = get_users(
		array(
			'fields'  => 'ids',
			'number'  => 1,
			'orderby' => 'ID',
			'order'   => 'ASC',
		)
	);
	$author_id  = isset( $author_ids[0] ) ? (int) $author_ids[0] : 0;

	if ( 0 === $author_id ) {
		WP_CLI::error( 'Exercise 05 fixtures require at least one WordPress user.' );
	}

	$category_ids = array(
		'strategy'   => cr_practice_exercise_05_category_id( 'Strategy', 'exercise-05-strategy', $term_key, $fixture_key, $fixture_value ),
		'design'     => cr_practice_exercise_05_category_id( 'Design', 'exercise-05-design', $term_key, $fixture_key, $fixture_value ),
		'technology' => cr_practice_exercise_05_category_id( 'Technology', 'exercise-05-technology', $term_key, $fixture_key, $fixture_value ),
	);

	$image_ids = array(
		'discover' => cr_practice_exercise_05_attachment_id( 'discover-customer-journey-workshop' ),
		'define'   => cr_practice_exercise_05_attachment_id( 'define-wireframe-sketching' ),
		'build'    => cr_practice_exercise_05_attachment_id( 'build-development-in-progress' ),
	);

	$posts = array(
		array(
			'slug'       => 'exercise-05-audience-research',
			'title'      => 'Turning Audience Research Into a Clear Digital Roadmap',
			'excerpt'    => 'A practical framework for translating interviews, analytics, and stakeholder input into focused priorities.',
			'content'    => '<!-- wp:paragraph --><p>Useful research does more than collect observations. It creates a shared language for deciding what matters, what can wait, and how success will be measured.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Start by grouping evidence around audience needs, organizational goals, and delivery constraints. The strongest opportunities appear where all three overlap.</p><!-- /wp:paragraph -->',
			'categories' => array( 'strategy' ),
			'image'      => 'discover',
			'date'       => '2026-08-20 09:00:00',
		),
		array(
			'slug'       => 'exercise-05-content-governance',
			'title'      => 'Content Governance That Survives the Launch',
			'excerpt'    => 'Simple ownership and review practices that keep an ambitious website accurate after launch day.',
			'content'    => '<!-- wp:paragraph --><p>A content model is only sustainable when ownership is visible. Every important page needs a responsible team, a review rhythm, and a clear reason to exist.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Governance works best when it is lightweight enough to follow and specific enough to resolve competing requests.</p><!-- /wp:paragraph -->',
			'categories' => array( 'strategy' ),
			'image'      => '',
			'date'       => '2026-08-16 11:30:00',
		),
		array(
			'slug'       => 'exercise-05-design-systems',
			'title'      => 'A Small Design System Can Still Create a Consistent Experience',
			'excerpt'    => 'How a focused set of semantic decisions can improve quality without slowing down everyday publishing.',
			'content'    => '<!-- wp:paragraph --><p>A useful design system begins with repeated decisions: type roles, spacing, surfaces, controls, and interaction states. Naming those decisions makes them easier to apply and review.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The goal is not to catalog every possible variation. It is to make the common path clear and dependable.</p><!-- /wp:paragraph -->',
			'categories' => array( 'design' ),
			'image'      => 'define',
			'date'       => '2026-08-12 14:15:00',
		),
		array(
			'slug'       => 'exercise-05-accessible-navigation',
			'title'      => 'Designing Navigation That Works for More People',
			'excerpt'    => 'Navigation improves when structure, language, focus order, and responsive behavior are considered together.',
			'content'    => '<!-- wp:paragraph --><p>Accessible navigation is not a final compliance pass. It starts with recognizable labels, semantic landmarks, predictable keyboard behavior, and a structure that remains understandable at every viewport.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Testing with real content exposes ambiguity that polished placeholder labels often hide.</p><!-- /wp:paragraph -->',
			'categories' => array( 'design', 'technology' ),
			'image'      => 'discover',
			'date'       => '2026-08-08 10:45:00',
		),
		array(
			'slug'       => 'exercise-05-performance-budgets',
			'title'      => 'Performance Budgets Make Speed a Shared Product Decision',
			'excerpt'    => 'Treating page weight and interaction speed as explicit constraints helps teams make better tradeoffs earlier.',
			'content'    => '<!-- wp:paragraph --><p>A performance budget turns speed from an abstract aspiration into a constraint the whole team can discuss. It should cover the assets and interactions most likely to affect visitors.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Budgets are most effective when they appear in design and content reviews, not only in a report at the end of development.</p><!-- /wp:paragraph -->',
			'categories' => array( 'technology' ),
			'image'      => 'build',
			'date'       => '2026-08-04 08:30:00',
		),
		array(
			'slug'       => 'exercise-05-editor-workflows',
			'title'      => 'Building Better Editorial Workflows With Purposeful WordPress Controls',
			'excerpt'    => 'Editor interfaces become easier to trust when every field has a clear effect and sensible boundary.',
			'content'    => '<!-- wp:paragraph --><p>Editors should not need to understand implementation details to create a reliable page. Purposeful controls, useful defaults, and defensive rendering reduce uncertainty on both sides of the publishing workflow.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The best field model expresses real content decisions without exposing presentation knobs that belong to the design system.</p><!-- /wp:paragraph -->',
			'categories' => array( 'design', 'technology' ),
			'image'      => '',
			'date'       => '2026-07-30 13:00:00',
		),
		array(
			'slug'       => 'exercise-05-progressive-enhancement',
			'title'      => 'Progressive Enhancement Starts by Making the Unenhanced Experience Complete',
			'excerpt'    => '',
			'content'    => '<!-- wp:paragraph --><p>Progressive enhancement is easiest when the initial document already communicates the complete message. JavaScript can then improve efficiency or presentation without becoming the only route to the content.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>This approach also creates a clearer failure mode: when enhancement is unavailable, visitors still receive a coherent experience.</p><!-- /wp:paragraph -->',
			'categories' => array( 'technology' ),
			'image'      => 'build',
			'date'       => '2026-07-24 15:20:00',
		),
		array(
			'slug'       => 'exercise-05-cross-functional-discovery',
			'title'      => 'What Cross-Functional Discovery Reveals Before a Team Commits to Features, Platforms, Timelines, and a Detailed Delivery Plan',
			'excerpt'    => 'Early collaboration exposes assumptions and dependencies while the team still has room to respond constructively.',
			'content'    => '<!-- wp:paragraph --><p>Discovery becomes more valuable when strategy, design, content, and technology contribute at the same time. Each discipline sees different risks, and the overlap often changes the shape of the proposed solution.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>The outcome should be a smaller set of better-supported decisions rather than a larger pile of documentation.</p><!-- /wp:paragraph -->',
			'categories' => array( 'strategy', 'design', 'technology' ),
			'image'      => 'define',
			'date'       => '2026-07-18 09:40:00',
		),
	);

	$created_count = 0;
	$updated_count = 0;

	foreach ( $posts as $fixture_post ) {
		$existing = get_page_by_path( $fixture_post['slug'], OBJECT, 'post' );

		if ( $existing instanceof WP_Post && $fixture_value !== get_post_meta( $existing->ID, $fixture_key, true ) ) {
			WP_CLI::error( sprintf( 'Refusing to overwrite unrelated post with slug "%s".', $fixture_post['slug'] ) );
		}

		$post_data = array(
			'ID'           => $existing instanceof WP_Post ? (int) $existing->ID : 0,
			'post_author'  => $author_id,
			'post_content' => wp_slash( $fixture_post['content'] ),
			'post_date'    => $fixture_post['date'],
			'post_excerpt' => $fixture_post['excerpt'],
			'post_name'    => $fixture_post['slug'],
			'post_status'  => 'publish',
			'post_title'   => $fixture_post['title'],
			'post_type'    => 'post',
		);

		$post_id = $existing instanceof WP_Post
			? wp_update_post( $post_data, true )
			: wp_insert_post( $post_data, true );

		if ( is_wp_error( $post_id ) ) {
			WP_CLI::error( $post_id->get_error_message() );
		}

		$term_ids = array_map(
			static function ( string $category ) use ( $category_ids ): int {
				return $category_ids[ $category ];
			},
			$fixture_post['categories']
		);

		wp_set_post_categories( $post_id, $term_ids, false );
		update_post_meta( $post_id, $fixture_key, $fixture_value );

		$image_id = '' !== $fixture_post['image'] ? $image_ids[ $fixture_post['image'] ] : 0;

		if ( $image_id > 0 ) {
			set_post_thumbnail( $post_id, $image_id );
		} else {
			delete_post_thumbnail( $post_id );
		}

		if ( $existing instanceof WP_Post ) {
			++$updated_count;
		} else {
			++$created_count;
		}

		WP_CLI::log( sprintf( '%s post %d: %s', $existing instanceof WP_Post ? 'Updated' : 'Created', $post_id, $fixture_post['title'] ) );
	}

	$missing_images = array_filter(
		$image_ids,
		static function ( int $image_id ): bool {
			return 0 === $image_id;
		}
	);

	if ( ! empty( $missing_images ) ) {
		WP_CLI::warning( 'Some optional Exercise 04 media could not be found; those fixture posts were imported without featured images.' );
	}

	WP_CLI::success( sprintf( 'Exercise 05 fixtures imported: %d created, %d updated.', $created_count, $updated_count ) );
	return;
}

if ( 'cleanup' === $action ) {
	if ( ! $apply_cleanup ) {
		WP_CLI::error( 'Cleanup is destructive. Run again with: cleanup --apply' );
	}

	$post_ids = get_posts(
		array(
			'fields'           => 'ids',
			'meta_key'         => $fixture_key,
			'meta_value'       => $fixture_value,
			'no_found_rows'    => true,
			'post_status'      => 'any',
			'post_type'        => 'post',
			'posts_per_page'   => -1,
			'suppress_filters' => true,
		)
	);

	foreach ( $post_ids as $post_id ) {
		wp_delete_post( (int) $post_id, true );
		WP_CLI::log( sprintf( 'Deleted fixture post %d.', $post_id ) );
	}

	foreach ( array( 'exercise-05-strategy', 'exercise-05-design', 'exercise-05-technology' ) as $term_slug ) {
		$term = get_term_by( 'slug', $term_slug, 'category' );

		if ( $term instanceof WP_Term && $fixture_value === get_term_meta( $term->term_id, $term_key, true ) ) {
			wp_delete_term( $term->term_id, 'category' );
			WP_CLI::log( sprintf( 'Deleted fixture category %s.', $term_slug ) );
		}
	}

	WP_CLI::success( sprintf( 'Exercise 05 cleanup removed %d fixture posts.', count( $post_ids ) ) );
	return;
}

if ( 'verify' === $action ) {
	$fixture_posts = get_posts(
		array(
			'meta_key'         => $fixture_key,
			'meta_value'       => $fixture_value,
			'no_found_rows'    => true,
			'post_status'      => 'any',
			'post_type'        => 'post',
			'posts_per_page'   => -1,
			'suppress_filters' => true,
		)
	);

	$published_count = 0;
	$image_count     = 0;
	$excerpt_count   = 0;
	$long_title_count = 0;

	foreach ( $fixture_posts as $fixture_post ) {
		$published_count += 'publish' === $fixture_post->post_status ? 1 : 0;
		$image_count     += has_post_thumbnail( $fixture_post ) ? 1 : 0;
		$excerpt_count   += '' !== trim( $fixture_post->post_excerpt ) ? 1 : 0;
		$long_title_count += strlen( $fixture_post->post_title ) > 100 ? 1 : 0;
	}

	$fixture_terms = get_terms(
		array(
			'hide_empty' => false,
			'meta_key'   => $term_key,
			'meta_value' => $fixture_value,
			'taxonomy'   => 'category',
		)
	);

	if ( is_wp_error( $fixture_terms ) ) {
		WP_CLI::error( $fixture_terms->get_error_message() );
	}

	$checks = array(
		'fixture posts'       => array( count( $fixture_posts ), 8 ),
		'published posts'     => array( $published_count, 8 ),
		'featured images'     => array( $image_count, 6 ),
		'authored excerpts'   => array( $excerpt_count, 7 ),
		'long-title cases'    => array( $long_title_count, 1 ),
		'fixture categories'  => array( count( $fixture_terms ), 3 ),
	);

	foreach ( $checks as $label => $values ) {
		WP_CLI::log( sprintf( '%s: %d (expected %d)', ucfirst( $label ), $values[0], $values[1] ) );

		if ( $values[0] !== $values[1] ) {
			WP_CLI::error( sprintf( 'Exercise 05 fixture verification failed for %s.', $label ) );
		}
	}

	WP_CLI::success( 'Exercise 05 fixture verification passed.' );
	return;
}

WP_CLI::error( 'Choose an action: import, verify, or cleanup --apply' );
