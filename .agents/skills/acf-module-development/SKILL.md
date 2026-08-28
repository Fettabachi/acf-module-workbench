---
name: acf-module-development
description: Build or revise portable ACF-driven modules in this WordPress theme. Use for module templates, field groups, module-specific styles, and related behavior.
---

# Develop reusable ACF modules

## Procedure

1. Inspect nearby modules, shared helpers, containers, media handling, CTA patterns, and ACF JSON before editing. Reuse a sound pattern instead of creating a parallel one.
2. Define the module contract. Expose content, media, links, intentional optional content, and meaningful variants required by the design. Keep incidental implementation choices in code; do not add arbitrary color, spacing, width, alignment, font-size, border, or layout controls merely because ACF makes them easy to expose.
3. Use predictable, module-scoped field names. Keep the field group exportable in `/acf-json` and aligned with the module directory name. Add requirements, limits, defaults, and concise instructions only where they improve editorial reliability.
4. Treat every field as potentially empty, including fields marked required. Normalize values once, render only complete elements, and omit empty wrappers, links, headings, media, attributes, and decorative regions. Test realistic optional-field combinations and varied title and body lengths.
5. Escape at output by context: text, attributes, URLs, and permitted rich HTML need different WordPress escaping functions. Sanitize values before storage or use when the module handles input.
6. Use semantic landmarks and a heading level that fits the page hierarchy; do not hard-code a new page-level heading inside a reusable module. Preserve meaningful Media Library alt text. Prefer native elements and correct link or button semantics; add ARIA only when native HTML is insufficient.
7. Reuse shared CTA and media primitives when they are documented, portable theme contracts. Keep module markup, internal layout, styles, fields, and behavior otherwise self-contained and free of generic layout classes, page-specific selectors, or fixed IDs.
8. Complete mobile-first responsive behavior across narrow, intermediate, and wide layouts. Use Grid or Flexbox for layout and JavaScript only for required behavior.
9. Verify keyboard use, visible `:focus-visible`, touch-target sizing, contrast, reduced-motion behavior where relevant, DOM versus visual order, empty-field combinations, long content, missing media, and escaping. Check PHP syntax and the rendered frontend and editor at representative mobile, tablet, and desktop sizes.

## Done criteria

The module has a clear content contract, purposeful controls, no empty output, valid and escaped semantic markup, complete responsive behavior, documented real dependencies, portable field JSON, and focused validation evidence.
