# Before / After Comparison

## Overview

Before / After Comparison lets visitors directly inspect a visual change while
keeping both source images available when scripting is unavailable. It fits
redesigns, renovations, restoration, retouching, product changes, and case-study
evidence.

## Component contract

Editors select two Media Library images, provide concise visible state labels,
and choose one shared crop. Optional section copy and a caption provide context.
The initial reveal controls presentation only; the visitor can expose either
image completely.

Alternative text belongs to each attachment in the Media Library. Images should
show the same subject from closely matched framing so the overlay communicates a
real comparison rather than an arbitrary transition.

## Implementation decisions

- A native range input provides pointer, touch, and keyboard interaction through
  one consistent control.
- The enhanced after image uses clipping rather than width changes, preserving
  identical image geometry on both sides of the divider.
- JavaScript updates only the reveal position, visible readout, and accessible
  value text.
- The unenhanced layout shows both complete images instead of presenting an
  inert imitation of the slider.
- Aspect ratio is a constrained component choice; crop alignment and source
  preparation remain editorial responsibilities.

## Accessibility and defensive behavior

Visible Before and After labels identify the image states. The range has a
programmatic label, keyboard instructions, current-value output, and a prominent
focus ring. Native image markup preserves responsive sources and attachment alt
text. The block omits itself on the frontend when either image is missing or no
longer valid, while the editor receives a specific completion message.

## Validation

Validation covers PHP and JavaScript syntax, ACF Local JSON, native range input,
arrow-key operation, pointer and touch input, no-JavaScript fallback, reduced
motion, multiple instances, editor preview rerenders, invalid images, optional
copy, long labels, and mobile through wide layouts.

## Tradeoffs and future improvements

The component deliberately avoids free-position focal-point controls because
both images must use the same crop geometry for an honest overlay. A future
variant could add paired focal points, but only with editor guidance and visual
validation that prevents the two states from drifting out of registration.

## Source

- [Component package](../../parts/modules/before-after-comparison/)
- [Component specification](before-after-comparison-specification.md)
