# ACF Module Workbench

A lightweight custom WordPress theme for building agency-style frontends and reusable ACF modules. It deliberately uses native PHP and CSS with no build process.

## Requirements

- WordPress 6.6 or newer
- PHP 7.4 or newer
- Advanced Custom Fields only for exercises that require it; ACF is not bundled

## Structure

```text
assets/css/                    Theme styles
inc/                           Theme setup and asset registration
parts/modules/                 Portable module packages
acf-json/                      Exported ACF field groups
.agents/skills/                Project-specific and vendored agent skills
```

Keep a module's template and module-specific assets together under `parts/modules/<module-name>/`, with its field-group JSON in `acf-json/`. Shared primitives belong in the theme foundation only when multiple portable modules genuinely need them.

## Development

Read `AGENTS.md` and the relevant skill before editing. Activate the theme in **Appearance → Themes** when it is ready to use. No database content or ACF field groups are created by the starter.

The official skills in `.agents/skills/` are vendored without changes from [WordPress/agent-skills](https://github.com/WordPress/agent-skills). See each skill's own metadata and license information for compatibility and usage details.
