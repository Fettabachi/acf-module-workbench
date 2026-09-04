# Accessible Accordion

## Overview

The Accessible Accordion lets visitors scan a short set of topics and reveal the supporting content they need.

## Component contract

Editors provide optional section copy and repeatable accordion items containing a concise label and rich answer content.

## Implementation decisions

- Each trigger is a native button with an explicit relationship to its panel.
- Stable, instance-specific identifiers prevent collisions when multiple accordions appear on one page.
- JavaScript enhances the controls while the unenhanced page keeps all answers available.
- Animation is modest and removed when the visitor prefers reduced motion.

## Accessibility and defensive behavior

Buttons expose their expanded state, support normal keyboard activation, and retain a visible focus indicator. Heading levels follow the surrounding document, and empty or incomplete items are not rendered.

## Validation

The accordion was checked with keyboard-only interaction, multiple instances, long content, reduced-motion preferences, disabled JavaScript, and narrow through wide viewports. Frontend and editor rendering were reviewed.

## Tradeoffs and future improvements

The interaction intentionally allows independent panels rather than enforcing a single-open-item pattern. That choice avoids closing content unexpectedly and works well for comparison.

## Source

- [Component package](../../parts/modules/accordion/)
- [Component specification](accessible-accordion-specification.md)
