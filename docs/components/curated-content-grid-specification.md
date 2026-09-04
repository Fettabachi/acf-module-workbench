# Curated Content Grid Specification

## Design source

This is an original component brief rather than a screenshot
translation. It extends the practice series from editor-authored module content
into a portable block that presents deliberately selected WordPress posts while
retaining the established project design system and defensive ACF conventions.

## Goal

Build a portable `acf/curated-content-grid` block that lets an editor choose and
order a collection of published posts. The frontend must preserve that
manual order, derive card content from each selected post, adapt cleanly when
optional post data is missing, and remain useful at narrow, intermediate, and
wide widths without JavaScript.

## Content and interaction contract

The component is a collection of linked editorial summaries.

- A required section title introduces the collection.
- An optional introduction provides one short supporting paragraph.
- Editors choose the section heading level so the module can fit the host
  page's hierarchy.
- A relationship field selects and orders published posts without imposing an
  arbitrary maximum. Selection is manual; the block never silently substitutes
  a latest-posts query.
- Card titles, permalinks, publication dates, categories, authored excerpts,
  and featured images come from the selected posts. Editors update that source
  content in WordPress rather than duplicating it in block fields.
- Each card has one explicit title link. A stretched hit area may make the card
  easier to activate visually, but the accessible link name and destination
  remain the post title. No duplicate image or “read more” link is added.
- There is no filtering, pagination, load-more behavior, or client-side script.

The post order in the relationship field is the frontend order. Drafts,
private posts, unsupported post types, deleted selections, and malformed values
are ignored at render time. The block does not render when its title is empty or
no valid published posts remain.

## ACF content model

| Field | ACF type | Requirement | Contract |
| --- | --- | --- | --- |
| Section title | Text | Required | Plain text; the block does not render without it. |
| Introduction | Textarea | Optional | One short supporting paragraph, limited to 300 characters. |
| Section heading level | Button group | Required | Allow `h2`, `h3`, or `h4`; default `h2`. |
| Curated posts | Relationship | Required | One or more published posts, ordered manually; return post IDs. |

Do not expose post-title, excerpt, category, date, image, card-color, column,
spacing, crop, or interaction controls. Those values either belong to the
selected post or are module/design-system decisions.

## Rendering and data handling

- Treat all ACF values and referenced posts as potentially absent or malformed.
- Allowlist the section heading level and fall back to `h2`. Card titles render
  one level below it as `h3`, `h4`, or `h5`.
- Normalize relationship values that arrive as IDs or `WP_Post` objects, remove
  duplicates while retaining the first occurrence, and preserve manual order.
- Render only published posts of the `post` post type.
- Use `get_permalink()` for the destination and omit a card if no safe permalink
  can be resolved.
- Render authored excerpts only. Do not manufacture an excerpt from post body
  content when the dedicated excerpt is empty.
- Render all assigned categories in a semantic list, omitting the list when no
  valid terms exist.
- Render publication time with a machine-readable `datetime` value and the
  site's configured date format.
- Render featured images with `wp_get_attachment_image()` so responsive sources
  and Media Library alt text are preserved. When no valid featured image exists,
  render a decorative generic placeholder in multi-column layouts so mixed
  collections retain a consistent card rhythm; omit that placeholder media
  region when cards stack in one column.
- Escape plain text, attributes, URLs, and generated class names by context.

## Semantics and accessibility

- Render the component as a `<section>` labelled by its visible heading.
- Render the collection as a semantic list and each item as an `<article>`
  associated with its linked heading.
- Preserve DOM and visual order.
- Give the title link a clear visible `:focus-visible` state and at least a
  44px practical activation area through the card treatment.
- Use category text and the publication date as visible metadata; meaning must
  not rely on color or imagery.
- Preserve authored attachment alt text. Do not derive alt text from titles or
  filenames, and do not render an empty media placeholder as meaningful content.
- Long titles, category names, and unbroken excerpt text must wrap without
  causing horizontal page overflow.

## Layout and design-system contract

The host theme owns the `alignwide` area and outer page gutters. The module fills
that available width and adds no generic container or second outer width
constraint.

The grid is mobile first: one column at narrow widths, two columns when cards
have sufficient room, and three columns at wide widths. A single card uses a
readable measure, while a two-card collection shares the full available width
in two columns. Both remain visually balanced without fixed card heights. Cards
in a shared row stretch naturally to equal height, while excerpt-free cards collapse
their missing text region. Cards without featured images use the same media
ratio through a decorative placeholder only where multiple columns make that
shared rhythm useful.

The module consumes project semantic roles for text, muted text, surface,
subtle surface, border, accent, body type, display type, label type, radius, and
section spacing. Component-scoped fallbacks support Gutenberg when frontend
root variables are absent. Internal grid geometry and the card composition
belong to the module.

## Editor contract

- New blocks open in edit mode so required fields are immediately available.
- The sidebar shows a compact Manage posts launcher and current selection count.
  The launcher opens the real ACF relationship field in an accessible modal so
  the settings are not constrained to the narrow Gutenberg sidebar.
- The modal keeps post search and taxonomy filtering, gives the available and
  selected panes useful side-by-side space, and stacks them at narrow viewport
  widths.
- Available rows omit thumbnails so post titles receive the full row width.
- The selected pane presents numbered rows, a live selection count, readable
  titles, and explicit Move up, Move down, and Remove controls. Drag ordering
  remains available as an optional shortcut, not the only ordering method.
- The concise field instructions explain selection and ordering without
  repeating the source-content model.
- The modal supports its native keyboard focus boundary and Escape behavior,
  closes from its explicit button or backdrop, and returns focus to the launcher.
- Search is transient modal state and clears whenever the modal closes; selected
  posts and their order remain unchanged.
- The server-rendered preview uses the same template and stylesheet as the
  frontend. Module-scoped editor assets enhance only the relationship field and
  do not alter saved data or surrounding Gutenberg controls.
- Card links remain visible as anchors in the editor preview but omit their
  destinations and stretched overlays there. Clicking a preview card selects the
  block instead of navigating Gutenberg's editor iframe; frontend links retain
  their normal destinations and full-card activation areas.

## Validation targets

- Parse block metadata and ACF Local JSON.
- Run PHP syntax checks.
- Verify empty, malformed, duplicate, unsupported, unpublished, and deleted
  relationship values.
- Verify manual ordering with one, eight, and more than eight valid posts.
- Verify add, remove, Move up, Move down, drag, endpoint-disabled controls,
  selection count, keyboard focus retention, preview order, and saved order in
  the real Gutenberg editor modal.
- Verify clicking every card region in the editor preview selects the block and
  never navigates the editor iframe to the selected post.
- Verify modal launch, explicit close, Escape, backdrop close, focus placement,
  focus containment, focus return, search reset, and narrow-viewport stacking.
- Verify missing excerpt, the responsive missing-image treatment, no categories,
  multiple categories, authored image alt text, and a very long title.
- Inspect narrow, breakpoint-adjacent, intermediate, and wide layouts for
  wrapping, equal-height rows, image crops, and horizontal overflow.
- Verify heading hierarchy, list/article semantics, link focus, enlarged card
  hit area, date markup, and contrast.
- Review frontend and editor output, then run `git diff --check`.
