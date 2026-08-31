# Exercise 03 — Accessible Accordion Specification

## Phase boundary

This document defines the requirements and implementation contract for a
portable `acf/accordion` block. This phase does not include implementation,
sample content, database changes, updates to the completed-exercises index, or
commits. The existing LocalWP post at ID 59 is reserved for later QA and must
not be modified during this phase.

## Design sources

- `accordion-desktop.png`
- `accordion-mobile.png`
- `exercise 03 Accordion Notes.rtf`

The screenshots are the visual reference. The RTF supplies measurements and
observations, but does not override this specification, `AGENTS.md`, or the
local module and design-system guidance.

## Goal

Build a portable `acf/accordion` block that closely reflects the supplied
desktop and mobile compositions. The block must provide native, independently
operable disclosures; CSS-only, content-driven opening and closing animation;
an editor-friendly ACF model; responsive and accessible presentation; and
useful parity in Gutenberg preview.

## Component classification and interaction model

This is a fully interactive disclosure component, not navigation. Each item is
a native `<details>` element with a `<summary>` control.

- Each item opens and closes independently.
- Multiple items may be open simultaneously; this is not a mutually exclusive
  accordion.
- The entire summary row is the interactive target.
- Keyboard, touch, and pointer interaction remains native. No frontend
  JavaScript may intercept or recreate disclosure behavior.
- A decorative chevron communicates the current state without becoming a
  separate control or accessible name.
- Any rows marked **Open by default** render with the Boolean `open` attribute.
  Open state is item data, so it remains attached to the same row when editors
  reorder repeater rows.

## Content model

Create one ACF Local JSON field group for `acf/accordion`, located by block
name and named consistently with `group_accordion.json`.

| Field | ACF type | Requirement | Contract |
| --- | --- | --- | --- |
| Section title | Text | Required | Plain text. The block does not render normally without it. |
| Subtitle | Text | Optional | Plain text. Omit its element when empty. |
| Section heading level | Button group | Required | Allow only `h2`, `h3`, or `h4`; default to `h2`. This applies only to the section title. |
| Accordion items | Repeater | Required | Minimum 2 with no arbitrary maximum; use `block` layout for constrained Gutenberg widths. |
| Question | Text | Required per row | Plain text; use this field as the repeater's collapsed-row label. |
| Answer | WYSIWYG | Required per row | Use the Basic toolbar, no media upload, and a deliberately constrained editing experience. |
| Open by default | True/false | Optional per row | Default off; the value travels with the row when reordered. |

Field names and keys must use an accordion-specific namespace. The repeater
instructions should tell editors that items operate independently, multiple
items may be open, and rows can be collapsed before dragging. A `block` layout
is preferred over `table`: the question, rich answer, and toggle must remain
usable in Gutenberg with the settings sidebar open. If authenticated QA shows
that `row` is clearer at the actual canvas width, it may be chosen instead, but
`table` is out of contract.

Do not expose controls for color, spacing, typography, animation duration,
icons, width, alignment beyond supported block alignment, or other internal
layout choices.

## Markup and heading hierarchy

The intended DOM is:

```html
<section class="accordion" aria-labelledby="accordion-heading-[unique]">
  <header class="accordion__header">
    <h2|h3|h4 id="accordion-heading-[unique]">Section title</h2|h3|h4>
    <p>Optional subtitle</p>
  </header>
  <div class="accordion__items">
    <details class="accordion__item" open>
      <summary class="accordion__summary">
        <span class="accordion__question">Question</span>
        <svg aria-hidden="true" focusable="false">...</svg>
      </summary>
      <div class="accordion__answer-region">
        <div class="accordion__answer-inner">
          <div class="accordion__answer">Permitted rich HTML</div>
        </div>
      </div>
    </details>
  </div>
</section>
```

The actual wrapper must include `get_block_wrapper_attributes()` and retain any
user-supplied anchor supported by block metadata. Generate a unique title ID
per instance with a WordPress helper; do not use row indexes or fixed IDs as
cross-instance identifiers.

The section title is the block's heading and uses the allowlisted shared level.
Questions are summary control labels, not additional headings. This avoids
inventing a repeated heading hierarchy while retaining native disclosure
semantics and descriptive accessible names. Do not add redundant roles,
`aria-expanded`, or scripted button semantics to `<summary>`.

## Required, optional, empty, and malformed data

Treat all ACF values as potentially absent or malformed, including required
fields.

- Trim section title, subtitle, and questions before testing or rendering.
- Allowlist the heading level; use `h2` when stored data is invalid.
- Normalize the repeater to an array and process every complete row; do not
  silently truncate otherwise valid editor content.
- Discard a row if its question is empty or its answer has no meaningful text
  after tags are stripped. Never render an empty `<details>`, `<summary>`, or
  answer wrapper.
- Render nothing when the required section title is empty or when no complete
  item survives normalization. This avoids an anonymous section or an empty
  interactive shell.
- ACF enforces the two-row editorial minimum. If malformed legacy data leaves
  only one complete row, render that useful row defensively rather than hiding
  valid content.
- Omit the subtitle element when it is empty.
- Treat only a normalized truthy per-row value as `open`; never output
  `open="false"`, because Boolean attributes are true by presence.

## Sanitization and escaping

- Escape section title, subtitle, and question with `esc_html()`.
- Allowlist the heading tag before interpolating it; do not trust a stored tag
  name merely because the ACF UI constrains it.
- Sanitize answer output with `wp_kses_post()`. Do not echo raw WYSIWYG HTML and
  do not execute shortcodes implicitly.
- Use `esc_attr()` for IDs, classes, and attribute values.
- Output WordPress-generated block wrapper attributes using the established
  documented exception pattern after passing only controlled class data.
- Keep the Basic toolbar and disabled media upload as editor constraints, while
  treating server-side KSES as the actual output safety boundary.

## Animation and progressive behavior

The implementation must animate variable-height answers in both directions
without JavaScript, fixed heights, or content-specific `max-height` values.

1. Keep native `<details>/<summary>` as the behavioral base.
2. In a feature query for `details::details-content`, make the native details
   content box a one-row grid.
3. Use `grid-template-rows: 0fr` for the closed state and `1fr` for
   `details[open]`.
4. Keep the grid child shrinkable and overflow-hidden.
5. Transition `grid-template-rows` and use a discrete `content-visibility`
   transition so the content remains renderable until closing motion finishes;
   transition the decorative chevron's orientation at the same time.
6. Confirm repeated opening and closing—not only the first toggle—and native
   closed disclosure semantics in the supported enhancement.

When interpolated grid-row animation is unsupported, do not apply the override:
native `<details>` must still open and close immediately. This is the required
progressive fallback. Under `prefers-reduced-motion: reduce`, remove the answer
and chevron transitions while preserving the open/closed state and native
interaction.

The transition duration and easing are implementation details, not editor
controls. Because the references do not specify them, choose a restrained
component-local value during visual QA rather than presenting it as a supplied
measurement or creating a project token without broader evidence.

## Visual contract and token mapping

### Recorded reference observations

- The parent supplies the section background; the block itself has no
  background declaration. The title and subtitle remain centered.
- Desktop section title: approximately `36px / 1.3`, display/serif role.
- Mobile section title: approximately `28px / 1.2`, display/serif role.
- Subtitle: approximately `16px / 1.75`, body/sans role.
- Desktop question: approximately `18px / 1.5`, bold.
- Mobile question: approximately `16px / 1.75`, bold.
- Mobile answer: approximately `14px / 1.75`.
- Item gap and internal padding are each approximately `20px`.
- Item corner radius is approximately `12px`.
- The reference border is `#E4E3DF`.
- An open summary uses the neutral border color as its background, and an open
  item receives a restrained shadow.
- The chevron is decorative and changes direction with state.
- Mobile text wraps naturally and retains comfortable touch targets.

### Project-token decisions

Use semantic project variables with accordion-scoped fallbacks where editor
preview may not inherit the frontend root:

- `--color-surface` for item and answer surfaces;
- `--color-text` and `--color-muted` for primary and secondary copy;
- `--color-border` for item borders;
- `--color-neutral` for the open-summary surface;
- an exercise-specific generic serif family for the section title and
  `--font-body` for controls and answer content;
- `--radius` for the established corner-radius role.

Do not repeat the screenshot's color literal in component CSS where those roles
apply. Do not create an accordion-specific palette, spacing, radius, or shadow
system. The exercise explicitly requires a serif title even though the current
project display token resolves to sans, so the component may use the generic
`serif` family without introducing an unapproved font asset. The current
`--radius` is smaller than the approximately 12px reference; retain the project
role unless a reusable larger-radius decision is approved.

## Focus, target size, and input behavior

- The summary's full padded row must be clickable and have a minimum block size
  of 44px, exceeding WCAG 2.2 AA's minimum while providing a comfortable touch
  target.
- Preserve a clearly visible `:focus-visible` treatment on the complete summary
  row. It may consume the project accent color but must remain visible against
  closed, open, and focused-open surfaces without clipping at rounded corners.
- Remove or neutralize the native marker only when the supplied decorative
  chevron is present; do not leave two state indicators.
- Suppress Chrome's touch tap-highlight overlay on the summary so it does not
  flash blue before the designed open or closed surface appears. Preserve the
  explicit keyboard `:focus-visible` treatment.
- Keep the chevron out of the accessibility tree and pointer targeting.
- Verify Space and Enter behavior, touch activation, pointer activation, rapid
  repeated toggling, and focus retention after state changes.

## Width and host-theme dependency contract

The block should default to and support only `alignwide`, consistent with the
existing modules. The host theme owns the available outer width and page
gutters through its block alignment contract. For this exercise, the accordion
section fills the available width up to an explicit `1000px` maximum and
centers itself within the host area. Implement the cap as `62.5rem` at the
project's root size. Do not add `.container` or a second set of outer gutters.

The `1000px` cap is an exercise-specific component contract, not evidence for a
new project-wide width token.

The module inherits its background from the parent and owns its `1000px`
section cap, vertical section padding, centered header treatment, item stack,
internal padding, gap, borders, radius, shadow, answer measure, and responsive
changes. A modest component-internal text measure for the centered
heading/subtitle is acceptable because it controls readability.

Documented host dependencies are:

- WordPress 6.6+ block metadata and wrapper APIs;
- PHP 7.4+;
- ACF Pro block, repeater, true/false, and WYSIWYG field support;
- centralized metadata registration in `inc/blocks.php`;
- the host's `alignwide` width/gutter contract;
- semantic design tokens from `assets/css/theme.css`, with essential scoped
  fallbacks for Gutenberg and portability.

The module must not depend on post ID 59, a page template, URL, database sample
content, generic host utility classes, page-specific ancestors, global
JavaScript, or a particular neighboring block.

## Responsive strategy

Start mobile-first. Natural wrapping, generous summary padding, 16px questions,
14px answers, and a single full-width item stack are the base. Increase title
typography fluidly from the documented 28px/1.2 mobile endpoint at 390px to the
36px/1.3 desktop endpoint at 768px, using rem bounds so neither font size nor
leading depends on the viewport alone. Increase question typography only when
the component's available width supports the desktop density. Use the fewest
media queries necessary and choose any discrete change point from the
component's wrapping and spacing behavior, not a named device.

The title's font size and changing leading must not remain at their mobile
values and then jump directly to their desktop values at the threshold. Bounded
`clamp()` values are the expected implementation, but the acceptance
requirement is the smooth interpolation and preserved endpoints, not a
particular CSS function.

`48rem` is the initial candidate because it matches the existing module
convention, but it is not authoritative. During implementation QA, test just
below, at, and just above the candidate with long questions and the editor
sidebar open; move the threshold if the component evidence requires it. Do not
use viewport-specific fixed heights or text widths.

## Frontend and Gutenberg stylesheet strategy

- Keep the complete structural and visual stylesheet with the module and load
  it via `block.json` `style` so the frontend and server-rendered editor preview
  share the same namespaced rules.
- Use component-scoped token fallbacks for essential rendering in Gutenberg,
  where frontend root variables and ancestor rules may be absent.
- Add a small `editorStyle` only if ACF field-form usability requires it, such
  as keeping the repeater collapse affordance visible and keyboard focused.
  Never restyle Gutenberg globally.
- No JavaScript is planned for the frontend or editor. Per-row open state does
  not need the exclusivity enforcement used by Feature Cards.
- Preview mode must represent heading level, optional subtitle, valid rows,
  rich answers, default-open states, chevron state, wrapping, and multiple open
  items. Field editing must remain practical with the settings sidebar open.

## Edge cases and QA scenarios

- Short, long, multi-paragraph, list-based, emphasized, and linked answers.
- Very long questions, including questions wrapping to three or more lines.
- Long unbroken question text, link text, and URLs; use defensive wrapping so
  none creates horizontal overflow.
- Exactly two, nine, and a larger practical row count; valid rows must not be
  truncated.
- No default-open row, one default-open row, and several default-open rows.
- Several items opened at once and rapid repeated toggling while an animation
  is in progress.
- Multiple block instances on one page, with unique associations and no state
  or selector leakage.
- Keyboard, touch, pointer, focus-visible, zoom/reflow, forced wrapping, and
  reduced-motion behavior.
- Gutenberg repeater collapse, expansion, drag reordering, row identity by
  question, WYSIWYG editing, and default-open retention with the settings
  sidebar both open and closed.
- Progressive native disclosure when the animation enhancement is unavailable.

## Implementation plan

1. **Requirements:** Reconfirm this contract, authoritative sources, host width,
   token mappings, and unresolved visual measurements.
2. **ACF model:** Add portable Local JSON with the required/optional rules,
   a two-item minimum with no arbitrary maximum, block-style repeater, collapsed question label,
   Basic WYSIWYG, and per-row default-open toggle.
3. **Markup:** Register block metadata and render normalized, escaped native
   `<details>/<summary>` markup with a valid section heading hierarchy.
4. **Styling:** Add namespaced mobile-first styles, semantic tokens, complete-row
   summary targeting, state surfaces, grid-row animation, chevron treatment,
   focus, and reduced motion.
5. **Responsive behavior:** Tune typography and spacing at a component-evidenced
   threshold without duplicating host gutters or fixed content heights.
6. **Editor parity:** Share module styles in preview and add only narrowly scoped
   field-form CSS if authenticated Gutenberg QA demonstrates a need.
7. **Accessibility:** Verify native semantics, heading order, accessible names,
   focus visibility, target size, contrast, keyboard operation, reduced motion,
   zoom/reflow, and rich-content links.
8. **QA:** Validate data boundaries, malformed data, multiple instances and open
   items, animation interruption, frontend breakpoints, editor sidebar states,
   PHP/JSON syntax, `git diff --check`, and the existing LocalWP QA page without
   coupling the module to it.

## Validation matrix

| Context | Representative width | Required checks |
| --- | --- | --- |
| Mobile | 390px and narrower reflow case | Natural title/question wrapping; 44px+ summary target; 14px answer role; no overflow from rich text or URLs; open/close animation; multiple open items; touch, keyboard, focus, and reduced motion. |
| Intermediate | Between 390px and 768px, plus immediately below/at/above the chosen discrete threshold | Smooth title interpolation without an abrupt size jump, clipping, or doubled gutters; long questions; nine or more rows; interrupted transitions; editor preview and repeater with settings sidebar open. |
| Desktop | 1440px viewport within host `alignwide` area | Section centered at a computed 1000px maximum; centered header; approximately 36px title and 18px questions; full-width summary target; open surface and restrained shadow; multiple instances; short/long/rich answers; screenshot comparison. |

All contexts also require contrast review, 200% zoom/reflow, valid source order,
unique heading associations, default-open persistence after reorder, unsupported
animation fallback, and no console/PHP errors.

## Known assumptions and unresolved questions

- The exact desktop answer font size and line height are not supplied. Mobile is
  approximately `14px / 1.75`; desktop must be measured or approved during
  implementation rather than guessed here.
- The exact open-item shadow is unknown. It should remain restrained and must be
  measured or visually approved before being recorded as authoritative.
- The exercise resolves the section width at a `1000px` maximum. Exact vertical
  section padding remains a responsive implementation judgment.
- The visual reference suggests approximately 12px corners, while the current
  semantic `--radius` token is 8px. This specification favors the established
  role unless a genuinely reusable project-level radius decision is approved.
- The exercise explicitly requires a serif title. Use the generic `serif`
  family until an approved project display-font asset is established.
- The chevron will be a controlled decorative inline SVG derived from the
  supplied visual treatment; exact stroke, size, and rotation need visual QA.
- Animation duration and easing are not specified and require restrained visual
  tuning, rapid-toggle testing, and reduced-motion verification.
- Native disclosure behavior is the baseline. The exact browser support floor
  for interpolated grid rows must be confirmed during implementation so the
  `@supports` enhancement does not weaken fallback behavior.

## Definition of Done

Implementation is done only when:

- `acf/accordion` is registered through metadata and all module files and ACF
  JSON are portable, namespaced, and free of page-specific coupling;
- the field model enforces a required title, optional subtitle, allowlisted
  heading level, a minimum of two rows with no arbitrary maximum, required question/basic rich answer, and a
  reorder-safe per-row default-open toggle;
- valid native `<details>/<summary>` markup is normalized, escaped, sanitized,
  and free of empty interactive elements;
- independent and simultaneous open states work with keyboard, touch, and
  pointer input;
- both opening and closing animate with the `0fr`/`1fr` grid technique without
  frontend JavaScript, fixed heights, or content-specific maximum heights;
- reduced-motion and unsupported-animation fallbacks preserve reliable native
  disclosure;
- frontend and Gutenberg preview closely reflect the supplied compositions at
  mobile, intermediate, and desktop widths, including the centered 1000px
  section cap and fluid 28px-to-36px title, without duplicated host gutters;
- focus visibility, target size, contrast, heading hierarchy, wrapping, rich
  answers, nine or more rows, rapid toggling, multiple instances, and malformed data
  pass QA;
- changed PHP and JSON pass syntax checks, relevant project checks pass, and
  `git diff --check` is clean;
- Exercise 03's completed record and index entry are added only after the later
  implementation and QA phase, with its implementation commit and evidence.

## Specification timing

**Active time spent:** approximately 15 minutes (timeboxed requirements and
specification phase).
