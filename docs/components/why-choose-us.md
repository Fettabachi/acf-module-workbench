# Why Choose Us

## Purpose and content contract

Why Choose Us gives a B2B organization a place to explain differentiators that matter to its customers. It is not a list of services: each reason states a distinctive claim, explains the customer benefit, and can show concrete supporting evidence.

Editors provide a section heading and two to six complete reasons. Each reason needs a claim and a short explanation. A supporting process detail, credential, outcome, or other evidence is optional; a public source link is shown only with evidence. The eyebrow, introduction, and single closing action are optional. Section-level controls can hide visual counters or place them above the claims instead of in a left column on wider screens.

## Implementation decisions

- Editorial rows separate claims from evidence rather than repeating Feature Cards' service-tile pattern.
- One shared closing action avoids competing per-row CTAs. Rows themselves are not interactive.
- The ordered list preserves the authored sequence. Optional visual counters are decorative; list semantics supply the relationship for assistive technology. When enabled, counters always move above the claims on narrow screens so they do not consume a text column.
- ACF Block Version 3's expanded editor separates introduction, reasons, and next step. Repeater rows have useful collapsed titles and bulk controls.
- The host provides aligned width and semantic design tokens; the module owns its internal responsive layout.

## Accessibility and defensive behavior

The section is labelled by its heading. Reason headings follow the chosen section heading level. Links have authored names and visible focus states; hover-state transitions respect reduced motion. Incomplete reasons and links disappear cleanly. With fewer than two complete reasons, the public block omits itself while the editor shows guidance.

## Validation and tradeoffs

Check two through six reasons at narrow, intermediate, and wide widths; counters hidden, left-aligned, and top-aligned; long copy; reasons with and without evidence; complete and incomplete links; keyboard focus; reduced motion; and expanded-editor row controls. The component cannot verify claims or sources automatically. Editorial review remains necessary, especially for numerical outcomes, certifications, and regulated claims.
