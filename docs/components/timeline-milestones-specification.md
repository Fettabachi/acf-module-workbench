# Timeline / Milestones specification

## Objective

Build a portable `acf/timeline-milestones` block that adapts the supplied Synkra
desktop and mobile changelog frames into the Workbench design system. Preserve
the section introduction, ordered markers, highlighted current state,
alternating desktop composition, categorized note cards, and single-flow mobile
layout without coupling the block to product releases.

## Content model

- Optional eyebrow and introduction with a required section heading.
- `h2`, `h3`, or `h4` hierarchy control.
- One or more ordered entries containing:
  - Required marker label and title.
  - Optional badge icon selected from the bundled component library.
  - Optional date context.
  - Either an optional exact date or optional free-form period.
  - Optional exclusive highlighted state.
  - One or more content groups.
- Content groups contain a required label, semantic tone, optional summary, and
  optional repeated notes. Notes inherit the group icon or choose a purposeful
  bundled override.

Expose these controls through ACF Block Version 3's expanded editor. Group the
form under Introduction and Timeline Entries tabs, hide duplicate sidebar
fields, use block-layout repeaters with collapsed summaries for entries and
groups, and provide Expand all and Collapse all controls for those substantial
rows. Keep the note repeater readable and free of ineffective collapse
controls.

## Structure and behavior

Use a labelled `section` and ordered list. Derive entry and group heading levels
from the selected section heading. Preserve metadata-before-card source order.
Alternate the two content columns at the desktop breakpoint, then collapse all
entries into the same marker, metadata, and card sequence on narrow screens.
Build line segments from each non-final entry rather than sizing one absolute
line against current content. The frontend requires no JavaScript.

## Visual contract

Use the design's badge-led introduction, bounded 56px-to-80px display heading,
short primary rule, dashed timeline, round markers, italic milestone headings,
neutral cards, white highlighted card, and semantic note groups. Consume project
typography, primary, stack, success, danger, neutral, surface, border, spacing,
and radius roles through component-scoped variables with portable fallbacks.
Use exact exported Figma silhouettes for decorative icons. Do not expose
arbitrary color, icon, width, spacing, alignment, or type-size controls.

## Accessibility and QA

- Keep authored and semantic order stable at every width.
- Use `<time datetime>` for exact dates and plain text for periods.
- Verify exact dates after an editor save, including ACF's compact `Ymd` storage
  format and canonical `Y-m-d` frontend output.
- Hide markers, connecting lines, and icon silhouettes from assistive technology.
- Prevent clipping and horizontal overflow from long titles, labels, and notes.
- Omit incomplete entries, groups, notes, dates, and optional section content.
- Verify one highlighted entry at a time in the editor.
- Verify keyboard focus for collapse controls and useful collapsed-row labels.
- Test zero optional fields, long content, multiple groups, many entries, exact
  dates, periods, multiple instances, and narrow through wide layouts.
- Verify frontend rendering, editor recognition, expanded-editor metadata, PHP
  syntax, ACF Local JSON, local assets, and clean diffs.
