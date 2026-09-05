(() => {
	'use strict';

	const selector = '[data-meet-the-team]';

	const enhance = (component) => {
		if (component.dataset.meetTheTeamReady === 'true') {
			return;
		}

		const isEditorPreview = component.ownerDocument.body?.classList.contains('block-editor-iframe__body');
		const bioTriggers = Array.from(component.querySelectorAll('[data-team-bio-trigger]'));
		const bioPanels = Array.from(component.querySelectorAll('[data-team-bio-panel]'));
		const activeOpeners = new WeakMap();
		const getPanel = (trigger) => {
			const panelId = trigger.getAttribute('aria-controls');

			return panelId ? component.querySelector(`#${CSS.escape(panelId)}`) : null;
		};
		const getPanelTriggers = (panel) => bioTriggers.filter((trigger) => trigger.getAttribute('aria-controls') === panel.id);
		const closeBio = (panel, restoreFocus = true) => {
			const opener = activeOpeners.get(panel) || getPanelTriggers(panel)[0];

			getPanelTriggers(panel).forEach((trigger) => trigger.setAttribute('aria-expanded', 'false'));
			panel.classList.remove('is-open');
			panel.setAttribute('aria-hidden', 'true');
			panel.inert = true;

			if (restoreFocus && opener) {
				opener.focus({ preventScroll: true });
			}
		};
		const openBio = (trigger) => {
			const panel = getPanel(trigger);

			if (!panel) {
				return;
			}

			bioPanels.forEach((otherPanel) => {
				if (otherPanel !== panel && otherPanel.classList.contains('is-open')) {
					closeBio(otherPanel, false);
				}
			});

			getPanelTriggers(panel).forEach((panelTrigger) => panelTrigger.setAttribute('aria-expanded', 'true'));
			activeOpeners.set(panel, trigger);
			panel.inert = false;
			panel.setAttribute('aria-hidden', 'false');
			panel.classList.add('is-open');
			panel.querySelector('[data-team-bio-close]')?.focus({ preventScroll: true });
		};

		if (!isEditorPreview) {
			bioTriggers.forEach((trigger) => {
				const panel = getPanel(trigger);

				if (!panel) {
					return;
				}

				trigger.disabled = false;
				trigger.addEventListener('click', () => openBio(trigger));
			});

			bioPanels.forEach((panel) => {
				const closeButton = panel.querySelector('[data-team-bio-close]');

				if (!closeButton) {
					return;
				}

				panel.setAttribute('aria-hidden', 'true');
				panel.inert = true;
				closeButton.hidden = false;

				closeButton.addEventListener('click', () => closeBio(panel));
				panel.addEventListener('keydown', (event) => {
					if (event.key === 'Escape') {
						event.preventDefault();
						closeBio(panel);
					}
				});
			});
		}

		const filter = component.querySelector('[data-team-filter]');
		const select = component.querySelector('[data-team-filter-select]');
		const items = Array.from(component.querySelectorAll('.meet-the-team__item'));
		const itemsContainer = component.querySelector('.meet-the-team__grid');
		const status = component.querySelector('.meet-the-team__status');

		if (!isEditorPreview && filter && select && items.length && itemsContainer && status) {
			const targetDocument = component.ownerDocument;
			const targetWindow = targetDocument.defaultView;
			const transitionScope = component.dataset.transitionScope || 'meet-the-team';
			const reducedMotion = targetWindow?.matchMedia('(prefers-reduced-motion: reduce)').matches;
			let isFiltering = false;

			items.forEach((item, index) => {
				item.style.viewTransitionName = `${transitionScope}-card-${index + 1}`;
			});

			const update = () => {
				const department = select.value;
				let visibleCount = 0;

				items.forEach((item) => {
					const visible = department === 'all' || item.dataset.department === department;
					const openPanel = item.querySelector('[data-team-bio-panel].is-open');

					if (!visible && openPanel) {
						closeBio(openPanel, false);
					}

					item.hidden = !visible;
					visibleCount += visible ? 1 : 0;
				});

				const template = visibleCount === 1 ? status.dataset.statusSingular : status.dataset.statusPlural;
				status.textContent = (template || 'Showing %d team members.').replace('%d', String(visibleCount));
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

				const canUseViewTransitions = typeof targetDocument.startViewTransition === 'function' && !reducedMotion;

				if (canUseViewTransitions) {
					setFiltering(true);
					const transition = targetDocument.startViewTransition(update);

					transition.finished.finally(() => setFiltering(false));
					return;
				}

				if (!reducedMotion && targetWindow) {
					setFiltering(true);
					component.classList.add('is-fallback-filtering');

					targetWindow.setTimeout(() => {
						update();
						targetWindow.requestAnimationFrame(() => {
							component.classList.remove('is-fallback-filtering');
							setFiltering(false);
						});
					}, 180);
					return;
				}

				update();
			};

			select.addEventListener('change', selectFilter);
			filter.hidden = false;
		}

		component.dataset.meetTheTeamReady = 'true';
		component.classList.add('is-enhanced');
		component.ownerDocument.defaultView?.requestAnimationFrame(() => {
			component.classList.add('is-bio-ready');
		});
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

	window.acf?.addAction('render_block_preview/type=meet-the-team', (block) => {
		enhanceAll(block?.[0] || document);
	});
})();
