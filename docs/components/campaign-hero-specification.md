# Campaign Hero Specification

## Design source

- Desktop Figma frame: `14829:2998`
- Mobile Figma frame: `15346:30072`
- Source file: Synkra — Enterprise SaaS Website Template

The Figma frames define separate desktop and mobile compositions. Desktop pairs
campaign content with an architectural image and two informational metric
overlays. Mobile removes that media composition and uses decorative line artwork
behind a single-column content layout.

## Goal

Build a self-contained `acf/campaign-hero` block that preserves the campaign
hierarchy, purposeful editor controls, exact supplied assets, and deliberate
desktop-to-mobile transition. Treat it as a single art-directed campaign
placement rather than a generalized hero primitive.

## Content and interaction contract

- The heading is assembled from a starting phrase, an optional emphasized phrase,
  and an optional ending phrase so campaign emphasis remains editorial.
- Editors choose `h1`, `h2`, or `h3` to fit the block into the page hierarchy.
- An optional eyebrow, body, primary link, secondary link, and reassurance note
  complete the content column. The secondary link label is split into before,
  emphasized, and after phrases so its semantic emphasis remains editable.
- Links are interactive only when both a URL and label are present. The primary
  link uses the supplied Figma icon; the secondary link uses text with optional
  semantic emphasis.
- Desktop media may be replaced with a Media Library image. When none is selected,
  the portable module uses the exact bundled architectural artwork from Figma.
- The efficiency label/value/description and deployment label/percentage/note are
  optional editor-managed informational content. They do not become links or
  controls.
- The rendered component remains in preview mode. Its tabbed field groups open
  in ACF's Expanded Editor from either the block toolbar or settings sidebar;
  the full field form is not duplicated in the constrained sidebar.

## Responsive contract

- Narrow layouts use 24px internal spacing, one content column, stacked full-width
  links, a 56px display heading endpoint, and the supplied decorative mobile art.
- Wide layouts use two columns, 64px internal spacing, side-by-side links, an 80px
  display heading endpoint, and the architectural media composition.
- Heading size interpolates between 56px and 80px from approximately 390px through
  1280px; body and control type also increase at the wide composition.
- The desktop media and its overlays are hidden below the component breakpoint.
  The mobile artwork is decorative, non-interactive, and hidden from assistive
  technology.
- The host owns the outer content width and gutters. The block owns its internal
  surface padding, columns, wrapping, and transition breakpoint. The module root
  includes its padding within `width: 100%` rather than relying on a host-theme
  box-sizing reset.

## Rendering and accessibility

- Treat every ACF value as potentially empty. Omit incomplete links and empty
  metric elements; omit the entire frontend block without any heading content.
- In the editor, an empty heading produces clear guidance rather than an invisible
  block.
- The Gutenberg preview remains aligned with the post title and other root
  content with the settings sidebar open or closed, while Expanded Editor
  fields and tabs use the available modal width.
- Use a labelled section with an allowlisted semantic heading level.
- Preserve Media Library image markup for editor-selected media. Bundled decorative
  assets use empty alternative text and are excluded from the accessibility tree.
- Provide visible focus, at least 40px controls on mobile and 44px controls on
  larger screens, defensive wrapping, and no motion dependency.
- Preview links remain visible but cannot navigate inside Gutenberg.
- Only one Campaign Hero instance is allowed per page because the composition is
  designed as a singular page introduction.

## Design-system mapping

- Figma primary blue maps to `--color-primary` / `--color-accent`.
- Figma signal orange maps to `--color-signal`; success and danger roles extend the
  project token layer as `--color-success` and `--color-danger`.
- Figma page, text, caption, border, and white surface colors map to existing
  semantic theme roles rather than component literals.
- The project `--font-display` role becomes a portable serif stack, while body,
  label, and control copy continue using the sans-serif roles.
- Radius and spacing relationships are expressed from existing project roles or
  component-scoped layout values documented by the two source frames.

## Validation targets

- Parse block metadata and ACF Local JSON and run PHP syntax checks.
- Verify empty heading, invalid heading level, incomplete links, invalid media,
  optional metric combinations, and deployment percentage clamping.
- Verify the supplied narrow and wide compositions plus the transition range,
  long content wrapping, focus visibility, touch targets, and horizontal overflow.
- Inspect both the frontend rendering and Gutenberg preview before completion.
