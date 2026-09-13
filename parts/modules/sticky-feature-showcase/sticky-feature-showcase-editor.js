(() => {
	'use strict';

	const { __ } = window.wp.i18n;
	const repeaterSelector = '.acf-field-repeater[data-key="field_sticky_feature_showcase_steps"]';
	const previewSelector = '[data-sticky-feature-showcase][data-editor-preview]';
	const observedDocuments = new WeakSet();
	const observedFrames = new WeakSet();

	const getRows = (field) => Array.from(field.querySelectorAll(':scope > .acf-input > .acf-repeater > table > tbody > .acf-row:not(.acf-clone)'));
	const setRows = (field, collapse) => getRows(field).forEach((row) => {
		const toggle = row.querySelector(':scope > .acf-row-handle .acf-icon.-collapse');
		if (toggle && row.classList.contains('-collapsed') !== collapse) toggle.click();
	});

	const enhanceRepeater = (field) => {
		if (field.dataset.showcaseControlsReady) return;

		const label = field.querySelector(':scope > .acf-label');
		if (!label) return;

		const controls = field.ownerDocument.createElement('div');
		controls.className = 'sticky-feature-showcase-editor__controls';
		[
			[__('Expand all', 'acf-module-workbench'), false],
			[__('Collapse all', 'acf-module-workbench'), true],
		].forEach(([text, collapse]) => {
			const button = field.ownerDocument.createElement('button');
			button.type = 'button';
			button.className = 'sticky-feature-showcase-editor__control';
			button.textContent = text;
			button.addEventListener('click', () => setRows(field, collapse));
			controls.append(button);
		});
		label.append(controls);
		field.dataset.showcaseControlsReady = 'true';
	};

	const enhancePreview = (component) => {
		if (component.dataset.showcaseEditorReady) return;

		const doc = component.ownerDocument;
		const view = doc.defaultView;
		const column = component.querySelector('.sticky-feature-showcase__visual-column');
		const steps = Array.from(component.querySelectorAll('[data-showcase-step]'));
		if (!view || !column || steps.length < 2) return;

		const visuals = steps.map((step, index) => {
			const image = step.querySelector('.sticky-feature-showcase__image');
			if (!image) return null;

			const figure = doc.createElement('figure');
			figure.className = 'sticky-feature-showcase__visual';
			figure.dataset.visualIndex = String(index);

			const clone = image.cloneNode(true);
			clone.alt = '';
			clone.setAttribute('aria-hidden', 'true');
			figure.append(clone);
			column.append(figure);
			return figure;
		});

		if (visuals.some((visual) => !visual)) {
			column.replaceChildren();
			return;
		}

		let activeIndex = -1;
		let frame = 0;
		const controller = new view.AbortController();
		const activate = (index) => {
			if (index === activeIndex) return;
			activeIndex = index;
			steps.forEach((step, itemIndex) => step.classList.toggle('is-active', itemIndex === index));
			visuals.forEach((visual, itemIndex) => visual.classList.toggle('is-active', itemIndex === index));
		};
		const update = () => {
			frame = 0;
			if (!component.isConnected) {
				controller.abort();
				return;
			}

			const readingLine = view.innerHeight * .5;
			let nearestIndex = 0;
			let nearestDistance = Number.POSITIVE_INFINITY;
			steps.forEach((step, index) => {
				const rect = step.getBoundingClientRect();
				const distance = Math.abs(rect.top + (rect.height / 2) - readingLine);
				if (distance < nearestDistance) {
					nearestDistance = distance;
					nearestIndex = index;
				}
			});
			activate(nearestIndex);
		};
		const queueUpdate = () => {
			if (!frame) frame = view.requestAnimationFrame(update);
		};

		component.classList.add('is-enhanced');
		component.dataset.showcaseEditorReady = 'true';
		doc.addEventListener('scroll', queueUpdate, { passive: true, capture: true, signal: controller.signal });
		view.addEventListener('resize', queueUpdate, { passive: true, signal: controller.signal });
		update();
	};

	const scan = (root) => {
		if (root.matches?.(repeaterSelector)) enhanceRepeater(root);
		if (root.matches?.(previewSelector)) enhancePreview(root);
		root.querySelectorAll?.(repeaterSelector).forEach(enhanceRepeater);
		root.querySelectorAll?.(previewSelector).forEach(enhancePreview);
		if ('IFRAME' === root.tagName) watchFrame(root);
		root.querySelectorAll?.('iframe').forEach(watchFrame);
	};

	function watchFrame(frame) {
		if (observedFrames.has(frame)) return;
		observedFrames.add(frame);
		frame.addEventListener('load', () => {
			try { watchDocument(frame.contentDocument); } catch (error) { /* Ignore cross-origin editor frames. */ }
		});
		try { watchDocument(frame.contentDocument); } catch (error) { /* Ignore cross-origin editor frames. */ }
	}

	function watchDocument(doc) {
		if (!doc || observedDocuments.has(doc)) return;
		observedDocuments.add(doc);

		const start = () => {
			if (!doc.documentElement) return;
			scan(doc);
			const Observer = doc.defaultView.MutationObserver;
			const elementNode = doc.defaultView.Node.ELEMENT_NODE;
			new Observer((mutations) => mutations.forEach((mutation) => mutation.addedNodes.forEach((node) => {
				if (node.nodeType === elementNode) scan(node);
			}))).observe(doc.documentElement, { childList: true, subtree: true });
		};

		if ('loading' === doc.readyState) doc.addEventListener('DOMContentLoaded', start, { once: true });
		else start();
	}

	watchDocument(document);
})();
