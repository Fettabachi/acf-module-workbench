# Feature Cards

## Overview

Feature Cards organizes a concise set of related benefits or capabilities into a responsive, scannable collection.

## Component contract

Editors can add section-level introductory copy and a repeatable set of cards. Each card contains purposeful editorial fields rather than open-ended layout controls.

## Implementation decisions

- A single repeater keeps card content and order predictable in the editor.
- CSS Grid adapts the collection from one column to wider multi-column layouts.
- Cards use equal-height layout behavior without forcing fixed content heights.
- Module-scoped classes and styles keep the package portable.

## Accessibility and defensive behavior

Semantic headings preserve the relationship between the section and its cards. Links receive visible focus treatment, and optional values disappear without leaving empty elements.

## Validation

The component was reviewed with short, long, and incomplete card content across desktop, tablet, and mobile widths. Keyboard focus, heading structure, PHP syntax, and editor usability were checked.

## Tradeoffs and future improvements

The component favors a restrained content model over per-card styling options. New variants should be driven by a repeatable editorial requirement rather than one-off presentation needs.

## Source

- [Component package](../../parts/modules/feature-cards/)
