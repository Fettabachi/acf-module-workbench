(() => {
	'use strict';

	const componentSelector = '[data-before-after-comparison]';
	const rangeSelector = '.before-after-comparison__range';
	const observedDocuments = new WeakSet();
	const observedFrames = new WeakSet();
	let activeRange = null;
	let activePointerId = null;

	const getParts = (component) => {
		const stage = component.querySelector('.before-after-comparison__stage');
		const range = component.querySelector(rangeSelector);
		const controls = component.querySelector('.before-after-comparison__controls');
		const output = component.querySelector('output');
		const afterLabel = component.querySelector('.before-after-comparison__media--after .before-after-comparison__image-label')?.textContent.trim() || 'After';

		return stage && range && controls && output ? { stage, range, controls, output, afterLabel } : null;
	};

	const update = (component) => {
		const parts = getParts(component);

		if (!parts) {
			return;
		}

		const value = Math.min(100, Math.max(0, Number.parseInt(parts.range.value, 10) || 0));
		const valueText = `${value}% ${parts.afterLabel}`;

		parts.stage.style.setProperty('--before-after-position', `${value}%`);
		parts.range.setAttribute('aria-valuetext', valueText);
		parts.output.value = valueText;
		parts.output.textContent = valueText;
	};

	const enhance = (component) => {
		const parts = getParts(component);

		if (!parts) {
			return;
		}

		component.classList.add('is-enhanced');
		parts.range.hidden = false;
		parts.controls.hidden = false;
		update(component);
		component.dataset.beforeAfterEditorReady = 'true';
	};

	const enhanceAll = (root) => {
		if (root.matches?.(componentSelector)) {
			enhance(root);
		}

		root.querySelectorAll?.(componentSelector).forEach(enhance);
	};

	const getRangeFromEvent = (event) => {
		const view = event.currentTarget.defaultView;
		const target = event.target;

		return view && target instanceof view.Element ? target.closest(rangeSelector) : null;
	};

	const setValue = (range, nextValue) => {
		const min = Number.parseFloat(range.min) || 0;
		const max = Number.parseFloat(range.max) || 100;
		const value = Math.min(max, Math.max(min, nextValue));

		range.value = String(value);
		update(range.closest(componentSelector));
	};

	const setValueFromPointer = (range, clientX) => {
		const rect = range.getBoundingClientRect();
		const min = Number.parseFloat(range.min) || 0;
		const max = Number.parseFloat(range.max) || 100;
		const step = Number.parseFloat(range.step) || 1;
		const ratio = rect.width > 0 ? Math.min(1, Math.max(0, (clientX - rect.left) / rect.width)) : 0;
		const rawValue = min + ratio * (max - min);
		const steppedValue = min + Math.round((rawValue - min) / step) * step;

		setValue(range, steppedValue);
	};

	const handleInput = (event) => {
		const range = getRangeFromEvent(event);
		const component = range?.closest(componentSelector);

		if (component) {
			update(component);
		}
	};

	const handleKeydown = (event) => {
		const range = getRangeFromEvent(event);

		if (!range) {
			return;
		}

		const current = Number.parseFloat(range.value) || 0;
		const min = Number.parseFloat(range.min) || 0;
		const max = Number.parseFloat(range.max) || 100;
		const step = Number.parseFloat(range.step) || 1;
		let nextValue;

		switch (event.key) {
			case 'ArrowLeft':
			case 'ArrowDown':
				nextValue = current - step;
				break;
			case 'ArrowRight':
			case 'ArrowUp':
				nextValue = current + step;
				break;
			case 'Home':
				nextValue = min;
				break;
			case 'End':
				nextValue = max;
				break;
			case 'PageDown':
				nextValue = current - step * 10;
				break;
			case 'PageUp':
				nextValue = current + step * 10;
				break;
			default:
				return;
		}

		event.preventDefault();
		event.stopImmediatePropagation();
		setValue(range, nextValue);
	};

	const handlePointerDown = (event) => {
		const range = getRangeFromEvent(event);

		if (!range) {
			return;
		}

		event.preventDefault();
		event.stopImmediatePropagation();
		activeRange = range;
		activePointerId = event.pointerId;
		range.focus({ preventScroll: true });
		setValueFromPointer(range, event.clientX);

		try {
			range.setPointerCapture(event.pointerId);
		} catch (error) {
			// Pointer capture may be unavailable during an editor rerender.
		}
	};

	const handlePointerMove = (event) => {
		if (!activeRange || activePointerId !== event.pointerId) {
			return;
		}

		event.preventDefault();
		event.stopImmediatePropagation();
		setValueFromPointer(activeRange, event.clientX);
	};

	const handlePointerEnd = (event) => {
		if (!activeRange || activePointerId !== event.pointerId) {
			return;
		}

		event.preventDefault();
		event.stopImmediatePropagation();
		setValueFromPointer(activeRange, event.clientX);
		activeRange = null;
		activePointerId = null;
	};

	const handleClick = (event) => {
		if (getRangeFromEvent(event)) {
			event.preventDefault();
			event.stopImmediatePropagation();
		}
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
		doc.addEventListener('input', handleInput, true);
		doc.addEventListener('change', handleInput, true);
		doc.addEventListener('keydown', handleKeydown, true);
		doc.addEventListener('pointerdown', handlePointerDown, true);
		doc.addEventListener('pointermove', handlePointerMove, true);
		doc.addEventListener('pointerup', handlePointerEnd, true);
		doc.addEventListener('pointercancel', handlePointerEnd, true);
		doc.addEventListener('click', handleClick, true);

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
