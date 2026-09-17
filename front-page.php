<?php

/**
 * Public component-directory front page.
 *
 * @package ACF_Module_Workbench
 */

$components = \ACF_Module_Workbench\get_workbench_component_pages();
$categories = \ACF_Module_Workbench\get_workbench_component_categories();
$contract_examples = array();
$contract_example_details = array(
    'acf/pricing-tables' => array(
        'editor'      => __('Plan names, prices, feature lists, billing labels, and links.', 'acf-module-workbench'),
        'component'   => __('Responsive plan cards and accessible billing controls.', 'acf-module-workbench'),
        'field_group' => 'acf-json/group_pricing_tables.json',
    ),
    'acf/accordion' => array(
        'editor'      => __('Questions, answers, and their order.', 'acf-module-workbench'),
        'component'   => __('Disclosure semantics, keyboard behavior, and readable content without JavaScript.', 'acf-module-workbench'),
        'field_group' => 'acf-json/group_accordion.json',
    ),
);

foreach ($components as $component) {
    $block_name = isset($component['block_name']) ? (string) $component['block_name'] : '';

    if (isset($contract_example_details[$block_name])) {
        $contract_examples[] = array_merge($component, $contract_example_details[$block_name]);
    }
}

get_header();
?>
<main id="primary" class="site-main workbench-home">
    <div class="container content-stack">
        <section class="workbench-hero" aria-labelledby="workbench-hero-title">
            <p class="workbench-eyebrow"><?php esc_html_e('PUBLIC WORDPRESS COMPONENT LIBRARY', 'acf-module-workbench'); ?></p>
            <h1 class="workbench-hero__title" id="workbench-hero-title"><?php esc_html_e('Reusable WordPress blocks, from editor fields to live output.', 'acf-module-workbench'); ?></h1>
            <p class="workbench-hero__introduction"><?php esc_html_e('These blocks use Advanced Custom Fields (ACF) to give editors clear content controls while keeping layout and behavior dependable. Explore live examples, then inspect the field definitions, source code, and implementation notes in the public repository.', 'acf-module-workbench'); ?></p>
            <div class="workbench-hero__actions">
                <a class="workbench-button" href="#components"><?php esc_html_e('Explore the components', 'acf-module-workbench'); ?></a>
                <a class="workbench-text-link" href="https://github.com/Fettabachi/acf-module-workbench" target="_blank" rel="noopener noreferrer">
                    <?php esc_html_e('View the code and documentation', 'acf-module-workbench'); ?>
                    <span class="workbench-text-link__icon" aria-hidden="true">→</span>
                </a>
            </div>
        </section>

        <section class="workbench-contract" id="component-contract" aria-labelledby="workbench-contract-title">
            <header class="workbench-contract__header">
                <p class="workbench-eyebrow"><?php esc_html_e('The component contract', 'acf-module-workbench'); ?></p>
                <h2 id="workbench-contract-title"><?php esc_html_e('Useful freedom for editors. Durable decisions in code.', 'acf-module-workbench'); ?></h2>
                <p><?php esc_html_e('The WordPress editor stays close to the rendered page, while structured fields keep content choices clear. Layout and interaction stay in the component—not in a collection of one-off page settings.', 'acf-module-workbench'); ?></p>
            </header>

            <div class="workbench-contract__ownership">
                <div class="workbench-contract__party">
                    <h3><?php esc_html_e('Editors control', 'acf-module-workbench'); ?></h3>
                    <p><?php esc_html_e('Copy, media, links, order, and approved variations that change the meaning of the content.', 'acf-module-workbench'); ?></p>
                </div>
                <div class="workbench-contract__party">
                    <h3><?php esc_html_e('Components control', 'acf-module-workbench'); ?></h3>
                    <p><?php esc_html_e('Semantic markup, layout, breakpoints, keyboard and focus behavior, empty states, and presentation.', 'acf-module-workbench'); ?></p>
                </div>
            </div>

            <?php if (! empty($contract_examples)) : ?>
                <div class="workbench-contract__examples">
                    <div class="workbench-contract__examples-heading">
                        <h3><?php esc_html_e('Trace the contract in working components.', 'acf-module-workbench'); ?></h3>
                        <p><?php esc_html_e('The editor fields and live output are both available to inspect; no one component has to stand in for the whole library.', 'acf-module-workbench'); ?></p>
                    </div>
                    <ul class="workbench-contract__example-list">
                        <?php foreach ($contract_examples as $example) : ?>
                            <li class="workbench-contract__example">
                                <h4><?php echo esc_html($example['title']); ?></h4>
                                <p><strong><?php esc_html_e('Editor:', 'acf-module-workbench'); ?></strong> <?php echo esc_html($example['editor']); ?></p>
                                <p><strong><?php esc_html_e('Component:', 'acf-module-workbench'); ?></strong> <?php echo esc_html($example['component']); ?></p>
                                <div class="workbench-contract__example-links">
                                    <a href="<?php echo esc_url(\ACF_Module_Workbench\get_workbench_repository_url($example['field_group'])); ?>" aria-label="<?php echo esc_attr(sprintf(__('%s editor fields', 'acf-module-workbench'), $example['title'])); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Editor fields', 'acf-module-workbench'); ?></a>
                                    <a href="<?php echo esc_url(get_permalink($example['page'])); ?>" aria-label="<?php echo esc_attr(sprintf(__('%s live component', 'acf-module-workbench'), $example['title'])); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Live component', 'acf-module-workbench'); ?></a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </section>

        <section class="component-directory" id="components" aria-labelledby="component-directory-title" data-component-directory data-transition-scope="<?php echo esc_attr(wp_unique_id('component-directory-')); ?>">
            <header class="component-directory__header">
                <p class="workbench-eyebrow"><?php esc_html_e('Component library', 'acf-module-workbench'); ?></p>
                <h2 class="component-directory__title" id="component-directory-title"><?php esc_html_e('Built to be useful beyond the demo.', 'acf-module-workbench'); ?></h2>
                <p><?php esc_html_e('Open a component to try the live example and review its content model, accessibility behavior, responsive decisions, and source.', 'acf-module-workbench'); ?></p>
            </header>

            <?php if (! empty($components)) : ?>
                <div class="component-directory__filters" data-component-directory-filters hidden>
                    <label class="component-directory__filter-label" for="component-directory-filter"><?php esc_html_e('Filter components', 'acf-module-workbench'); ?></label>
                    <div class="component-directory__select-wrap">
                        <select class="component-directory__select" id="component-directory-filter" data-component-directory-filter>
                            <option value="all">
                                <?php
                                echo esc_html(
                                    sprintf(
                                        /* translators: %d: number of components. */
                                        __('All components (%d)', 'acf-module-workbench'),
                                        count($components)
                                    )
                                );
                                ?>
                            </option>
                            <?php foreach ($categories as $category_slug => $category_label) : ?>
                                <?php
                                $category_count = 0;

                                foreach ($components as $component) {
                                    $tags = isset($component['tags']) && is_array($component['tags']) ? $component['tags'] : array();

                                    if (in_array($category_slug, $tags, true)) {
                                        ++$category_count;
                                    }
                                }

                                if (0 === $category_count) {
                                    continue;
                                }
                                ?>
                                <option value="<?php echo esc_attr($category_slug); ?>">
                                    <?php
                                    echo esc_html(
                                        sprintf(
                                            /* translators: 1: category label, 2: number of matching components. */
                                            __('%1$s (%2$d)', 'acf-module-workbench'),
                                            $category_label,
                                            $category_count
                                        )
                                    );
                                    ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <p class="component-directory__status screen-reader-text" aria-live="polite" aria-atomic="true" data-component-directory-status data-status-singular="<?php esc_attr_e('Showing %d component.', 'acf-module-workbench'); ?>" data-status-plural="<?php esc_attr_e('Showing %d components.', 'acf-module-workbench'); ?>">
                    <?php
                    echo esc_html(
                        sprintf(
                            /* translators: %d: number of components. */
                            __('Showing %d components.', 'acf-module-workbench'),
                            count($components)
                        )
                    );
                    ?>
                </p>

                <ul class="component-directory__grid" role="list" data-component-directory-grid aria-busy="false">
                    <?php foreach ($components as $component) : ?>
                        <?php
                        $component_tags = isset($component['tags']) && is_array($component['tags']) ? array_filter(array_map('sanitize_key', $component['tags'])) : array();
                        $thumbnail      = isset($component['thumbnail']) ? sanitize_html_class((string) $component['thumbnail']) : 'cards';
                        $meta_items     = isset($component['meta']) && is_array($component['meta']) ? array_filter(array_map('trim', $component['meta'])) : array();
                        ?>
                        <li class="component-directory__item" data-tags="<?php echo esc_attr(implode(',', $component_tags)); ?>">
                            <a class="component-card" href="<?php echo esc_url(get_permalink($component['page'])); ?>">
                                <span class="component-card__thumbnail component-card__thumbnail--<?php echo esc_attr($thumbnail); ?>" aria-hidden="true">
                                    <span class="component-card__badge"><?php echo esc_html(strtolower((string) $component['primary_category_label'])); ?></span>
                                    <span class="component-card__wireframe">
                                        <?php for ($wireframe_part = 1; $wireframe_part <= 6; ++$wireframe_part) : ?>
                                            <span class="component-card__wireframe-part component-card__wireframe-part--<?php echo esc_attr((string) $wireframe_part); ?><?php echo 1 === $wireframe_part % 2 ? ' component-card__wireframe-part--odd' : ' component-card__wireframe-part--even'; ?>"></span>
                                        <?php endfor; ?>
                                    </span>
                                </span>
                                <span class="component-card__body">
                                    <span class="component-card__name"><?php echo esc_html($component['title']); ?></span>
                                    <span class="component-card__summary"><?php echo esc_html($component['summary']); ?></span>
                                    <?php if (! empty($meta_items)) : ?>
                                        <span class="component-card__meta">
                                            <?php esc_html_e('ACF', 'acf-module-workbench'); ?>
                                            <?php foreach ($meta_items as $meta_item) : ?>
                                                <span aria-hidden="true">&middot;</span>
                                                <span><?php echo esc_html($meta_item); ?></span>
                                            <?php endforeach; ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="component-card__action">
                                        <?php esc_html_e('View component', 'acf-module-workbench'); ?>
                                        <svg viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                                            <path d="M4 10h11m-4-4 4 4-4 4"></path>
                                        </svg>
                                    </span>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section class="workbench-contact" aria-labelledby="workbench-contact-title">
            <p class="workbench-eyebrow"><?php esc_html_e('Freelance development', 'acf-module-workbench'); ?></p>
            <h2 id="workbench-contact-title"><?php esc_html_e('Work with Tim', 'acf-module-workbench'); ?></h2>
            <p><?php esc_html_e('I’m Tim Fetter, a freelance WordPress and front-end developer. I help agencies, designers, and businesses bring designs to life through an AI-accelerated workflow, with semantic, accessible implementation, responsive polish, and pages that are easier to update. I’m available for scoped projects, contract work, and agency overflow support.', 'acf-module-workbench'); ?></p>
            <div class="workbench-contact__actions">
                <a class="workbench-button" href="<?php echo esc_url('https://timfetter.com/contact/'); ?>"><?php esc_html_e('Discuss a project', 'acf-module-workbench'); ?></a>
                <a class="workbench-text-link" href="<?php echo esc_url('https://timfetter.com/'); ?>">
                    <span class="workbench-text-link__label"><?php esc_html_e('View my portfolio', 'acf-module-workbench'); ?></span>
                    <span class="workbench-text-link__icon" aria-hidden="true">→</span>
                </a>
            </div>
        </section>

        <aside class="workbench-about-callout" aria-labelledby="workbench-about-title">
            <div>
                <p class="workbench-eyebrow"><?php esc_html_e('Behind the work', 'acf-module-workbench'); ?></p>
                <h2 id="workbench-about-title"><?php esc_html_e('See how the workbench is built.', 'acf-module-workbench'); ?></h2>
                <p><?php esc_html_e('Read about the workflow, project standards, and portability principles shared by every component.', 'acf-module-workbench'); ?></p>
            </div>
            <a class="workbench-text-link" href="<?php echo esc_url(home_url('/about-the-workbench/')); ?>">
                <span class="workbench-text-link__label"><?php esc_html_e('About the workbench', 'acf-module-workbench'); ?></span>
                <span class="workbench-text-link__icon" aria-hidden="true">→</span>
            </a>
        </aside>
    </div>
</main>
<?php
get_footer();
