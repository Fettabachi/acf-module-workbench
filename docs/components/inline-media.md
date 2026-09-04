# Inline Media

## Overview

Inline Media pairs editorial context with a user-initiated video experience that supports captions and an optional transcript.

## Component contract

Editors provide context copy, a self-hosted video, poster image, caption file, optional transcript, and media position. WordPress Media Library attachments supply file metadata.

## Implementation decisions

- Native video controls are the baseline experience.
- A poster-led play treatment progressively enhances the player without introducing a modal.
- Native media timing remains the source of truth instead of duplicating duration metadata.
- The transcript occupies stable page space and remains adjacent to the media.

## Accessibility and defensive behavior

Playback is user initiated. Native controls, captions, keyboard operation, visible focus, and reduced-motion preferences are preserved. The component remains useful without JavaScript and handles missing optional media details safely.

## Validation

The component was reviewed with keyboard-only playback, captions, transcript expansion, disabled JavaScript, reduced motion, incomplete data, and desktop through mobile layouts. Editor controls and PHP syntax were checked.

## Tradeoffs and future improvements

The component deliberately supports self-hosted video rather than arbitrary embeds. A future embed variant would need its own privacy, consent, responsive, and accessibility contract.

## Source

- [Component package](../../parts/modules/inline-media/)
- [Component specification](inline-media-specification.md)
