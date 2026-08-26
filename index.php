<?php
/**
 * Main template fallback.
 *
 * @package CR_Practice
 */

get_header();
?>
<main id="primary" class="site-main">
	<div class="container content-stack">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
					<header class="entry__header">
						<?php if ( is_singular() ) : ?>
							<h1 class="entry__title"><?php the_title(); ?></h1>
						<?php else : ?>
							<h2 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php endif; ?>
					</header>
					<div class="entry__content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>
		<?php else : ?>
			<section class="entry">
				<h1 class="entry__title"><?php esc_html_e( 'Nothing found', 'cr-practice' ); ?></h1>
				<p><?php esc_html_e( 'There is no content to display yet.', 'cr-practice' ); ?></p>
			</section>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
