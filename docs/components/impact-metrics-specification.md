# Impact Metrics specification

## Purpose

Build a portable `acf/impact-metrics` block that presents a concise collection
of measurable outcomes with the context and citations visitors need to assess
their meaning.

## Content contract

- Optional eyebrow and introduction.
- Required section heading with an H2, H3, or H4 choice.
- Two to six ordered metrics.
- Required complete display value and plain-language result label per metric.
- Optional measurement context, source label, and public source URL per metric.
- Optional shared methodology note and complete closing link.

## Rendering and data handling

- Treat every field as potentially empty or malformed.
- Allowlist heading levels and cap metrics at six.
- Retain author order and omit metrics missing either their value or label.
- Render a source URL only with a corresponding source label.
- Omit incomplete links, empty context, citations, introduction, methodology,
  and footer wrappers.
- Omit the frontend block without a heading and two complete metrics. Show
  concise completion guidance in an incomplete editor preview.
- Escape text, attributes, and URLs by context.

## Semantics and accessibility

- Render a section labelled by its visible heading.
- Use one definition list whose grouped terms and descriptions associate each
  result label with its value, context, and source.
- Preserve authored metric order at every viewport.
- Use `cite` for source titles and links only when a public URL is complete.
- Keep links keyboard operable with visible focus and at least a 44 CSS pixel
  target for the CTA.
- Protect long values, labels, citations, and URLs from overflow.
- Keep CTA state changes understandable without motion and remove their
  transition for reduced-motion preferences.

## Responsive behavior

- Use one metric column on narrow screens and two at intermediate widths.
- Balance odd intermediate collections by letting the final card span the row.
- At wide widths use a six-track grid: three columns for three or six metrics,
  two columns for two or four metrics, and three followed by two balanced cards
  for five metrics.
- Do not add placeholder cards or reorder the DOM to complete a row.
- Let card height grow with valid content and align source citations toward the
  card footer when space permits.

## Editor contract

- Use ACF Block Version 3's expanded editor as the primary authoring surface.
- Divide introduction, metrics, and supporting-note fields with concise tabs.
- Use a block-layout repeater with the metric value as its collapsed summary.
- Provide keyboard-operable Expand all and Collapse all controls.
- Keep the rendered block in preview mode and hide duplicate sidebar fields.
- Do not expose arbitrary colors, columns, alignment, spacing, typography,
  animation, or card-style controls.

## Host dependencies

The host supplies WordPress block registration and wrapper APIs; ACF text,
textarea, URL, link, button-group, tab, and repeater fields; ACF's expanded block
editor; the outer aligned-block width; and documented semantic design tokens.
The module owns its evidence hierarchy, list semantics, citations, responsive
balancing, optional footer, defensive rendering, and scoped editor controls. It
does not depend on a post ID, page template, URL, generic host utility, external
data source, or frontend JavaScript.

## Validation targets

- Parse block metadata and ACF Local JSON; run PHP and editor JavaScript syntax
  checks.
- Verify heading fallback, malformed repeater values, incomplete metrics,
  incomplete source links, incomplete CTA data, and the minimum complete state.
- Inspect exactly two through six metrics, long and unbroken content, multiple
  instances, and every optional-field combination.
- Inspect narrow, breakpoint-adjacent, intermediate, and wide layouts for order,
  balanced rows, card growth, source alignment, and overflow.
- Verify source and CTA keyboard focus, CTA hover and focus transitions,
  reduced-motion behavior, editor link suppression, repeater reordering,
  individual collapse, and bulk Expand all and Collapse all controls.
- Run `git diff --check` before completion.
