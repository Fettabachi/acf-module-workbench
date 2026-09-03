# Exercise 09 — Pricing Tables

## Status

Ready for review on `exercise/09-pricing-tables`.

## Design source

- Desktop: Figma node `15067:17065` in the Synkra Enterprise SaaS template.
- Mobile: Figma node `15346:31144` in the same file.
- Component contract: `exercise-09-pricing-tables-spec.md`.

## Goal

Add a reusable pricing section with responsive plan cards, a purposeful featured
tier, and an accessible progressive billing selector.

## PR-style summary

- Registered a portable `acf/pricing-tables` block with module-owned metadata,
  rendering, styling, artwork, and progressive-enhancement behavior.
- Added exportable ACF Local JSON for WYSIWYG introduction copy, heading
  hierarchy, billing labels, one to three plans, monthly and annual prices,
  features, featured treatment, and plan-specific links.
- Enabled ACF's full-screen expanded editor, removed the field form from the
  constrained sidebar, stacked all controls, switched nested features to block
  layout, and made repeater collapse controls persistent.
- Rendered a labelled section with derived plan-heading levels, normalized links,
  complete empty-data handling, and inert editor links and billing controls.
- Implemented a native radio-group billing selector that is exposed only when
  annual values differ and JavaScript can update them. Default prices remain
  readable without JavaScript.
- Added native plan selection and a portable per-plan billing eligibility field.
  Clicking a card selects it without a visible selection row; plans without
  frequency-based pricing disable and mute the billing control.
- Adapted the supplied 56px and 80px heading endpoints into bounded fluid type,
  stacked cards into responsive two- and three-column layouts, and preserved
  local artwork, including an unmistakable check-in-circle feature icon.
- Kept flat, gradient-free surfaces while restoring a consistent neutral shadow
  to every card. Selection owns one 3px primary card border and the primary CTA;
  deselected cards use 1px neutral borders. Featured status adds the optional
  badge, blue plan label, and taller wide-screen silhouette.
- Rebuilt the billing toggle as an equal-track segmented control with one primary
  indicator that slides between Monthly and Annual selections.
- Documented the module contract and host dependencies.

## Implementation commit

`e131909` — Build accessible pricing tables module.

## Timing breakdown

Timing was not continuously clocked; the following is a rough active-work split:

| Phase | Approximate time |
| --- | ---: |
| Requirements, Figma review, and content model | ~15 min |
| Markup, ACF fields, and assets | ~25 min |
| Styling and responsive refinement | ~40 min |
| Runtime, interaction, editor, and browser QA | ~30 min |
| Review and documentation | ~15 min |
| **Approximate total** | **~125 min** |

## Key decisions

### Progressive billing controls

The server renders the configured default price for every plan. The native radio
group starts hidden on the frontend and is revealed only after the module script
can update every price and suffix. This avoids presenting a dead toggle when
JavaScript is unavailable while retaining readable pricing.

### Structured pricing strings

Prices are editorial strings rather than numeric fields so the module supports
currency symbols, zero-cost plans, and values such as “Custom.” Separate suffixes
carry cadence and billing context without forcing one pricing model.

### Expanded editor instead of sidebar fields

The block uses ACF Block Version 3's built-in expanded editor rather than a
custom modal. Its focus management and completion action are maintained by ACF,
while module-scoped editor CSS presents the tabs as a connected neutral rail with
a full-width 5px active underline, shortens both WYSIWYG controls, keeps repeater
controls visible, and centers the preview. The cramped inspector no longer
duplicates the form.

### Portable billing eligibility

Billing behavior is configured with a per-plan “Uses Billing Frequency” field,
not a hard-coded plan name. The featured plan is selected initially; editors can
make any plan eligible without changing the template or script.

### Selectable cards with explicit links

Plan cards activate an associated native radio when their non-interactive surface
is clicked. The radios remain keyboard and screen-reader accessible without a
visible “Select” row. Complete ACF link values render as separate CTAs and are
excluded from the card-selection click handler, preserving their navigation role.

### Portability boundary

The host supplies outer width and documented semantic tokens. The block owns its
namespaced surface, internal spacing, card grid, featured treatment, breakpoints,
and billing behavior. It has no page ID, URL, generic utility class, or database
dependency.

## Accessibility and defensive behavior

- The section is labelled by an allowlisted heading; plan headings derive the
  next logical level.
- The billing and plan selectors use native radio inputs, unique per-instance names,
  visible focus, and 44px-or-larger labels.
- CTA links preserve safe new-window behavior and become inert in editor previews.
- Empty features, badges, links, and descriptions produce no empty wrappers.
- Incomplete blocks show editor guidance and suppress frontend output.
- Long values wrap, card columns use zero minimums, and motion is optional.

## Validation

- PHP syntax checks passed for the block template and changed registration file.
- JavaScript syntax, block metadata JSON, ACF Local JSON, and `git diff --check`
  passed. The repository exposes no additional package, Composer, lint, or test
  configuration applicable to this module.
- Gutenberg's inserter lists Pricing Tables in the Design category, confirming
  runtime block registration and active ACF field matching. Page 209 saves with
  one serialized Pricing Tables block and reports no unsaved changes.
- Published page 209, “Exercise 09 Pricing Tables,” renders one labelled section,
  three plan articles, one featured plan, an `h2` section heading, derived `h3`
  plan headings, complete feature lists, and three enabled CTA links.
- Server-rendered HTML keeps the billing fieldset hidden and outputs the selected
  annual defaults (`$0`, `$49`, and `Custom`), confirming the readable
  no-JavaScript fallback. It also loads the module script and local assets.
- Browser interaction confirms enhancement reveals and enables the radio group;
  selecting Monthly changes the plans to `$0`, `$69`, and `Custom` and updates
  the component state without reloading.
- Selecting Starter disables billing, selecting Pro restores it, and the controls
  expose both native disabled state and a visible muted treatment.
- Wide-layout measurement confirms the Featured plan is 24px taller than its
  neighbors, its label uses the primary color, and selected/deselected borders
  resolve to 3px/1px. All three cards share the same neutral shadow.
- Billing interaction confirms the primary indicator traverses an intermediate
  transform during its 280ms transition and settles beneath the selected option;
  reduced-motion CSS removes that transition when requested.
- Browser QA at 390px and 1440px confirmed the intended single- and three-column
  compositions, the 56px and 80px heading endpoints, visible featured treatment,
  and no horizontal overflow.
- Breakpoint-edge checks at 671px, 672px, 1023px, and 1024px confirmed deliberate
  one-to-two and two-to-three column transitions without overflow.
- The selected billing option exposes a visible keyboard-focus outline, CTA
  targets meet the 48px implementation size, and the browser console reports no
  warnings or errors. Page 209 was migrated to the WYSIWYG fields and the Pro
  plan was marked billing-eligible without changing its other block content.
- Final visual review reduced module-owned horizontal padding because the host
  already supplies the 72rem outer constraint. This avoids doubled gutters and
  brings card proportions closer to the Figma reference.

## Tradeoffs and deferred improvements

- Price strings intentionally leave currency localization to editors. A future
  commerce-backed version should use structured currency data and locale-aware
  formatting rather than extending this presentation block.
- The first version compares two billing frequencies only; additional periods
  would require a new content and interaction contract.

## Bottlenecks

- The controlled Gutenberg iframe remained visually blank, as it did during the
  preceding exercise. Registration and state were verified programmatically;
  user-provided editor screenshots supplied the visual field-control review.

## Lessons for the next exercise

- Reveal a control only when its enhanced behavior is available if the server can
  already provide a complete readable default state.
- A full-width module root that owns padding and borders should explicitly use
  border-box sizing and automatic inline margins; otherwise editor width math can
  make a visually centered block appear offset. This is worth auditing in earlier
  exercise modules as a separate project-level consistency pass.
