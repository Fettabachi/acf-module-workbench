( function () {
	'use strict';

	const featuredFieldSelector = '.acf-field[data-key="field_feature_cards_featured"] input[type="checkbox"]';
	const repeaterSelector = '.acf-field-repeater[data-key="field_feature_cards_cards"]';

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
}() );
