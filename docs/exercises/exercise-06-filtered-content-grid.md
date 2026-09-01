# Exercise 06 — Filtered Content Grid

## Design source

This exercise uses the original component contract in
`exercise-06-filtered-content-grid-spec.md`, based on the empty WordPress page
created for Exercise 06 and the site's existing published-post fixtures.

## Goal

Build a portable, query-driven ACF block whose recent-post collection can be
filtered by represented categories while remaining complete without JavaScript.

## PR-style summary

Added a Filtered Content Grid ACF block with a required title, optional
introduction, semantic heading-level choice, bounded result count, and optional
category scope. The renderer validates editor input, queries newest published
posts, derives card data and useful filter choices from WordPress, and returns
cleanly when required content is unavailable.

Added progressively enhanced category buttons with native pressed states and a
polite result count. All results remain visible when scripting is unavailable.
Scoped mobile-first styles provide accessible controls, one/two/three-column
layouts, defensive card variants, visible focus, and reduced-motion behavior.

Follow-up editor QA added a useful default title, an editor-only incomplete
preview, and support for one or two requested posts without ACF validation
errors. Filtering now uses stable card identities with the View Transitions API,
matching the portfolio implementation's smooth spatial rearrangement; a short
opacity fallback covers older browsers, and reduced-motion users get an
immediate update.

## Implementation commit

`6e3109e` — Add filtered content grid block

## Timing breakdown

- Requirements and repository/content inspection: 25 minutes
- Content model, rendering, and interaction: 65 minutes
- Styling and responsive implementation: 40 minutes
- Documentation, QA, and review: 45 minutes

## Key decisions and tradeoffs

- This is an automatic latest-post query, clearly separated from manual curation.
- Category scope and post count are purposeful editor controls; card data and
  presentation remain owned by posts and the design system.
- Filters are buttons rather than tabs and are revealed only after successful
  enhancement. This avoids presenting inert controls without JavaScript.
- Filtering is client-side and intentionally bounded at 24 posts. Pagination,
  URL-addressable filter state, and remote/AJAX loading are deferred because
  they would create a different archive-level contract.
- Cards show all assigned categories as metadata, while available filter choices
  honor the editor's selected category scope.

## Portability and accessibility

The block depends only on standard posts, the built-in category taxonomy,
WordPress media/date/link APIs, ACF fields, and documented project semantic
tokens with component-scoped fallbacks. It has no page ID, URL, generic host
utility class, database fixture, or ancestor-selector dependency.

The section is visibly labelled, results are a semantic list of articles,
filter state uses native buttons and `aria-pressed`, changes announce through a
polite status, and hidden cards use the native `hidden` state. Focus styles,
touch target sizing, wrapping, and reduced motion are component-owned.

## Validation

- PHP syntax passed for block registration, the renderer, and the script asset
  metadata. Block metadata and ACF Local JSON parsed successfully, JavaScript
  syntax passed, and `git diff --check` reported no whitespace errors.
- The live local WordPress runtime registered `acf/filtered-content-grid` and
  one matching five-field ACF group.
- A server-rendered matrix confirmed nine newest posts for an unscoped query;
  six posts for the Design/Technology scope; three Strategy posts; five unscoped
  filter buttons; three scoped filter buttons; duplicate and invalid-term
  rejection; `h2`/`h3` fallback for an invalid heading; post-count clamping; and
  empty output for an empty title.
- The focused QA scope produced eight fixture cards, with filter counts of four
  Design, three Strategy, and five Technology posts. Filtering to Design hid
  the other four cards, left one pressed button, announced “Showing 4 articles,”
  retained focus on the activated control, and showed a 3px focus outline.
- At 390px and 639px, cards used one column. At 640px and 1023px, they used two
  equal-height columns. At 1024px, they used three equal-height columns. No
  tested viewport had horizontal document overflow, and filter controls measured
  at least 44px high.
- The base response contained every result card, kept controls initially hidden,
  and included the enhancement script. The editor-preview rendering produced
  eight disabled links without destinations and removes the stretched overlay.
  The browser console reported no warnings or errors.
- Authenticated Gutenberg screenshots exposed and guided fixes for the initially
  invisible blank-title preview, insertion-time title validation, one- and
  two-post validation, narrow two-column field layout, and mismatched number
  input suffix height. Follow-up editor review confirmed the final full-width
  fields and unified number control presentation.
- Follow-up runtime checks confirmed the default title, a minimum and step of
  one, correct one- and two-card output, nine queried cards plus guidance in a
  blank-title editor preview, and empty frontend output for that same incomplete
  state. Browser follow-up confirmed eight unique card transition identities,
  a busy/disabled filter state during animation, four Design results afterward,
  correct pressed state and status copy, no overflow, and no console warnings or
  errors. The available browser exercised the opacity fallback; supported
  browsers use the equivalent View Transitions path.

## Deferred improvements

- Add pagination or URL-backed filtering only if the component becomes a true
  archive with more than 24 results.
- Consider a reusable project-level content-card primitive only after another
  module confirms the same card contract.

## Lesson for the next exercise

Document progressive-enhancement visibility as part of the interaction contract:
controls should not be shown until their behavior is available, while the base
content remains useful on its own.
