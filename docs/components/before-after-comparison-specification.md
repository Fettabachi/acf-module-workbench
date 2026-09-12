# Before / After Comparison specification

## Objective

Build a portable `acf/before-after-comparison` block for visually comparing two
related Media Library images. The enhanced component must support pointer,
touch, and keyboard input without making JavaScript a prerequisite for access
to either image.

## Content model

- Optional eyebrow, heading, heading level, and introduction.
- Required before image and visible label.
- Required after image and visible label.
- Optional caption.
- Constrained shared image ratio: 16:9, 4:3, or 1:1.
- Initial after-image reveal from 10% through 90%.

Image alternative text remains attachment metadata in the WordPress Media
Library. Do not duplicate it in block fields. The editor should explain that
closely matched framing produces the clearest comparison.

## Structure and behavior

Render both labelled images in document order. Without JavaScript, show them as
a stacked comparison on narrow screens and a two-column comparison when space
allows. With JavaScript, layer the after image over the before image and clip it
at a position controlled by one native range input.

The range control owns the interaction for mouse, touch, and keyboard users.
Update a visible percentage readout and `aria-valuetext` while it moves. Do not
build a separate pointer-only drag implementation. Multiple instances must
initialize independently in both the frontend and ACF preview.

## Visual contract

Use the Workbench's semantic type, color, border, surface, focus, and radius
roles. Keep both image planes identically sized and cropped. The divider and
handle must remain visible over light and dark imagery, while labels stay close
to their respective edges. Do not expose arbitrary control colors or geometry.

## Accessibility and QA

- Preserve both images and visible state labels without JavaScript.
- Use a native range input with a programmatic label and visible instructions.
- Preserve Media Library alternative text.
- Provide a strong visible focus treatment around the comparison stage.
- Permit normal vertical page scrolling during touch interaction.
- Respect reduced-motion preferences.
- Omit the frontend block when either required image is invalid.
- Verify 0%, 50%, and 100% keyboard-controlled states despite the narrower
  authored initial-position range.
- Test multiple instances, missing optional copy, long labels, empty captions,
  mismatched source dimensions, narrow screens, and editor rerenders.
