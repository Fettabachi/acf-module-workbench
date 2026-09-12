(() => {
	'use strict';

	const selector = '[data-sticky-feature-showcase]:not([data-editor-preview])';

	const enhance = (component) => {
		if (component.dataset.showcaseReady) return;

		const column = component.querySelector('.sticky-feature-showcase__visual-column');
		const steps = Array.from(component.querySelectorAll('[data-showcase-step]'));
		if (!column || steps.length < 2) return;

		const visuals = steps.map((step, index) => {
			const image = step.querySelector('.sticky-feature-showcase__image');
			if (!image) return null;

			const figure = document.createElement('figure');
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
		const controller = new AbortController();
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
			const readingLine = window.innerHeight * .5;
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
			if (!frame) frame = window.requestAnimationFrame(update);
		};

		component.classList.add('is-enhanced');
		component.dataset.showcaseReady = 'true';
		document.addEventListener('scroll', queueUpdate, { passive: true, capture: true, signal: controller.signal });
		window.addEventListener('resize', queueUpdate, { passive: true, signal: controller.signal });
		update();
	};

	const scan = (root = document) => {
		if (root.matches?.(selector)) enhance(root);
		root.querySelectorAll?.(selector).forEach(enhance);
	};

	scan();
	new MutationObserver((mutations) => mutations.forEach((mutation) => mutation.addedNodes.forEach((node) => {
		if (node.nodeType === 1) scan(node);
	}))).observe(document.documentElement, { childList: true, subtree: true });
})();
