# Exercise 09 — Pricing Tables Specification

## Design source

- Desktop: Figma node `15067:17065` in the Synkra Enterprise SaaS template.
- Mobile: Figma node `15346:31144` in the same file.

## Goal

Build a portable `acf/pricing-tables` block that presents one to three product
plans, emphasizes one recommended tier, and optionally lets visitors compare
monthly and annual prices without hiding the default pricing from no-JavaScript
visitors.

## Content and interaction contract

- A heading and one plan with a name and price are required
  for frontend output. Eyebrow, supporting copy, price suffixes, features,
  featured badge, annual alternatives, savings label, and CTA links are optional.
- Heading and supporting copy use WYSIWYG controls. Heading output is restricted
  to emphasis, strong emphasis, and line breaks; supporting copy uses safe post markup.
- Editors choose `h2`, `h3`, or `h4` for the section heading. Plan names use the
  next level in the document outline.
- Each plan accepts a monthly price and optional annual price. A missing value
  falls back to the supplied value, keeping custom or non-recurring tiers valid.
- The billing selector appears only when at least one displayed price or suffix
  changes between frequencies on a plan marked as using billing frequency. It
  uses native radio inputs and is revealed only after its update behavior is
  available. Without JavaScript, the configured default price remains readable
  and no inactive control is shown.
- Visitors select among all displayed plans with visually hidden toggle buttons.
  Every button remains in the Tab sequence, exposes its pressed state, and draws
  focus on the corresponding card without adding a visible selection row. The
  visible card surface activates the same button. Selecting a plan that does not
  use billing frequency disables and visually mutes the billing controls;
  selecting an eligible plan restores them.
- CTA links remain the only navigation targets. Clicking elsewhere on a card
  selects its plan, while clicking its CTA follows the configured destination.
- Only the first plan marked Featured receives the visual emphasis and badge.

## Responsive contract

- Plans form a single-column stack on narrow screens, two columns when cards can
  retain a practical width, and three equal columns at the wide breakpoint.
- One- and two-plan configurations remain centered at wider sizes.
- The Figma heading scales fluidly from 56px at the mobile endpoint to 80px at
  the desktop endpoint. Supporting copy scales from 16px to 20px.
- Each card uses natural content height and a flex column to keep its CTA aligned
  without imposing a fixed card height. At the wide breakpoint, the Featured
  plan extends modestly above and below the secondary plans.

## Design-system mapping

- Typography, primary and accent colors, text, muted copy, success, subtle page
  background, surfaces, borders, focus, and radius use the theme's semantic roles.
- Cards and the section use flat semantic surfaces without gradients. Every card
  receives the same neutral gray shadow. The selected card receives one 3px
  primary border and a primary CTA; deselected cards use 1px neutral borders and
  secondary CTAs. Featured status controls the badge, blue plan label, and taller
  wide-screen silhouette.
- Badge and CTA-arrow artwork are local Figma exports. Feature rows use a clear,
  module-owned check-in-circle icon.

## Editor contract

- ACF's native expanded editor presents the complete field group in a focused
  full-screen modal; the narrow block sidebar does not duplicate those fields.
- Billing labels, plan fields, and nested features are full-width, stacked controls.
  Repeaters use block layout and keep their collapse controls visible at all times.
- The tab group sits on a connected neutral rail with a continuous rule, rounded
  tab shoulders, and a full-width 5px active underline.
  Module-scoped height overrides keep both WYSIWYG editors compact.

## Accessibility and defensive behavior

- A labelled section and ordered heading hierarchy provide document structure.
- Native billing radios and pressed-state plan buttons provide keyboard behavior
  and selected-state announcements.
- Focus indicators, 44px-or-larger controls, defensive wrapping, and AA-oriented
  semantic colors support varied input and content lengths.
- The billing selector uses one animated primary indicator that slides between
  equal Monthly and Annual tracks while the native radios retain interaction.
- Reduced-motion preferences remove card, CTA, and billing-indicator transitions.
- Missing required data produces editor guidance but no empty frontend shell.
  Optional values never emit empty wrappers, features, badges, or links.

## Validation targets

- Parse block metadata and ACF Local JSON; run PHP and JavaScript syntax checks.
- Test invalid heading levels, missing headings, incomplete plan rows, one to three
  plans, multiple Featured selections, missing CTAs, and missing annual values.
- Verify the no-JavaScript price fallback and enhanced monthly/annual switching.
- Verify all plan selections and the eligible/ineligible billing-control states.
- Inspect Gutenberg and the frontend at mobile, intermediate, and desktop widths,
  including breakpoint edges, keyboard focus, long content, and overflow.
