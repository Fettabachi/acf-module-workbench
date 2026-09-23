(() => {
	'use strict';

	const selector = '.acf-field-repeater[data-key="field_why_choose_us_reasons"]';
	let scanQueued = false;
	const rows = (field) => Array.from(field.querySelectorAll(':scope > .acf-input > .acf-repeater > table > tbody > .acf-row:not(.acf-clone)'));

	const enhance = (field) => {
		if (field.dataset.whyChooseUsControlsReady) return;
		const label = field.querySelector(':scope > .acf-label');
		if (!label) return;

		const controls = document.createElement('div');
		controls.className = 'why-choose-us-editor__controls';
		[false, true].forEach((collapse) => {
			const button = document.createElement('button');
			button.type = 'button';
			button.className = 'why-choose-us-editor__control';
			button.textContent = window.wp.i18n.__(collapse ? 'Collapse all' : 'Expand all', 'acf-module-workbench');
			button.addEventListener('click', () => {
				rows(field).forEach((row) => {
					const toggle = row.querySelector(':scope > .acf-row-handle .acf-icon.-collapse');
					if (toggle && row.classList.contains('-collapsed') !== collapse) toggle.click();
				});
			});
			controls.append(button);
		});
		label.append(controls);
		field.dataset.whyChooseUsControlsReady = 'true';
	};

	const scan = () => {
		document.querySelectorAll(selector).forEach(enhance);
		scanQueued = false;
	};
	new MutationObserver(() => {
		if (!scanQueued) {
			scanQueued = true;
			window.requestAnimationFrame(scan);
		}
	}).observe(document.documentElement, { childList: true, subtree: true });
	scan();
})();
