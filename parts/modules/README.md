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
