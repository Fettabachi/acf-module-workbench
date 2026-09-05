# Testimonials specification

## Design source

The visual direction comes from the supplied Synkra testimonial-section reference: a split introduction, rows of bordered quote cards, and a full-width featured statement with separate attribution. The implementation removes the detached quote-mark badge and heading underline, standardizes card quote typography, constrains the featured quote measure, and adapts all color and typography decisions to the project tokens.

## Purpose

Present a modest but not artificially capped collection of attributed testimonials while allowing editors to position featured statements between complete card rows.

## Content and interaction contract

- A required heading labels the section.
- An optional eyebrow and introduction provide context.
- Editors choose H2, H3, or H4 for the section heading.
- Editors build and reorder complete rows with ACF Flexible Content.
- A standard row contains one to three ordered testimonials.
- A featured row contains one testimonial and may appear anywhere.
- Multiple featured rows are allowed.
- Every testimonial requires a quote and person's name. Portrait, role, and organization are optional; a featured testimonial may also include one short supporting detail.
- The component is informational. It has no links, controls, autoplay, carousel, or JavaScript behavior.
- There is no overall row maximum. The intended use remains a curated page section; large shared collections belong in a dedicated content type.

## Rendering and data handling

- Treat every field as potentially absent or malformed, including required fields.
- Allowlist the heading level and fall back to H2.
- Allowlist Flexible Content layout names and ignore unsupported layouts.
- Limit standard rows defensively to their first three supplied testimonials, matching the field contract.
- Omit testimonials without both a quote and name, then omit any row left empty.
- Omit the frontend block without a heading or valid row. Show concise guidance for an incomplete editor preview.
- Validate portrait attachment IDs as images and render them with `wp_get_attachment_image()`.
- Derive up to two initials from the person's name when a valid portrait is unavailable.
- Render role and organization independently and add punctuation only when both are present.
- Escape all plain text and generated attributes by context.

## Semantics and accessibility

- Render a section labelled by its visible heading.
- Render standard rows as semantic lists and each testimonial as a figure containing a blockquote and figcaption.
- Render featured testimonials as figures using the same quote-and-attribution relationship.
- Preserve authored row and testimonial order in both the DOM and layout; do not use dense packing or visual reordering.
- Keep portrait alternatives from the Media Library. Initial fallbacks are decorative because the adjacent visible name provides the identity.
- Do not add generated quotation marks or a quote-mark badge; the native blockquote structure carries the semantics.
- Ensure long quotes, names, roles, and organization names wrap without horizontal overflow.

## Responsive behavior

- The section introduction and every row begin as one column.
- Standard rows become two columns when cards have sufficient room and three columns at wide widths.
- One- and two-card rows remain balanced without inserting empty cards.
- The featured quote and attribution stack on narrow and intermediate widths, then form a wide quote constrained to 36 characters with a compact side attribution at the wide breakpoint.
- The featured quote scales from 30px on mobile to no more than 36px on desktop.
- Portraits retain a circular crop with `object-fit: cover`.
- Row order does not change between breakpoints.

## Editor contract

- ACF Block Version 3's expanded editor is the primary field-authoring experience.
- Introduction and row controls use separate tabs.
- Editors add either a standard or featured row and drag complete rows into display order.
- Standard-row testimonials use a block-layout repeater and collapse by name for easier ordering.
- The field group does not expose font, color, alignment, card, quotation-mark, spacing, or breakpoint controls.
- The server-rendered preview shares the frontend template and stylesheet.

## Host dependencies

The host supplies ACF text, textarea, button-group, image, tab, repeater, and flexible-content fields; ACF Block Version 3's expanded editor; WordPress Media Library image markup; the outer aligned-block width; and the documented semantic typography, color, surface, border, focus, spacing, and radius tokens. The module owns its row model, normalization, initials fallback, internal composition, and responsive behavior.

## Validation targets

- Parse block metadata and ACF Local JSON, and run PHP syntax checks.
- Verify heading fallback, unsupported row layouts, malformed values, incomplete testimonials, and empty rows.
- Verify one-, two-, and three-card standard rows, featured rows at the beginning, middle, and end, and more than one featured row.
- Verify missing portraits, derived initials, preserved image alternatives, partial attribution, long content, and multiple block instances.
- Inspect narrow, breakpoint-adjacent, intermediate, and wide layouts for wrapping, row order, balanced columns, and overflow.
- Verify the expanded editor with both sidebar states and row reordering.
- Review `git diff --check` before completion.
