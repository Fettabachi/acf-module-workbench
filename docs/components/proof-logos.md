# Proof Logos

## Overview

Proof Logos presents a flexible set of client, partner, press, integration, or
sponsor logos as credibility evidence. It is designed for real supplied brand
assets, where logos may arrive as raster images or SVGs with very different
aspect ratios, colors, and optical weight.

## Component contract

Editors provide a heading and two to twelve complete logos. Each logo requires
an organization name and image attachment. Section eyebrow, introduction,
global visual treatment, layout density, per-logo treatment overrides,
per-logo optical scale, optional logo links, and a closing call to action are
available when they support the proof story.

## Implementation decisions

- The component normalizes the slot, not the source artwork. Every logo sits in
  a consistent frame with `object-fit: contain`.
- Per-logo visual scale lets editors compensate for compact marks, long
  wordmarks, tall badges, and heavier artwork without editing the original file.
- Global and per-logo treatments support original, grayscale, and monochrome
  presentation so mixed source files can feel intentional in one grid.
- SVG attachments render through a direct escaped image tag, while raster
  attachments use WordPress image markup and responsive attributes.
- Links are optional per logo. A logo can be proof without becoming an
  interaction target.
- Density changes the logo slot and cell rhythm without exposing arbitrary
  spacing controls.

## Accessibility and defensive behavior

The block is a labelled section containing a semantic list. Each logo has a
programmatic organization name, and linked logos receive explicit destination
labels. The optional CTA and linked logos use visible focus states; restrained
state transitions are removed for reduced-motion preferences. Empty optional
fields, incomplete logos, invalid attachment types, and incomplete links are
omitted. The frontend block omits itself until a heading and at least two
complete logos remain.

## Validation

Block metadata, Local JSON, registration, PHP syntax, editor-script syntax,
server rendering, responsive grid behavior, SVG and raster rendering,
linked and unlinked logos, optional-field combinations, long organization
names, and the expanded editor controls are checked before release.

## Tradeoffs and future improvements

CSS filters cannot perfectly recolor every multicolor source asset. They are a
portable baseline for visual consistency, while the optical scale and treatment
override fields give editors practical escape hatches. Projects with strict
brand-governance needs should supply approved single-color logo files instead
of relying on browser filters.

## Source

- [Component package](../../parts/modules/proof-logos/)
- [Component specification](proof-logos-specification.md)
