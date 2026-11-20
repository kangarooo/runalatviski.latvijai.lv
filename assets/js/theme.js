( function () {
	'use strict';

	// Mobile menu.
	var nav = document.getElementById( 'main-nav' );
	if ( nav ) {
		var btn = nav.querySelector( '.menu-toggle' );
		if ( btn ) {
			btn.addEventListener( 'click', function () {
				var open = nav.classList.toggle( 'is-open' );
				btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			} );
		}
	}

	// Accessible tabs (Jaunākie / Populāri).
	document.querySelectorAll( '[data-tabs]' ).forEach( function ( root ) {
		var tabs = Array.prototype.slice.call( root.querySelectorAll( '[role="tab"]' ) );

		function select( tab ) {
			tabs.forEach( function ( t ) {
				var on = t === tab;
				t.setAttribute( 'aria-selected', on ? 'true' : 'false' );
				t.tabIndex = on ? 0 : -1;
				var panel = document.getElementById( t.getAttribute( 'aria-controls' ) );
				if ( panel ) { panel.hidden = ! on; }
			} );
			tab.focus();
		}

		tabs.forEach( function ( tab, i ) {
			tab.addEventListener( 'click', function () { select( tab ); } );
			tab.addEventListener( 'keydown', function ( e ) {
				var next = null;
				if ( e.key === 'ArrowRight' ) { next = tabs[ ( i + 1 ) % tabs.length ]; }
				if ( e.key === 'ArrowLeft' ) { next = tabs[ ( i - 1 + tabs.length ) % tabs.length ]; }
				if ( next ) { e.preventDefault(); select( next ); }
			} );
		} );
	} );
}() );
