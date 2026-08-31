# Exercise 03 — Accessible Accordion

## Design source

The implementation follows the supplied desktop and mobile Accordion
screenshots and the accompanying RTF measurements. The accepted contract is
recorded in `exercise-03-accordion-spec.md`. The visual targets include a light
neutral section, centered title and subtitle, six bordered disclosure rows,
one reference item open by default, responsive typography, and a decorative
state chevron.

## Goal

Build a portable `acf/accordion` block with a constrained editor model, native
independent disclosure behavior, CSS-only content-driven animation, responsive
styling, accessible interaction, and useful Gutenberg preview parity.

## PR-style summary

Built a portable Accessible Accordion ACF block with a minimum of two block-layout
repeater rows, a shared section heading level, optional subtitle, Basic
WYSIWYG answers, and a reorder-safe per-row default-open state. Native
`<details>` and `<summary>` elements preserve browser interaction while scoped
CSS animates variable-height answers between `0fr` and `1fr`, rotates the
decorative chevron, and removes nonessential transitions for reduced motion.

The module uses shared project tokens with editor-safe fallbacks, accepts the
host theme's `alignwide` area and centers an exercise-specific 1000px section
within it, scales the title fluidly between its documented mobile and desktop
typography, avoids frontend JavaScript, and defensively normalizes malformed
data. Authenticated LocalWP QA populated page 59 with the reference title,
subtitle, questions, one default-open item, and complete answer content.

### Files changed

- `acf-json/group_accordion.json`
- `inc/blocks.php`
- `parts/modules/accordion/block.json`
- `parts/modules/accordion/accordion.php`
- `parts/modules/accordion/accordion.css`
- `parts/modules/accordion/accordion-editor.css`
- `docs/exercises/exercise-03-accordion-spec.md`
- `docs/exercises/exercise-03-accordion.md`
- `docs/exercises/README.md`
- `.agents/skills/acf-module-development/SKILL.md`
- `.agents/skills/apply-project-design-system/SKILL.md`

## ACF content model

- Required section title
- Optional subtitle
- Shared section heading level: `h2`, `h3`, or `h4`, default `h2`
- Required Accordion Items repeater using block layout, minimum two with no
  arbitrary maximum
- Required plain-text question used as the collapsed-row label
- Required Basic WYSIWYG answer with media upload disabled
- Per-row Open by Default toggle, default off

The model exposes no arbitrary color, typography, spacing, icon, animation,
width, or internal layout controls.

## Interaction and rendering decisions

- Every item is an independent native `<details>` disclosure with the complete
  `<summary>` row as its target. Multiple rows may remain open.
- Open-by-default state is stored within each repeater row rather than by row
  number, so the state travels with its question and answer when reordered.
- The native `::details-content` box uses an enhanced `0fr`/`1fr` grid-row
  transition with discrete `content-visibility`, allowing repeated opening and
  closing animations. Browsers without the enhancement retain immediate native
  disclosure behavior.
- The chevron is a controlled inline SVG, hidden from assistive technology and
  rotated through CSS state selectors.
- The renderer processes every complete row without arbitrary truncation, skips
  incomplete rows, falls back to `h2` for invalid heading data, omits an invalid
  empty block, and sanitizes WYSIWYG output with `wp_kses_post()`.
- The block's inserter title is **Accessible Accordion** to distinguish it from
  the separate core Accordion block available in this WordPress installation.
- New blocks default to ACF edit mode. Authenticated QA found that an empty
  preview has no frontend markup by design, so edit mode gives editors an
  immediate field-entry surface; populated blocks may switch to the
  server-rendered preview.

## Responsive and design-system decisions

| Context | Verified behavior |
| --- | --- |
| Mobile, 390px | 28px/1.2 title, 16px/1.75 questions, 14px/1.75 answers, naturally wrapped copy, 68px minimum summary height, and no horizontal overflow. |
| Intermediate, 430/600/767/768px | Title size and leading scale smoothly through the documented range; the remaining 48rem question/answer transition has no clipping or duplicate gutters. |
| Desktop, 1440px | Section centered at a computed 1000px maximum, 36px/1.3 title, 18px/1.5 questions, 16px answers, two-line centered title composition, and no horizontal overflow. |

The module inherits its section background from the parent and consumes
`--color-surface`, `--color-text`, `--color-muted`, `--color-border`,
`--color-neutral`, `--color-accent`, `--font-body`, `--measure`, and `--radius`
through component-scoped aliases and fallbacks. Its title uses the exercise's
required generic serif family. It adds no competing token layer or generic host
utility classes. The `1000px` maximum is an exercise-specific component
constraint rather than a new project width token.

## Accessibility

- Native disclosure semantics preserve keyboard, pointer, and touch behavior.
- The complete summary row is interactive and has a 68px minimum block size.
- A visible inward `:focus-visible` outline remains unclipped on open and
  closed item surfaces.
- Decorative chevrons are `aria-hidden` and nonfocusable.
- The block is a labelled section with a unique heading association and an
  editor-selected heading level.
- Questions and unbroken text use defensive wrapping; rich answer links and
  lists remain within the component.
- `prefers-reduced-motion: reduce` removes answer and chevron transitions while
  retaining disclosure behavior.
- Multiple open items and rapid repeated pointer toggling retain independent
  state.

## Authenticated Gutenberg and LocalWP QA

- `acf/accordion` and `group_accordion` loaded through the live WordPress
  runtime.
- Accessible Accordion appeared in Gutenberg's Design category separately from
  the core Accordion block.
- Page 59 contains one `acf/accordion` block in `alignwide`, preview mode with
  six complete rows.
- Gutenberg's document overview and block settings recognized the populated
  Accessible Accordion, and the editor remained clean after the external
  WordPress API update.
- The repeater definition loaded with block layout, a two-item minimum with no
  maximum, and `field_accordion_question` as its collapsed-row identity.
- A storage-level reorder check moved the default-open row in memory and
  confirmed that its question and open value stayed together.
- The saved frontend rendered six disclosures, two permitted `<strong>`
  elements in the reference answer, and exactly one default-open item.
- Pointer toggling opened multiple items simultaneously; focus remained visible
  with a 68px minimum target.
- Desktop and mobile live screenshots were compared with the supplied
  compositions. No additional component styling refinement was necessary.
- The editor and frontend produced no captured console warnings or errors.

### Editor tooling limitation

The controlled in-app browser cannot expose Gutenberg's cross-origin
blob-based editor canvas. It authenticated successfully and could inspect the
top-level inserter, document overview, block selection, settings sidebar, save
state, and live frontend, but it could not directly click the repeater's
collapse or drag controls or visually capture the server-rendered canvas.

The field configuration, scoped editor CSS, stored data, preview mode, and
reorder-safe row model were verified. The remaining visible-canvas checkpoint
was handed off for human review; the user subsequently confirmed that the
exercise looked good and authorized finalization. The automation boundary was
not a detected module defect.

## Validation

- PHP syntax checks passed for block registration and the template.
- ACF Local JSON and block metadata parsed successfully and passed contract
  assertions.
- WordPress runtime registration and server rendering passed.
- Rich content, invalid heading fallback, incomplete-row omission, empty-block
  omission, two default-open rows, and untruncated nine-row rendering passed
  automated rendering checks.
- Live frontend checks passed at mobile, breakpoint-adjacent, and desktop
  widths with no horizontal overflow.
- The title computed to 28px at 390px, 28.84px at 430px, 32.44px at 600px,
  and 36px at 768px and above. Its line-height progressed from 33.6px to
  46.8px without the former breakpoint jump.
- The live section computed to exactly 1000px and centered evenly at a 1440px
  viewport; at 390px it remained fluid within the host's 16px gutters.
- Native pointer disclosure, simultaneous open items, focus-visible styling,
  rich answer rendering, and default-open state passed on page 59.
- Browser console review found no warnings or errors.
- `git diff --check` passed.

## Post-QA corrections

Visible review after the initial QA pass identified six contract corrections:

- The block no longer paints its section background; that surface is inherited
  from the parent context.
- The section title uses the exercise-required generic serif family without
  adding an unapproved font asset.
- Repeat-toggle motion now enhances the native `::details-content` box instead
  of a descendant hidden immediately by closed `<details>`. The discrete
  `content-visibility` transition keeps closing content renderable through the
  `0fr`/`1fr` grid transition; unsupported browsers retain immediate native
  disclosure.
- The arbitrary eight-item maximum and PHP truncation were removed. Editors may
  add nine or more items, while the exercise retains a two-item minimum.
- The section now fills its available host width only up to a centered `1000px`
  maximum, as explicitly required for this exercise.
- Chrome's touch tap-highlight overlay is disabled on the summary control so
  responsive touch emulation does not flash blue before the designed gray or
  white state appears. Keyboard users retain the explicit focus-visible outline.

The block metadata version increased to `1.0.3` so browsers receive the latest
stylesheet, including the section-width and touch-highlight corrections,
instead of a cached asset.

## Fluid typography follow-up

The section title now uses rem-bounded `clamp()` values for both font size and
line-height. It preserves the documented 28px/1.2 mobile typography at 390px
and 36px/1.3 desktop typography at 768px while interpolating smoothly between
them. Keeping the old line-height media rule would have left a visible layout
jump even after making the font size fluid, so both values share the responsive
range.

The accepted specification now describes the responsive outcome rather than
mandating `clamp()` for every heading. The project design-system and ACF-module
skills carry the same conditional guidance for future exercises: record the
endpoints and interpolation range, prefer rem-bounded fluid typography when the
same display heading changes across viewports, and retain discrete breakpoints
when they are intentional. Block version `1.0.4` provides stylesheet cache
busting for the refinement.

## Implementation commits

`30f2819de53bd441ea6f59777033c01c7ea2cc70` (`30f2819`) — Add
accessible accordion ACF block.

`37298cdcd6d9f9429cf13c170da04e45b66467d9` (`37298cd`) — Refine
accordion heading typography.

## Timing

| Phase | Active time |
| --- | --- |
| Requirements and specification | ~15 min |
| ACF model, markup, styling, and automated QA | ~35–45 min |
| Authenticated Gutenberg and live frontend QA | ~25 min |
| Documentation and final review | ~10 min |
| Post-QA correction and verification | ~30 min |
| Fluid typography follow-up | ~20 min |
| **Approximate total** | **135–145 min** |

### Pause checkpoint

Work paused on August 30, 2026 at 11:26 AM EDT after approximately 85–95
minutes of recorded active work. At that checkpoint, the exercise remained
ready for review and uncommitted on `exercise/03-accordion`.

After resumption, the identified visual and interaction corrections were
implemented and validated: inherited background, serif title, repeat-toggle
animation, unbounded repeater rows, the 1000px section cap, and removal of
Chrome's blue touch highlight. The user approved the completed result and
authorized finalization.

## Key decisions and tradeoffs

- The host owns the available `alignwide` area and outer gutters; the module
  centers its exercise-specific 1000px section cap and owns its internal
  geometry without a nested `.container`.
- Native disclosure behavior is the baseline, with grid-row animation as a
  progressive CSS enhancement.
- Multiple open rows are intentional, so no exclusivity script or editor-only
  state enforcement is needed.
- ACF edit mode is the default for new empty blocks; saved QA content uses
  preview mode to exercise the server renderer.
- The title uses the exercise-required generic serif family. No arbitrary font
  asset was added to imitate the reference.
- The title's supplied mobile and desktop typography are endpoints of a fluid
  range, not two states that require an abrupt breakpoint switch.
- The project `--radius` role remains authoritative even though the visual
  reference suggests a slightly larger radius.
- The desktop answer uses 16px/1.75 after live visual comparison; the source
  notes supplied only the mobile 14px measurement.
- The restrained open-item shadow and transition timing were visually tuned as
  component implementation details because the source did not provide exact
  values.

## Deferred improvements

- Establish an approved project display-font asset so `--font-display` can
  express the intended serif role.
- Consider a reusable larger-radius or elevation token only if other components
  confirm those project-wide roles.
- Repeat the final editor collapse, drag, and preview check manually when a
  browser surface can inspect Gutenberg's blob canvas.

## Lessons for the next exercise

- Test the new-block empty state in authenticated Gutenberg before detailed
  visual tuning; defensive empty output can make preview-first blocks awkward
  to initialize.
- Distinguish custom blocks from similarly named core blocks in the inserter.
- Use `wp_slash()` when seeding serialized block JSON through `wp_update_post()`
  so WYSIWYG markup survives WordPress input unslashing.
- Treat Gutenberg blob-canvas automation as a known tooling boundary and plan a
  human editor-control checkpoint early when row dragging is acceptance-critical.
- When the same display heading has supplied mobile and desktop typography,
  specify its endpoints and interpolation range; do not turn `clamp()` into a
  universal requirement for headings that are intentionally static.
