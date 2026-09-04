# Tabbed Content

## Overview

Tabbed Content presents a small group of parallel topics in one location, helping visitors compare or move between related information.

## Component contract

Editors provide section copy and repeatable items with a short tab label and corresponding panel content.

## Implementation decisions

- The enhanced interface follows the expected tab, tabpanel, and arrow-key interaction model.
- Identifiers are unique to each component instance.
- Without JavaScript, all panels remain readable in document order.
- Overflow behavior keeps the tab list usable when labels exceed the available width.

## Accessibility and defensive behavior

Native buttons provide keyboard activation, selected state is exposed programmatically, and focus moves predictably with arrow keys. Empty labels or panels are excluded safely.

## Validation

The component was reviewed with keyboard and pointer input, disabled JavaScript, long labels, multiple instances, and narrow through wide viewports. Editor presentation and PHP syntax were also checked.

## Tradeoffs and future improvements

Tabs are best for a small number of closely related topics. Longer or independently valuable sections should use ordinary page content or an accordion instead.

## Source

- [Component package](../../parts/modules/tabbed-content/)
- [Component specification](tabbed-content-specification.md)
