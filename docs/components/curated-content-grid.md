# Curated Content Grid

## Overview

The Curated Content Grid gives editors direct control over which posts appear and the order in which they are presented.

## Component contract

Editors provide optional section copy and choose an ordered set of published posts. Each selected post remains the source of truth for its title, image, excerpt, date, categories, and URL.

## Implementation decisions

- A relationship field supports intentional selection and ordering without duplicating post content.
- Invalid, unavailable, and duplicate selections are discarded before rendering.
- Cards derive consistent summaries from authored excerpts with a safe fallback.
- The grid adapts to its available width and does not assume a page-specific container.

## Accessibility and defensive behavior

Cards use semantic article structure and descriptive linked titles. Missing images, excerpts, or terms do not leave broken controls or empty wrappers.

## Validation

The component was reviewed with reordered content, missing media, long titles, incomplete metadata, and unpublished selections across desktop, tablet, and mobile layouts. Editor selection behavior and PHP syntax were checked.

## Tradeoffs and future improvements

Manual curation provides editorial control but requires ongoing maintenance. Collections governed primarily by taxonomy or recency are better served by the Filtered Content Grid.

## Source

- [Component package](../../parts/modules/curated-content-grid/)
- [Component specification](curated-content-grid-specification.md)
