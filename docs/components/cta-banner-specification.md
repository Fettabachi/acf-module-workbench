# CTA Banner specification

## Objective

Build a portable `acf/cta-banner` block that adapts the supplied Synkra call to
action into the theme's WordPress and ACF conventions. Preserve its centered
message, paired actions, reassurance note, testimonial footer, dark atmospheric
surface, and decorative linework without coupling the content to Synkra.

## Content model

- Required heading prefix and emphasized phrase, plus an optional suffix.
- `h2`, `h3`, or `h4` hierarchy control.
- Required primary ACF link and optional secondary ACF link.
- Optional plain-text reassurance note.
- Optional testimonial quote, name, and role. The quote renders only when the
  quote and name are both complete.

Expose these controls only through ACF Block Version 3's expanded editor. Group
them under Message, Actions, and Testimonial tabs; keep the rendered block in
preview mode and hide duplicate fields from Gutenberg's block sidebar. Present
the controls on the established editor tab rail with a clearly connected active
tab and WordPress admin-color indicator.

## Structure and behavior

Use a labelled `section`, explicit links, a semantic `figure`, `blockquote`, and
`figcaption` for the testimonial. The full banner is never a click target.
Buttons stack on narrow screens and become a centered row when space permits.
The testimonial stacks before becoming a quote-and-attribution grid. The block
requires no JavaScript.

## Visual contract

Use the design's single dark gradient surface, centered display heading, bold
italic emphasized phrase, primary-blue action, bordered secondary action,
orange reassurance marker, and lower testimonial composition. Preserve the
exact exported background linework and support icon as local decorative assets.
Apply the support icon as a `currentColor` mask so its color follows the
secondary button in default and hover states without modifying the exported
silhouette.
Consume project typography, primary, signal, stack, and radius roles through
component-scoped variables with portable fallbacks. Do not expose arbitrary
surface, color, alignment, width, spacing, or type-size controls.

## Accessibility and QA

- Preserve logical heading hierarchy, explicit link semantics, and semantic
  testimonial attribution.
- Mark exported artwork and the support icon decorative.
- Provide visible keyboard focus and at least 44px-high action targets.
- Keep the secondary action's text and icon colors synchronized in every state.
- Disable preview navigation without removing visible action labels.
- Keep expanded-editor tab labels and the active tab visually distinct.
- Omit incomplete optional links and testimonials without empty wrappers.
- Test long content, absent optional content, `_blank` links, multiple instances,
  and narrow through wide layouts.
- Verify frontend rendering, Gutenberg recognition, expanded-editor metadata,
  PHP syntax, ACF Local JSON, exact local assets, and clean diffs.
