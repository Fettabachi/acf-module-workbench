( function () {
	'use strict';

	const featuredFieldSelector = '.acf-field[data-key="field_feature_cards_featured"] input[type="checkbox"]';
	const repeaterSelector = '.acf-field-repeater[data-key="field_feature_cards_cards"]';
	let scanQueued = false;

	const getRows = ( field ) => Array.from( field.querySelectorAll( ':scope > .acf-input > .acf-repeater > table > tbody > .acf-row:not(.acf-clone)' ) );

	const setCollapsedState = ( field, shouldCollapse ) => {
		getRows( field ).forEach( ( row ) => {
			const isCollapsed = row.classList.contains( '-collapsed' );
			const toggle = row.querySelector( ':scope > .acf-row-handle .acf-icon.-collapse' );

			if ( toggle && isCollapsed !== shouldCollapse ) {
				toggle.click();
			}
		} );
	};

	const createControl = ( label, shouldCollapse ) => {
		const button = document.createElement( 'button' );

		button.type = 'button';
		button.className = 'feature-cards-editor__control';
		button.textContent = label;
		button.dataset.collapseRows = shouldCollapse ? 'true' : 'false';

		return button;
	};

	const enhanceRepeater = ( field ) => {
		if ( field.dataset.featureCardsControlsReady ) {
			return;
		}

		const label = field.querySelector( ':scope > .acf-label' );

		if ( ! label ) {
			return;
		}

		const controls = document.createElement( 'div' );
		controls.className = 'feature-cards-editor__controls';
		controls.append(
			createControl( 'Expand all', false ),
			createControl( 'Collapse all', true ),
		);
		controls.addEventListener( 'click', ( event ) => {
			const button = event.target.closest( '[data-collapse-rows]' );

			if ( button ) {
				setCollapsedState( field, 'true' === button.dataset.collapseRows );
			}
		} );
		label.append( controls );
		field.dataset.featureCardsControlsReady = 'true';
	};

	document.addEventListener( 'change', ( event ) => {
		const input = event.target;

		if ( ! input.matches( featuredFieldSelector ) || ! input.checked ) {
			return;
		}

		const repeater = input.closest( repeaterSelector );

		if ( ! repeater ) {
			return;
		}

		repeater.querySelectorAll( featuredFieldSelector ).forEach( ( otherInput ) => {
			if ( otherInput === input || ! otherInput.checked ) {
				return;
			}

			otherInput.checked = false;
			otherInput.dispatchEvent( new Event( 'change', { bubbles: true } ) );
		} );
	} );

	const scan = () => {
		document.querySelectorAll( repeaterSelector ).forEach( enhanceRepeater );
		scanQueued = false;
	};

	const queueScan = () => {
		if ( ! scanQueued ) {
			scanQueued = true;
			window.requestAnimationFrame( scan );
		}
	};

	const observer = new MutationObserver( queueScan );
	observer.observe( document.documentElement, { childList: true, subtree: true } );
	queueScan();
}() );
