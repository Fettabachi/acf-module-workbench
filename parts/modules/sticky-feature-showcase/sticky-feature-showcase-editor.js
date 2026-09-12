(() => {
	'use strict';
	const { __ } = window.wp.i18n;
	const selector = '.acf-field-repeater[data-key="field_sticky_feature_showcase_steps"]';
	const getRows = (field) => Array.from(field.querySelectorAll(':scope > .acf-input > .acf-repeater > table > tbody > .acf-row:not(.acf-clone)'));
	const setRows = (field, collapse) => getRows(field).forEach((row) => {
		const toggle = row.querySelector(':scope > .acf-row-handle .acf-icon.-collapse');
		if (toggle && row.classList.contains('-collapsed') !== collapse) toggle.click();
	});
	const enhance = (field) => {
		if (field.dataset.showcaseControlsReady) return;
		const label = field.querySelector(':scope > .acf-label');
		if (!label) return;
		const controls = document.createElement('div');
		controls.className = 'sticky-feature-showcase-editor__controls';
		[
			[__('Expand all', 'acf-module-workbench'), false],
			[__('Collapse all', 'acf-module-workbench'), true],
		].forEach(([text, collapse]) => {
			const button = document.createElement('button');
			button.type = 'button';
			button.className = 'sticky-feature-showcase-editor__control';
			button.textContent = text;
			button.addEventListener('click', () => setRows(field, collapse));
			controls.append(button);
		});
		label.append(controls);
		field.dataset.showcaseControlsReady = 'true';
	};
	const scan = () => document.querySelectorAll(selector).forEach(enhance);
	new MutationObserver(scan).observe(document.documentElement, { childList: true, subtree: true });
	scan();
})();
