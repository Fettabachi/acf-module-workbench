# CR Practice development guardrails

These rules apply to work in this theme. Read the relevant local skills before changing code. Exercise-specific requirements override these rules only when they explicitly conflict.

## Before editing

- Inspect the theme, nearby modules, shared helpers, and established markup and styling patterns first.
- Reuse sound existing patterns. Make the smallest coherent change that completes the exercise.
- Keep supplied examples intact unless the exercise explicitly asks to change them.
- Ignore a `prompts/` directory unless an exercise explicitly makes it part of the work.
- Do not perform speculative refactors, dependency changes, unrelated cleanup, or broad formatting passes.

## WordPress and PHP

- Use WordPress APIs and conventions. Never edit WordPress core.
- Do not add a plugin when focused theme code is sufficient, and do not add dependencies without a clear need.
- Sanitize input and escape output at the correct context. Check capabilities and nonces for privileged actions.
- Use semantic HTML and preserve the WordPress template lifecycle and hooks.
- Treat every ACF field as potentially empty. Do not render empty wrappers, links, headings, media, or attributes.
- Give editors only purposeful controls. Use predictable field names and keep field definitions exportable in `/acf-json`.
- Namespace PHP symbols or use the `cr_practice_` prefix to prevent collisions.

## Frontend quality

- Target WCAG 2.2 AA: support keyboard use, visible focus, sufficient contrast, useful accessible names, semantic structure, and reduced motion where relevant.
- Follow the project design-system roles for typography, color, spacing, surfaces, borders, radii, and controls. Inspect existing tokens before adding values; do not invent a competing visual system inside a component.
- Write mobile-first CSS when practical and verify narrow, intermediate, and wide layouts.
- Prefer CSS Grid and Flexbox for layout. Avoid unnecessary `!important` declarations.
- Use CSS custom properties for shared system values such as colors, type, spacing scales, widths, and radii—not for every one-off value.
- Prefer modern space-separated color syntax, for example `rgb(255 255 255 / 0.09)`.
- Keep reusable markup and styles component-scoped. Use JavaScript only when behavior requires it, and make the non-JavaScript experience sensible.
- Write practical interface copy: clear, specific, concise, and useful to the visitor. Keep internal notes and demo disclaimers out of the interface.

## Portability

Reusable modules must be portable across projects, not merely repeated within this site.

- Do not couple a module to a page or post ID, page template, URL, domain, or site-specific content.
- Use a unique module namespace for markup and styles. Do not add broad host utility classes such as `.container`, `.section`, `.grid`, `.row`, `.columns`, or `.card` to reusable module markup merely because they already exist.
- Avoid selectors that depend on page-specific ancestor classes or unrelated surrounding markup.
- Keep module markup, styles, fields, and behavior self-contained as one coherent package.
- Separate page-shell layout from module-internal layout. Before adding centering, horizontal padding, or a `max-width`, inspect the ancestors and avoid unintentionally nesting width constraints or gutters.
- Organize ACF field definitions so they can be exported, imported, and recreated predictably.
- Use relative asset locations and WordPress APIs instead of hard-coded filesystem paths or URLs.
- Namespace module classes, functions, handles, and other identifiers sufficiently to avoid collisions.
- Document real dependencies. Do not make a module depend silently on unrelated theme features.
- Avoid assumptions about surrounding content width, background, typography, spacing, or neighboring modules unless those assumptions are part of a documented component contract.
- Prefer shared foundation utilities only when they are broadly available and make the module easier to transfer.

## Git workflow for practice exercises

`main` is the stable baseline branch. Never implement or commit a numbered exercise directly on `main`.

Before modifying implementation files for a new exercise:

1. Check the current branch and working-tree status.
2. Report the current branch, whether the working tree is clean, and the branch that will be used for the exercise.
3. Start from `main` unless the exercise explicitly requires another base.
4. Create and switch to a dedicated branch named `exercise/<number>-<short-description>` unless the repository already has a better compatible convention.
5. Keep all implementation commits on that exercise branch.

Examples include `exercise/01-content-media`, `exercise/02-feature-grid`, and `exercise/03-accordion`.

- If unrelated uncommitted changes exist, do not discard, overwrite, stash, or commit them without explicit instruction. Report the conflict and keep the work safely scoped.
- Commit exercise documentation, including `docs/exercises/` records, on the same exercise branch because it describes that branch's work.
- Repository-wide guidance learned during an exercise may be handled separately when appropriate, but do not silently commit it to `main` while exercise work is underway.
- Do not merge an exercise branch into `main` unless explicitly instructed.
- When implementation is complete, leave the exercise branch checked out and report its name, relevant commit hashes, the PR-style summary, and whether the working tree is clean. Treat the branch as ready for review, not automatically merged.

## Scope and validation

- Follow the exercise boundary strictly. Do not create demo content or change the database unless explicitly required.
- For practice exercises, work in this sequence: requirements → ACF/content model → markup → styling → responsive → editor parity → accessibility → QA → PR-style review.
- Review changed files for security, accessibility, responsiveness, portability, and empty-data behavior.
- Run PHP syntax checks on changed PHP files and any existing relevant project checks. Do not add tooling only to manufacture a check.
- Inspect the rendered frontend at desktop, tablet, and mobile sizes and check the editor experience before claiming a visual exercise is complete.
- Review `git status` and run `git diff --check`. Do not commit unless asked.
- Finish with a concise report of changed files, decisions, validation, and any manual step or unresolved limitation.

## Exercise records

- Preserve the completed-exercise record under `docs/exercises/` and its index in `docs/exercises/README.md`.
- Record the PR-style summary, implementation commit hash, timing breakdown, key decisions, tradeoffs, deferred improvements, bottlenecks, and lessons for the next exercise.
- When an exercise reveals a generally reusable lesson, recommend promoting it into `AGENTS.md` or the appropriate local skill rather than leaving it only in the exercise record.

## Local skills

- For visual styling or design-token decisions, read `.agents/skills/apply-project-design-system/SKILL.md`.
- For reusable ACF modules, read `.agents/skills/acf-module-development/SKILL.md`
  and `.agents/skills/build-portable-acf-modules/SKILL.md`.
- Use the vendored official WordPress skills when their descriptions match the task. Do not modify their contents.
