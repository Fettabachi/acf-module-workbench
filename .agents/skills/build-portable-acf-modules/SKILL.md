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

- Inspect the module's ancestors before adding width or gutter wrappers. Let the
  block wrapper participate in the host layout while module-scoped classes own
  the component's internal geometry.
- Avoid generic host structural classes such as `.container`, `.wrapper`,
  `.row`, or `.grid` unless the host architecture explicitly requires that
  dependency. Do not replace one generic dependency with another.
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

- Prefer one shared module stylesheet for the frontend and Gutenberg.
- Do not assume frontend-only variables, body typography, resets, generic
  containers, or ancestor selectors exist in the editor. Provide narrowly
  scoped fallbacks for essential module tokens.
- Add editor-only overrides only where Gutenberg's wrapper or canvas genuinely
  requires them.

## Responsive and accessibility QA

- Choose breakpoints where the component stops working, not from arbitrary
  device conventions. Test immediately below, at, and above each important
  breakpoint.
- Verify long headings, labels, URLs, maximum repeater rows, both media
  positions, and multiple instances. Keep DOM order semantically sensible.
- Prefer attachment IDs with `wp_get_attachment_image()`. Preserve Media Library
  alt text and never fabricate alt text from filenames.
- Mark decorative SVGs `aria-hidden="true"` and non-focusable. Check contrast
  during visual QA rather than postponing it to final review.
