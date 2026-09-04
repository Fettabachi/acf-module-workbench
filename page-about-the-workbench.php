<?php
/**
 * About the Workbench page.
 *
 * @package ACF_Module_Workbench
 */

get_header();
?>
<main id="primary" class="site-main workbench-about">
	<div class="container content-stack">
		<header class="workbench-about__hero">
			<p class="workbench-eyebrow"><?php esc_html_e( 'About the workbench', 'acf-module-workbench' ); ?></p>
			<h1><?php esc_html_e( 'A practical place to build better WordPress components.', 'acf-module-workbench' ); ?></h1>
			<p><?php esc_html_e( 'This site is both a component library and a record of the thinking behind it. Each module starts with a real interface problem and is developed as production-minded theme code—not a disposable screenshot recreation.', 'acf-module-workbench' ); ?></p>
		</header>

		<section class="workbench-about__section" aria-labelledby="workbench-process-title">
			<div class="workbench-about__section-heading">
				<p class="workbench-eyebrow"><?php esc_html_e( 'The process', 'acf-module-workbench' ); ?></p>
				<h2 id="workbench-process-title"><?php esc_html_e( 'From content model to quality assurance.', 'acf-module-workbench' ); ?></h2>
			</div>
			<ol class="workbench-process">
				<li><strong><?php esc_html_e( 'Define the contract.', 'acf-module-workbench' ); ?></strong> <?php esc_html_e( 'Clarify the content, behavior, optional states, and genuine editor choices before writing markup.', 'acf-module-workbench' ); ?></li>
				<li><strong><?php esc_html_e( 'Build the complete path.', 'acf-module-workbench' ); ?></strong> <?php esc_html_e( 'Keep fields, rendering, styles, assets, and required behavior together as one coherent component.', 'acf-module-workbench' ); ?></li>
				<li><strong><?php esc_html_e( 'Test the uncomfortable cases.', 'acf-module-workbench' ); ?></strong> <?php esc_html_e( 'Review empty data, long copy, keyboard use, reduced motion, narrow layouts, editor constraints, and external failures.', 'acf-module-workbench' ); ?></li>
				<li><strong><?php esc_html_e( 'Record the decisions.', 'acf-module-workbench' ); ?></strong> <?php esc_html_e( 'Document tradeoffs and lessons so the next component starts from a stronger baseline.', 'acf-module-workbench' ); ?></li>
			</ol>
		</section>

		<section class="workbench-about__section" aria-labelledby="workbench-principles-title">
			<div class="workbench-about__section-heading">
				<p class="workbench-eyebrow"><?php esc_html_e( 'Shared standards', 'acf-module-workbench' ); ?></p>
				<h2 id="workbench-principles-title"><?php esc_html_e( 'Four principles guide every module.', 'acf-module-workbench' ); ?></h2>
			</div>
			<div class="workbench-principles">
				<article><h3><?php esc_html_e( 'Accessible', 'acf-module-workbench' ); ?></h3><p><?php esc_html_e( 'Semantic structure, keyboard operation, visible focus, useful names, sufficient contrast, and reduced-motion support are part of implementation—not a later audit.', 'acf-module-workbench' ); ?></p></article>
				<article><h3><?php esc_html_e( 'Portable', 'acf-module-workbench' ); ?></h3><p><?php esc_html_e( 'Components avoid page IDs, site-specific URLs, generic class names, and hidden dependencies on one surrounding layout.', 'acf-module-workbench' ); ?></p></article>
				<article><h3><?php esc_html_e( 'Editor-friendly', 'acf-module-workbench' ); ?></h3><p><?php esc_html_e( 'Controls reflect meaningful content decisions and are tested in the space editors actually use.', 'acf-module-workbench' ); ?></p></article>
				<article><h3><?php esc_html_e( 'Defensive', 'acf-module-workbench' ); ?></h3><p><?php esc_html_e( 'Every field may be empty, every external response is untrusted, and the useful experience should survive missing data or unavailable JavaScript.', 'acf-module-workbench' ); ?></p></article>
			</div>
		</section>

		<section class="workbench-repository" aria-labelledby="workbench-repository-title">
			<div>
				<p class="workbench-eyebrow"><?php esc_html_e( 'Public repository', 'acf-module-workbench' ); ?></p>
				<h2 id="workbench-repository-title"><?php esc_html_e( 'Inspect the implementation.', 'acf-module-workbench' ); ?></h2>
				<p><?php esc_html_e( 'The theme, ACF field definitions, component records, and source assets are available on GitHub.', 'acf-module-workbench' ); ?></p>
			</div>
			<a class="workbench-button" href="<?php echo esc_url( \ACF_Module_Workbench\WORKBENCH_REPOSITORY_URL ); ?>"><?php esc_html_e( 'View the repository', 'acf-module-workbench' ); ?></a>
		</section>
	</div>
</main>
<?php
get_footer();
