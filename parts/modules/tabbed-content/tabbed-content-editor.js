(() => {
	'use strict';

	const componentSelector = '[data-tabbed-content]';
	const observedDocuments = new WeakSet();
	const observedFrames = new WeakSet();

	const getComponentParts = (component) => {
		const tablist = component.querySelector('[role="tablist"]');
		const tabs = Array.from(component.querySelectorAll('[role="tab"]'));
		const panels = Array.from(component.querySelectorAll('[role="tabpanel"]'));

		if (!tablist || tabs.length < 2 || tabs.length !== panels.length) {
			return null;
		}

		return { tablist, tabs, panels };
	};

	const selectTab = (component, nextTab, moveFocus = true) => {
		const parts = getComponentParts(component);

		if (!parts || !parts.tabs.includes(nextTab)) {
			return;
		}

		parts.tabs.forEach((tab, index) => {
			const selected = tab === nextTab;
			const panel = parts.panels[index];

			tab.setAttribute('aria-selected', selected ? 'true' : 'false');
			tab.tabIndex = selected ? 0 : -1;
			panel.hidden = !selected;
		});

		if (moveFocus) {
			nextTab.focus({ preventScroll: true });
		}
	};

	const enhance = (component) => {
		const parts = getComponentParts(component);

		if (!parts) {
			return;
		}

		const selectedTab = parts.tabs.find((tab) => 'true' === tab.getAttribute('aria-selected')) || parts.tabs[0];

		component.dataset.tabbedContentEditorReady = 'true';
		component.classList.add('is-enhanced');
		parts.tablist.hidden = false;
		selectTab(component, selectedTab, false);
	};

	const enhanceAll = (root) => {
		if (root.matches?.(componentSelector)) {
			enhance(root);
		}

		root.querySelectorAll?.(componentSelector).forEach(enhance);
	};

	const getTabFromEvent = (event) => {
		const view = event.currentTarget.defaultView;
		const target = event.target;

		return view && target instanceof view.Element ? target.closest('[role="tab"]') : null;
	};

	const handlePointer = (event) => {
		const tab = getTabFromEvent(event);
		const component = tab?.closest(componentSelector);

		if (!component) {
			return;
		}

		event.preventDefault();
		event.stopImmediatePropagation();
		selectTab(component, tab);
	};

	const handleKeydown = (event) => {
		const tab = getTabFromEvent(event);
		const component = tab?.closest(componentSelector);
		const parts = component ? getComponentParts(component) : null;

		if (!parts) {
			return;
		}

		const index = parts.tabs.indexOf(tab);
		let nextIndex;

		switch (event.key) {
			case 'ArrowLeft':
				nextIndex = (index - 1 + parts.tabs.length) % parts.tabs.length;
				break;
			case 'ArrowRight':
				nextIndex = (index + 1) % parts.tabs.length;
				break;
			case 'Home':
				nextIndex = 0;
				break;
			case 'End':
				nextIndex = parts.tabs.length - 1;
				break;
			default:
				return;
		}

		event.preventDefault();
		event.stopImmediatePropagation();
		selectTab(component, parts.tabs[nextIndex]);
	};

	const watchFrame = (frame) => {
		if (observedFrames.has(frame)) {
			return;
		}

		observedFrames.add(frame);
		frame.addEventListener('load', () => {
			try {
				watchDocument(frame.contentDocument);
			} catch (error) {
				// Ignore unrelated cross-origin frames in the editor.
			}
		});

		try {
			watchDocument(frame.contentDocument);
		} catch (error) {
			// Ignore unrelated cross-origin frames in the editor.
		}
	};

	const scanFrames = (root) => {
		if ('IFRAME' === root.tagName) {
			watchFrame(root);
		}

		root.querySelectorAll?.('iframe').forEach(watchFrame);
	};

	function watchDocument(doc) {
		if (!doc || observedDocuments.has(doc)) {
			return;
		}

		observedDocuments.add(doc);
		doc.addEventListener('pointerdown', handlePointer, true);
		doc.addEventListener('click', handlePointer, true);
		doc.addEventListener('keydown', handleKeydown, true);

		const start = () => {
			if (!doc.documentElement) {
				return;
			}

			enhanceAll(doc);
			scanFrames(doc);

			const Observer = doc.defaultView.MutationObserver;
			const elementNode = doc.defaultView.Node.ELEMENT_NODE;

			const observer = new Observer((mutations) => {
				mutations.forEach((mutation) => {
					mutation.addedNodes.forEach((node) => {
						if (node.nodeType === elementNode) {
							enhanceAll(node);
							scanFrames(node);
						}
					});
				});
			});

			try {
				observer.observe(doc.documentElement, { childList: true, subtree: true });
			} catch (error) {
				// A just-navigated frame can briefly expose a detached document.
			}
		};

		if (doc.readyState === 'loading') {
			doc.addEventListener('DOMContentLoaded', start, { once: true });
		} else {
			start();
		}
	}

	watchDocument(document);
})();
