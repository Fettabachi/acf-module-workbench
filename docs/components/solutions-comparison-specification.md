# Solutions Comparison specification

## Purpose

Help a B2B visitor decide which related solution best fits their organization without conflating capability comparison with pricing.

## Content model

- Optional eyebrow
- Required heading and explicit H2–H4 level
- Optional concise introduction
- Two to four solutions, each with:
  - required name
  - optional best-fit description
  - optional recommendation state and badge
  - optional complete CTA link
- One to twelve criteria, each with:
  - required label
  - optional supporting detail
  - two to four ordered solution values
- Each value uses Included, Optional, Not available, Custom, or Text plus optional detail
- Optional shared comparison note

## Authoring experience

Use ACF Block Version 3's expanded editor as the primary authoring surface. Divide introduction, solutions, criteria, and notes into concise tabs. Solution and criterion repeaters use block layout, meaningful collapsed labels, and keyboard-operable Expand all and Collapse all controls. Keep nested value rows individually collapsible without adding redundant bulk controls.

## Rendering and behavior

Render a semantic table with solution column headers and criterion row headers. Keep all authored content in the document at every width. At constrained widths, place the table in a labelled, focusable horizontal scrolling region and show an instruction; remove the visible instruction when the complete table fits at wide widths. Do not require frontend JavaScript.

## Defensive rules

- Render only complete named solutions, up to four.
- Render only labelled criteria, up to twelve.
- Match criterion values to the normalized solution order and ignore extras.
- Represent missing values as Not specified.
- Honor only the first recommended solution.
- Render CTAs only when both URL and label are present.
- Render no frontend block unless a heading, two solutions, and one criterion remain after normalization.

## Accessibility

Use a caption, `scope="col"` for solutions, and `scope="row"` for criteria. Preserve visible focus for the overflow region and links. Ensure status meaning is present as text rather than color or icon alone. CTA state changes must remain perceivable without motion and transitions must be disabled for reduced-motion preferences.
