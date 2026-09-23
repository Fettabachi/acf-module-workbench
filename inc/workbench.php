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
		'acf/meet-the-team' => array(
			'title'           => __( 'Meet the Team', 'acf-module-workbench' ),
			'summary'         => __( 'Introduces a curated group of people with consistent portraits and optional department filtering.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component for a focused team directory where editors control the people, order, department labels, profile links, and recruitment call to action.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy, heading hierarchy, optional careers link, and visitor filter labels.', 'acf-module-workbench' ),
				__( 'An ordered set of portraits, names, roles, departments, short biographies, and optional profile links.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'A native select progressively filters the authored collection with animated card rearrangement while the complete directory remains available without JavaScript.', 'acf-module-workbench' ),
				__( 'Portraits and underlined member names open scrollable biography panels that slide from the top, manage focus, respect reduced-motion preferences, and retain inline content without JavaScript.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/meet-the-team',
			'docs_path'       => 'docs/components/meet-the-team.md',
		),
		'acf/testimonials' => array(
			'title'           => __( 'Testimonials', 'acf-module-workbench' ),
			'summary'         => __( 'Combines compact customer quotes with editor-positioned featured stories.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component for a curated set of attributed customer perspectives where editors need to control both row order and visual emphasis.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section copy, heading hierarchy, and an ordered flexible collection of testimonial rows.', 'acf-module-workbench' ),
				__( 'Standard rows contain one to three testimonials; featured rows contain one larger testimonial and may appear anywhere.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Authored row order remains the visual and semantic reading order at every width.', 'acf-module-workbench' ),
				__( 'Portraits preserve Media Library alternatives, while missing portraits receive derived initials.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/testimonials',
			'docs_path'       => 'docs/components/testimonials.md',
		),
		'acf/cta-banner' => array(
			'title'           => __( 'CTA Banner', 'acf-module-workbench' ),
			'summary'         => __( 'Combines a focused closing message, paired actions, reassurance, and an optional customer perspective.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component near the end of a page when visitors need a persuasive next step supported by a concise expectation and credible voice.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'A tabbed expanded editor contains controlled heading emphasis, heading hierarchy, paired links, and reassurance copy.', 'acf-module-workbench' ),
				__( 'An optional complete testimonial adds a quote, attribution name, and role.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Exact local Figma exports provide the decorative linework and support icon over a responsive dark composition.', 'acf-module-workbench' ),
				__( 'Incomplete links and testimonials disappear without leaving unusable controls or wrappers.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/cta-banner',
			'docs_path'       => 'docs/components/cta-banner.md',
		),
		'acf/timeline-milestones' => array(
			'title'           => __( 'Timeline / Milestones', 'acf-module-workbench' ),
			'summary'         => __( 'Organizes dated milestones and categorized notes along a responsive chronological path.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component for a changelog, company history, roadmap, project sequence, or other ordered story that needs more context than a simple list.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section introduction, heading hierarchy, and an ordered collection of dated or period-based entries with optional badge icons.', 'acf-module-workbench' ),
				__( 'Nested content groups pair semantic tones with optional summaries and repeatable notes using constrained icon choices.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Desktop entries alternate around a central spine while mobile keeps every entry in one consistent reading order.', 'acf-module-workbench' ),
				__( 'The timeline grows with authored content, exact dates use native time semantics, and incomplete content disappears cleanly.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/timeline-milestones',
			'docs_path'       => 'docs/components/timeline-milestones.md',
		),
		'acf/before-after-comparison' => array(
			'title'           => __( 'Before / After Comparison', 'acf-module-workbench' ),
			'summary'         => __( 'Reveals the visual difference between two related images with one accessible control.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component for redesigns, renovations, restoration, retouching, or other evidence where visitors benefit from directly comparing two image states.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Optional section context, two labelled Media Library images, a shared crop, caption, and initial reveal position.', 'acf-module-workbench' ),
				__( 'Media Library metadata remains the source of image alternative text.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'A native range input supplies keyboard, touch, and pointer interaction while exposing the current reveal percentage.', 'acf-module-workbench' ),
				__( 'Without JavaScript, both complete labelled images remain available in a responsive comparison layout.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/before-after-comparison',
			'docs_path'       => 'docs/components/before-after-comparison.md',
		),
		'acf/sticky-feature-showcase' => array(
			'title'           => __( 'Sticky Feature Showcase', 'acf-module-workbench' ),
			'summary'         => __( 'Pairs a persistent visual stage with an ordered, scroll-led feature story.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component to explain a process, product, service, or transformation whose related visuals benefit from staying in view as visitors move through the story.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section introduction and an ordered collection of labelled steps with copy, imagery, and optional links.', 'acf-module-workbench' ),
				__( 'An expanded editor keeps substantial repeated content readable and easy to reorder.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Desktop progressively enhances into a sticky visual stage while the authored document order remains unchanged.', 'acf-module-workbench' ),
				__( 'Mobile, narrow editor, reduced-motion, and no-script experiences retain each image beside its corresponding content.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/sticky-feature-showcase',
			'docs_path'       => 'docs/components/sticky-feature-showcase.md',
		),
		'acf/case-study-spotlight' => array(
			'title'           => __( 'Case Study Spotlight', 'acf-module-workbench' ),
			'summary'         => __( 'Connects a client challenge and focused approach with measurable outcomes and supporting proof.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component to turn completed work into a concise results story that helps prospective customers understand the problem, intervention, and credible change.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section introduction, client identity, challenge, approach, optional imagery, and two to four measurable outcomes.', 'acf-module-workbench' ),
				__( 'Optional attributed testimonial and complete link to the full case study.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'A labelled section connects narrative context with semantic definition-list metrics and an optional figure-based testimonial.', 'acf-module-workbench' ),
				__( 'Incomplete outcomes, proof, links, and media disappear cleanly while the authored story keeps a logical reading order.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/case-study-spotlight',
			'docs_path'       => 'docs/components/case-study-spotlight.md',
		),
		'acf/project-gallery' => array(
			'title'           => __( 'Project Gallery', 'acf-module-workbench' ),
			'summary'         => __( 'Guides visitors through a compact image carousel with captions, thumbnails, expanded viewing, and an optional next step.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component to help visitors inspect project, product, place, or event imagery without losing the context and accessibility provided by the page.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section introduction, heading hierarchy, three to twelve ordered Media Library images, and a consistent thumbnail shape.', 'acf-module-workbench' ),
				__( 'Attachment captions and alternative text remain managed in the Media Library, with an optional closing link.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'A prominent active image, persistent controls, position status, and thumbnail rail make the gallery discoverable on touch, pointer, and keyboard devices.', 'acf-module-workbench' ),
				__( 'The carousel, swipe handling, and native dialog progressively enhance a complete direct-link gallery fallback.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/project-gallery',
			'docs_path'       => 'docs/components/project-gallery.md',
		),
		'acf/impact-metrics' => array(
			'title'           => __( 'Impact Metrics', 'acf-module-workbench' ),
			'summary'         => __( 'Turns measurable outcomes into a concise, contextualized proof section.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component when visitors need credible evidence of organizational, campaign, program, or service performance without the narrative weight of a full case study.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section introduction, heading hierarchy, and two to six ordered metrics with values, labels, and optional measurement context.', 'acf-module-workbench' ),
				__( 'Optional source citations, a shared methodology note, and a complete closing link help editors substantiate the results.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'A semantic definition list preserves the relationship between each value and its meaning without relying on visual position.', 'acf-module-workbench' ),
				__( 'Balanced one-, two-, and three-column layouts accommodate every allowed metric count without exposed empty cells.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/impact-metrics',
			'docs_path'       => 'docs/components/impact-metrics.md',
		),
		'acf/proof-logos' => array(
			'title'           => __( 'Proof Logos', 'acf-module-workbench' ),
			'summary'         => __( 'Balances mixed client, partner, press, sponsor, or integration logos in a flexible proof grid.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component when proof by association helps visitors recognize who trusts, funds, features, or integrates with an organization.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section introduction, heading hierarchy, default treatment, layout density, and two to twelve ordered logos.', 'acf-module-workbench' ),
				__( 'Each logo can include an organization name, optional link, visual scale, and treatment override for mismatched source assets.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Consistent logo slots, per-logo optical scaling, and treatment controls keep varied files visually balanced.', 'acf-module-workbench' ),
				__( 'Raster and SVG image attachments render defensively, while incomplete logos and links disappear cleanly.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/proof-logos',
			'docs_path'       => 'docs/components/proof-logos.md',
		),
		'acf/solutions-comparison' => array(
			'title'           => __( 'Solutions Comparison', 'acf-module-workbench' ),
			'summary'         => __( 'Helps B2B buyers compare solutions against a shared set of decision criteria.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component when related services, packages, or products need clearer differentiation than a pricing card can provide.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section context and two to four named solutions with fit guidance, recommendation emphasis, and optional links.', 'acf-module-workbench' ),
				__( 'An ordered set of criteria contains one structured status or text value for each solution.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'A semantic table preserves the relationship between every criterion and solution for visual and assistive-technology users.', 'acf-module-workbench' ),
				__( 'Narrow screens retain the complete comparison in a labelled, keyboard-focusable horizontal region.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/solutions-comparison',
			'docs_path'       => 'docs/components/solutions-comparison.md',
		),
		'acf/why-choose-us' => array(
			'title'           => __( 'Why Choose Us', 'acf-module-workbench' ),
			'summary'         => __( 'Pairs distinctive strengths with concrete supporting evidence.', 'acf-module-workbench' ),
			'purpose'         => __( 'Use this component when an organization needs to explain why its approach merits trust beyond a list of services or features.', 'acf-module-workbench' ),
			'editor_controls' => array(
				__( 'Section heading, introduction, and two to six ordered reasons.', 'acf-module-workbench' ),
				__( 'Each reason includes customer benefit and optional evidence with a source; one closing link is optional.', 'acf-module-workbench' ),
			),
			'implementation'  => array(
				__( 'Editorial rows keep differentiating claims separate from optional proof instead of recreating service cards.', 'acf-module-workbench' ),
				__( 'Incomplete reasons, unsupported source links, and empty optional content disappear cleanly.', 'acf-module-workbench' ),
			),
			'source_path'     => 'parts/modules/why-choose-us',
			'docs_path'       => 'docs/components/why-choose-us.md',
		),
	);
}

/**
 * Get the display categories used to filter the public component directory.
 *
 * @return array<string, string>
 */
function get_workbench_component_categories(): array {
	return array(
		'hero-conversion'    => __( 'Conversion', 'acf-module-workbench' ),
		'content-media'      => __( 'Content & Media', 'acf-module-workbench' ),
		'interactive-layout' => __( 'Interactive Layout', 'acf-module-workbench' ),
		'collections-grids'  => __( 'Collections & Grids', 'acf-module-workbench' ),
		'social-proof'       => __( 'Social Proof', 'acf-module-workbench' ),
		'people-careers'     => __( 'People & Careers', 'acf-module-workbench' ),
		'storytelling'       => __( 'Storytelling', 'acf-module-workbench' ),
	);
}

/**
 * Get card metadata for the public component directory.
 *
 * @return array<string, array{category:string,tags:array<int,string>,thumbnail:string,meta:array<int,string>}>
 */
function get_workbench_component_card_metadata(): array {
	return array(
		'acf/content-media' => array(
			'category'  => 'content-media',
			'tags'      => array( 'content-media' ),
			'thumbnail' => 'split-media',
			'meta'      => array( 'text', 'media', 'link' ),
		),
		'acf/feature-cards' => array(
			'category'  => 'collections-grids',
			'tags'      => array( 'collections-grids', 'content-media' ),
			'thumbnail' => 'cards',
			'meta'      => array( 'repeater', 'cards' ),
		),
		'acf/accordion' => array(
			'category'  => 'interactive-layout',
			'tags'      => array( 'interactive-layout', 'content-media' ),
			'thumbnail' => 'accordion',
			'meta'      => array( 'repeater', 'no JS' ),
		),
		'acf/tabbed-content' => array(
			'category'  => 'interactive-layout',
			'tags'      => array( 'interactive-layout', 'content-media' ),
			'thumbnail' => 'tabs',
			'meta'      => array( 'repeater', 'JS' ),
		),
		'acf/curated-content-grid' => array(
			'category'  => 'collections-grids',
			'tags'      => array( 'collections-grids', 'content-media' ),
			'thumbnail' => 'cards',
			'meta'      => array( 'relationship', 'posts' ),
		),
		'acf/filtered-content-grid' => array(
			'category'  => 'collections-grids',
			'tags'      => array( 'collections-grids', 'interactive-layout' ),
			'thumbnail' => 'filtered-grid',
			'meta'      => array( 'query', 'filters', 'JS' ),
		),
		'acf/campaign-hero' => array(
			'category'  => 'hero-conversion',
			'tags'      => array( 'hero-conversion', 'content-media' ),
			'thumbnail' => 'hero',
			'meta'      => array( 'media', 'CTA', 'proof' ),
		),
		'acf/inline-media' => array(
			'category'  => 'content-media',
			'tags'      => array( 'content-media', 'interactive-layout' ),
			'thumbnail' => 'media-player',
			'meta'      => array( 'video', 'transcript', 'JS' ),
		),
		'acf/pricing-tables' => array(
			'category'  => 'hero-conversion',
			'tags'      => array( 'hero-conversion', 'collections-grids' ),
			'thumbnail' => 'pricing',
			'meta'      => array( 'repeater', 'links', 'JS' ),
		),
		'acf/open-positions' => array(
			'category'  => 'people-careers',
			'tags'      => array( 'people-careers', 'collections-grids' ),
			'thumbnail' => 'jobs',
			'meta'      => array( 'external API', 'cache' ),
		),
		'acf/meet-the-team' => array(
			'category'  => 'people-careers',
			'tags'      => array( 'people-careers', 'interactive-layout' ),
			'thumbnail' => 'people',
			'meta'      => array( 'repeater', 'media', 'filters' ),
		),
		'acf/testimonials' => array(
			'category'  => 'social-proof',
			'tags'      => array( 'social-proof', 'storytelling' ),
			'thumbnail' => 'testimonial',
			'meta'      => array( 'repeater', 'quotes' ),
		),
		'acf/cta-banner' => array(
			'category'  => 'hero-conversion',
			'tags'      => array( 'hero-conversion', 'social-proof' ),
			'thumbnail' => 'cta',
			'meta'      => array( 'links', 'testimonial' ),
		),
		'acf/timeline-milestones' => array(
			'category'  => 'storytelling',
			'tags'      => array( 'storytelling', 'content-media' ),
			'thumbnail' => 'timeline',
			'meta'      => array( 'repeater', 'dates' ),
		),
		'acf/before-after-comparison' => array(
			'category'  => 'content-media',
			'tags'      => array( 'content-media', 'interactive-layout' ),
			'thumbnail' => 'comparison',
			'meta'      => array( 'media', 'range', 'JS' ),
		),
		'acf/sticky-feature-showcase' => array(
			'category'  => 'interactive-layout',
			'tags'      => array( 'interactive-layout', 'storytelling', 'content-media' ),
			'thumbnail' => 'sticky',
			'meta'      => array( 'repeater', 'media', 'JS' ),
		),
		'acf/case-study-spotlight' => array(
			'category'  => 'social-proof',
			'tags'      => array( 'social-proof', 'storytelling', 'content-media' ),
			'thumbnail' => 'case-study',
			'meta'      => array( 'WYSIWYG', 'media', 'metrics' ),
		),
		'acf/project-gallery' => array(
			'category'  => 'content-media',
			'tags'      => array( 'content-media', 'interactive-layout' ),
			'thumbnail' => 'gallery',
			'meta'      => array( 'gallery', 'dialog', 'JS' ),
		),
		'acf/impact-metrics' => array(
			'category'  => 'social-proof',
			'tags'      => array( 'social-proof', 'collections-grids' ),
			'thumbnail' => 'metrics',
			'meta'      => array( 'repeater', 'sources' ),
		),
		'acf/proof-logos' => array(
			'category'  => 'social-proof',
			'tags'      => array( 'social-proof', 'collections-grids' ),
			'thumbnail' => 'logos',
			'meta'      => array( 'repeater', 'media', 'links' ),
		),
		'acf/solutions-comparison' => array(
			'category'  => 'collections-grids',
			'tags'      => array( 'collections-grids', 'hero-conversion' ),
			'thumbnail' => 'pricing',
			'meta'      => array( 'nested repeater', 'table', 'links' ),
		),
		'acf/why-choose-us' => array(
			'category'  => 'social-proof',
			'tags'      => array( 'social-proof', 'hero-conversion' ),
			'thumbnail' => 'reasons',
			'meta'      => array( 'repeater', 'evidence', 'links' ),
		),
	);
}

/**
 * Add public-directory card metadata to a component definition.
 *
 * @param string              $block_name Registered block name.
 * @param array<string,mixed> $component Component metadata.
 * @return array<string,mixed>
 */
function add_workbench_component_card_metadata( string $block_name, array $component ): array {
	$card_metadata = get_workbench_component_card_metadata();
	$categories    = get_workbench_component_categories();
	$metadata      = $card_metadata[ $block_name ] ?? array(
		'category'  => '',
		'tags'      => array(),
		'thumbnail' => 'cards',
		'meta'      => array( 'ACF' ),
	);
	$category      = isset( $metadata['category'] ) ? (string) $metadata['category'] : '';

	return array_merge(
		$component,
		array(
			'primary_category'       => $category,
			'primary_category_label' => $categories[ $category ] ?? __( 'Component', 'acf-module-workbench' ),
			'tags'                   => isset( $metadata['tags'] ) && is_array( $metadata['tags'] ) ? $metadata['tags'] : array(),
			'thumbnail'              => isset( $metadata['thumbnail'] ) ? (string) $metadata['thumbnail'] : 'cards',
			'meta'                   => isset( $metadata['meta'] ) && is_array( $metadata['meta'] ) ? $metadata['meta'] : array( 'ACF' ),
		)
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
				add_workbench_component_card_metadata( $block_name, $components[ $block_name ] ),
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
				add_workbench_component_card_metadata( $block_name, $components[ $block_name ] ),
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
