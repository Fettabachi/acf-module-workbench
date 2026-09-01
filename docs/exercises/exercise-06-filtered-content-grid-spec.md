# Exercise 06 — Filtered Content Grid Specification

## Design source

This is an original component brief for the empty WordPress page titled
“Exercise 06 Filtered Content Grid.” It follows the practice series into
automatic post queries and progressively enhanced visitor controls.

## Goal

Build a portable `acf/filtered-content-grid` block that queries recent published
posts, optionally scopes the query to editor-selected categories, and lets
visitors filter the returned collection by category without a page load.

## Content and interaction contract

- A required section title introduces the collection and defaults to “Filtered
  Content Grid” so a newly inserted block has an immediate preview.
- An optional introduction adds one short supporting paragraph.
- The editor chooses `h2`, `h3`, or `h4`; card headings use the next level.
- The editor may choose category scope and a post count from 1 through 24.
- Posts are always the newest published standard posts. Editorial ordering,
  pagination, and “load more” behavior are outside this component.
- Filters are derived only from categories represented in the returned posts.
  A scoped query exposes only selected categories as filter choices.
- “All” is initially active. Selecting a category updates pressed state,
  visible cards, and a polite result-count status through a smooth View
  Transition where supported, with a short fade fallback and reduced-motion
  opt-out.
- The controls appear only when at least two useful category choices exist and
  JavaScript has initialized. Without JavaScript, every queried post remains
  visible as a complete semantic collection.

## Rendering and data handling

- Treat every ACF field and queried post value as potentially absent.
- Allowlist heading levels and clamp the post count to 1–24.
- Normalize, validate, and deduplicate category IDs before querying.
- Ignore sticky-post priority and query by descending publication date.
- Omit posts without a usable title or permalink.
- Render authored excerpts only; never manufacture body-content excerpts.
- Use `wp_get_attachment_image()` and preserve Media Library alt text.
- Omit the entire block without a title or valid posts.

## Accessibility and responsive contract

- Use a labelled section, semantic result list, and labelled article cards.
- Use native buttons in a labelled group with `aria-pressed`; do not implement
  the filters as tabs because they change a result set rather than panels.
- Keep the live result count associated with the filter group.
- Preserve DOM order while filtering by toggling the native `hidden` state.
- Provide visible focus, practical 44px controls, defensive wrapping, and
  reduced-motion support.
- Use one column at narrow widths, two when cards have sufficient room, and
  three at wide widths. The host owns outer gutters and `alignwide` width.

## Editor contract

- New blocks open in edit mode.
- Fields expose content, query scope, and result count only—not card styling or
  duplicated post data.
- The server-rendered preview shares frontend markup and styling.
- Preview card links remain visible but cannot navigate the editor.
- A missing title still produces a clearly labelled editor-only preview and
  guidance instead of an invisible block; the frontend remains empty until the
  required title exists.

## Validation targets

- Parse block metadata and ACF Local JSON; check PHP and JavaScript syntax.
- Verify empty title, invalid heading, invalid categories, and count clamping.
- Verify automatic date order, selected-category scope, multi-category posts,
  authored excerpts, missing excerpts, featured images, and missing images.
- Verify progressive enhancement, button pressed state, live counts, repeated
  instances, keyboard focus, narrow/intermediate/wide layouts, and no overflow.
- Inspect both the frontend and Gutenberg editor before completion.
