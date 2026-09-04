# Filtered Content Grid

## Overview

The Filtered Content Grid lets visitors narrow a larger post collection by category without leaving the page.

## Component contract

Editors provide section copy, result limits, and the categories available to the collection. Published WordPress posts supply the card content.

## Implementation decisions

- WordPress queries remain the source of truth for available content.
- Lightweight JavaScript progressively enhances the category controls.
- All cards remain visible when JavaScript is unavailable.
- Module-scoped data attributes and classes keep multiple instances independent.

## Accessibility and defensive behavior

Filter controls expose their selected state, remain keyboard operable, and announce meaningful result changes. Missing post metadata is handled without empty interface elements.

## Validation

The grid was reviewed with several category combinations, no matching results, keyboard input, disabled JavaScript, and narrow through wide layouts. Query behavior, PHP syntax, and editor controls were checked.

## Tradeoffs and future improvements

Client-side filtering is intentionally suited to a bounded result set. Larger archives should use server-side filtering, pagination, or a dedicated search experience.

## Source

- [Component package](../../parts/modules/filtered-content-grid/)
- [Component specification](filtered-content-grid-specification.md)
