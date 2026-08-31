---
name: acf-module-development
description: Build or revise portable ACF-driven modules in this WordPress theme. Use for module templates, field groups, module-specific styles, and related behavior.
---

# Develop reusable ACF modules

## Procedure

1. Inspect nearby modules, shared helpers, containers, media handling, CTA patterns, and ACF JSON before editing. Reuse a sound pattern instead of creating a parallel one.
2. Define the module contract. Expose content, media, links, intentional optional content, and meaningful variants required by the design. Keep incidental implementation choices in code; do not add arbitrary color, spacing, width, alignment, font-size, border, or layout controls merely because ACF makes them easy to expose. Detect unresolved behavior before choosing fields and markup. Do not let implementation assumptions silently become product requirements.

   - When a supplied design does not clearly indicate interaction, classify the component as informational only, partially interactive, or fully interactive before implementation. Do not invent links, buttons, hover behavior, click targets, or navigation semantics.
   - For cards, tiles, promos, feature items, and similar components, determine whether each item links anywhere; whether interaction is required or optional per item; whether the whole item or only an explicit control is interactive; the destination or action; whether hover, focus, active, or disabled states are supplied; whether an explicit CTA label exists; and what keyboard or focus requirements the interaction implies.
   - If the design does not resolve those questions, treat the component as non-interactive by default, raise the missing interaction contract during requirements review, and do not add speculative ACF link fields or frontend behavior merely because similar components are often interactive.
3. Use predictable, module-scoped field names. Keep the field group exportable in `/acf-json` and aligned with the module directory name. Add requirements, limits, defaults, and concise instructions only where they improve editorial reliability. Choose ACF field layouts based on the real editing environment, not just how the field group looks in ACF administration.

   - When a repeater contains several substantial subfields and will be edited in Gutenberg's constrained block or sidebar interface, avoid the table layout merely because it is compact. Consider the actual width available, especially with the settings sidebar open, and prefer block or row layouts for items combining toggles, selects, text inputs, textareas, media fields, or several other meaningful controls.
   - Make each repeater item readable and easy to scan as one coherent unit. Use a concise collapsed-row summary, such as the item title, when available so editors can navigate multiple rows efficiently.
   - When reordering is expected, verify collapse, expansion, and drag behavior in the actual Gutenberg editor. Prefer editor usability over minimizing vertical space.
4. Treat every field as potentially empty, including fields marked required. Normalize values once, render only complete elements, and omit empty wrappers, links, headings, media, attributes, and decorative regions. Test realistic optional-field combinations and varied title and body lengths.
5. Escape at output by context: text, attributes, URLs, and permitted rich HTML need different WordPress escaping functions. Sanitize values before storage or use when the module handles input.
6. Use semantic landmarks and a heading level that fits the page hierarchy; do not hard-code a new page-level heading inside a reusable module. Preserve meaningful Media Library alt text. Prefer native elements and correct link or button semantics; add ARIA only when native HTML is insufficient.
7. Reuse shared CTA and media primitives when they are documented, portable theme contracts. Keep module markup, internal layout, styles, fields, and behavior otherwise self-contained and free of generic layout classes, page-specific selectors, or fixed IDs.
8. Complete mobile-first responsive behavior across narrow, intermediate, and wide layouts. When a supplied design gives different mobile and desktop sizes for the same heading, record both endpoints and the intended interpolation range in the module contract. Prefer rem-bounded fluid sizing between them unless the design calls for a deliberate breakpoint change; do not require fluid sizing for every heading. Use Grid or Flexbox for layout and JavaScript only for required behavior.
9. Verify keyboard use, visible `:focus-visible`, touch-target sizing, contrast, reduced-motion behavior where relevant, DOM versus visual order, empty-field combinations, long content, missing media, and escaping. Check PHP syntax and the rendered frontend and editor at representative mobile, tablet, and desktop sizes.

## Done criteria

The module has a clear content contract, purposeful controls, no empty output, valid and escaped semantic markup, complete responsive behavior, documented real dependencies, portable field JSON, and focused validation evidence.
