(() => {
	'use strict';

	const selector = '[data-before-after-comparison]';

	const enhance = (component) => {
		if (component.dataset.beforeAfterReady === 'true') {
			return;
		}

		const stage = component.querySelector('.before-after-comparison__stage');
		const range = component.querySelector('.before-after-comparison__range');
		const controls = component.querySelector('.before-after-comparison__controls');
		const output = component.querySelector('output');
		const afterLabel = component.querySelector('.before-after-comparison__media--after .before-after-comparison__image-label')?.textContent.trim() || 'After';

		if (!stage || !range || !controls || !output) {
			return;
		}

		const update = () => {
			const value = Math.min(100, Math.max(0, Number.parseInt(range.value, 10) || 0));
			const valueText = `${value}% ${afterLabel}`;

			stage.style.setProperty('--before-after-position', `${value}%`);
			range.setAttribute('aria-valuetext', valueText);
			output.value = valueText;
			output.textContent = valueText;
		};

		range.hidden = false;
		controls.hidden = false;
		component.classList.add('is-enhanced');
		range.addEventListener('input', update);
		update();

		const targetWindow = component.ownerDocument.defaultView;

		if (targetWindow) {
			targetWindow.requestAnimationFrame(() => component.classList.add('is-ready'));
		}

		component.dataset.beforeAfterReady = 'true';
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

	window.acf?.addAction('render_block_preview/type=before-after-comparison', (block) => {
		enhanceAll(block?.[0] || document);
	});
})();
