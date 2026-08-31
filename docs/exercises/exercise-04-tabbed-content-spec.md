# Exercise 04 — Tabbed Content Specification

## Design source

This exercise is an original component brief rather than a screenshot
translation. It extends the practice series into purposeful client-side
behavior while retaining the established project design system and portable
ACF module conventions.

## Goal

Build a portable `acf/tabbed-content` block that groups related rich-content
panels behind a compact tab interface. The enhanced experience must follow the
ARIA tabs interaction pattern, remain usable across narrow and wide layouts,
and preserve all content in a readable stacked fallback when JavaScript is not
available.

## Interaction contract

The component is fully interactive when enhanced.

- The first complete tab is selected on initial load.
- Activating a tab reveals its associated panel and hides the others.
- Pointer or touch activation moves focus to and selects the chosen tab.
- Left and Right Arrow move focus and selection through the tabs, wrapping at
  either end. Home selects the first tab and End selects the last.
- Automatic activation is intentional because panel changes are local and do
  not require a network request.
- Focus stays on the selected tab after activation. Panels are not placed in
  the normal tab sequence unless their own content contains interactive
  elements.
- On narrow screens, the tab list becomes a deterministic two-column grid. An
  odd final tab spans both columns so the layout never produces a narrow orphan.
  All tabs remain visible without horizontal scrolling.

Without JavaScript, the tab controls remain hidden and every complete panel is
shown as a labelled section. Content is not hidden behind an inoperable
control.

## Content model

| Field | ACF type | Requirement | Contract |
| --- | --- | --- | --- |
| Section title | Text | Required | Plain text; the block does not render without it. |
| Introduction | Textarea | Optional | One short supporting paragraph. |
| Section heading level | Button group | Required | Allow `h2`, `h3`, or `h4`; default `h2`. |
| Background image | Image | Optional | Atmospheric section image returned as an attachment ID. |
| Tabs | Repeater | Required | Minimum two, block layout, no arbitrary maximum. |
| Tab label | Text | Required per row | Concise control label and collapsed-row identity. |
| Panel heading | Text | Optional per row | Visible heading inside the panel. |
| Panel content | WYSIWYG | Required per row | Basic rich text with media upload disabled. |
| Call to action | Link | Optional per row | Complete linked control beneath panel content. |

Do not expose color, typography, spacing, width, orientation, activation mode,
or animation controls. The interaction and visual treatment are component
decisions, not editorial choices.

## Rendering and data handling

- Treat all ACF values as potentially absent or malformed.
- Allowlist the section heading level and fall back to `h2`.
- Discard rows with an empty tab label or no meaningful panel content.
- Render nothing when the section title is empty or fewer than two complete
  rows survive normalization. A single valid row is ordinary content rather
  than a meaningful tab set.
- Preserve all complete rows; do not impose a renderer-side maximum.
- Escape plain text and attributes by context. Sanitize WYSIWYG content with
  `wp_kses_post()` and do not execute shortcodes implicitly.
- Generate unique tab and panel IDs per block instance with a WordPress helper.
  Never derive cross-instance IDs from row indexes alone.

## Semantics and accessibility

- Render the component as a labelled `<section>`.
- When a panel heading is present, render it one level below the selected
  section heading (`h3`, `h4`, or `h5`).
- Render the control group with `role="tablist"` and an accessible name that
  references the section heading.
- Use `<button type="button" role="tab">` controls with `aria-selected`,
  `aria-controls`, and roving `tabindex`.
- Use `role="tabpanel"`, `aria-labelledby`, and the native `hidden` attribute
  for inactive enhanced panels.
- Keep DOM and visual order identical.
- Provide a clear `:focus-visible` state, a minimum 44px control height,
  defensive text wrapping, and touch-safe wrapping without page overflow.
- Any motion is nonessential and must be removed under
  `prefers-reduced-motion: reduce`.

## Layout and design-system contract

The host theme owns the `alignwide` area and outer page gutters. The module
fills that available area and does not add a generic container or a second
outer width constraint.

The module consumes project semantic roles for text, muted text, surface,
subtle surface, border, accent, body type, display type, label type, radius,
and section spacing. Component-scoped fallbacks keep the editor preview usable
when frontend root variables are absent. Internal dimensions and the tab-panel
relationship belong to the module.

The visual composition adapts Designmodo's **Hops Farm Tabbed Widget**: an
atmospheric image field, colored tab rail, selected-tab pointer, elevated white
content panel, strong editorial hierarchy, and a secondary graphic area. The
project version uses a numbered stage motif instead of copying the reference
illustration. On mobile the tab rail wraps into two columns and the panel stacks.
The selected-tab marker is a true downward-pointing triangle. The section header
uses the full available width and balances its title only when wrapping is
actually necessary.

## Editor contract

- New blocks open in edit mode so empty defensive rendering does not create a
  blank initialization experience.
- The repeater uses block layout and the tab label as its collapsed summary.
- Editor styles expose the collapse control and preserve clear row boundaries.
- A dedicated editor script must make the rendered preview tabs operable by
  pointer and keyboard even when Gutenberg intercepts normal block clicks. It
  must enhance both the editor document and Gutenberg's same-origin canvas
  document, including previews replaced after an ACF field update.
- If editor enhancement fails, every panel remains visible rather than trapping
  editors on an inaccessible first-panel-only preview.
- Field editing remains the primary authoring experience.

## Validation targets

- Parse block metadata and ACF Local JSON.
- Run PHP syntax checks.
- Verify empty, incomplete, malformed, long-label, rich-content, and multiple-
  instance rendering.
- Verify click, touch, Arrow keys, Home, End, focus, selected state, panel
  visibility, and no-JavaScript fallback.
- Inspect mobile, breakpoint-adjacent, tablet, and desktop layouts for overflow
  and nested gutters.
- Review frontend and editor console output, then run `git diff --check`.
