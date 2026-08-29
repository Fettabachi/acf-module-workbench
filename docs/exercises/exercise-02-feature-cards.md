# Exercise 02 — Feature Cards

## Design source

The implementation follows the supplied desktop and mobile Feature Cards
screenshots. No shareable Figma URL or node ID was provided. The visual targets
included a three-card desktop grid, vertically stacked mobile cards, naturally
equal card heights, semantic badge and icon treatments, and one emphasized card.

## Goal

Build a portable `acf/feature-cards` block that supports one to three feature
cards and reproduces the supplied composition without hard-coding its example
content. Preserve editor usability, responsive behavior, accessibility, and
Gutenberg preview parity while keeping the module independent of page-specific
layout and content.

## Final PR-style summary

Built a portable Feature Cards ACF block with a constrained, content-driven
field model; responsive one-, two-, and three-card layouts; semantic visual
treatments; one optional featured card; shared frontend/editor styling; and
scoped editor enhancements for repeater usability and single-feature behavior.
The exercise also promoted reusable interaction-contract and ACF editor-layout
guidance into the local ACF module development skill.

### Files changed in the implementation commit

- `.agents/skills/acf-module-development/SKILL.md`
- `acf-json/group_feature_cards.json`
- `inc/blocks.php`
- `parts/modules/feature-cards/block.json`
- `parts/modules/feature-cards/feature-cards.php`
- `parts/modules/feature-cards/feature-cards.css`
- `parts/modules/feature-cards/feature-cards-editor.js`
- `parts/modules/feature-cards/feature-cards-editor.css`

### ACF content model

- One shared card-heading level: `h2`, `h3`, or `h4`, defaulting to `h2`
- Required Cards repeater with a minimum of one and maximum of three rows
- Block-style repeater layout with the card title as the collapsed-row summary
- Per-card Featured toggle; zero or one card may be featured
- Required editable label, limited to 40 characters
- Required approved icon choice: Palette, Integrations, or Lock
- Required semantic treatment: Standard, Positive, or Restricted
- Required title, limited to 80 characters
- Required plain-text description, limited to 400 characters

The model deliberately avoids arbitrary color, typography, spacing, icon-upload,
and layout controls. It can reproduce the reference content without treating
the supplied labels as a fixed product taxonomy.

### Responsive behavior

| Width | One card | Two cards | Three cards |
| --- | --- | --- | --- |
| 390px | One column | Stacked | Stacked |
| 768px | One column | Two columns | Two plus one |
| 1440px | Centered, capped at 46rem | Two columns | Three columns |

CSS Grid supplies natural equal heights within each row without fixed card
heights. Mobile cards retain natural content height, long content wraps without
horizontal overflow, and the block uses the width supplied by its host without
adding a nested container or duplicate gutter.

### Accessibility

- All card titles share an editor-selected semantic heading level.
- Titled cards render as `article` elements associated with unique heading IDs
  through `aria-labelledby`.
- Decorative SVG icons are `aria-hidden` and non-focusable.
- Visible label text preserves meaning independently of icon shape or color.
- Output values and dynamic classes are escaped and allowlisted by context.
- Missing and malformed field data is handled defensively; empty blocks do not
  render and malformed multiple-feature data emphasizes only the first card.
- Long labels, titles, descriptions, and unbroken strings wrap safely.
- The minimum measured text contrast during final QA was 4.76:1.

### Validation

- PHP syntax checks passed for the template and block registration.
- ACF Local JSON and block metadata parsed successfully.
- JavaScript syntax validation passed.
- One-, two-, and three-card fixtures passed at 390px, 768px, and 1440px.
- Breakpoint-adjacent, long-content, overflow, heading-level, icon, treatment,
  emphasis, and contrast checks passed.
- The synchronized ACF field group and server-rendered Gutenberg preview passed.
- `git diff --check` passed before the implementation commit.
- The implementation working tree was clean after commit.

## Implementation commit

`f27a9a9c0fa8e8c7f63f38acdd61b9e0040a36a2` (`f27a9a9`) — Add Feature
Cards block and ACF editor UX guidance.

## Timing

**Timing:** Not recorded reliably. The exercise was interrupted several times by
repository-guidance changes, Git workflow corrections, design-system/token
setup, featured-card content-model revisions, repeater editor-UX refinement,
Gutenberg canvas limitations, and interaction-contract clarification. No
meaningful total duration should be inferred from this exercise.

## Key implementation decisions

- Register the metadata-driven block through `inc/blocks.php` and keep its
  metadata, template, styles, and editor-only behavior together under
  `parts/modules/feature-cards/`.
- Use ACF Local JSON for a portable and reviewable field contract.
- Keep the block informational because the supplied design showed no link,
  button, hover, focus, or other interaction affordance. Adding links would
  have invented a product requirement and changed both fields and semantics.
- Replace the original hard-coded example taxonomy with editable labels plus
  constrained icon and semantic-treatment choices.
- Use one block-level heading-level control so editors can fit the cards into
  the page hierarchy without exposing a visual font-size control per card.
- Keep the one-to-three-card boundary from the supplied composition, while
  treating all three counts as supported layouts rather than requiring exactly
  three cards.
- Separate semantic treatment from featured emphasis. A card may be Standard,
  Positive, or Restricted independently of whether it is featured.
- Add no frontend JavaScript; the only script improves the ACF editing model.

## Editor UX decisions

- The first featured-card model used a block-level positional choice such as
  “Card 2.” Authenticated QA showed that reordering rows could move emphasis to
  different content and that one-card blocks exposed choices for nonexistent
  cards.
- Featured state therefore belongs to each repeater row. A small editor-only,
  block-scoped script clears the previous Featured toggle when another is
  selected, so the interface enforces the rule rather than relying on
  instructions. The PHP template still protects malformed stored data by
  honoring only the first featured row.
- The repeater uses ACF's block layout because Featured, Label, Icon, Semantic
  Treatment, Title, and Description were too compressed in a table inside the
  Gutenberg editing environment.
- Card titles identify collapsed rows, and scoped editor CSS keeps the collapse
  affordance visible and gives it a keyboard-visible focus treatment.
- Reordering preserves the featured state because that state travels with the
  card row instead of referring to a row number.

## Portability and design-system decisions

- Module markup, selectors, field keys, assets, and behavior use a Feature Cards
  namespace and do not reuse generic host classes such as `.container`, `.grid`,
  or `.card`.
- The host owns the available block width through its documented `alignwide`
  contract. The module owns only its grid, gaps, card padding, and internal
  presentation, avoiding nested width and gutter constraints.
- Component CSS consumes the project's color, surface, typography, border,
  radius, and measure roles with local fallbacks so it can render in Gutenberg
  without silently depending on frontend-only ancestors.
- The restricted red remains component-scoped because its exact value was
  inferred from the design and was not established strongly enough to become a
  project-wide token.
- Approved icon choices are rendered from controlled, decorative inline SVGs;
  editors cannot upload arbitrary icon markup or create a parallel icon system.
- The module has no page IDs, templates, URLs, sample-content dependencies,
  fixed heights, parent-layout selectors, or frontend behavioral dependency.

## Gutenberg QA findings

- ACF recognized and synchronized the field group, and Feature Cards appeared
  in Gutenberg's Design category and document list view.
- The final field structure, one-to-three-row limit, block repeater layout,
  collapsed title summaries, per-row Featured behavior, and row reordering were
  validated in the authenticated editor.
- Selecting a second Featured toggle clears the first, and reordering retains
  Featured on the same content row.
- The editor-only script and stylesheet loaded once without logged errors; the
  server-rendered preview produced the expected grid and emphasis.
- The controlled in-app browser could not consistently expose Gutenberg's
  blob-based canvas for automated visual inspection. A later visible editor
  screenshot and the synchronized fields, saved block state, editor assets, and
  server-rendered preview provided evidence of useful parity, but this tooling
  limitation should not be mistaken for complete automated canvas coverage.
- The settings sidebar opened and closed without Feature Cards styles leaking
  into the surrounding Gutenberg interface.

## Tradeoffs and deferred items

- The cards remain informational. Links, CTA labels, whole-card click targets,
  and interactive states are deferred until a design or product brief defines
  the interaction contract.
- The exact reference serif cannot be reproduced until approved font assets and
  a definitive display-font token are supplied. The component uses the available
  project/fallback typography rather than bundling an arbitrary font.
- The layout uses a component-justified media query rather than container
  queries. Container queries remain a possible future improvement only if a
  real host or editor-width mismatch warrants the extra complexity.
- Editor-only single-feature enforcement depends on ACF's field markup, although
  the behavior is tightly key-scoped and server rendering remains defensive.
- The one-to-three-card maximum intentionally matches the exercise contract; a
  larger collection would need a separate layout and content-design decision.
- Automated inspection of Gutenberg's blob-based canvas remains incomplete in
  the controlled in-app browser and should be supplemented with normal-browser
  QA when editor rendering is a release-critical acceptance criterion.

## Main bottlenecks

- Repository guidance changed during the exercise instead of being fully
  settled before kickoff.
- Git workflow corrections and branch guardrails were established as setup work
  before the implementation could proceed cleanly.
- Project design-system and token guidance had to be created or clarified before
  component styling decisions could be evaluated consistently.
- The featured-card content model required multiple revisions: hard-coded
  taxonomy, positional selection, and finally content-attached per-row state.
- The repeater editor UX needed refinement after testing it at Gutenberg's real
  constrained width rather than judging it only from ACF administration.
- Gutenberg's blob-based canvas was not consistently visible to the controlled
  browser, complicating authenticated visual QA despite valid fields, preview,
  saved state, and error-free assets.
- The absence of a defined interaction contract prompted late clarification
  about whether cards should link or remain informational.

## Reusable lessons promoted into skills

Exercise 02 extended `.agents/skills/acf-module-development/SKILL.md` with two
durable rules:

- Resolve the interaction contract before selecting fields and markup. When a
  design does not communicate links or behavior, do not invent them; identify
  the component as informational, partially interactive, or fully interactive
  during requirements review.
- Choose ACF layouts for the real editing environment. Substantial repeater rows
  in constrained Gutenberg contexts should favor readable block or row layouts,
  useful collapsed summaries, and verified collapse/reorder behavior over a
  compact but unusable table.

The implementation also reinforced a broader content-model lesson: state that
belongs to content should travel with that content. A featured card should be
modeled as “this card is featured,” not “the card currently in position two is
featured.”

## Lessons for Exercise 03

- Settle repository, branch, design-token, and skill prerequisites before the
  exercise clock starts.
- Record only active-work timestamps or rough per-phase durations as work occurs;
  do not use interrupted wall-clock time as exercise timing.
- Add an interaction-contract checkpoint to kickoff: informational versus
  interactive, destination/action, clickable area, CTA copy, and required
  hover/focus/active states.
- Review ACF fields in the actual Gutenberg width before finalizing the content
  model, especially repeaters with several substantial controls.
- Model identity and state on the content object rather than its current order.
- Run the one/two/three-state, long-content, contrast, breakpoint-edge,
  frontend/editor, and malformed-data matrix earlier to reduce repeated QA.
- Plan a normal authenticated-browser fallback when the controlled browser
  cannot inspect Gutenberg's blob-based canvas.
- Confirm approved font assets and authoritative visual tokens before judging
  exact typographic fidelity.
