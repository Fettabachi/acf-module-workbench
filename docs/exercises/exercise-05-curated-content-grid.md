# Exercise 05 — Curated Content Grid

## Design source

This exercise uses the original component contract in
`exercise-05-curated-content-grid-spec.md`. It extends the practice series into
manually curated WordPress content while retaining the established portable ACF
module and project design-system conventions.

## Goal

Build a portable `acf/curated-content-grid` block that lets editors select and
order published posts, keeps the selected posts as the source of truth for card
content, and handles optional or malformed post data without broken markup or
layout.

## PR-style summary

Built a portable Curated Content Grid ACF block with a required section title,
optional introduction, shared section heading-level control, and an unlimited
published-post relationship field with search, taxonomy filtering, and manual
ordering. A compact Manage posts launcher opens the real ACF relationship field
in an accessible modal, where the selected pane becomes a numbered, readable
list with a live count and explicit Move up, Move down, and Remove controls while
retaining optional drag ordering.

The renderer normalizes IDs and `WP_Post` values, removes duplicates, preserves
the first selected order, rejects missing, unsupported, private, draft, and
malformed selections, and returns no markup
without a title and at least one valid published post. Cards derive their title,
permalink, categories, authored excerpt, date, and featured image from WordPress
instead of duplicating that content in block fields.

Scoped, mobile-first styling produces one, two, and three columns at component-
driven breakpoints; equal-height cards within each row; balanced one- and two-
card collections; consistent responsive image crops; a generic decorative
placeholder for missing featured images in multi-column layouts; compact
image-free cards in the single-column layout; clean excerpt-free variants;
defensive wrapping; and a single stretched title link
with visible focus and hover treatment. The module adds no JavaScript, generic
host utility classes, nested outer container, post IDs, URLs, or fixture
dependencies on the frontend. Its editor-only JavaScript improves the ACF
selection workflow without changing stored relationship values.

### Files changed

- `acf-json/group_curated_content_grid.json`
- `inc/blocks.php`
- `parts/modules/curated-content-grid/block.json`
- `parts/modules/curated-content-grid/curated-content-grid.php`
- `parts/modules/curated-content-grid/curated-content-grid.css`
- `parts/modules/curated-content-grid/curated-content-grid-editor.css`
- `parts/modules/curated-content-grid/curated-content-grid-editor.js`
- `parts/modules/curated-content-grid/curated-content-grid-editor.asset.php`
- `docs/exercises/exercise-05-curated-content-grid-spec.md`
- `docs/exercises/exercise-05-curated-content-grid.md`
- `docs/exercises/README.md`
- `docs/exercises/fixtures/exercise-05/README.md`
- `docs/exercises/fixtures/exercise-05/manage.php`

## Content and interaction decisions

- The block is a manual curation tool, not a latest-post query. The relationship
  field stores selected post identities and order, while the posts remain the
  source of truth for display content.
- The relationship field has no arbitrary maximum. Editors can build the
  collection the page needs, while a query-driven archive remains the better
  pattern when automatic recency, filtering, or pagination is required.
- Only published standard posts render. A selection that later becomes private,
  draft, deleted, or another post type disappears safely rather than exposing
  content that is not publicly available.
- Authored excerpts render exactly when present. The block does not generate an
  unpredictable fallback from body content, and excerpt-free cards collapse the
  missing region.
- All assigned categories render as visible metadata. Multi-category meaning is
  preserved rather than arbitrarily choosing one term.
- Each card has one title link. Its pseudo-element enlarges the activation area
  to the card without introducing duplicate image and “read more” links with the
  same destination.
- The section heading allows `h2`, `h3`, or `h4`; card headings reliably use the
  following level (`h3`, `h4`, or `h5`).

## Editor UX decisions

- Authenticated editor evidence showed that ACF's default two-pane relationship
  interface collapsed into two approximately 125–130px lists in Gutenberg's
  sidebar. Long titles, thumbnails, scrolling, and small drag targets made even
  a five-post selection difficult to scan and reorder.
- The field therefore keeps ACF's relationship data model, AJAX search,
  taxonomy filter, validation limits, and native sorting while changing only
  its block-scoped editor presentation and controls.
- The narrow sidebar now contains only a Manage posts button and live count. It
  opens the real ACF control in a native modal, giving search, filters, available
  posts, and selected posts materially more working space without introducing a
  second source of saved data.
- Available rows hide thumbnails so titles get the full width. The selected list
  also hides thumbnails, numbers every item, shows the current count, and
  provides explicit Move up and Move down buttons. Dragging remains available
  for editors who prefer it.
- Selected-row hover retains dark text on a white surface. Every control has a
  stable bordered footprint; move controls invert to the admin accent on hover,
  and Remove rests as red-on-white before reversing to solid WordPress danger
  red on hover without changing position.
- Move controls change the existing hidden-input order and dispatch the same
  field change event used by ACF. The implementation maintains one source of
  truth and survives relationship-list and block-field replacement.
- Endpoint controls are disabled, every move and remove control has a post-
  specific accessible name, focus remains on the activated move button, and
  the live count announces selection changes.
- Remove remains ACF's native relationship control so ACF owns removal, value
  changes, and DOM updates. The enhancement preserves its behavior hooks while
  adding a post-specific accessible name and narrowly scoped positioning and
  visual states.
- The native dialog supplies keyboard focus containment and Escape-to-close.
  The explicit close button and backdrop also dismiss it, and focus returns to
  the Manage posts launcher.
- The search query clears on every dismissal path so reopening starts with the
  complete Available Posts list; selected posts and ordering are unaffected.
- Editor-preview card anchors omit `href` and the editor stylesheet removes the
  stretched pseudo-element. Cards therefore select the block instead of loading
  a selected post inside Gutenberg's iframe, while frontend links remain fully
  interactive.

## Portability and design-system decisions

The host owns the available `alignwide` width and outer gutters. The component
fills that space and owns only its header, grid, card, media, metadata, and
responsive behavior. It has no ancestor-class, page-template, URL, post-ID,
sample-content, or frontend-script dependency.

The CSS consumes semantic project roles for text, muted text, surface, subtle
surface, border, accent, body type, display type, label type, measure, and
radius. Component-scoped fallbacks keep the server-rendered Gutenberg preview
legible if frontend root variables are absent. No new project-level token or
competing visual system was introduced.

The responsive thresholds are based on minimum useful card width: one column
below 40rem, two columns from 40rem, and three columns from 64rem. A single card
uses the shared readable measure, while exactly two cards stay in a capped
two-column composition at wide widths.

## Accessibility and responsive QA

- The rendered section is labelled by its visible heading, the card collection
  is a semantic list, and each article is labelled by its linked heading.
- The eight fixture posts produced eight articles and eight unique title links,
  six responsive images with authored alt text, seven authored excerpts, twelve
  category tags across single- and multi-category cases, and valid publication
  time elements.
- The deliberate missing-image cases use decorative placeholders with the same
  media ratio as featured images in multi-column layouts and omit the placeholder
  media region in the single-column layout. The missing-excerpt case omits its
  wrapper, and the long title wraps without horizontal overflow.
- At 390px and 639px the grid contained one card per row. At 640px and 1023px it
  contained two equal-width cards per row. At 1024px and 1440px it contained
  three equal-width cards per full row.
- At every measured width, cards sharing a row had equal computed heights. The
  grid and document reported no horizontal overflow.
- All six images loaded at 390px with nonzero natural width and preserved Media
  Library alt text.
- Keyboard focus on a title link produced a visible 3px accent outline plus a
  card border/shadow treatment. The stretched pseudo-element covered the card.
- Measured excerpt contrast was 5.45:1 and category-label contrast was 6.69:1.
- The exact QA page produced no browser warnings or errors. Its temporary,
  read-only file was removed after testing.

## Validation

- PHP syntax checks passed for block registration and the template.
- Block metadata and ACF Local JSON parsed successfully.
- A live WordPress runtime check confirmed the block, stylesheet, and one ACF
  field group are registered.
- The supplied fixture verification passed with eight published posts, six
  featured images, seven authored excerpts, one long-title case, and three
  fixture categories.
- Live server rendering originally confirmed eight cards, eight links, six
  featured images, seven excerpt regions, the long title, and a labelled
  section. The missing-image revision adds equal-ratio decorative placeholders
  for the other two cards where the grid has multiple columns.
- The current six-card page renders six equal media regions: four responsive
  featured images and two decorative placeholders in the multi-column layout;
  the two placeholder regions are omitted when the cards stack in one column.
  Editor-only assets remain absent from the frontend response.
- A malformed-data matrix confirmed duplicate removal, first-occurrence order,
  rejection of a selected page and nonexistent ID, fallback from an invalid
  heading choice to `h2`/`h3`, and empty output for an invalid-only or untitled
  block.
- The relationship field group loaded from Local JSON with the expected field
  type, post/status constraints, search and taxonomy filters, ID return format,
  and required-without-an-arbitrary-maximum constraints.
- JavaScript syntax, editor asset PHP syntax, and block/field JSON parsing
  passed. An earlier live WordPress runtime check registered the editor script
  and style handles; the current editor-interaction revision advances the block
  and editor script metadata to version `1.2.10`.
- `git diff --check` passed during implementation and final review.

### Editor review outcome

The supplied authenticated Gutenberg screenshot resolved the previously
missing editor checkpoint and exposed a failed usability assumption: the
default relationship control was not practical in the block sidebar. The
resulting editor-only correction preserves the existing relationship values and
now presents the control in a modal with non-drag ordering controls, restrained
hover states, stable bordered actions, and more readable available rows. The
final authenticated-editor review confirmed that the native Remove control,
move controls, modal, ordering workflow, and visual states work together without
replacing ACF's removal behavior.

## Final assessment

**Verdict: Pass — ready for review.** No blocking security, accessibility,
responsive, portability, data-integrity, or editor-workflow findings remain.

| Area | Result | Evidence |
| --- | --- | --- |
| Requirements and content model | Pass | Purposeful ACF fields, unlimited ordered selection, and source-post ownership match the specification. |
| Defensive rendering and security | Pass | Invalid, duplicate, unpublished, unsupported, deleted, untitled, and empty values fail safely; output is escaped by context. |
| Semantics and accessibility | Pass | Labelled section, semantic list/articles, ordered heading hierarchy, preserved image alt text, visible focus, named controls, and keyboard-capable modal behavior. |
| Responsive presentation | Pass | Component-owned one/two/three-column behavior, defensive wrapping, equal-height rows, reduced motion, and responsive missing-image treatment. |
| Editor experience | Pass | Authenticated review confirmed the modal workflow, search reset, readable lists, native removal, non-drag ordering, stable controls, and selection count. |
| Portability and design system | Pass | Module-scoped markup/assets, semantic token consumption with fallbacks, no page IDs/URLs/ancestor selectors, and no nested page-shell constraint. |
| Validation and maintainability | Pass | PHP/JavaScript/JSON checks, runtime registration, fixture verification, render checks, and `git diff --check` pass; the ACF markup dependency is documented. |

The remaining missing-image concern is a documented design tradeoff rather than
a defect: placeholders preserve rhythm in multi-column layouts and disappear in
the single-column layout. A stronger solution would require an explicit
editorial featured-image policy or a separate fallback-media contract.

## Implementation commit

`84f7df5` — Add curated content grid block

## Timing

| Phase | Active time |
| --- | --- |
| Requirements, existing-pattern review, and specification | ~15 min |
| Field model, rendering, and styling | ~20 min |
| Runtime, defensive, responsive, and accessibility QA | ~20 min |
| Documentation and final review | ~10 min |
| Authenticated editor review and editor-UX correction | ~25 min |
| Modal, unlimited selection, native-control corrections, and missing-image revision | ~50 min |
| **Approximate total** | **~140 min** |

## Tradeoffs and deferred improvements

- Manual selection intentionally does not refresh itself as new content is
  published. A separate query-driven block would be more appropriate if recency
  becomes the product requirement.
- Cards use the source post's default featured-image crop. A focal-point or
  alternate-card-image field is deferred until real editorial use demonstrates
  that the source crop is insufficient.
- Missing images remain an editorial compromise: a neutral decorative
  placeholder preserves multi-column rhythm and disappears in the single-column
  layout, while enforcing featured images or sourcing a separate fallback asset
  would require a broader publishing rule or media contract.
- All categories are visible. Posts with many categories can make the metadata
  region tall; the supported exercise content remains clear, and an arbitrary
  renderer-side term limit would hide meaning.
- The enhancement intentionally targets ACF's documented relationship-field
  structure. A future ACF markup change may require a small editor-only update;
  saved values and frontend rendering remain independent of that interface.
- Native `<dialog>` support is used for the pop-out. Browsers without that API
  retain the improved relationship control inline rather than losing access to
  the field.

## Bottlenecks

- The exercise fixture defined edge cases but not the component contract, so the
  content, interaction, and responsive decisions needed to be specified before
  implementation.
- The local WordPress command-line runtime required the site's bundled PHP and
  local database socket rather than the system PHP defaults.
- The initial browser review lacked an authenticated editor session, allowing a
  narrow-sidebar interaction problem to survive until the supplied screenshot
  made the real editing conditions visible.
- Replacing or over-customizing ACF's native Remove control caused avoidable
  regressions. Preserving its behavior hooks and overriding only its cosmetic
  classes and scoped presentation produced the reliable result.

## Lessons for the next exercise

- For curated content, store identity and order in the module while keeping the
  source post responsible for its own title, excerpt, taxonomy, media, and URL.
- Validate publication status again at render time because a valid selection can
  change after the block is saved.
- Include duplicate, deleted, unsupported-type, unpublished, large-collection,
  and missing-optional-data states in the first rendering matrix.
- A stretched single link can provide a generous card hit area without adding
  duplicate destinations, provided its focus treatment and stacking behavior
  are tested explicitly.
- ACF's dual-pane relationship field is not inherently usable inside a narrow
  Gutenberg sidebar. Test its real width early, move complex management into a
  focused modal when appropriate, and provide non-drag ordering controls whenever
  manual order is part of the content contract.
- Preserve native ACF action elements and behavior hooks when restyling complex
  fields. Add controls only for missing behavior, and prefer narrowly scoped
  cosmetic overrides to replacing working native interactions.
- Consider promoting the source-record ownership rule and curated-selection
  defensive matrix into the local ACF module skill if another relationship-
  driven module confirms that the guidance is broadly reusable.
