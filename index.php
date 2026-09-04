<?php

/**
 * Main template fallback.
 *
 * @package ACF_Module_Workbench
 */

get_header();
?>
<main id="primary" class="site-main">
    <div class="container content-stack">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
                    <?php if (! is_front_page()) : ?>
                        <header class="entry__header">
                            <?php if (is_singular()) : ?>
                                <h1 class="entry__title"><?php the_title(); ?></h1>
                            <?php else : ?>
                                <h2 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php endif; ?>
                        </header>
                    <?php endif; ?>
                    <div class="entry__content">
                        <?php the_content(); ?>
                    </div>
                    <?php if (is_page() && ! is_front_page()) : ?>
                        <?php
                        $workbench_component = \ACF_Module_Workbench\get_workbench_component_for_post(get_the_ID());

                        if ($workbench_component) {
                            get_template_part(
                                'template-parts/workbench/component-details',
                                null,
                                array('component' => $workbench_component)
                            );
                        }
                        ?>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>

            <?php the_posts_navigation(); ?>
        <?php else : ?>
            <section class="entry">
                <h1 class="entry__title"><?php esc_html_e('Nothing found', 'acf-module-workbench'); ?></h1>
                <p><?php esc_html_e('There is no content to display yet.', 'acf-module-workbench'); ?></p>
            </section>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
