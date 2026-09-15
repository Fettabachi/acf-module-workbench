# Impact Metrics

## Overview

Impact Metrics presents a short, substantiated collection of organizational,
campaign, program, or service outcomes. It is designed for pages that need
scan-friendly proof without requiring visitors to read a complete case study.

## Component contract

Editors provide a heading and two to six complete metrics. Each metric pairs a
displayed value with a plain-language result label. Measurement context, source
label, public source URL, section eyebrow, introduction, shared methodology
note, and closing call to action are optional.

## Implementation decisions

- Editors enter a complete display value so currency, percentages, multipliers,
  durations, and human-readable quantities are not forced into one numeric model.
- Context and sources are attached to individual metrics because figures may
  use different timeframes, audiences, baselines, or evidence.
- Source labels remain useful without a public URL; a URL is rendered only when
  its label is also present.
- A shared methodology note provides collection-level qualification without
  repeating the same caveat in every card.
- The grid balances every supported metric count at tablet and wide sizes,
  avoiding placeholder cards and exposed empty cells.
- Values are deliberately static. Count-up animation would add motion without
  improving credibility, comprehension, or access to the underlying evidence.

## Accessibility and defensive behavior

The block is a labelled section containing a semantic definition list. Each
result label remains programmatically associated with its value, context, and
source regardless of the responsive layout. Source links and the optional CTA
use visible focus states; the CTA has a restrained state transition that is
removed for reduced-motion preferences. Incomplete metrics, invalid optional
links, and empty supporting fields disappear cleanly. The frontend block omits
itself until a heading and two complete metrics remain.

## Validation

Block metadata, Local JSON, registration, PHP syntax, editor-script syntax, and
server rendering are checked. Responsive review covers two through six metrics,
long values and copy, linked and unlinked sources, optional-field combinations,
balanced mobile, tablet, and desktop grids, CTA states, and the expanded editor
with its repeater controls.

## Tradeoffs and future improvements

The component does not calculate, animate, query, or automatically verify
figures. Its purpose is editorial presentation with enough context for visitors
to evaluate the claims. Projects needing live dashboards or derived calculations
should use a data-backed visualization rather than expanding this content model.

## Source

- [Component package](../../parts/modules/impact-metrics/)
- [Component specification](impact-metrics-specification.md)
