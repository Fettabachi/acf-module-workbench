# Project Gallery

## Overview

Project Gallery guides visitors through an ordered set of images without making
the page carry a long visual grid. It works for projects, products, facilities,
events, campaigns, and other stories where one prominent image should remain the
focus while the full collection stays visible and directly navigable.

## Component contract

Editors provide a heading and three to twelve Media Library images. Eyebrow,
introduction, attachment captions, and a closing call to action are optional.
Editors may choose landscape or square thumbnails; expanded images always retain
their natural proportions.

## Implementation decisions

- The Media Library remains the source of image alternative text and captions,
  avoiding duplicate metadata fields inside the block.
- Direct links in a complete responsive grid form the reliable baseline.
  JavaScript progressively presents those same figures as one prominent active
  image with persistent Previous and Next controls, a visible position, touch
  swiping, and a horizontally scrollable thumbnail rail.
- The “View larger” affordance remains visible without hover. Supporting
  browsers progressively open the full image in a native modal dialog.
- Thumbnail crops create a steady navigation rhythm without changing the full
  asset shown in the expanded view. The active image uses a compact 16:9 stage.
- The fallback grid balances every allowed item count without changing authored
  order or exposing an awkward empty cell.
- Slide changes are immediate so the active image never overlaps or briefly
  flashes during navigation. Supporting browsers instead apply a restrained
  fade to the modal dialog and backdrop when they open and close.
- The optional CTA is separate from image interaction so its destination and
  purpose remain explicit.

## Accessibility and defensive behavior

The block renders a labelled section and a semantic list of figures. Each image
link receives a position-aware accessible name and retains Media Library
alternative text. Carousel controls remain visible, reach at least 44 CSS pixels,
and announce the active position. Visitors may use Previous and Next controls,
thumbnails, Left and Right Arrow keys while focused on the stage, or horizontal
touch swipes. The enhanced dialog provides its own navigation, native Escape
behavior, backdrop and explicit close actions, announced position, and focus
restoration. Motion is restrained and removed for reduced-motion preferences.
Background page scrolling is locked while any gallery dialog is open and
restored when the last one closes.
Invalid images, captions, links, and empty optional copy disappear cleanly; the
frontend block omits itself until a heading and three valid images remain.

## Validation

Block metadata, Local JSON, registration, PHP syntax, JavaScript syntax, and
server rendering are checked. Responsive review covers three through twelve
images, both thumbnail shapes, captions, missing optional content, narrow
through wide layouts, control and thumbnail navigation, swipe thresholds,
direct-link fallback, keyboard dialog navigation, focus restoration, and the
expanded editor with the sidebar open and closed.

## Tradeoffs and future improvements

The component intentionally avoids filtering, video, mixed media, downloads,
and per-image links because those change the gallery's content and interaction
contract. Collections needing those capabilities should use a dedicated media
library or content-grid component rather than adding modes to this block.

## Source

- [Component package](../../parts/modules/project-gallery/)
- [Component specification](project-gallery-specification.md)
