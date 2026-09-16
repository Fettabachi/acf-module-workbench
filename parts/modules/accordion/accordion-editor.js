(() => {
	'use strict';

	const repeaterSelector = '.acf-field-repeater[data-key="field_accordion_items"]';
	let scanQueued = false;

	const getRows = (field) => Array.from(field.querySelectorAll(':scope > .acf-input > .acf-repeater > table > tbody > .acf-row:not(.acf-clone)'));

	const setCollapsedState = (field, shouldCollapse) => {
		getRows(field).forEach((row) => {
			const isCollapsed = row.classList.contains('-collapsed');
			const toggle = row.querySelector(':scope > .acf-row-handle .acf-icon.-collapse');

			if (toggle && isCollapsed !== shouldCollapse) {
				toggle.click();
			}
		});
	};

	const createControl = (label, shouldCollapse) => {
		const button = document.createElement('button');

		button.type = 'button';
		button.className = 'accordion-editor__control';
		button.textContent = label;
		button.dataset.collapseRows = shouldCollapse ? 'true' : 'false';

		return button;
	};

	const enhanceRepeater = (field) => {
		if (field.dataset.accordionControlsReady) {
			return;
		}

		const label = field.querySelector(':scope > .acf-label');

		if (!label) {
			return;
		}

		const controls = document.createElement('div');
		controls.className = 'accordion-editor__controls';
		controls.append(
			createControl('Expand all', false),
			createControl('Collapse all', true),
		);
		controls.addEventListener('click', (event) => {
			const button = event.target.closest('[data-collapse-rows]');

			if (button) {
				setCollapsedState(field, 'true' === button.dataset.collapseRows);
			}
		});
		label.append(controls);
		field.dataset.accordionControlsReady = 'true';
	};

	const scan = () => {
		document.querySelectorAll(repeaterSelector).forEach(enhanceRepeater);
		scanQueued = false;
	};

	const queueScan = () => {
		if (!scanQueued) {
			scanQueued = true;
			window.requestAnimationFrame(scan);
		}
	};

	const observer = new MutationObserver(queueScan);
	observer.observe(document.documentElement, { childList: true, subtree: true });
	queueScan();
})();
