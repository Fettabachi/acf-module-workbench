# Meet the Team

## Overview

Meet the Team presents an editor-curated group of people in a responsive portrait grid. Expandable biographies, optional profile links, and progressive department filtering support both a concise team introduction and a small directory without requiring a custom post type.

## Component contract

Editors provide section copy, heading hierarchy, an optional careers link, filter labels, and one to sixteen team members. Each member requires a name and may include a portrait, role, department, short biography, and profile link. Repeating a department name creates one shared filter option; department values support filtering without appearing as decorative card badges.

## Implementation decisions

- A repeater keeps the module portable and lets editors deliberately select and order a bounded group without depending on a site-specific people post type.
- The responsive composition preserves the Figma design's editorial hierarchy, portrait-led cards, and compact recruitment action while using the host theme's semantic tokens. Department badges are intentionally omitted so roles remain the card's primary professional context.
- A native select is revealed by JavaScript only when filtering is enabled and at least two departments are represented. Filtering reuses the Filtered Content Grid's card-rearrangement transition, with an opacity fallback and an immediate reduced-motion path.
- When JavaScript is available, either the portrait or underlined member name opens a biography panel that slides from the top of the card and scrolls internally when its content exceeds the card height.
- The panel includes an explicit close control, supports Escape, returns focus to the portrait or name that opened it, and closes automatically if filtering hides its card.
- Without JavaScript, biography content remains visible inline. When an authored profile link and biography both exist, the profile action appears inside the biography panel; without a biography, the member name links directly to the profile.

## Accessibility and defensive behavior

The section and each card use a meaningful heading hierarchy. The filter has a persistent visible label, announces updated result counts, and marks the grid busy while cards rearrange. Portrait and name biography triggers expose expanded state and panel relationships, move focus to the close control, close with Escape, and restore focus to the control that opened the panel. Panel and filter motion respect reduced-motion preferences, while biographies remain inline without JavaScript. All members remain visible without JavaScript. Media Library alternative text is preserved, focus is visible, and optional or invalid values are omitted without leaving empty wrappers.

## Validation

The component is reviewed with linked and unlinked members, present and missing biographies, repeated and missing departments, missing portraits and roles, long labels, keyboard filtering and disclosure use, JavaScript disabled, reduced motion, multiple responsive widths, and the expanded ACF editor. PHP syntax, metadata, and source formatting are checked.

## Tradeoffs and future improvements

The bounded repeater is appropriate for a curated small-to-medium team. A large organization with shared biographies, archives, or many reuse points should replace the row source with a dedicated person content type and department taxonomy while retaining the normalized card presentation.

## Source

- [Component package](../../parts/modules/meet-the-team/)
- [Component specification](meet-the-team-specification.md)
