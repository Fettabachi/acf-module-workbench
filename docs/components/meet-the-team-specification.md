# Meet the Team specification

## Purpose

Introduce a curated group of people with enough structured information to scan roles, optionally visit profiles, and narrow a modest collection by department.

## Content model

- Optional eyebrow, introduction, and careers link.
- Required section heading with H2, H3, or H4 choice.
- Optional department filter with editable visible and all-results labels.
- One to sixteen ordered members.
- Required member name; optional portrait, role, department, short biography, and profile link.

## Rendering rules

- Do not render the frontend block without a section heading and one named member.
- Omit optional content and invalid image attachments.
- Derive unique, alphabetized department options from non-empty member values.
- Keep departments available to the filter without displaying them as card badges.
- Reveal filtering only when enabled, JavaScript is available, and at least two departments exist.
- When biography content is present, enhance the underlined member-name button to open an absolutely positioned, internally scrollable panel from the top of the card.
- Move focus to the close control when a panel opens; support Escape; return focus to the member name when it closes.
- Leave biography content inline when JavaScript is unavailable.
- When a profile URL and biography are both present, render the profile action inside the panel. Without a biography, link the member name directly.
- Use the heading level immediately below the section heading for member names.

## Responsive behavior

- One column below 36rem.
- Two columns from 36rem.
- Four columns and a horizontal intro/CTA composition from 58rem.
- Portraits maintain a stable near-square crop with `object-fit: cover`.

## Host dependencies

The host supplies ACF repeater, image, link, text, textarea, button-group, tab, and true/false fields; WordPress Media Library image markup; the outer aligned-block width; and the documented semantic typography, color, border, surface, focus, spacing, and radius tokens. The module owns its internal layout, progressively enhanced biography panels, focus management, progressive filter, fallback values, motion preferences, and responsive behavior.
