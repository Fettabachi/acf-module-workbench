# Exercise 07 — Responsive Campaign Hero

## Design source

- Desktop Figma frame: `14829:2998`
- Mobile Figma frame: `15346:30072`
- Source file: Synkra — Enterprise SaaS Website Template

The implementation contract is recorded in
`exercise-07-responsive-campaign-hero-spec.md`.

## Goal

Build a self-contained ACF campaign hero that translates the supplied desktop
and mobile Figma compositions into semantic WordPress markup, purposeful editor
controls, exact local assets, and component-owned responsive behavior.

## PR-style summary

Added a Campaign Hero ACF block with structured campaign heading content, a
semantic heading-level choice, optional body and reassurance copy, two validated
links, a structured secondary CTA label, a Media Library desktop-image override,
and optional efficiency and deployment metrics. The renderer omits incomplete
links and an empty frontend block, provides editor guidance for a missing
heading, clamps progress values, preserves selected-media alt text, and disables
preview navigation. Block metadata limits the art-directed hero to one instance
per page.

Added a mobile-first scoped stylesheet that maps Figma roles into the project
design system, interpolates the display heading from 56px to 80px, changes
internal padding from 24px to 64px, stacks mobile links, and switches to the
desktop media composition at the component breakpoint. Exact architectural,
mobile-artwork, badge, button, and status assets are bundled locally so the
module does not depend on expiring Figma URLs.

Extended the project token layer with the documented serif display role plus
success and danger colors. Registered the block through metadata and documented
its real ACF, token, and asset dependencies.

## Implementation commit

`dac469f08c7720b4347571b50ee3815bc1b5abc4` (`dac469f`) — Add responsive
campaign hero.

## Timing breakdown

- Figma context, variables, assets, and module contract: 25 minutes
- ACF model, semantic renderer, and block metadata: 40 minutes
- Responsive styling and design-system mapping: 45 minutes
- Renderer, runtime, responsive browser, and accessibility QA: 35 minutes
- Documentation and PR-style review: 15 minutes

## Key decisions and tradeoffs

- Heading start, emphasis, and ending are separate fields so the visual emphasis
  remains meaningful editorial content rather than brittle text matching.
- Although implemented as an ACF block for the exercise, this composition is too
  campaign-specific to serve as a general hero primitive. It is intentionally a
  single-instance, art-directed block; future heroes should not inherit its
  architecture artwork, metric overlays, or campaign-specific field contract.
- The desktop image is replaceable, while the exact Figma architecture remains a
  portable fallback. Decorative mobile artwork and UI icons are fixed design
  assets rather than editor choices.
- Performance overlays are informational and optional. They remain readable
  content on desktop and are intentionally absent from the mobile composition,
  matching the supplied frame.
- The component follows the host's 72rem content width instead of escaping the
  page shell to reproduce Figma's 1280px maximum. This preserves portability and
  avoids nested or viewport-coupled layout hacks; the desktop heading therefore
  wraps according to the available host column.
- The secondary CTA label uses separate before, emphasized, and after fields.
  This preserves the source button's semantic italic emphasis without accepting
  arbitrary editor HTML or relying on brittle string matching.

## Scope and accessibility

The block remains technically self-contained: it has no page ID, hard-coded URL,
generic host utility class, external runtime asset, or JavaScript dependency.
Its PHP, markup, styles, ACF fields, and exact design assets travel together,
while the host retains responsibility for page width and outer gutters. That
self-containment supports maintenance; it does not make the visual contract a
good candidate for broad reuse.

The block is a labelled section with an allowlisted heading level. Links render
only with complete labels and URLs, external targets add safe relationship
attributes, selected media preserves Media Library alternative text, decorative
assets use empty alternative text, and preview links cannot navigate Gutenberg.
Controls have visible focus and practical touch targets, and valid long text can
wrap without causing horizontal overflow.

## Validation

- PHP syntax passed for registration and the renderer. Block metadata and ACF
  Local JSON parsed successfully, and `git diff --check` reported no whitespace
  errors.
- A renderer matrix confirmed empty frontend output, editor guidance, invalid
  heading fallback, incomplete-link rejection, safe external-link attributes,
  0–100 progress clamping, bundled media fallback, and selected-image alt text.
- The live local WordPress runtime confirmed the active `cr-practice` theme,
  registered `acf/campaign-hero` block and stylesheet, and active 22-field ACF
  group.
- Browser QA at 390px, 768px, 1023px, 1024px, and 1440px confirmed 56–80px
  heading interpolation, 24–64px padding, stacked mobile links, the intentional
  visual swap, loaded local assets, at least 40px mobile and 44px desktop links,
  a visible 3px focus outline, and no horizontal overflow or console warnings.
- Browser QA found and corrected a specificity conflict that initially left the
  mobile line artwork visible at the desktop breakpoint.
- The user-created published Home page (`ID 183`) now contains one populated
  Campaign Hero block with the supplied Figma copy and metrics. Gutenberg List
  View recognizes the block, the final editor state is clean with Save disabled,
  and no stale autosave warning remains.
- Published Home-page QA at 390px and 1440px confirmed the omitted front-page
  shell title and `h1` hero hierarchy, complete local asset loading, desktop
  metric cards, the mobile artwork swap, 56px mobile heading, 24px mobile
  padding, no overflow, and no browser console warnings.

## Content follow-up

The local exercise content uses `#` destinations for both campaign links. Replace
them through Gutenberg when real campaign targets are available. The secondary
label is stored as `Watch` / `Synkra` / `in action`, and the renderer outputs the
middle phrase as semantic italic emphasis.

## Deferred improvements

- Promote a shared campaign-button primitive only if another module confirms the
  same control contract.
- If a future reusable hero accumulates this many grouped controls, move its tabs
  and controls into a focused modal editor. The sidebar remains an acceptable
  tradeoff for this one-off implementation and does not justify custom editor
  JavaScript on its own.
- Add a dedicated 1280px page-shell option only if the host design system adopts
  that width beyond this component.

## Bottlenecks

- Figma asset URLs are temporary, so the exact raster and vector exports had to
  be identified and stored locally before implementation could be considered
  durable.
- Gutenberg's narrow settings sidebar made the 22-field contract dense. The
  design remains manageable for a one-off block, but the same control count
  would justify a modal editor in a frequently reused component.
- The local browser could verify the block outline and frontend, but its editor
  canvas was not consistently available for automated field inspection. User
  screenshots plus the loaded ACF field count and saved block data provided the
  complementary editor evidence.
- The default page template initially produced a duplicate visible page title
  above the hero. Resolving the title in the template and promoting the hero to
  `h1` was a page-shell decision rather than a block-style workaround.

## Lessons learned

- Figma integration can provide exact assets, variables, and responsive intent,
  but implementation fidelity does not imply that the result should be reusable.
  Decide the reuse boundary before expanding the content model.
- Exact responsive measurements still need to be reconciled with the host page
  shell. Record which dimensions belong to the source component and which remain
  host responsibilities before reproducing screenshot geometry.
- Desktop and mobile may be deliberately different compositions rather than one
  layout compressed through breakpoints. Preserve the intentional asset swap.
- A standard ACF link title cannot express meaningful partial emphasis. Separate
  before, emphasized, and after fields preserve editorial intent without rich
  HTML or brittle string matching; `<strong><em>` accurately represents the
  supplied bold-italic brand emphasis.
- Page titles and hero headings are one semantic system. Remove an unwanted
  front-page title from the template rather than hiding it with CSS, then let the
  hero provide the page's `h1`.
- Editor-interface investment should follow reuse and editing frequency. A modal
  would improve a dense reusable block, while a one-off hero does not justify the
  extra editor code.
- The reusable lesson worth promoting is a requirements question: before building
  an ACF module, classify it as a shared primitive, a constrained reusable
  component, or a template-bound composition.
