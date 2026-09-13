# Case Study Spotlight specification

## Purpose

Build a portable `acf/case-study-spotlight` block that turns one completed
engagement into a concise, credible results story. The component should help a
prospective customer connect a recognizable problem with the work performed and
the measurable change that followed.

## Content and interaction contract

- Optional eyebrow and introduction.
- Required section heading with an H2, H3, or H4 choice.
- Required client or anonymized project name and optional industry context.
- Optional client logo and supporting Media Library image.
- Required challenge and approach rich content.
- Two to four ordered outcomes, each with a required value and label plus an
  optional qualifier or timeframe.
- Optional testimonial that renders only with both a quote and person's name;
  role and organization context may be combined in one supporting field.
- Optional complete link to the full case study.
- The component is informational except for the explicit optional link. Do not
  make the surface, metrics, client identity, or testimonial clickable.

The visible labels “Client,” “The challenge,” “The approach,” and “What
changed” are fixed, translated interface copy rather than editor fields.

## Rendering and data handling

- Treat every field as potentially empty or malformed, including required
  fields.
- Allowlist the heading level and derive the narrative heading level from it.
- Validate image attachment IDs before rendering WordPress image markup.
- Normalize at most four outcomes and omit rows without both a value and label.
- Omit incomplete links and testimonials without empty wrappers.
- Omit the frontend block without a heading, client name, challenge, approach,
  and at least two complete outcomes. Show concise guidance in an incomplete
  editor preview.
- Escape plain text, attributes, URLs, and permitted rich HTML by context.

## Semantics and accessibility

- Render a section labelled by its visible heading.
- Preserve challenge-before-approach story order at every viewport.
- Use a definition list for outcome labels, values, and optional supporting
  details.
- Render the optional quote as a figure containing a blockquote and figcaption.
- Preserve Media Library alternative text; do not derive alternatives from the
  client name or filename.
- Keep the explicit link keyboard operable with a visible focus state. Disable
  navigation in the Gutenberg preview.
- Protect long headings, metric values, labels, names, and rich content from
  horizontal overflow.

## Responsive behavior

- Begin as one column with story media before narrative copy and outcomes in one
  column.
- At intermediate widths, present outcomes in two columns. When exactly three
  outcomes are present, let the third span the complete second row rather than
  exposing an empty grid cell.
- At wide widths, align the client identity beside the introduction, pair
  supporting media with the narrative, and present up to four outcomes in one
  row.
- When media is absent, let challenge and approach form balanced wide columns
  without leaving an empty media region.
- Keep the testimonial before the optional link in document order.

## Editor contract

- Use ACF Block Version 3's expanded editor as the primary authoring surface.
- Divide Introduction, Client Story, and Results & Proof with meaningful tabs.
- Use a block-layout outcome repeater collapsed by its result value.
- Keep the rendered block in preview mode and hide duplicate sidebar fields.
- Do not expose layout, color, font, metric-card, label, or breakpoint controls.

## Host dependencies

The host supplies WordPress block registration and wrapper APIs; ACF text,
textarea, WYSIWYG, image, link, button-group, tab, and repeater fields; ACF's
expanded block editor; Media Library image markup; the outer aligned-block
width; and documented semantic design tokens. The block owns its internal
layout, hierarchy, fallback values, defensive behavior, and responsive rules.
It does not depend on a post ID, page template, URL, generic host utility,
third-party service, or JavaScript.

## Validation targets

- Parse block metadata and ACF Local JSON, then run PHP syntax checks.
- Verify heading fallback, invalid attachment IDs, malformed outcome rows,
  incomplete proof, incomplete links, and the minimum complete-story boundary.
- Verify exactly two through four outcomes, long and symbolic metric values,
  missing optional media, long client context, and multiple block instances.
- Inspect narrow, breakpoint-adjacent, intermediate, and wide layouts for order,
  overflow, balanced outcome rows, and the no-media variant.
- Verify Media Library alternatives, keyboard focus, editor link suppression,
  expanded-editor tabs, and preview centering with the sidebar open and closed.
- Run `git diff --check` before completion.
