# CTA Banner

## Overview

CTA Banner translates the supplied Synkra call-to-action composition into a
portable closing module. It combines a focused message and paired next steps
with concise reassurance and an optional attributed customer perspective.

## Component contract

Editors build the heading from a standard prefix, bold italic emphasized phrase,
and optional suffix. A primary link is required; the secondary link and
reassurance note are optional. A testimonial appears only when both its quote
and author name are complete, with an optional role. All controls live in a
tabbed expanded editor, and duplicate Gutenberg panel fields remain hidden.

## Implementation decisions

- The dark Synkra treatment is the component's intentional design rather than an
  editor-selectable surface variant.
- Separate heading segments reproduce the designed emphasis without allowing
  unrestricted rich text in a heading.
- The primary and secondary actions remain explicit links; the banner itself is
  never an ambiguous click target.
- Exact Figma exports supply the decorative linework and support icon. The icon
  is applied as a `currentColor` mask so it remains faithful to the source while
  following the secondary button's light default and dark hover states. Project
  semantic tokens supply the primary, signal, stack, typography, and radius
  roles around those assets.
- Message and testimonial content preserve their semantic order while the module
  owns its responsive layout. No JavaScript is required.

## Accessibility and defensive behavior

The labelled section supports `h2` through `h4`, and the optional testimonial
uses a figure, blockquote, and figcaption. Decorative assets have empty
alternative text and are hidden from assistive technology. Links provide visible
focus, generous targets, and safe new-window behavior. Incomplete links and
testimonial data are omitted; long authored values wrap rather than overflow.

## Validation

Block registration, metadata, ACF Local JSON, PHP syntax, escaping, editor
recognition, expanded-editor configuration, keyboard focus, coordinated button
and icon hover states, local assets, and frontend rendering are checked.
Responsive QA covers mobile, tablet, and desktop layouts with complete and
optional content combinations.

## Tradeoffs and future improvements

Three heading fields add small editorial overhead, but they preserve the intended
emphasis without introducing a permissive rich-text heading. The decorative
assets are presentation-only and can be replaced if the component is transferred
to a host with different licensed artwork.

## Source

- [Component package](../../parts/modules/cta-banner/)
- [Component specification](cta-banner-specification.md)
