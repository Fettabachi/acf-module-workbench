# Sticky Feature Showcase specification

## Purpose

Present two to six related stages as a coherent visual narrative. Use it when the relationship between sequential copy and imagery matters more than compact comparison or direct navigation.

## Content model

- Optional eyebrow
- Required section heading
- Required heading level: H2, H3, or H4
- Optional introduction
- Two to six ordered steps:
  - Optional short label
  - Required title
  - Required concise summary
  - Required Media Library image
  - Optional complete link

## Rendering rules

- Omit the frontend component unless a heading and at least two complete steps remain after validation.
- Omit invalid steps rather than rendering partial cards.
- Preserve attachment alternative text and responsive image sources.
- Omit optional labels and incomplete links without empty wrappers.
- Preserve authored step order at every viewport and in the DOM.

## Responsive behavior

- Below 56.25rem, render a stacked sequence with each image immediately before its copy.
- At and above 56.25rem, supported browsers may progressively enhance the layout into a sticky media column and scrolling step column.
- Without JavaScript, wider screens retain the complete stacked cards.
- Gutenberg preview mirrors the responsive behavior: wide canvases use the sticky stage and narrow canvases use the stacked representation.

## Interaction and accessibility

- Do not intercept or animate the page scroll position.
- Do not move keyboard focus as active steps change.
- Treat enhanced sticky images as decorative copies; keep the inline sequence as the semantic source.
- Keep links native and visibly focusable.
- Disable component transitions for reduced-motion preferences.

## Dependencies

The module requires WordPress block metadata, ACF Pro block fields, Media Library attachments, and the theme's semantic design tokens. It includes portable fallback values and does not depend on a page ID, host container utility, URL, or third-party library.
