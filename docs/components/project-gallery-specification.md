# Project Gallery specification

## Purpose

Build a portable `acf/project-gallery` block that helps visitors inspect a
cohesive image collection while preserving page context, clear metadata, and a
reliable non-JavaScript path.

## Content and interaction contract

- Optional eyebrow and introduction.
- Required section heading with an H2, H3, or H4 choice.
- Three to twelve ordered Media Library images.
- Attachment alternative text and optional captions remain the metadata source.
- A constrained landscape or square thumbnail crop.
- Optional complete closing link.
- Without JavaScript, every gallery figure links directly to its full image.
- JavaScript progressively presents one active image with persistent Previous
  and Next controls, visible position status, thumbnail navigation, and
  horizontal touch swiping. The active image retains an explicit “View larger”
  action that may open a native expanded viewer.

## Rendering and data handling

- Treat every field as potentially empty or malformed.
- Allowlist heading levels and thumbnail shapes.
- Normalize gallery values from attachment IDs or arrays, remove duplicates,
  retain author order, cap the collection at twelve, and omit invalid images.
- Omit incomplete links, captions, and optional introduction markup.
- Omit the frontend block without a heading and three valid images. Show concise
  completion guidance in an incomplete editor preview.
- Escape text, attributes, URLs, and generated Media Library markup by context.

## Semantics and accessibility

- Render a section labelled by its visible heading and a list of figures.
- Preserve gallery order at every viewport.
- Give each image link a position-aware accessible name while preserving the
  attachment alternative.
- Keep carousel Previous and Next controls, position, thumbnails, and the active
  image's “View larger” affordance persistently visible without hover. Give each
  control at least a 44-by-44 CSS pixel target.
- Support Left and Right Arrow navigation while focus is within the carousel
  stage. Treat horizontal touch swipes as an additional input, not the only way
  to change images, and preserve normal vertical page scrolling.
- Use a native dialog for the enhanced viewer. Provide labelled close, previous,
  and next controls; announce the current position; support Left and Right Arrow
  navigation; retain native Escape behavior; prevent background page scrolling
  while open; and restore focus to the opener.
- Keep direct full-image links when JavaScript or dialog support is unavailable.
- Protect long headings, captions, link labels, and metadata from overflow.
- Remove non-essential transitions for reduced-motion preferences.
- Change slides immediately. Where supported, use discrete `display` and
  `overlay` transitions with `@starting-style` to fade only the dialog and its
  backdrop during entry and exit. Preserve immediate dialog behavior in browsers
  without discrete-transition support.

## Responsive behavior

- Use one viewport-filling 16:9 active image at every enhanced layout size.
- Keep navigation controls below the active figure and allow the thumbnail rail
  to scroll horizontally without causing page overflow.
- In the no-JavaScript fallback, begin with two equal thumbnail columns. Balance
  odd narrow collections and wide three-column remainder sets without exposed
  empty cells.
- Keep captions attached to their images and preserve DOM order in both modes.
- Fit expanded images inside the available viewport without cropping.

## Editor contract

- Use ACF Block Version 3's expanded editor as the primary authoring surface.
- Divide introduction fields from gallery and CTA fields with two concise tabs.
- Use ACF's gallery field for selection, metadata access, and reordering.
- Keep the rendered block in preview mode as a static first-slide carousel with
  visible disabled controls and thumbnails. Suppress navigation and lightbox
  behavior, and hide duplicate sidebar fields.
- Do not expose arbitrary gap, column, color, font, radius, lightbox, or
  breakpoint controls.

## Host dependencies

The host supplies WordPress block registration and wrapper APIs; ACF text,
textarea, button-group, gallery, link, and tab fields; ACF's expanded block
editor; Media Library image markup and metadata; the outer aligned-block width;
and documented semantic design tokens. The module owns its active-image stage,
carousel controls, position status, thumbnail navigation, swipe behavior,
responsive fallback balancing, link fallback, dialog behavior, and defensive
rendering. It does not depend on a post ID, page template, URL,
generic host utility, third-party lightbox, or external service.

## Validation targets

- Parse block metadata and ACF Local JSON; run PHP and JavaScript syntax checks.
- Verify heading fallback, malformed gallery values, duplicate and invalid
  attachment IDs, incomplete links, and the minimum complete-gallery boundary.
- Inspect exactly three through twelve images, both thumbnail shapes, caption
  combinations, long copy, multiple instances, and missing optional content.
- Inspect narrow, breakpoint-adjacent, intermediate, and wide layouts for order,
  overflow, active-stage crop, thumbnail scrolling, balanced fallback rows, and
  viewport-safe dialogs.
- Verify persistent touch affordances, Previous and Next controls, thumbnail and
  Arrow-key navigation, announced position, swipe thresholds, vertical-scroll
  preservation, direct-link fallback, keyboard and pointer dialog navigation,
  native Escape, backdrop close, focus restoration, document scroll locking,
  editor link suppression, dialog and backdrop entry and exit, reduced-motion
  behavior, and expanded-editor centering.
- Run `git diff --check` before completion.
