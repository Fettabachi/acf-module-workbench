# Proof Logos Specification

## Purpose

Create a portable ACF block that presents proof-by-association: clients,
partners, press mentions, sponsors, integrations, or certifications. The block
must remain useful when supplied logos vary widely by file type, aspect ratio,
color treatment, and visual weight.

## Content Model

- Optional eyebrow.
- Required heading.
- Required heading level: H2, H3, or H4.
- Optional introduction.
- Required logos repeater with two to twelve rows.
- Each logo row requires an image attachment and organization name.
- Each logo row supports an optional link, visual scale, and treatment override.
- Global logo treatment choices: original, grayscale, or monochrome.
- Layout density choices: compact, standard, or spacious.
- Optional closing CTA.

## Rendering Rules

- Omit the frontend block unless a heading and at least two complete logos are
  present.
- Render only attachments with an `image/*` MIME type.
- Render raster attachments with WordPress image helpers.
- Render SVG attachments with a direct escaped `<img>` tag when WordPress image
  helpers do not provide responsive markup.
- Preserve complete links only when both URL and label are present.
- Disable logo links and the CTA inside editor preview mode.
- Do not render empty wrappers for missing intro copy, eyebrow text, links, or
  CTA content.

## Layout

- Use a constrained, bordered component surface consistent with the project
  design system.
- Use a consistent logo slot inside each cell and let individual logo artwork
  use `object-fit: contain`.
- Start at two columns on narrow viewports, move to three at tablet width, and
  four at wide width.
- Support two through twelve logos without placeholder cells or exposed empty
  states.
- Keep horizontal overflow impossible with long organization names and narrow
  viewports.

## Accessibility

- Render a labelled section and semantic list.
- Provide a programmatic organization name for every logo.
- Provide explicit accessible names for linked logos.
- Preserve keyboard focus visibility for logo links and CTA links.
- Respect reduced-motion preferences for state transitions.

## Editor Experience

- Use ACF's expanded editor as the primary authoring surface.
- Group fields into Introduction, Logo Settings, Logos, and Link tabs.
- Use a block-layout repeater because each row combines media, naming,
  optional link, scale, and treatment controls.
- Provide Expand all and Collapse all controls for the logo repeater.

## Validation

- Check PHP syntax for the template and asset file.
- Check editor JavaScript syntax.
- Validate block JSON and ACF Local JSON.
- Run whitespace checks.
- Render saved, incomplete, malformed, linked, unlinked, SVG, and raster cases.
- Inspect frontend at mobile, tablet, and desktop widths.
