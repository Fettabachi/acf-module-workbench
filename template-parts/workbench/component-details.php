<?php
/**
 * Component notes and adjacent-component navigation.
 *
 * @package ACF_Module_Workbench
 */

if ( ! defined( 'ABSPATH' ) || empty( $args['component'] ) || ! is_array( $args['component'] ) ) {
	return;
}

$component = $args['component'];
$pages     = \ACF_Module_Workbench\get_workbench_component_pages();
$current   = null;

foreach ( $pages as $index => $page_component ) {
	if ( $page_component['block_name'] === $component['block_name'] ) {
		$current = $index;
		break;
	}
}

$previous = null !== $current && $current > 0 ? $pages[ $current - 1 ] : null;
$next     = null !== $current && $current < count( $pages ) - 1 ? $pages[ $current + 1 ] : null;
$source_url = \ACF_Module_Workbench\get_workbench_repository_url( $component['source_path'], true );
$docs_url   = \ACF_Module_Workbench\get_workbench_repository_url( $component['docs_path'] );
?>
<footer class="component-context">
	<details class="component-details">
		<summary>
			<span><?php esc_html_e( 'Learn more about this component', 'acf-module-workbench' ); ?></span>
			<svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M10 4v12M4 10h12"></path></svg>
		</summary>
		<div class="component-details__region">
			<div class="component-details__body">
				<div class="component-details__introduction">
					<p class="workbench-eyebrow"><?php esc_html_e( 'Component notes', 'acf-module-workbench' ); ?></p>
					<h2><?php echo esc_html( sprintf( /* translators: %s: Component name. */ __( 'About %s', 'acf-module-workbench' ), $component['title'] ) ); ?></h2>
					<p><?php echo esc_html( $component['purpose'] ); ?></p>
				</div>
				<div class="component-details__columns">
					<section aria-labelledby="component-editor-title-<?php the_ID(); ?>">
						<h3 id="component-editor-title-<?php the_ID(); ?>"><?php esc_html_e( 'What editors control', 'acf-module-workbench' ); ?></h3>
						<ul>
							<?php foreach ( $component['editor_controls'] as $control ) : ?>
								<li><?php echo esc_html( $control ); ?></li>
							<?php endforeach; ?>
						</ul>
					</section>
					<section aria-labelledby="component-implementation-title-<?php the_ID(); ?>">
						<h3 id="component-implementation-title-<?php the_ID(); ?>"><?php esc_html_e( 'Implementation notes', 'acf-module-workbench' ); ?></h3>
						<ul>
							<?php foreach ( $component['implementation'] as $note ) : ?>
								<li><?php echo esc_html( $note ); ?></li>
							<?php endforeach; ?>
						</ul>
					</section>
				</div>
				<div class="component-details__links">
					<a href="<?php echo esc_url( $source_url ); ?>"><?php esc_html_e( 'View component source', 'acf-module-workbench' ); ?></a>
					<a href="<?php echo esc_url( $docs_url ); ?>"><?php esc_html_e( 'Read component notes', 'acf-module-workbench' ); ?></a>
				</div>
			</div>
		</div>
	</details>

	<?php if ( $previous || $next ) : ?>
		<nav class="component-pagination" aria-label="<?php esc_attr_e( 'Component navigation', 'acf-module-workbench' ); ?>">
			<?php if ( $previous ) : ?>
				<a class="component-pagination__link component-pagination__link--previous" href="<?php echo esc_url( get_permalink( $previous['page'] ) ); ?>">
					<span><?php esc_html_e( 'Previous component', 'acf-module-workbench' ); ?></span>
					<strong><?php echo esc_html( $previous['title'] ); ?></strong>
				</a>
			<?php endif; ?>
			<?php if ( $next ) : ?>
				<a class="component-pagination__link component-pagination__link--next" href="<?php echo esc_url( get_permalink( $next['page'] ) ); ?>">
					<span><?php esc_html_e( 'Next component', 'acf-module-workbench' ); ?></span>
					<strong><?php echo esc_html( $next['title'] ); ?></strong>
				</a>
			<?php endif; ?>
		</nav>
	<?php endif; ?>
</footer>
