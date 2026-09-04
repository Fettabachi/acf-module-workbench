<?php

/**
 * Site header.
 *
 * @package ACF_Module_Workbench
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'acf-module-workbench'); ?></a>
    <header class="site-header">
        <div class="container site-header__inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                <?php endif; ?>
            </div>
            <nav class="primary-navigation" aria-label="<?php esc_attr_e('Primary navigation', 'acf-module-workbench'); ?>">
                <?php if (has_nav_menu('primary')) : ?>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'container'      => false,
                        )
                    );
                    ?>
                <?php else : ?>
                    <ul class="primary-navigation__fallback">
                        <li><a<?php if (is_front_page()) : ?> aria-current="page"<?php endif; ?> href="<?php echo esc_url(home_url('/#components')); ?>"><?php esc_html_e('Components', 'acf-module-workbench'); ?></a></li>
                        <li><a<?php if (is_page('about-the-workbench')) : ?> aria-current="page"<?php endif; ?> href="<?php echo esc_url(home_url('/about-the-workbench/')); ?>"><?php esc_html_e('About', 'acf-module-workbench'); ?></a></li>
                        <li><a href="<?php echo esc_url(\ACF_Module_Workbench\WORKBENCH_REPOSITORY_URL); ?>"><?php esc_html_e('GitHub', 'acf-module-workbench'); ?></a></li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
    </header>
