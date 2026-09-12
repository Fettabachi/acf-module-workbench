# Sticky Feature Showcase

## Overview

Sticky Feature Showcase explains an ordered process, product, service, or transformation while keeping the corresponding visual context close to the reader. On wider screens, its media stage remains visible as the narrative advances; smaller and unenhanced experiences keep each image beside its step.

## Component contract

Editors provide a section heading and at least two complete steps. Each step requires a title, concise summary, and Media Library image; a short label and supporting link are optional. Steps are authored and rendered in meaningful reading order, with a maximum of six to keep the experience focused.

Landscape images with comparable composition work best. Alternative text remains attachment metadata and should describe the meaningful content of each image rather than its position in the sequence.

## Implementation decisions

- The server-rendered document contains one complete article and image for every step.
- JavaScript progressively creates a decorative sticky visual stage from those authored images on wider screens.
- Intersection Observer chooses the step nearest the central reading band without changing focus, scrolling, or document order.
- The editor presents the complete stacked sequence instead of simulating scroll interaction in Gutenberg.
- Component-owned class names, fallbacks, and responsive behavior allow the package to move without host layout utilities.

## Accessibility and defensive behavior

The section and step heading hierarchy follows the editor-selected section level. Images preserve Media Library alternative text in the semantic inline sequence; enhanced sticky copies are decorative and hidden from assistive technology. Optional links render only when both destination and label are complete. The frontend omits the component unless it has a heading and two valid steps, while the editor receives specific completion guidance.

The interaction never captures scrolling, changes focus, or hides content on mobile. Reduced-motion preferences remove fades and transforms, and the no-script experience remains complete.

## Validation

Validation covers PHP and JavaScript syntax, ACF Local JSON, field completeness, heading hierarchy, optional labels and links, invalid media, multiple instances, editor preview, expanded-editor repeater controls, no-script output, reduced motion, and mobile through wide layouts. Browser QA also checks sticky activation at the responsive boundary and active-step changes in both scroll directions.

## Tradeoffs and future improvements

The desktop enhancement duplicates cached image elements into a decorative stage so the original semantic sequence remains an honest fallback. This adds DOM nodes but avoids rearranging authored content or maintaining two independent data sources. A future video variant would need explicit playback, reduced-data, captions, and pause behavior rather than treating motion media as a drop-in image replacement.

## Source

- [Component package](../../parts/modules/sticky-feature-showcase/)
- [Component specification](sticky-feature-showcase-specification.md)
