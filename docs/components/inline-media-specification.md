# Inline Media Specification

## Design source

This component uses a self-authored contract rather than reproducing a supplied
Figma frame.

## Goal

Build a portable `acf/inline-media` block that pairs concise editorial context
with an accessible, user-initiated video player. Treat it as a constrained
reusable content section rather than a hero, background video, or modal.

## Content and interaction contract

- A heading and browser-playable Media Library video are required for frontend
  output. An eyebrow, supporting paragraph, poster, captions, and
  transcript are optional.
- Editors choose `h2`, `h3`, or `h4` to fit the block into the page hierarchy.
- Editors may place media on the left or right at the two-column breakpoint.
  Media remains the wider column and copy remains first in document and mobile
  reading order.
- The video never autoplays. Without JavaScript it renders immediately with
  native controls and any supplied poster and captions.
- Do not duplicate elapsed or total time beside the player; native controls
  expose that information when it becomes relevant.
- When JavaScript and a poster are available, a compact icon-only Play control
  overlays the poster, which may be purpose-built editorial cover art rather
  than a video frame. Its text remains available as an accessible name.
  Activating it reveals native controls, starts playback, and moves focus to the
  player without changing the reserved 16:9 geometry. A short overlay fade
  softens the handoff from the supplied poster to the video's opening frame.
- If enhancement or playback fails, the native controls remain or become
  available. The interaction has no hidden content dependency.
- A WebVTT captions file may provide synchronized English or other language
  captions. Editors supply the track language code and readable language label.
- An optional transcript is visible in the server-rendered, no-JavaScript
  experience. JavaScript adds a disclosure button and animates the content with
  a CSS grid track transitioning between `0fr` and `1fr`, while synchronizing
  expanded state, visibility, and focusability. Reduced-motion preferences remove
  the transition.

## Responsive contract

- Narrow layouts place copy before the player and transcript in normal reading
  order.
- At the component breakpoint, copy and media form two columns with the player
  receiving the larger share of the available width in either orientation. Copy
  aligns to the video row only; the transcript occupies a separate row beneath
  the media so disclosure height cannot reposition the copy.
- The player always reserves a 16:9 region. Poster and video content use cover
  behavior without fixed component heights.
- The host owns the outer width and gutters. The module owns its internal surface,
  padding, columns, spacing, and breakpoint.

## Rendering and accessibility

- Treat every ACF value as potentially empty. Reject invalid attachment types,
  omit incomplete captions, and omit the frontend block without both a heading
  and valid video.
- In Gutenberg, incomplete required fields produce explicit guidance rather than
  an invisible preview. A completed preview uses the poster or a neutral media
  placeholder and does not play video inside the editor.
- Use a labelled section, an allowlisted heading element, native `<video>` and
  `<track>` semantics, and real buttons for the enhanced Play and transcript
  actions. Connect the transcript button and panel programmatically and keep the
  no-JavaScript transcript readable.
- Preserve the Media Library poster alternative text in image-based editor
  previews. The frontend poster is the video control's visual state and does not
  create a duplicate image announcement.
- Provide visible focus, a large touch target, defensive wrapping, sufficient
  contrast, and no required motion.
- Support multiple independent instances without fixed IDs or shared player
  state.

## Design-system mapping

- Text, muted copy, borders, page and surface colors, focus, display typography,
  body typography, radius, and content measure use the theme's semantic tokens.
- The media frame uses the existing subtle surface and border roles. The Play
  control uses the existing primary/surface roles.
- Component-scoped spacing and geometry express this module's layout without
  adding new project-level tokens or host utility classes.

## Validation targets

- Parse block metadata and ACF Local JSON and run PHP and JavaScript syntax checks.
- Verify empty heading, missing or invalid video, missing poster, invalid captions,
  invalid heading level, long content, transcript omission, and attachment
  metadata fallbacks.
- Verify enhanced playback, native no-JavaScript fallback, focus movement,
  captions markup, multiple instances, editor non-interactivity, and playback
  failure recovery.
- Inspect frontend and Gutenberg output at mobile, intermediate, and desktop
  widths, including breakpoint edges and horizontal overflow.
