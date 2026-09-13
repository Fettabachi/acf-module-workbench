# Case Study Spotlight

## Overview

Case Study Spotlight turns one completed engagement into a focused proof story.
It connects the client's challenge and the work performed with measurable
outcomes, then optionally reinforces that evidence with imagery, an attributed
quote, and a link to the complete case study.

## Component contract

Editors provide a heading, client or anonymized project name, challenge,
approach, and two to four complete outcomes. Eyebrow, introduction, industry
context, client logo, supporting image, testimonial, and full-story link are
optional. Each outcome requires a concise value and label and may include a
measurement qualifier or timeframe.

## Implementation decisions

- The component presents one story rather than becoming a case-study archive;
  shared collections remain the responsibility of posts or a dedicated content
  type.
- Fixed narrative labels preserve a consistent story structure without asking
  editors to recreate interface copy.
- Outcome values remain text so legitimate formats such as percentages,
  multipliers, currency, durations, and qualitative measured states are not
  forced into one numeric model.
- The optional link is the only interactive region. The component does not
  invent clickable cards, logos, metrics, or quotes.
- Media is supplementary. The no-media composition remains complete and
  balanced rather than reserving an empty column.
- A three-outcome set fills its intermediate-width grid: the final outcome spans
  the second row before all three outcomes form equal columns at wide widths.

## Accessibility and defensive behavior

The block uses a labelled section, hierarchical narrative headings, a semantic
definition list for outcomes, and figure relationships for optional testimony.
WordPress retains Media Library alternative text. Incomplete outcomes,
testimonials, links, and invalid media are omitted. The frontend block omits
itself until a complete core story remains after validation, while the editor
shows useful completion guidance. Long values and copy wrap defensively.

## Validation

Block metadata, Local JSON, registration, PHP syntax, and representative server
rendering are checked. Responsive review covers two through four outcomes,
missing media, optional proof combinations, long content, narrow through wide
layouts, and the expanded authoring experience with both sidebar states.

## Tradeoffs and future improvements

Outcome values are editorial claims rather than calculations. Content owners
remain responsible for making them accurate, attributable, and appropriately
qualified. Sites that reuse the same case studies in many locations should
move the story data into a dedicated content type and retain this component as
one presentation option.

## Source

- [Component package](../../parts/modules/case-study-spotlight/)
- [Component specification](case-study-spotlight-specification.md)
