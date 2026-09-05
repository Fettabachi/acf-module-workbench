# Modules

Keep each reusable ACF module in its own directory. A module should own its template and styles, plus any behavior it genuinely needs. Store the corresponding ACF field-group JSON in `/acf-json` with a predictable module-based filename.

Prefer this boundary when an exercise needs a module:

```text
parts/modules/content-media/
├── content-media.php
├── content-media.css
└── content-media.js    # Only when behavior requires JavaScript.

acf-json/
└── group_content_media.json
```

Document any real dependency near the module. Do not add empty placeholder files.

## Filtered Content Grid dependencies

The Filtered Content Grid queries published standard posts and the built-in
`category` taxonomy. WordPress supplies post links, dates, authored excerpts,
category terms, and featured-image markup. Its filter controls use a small
module-owned script for progressive enhancement; the complete post collection
remains visible when that script is unavailable.

## Campaign Hero dependencies

The Campaign Hero depends on ACF link, image, text, textarea, number, tab, and
button-group fields plus the theme's documented semantic color, typography,
spacing, and radius roles. Its architectural fallback, decorative mobile art,
and interface icons are exact local exports from the supplied Figma frames. A
Media Library image can replace the desktop artwork, and the block requires no
JavaScript. This is an art-directed, single-instance campaign component rather
than a general-purpose hero primitive.

## Inline Media dependencies

The Inline Media block depends on ACF text, textarea, button-group, image, file,
and WYSIWYG fields plus WordPress Media Library attachment URLs and metadata. It
accepts one browser-playable video attachment and an optional WebVTT captions
attachment. A module-owned script progressively enhances a native video player
with a poster-led Play control, fades the poster into the opening video, and
animates the optional transcript with a `0fr` to `1fr` grid-track transition. The
native player and transcript content remain available when the script does not
run. Editors may place media on either side at the two-column breakpoint; media
remains the wider column and mobile reading order remains copy-first. The host
supplies semantic design tokens and the outer content width, while the block owns
its internal layout and responsive behavior.

## Pricing Tables dependencies

The Pricing Tables block depends on ACF text, WYSIWYG, button-group, true/false,
repeater, and link fields, plus ACF Block Version 3's expanded editor. The host
supplies its documented semantic typography, color, surface, border, focus, and
radius tokens plus the outer content width. The module owns its responsive one-,
two-, and three-column layouts, price-card
geometry, featured-plan treatment, and progressive billing selector. A small
module-owned script reveals native billing radios and visually hidden plan toggle
buttons only when it can manage their state. Every plan button remains in the Tab
sequence and is visually represented by its card rather than a separate selection
row; billing is disabled for plans not configured to use it, and configured
default prices remain readable without JavaScript. Its billing
indicator transitions between the two native radio states and respects reduced
motion. The badge and CTA-arrow artwork are local Figma exports; the feature check
is a purpose-built module asset.

## Open Positions dependencies

The Open Positions block depends on ACF text, textarea, button-group, and number
fields plus the public Greenhouse Job Board API. The host supplies its documented
semantic typography, color, surface, border, focus, and radius tokens plus the
outer content width. The module owns its server-side HTTP request, response
validation, transient caching, stale-data fallback, empty state, card layout, and
responsive behavior. Only the public board token is editable; the API origin is
fixed in code, no credential is stored, and no browser-side request or JavaScript
is required.

## Meet the Team dependencies

The Meet the Team block depends on ACF text, textarea, button-group, true/false,
link, image, tab, and repeater fields plus WordPress Media Library image markup.
The host supplies its documented semantic typography, color, surface, border,
focus, and radius tokens plus the outer content width. The module owns its
ordered member data, near-square portrait crop, one-, two-, and four-column
layouts, missing-media treatment, biography panels, and native-select department
filter. A module-owned script turns portraits and underlined member-name buttons into
focus-managed, scrollable panels that slide from the top of each card and reveals
filtering only when it can manage the result state. Department changes reuse the
Filtered Content Grid's card-rearrangement transition and opacity fallback. Biography
content and the complete team remain available without JavaScript, and motion respects
reduced-motion preferences.
