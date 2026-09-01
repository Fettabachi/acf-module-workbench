(() => {
	'use strict';

	const { __, sprintf } = window.wp.i18n;
	const fieldSelector = '.acf-field[data-key="field_curated_content_grid_posts"]';
	const editorVersion = '1.2.11';
	const listObservers = new WeakMap();
	let uniqueId = 0;
	let scanScheduled = false;

	const nextId = (suffix) => {
		uniqueId += 1;
		return `curated-content-grid-editor-${suffix}-${uniqueId}`;
	};

	const getItemTitle = (item) => {
		const existingLabel = item.querySelector('.curated-content-grid-editor__item-label');

		if (existingLabel) {
			return existingLabel.textContent.trim();
		}

		const copy = item.cloneNode(true);
		copy.querySelectorAll('a, button, input, .thumbnail').forEach((element) => element.remove());

		return copy.textContent.trim() || __('Selected post', 'cr-practice');
	};

	const createMoveButton = (direction, title) => {
		const button = document.createElement('button');
		const label = 'up' === direction ? __('Move up', 'cr-practice') : __('Move down', 'cr-practice');

		button.type = 'button';
		button.className = 'curated-content-grid-editor__move';
		button.dataset.curatedContentGridMove = direction;
		button.setAttribute('aria-label', sprintf(__('%1$s: %2$s', 'cr-practice'), label, title));
		button.title = label;
		button.innerHTML = 'up' === direction ? '<span aria-hidden="true">↑</span>' : '<span aria-hidden="true">↓</span>';

		return button;
	};

	const enhanceItem = (item, index, itemCount) => {
		const title = getItemTitle(item);
		let order = item.querySelector('.curated-content-grid-editor__item-order');
		let label = item.querySelector('.curated-content-grid-editor__item-label');
		let moveUp = item.querySelector('[data-curated-content-grid-move="up"]');
		let moveDown = item.querySelector('[data-curated-content-grid-move="down"]');
		const remove = item.querySelector(':scope > [data-name="remove_item"]');

		if (!label) {
			label = document.createElement('span');
			label.className = 'curated-content-grid-editor__item-label';

			Array.from(item.childNodes).forEach((node) => {
				if (node !== remove) {
					label.append(node);
				}
			});

			item.prepend(label);
		}

		if (!order) {
			order = document.createElement('span');
			order.className = 'curated-content-grid-editor__item-order';
			order.setAttribute('aria-hidden', 'true');
			item.prepend(order);
		}

		if (!moveUp) {
			moveUp = createMoveButton('up', title);
			item.append(moveUp);
		}

		if (!moveDown) {
			moveDown = createMoveButton('down', title);
			item.append(moveDown);
		}

		if (remove) {
			remove.classList.remove('dark', 'small');
			remove.classList.add('curated-content-grid-editor__remove');
			remove.setAttribute('aria-label', sprintf(__('Remove: %s', 'cr-practice'), title));
			remove.title = __('Remove', 'cr-practice');
		}

		item.classList.add('curated-content-grid-editor__item');
		item.removeAttribute('tabindex');
		order.textContent = String(index + 1);
		moveUp.disabled = 0 === index;
		moveDown.disabled = index === itemCount - 1;
	};

	const getStatusText = (itemCount) => sprintf(__('%d selected', 'cr-practice'), itemCount);

	const updateField = (field) => {
		const relationship = field.querySelector('.acf-relationship');
		const valuesList = relationship?.querySelector('.values-list');
		const items = valuesList ? Array.from(valuesList.children).filter((item) => item.matches('li')) : [];
		const nextStatus = getStatusText(items.length);

		items.forEach((listItem, index) => {
			const item = listItem.querySelector(':scope > .acf-rel-item');

			if (item) {
				enhanceItem(item, index, items.length);
			}
		});

		field.querySelectorAll('[data-curated-content-grid-status]').forEach((status) => {
			if (status.textContent !== nextStatus) {
				status.textContent = nextStatus;
			}
		});
	};

	const addListHeading = (container, labelText, list, includeStatus = false) => {
		const heading = document.createElement('div');
		const label = document.createElement('span');
		const headingId = nextId('list');

		heading.className = 'curated-content-grid-editor__list-heading';
		label.id = headingId;
		label.textContent = labelText;
		heading.append(label);
		list.setAttribute('aria-labelledby', headingId);

		if (includeStatus) {
			const status = document.createElement('span');

			status.dataset.curatedContentGridStatus = 'true';
			status.setAttribute('aria-live', 'polite');
			status.textContent = getStatusText(0);
			heading.append(status);
		}

		container.prepend(heading);
	};

	const setupDialog = (field) => {
		if (field.dataset.curatedContentGridDialogReady || 'function' !== typeof document.createElement('dialog').showModal) {
			return;
		}

		const input = field.querySelector(':scope > .acf-input');

		if (!input) {
			return;
		}

		const launcher = document.createElement('div');
		const openButton = document.createElement('button');
		const launcherStatus = document.createElement('span');
		const dialog = document.createElement('dialog');
		const dialogHeader = document.createElement('div');
		const dialogTitle = document.createElement('h2');
		const closeButton = document.createElement('button');
		const dialogBody = document.createElement('div');
		const titleId = nextId('dialog-title');

		launcher.className = 'curated-content-grid-editor__launcher';
		openButton.type = 'button';
		openButton.className = 'curated-content-grid-editor__open';
		openButton.textContent = __('Manage posts', 'cr-practice');
		launcherStatus.className = 'curated-content-grid-editor__launcher-status';
		launcherStatus.dataset.curatedContentGridStatus = 'true';
		launcherStatus.textContent = getStatusText(0);
		launcher.append(openButton, launcherStatus);

		dialog.className = 'curated-content-grid-editor__dialog';
		dialog.setAttribute('aria-labelledby', titleId);
		dialogHeader.className = 'curated-content-grid-editor__dialog-header';
		dialogTitle.id = titleId;
		dialogTitle.className = 'curated-content-grid-editor__dialog-title';
		dialogTitle.textContent = __('Manage curated posts', 'cr-practice');
		closeButton.type = 'button';
		closeButton.className = 'curated-content-grid-editor__close';
		closeButton.setAttribute('aria-label', __('Close post manager', 'cr-practice'));
		closeButton.innerHTML = '<span aria-hidden="true">×</span>';
		dialogHeader.append(dialogTitle, closeButton);
		dialogBody.className = 'curated-content-grid-editor__dialog-body';
		dialogBody.append(input);
		dialog.append(dialogHeader, dialogBody);
		field.append(launcher, dialog);
		field.dataset.curatedContentGridDialogReady = 'true';

		const closeDialog = () => {
			if (dialog.open) {
				dialog.close();
			}
		};
		const clearSearch = () => {
			const search = dialog.querySelector('input[data-filter="s"]');

			if (!search || '' === search.value) {
				return;
			}

			search.value = '';
			search.dispatchEvent(new Event('change', { bubbles: true }));
		};

		openButton.addEventListener('click', () => {
			dialog.showModal();
			field.classList.add('is-dialog-open');

			window.requestAnimationFrame(() => {
				dialog.querySelector('input[data-filter="s"]')?.focus({ preventScroll: true });
			});
		});

		closeButton.addEventListener('click', closeDialog);
		dialog.addEventListener('close', () => {
			clearSearch();
			field.classList.remove('is-dialog-open');
			openButton.focus({ preventScroll: true });
		});
		dialog.addEventListener('click', (event) => {
			if (event.target !== dialog) {
				return;
			}

			const bounds = dialog.getBoundingClientRect();
			const withinDialog = event.clientX >= bounds.left && event.clientX <= bounds.right && event.clientY >= bounds.top && event.clientY <= bounds.bottom;

			if (!withinDialog) {
				closeDialog();
			}
		});
	};

	const enhanceField = (field) => {
		field.classList.add('curated-content-grid-editor');
		field.dataset.curatedContentGridEditorVersion = editorVersion;
		setupDialog(field);

		const relationship = field.querySelector('.acf-relationship');
		const choices = relationship?.querySelector('.choices');
		const values = relationship?.querySelector('.values');
		const choicesList = choices?.querySelector('.choices-list');
		const valuesList = values?.querySelector('.values-list');

		if (!relationship || !choices || !values || !choicesList || !valuesList) {
			return;
		}

		if (!choices.querySelector(':scope > .curated-content-grid-editor__list-heading')) {
			addListHeading(choices, __('Available posts', 'cr-practice'), choicesList);
		}

		if (!values.querySelector(':scope > .curated-content-grid-editor__list-heading')) {
			addListHeading(values, __('Selected posts', 'cr-practice'), valuesList, true);
		}

		if (!listObservers.has(valuesList)) {
			const Observer = valuesList.ownerDocument.defaultView.MutationObserver;
			const observer = new Observer(() => updateField(field));

			observer.observe(valuesList, { childList: true });
			listObservers.set(valuesList, observer);
		}

		updateField(field);
	};

	const scan = (root = document) => {
		if (root.matches?.(fieldSelector)) {
			enhanceField(root);
		}

		root.querySelectorAll?.(fieldSelector).forEach(enhanceField);
	};

	const scheduleScan = () => {
		if (scanScheduled) {
			return;
		}

		scanScheduled = true;
		window.requestAnimationFrame(() => {
			scanScheduled = false;
			scan();
		});
	};

	document.addEventListener('click', (event) => {
		const button = event.target.closest?.('[data-curated-content-grid-move]');

		if (!button) {
			return;
		}

		const field = button.closest(fieldSelector);
		const listItem = button.closest('li');
		const valuesList = listItem?.parentElement;
		const direction = button.dataset.curatedContentGridMove;
		const sibling = 'up' === direction ? listItem?.previousElementSibling : listItem?.nextElementSibling;

		if (!field || !listItem || !valuesList || !sibling) {
			return;
		}

		event.preventDefault();
		event.stopPropagation();

		if ('up' === direction) {
			valuesList.insertBefore(listItem, sibling);
		} else {
			valuesList.insertBefore(sibling, listItem);
		}

		const input = field.querySelector('.acf-relationship > input[type="hidden"]');

		input?.dispatchEvent(new Event('change', { bubbles: true }));
		updateField(field);
		button.focus({ preventScroll: true });
	});

	const start = () => {
		scan();

		const observer = new MutationObserver((mutations) => {
			for (const mutation of mutations) {
				for (const node of mutation.addedNodes) {
					if (node.nodeType === Node.ELEMENT_NODE && (node.matches?.(fieldSelector) || node.closest?.(fieldSelector) || node.querySelector?.(fieldSelector))) {
						scheduleScan();
						return;
					}
				}
			}
		});

		observer.observe(document.documentElement, { childList: true, subtree: true });
	};

	if ('loading' === document.readyState) {
		document.addEventListener('DOMContentLoaded', start, { once: true });
	} else {
		start();
	}
})();
