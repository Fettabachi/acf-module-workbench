# Content Media

## Overview

Content Media pairs focused editorial copy with supporting imagery in a reusable split layout. It is appropriate for services, capabilities, case studies, and other sections where text and media should carry equal weight.

## Component contract

Editors provide a heading, body copy, and image. An eyebrow, call to action, and media position are optional. Empty optional fields do not produce empty markup.

## Implementation decisions

- The document order remains content-first even when CSS places the image first visually.
- The image uses WordPress attachment data and responsive image output instead of a hard-coded URL.
- Styles and identifiers are scoped to the module so it can move between compatible themes.
- The component stacks into one column when the available width no longer supports the split layout.

## Accessibility and defensive behavior

The template preserves a logical heading hierarchy, meaningful link text, and authored image alternative text. Missing optional content and malformed links are omitted safely.

## Validation

The component was reviewed with complete and partial content at wide, intermediate, and narrow viewport sizes. PHP syntax, responsive image output, keyboard focus, empty-data behavior, and editor presentation were checked.

## Tradeoffs and future improvements

Media position is intentionally limited to two purposeful choices. Additional visual variants should be introduced only when a recurring content need justifies them.

## Source

- [Component package](../../parts/modules/content-media/)
