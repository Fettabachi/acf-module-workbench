(() => {
	'use strict';

	const selector = '[data-project-gallery]';

	const enhance = (component) => {
		if (component.dataset.projectGalleryReady === 'true' || component.dataset.editorPreview === 'true') {
			return;
		}

		const viewport = component.querySelector('[data-project-gallery-viewport]');
		const items = Array.from(component.querySelectorAll('.project-gallery__item'));
		const triggers = Array.from(component.querySelectorAll('[data-project-gallery-trigger]'));
		const controls = component.querySelector('[data-project-gallery-controls]');
		const slideStatus = component.querySelector('[data-project-gallery-slide-status]');
		const slidePrevious = component.querySelector('[data-project-gallery-slide-previous]');
		const slideNext = component.querySelector('[data-project-gallery-slide-next]');
		const thumbnailNavigation = component.querySelector('[data-project-gallery-thumbnails]');
		const thumbnailList = component.querySelector('.project-gallery__thumbnails');
		const thumbnails = Array.from(component.querySelectorAll('[data-project-gallery-thumbnail]'));
		const dialog = component.querySelector('[data-project-gallery-dialog]');
		const documentElement = component.ownerDocument.documentElement;
		const targetWindow = component.ownerDocument.defaultView;
		const reducedMotion = targetWindow?.matchMedia('(prefers-reduced-motion: reduce)').matches;
		let activeIndex = 0;
		let activeTrigger = null;
		let pointerStart = null;
		let suppressTriggerClick = false;

		if (!viewport || !items.length || items.length !== triggers.length || !controls || !slideStatus || !slidePrevious || !slideNext || !thumbnailNavigation || !thumbnailList || thumbnails.length !== items.length) {
			return;
		}

		const formatPosition = (index) => (slideStatus.dataset.statusTemplate || 'Image %1$d of %2$d')
			.replace('%1$d', String(index + 1))
			.replace('%2$d', String(items.length));
		const setActive = (index, announce = true) => {
			activeIndex = (index + items.length) % items.length;

			items.forEach((item, itemIndex) => {
				item.hidden = itemIndex !== activeIndex;
			});

			thumbnails.forEach((thumbnail, thumbnailIndex) => {
				if (thumbnailIndex === activeIndex) {
					thumbnail.setAttribute('aria-current', 'true');

					if (announce) {
						thumbnailList.scrollTo({
							behavior: reducedMotion ? 'auto' : 'smooth',
							left: thumbnail.offsetLeft - ((thumbnailList.clientWidth - thumbnail.offsetWidth) / 2),
						});
					}
				} else {
					thumbnail.removeAttribute('aria-current');
				}
			});

			if (announce || !slideStatus.textContent) {
				slideStatus.textContent = formatPosition(activeIndex);
			}
		};

		const showPrevious = () => setActive(activeIndex - 1);
		const showNext = () => setActive(activeIndex + 1);

		slidePrevious.addEventListener('click', showPrevious);
		slideNext.addEventListener('click', showNext);

		thumbnails.forEach((thumbnail, index) => {
			thumbnail.addEventListener('click', () => setActive(index));
		});

		viewport.addEventListener('keydown', (event) => {
			if (event.key === 'ArrowLeft') {
				event.preventDefault();
				showPrevious();
			}

			if (event.key === 'ArrowRight') {
				event.preventDefault();
				showNext();
			}
		});

		viewport.addEventListener('pointerdown', (event) => {
			if (!event.isPrimary || 'mouse' === event.pointerType) {
				return;
			}

			pointerStart = { x: event.clientX, y: event.clientY };
		});

		viewport.addEventListener('pointerup', (event) => {
			if (!pointerStart || !event.isPrimary || 'mouse' === event.pointerType) {
				pointerStart = null;
				return;
			}

			const horizontalDistance = event.clientX - pointerStart.x;
			const verticalDistance = event.clientY - pointerStart.y;
			pointerStart = null;

			if (Math.abs(horizontalDistance) < 48 || Math.abs(horizontalDistance) <= Math.abs(verticalDistance)) {
				return;
			}

			suppressTriggerClick = true;
			horizontalDistance > 0 ? showPrevious() : showNext();
			targetWindow?.setTimeout(() => {
				suppressTriggerClick = false;
			}, 0);
		});

		viewport.addEventListener('pointercancel', () => {
			pointerStart = null;
		});

		controls.hidden = false;
		thumbnailNavigation.hidden = false;
		setActive(0, false);
		component.classList.add('is-enhanced');

		if (!dialog || 'function' !== typeof dialog.showModal) {
			component.dataset.projectGalleryReady = 'true';
			return;
		}

		const dialogImage = dialog.querySelector('[data-project-gallery-image]');
		const dialogCaption = dialog.querySelector('[data-project-gallery-caption]');
		const dialogStatus = dialog.querySelector('[data-project-gallery-status]');
		const closeButton = dialog.querySelector('[data-project-gallery-close]');
		const dialogPrevious = dialog.querySelector('[data-project-gallery-previous]');
		const dialogNext = dialog.querySelector('[data-project-gallery-next]');

		if (!dialogImage || !dialogCaption || !dialogStatus || !closeButton || !dialogPrevious || !dialogNext) {
			component.dataset.projectGalleryReady = 'true';
			return;
		}

		const updateDialog = (index) => {
			setActive(index);
			activeTrigger = triggers[activeIndex];

			const trigger = triggers[activeIndex];
			const sourceImage = trigger.querySelector('img');
			const caption = trigger.closest('figure')?.querySelector('.project-gallery__caption')?.textContent.trim() || '';

			if (!sourceImage) {
				return;
			}

			dialogImage.src = trigger.href;
			dialogImage.alt = sourceImage.alt;
			dialogCaption.textContent = caption;
			dialogCaption.hidden = !caption;

			const template = dialog.dataset.statusTemplate || 'Image %1$d of %2$d';
			dialogStatus.textContent = template
				.replace('%1$d', String(activeIndex + 1))
				.replace('%2$d', String(triggers.length));
		};

		const openDialog = (trigger, index) => {
			activeTrigger = trigger;
			updateDialog(index);
			dialog.showModal();
			documentElement.classList.add('project-gallery-dialog-open');
			closeButton.focus({ preventScroll: true });
		};

		triggers.forEach((trigger, index) => {
			trigger.addEventListener('click', (event) => {
				if (suppressTriggerClick) {
					event.preventDefault();
					return;
				}

				event.preventDefault();
				openDialog(trigger, index);
			});
		});

		closeButton.addEventListener('click', () => dialog.close());
		dialogPrevious.addEventListener('click', () => updateDialog(activeIndex - 1));
		dialogNext.addEventListener('click', () => updateDialog(activeIndex + 1));

		dialog.addEventListener('keydown', (event) => {
			if (event.key === 'ArrowLeft') {
				event.preventDefault();
				updateDialog(activeIndex - 1);
			}

			if (event.key === 'ArrowRight') {
				event.preventDefault();
				updateDialog(activeIndex + 1);
			}
		});

		dialog.addEventListener('click', (event) => {
			if (event.target === dialog) {
				dialog.close();
			}
		});

		dialog.addEventListener('close', () => {
			const hasOpenGalleryDialog = component.ownerDocument.querySelector('[data-project-gallery-dialog][open]');

			documentElement.classList.toggle('project-gallery-dialog-open', Boolean(hasOpenGalleryDialog));
			activeTrigger?.focus({ preventScroll: true });
		});

		component.dataset.projectGalleryReady = 'true';
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

	window.acf?.addAction('render_block_preview/type=project-gallery', (block) => {
		enhanceAll(block?.[0] || document);
	});
})();
