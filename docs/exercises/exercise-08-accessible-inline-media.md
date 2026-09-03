# Exercise 08 — Accessible Inline Media

## Status

Completed on `exercise/08-accessible-inline-media`.

## Design source

Self-authored component contract documented in
`exercise-08-accessible-inline-media-spec.md`.

## Goal

Add a reusable content section that pairs concise context with an accessible,
user-initiated video. Keep playback inline, reserve its geometry, retain a useful
native fallback, and avoid modal focus management or background-video behavior.

## PR-style summary

- Registered a portable `acf/inline-media` block with module-owned metadata,
  rendering, styling, and progressive-enhancement behavior.
- Added exportable ACF Local JSON for structured copy, heading hierarchy, Media
  Library video and poster attachments, optional WebVTT captions, and an optional
  transcript.
- Rendered a labelled content section with a native video fallback, a poster-led
  Play control, synchronized caption support, and a progressively enhanced
  transcript disclosure.
- Removed the decorative duration label because native video controls expose
  elapsed and total time when visitors need it.
- Refined the poster state with a compact icon-only control that retains a hidden
  accessible label, locked its icon to 4rem at every viewport, and added a
  motion-safe poster-to-video fade.
- Implemented transcript expansion with the reusable CSS grid-track pattern,
  transitioning the content row between `0fr` and `1fr`.
- Added a focused desktop media-position control. Both orientations preserve the
  wider media column, while narrow layouts and document order remain copy-first.
- Separated the desktop video and transcript into independent grid rows so
  transcript expansion does not reposition the copy column.
- Added an inert Gutenberg preview so editors see the poster-led composition
  without playing media inside the editor. Incomplete required fields produce
  explicit guidance.
- Documented the block's host dependencies and the complete Exercise 08 contract.

## Implementation commits

`c34d211` — `feat: add accessible inline media block`

`3ef560d` — `refactor: remove redundant video duration`

## Timing breakdown

Timing was not continuously clocked; the following is a rough active-work split:

| Phase | Approximate time |
| --- | ---: |
| Requirements and content model | ~10 min |
| Markup, styles, and behavior | ~30 min |
| Interaction and visual refinements | ~25 min |
| Runtime, responsive, and editor QA | ~20 min |
| Review and documentation | ~10 min |
| **Approximate total** | **~95 min** |

## Key decisions

### Inline rather than modal playback

The video replaces its poster inside a reserved 16:9 frame. Keeping it in the
page preserves context, behaves naturally on mobile, and avoids a focus trap,
close action, scroll lock, and viewport-constrained dialog.

### Native-first progressive enhancement

The server response contains a native `<video controls>` element. When JavaScript
and a poster are available, the script temporarily replaces native controls with
a compact icon-only Play action with a programmatic text label. Activation
restores controls, starts playback, and moves focus to the video. If JavaScript
is absent, the source fails, or playback is rejected, visitors retain native
controls and a direct file fallback.

### Native timing instead of duplicate metadata

The component does not repeat video duration in the adjacent copy. The native
player exposes elapsed and total time after activation, while a separate timer
would duplicate that information and create unnecessary visual and scripting
weight.

### Stable transcript geometry

On wide screens, the copy and video share the first grid row while the transcript
occupies a second row beneath the video. Expanding the transcript increases the
section's natural height and moves later page content, as an in-flow disclosure
should, but it does not change the copy's document position or its alignment with
the player. The transcript uses a short grid-track-and-opacity animation when
motion is allowed. Its outer grid transitions between `0fr` and `1fr`, while an
inner wrapper clips the collapsing content. Without JavaScript, the toggle stays
hidden and the transcript remains readable.

### Art-directed poster and video handoff

The poster is optional and may act as editorial cover art rather than reproduce
the video's opening frame. It should be composed for the player's 16:9 frame. A
brief overlay fade begins only when playback starts, making the transition feel
intentional without delaying or obscuring the native player.

### Self-hosted attachment contract

The first version intentionally accepts browser-playable Media Library files
rather than third-party embeds. This keeps lazy loading, controls, focus, and
failure behavior predictable without provider APIs, tracking, or cross-origin
player differences.

### Purposeful editor controls

The field model exposes content, accessibility needs, and one purposeful layout
choice: media left or media right on wider screens. It does not offer arbitrary
color, spacing, autoplay, looping, or player-style controls. Poster and transcript
are optional; synchronized captions are supported through a valid WebVTT
attachment, language code, and readable language label.

### Portability boundary

The host supplies outer width plus documented semantic typography, color,
surface, border, focus, and radius roles. The block owns its uniquely namespaced
surface, reversible two-column geometry, 52rem component breakpoint, 16:9 player,
and mobile stack. It uses no page ID, URL, generic host layout class, or
surrounding selector.

## Accessibility and defensive behavior

- The section is labelled by an allowlisted `h2`, `h3`, or `h4`.
- Playback requires an explicit user action and never loops or autoplays.
- The icon-only Play control has a 52px target on narrow layouts and a 60px target
  on wider layouts, a 4rem SVG at all widths, visible focus, and a visually
  hidden text label.
- Focus moves to the player after the Play control disappears.
- Captions render only for a valid WebVTT attachment with a valid BCP 47-style
  language code and non-empty readable label.
- Transcript content is escaped through WordPress's permitted-rich-HTML policy
  and remains available without JavaScript.
- Invalid videos suppress frontend output; missing posters fall back to the
  always-visible native player; missing optional content emits no empty wrappers.
- The editor preview never plays video and preserves Media Library poster alt
  text when an image is shown.

## Validation

- PHP syntax checks passed for the template and changed registration file.
- JavaScript syntax, block metadata JSON, ACF Local JSON, and `git diff --check`
  passed.
- WordPress runtime inspection confirmed the registered `acf/inline-media` block,
  its script and style handles, the active 14-field group, and allowed MP4 and
  WebVTT uploads.
- Final rendering uses the supplied 1920×1080 `office-pan.mp4` attachment and an
  intentionally art-directed 16:9 poster from the Figma source.
- Published page 192, “Accessible Inline Media Player,” now contains one saved
  Inline Media block using those attachments. Gutenberg's document outline
  recognizes the block and the editor reports no unsaved changes.
- Read-only ACF rendering checks confirmed the static editor poster, no playable
  editor video, `h2` fallback for an invalid heading level, native controls when
  the poster is missing, empty frontend output for incomplete required data, and
  clear incomplete-editor guidance.
- Browser QA at 390px and 1440px confirmed the single-column and two-column
  compositions, stable 16:9 geometry, visible Play state, and no overflow.
- Breakpoint-edge checks at 831px, 832px, and 833px confirmed the deliberate
  transition at 52rem without overflow.
- Activating Play exposed native controls, started playback, hid the replaced
  button, and moved focus to the video. The browser console reported no warnings
  or errors.
- Live QA on `/accessible-inline-media-player/` confirmed the published page's
  poster-led state, exact media sources, desktop and mobile layouts, playback,
  native controls, focus transfer, and clean browser console.
- Follow-up live QA confirmed the Play button exposes the accessible name “Play
  video” while rendering only the icon, keeps a 52–60px target, and produces no
  overflow. Transcript open and closed states keep the copy at the same document
  position and the same alignment relative to the player; the disclosure script
  completes with no inline animation residue or console errors.
- Final QA confirmed the icon remains exactly 4rem at desktop and mobile, the
  transcript collapses to a true 0px grid row, the Figma-sourced poster reads as
  intentional cover art, and the media-right layout reflows copy-first at 390px.

## Tradeoffs and deferred improvements

- Third-party providers are outside the initial contract. Add a separate embed
  source only if a real requirement defines privacy, consent, poster, captions,
  API-control, and failure behavior for the chosen provider.
- The existing Media Library contains no WebVTT fixture, so upload permission and
  defensive rendering were verified but an actual caption track was not played.
- The controlled browser exposed the saved block in Gutenberg's document outline,
  but its iframe canvas remained visually blank. The saved field data, inert
  editor-preview rendering, and published output were verified independently;
  a normal-browser field-editing pass remains a useful release check.
- A custom transcript label should be added only if real editorial requirements
  establish it as a reusable choice.

## Bottlenecks

- The controlled Gutenberg iframe did not expose a reliable visual preview, so
  saved field data, server rendering, document-outline recognition, and frontend
  behavior were verified independently.
- Distinguishing image scaling from a deliberately different poster composition
  required checking the intrinsic 16:9 source dimensions and rendered asset URL.

## Lessons for the next exercise

- Choose inline playback before a modal unless the design specifically requires
  the media to leave the page composition.
- For controls replaced by JavaScript, define both the server-rendered fallback
  and the post-activation focus destination before styling the enhanced state.
- Treat captions as structured media with a file, machine-readable language, and
  readable label; a transcript is valuable but does not replace synchronized
  captions for spoken video.
- A self-hosted player and a third-party embed are different component contracts,
  not interchangeable source options to hide behind one unqualified URL field.
- Prefer native player timing over a second decorative timer unless an editorial
  requirement makes duration meaningful before playback.
- Use an outer `0fr` to `1fr` grid-track transition with a clipped, zero-minimum
  inner wrapper for content-driven disclosures. This lesson was promoted to the
  reusable ACF module development skill.
