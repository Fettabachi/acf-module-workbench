# Curated Content Grid

## Overview

The Curated Content Grid gives editors direct control over which posts appear and the order in which they are presented.

## Component contract

Editors provide optional section copy and choose an ordered set of published posts. Each selected post remains the source of truth for its title, image, excerpt, author, date, categories, content-derived reading time, and URL.

## Implementation decisions

- A relationship field supports intentional selection and ordering without duplicating post content.
- Invalid, unavailable, and duplicate selections are discarded before rendering.
- The card composition follows the supplied Synkra article-card references: inset media, text-only category labels, serif titles, restrained summaries, and compact author metadata.
- Reading time is estimated from the post body at 200 words per minute with a one-minute minimum.
- Author initials are derived from the display name. A stable author-ID mapping assigns one of three design-system badge palettes consistently across both post grids.
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
