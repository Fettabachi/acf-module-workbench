---
name: apply-project-design-system
description: Apply or extend this theme's project-level visual tokens and semantic typography, color, surface, spacing, and control conventions. Use for frontend or editor styling and design-system decisions; do not use it to define a component's content model or internal layout.
---

# Apply the CR Practice design system

Treat project tokens as the visual contract shared by the theme, reusable blocks,
and the editor. Component CSS may own layout and behavior, but must not create an
independent typography, color, spacing, radius, shadow, surface, or control system.

## Source of truth and current inventory

Inspect `assets/css/theme.css` before styling. Its `:root` currently defines:

- palette and semantic color roles including `--color-primary`,
  `--color-signal`, `--color-stack`, `--color-neutral`, `--color-text`,
  `--color-muted`, `--color-page`, `--color-surface`, `--color-accent`, and
  `--color-border`;
- typography roles: `--font-sans`, `--font-display`, `--font-body`, and
  `--font-label`;
- geometry: `--content-width`, `--measure`, `--space-section`, and `--radius`.

Reuse these established roles where their semantics fit. Do not duplicate their
literal values in component styles. This inventory is partial rather than a
complete expression of the supplied project direction.

## Project visual direction

- Use a serif role for display and heading typography, and a sans-serif role for
  interface and body typography. Small uppercase labels, eyebrows, and control
  text use the interface family with deliberate weight, tracking, and casing.
- The reference palette identifies primary blue `#1A56DB`, signal orange
  `#F4A016`, stack teal `#0D9488`, and neutral stone `#E3E2E4`. Treat these as
  project-level semantic directions, not literals to copy into each component.
- Favor light neutral page backgrounds, bordered white surfaces, restrained
  rounded corners, and consistent button and control treatments.
- Keep typography roles semantic: display/heading, interface/body, and
  label/eyebrow/control. Do not hard-code `Georgia`, `Times New Roman`, or another
  font stack inside a block unless the project token layer explicitly defines it.
- When the same display heading has distinct mobile and desktop sizes, prefer a
  rem-bounded fluid value between the documented endpoints unless the design
  calls for a deliberate breakpoint change. Do not make all headings fluid by
  default, and avoid viewport-only sizing without accessible bounds.
- Reuse established spacing, border, surface, radius, and shadow conventions.
  Add a project token only when it represents a repeated, named design decision.

## Decision process

1. Inspect `:root`, shared theme styles, and relevant existing components before
   choosing any visual value.
2. Use the closest established token when its role is appropriate; consume it
   through a CSS custom property rather than an unrelated utility class.
3. If the supplied design does not define a value, do not create a new token or
   literal solely to approximate a screenshot. Report a genuinely unresolved
   decision when no established value is suitable.
4. For fluid typography, record the minimum and maximum sizes and the viewport
   range across which they interpolate. A bounded `clamp()` is the usual
   implementation, not a requirement when another approach preserves the same
   behavior.
5. If a repeated missing role is confirmed, extend the project-level token layer
   first, then consume that token from components. Keep fallback values narrowly
   scoped for portability and aligned with the project token's meaning.
6. Use the same project typography and color roles in editor styles where
   practical so Gutenberg does not present a conflicting visual system.

## Recommended typography-scale follow-up

The theme defines font-family roles but not a semantic type-size scale. If
multiple components confirm the same display, section-heading, body, or label
size ranges, consider promoting those repeated decisions into project-level
tokens. Do not create a shared fluid-size token from one component or force
unrelated heading roles onto the same interpolation curve.

## Review checklist

- No arbitrary visual value was introduced where a project token applies.
- Typography and colors reference semantic project roles.
- Component CSS owns layout and behavior without competing visual foundations.
- Fluid display sizes preserve documented rem-based endpoints and scale through
  the intended intermediate range without an accidental breakpoint jump.
- Frontend and editor styling use compatible tokens.
- New tokens represent reusable decisions rather than screenshot approximations.
- Unresolved design choices are reported explicitly.
