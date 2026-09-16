(() => {
	'use strict';

	const selector = '[data-component-directory]';

	const enhance = (component) => {
		if (component.dataset.componentDirectoryReady === 'true') {
			return;
		}

		const filters = component.querySelector('[data-component-directory-filters]');
		const select = component.querySelector('[data-component-directory-filter]');
		const itemsContainer = component.querySelector('[data-component-directory-grid]');
		const items = Array.from(component.querySelectorAll('.component-directory__item'));
		const status = component.querySelector('[data-component-directory-status]');

		if (!filters || !select || select.options.length < 2 || !items.length || !itemsContainer || !status) {
			return;
		}

		const targetDocument = component.ownerDocument;
		const targetWindow = targetDocument.defaultView;
		const transitionScope = component.dataset.transitionScope || 'component-directory';
		const reducedMotion = targetWindow?.matchMedia('(prefers-reduced-motion: reduce)').matches;
		const isEditorPreview = targetDocument.body?.classList.contains('block-editor-iframe__body');
		let isFiltering = false;

		items.forEach((item, index) => {
			item.style.viewTransitionName = `${transitionScope}-card-${index + 1}`;
		});

		const updateStatus = (count) => {
			const template = count === 1 ? status.dataset.statusSingular : status.dataset.statusPlural;

			status.textContent = (template || 'Showing %d components.').replace('%d', String(count));
		};

		const updateResults = () => {
			const filter = select.value || 'all';
			let visibleCount = 0;

			items.forEach((item) => {
				const tags = (item.dataset.tags || '').split(',').filter(Boolean);
				const visible = filter === 'all' || tags.includes(filter);

				item.hidden = !visible;
				visibleCount += visible ? 1 : 0;
			});

			updateStatus(visibleCount);
		};

		const setFiltering = (filtering) => {
			isFiltering = filtering;
			itemsContainer.setAttribute('aria-busy', filtering ? 'true' : 'false');
			select.disabled = filtering;
		};

		const selectFilter = () => {
			if (isFiltering) {
				return;
			}

			const canUseViewTransitions = typeof targetDocument.startViewTransition === 'function' && !reducedMotion && !isEditorPreview;

			if (canUseViewTransitions) {
				setFiltering(true);
				const transition = targetDocument.startViewTransition(updateResults);

				transition.finished.finally(() => setFiltering(false));
				return;
			}

			if (!reducedMotion && !isEditorPreview && targetWindow) {
				setFiltering(true);
				component.classList.add('is-fallback-filtering');

				targetWindow.setTimeout(() => {
					updateResults();
					targetWindow.requestAnimationFrame(() => {
						component.classList.remove('is-fallback-filtering');
						setFiltering(false);
					});
				}, 180);
				return;
			}

			updateResults();
		};

		select.addEventListener('change', selectFilter);

		component.dataset.componentDirectoryReady = 'true';
		component.classList.add('is-enhanced');
		filters.hidden = false;
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

	if (window.acf) {
		window.acf.addAction('render_block_preview', (block) => {
			enhanceAll(block?.[0] || document);
		});
	}
})();
