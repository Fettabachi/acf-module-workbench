# Timeline / Milestones

## Overview

Timeline / Milestones adapts the supplied Synkra changelog into a portable
ordered-story module. It supports product releases, company history, project
phases, roadmaps, and other sequences whose entries need dated metadata and
categorized supporting notes.

## Component contract

Editors provide a required section heading, optional eyebrow and introduction,
and an ordered collection of entries. Each complete entry requires a marker
label and title, accepts either an exact date or a free-form period, and may be
highlighted. Entry badges may omit their icon or select one from a constrained
portable set. Entries contain one or more content groups; each group has a
label, semantic tone, optional summary, and optional repeated notes. Notes
inherit their group's semantic icon by default and support a small set of
purposeful overrides. The editor-only script permits only one highlighted entry
at a time.

The tabbed expanded editor is the primary authoring surface. Entry and group
repeaters use readable block layouts, collapsed-row summaries, and scoped Expand
all and Collapse all controls. The note editor uses a readable stacked layout
and intentionally omits ineffective collapse controls. Duplicate Gutenberg
sidebar fields remain hidden.

## Implementation decisions

- The section is an ordered list because authored entry order carries meaning.
- Desktop alternation is presentational. Metadata always precedes its card in
  the document, and mobile presents that same order beside a left-hand spine.
- Each entry draws its own line segment toward the next entry, so the timeline
  grows naturally with long content and stops at the final marker.
- Exact dates render with a machine-readable `datetime` value. Free-form periods
  support ranges and approximate eras without pretending they are exact dates.
- Exact-date normalization accepts both ACF's compact `Ymd` storage value and
  the field's configured `Y-m-d` return value, then emits one canonical form.
- Brand, success, danger, and neutral tones map to project semantic colors and
  exact exported Figma icon silhouettes. Badge and note overrides use a small
  bundled library; editors cannot choose arbitrary colors or upload decorative
  icons.
- Figma's fixed mobile widths, no-wrap text, and fixed line endpoint were not
  reproduced because they clipped valid content and broke content-driven sizing.

## Accessibility and defensive behavior

The labelled section permits `h2` through `h4`; entry and group headings descend
from the selected level without skipping hierarchy. Decorative icons, markers,
and line segments remain absent from the accessibility tree. Text wraps at every
level, exact dates use native time semantics, and chronological reading order is
unchanged by desktop alternation. Incomplete entries, groups, notes, dates, and
optional introductory content are omitted without empty wrappers.

## Validation

Block registration, metadata, ACF Local JSON, PHP syntax, escaping, nested
repeater behavior, exclusive highlighting, expanded-editor controls, responsive
layout, long content, empty-data combinations, exact dates, periods, and
multiple instances are checked. Responsive QA covers narrow, intermediate, and
wide layouts, including both sides of the desktop breakpoint. The saved-editor
date path is checked against ACF's compact storage format and canonical frontend
`datetime` output.

## Tradeoffs and future improvements

Nested repeaters add editorial depth, so the expanded editor and collapse tools
for substantial rows are part of the component contract. Semantic defaults and
constrained icon choices intentionally provide fewer visual options than a
general icon picker. A future host could map those same roles to different
project tokens without changing the content model.

## Source

- [Component package](../../parts/modules/timeline-milestones/)
- [Component specification](timeline-milestones-specification.md)
