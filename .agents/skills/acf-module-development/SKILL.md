---
name: acf-module-development
description: Build or revise portable ACF-driven modules in this WordPress theme. Use for module templates, field groups, module-specific styles, and related behavior.
---

# Develop reusable ACF modules

## Procedure

1. Inspect nearby modules, shared helpers, containers, media handling, CTA patterns, and ACF JSON before editing. Reuse a sound pattern instead of creating a parallel one.
2. Define the module contract. Separate fields required for the module to communicate its purpose from optional enhancements. Add editor controls only when they enable a meaningful content or presentation choice.
3. Use predictable, module-scoped field names. Keep the field group exportable in `/acf-json` and aligned with the module directory name.
4. Treat every field as potentially empty. Normalize values once, render only complete elements, and omit empty wrappers, links, media, and decorative regions.
5. Escape at output by context: text, attributes, URLs, and permitted rich HTML need different WordPress escaping functions. Sanitize values before storage or use when the module handles input.
6. Use semantic landmarks and a heading level that fits the page hierarchy; do not hard-code a new page-level heading inside a reusable module. Preserve useful alt text and accessible names.
7. Reuse shared CTA, media, and container patterns when they are part of the theme foundation. Keep module markup, styles, fields, and behavior otherwise self-contained and free of page-specific selectors or IDs.
8. Complete mobile-first responsive behavior across narrow, intermediate, and wide layouts. Use Grid or Flexbox for layout and JavaScript only for required behavior.
9. Verify keyboard use, focus visibility, contrast, reduced-motion behavior where relevant, empty-field combinations, long content, missing media, and escaping. Check PHP syntax and the rendered page at representative mobile and desktop sizes.

## Done criteria

The module has a clear content contract, purposeful controls, no empty output, valid and escaped semantic markup, complete responsive behavior, documented real dependencies, portable field JSON, and focused validation evidence.
