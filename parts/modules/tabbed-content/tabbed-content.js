(() => {
	'use strict';

	const selector = '[data-tabbed-content]';

	const enhance = (component) => {
		if (component.dataset.tabbedContentReady === 'true') {
			return;
		}

		const tablist = component.querySelector('[role="tablist"]');
		const tabs = Array.from(component.querySelectorAll('[role="tab"]'));
		const panels = Array.from(component.querySelectorAll('[role="tabpanel"]'));

		if (!tablist || tabs.length < 2 || tabs.length !== panels.length) {
			return;
		}

		const selectTab = (nextTab, moveFocus = true) => {
			tabs.forEach((tab) => {
				const selected = tab === nextTab;
				const panel = component.querySelector(`#${CSS.escape(tab.getAttribute('aria-controls'))}`);

				tab.setAttribute('aria-selected', selected ? 'true' : 'false');
				tab.tabIndex = selected ? 0 : -1;

				if (panel) {
					panel.hidden = !selected;
				}
			});

			if (moveFocus) {
				nextTab.focus();
			}
		};

		tabs.forEach((tab, index) => {
			tab.addEventListener('click', () => selectTab(tab));
			tab.addEventListener('keydown', (event) => {
				let nextIndex;

				switch (event.key) {
					case 'ArrowLeft':
						nextIndex = (index - 1 + tabs.length) % tabs.length;
						break;
					case 'ArrowRight':
						nextIndex = (index + 1) % tabs.length;
						break;
					case 'Home':
						nextIndex = 0;
						break;
					case 'End':
						nextIndex = tabs.length - 1;
						break;
					default:
						return;
				}

				event.preventDefault();
				selectTab(tabs[nextIndex]);
			});
		});

		component.dataset.tabbedContentReady = 'true';
		component.classList.add('is-enhanced');
		tablist.hidden = false;
		selectTab(tabs[0], false);
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

	window.acf?.addAction('render_block_preview/type=tabbed-content', (block) => {
		enhanceAll(block?.[0] || document);
	});
})();
