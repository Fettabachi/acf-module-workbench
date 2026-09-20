# Solutions Comparison

## Overview

Solutions Comparison helps B2B buyers distinguish related services, packages, or products using the criteria that matter to a purchase decision.

## Component contract

Editors control the section introduction, two to four solution names, concise fit guidance, one optional recommendation, solution-specific links, and up to twelve ordered comparison criteria. Each criterion contains values in the same order as the solution columns and may use a constrained status or specific text.

The component controls table semantics, column alignment, recommendation styling, responsive overflow, empty-value treatment, and link behavior. The expanded editor keeps the nested data model out of Gutenberg's narrow sidebar.

## Implementation decisions

- A native table keeps column and row relationships explicit rather than recreating them with generic cards.
- Criteria are authored separately from solution headers so each name, description, recommendation, and destination has one source of truth.
- Included, optional, unavailable, and custom statuses produce consistent language and visual marks; Text supports values such as company size or implementation timing.
- Only the first solution marked Recommended receives emphasis, preventing conflicting recommendations without hiding editor input.
- The frontend requires no JavaScript.

## Accessibility and defensive behavior

The table includes a descriptive caption and uses column and row headers. At narrower widths, its labelled scrolling region is keyboard focusable and displays a visible instruction. Focus remains visible, CTA links retain explicit labels, and incomplete links or rows are omitted. Missing criterion values are announced as not specified.

## Validation

Review two-, three-, and four-solution versions at narrow, intermediate, and wide widths. Check keyboard access to the overflow region and links, long labels and values, missing optional content, mismatched value counts, multiple recommendation toggles, editor collapse controls, and reduced-motion preferences. Validate PHP syntax and the ACF JSON before release.

## Tradeoffs and future improvements

ACF cannot dynamically label nested values from a separate solution repeater, so editors must preserve solution order within each criterion. Clear field instructions, collapsed-row summaries, and a maximum of four columns keep that relationship manageable. Comparisons requiring dozens of rows or frequently changing product data may warrant a dedicated data source and administration interface.

## Source

- [Component package](../../parts/modules/solutions-comparison/)
- [Component specification](solutions-comparison-specification.md)
