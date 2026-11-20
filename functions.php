<?php
/**
 * Runā latviski — theme functions.
 *
 * @package runalatviski
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RUNALV_VERSION', '1.0.0' );

/* ---------------------------------------------------------------
 * Setup
 * ------------------------------------------------------------- */
function runalv_setup() {
	load_theme_textdomain( 'runalatviski', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 320,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	set_post_thumbnail_size( 800, 450, true );
	add_image_size( 'runalv-hero', 1200, 700, true );
	add_image_size( 'runalv-card', 640, 360, true );
	add_image_size( 'runalv-thumb', 192, 136, true );

	register_nav_menus( array(
		'primary' => __( 'Galvenā izvēlne', 'runalatviski' ),
		'footer'  => __( 'Kājenes izvēlne', 'runalatviski' ),
	) );
}
add_action( 'after_setup_theme', 'runalv_setup' );

function runalv_content_width() {
	$GLOBALS['content_width'] = 760;
}
add_action( 'after_setup_theme', 'runalv_content_width', 0 );

/* ---------------------------------------------------------------
 * Assets
 * ------------------------------------------------------------- */
function runalv_assets() {
	wp_enqueue_style( 'runalatviski', get_stylesheet_uri(), array(), RUNALV_VERSION );
	wp_enqueue_script( 'runalatviski', get_template_directory_uri() . '/assets/js/theme.js', array(), RUNALV_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'runalv_assets' );

/** Flag JS early so reveal animations never hide content without JS. */
function runalv_js_class() {
	echo "<script>document.documentElement.classList.add('js');</script>\n";
}
add_action( 'wp_head', 'runalv_js_class', 1 );

/* ---------------------------------------------------------------
 * Widgets
 * ------------------------------------------------------------- */
function runalv_widgets() {
	$args = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);
	register_sidebar( array_merge( $args, array(
		'name' => __( 'Sānjosla', 'runalatviski' ),
		'id'   => 'sidebar-1',
	) ) );
	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar( array_merge( $args, array(
			/* translators: %d: column number */
			'name' => sprintf( __( 'Kājene %d', 'runalatviski' ), $i ),
			'id'   => 'footer-' . $i,
		) ) );
	}
}
add_action( 'widgets_init', 'runalv_widgets' );

/* ---------------------------------------------------------------
 * Customizer
 * ------------------------------------------------------------- */
function runalv_customize( $wp_customize ) {
	$wp_customize->add_section( 'runalv_campaign', array(
		'title'    => __( 'Kampaņa un ziedošana', 'runalatviski' ),
		'priority' => 30,
	) );

	$fields = array(
		'campaign_text'  => array( __( 'Kampaņas joslas teksts (tukšs = paslēpt)', 'runalatviski' ), 'text', 'sanitize_text_field', '' ),
		'campaign_label' => array( __( 'Kampaņas saites teksts', 'runalatviski' ), 'text', 'sanitize_text_field', 'Parakstīties' ),
		'campaign_url'   => array( __( 'Kampaņas saite (piem., manabalss.lv)', 'runalatviski' ), 'url', 'esc_url_raw', '' ),
		'donate_label'   => array( __( 'Ziedošanas pogas teksts', 'runalatviski' ), 'text', 'sanitize_text_field', 'Ziedo' ),
		'donate_url'     => array( __( 'Ziedošanas lapas saite (tukšs = paslēpt)', 'runalatviski' ), 'url', 'esc_url_raw', '' ),
		'social_facebook'=> array( __( 'Facebook saite', 'runalatviski' ), 'url', 'esc_url_raw', '' ),
		'social_x'       => array( __( 'X (Twitter) saite', 'runalatviski' ), 'url', 'esc_url_raw', '' ),
		'social_telegram'=> array( __( 'Telegram saite', 'runalatviski' ), 'url', 'esc_url_raw', '' ),
		'social_youtube' => array( __( 'YouTube saite', 'runalatviski' ), 'url', 'esc_url_raw', '' ),
	);

	foreach ( $fields as $id => $f ) {
		$wp_customize->add_setting( 'runalv_' . $id, array(
			'default'           => $f[3],
			'sanitize_callback' => $f[2],
		) );
		$wp_customize->add_control( 'runalv_' . $id, array(
			'label'   => $f[0],
			'section' => 'runalv_campaign',
			'type'    => $f[1],
		) );
	}

	$wp_customize->add_setting( 'runalv_hero_count', array( 'default' => 3, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'runalv_hero_count', array(
		'label'   => __( 'Sākumlapas galvenie raksti (1–3)', 'runalatviski' ),
		'section' => 'runalv_campaign',
		'type'    => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 3 ),
	) );
}
add_action( 'customize_register', 'runalv_customize' );

function runalv_opt( $key, $default = '' ) {
	return get_theme_mod( 'runalv_' . $key, $default );
}

/* ---------------------------------------------------------------
 * Helpers
 * ------------------------------------------------------------- */
function runalv_excerpt_length() {
	return 28;
}
add_filter( 'excerpt_length', 'runalv_excerpt_length' );
add_filter( 'excerpt_more', function () { return '…'; } );

/** Date, author, comments line. */
function runalv_meta( $with_author = true ) {
	$parts   = array();
	$parts[] = '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
	if ( $with_author ) {
		$parts[] = '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';
	}
	$n = get_comments_number();
	if ( $n > 0 ) {
		/* translators: %s: comments count */
		$parts[] = '<a href="' . esc_url( get_comments_link() ) . '">' . esc_html( sprintf( _n( '%s komentārs', '%s komentāri', $n, 'runalatviski' ), number_format_i18n( $n ) ) ) . '</a>';
	}
	echo '<div class="meta">' . implode( '<span class="sep">·</span>', $parts ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/** First category label (skips "Nekategorizēts" / uncategorized). */
function runalv_cat_label() {
	$cats = get_the_category();
	foreach ( $cats as $c ) {
		if ( (int) $c->term_id === (int) get_option( 'default_category' ) ) {
			continue;
		}
		echo '<a class="cat-label" href="' . esc_url( get_category_link( $c->term_id ) ) . '">' . esc_html( $c->name ) . '</a>';
		return;
	}
}

/** Thumbnail or flag-striped placeholder. */
function runalv_thumb( $size = 'runalv-card' ) {
	if ( has_post_thumbnail() ) {
		echo '<a class="thumb" href="' . esc_url( get_permalink() ) . '" tabindex="-1" aria-hidden="true">';
		the_post_thumbnail( $size, array( 'loading' => 'lazy', 'alt' => '' ) );
		echo '</a>';
	} else {
		echo '<a class="thumb placeholder" href="' . esc_url( get_permalink() ) . '" tabindex="-1" aria-hidden="true"></a>';
	}
}

/** Compact list of posts for tabs/widgets. */
function runalv_post_list( $query ) {
	echo '<ul class="list-posts">';
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<li>';
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'runalv-thumb', array( 'class' => 'lp-thumb', 'loading' => 'lazy', 'alt' => '' ) );
		} else {
			echo '<span class="lp-thumb" aria-hidden="true"></span>';
		}
		echo '<div><a class="lp-title" href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
		runalv_meta( false );
		echo '</div></li>';
	}
	echo '</ul>';
	wp_reset_postdata();
}

/** Safe fallback for the primary menu. */
function runalv_menu_fallback() {
	echo '<ul class="menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Sākums', 'runalatviski' ) . '</a></li>';
	wp_list_pages( array( 'title_li' => '', 'depth' => 1, 'number' => 8 ) );
	echo '</ul>';
}

/** Numbered pagination. */
function runalv_pagination() {
	the_posts_pagination( array(
		'mid_size'  => 2,
		'prev_text' => '‹ ' . __( 'Jaunāki', 'runalatviski' ),
		'next_text' => __( 'Vecāki', 'runalatviski' ) . ' ›',
		'screen_reader_text' => __( 'Rakstu navigācija', 'runalatviski' ),
	) );
}

/** Add lazy "decoding" to avatars and keep things light. */
add_filter( 'get_avatar_data', function ( $args ) {
	$args['extra_attr'] = 'loading="lazy" decoding="async"';
	return $args;
} );

/** Clean head. */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
