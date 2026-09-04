# Open Positions Specification

## Why this component

Agency sites commonly include a careers page while recruiting teams manage
openings in an applicant-tracking system. Re-entering the same role in WordPress
creates stale listings and unnecessary coordination. This component reads the
published Greenhouse job board so recruiting remains the source of truth and the
agency can present current roles in its own visual system.

## Goal

Build a portable `acf/open-positions` block that retrieves published jobs from
the public Greenhouse Job Board API, presents them as accessible role links, and
remains useful when the provider is empty or temporarily unavailable.

## Content and integration contract

- A heading and syntactically valid public Greenhouse board token are required
  for frontend output. Eyebrow and introduction are optional.
- Editors may set a one-to-twelve display limit, a shared role-link label, and a
  visitor-facing message for an empty or unavailable board.
- The provider origin and request path are fixed in code. Editors cannot supply
  an arbitrary endpoint, and the public GET integration requires no API key.
- Requests run on the WordPress server through the safe HTTP API. No visitor
  browser calls Greenhouse, no provider payload is exposed as JSON, and no
  JavaScript is required.
- The lightweight jobs endpoint supplies the job ID, title, location, and
  canonical application URL. Full job descriptions are intentionally excluded.
- Response objects are normalized into the module's own small data shape. Jobs
  without an ID, title, or valid HTTPS application URL are omitted.
- A successful result is cached for 15 minutes and retained for up to 24 hours as
  stale fallback data. Provider failures back off for five minutes so repeated
  page views do not create a request storm.
- If the provider is unavailable and no validated cache exists, visitors see the
  authored empty-state message. Editors also see a concise diagnostic note that
  does not expose raw provider details.

## Markup and accessibility contract

- The section is labelled by an allowlisted `h2`, `h3`, or `h4`; role headings
  use the next level.
- Every role is one conventional link with a clear title, optional location,
  and shared visible action label. The whole card is the link, avoiding nested or
  competing interactive controls.
- Editor-preview links are inert. Frontend links preserve the canonical provider
  URL and same-tab browser behavior.
- Optional text and location markup are omitted when empty. Missing required
  configuration produces editor guidance but no empty frontend shell.
- Long titles, locations, and action labels wrap without horizontal overflow.
  Focus remains visible and reduced-motion preferences remove hover transitions.

## Responsive and design-system contract

- The host supplies the outer content width and documented semantic typography,
  color, surface, border, focus, and radius roles.
- The module owns its internal spacing, header measure, role-card stack, narrow
  layout, hover/focus treatment, empty state, and responsive behavior.
- Role cards use restrained white surfaces within a subtle page-colored section.
  At narrow widths, the action drops below the role metadata to preserve readable
  line lengths and touch targets.

## Validation targets

- Parse block metadata and ACF Local JSON; run PHP syntax checks and
  `git diff --check`.
- Confirm the public API response matches the normalized title, location, and
  HTTPS application-link assumptions and remains below the response-size cap.
- Test valid, malformed, missing, empty, oversized, and provider-error
  responses; verify fresh cache, stale fallback, and failure backoff behavior.
- Inspect frontend and editor output at mobile, intermediate, and desktop widths,
  including long content, keyboard focus, empty data, and overflow.
- Verify no credential, raw endpoint field, generic utility class, page ID,
  domain-specific content, or browser-side API request is introduced.
