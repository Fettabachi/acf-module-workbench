---
name: build-portable-acf-modules
description: Build or revise reusable ACF/WordPress modules whose markup, layout, fields, media, and editor preview must remain portable across host themes.
---

# Build portable ACF modules

Before implementation, answer: **What does this module depend on from the host
theme?** Audit typography, CSS variables, resets, layout utilities, breakpoints,
alignment behavior, and editor assumptions. Keep dependencies deliberate,
documented, and overridable rather than accidental.

## Layout and design translation

- Separate page/layout-shell responsibility from block-internal layout. Inspect
  the module's ancestors before adding centering, horizontal padding, gutters,
  or `max-width`; do not place a width-constraining module wrapper inside an
  existing width constraint unless the design deliberately calls for both.
- Let the block wrapper participate in the host layout while uniquely
  namespaced classes own the component's internal geometry. For example,
  `.content-media__inner` is a portable component class; `.container` is not.
- Do not add broad host classes such as `.container`, `.section`, `.wrapper`,
  `.grid`, `.row`, `.columns`, or `.card` to reusable module markup merely
  because similar utilities exist. Any retained host dependency must be an
  explicit, documented component contract.
- Translate design-system values and relationships—not dimensions caused by the
  current copy. Preserve aspect ratios, column proportions, spacing hierarchy,
  and alignment; avoid fixed component heights and rendered text widths.
- Document responsive behavior inferred where the design source is silent.

## Fields and rendering

- Expose content and meaningful presentation choices to editors. Keep semantic
  and design-system decisions in code unless editors genuinely need control.
- Avoid controls such as heading-level or repeated icon selectors when the
  component contract already defines them. Required fields should reflect that
  contract, and controls should not remain available when they have no effect.
- Omit optional markup when fields are empty. Protect long or unbroken content
  from overflow, and avoid fixed IDs, page-specific selectors, URLs, database
  assumptions, and unnecessary JavaScript.

## Frontend and editor parity

- Scope frontend selectors, state styles, and modifiers to the module namespace;
  avoid broad selectors such as `.title`, `.grid`, or `.card` that can leak into
  other components.
- When visual structure affects comprehension or editing, provide editor styles
  that make hierarchy, columns, block boundaries, fields, and alignment
  recognizable. They need not reproduce the frontend pixel-for-pixel.
- Prefer one shared module stylesheet for the frontend and Gutenberg when that
  remains clear and lightweight. Do not copy the entire frontend stylesheet
  into editor CSS when a smaller scoped representation is sufficient.
- Do not assume frontend-only variables, body typography, resets, generic
  containers, or ancestor selectors exist in the editor. Provide narrowly
  scoped fallbacks for essential module tokens.
- Scope editor rules to the module and add editor-only overrides only where
  Gutenberg's wrapper or canvas genuinely requires them. Never globally restyle
  the editor to make one module work.

## Responsive and accessibility QA

- Make responsive behavior a module responsibility rather than an accidental
  consequence of page styles. Check desktop, tablet, and mobile for nested
  gutters, overflow, awkward wrapping, image sizing, spacing, and assumptions
  that work only with ideal content.
- Choose breakpoints where the component stops working, not from arbitrary
  device conventions. Test immediately below, at, and above each important
  breakpoint.
- Verify long headings, labels, URLs, maximum repeater rows, both media
  positions, and multiple instances. Keep DOM order semantically sensible.
- Prefer attachment IDs with `wp_get_attachment_image()`. Preserve Media Library
  alt text and never fabricate alt text from filenames.
- Mark decorative SVGs `aria-hidden="true"` and non-focusable. Check contrast
  during visual QA rather than postponing it to final review.

## Portability review

Before declaring the module complete, verify:

1. It does not rely on an ancestor class that may be absent elsewhere.
2. Its class names cannot reasonably collide with another theme or component.
3. Page-level width constraints and gutters are not duplicated unintentionally.
4. Its internal layout still works in another normal content location.
5. Frontend and editor styles are fully scoped.
6. Optional fields produce clean markup in realistic combinations.
7. Non-ideal but valid content does not break the component.
8. The module owns its responsive behavior.
9. Accessibility was implemented and tested as part of the component.
