(() => {
	'use strict';

	const { __ } = window.wp.i18n;
	const repeaterSelector = [
		'.acf-field-repeater[data-key="field_timeline_milestones_entries"]',
		'.acf-field-repeater[data-key="field_timeline_milestones_groups"]',
	].join(',');
	const highlightSelector = '.acf-field[data-key="field_timeline_milestones_highlight"] input[type="checkbox"]';
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
		button.className = 'timeline-milestones-editor__control';
		button.textContent = label;
		button.dataset.collapseRows = shouldCollapse ? 'true' : 'false';

		return button;
	};

	const enhanceRepeater = (field) => {
		if (field.dataset.timelineMilestonesControlsReady) {
			return;
		}

		const label = field.querySelector(':scope > .acf-label');

		if (!label) {
			return;
		}

		const controls = document.createElement('div');
		controls.className = 'timeline-milestones-editor__controls';
		controls.append(
			createControl(__('Expand all', 'acf-module-workbench'), false),
			createControl(__('Collapse all', 'acf-module-workbench'), true),
		);
		controls.addEventListener('click', (event) => {
			const button = event.target.closest('[data-collapse-rows]');

			if (button) {
				setCollapsedState(field, 'true' === button.dataset.collapseRows);
			}
		});
		label.append(controls);
		field.dataset.timelineMilestonesControlsReady = 'true';
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

	document.addEventListener('change', (event) => {
		const input = event.target;

		if (!input.matches(highlightSelector) || !input.checked) {
			return;
		}

		const entries = input.closest('.acf-field-repeater[data-key="field_timeline_milestones_entries"]');

		entries?.querySelectorAll(highlightSelector).forEach((otherInput) => {
			if (otherInput !== input && otherInput.checked) {
				otherInput.checked = false;
				otherInput.dispatchEvent(new Event('change', { bubbles: true }));
			}
		});
	});

	const observer = new MutationObserver(queueScan);
	observer.observe(document.documentElement, { childList: true, subtree: true });
	queueScan();
})();
