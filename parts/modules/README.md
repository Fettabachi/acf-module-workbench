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
