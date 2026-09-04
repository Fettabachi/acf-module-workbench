# Campaign Hero

## Overview

Campaign Hero combines a focused message, action, proof points, and art-directed media in an expressive opening section.

## Component contract

Editors control campaign copy, a call to action, supporting proof points, and optional imagery. The field model limits choices that would undermine the composition.

## Implementation decisions

- Responsive image sources support deliberate mobile and desktop crops.
- Content order remains meaningful independently of the visual composition.
- ACF's Expanded Editor keeps the tabbed field groups out of the constrained Gutenberg sidebar while the component preview remains aligned with the editor canvas.
- The module root owns its box sizing so its responsive padding cannot overflow the Gutenberg preview or another host theme.
- The layout is CSS-driven and requires no JavaScript.
- Component styling uses project tokens while remaining scoped to the module.

## Accessibility and defensive behavior

The hero preserves a clear heading structure, descriptive link copy, responsive images, visible focus, and sufficient contrast. Optional artwork and proof points disappear cleanly when absent.

## Validation

The component was reviewed with alternate image combinations, varied copy lengths, keyboard navigation, and desktop, tablet, and mobile viewports. PHP syntax and editor presentation were checked.

## Tradeoffs and future improvements

This is intentionally a campaign-specific composition rather than a universal hero builder. Additional variants should be implemented as explicit designs with their own content constraints.

## Source

- [Component package](../../parts/modules/campaign-hero/)
- [Component specification](campaign-hero-specification.md)
