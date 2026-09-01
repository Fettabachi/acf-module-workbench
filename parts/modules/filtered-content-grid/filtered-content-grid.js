(() => {
	'use strict';

	const selector = '[data-filtered-content-grid]';

	const enhance = (component) => {
		if (component.dataset.filteredContentGridReady === 'true') {
			return;
		}

		const filters = component.querySelector('.filtered-content-grid__filters');
		const buttons = Array.from(component.querySelectorAll('.filtered-content-grid__filter'));
		const items = Array.from(component.querySelectorAll('.filtered-content-grid__item'));
		const itemsContainer = component.querySelector('.filtered-content-grid__items');
		const status = component.querySelector('.filtered-content-grid__status');

		if (!filters || buttons.length < 3 || !items.length || !itemsContainer || !status) {
			return;
		}

		const targetDocument = component.ownerDocument;
		const targetWindow = targetDocument.defaultView;
		const transitionScope = component.dataset.transitionScope || 'filtered-content-grid';
		const reducedMotion = targetWindow?.matchMedia('(prefers-reduced-motion: reduce)').matches;
		const isEditorPreview = targetDocument.body?.classList.contains('block-editor-iframe__body');
		let isFiltering = false;

		items.forEach((item, index) => {
			item.style.viewTransitionName = `${transitionScope}-card-${index + 1}`;
		});

		const updateStatus = (count) => {
			const template = count === 1 ? status.dataset.statusSingular : status.dataset.statusPlural;

			status.textContent = (template || 'Showing %d articles.').replace('%d', String(count));
		};

		const updateResults = (selectedButton) => {
			const filter = selectedButton.dataset.filter || 'all';
			let visibleCount = 0;

			buttons.forEach((button) => {
				button.setAttribute('aria-pressed', button === selectedButton ? 'true' : 'false');
			});

			items.forEach((item) => {
				const categories = (item.dataset.categories || '').split(',').filter(Boolean);
				const visible = filter === 'all' || categories.includes(filter);

				item.hidden = !visible;
				visibleCount += visible ? 1 : 0;
			});

			updateStatus(visibleCount);
		};

		const setFiltering = (filtering) => {
			isFiltering = filtering;
			itemsContainer.setAttribute('aria-busy', filtering ? 'true' : 'false');
			buttons.forEach((button) => {
				button.disabled = filtering;
			});
		};

		const selectFilter = (selectedButton) => {
			if (isFiltering || selectedButton.getAttribute('aria-pressed') === 'true') {
				return;
			}

			const canUseViewTransitions = typeof targetDocument.startViewTransition === 'function' && !reducedMotion && !isEditorPreview;

			if (canUseViewTransitions) {
				setFiltering(true);
				const transition = targetDocument.startViewTransition(() => updateResults(selectedButton));

				transition.finished.finally(() => setFiltering(false));
				return;
			}

			if (!reducedMotion && !isEditorPreview && targetWindow) {
				setFiltering(true);
				component.classList.add('is-fallback-filtering');

				targetWindow.setTimeout(() => {
					updateResults(selectedButton);
					targetWindow.requestAnimationFrame(() => {
						component.classList.remove('is-fallback-filtering');
						setFiltering(false);
					});
				}, 180);
				return;
			}

			updateResults(selectedButton);
		};

		buttons.forEach((button) => {
			button.addEventListener('click', () => selectFilter(button));
		});

		component.dataset.filteredContentGridReady = 'true';
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

	window.acf?.addAction('render_block_preview/type=filtered-content-grid', (block) => {
		enhanceAll(block?.[0] || document);
	});
})();
