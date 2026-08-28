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

- color roles: `--color-text`, `--color-muted`, `--color-surface`,
  `--color-surface-subtle`, `--color-accent`, and `--color-border`;
- typography: `--font-sans` only;
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
4. If a repeated missing role is confirmed, extend the project-level token layer
   first, then consume that token from components. Keep fallback values narrowly
   scoped for portability and aligned with the project token's meaning.
5. Use the same project typography and color roles in editor styles where
   practical so Gutenberg does not present a conflicting visual system.

## Recommended minimal token-layer follow-up

The theme does not yet define semantic display/body/label font roles or the four
reference palette roles. A future focused infrastructure change should consider:

- `--font-display`, `--font-body`, and `--font-label`;
- `--color-primary`, `--color-signal`, `--color-stack`, and `--color-neutral`;
- aliases or clarified roles for the existing page background, white surface,
  border, radius, and control styles.

Resolve actual font availability and whether existing `--color-accent` maps to a
new semantic role before assigning or migrating values. Do not silently replace
existing tokens or refactor component CSS as part of unrelated exercise work.

## Review checklist

- No arbitrary visual value was introduced where a project token applies.
- Typography and colors reference semantic project roles.
- Component CSS owns layout and behavior without competing visual foundations.
- Frontend and editor styling use compatible tokens.
- New tokens represent reusable decisions rather than screenshot approximations.
- Unresolved design choices are reported explicitly.
