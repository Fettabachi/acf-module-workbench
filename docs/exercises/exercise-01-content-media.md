# Exercise 01 — Content Media

## Figma/design source

The implementation follows the supplied Figma composition represented by
`Screenshot 2026-08-27 at 4.43.04 PM.png`. No shareable Figma URL or node ID was
provided. The visual targets included an approximately 1150px-wide component,
an approximately 580/480 content-to-media relationship, a 28px heading at 120%
line height, and 3:2 media.

## Goal

Build a portable, reusable `acf/content-media` block containing an optional
eyebrow, required `h2` heading, WYSIWYG content, up to four feature labels with
fixed decorative icons, required media, and an editor-selectable left/right
media position. Match the supplied desktop composition closely, provide a
media-first mobile layout, and maintain useful parity between the frontend and
Gutenberg preview.

## Final PR-style summary

Built a portable `acf/content-media` block with shared frontend/editor styling,
centralized block registration, ACF Local JSON, responsive media positioning,
and scoped wide-block layout support.

### Files changed

- `acf-json/group_content_media.json`
- `inc/blocks.php`
- `parts/modules/content-media/block.json`
- `parts/modules/content-media/content-media.php`
- `parts/modules/content-media/content-media.css`
- `functions.php`
- `assets/css/theme.css`

### ACF field contract

- Optional text eyebrow
- Required text heading, rendered as `h2`
- Optional WYSIWYG body
- Optional Features repeater, maximum four text labels
- Required image returning an attachment ID
- Media Position: left/right, default right

### Responsive behavior

Media precedes content in the DOM and displays above it on narrow screens. At
`48rem`, the component becomes a proportional two-column layout supporting both
media positions. Images retain a 3:2 presentation ratio. Wide blocks can reach
approximately 1150px without widening ordinary prose.

### Accessibility

- WCAG AA-compliant eyebrow contrast
- Decorative SVGs hidden from assistive technology
- Media Library alt text preserved, including intentionally empty alt text
- WYSIWYG output sanitized with `wp_kses_post()`
- Unique heading associations per instance
- Defensive wrapping for long headings, labels, eyebrow text, and URLs
- Existing keyboard focus treatment remains intact

### Validation

- PHP syntax checks passed
- ACF and block JSON assertions passed
- `git diff --check` passed
- Desktop, intermediate, and 390px responsive layouts verified
- Both media positions and editor-style fallback rendering verified
- Working tree was clean after the implementation commit

### Tradeoffs

- Required images with stale or invalid attachment IDs fail safely without an
  alternate image-less layout.
- The two-column layout is intentionally compact near the breakpoint.
- Exact authenticated Gutenberg canvas rendering remains dependent on the
  available editor width, though the shared stylesheet and component-local
  fallbacks provide structural parity.

## Implementation commit

`f4a0379732ebd87e601b482f658acea02389f6fe` (`f4a0379`) — Add portable content
media ACF block.

## Timing breakdown

| Phase | Time |
| --- | --- |
| Figma inspection / requirements interpretation | ~30 min |
| ACF/component architecture | 6 min |
| Plan + initial implementation | 30 min |
| WordPress/editor validation | 9 min active / ~15 min including documentation |
| Frontend visual refinement | 6 min |
| Gutenberg editor parity | 5 min |
| Final accessibility / PR-readiness fixes | 11 min |
| **Approximate total** | **96–102 min** |

The main friction during the first phase was relearning Figma's selection and
inspection workflow. This is a specific improvement target for Exercise 02.

## Key architectural decisions

- Register metadata-driven ACF blocks through the centralized `inc/blocks.php`
  layer while keeping the complete module under
  `parts/modules/content-media/`.
- Store the portable field group in `/acf-json` and keep the field contract
  independent of page IDs, templates, URLs, and database sample content.
- Use one component stylesheet for the frontend and editor, with scoped local
  fallbacks when frontend theme tokens are unavailable in Gutenberg.
- Establish a narrow prose versus `.alignwide` layout contract in the theme
  rather than widening `.entry` content globally. Omit `alignfull` because the
  theme does not provide a genuine full-width contract.
- Keep media first in DOM order. CSS changes only its desktop grid placement,
  preserving the intended mobile reading order without JavaScript.
- Use WordPress attachment rendering so Media Library alt text and responsive
  image attributes continue to work normally.

### Portability follow-up

- The initial module reused the host theme's generic `.container` on its
  internal frame. That unnecessary coupling created nested container behavior
  and double inset/gutter risk when moved between frontend and editor contexts.
- The follow-up removed the generic class from the module markup.
  `.content-media__frame` now fills the width made available by the block
  wrapper and owns only its internal padding, border, and component geometry.
  The host remains responsible for constraining the wrapper through its
  `.alignwide` contract.
- A colocated stylesheet is not automatically portable: editor parity exposed
  that shared module CSS can still depend accidentally on frontend-only tokens,
  resets, containers, and ancestor selectors. Essential values need
  module-scoped fallbacks.
- Future module planning should explicitly answer: **What does this module
  depend on from the host theme?** Generic structural class reuse should be
  treated cautiously and every retained host dependency should be deliberate
  and overridable.

## Accessibility, responsive, and editor-parity considerations

- The eyebrow teal was darkened to meet WCAG AA against white, and other text,
  icon, border, link, and focus colors were checked for sufficient contrast.
- Fixed eyebrow and feature SVGs are decorative (`aria-hidden` and
  non-focusable), while the section is associated with its unique heading ID.
- Optional wrappers are omitted when empty. Required media prevents normal
  image-less block configurations. Handling of stale or invalid attachment IDs
  remains a deferred defensive improvement.
- Long eyebrow text, headings, feature labels, and rich-content URLs wrap within
  the component instead of forcing horizontal overflow.
- The layout was checked at narrow, breakpoint-adjacent, and wide viewports.
  Mobile keeps media above all text; desktop supports understandable left and
  right media arrangements while retaining a 3:2 image frame.
- The same module stylesheet is loaded in Gutenberg. Component-local token
  fallbacks and geometry reproduce typography, colors, icons, spacing, column
  intent, and media treatment without globally restyling the editor.
- Multiple instances do not depend on page-specific selectors or fixed IDs.

## Tradeoffs and deferred improvements

- The two-column layout can feel compressed immediately above `48rem`; a future
  design system could adopt container queries or a deliberately higher shared
  breakpoint if more modules need similar behavior.
- Authenticated Gutenberg review confirmed substantially improved structural
  parity. Exact proportions still vary with the available editor canvas width
  and sidebar state.
- The required image deliberately has no image-less fallback layout. Editors
  must repair invalid or stale attachments through the field.
- The heading level is fixed at `h2` by the exercise contract. A broader module
  system may eventually need a documented heading-level strategy.

## Main bottlenecks

- Initial Figma inspection took ~30 minutes largely because of unfamiliarity
  with Figma's selection and inspection workflow. Exercise 02 should target
  roughly 10–15 minutes for a comparable design inspection.
- Iterative comparison between the supplied static composition and real browser
  geometry across frontend and editor contexts.
- Reconciling the theme's prose-width constraint with a reusable wide-block
  contract without introducing global typography or spacing changes.
- Gutenberg does not automatically inherit every frontend token and surrounding
  layout assumption, which required identifying and adding minimal local
  fallbacks.
- Accessibility and long-content review occurred after several visual passes,
  causing avoidable revalidation of the same responsive states.
- The post-completion portability review found that the module's internal frame
  still carried the host's generic `.container` class. Inspecting ancestor and
  utility interactions earlier would have prevented the nested gutter coupling.

## What should be faster or handled differently next time

- Target roughly 10–15 minutes for comparable Figma inspection by applying the
  selection and inspection workflow learned in this exercise.
- Begin module planning by asking, **What does this module depend on from the
  host theme?**, and audit layout utilities, tokens, resets, breakpoints,
  alignment behavior, typography, and editor assumptions before writing markup.
- Verify frontend and editor stylesheet loading together before detailed visual
  tuning.
- Establish the required/optional field contract and alignment support before
  creating test instances to reduce ACF synchronization churn.
- Run contrast, long-content, four-row repeater, and breakpoint-adjacent cases in
  the first responsive QA matrix rather than as a final pass.
- Capture a Figma URL/node ID and authoritative measurements when available so
  visual comparison is less dependent on a flattened screenshot.
