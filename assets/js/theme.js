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

	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// Scroll reveal with a small stagger.
	var targets = document.querySelectorAll( '.card, .hero-side .card, .widget, .tabs, .archive-header, .entry, .post-nav, .comments-area, .section-title' );
	if ( ! reduce && 'IntersectionObserver' in window ) {
		var io = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( e ) {
				if ( e.isIntersecting ) {
					e.target.classList.add( 'is-in' );
					io.unobserve( e.target );
				}
			} );
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 } );

		targets.forEach( function ( el, i ) {
			el.classList.add( 'reveal' );
			el.style.setProperty( '--d', ( ( i % 4 ) * 80 ) + 'ms' );
			el.addEventListener( 'transitionend', function ( ev ) {
				if ( ev.propertyName === 'opacity' ) { el.classList.add( 'reveal-done' ); }
			} );
			io.observe( el );
		} );
	}

	// Scroll-driven bits (sticky nav shadow, reading progress, back to top).
	var navTop = nav ? nav.offsetTop : 0;
	var bar = document.querySelector( '.read-progress span' );
	var article = document.querySelector( 'article.entry' );
	var toTop = document.querySelector( '.to-top' );
	var ticking = false;

	function update() {
		ticking = false;
		var y = window.pageYOffset;
		if ( nav ) { nav.classList.toggle( 'is-stuck', y > navTop ); }
		if ( toTop ) { toTop.classList.toggle( 'is-visible', y > 700 ); }
		if ( bar && article ) {
			var rect = article.getBoundingClientRect();
			var total = rect.height - window.innerHeight * 0.6;
			var p = total > 0 ? Math.min( 1, Math.max( 0, -rect.top / total ) ) : 0;
			bar.style.transform = 'scaleX(' + p + ')';
		}
	}
	window.addEventListener( 'scroll', function () {
		if ( ! ticking ) { ticking = true; window.requestAnimationFrame( update ); }
	}, { passive: true } );
	window.addEventListener( 'resize', update );
	update();

	if ( toTop ) {
		toTop.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: reduce ? 'auto' : 'smooth' } );
		} );
	}
}() );
