<?php

/**
 * Site header.
 *
 * @package CR_Practice
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
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'cr-practice'); ?></a>
    <header class="site-header">
        <div class="container site-header__inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a class="site-title" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                <?php endif; ?>
            </div>
            <?php if (has_nav_menu('primary')) : ?>
                <nav class="primary-navigation" aria-label="<?php esc_attr_e('Primary navigation', 'cr-practice'); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'container'      => false,
                        )
                    );
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    </header>