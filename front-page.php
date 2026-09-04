<?php
/**
 * Public component-directory front page.
 *
 * @package ACF_Module_Workbench
 */

$components = \ACF_Module_Workbench\get_workbench_component_pages();

get_header();
?>
<main id="primary" class="site-main workbench-home">
	<div class="container content-stack">
		<section class="workbench-hero" aria-labelledby="workbench-hero-title">
			<p class="workbench-eyebrow"><?php esc_html_e( 'ACF Module Workbench', 'acf-module-workbench' ); ?></p>
			<h1 class="workbench-hero__title" id="workbench-hero-title"><?php esc_html_e( 'Portable components, built in the open.', 'acf-module-workbench' ); ?></h1>
			<p class="workbench-hero__introduction"><?php esc_html_e( 'A working collection of accessible, editor-friendly WordPress components. Each example includes the decisions, dependencies, and defensive details behind the interface.', 'acf-module-workbench' ); ?></p>
			<a class="workbench-button" href="#components"><?php esc_html_e( 'Explore the components', 'acf-module-workbench' ); ?></a>
		</section>

		<section class="component-directory" id="components" aria-labelledby="component-directory-title">
			<header class="component-directory__header">
				<p class="workbench-eyebrow"><?php esc_html_e( 'Component library', 'acf-module-workbench' ); ?></p>
				<h2 class="component-directory__title" id="component-directory-title"><?php esc_html_e( 'Built to be useful beyond the demo.', 'acf-module-workbench' ); ?></h2>
				<p><?php esc_html_e( 'Open a component to try the live example and review its content model, accessibility behavior, responsive decisions, and source.', 'acf-module-workbench' ); ?></p>
			</header>

			<?php if ( ! empty( $components ) ) : ?>
				<ul class="component-directory__grid" role="list">
					<?php foreach ( $components as $component ) : ?>
						<li class="component-directory__item">
							<a class="component-card" href="<?php echo esc_url( get_permalink( $component['page'] ) ); ?>">
								<span class="component-card__name"><?php echo esc_html( $component['title'] ); ?></span>
								<span class="component-card__summary"><?php echo esc_html( $component['summary'] ); ?></span>
								<span class="component-card__action">
									<?php esc_html_e( 'View component', 'acf-module-workbench' ); ?>
									<svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><path d="M4 10h11m-4-4 4 4-4 4"></path></svg>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>

		<aside class="workbench-about-callout" aria-labelledby="workbench-about-title">
			<div>
				<p class="workbench-eyebrow"><?php esc_html_e( 'Behind the work', 'acf-module-workbench' ); ?></p>
				<h2 id="workbench-about-title"><?php esc_html_e( 'See how the workbench is built.', 'acf-module-workbench' ); ?></h2>
				<p><?php esc_html_e( 'Read about the workflow, project standards, and portability principles shared by every component.', 'acf-module-workbench' ); ?></p>
			</div>
			<a class="workbench-text-link" href="<?php echo esc_url( home_url( '/about-the-workbench/' ) ); ?>">
				<?php esc_html_e( 'About the workbench', 'acf-module-workbench' ); ?>
				<span aria-hidden="true">→</span>
			</a>
		</aside>
	</div>
</main>
<?php
get_footer();
