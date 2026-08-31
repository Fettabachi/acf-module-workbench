# Exercise 04 — Tabbed Content

## Design source

This exercise uses the component contract in
`exercise-04-tabbed-content-spec.md` and adapts the **Hops Farm Tabbed Widget**
published in Designmodo's *Tabbed Widgets in Web Design* gallery. The reference
supplies the atmospheric background, colored tab rail, selected-tab pointer,
layered white panel, split content composition, and strong marketing hierarchy.

## Goal

Build a portable `acf/tabbed-content` block with an editor-friendly content
model, an accessible automatically activating tab interface, complete
responsive behavior, and a readable all-panels fallback when JavaScript is not
available.

## PR-style summary

Built a portable Tabbed Content ACF block with a required section title,
optional introduction and atmospheric background image, shared section heading
level, and an unbounded block-layout repeater containing concise labels,
optional panel headings, Basic rich content, and optional complete CTA links.
The renderer discards incomplete data, requires two complete rows for meaningful
tab behavior, sanitizes rich content, creates unique tab/panel relationships,
and nests optional panel headings one level below the selected section heading.

The progressive frontend starts with hidden controls and every labelled panel
visible. JavaScript enhances complete instances into an ARIA tab interface
with roving focus, automatic activation, click support, Arrow key wraparound,
Home and End navigation, and one visible panel. The client-facing composition
uses a dark image treatment, orange tab rail, blue selected state and pointer,
elevated white panel, editorial/graphic split, and a numbered stage motif.
Scoped mobile-first styling uses project semantic roles, preserves a 56px tab
height, wraps tabs into a deterministic two-column mobile grid, lets an odd
final tab span both columns, contains intrinsic width to prevent page overflow,
stacks the panel on narrow screens, and removes nonessential transition motion
when requested.

### Files changed

- `acf-json/group_tabbed_content.json`
- `inc/blocks.php`
- `parts/modules/tabbed-content/block.json`
- `parts/modules/tabbed-content/tabbed-content.php`
- `parts/modules/tabbed-content/tabbed-content.css`
- `parts/modules/tabbed-content/tabbed-content-editor.css`
- `parts/modules/tabbed-content/tabbed-content-editor.js`
- `parts/modules/tabbed-content/tabbed-content-editor.asset.php`
- `parts/modules/tabbed-content/tabbed-content.js`
- `docs/exercises/exercise-04-tabbed-content-spec.md`
- `docs/exercises/exercise-04-tabbed-content.md`
- `docs/exercises/README.md`

## Content and interaction decisions

- Two complete rows are the minimum meaningful tab set. ACF enforces the
  authoring minimum and PHP omits malformed instances that fall below it.
- All complete rows render; there is no arbitrary maximum or renderer-side
  truncation.
- Tab label is the repeater's collapsed-row identity. Panel headings are
  optional and render as `h3`, `h4`, or `h5` according to the section level.
- The section background image is optional and rendered decoratively beneath a
  strong overlay. Without it, the component retains a project-color gradient.
- CTA output requires both a title and URL. New-window links receive
  `noopener noreferrer`; incomplete link data produces no wrapper.
- Each valid row receives a decorative stage number based on its current order,
  so reordering updates the visual sequence without storing incidental data.
- Automatic activation is appropriate because switching panels is immediate
  and local. Left/Right Arrow, Home, and End both move focus and selection.
- The first valid tab is initially selected. Exactly one tab remains in the
  page tab sequence.
- Without JavaScript, controls remain hidden and all panels appear with visible
  labels. No content depends on an inoperable interface.
- JavaScript is registered for both frontend and editor contexts. The editor
  asset has an explicit version so browser caching cannot retain stale behavior.
- A dedicated editor script observes both the editor shell and Gutenberg's
  same-origin canvas document, enhances newly rendered ACF previews, and
  captures pointer and keyboard tab input before Gutenberg consumes it. Its
  progressive fallback leaves all panels visible rather than hiding every panel
  except an inoperable first selection.

## Portability and design-system decisions

The host owns the available `alignwide` area and outer gutters. The component
adds no generic container, fixed site width, page-specific ancestor selector,
URL, post ID, or database assumption. Its namespace owns only internal
geometry and behavior.

The CSS consumes semantic text, muted text, surface, subtle surface, border,
accent, primary blue, signal orange, stack teal, body type, display type, label
type, measure, content width, and radius roles. Component-scoped fallbacks
support Gutenberg when frontend root variables are unavailable. No new project
tokens or competing palette were introduced.

`contain: inline-size` prevents the tab grid's intrinsic width from expanding a
grid ancestor. This keeps the portable component inside whatever normal width
the host provides without selecting or modifying a page-specific ancestor.

## Accessibility and responsive QA

- The labelled section, tablist, tabs, and tabpanels have unique and matched
  accessible relationships.
- Click selection, Right Arrow, End, and wrapped Right Arrow were exercised in
  sequence; selection, focus, and visible-panel state remained synchronized.
- The implementation also handles Left Arrow and Home through the same tested
  index-selection path.
- At 390px, four 163px controls formed a two-column, two-row grid inside the
  326px widget. The tab list and document had no horizontal overflow; pointer
  activation selected and focused Improve while retaining one visible panel.
- At 505px, four 216px controls formed two equal rows instead of the previous
  three-plus-one arrangement, with no horizontal overflow.
- At 767px the panel remained one column; at 768px it changed to a measured
  `309.688px / 240px` editorial/graphic split without horizontal overflow.
- At 1440px, the component occupied the host's 1152px content area and retained
  exactly one visible panel. The inner widget measured 1056px with a
  `587.25px / 282.75px` panel split.
- The selected indicator, keyboard focus treatment, long labels, optional
  panel heading, rich text, decorative background, numbered graphic, and a
  panel without its optional heading were visually represented in browser QA.
- At 1440px the 790px module title fit on one line within its 1056px header.
  `text-wrap: balance` remains active for viewports where wrapping is required.
- The selected marker computed as a transparent-sided triangle with a blue top
  border, pointing downward into the content panel.
- Editor-script QA loaded the script in a parent editor shell and rendered the
  component inside a separate same-origin canvas frame. Pointer selection and
  the Home key switched panels while preserving focus, selection, and exactly
  one visible panel.
- With the script omitted, both fixture panels and their fallback labels were
  visible while the tablist remained hidden.
- Live frontend QA reported no warnings or errors.

## Validation

- PHP syntax checks passed for registration and the template.
- Block metadata and ACF Local JSON parsed successfully.
- JavaScript syntax validation passed.
- A live WordPress registration check confirmed the frontend and editor scripts
  are assigned to their respective block handles.
- A live WordPress runtime check confirmed page 65 renders four tabs, four
  panels, four stage graphics, and Media Library attachment 11 as its decorative
  background.
- Runtime rendering confirmed empty CTA omission, complete CTA output, safe
  `target="_blank"` relationship attributes, and no unsafe script output.
- `git diff --check` passed before final review.

### Editor review outcome

Authenticated review initially exposed that the editor script did not reach
Gutenberg's iframe-based canvas. The correction now observes the editor shell
and same-origin canvas documents, survives simulated ACF preview replacement,
and uses an explicitly versioned asset to prevent stale browser caching. The
revised editor and deterministic mobile grid were accepted during final review.

## Implementation commit

`80f7821` — Add tabbed content ACF block

## Timing

| Phase | Active time |
| --- | --- |
| Requirements and specification | ~10 min |
| Content model, rendering, styling, and interaction | ~25 min |
| Runtime, responsive, accessibility, and fallback QA | ~20 min |
| Documentation and final review | ~10 min |
| Client-ready visual redesign and field expansion | ~35 min |
| Redesign browser, runtime, and responsive QA | ~20 min |
| Editor iframe correction and mobile-grid refinement | ~20 min |
| **Approximate total** | **~140 min** |

## Tradeoffs and deferred improvements

- The mobile tab grid favors persistent visibility over horizontal scrolling.
  Very large tab counts will create additional rows; editors should keep labels
  concise and use tabs only for a reasonably small set of peer topics.
- Selection does not update the URL or persist across reloads because the
  component contract does not define deep linking or state restoration.
- The current art direction uses one section-level image and portable numbered
  panel graphics. Per-panel media should be added only if a future content
  contract requires every tab to own distinct editorial imagery.
- Editor interactivity relies on Gutenberg retaining a same-origin canvas. If a
  future editor embeds the preview cross-origin, the component intentionally
  falls back to showing every labelled panel rather than hiding content.

## Lessons for the next exercise

- Define the no-JavaScript content order before adding ARIA state; progressive
  enhancement is much easier when all content begins readable.
- Treat the ACF preview refresh lifecycle as part of interactive block design,
  not as a frontend-only afterthought.
- A horizontal tab strip needs explicit narrow-screen overflow behavior even
  when the supplied labels are initially short.
- Test editor interaction inside Gutenberg's iframe-shaped document from the
  first pass and version custom editor assets so fixes cannot be masked by a
  stale browser cache.
