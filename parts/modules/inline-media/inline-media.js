(() => {
	'use strict';

	const selector = '[data-inline-media]';

	const enhancePlayer = (component) => {
		const video = component.querySelector('.inline-media__video');
		const playButton = component.querySelector('[data-inline-media-play]');
		const poster = component.querySelector('[data-inline-media-poster]');

		if (!video || !playButton) {
			return;
		}

		const restoreNativePlayer = () => {
			video.controls = true;
			playButton.hidden = true;
			component.classList.add('is-started');
		};

		playButton.addEventListener('click', () => {
			video.controls = true;
			playButton.hidden = true;
			video.tabIndex = 0;
			video.focus({ preventScroll: true });
			video.addEventListener('playing', () => component.classList.add('is-started'), { once: true });

			const playAttempt = video.play();

			if (playAttempt && typeof playAttempt.catch === 'function') {
				playAttempt.catch(restoreNativePlayer);
			}
		});

		video.addEventListener('error', restoreNativePlayer, { once: true });
		video.controls = false;

		if (poster) {
			poster.hidden = false;
		}

		playButton.hidden = false;
		component.classList.add('is-enhanced');
	};

	const enhanceTranscript = (component) => {
		const transcript = component.querySelector('[data-inline-media-transcript]');
		const toggle = transcript?.querySelector('[data-inline-media-transcript-toggle]');
		const content = transcript?.querySelector('.inline-media__transcript-content');

		if (!transcript || !toggle || !content) {
			return;
		}

		transcript.classList.add('is-enhanced');
		toggle.hidden = false;
		content.setAttribute('aria-hidden', 'true');
		content.inert = true;

		const markReady = () => transcript.classList.add('is-ready');
		const targetWindow = component.ownerDocument.defaultView;

		if (targetWindow) {
			targetWindow.requestAnimationFrame(() => targetWindow.requestAnimationFrame(markReady));
		} else {
			markReady();
		}

		toggle.addEventListener('click', () => {
			const open = 'false' === toggle.getAttribute('aria-expanded');

			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			content.setAttribute('aria-hidden', open ? 'false' : 'true');
			content.inert = !open;
			transcript.classList.toggle('is-open', open);
		});

		transcript.dataset.inlineMediaTranscriptReady = 'true';
	};

	const enhance = (component) => {
		if (component.dataset.inlineMediaReady === 'true' || component.dataset.editorPreview === 'true') {
			return;
		}

		enhancePlayer(component);
		enhanceTranscript(component);
		component.dataset.inlineMediaReady = 'true';
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

	window.acf?.addAction('render_block_preview/type=inline-media', (block) => {
		enhanceAll(block?.[0] || document);
	});
})();
