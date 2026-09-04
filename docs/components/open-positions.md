# Open Positions

## Overview

Open Positions keeps a branded careers page synchronized with a public Greenhouse job board. It demonstrates a practical third-party API use case for an agency-built website.

## Component contract

Editors provide section copy, the public Greenhouse board token, a result limit, a shared role-link label, and an empty-state message. The integration uses public board data and requires no API key.

## Implementation decisions

- The request runs server-side so validation, caching, and failure handling remain centralized.
- Only the fields needed by the presentation are requested and retained.
- Successful responses are cached for 15 minutes, with a validated stale copy available during temporary provider outages.
- Short failure backoff prevents a broken endpoint from being requested on every page view.
- URLs and response shapes are validated before any provider data reaches the template.

## Accessibility and defensive behavior

Jobs render as a semantic list with descriptive links and visible focus states. Missing optional metadata is omitted, and a clear authored message appears when no usable roles are available.

## Validation

The component was reviewed with a live public board, cached results, empty and malformed responses, unavailable providers, long role titles, keyboard navigation, and desktop through mobile layouts. PHP syntax and editor presentation were checked.

## Tradeoffs and future improvements

This implementation targets Greenhouse's public job-board endpoint. Supporting another recruiting platform should use a small provider adapter while preserving the component's normalized job data and presentation contract.

## Source

- [Component package](../../parts/modules/open-positions/)
- [Component specification](open-positions-specification.md)
