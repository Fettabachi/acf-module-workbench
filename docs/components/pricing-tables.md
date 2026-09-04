# Pricing Tables

## Overview

Pricing Tables compares product plans with responsive cards and optional progressive billing controls.

## Component contract

Editors control section copy, billing labels, plan names, structured prices, feature lists, emphasis, and destination links. The expanded editor view gives this structured content enough room to remain usable.

## Implementation decisions

- Default prices are rendered in HTML and remain readable without JavaScript.
- Native radio controls switch eligible plans between billing periods.
- A featured-plan option adds editorial emphasis without changing document order.
- Each plan keeps an explicit destination link instead of making the entire card ambiguous.

## Accessibility and defensive behavior

Billing choices and selected plans expose state programmatically, support keyboard input, and retain visible focus. Incomplete price variants do not create nonfunctional controls.

## Validation

The component was reviewed with one through three plans, mixed billing eligibility, long feature lists, keyboard interaction, disabled JavaScript, and narrow through wide layouts. Editor behavior and PHP syntax were checked.

## Tradeoffs and future improvements

The pricing model favors common recurring-price comparisons and does not attempt to cover every commerce model. Usage-based or heavily configurable pricing would benefit from a separate component.

## Source

- [Component package](../../parts/modules/pricing-tables/)
- [Component specification](pricing-tables-specification.md)
