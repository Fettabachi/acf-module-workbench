# Testimonials

## Overview

Testimonials presents a curated sequence of customer perspectives using compact card rows and larger featured statements. Editors can place featured rows anywhere in the sequence without changing the semantic reading order or creating incomplete grid layouts.

## Component contract

Editors provide a required heading, optional eyebrow and introduction, and one or more ordered testimonial rows. A standard row contains one to three testimonials. A featured row contains one testimonial with an optional supporting detail. Each testimonial requires a quote and name and may include a portrait, role, and organization. There is no arbitrary overall row limit.

## Implementation decisions

- Flexible Content models standard and featured rows as explicit, draggable editorial units rather than inferring layout from a flat list.
- Multiple featured rows are permitted, and every row retains its authored position at all viewport sizes.
- Standard quotes use one consistent body treatment; featured quotes use the display type role and a constrained measure.
- The decorative quote-mark badge from the reference design is intentionally omitted because the blockquote composition already communicates the content type.
- The optional eyebrow is text-only, avoiding a decorative icon dependency.
- The section heading relies on typographic scale and spacing for hierarchy; the detached blue underline is intentionally omitted.
- The component is informational. It does not invent profile links, case-study actions, a carousel, or other interaction absent from the content contract.

## Accessibility and defensive behavior

The block uses a labelled section, semantic blockquotes, figures, and figcaptions while preserving authored row order in the DOM. Portraits retain Media Library alternative text; missing or invalid images receive decorative initials derived from the person's name. Incomplete testimonials and empty rows are omitted. Long quotes and attribution values wrap defensively, and no meaning depends on portrait imagery.

## Validation

Block registration, ACF Local JSON, block metadata, PHP syntax, and representative frontend rendering are checked. Responsive review covers standard and featured rows in different positions, one-to-three-card standard rows, multiple featured rows, missing portraits and optional attribution details, long copy, and narrow through wide layouts. The expanded authoring interface remains an integration QA check whenever the host updates ACF or WordPress.

## Tradeoffs and future improvements

An unlimited row builder keeps the block flexible, but it remains intended for a curated page section rather than a large reusable testimonial archive. A site that manages dozens of shared testimonials should move the source data to a dedicated content type while retaining this row-based presentation contract.

## Source

- [Component package](../../parts/modules/testimonials/)
- [Component specification](testimonials-specification.md)
