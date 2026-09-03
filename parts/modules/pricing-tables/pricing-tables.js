(() => {
	'use strict';

	const selector = '[data-pricing-tables]';

	const enhance = (component) => {
		if (component.dataset.pricingTablesReady === 'true' || component.dataset.editorPreview === 'true') {
			return;
		}

		const billing = component.querySelector('[data-pricing-billing]');
		const billingInputs = billing?.querySelectorAll('input[type="radio"]') || [];
		const planControls = component.querySelectorAll('[data-pricing-plan-choice]');
		const planCards = component.querySelectorAll('.pricing-tables__plan');

		const updatePrices = (period) => {
			if ('monthly' !== period && 'annual' !== period) {
				return;
			}

			component.querySelectorAll('[data-pricing-value], [data-pricing-suffix]').forEach((node) => {
				if (typeof node.dataset[period] === 'string') {
					node.textContent = node.dataset[period];
				}
			});

			component.dataset.billingPeriod = period;
		};

		billingInputs.forEach((input) => {
			input.addEventListener('change', () => {
				if (input.checked) {
					updatePrices(input.value);
				}
			});
		});

		const selectPlan = (selectedControl) => {
			planControls.forEach((control) => {
				const isSelected = control === selectedControl;

				control.setAttribute('aria-pressed', String(isSelected));
				control.closest('.pricing-tables__plan')?.classList.toggle('is-selected', isSelected);
			});

			if (billing) {
				const supportsBilling = selectedControl?.dataset.supportsBilling === 'true';

				billing.disabled = !supportsBilling;
				billing.setAttribute('aria-disabled', String(!supportsBilling));
			}
		};

		planControls.forEach((control) => {
			control.removeAttribute('hidden');
			control.addEventListener('click', () => selectPlan(control));
			control.addEventListener('keydown', (event) => {
				if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					selectPlan(control);
				}
			});
		});

		planCards.forEach((card) => {
			card.addEventListener('click', (event) => {
				if (event.target.closest('a, button, input, label')) {
					return;
				}

				const control = card.querySelector('[data-pricing-plan-choice]');

				if (control && control.getAttribute('aria-pressed') !== 'true') {
					control.click();
				}
			});
		});

		if (billing) {
			billing.hidden = false;
		}

		selectPlan(component.querySelector('[data-pricing-plan-choice][aria-pressed="true"]') || planControls[0]);
		component.dataset.pricingTablesReady = 'true';
	};

	const enhanceAll = (root = document) => {
		if (root.matches?.(selector)) {
			enhance(root);
		}

		root.querySelectorAll?.(selector).forEach(enhance);
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => enhanceAll(), { once: true });
	} else {
		enhanceAll();
	}

	window.acf?.addAction('render_block_preview/type=pricing-tables', (block) => {
		enhanceAll(block?.[0] || document);
	});
})();
