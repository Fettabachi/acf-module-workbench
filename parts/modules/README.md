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
