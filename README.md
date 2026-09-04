# ACF Module Workbench

A lightweight custom WordPress theme for building agency-style frontends and reusable ACF modules. It deliberately uses native PHP and CSS with no build process.

## Requirements

- WordPress 6.6 or newer
- PHP 7.4 or newer
- Advanced Custom Fields; ACF is not bundled

## Structure

```text
assets/css/                    Theme styles
inc/                           Theme setup and asset registration
parts/modules/                 Portable module packages
acf-json/                      Exported ACF field groups
.agents/skills/                Project-specific and vendored agent skills
```

Keep a module's template and module-specific assets together under `parts/modules/<module-name>/`, with its field-group JSON in `acf-json/`. Shared primitives belong in the theme foundation only when multiple portable modules genuinely need them.

## Public workbench

The front-page template discovers published component pages from the ACF blocks
in their content and presents them as a component directory. Component metadata,
public descriptions, source paths, and display order live in `inc/workbench.php`.

Pages containing a registered workbench component automatically receive a native
“Learn more about this component” disclosure, source and component-note links,
and previous/next component navigation. The header uses the assigned WordPress
menu when one exists and otherwise provides Components, About, and GitHub links.
The About template is selected by the `about-the-workbench` page slug.

Public page titles and documentation use component names without sequence
numbers. Public notes and specifications live under `docs/components/`; the
development history remains available through Git branches and commits.

## Development

Read `AGENTS.md` and the relevant skill before editing. Activate the theme in **Appearance → Themes** when it is ready to use. No database content or ACF field groups are created by the starter.

The official skills in `.agents/skills/` are vendored without changes from [WordPress/agent-skills](https://github.com/WordPress/agent-skills). See each skill's own metadata and license information for compatibility and usage details.

## Licensing

Original project code and documentation are available under the [MIT License](LICENSE). Bundled third-party materials retain their respective licenses; see [Third-party notices](THIRD_PARTY_NOTICES.md) for attribution and scope.
