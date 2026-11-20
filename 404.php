<?php
/**
 * 404.
 *
 * @package runalatviski
 */

get_header();
?>
<div class="entry error-404">
	<h1>404</h1>
	<h2><?php esc_html_e( 'Lapa nav atrasta', 'runalatviski' ); ?></h2>
	<p><?php esc_html_e( 'Šāda lapa neeksistē vai ir pārvietota. Mēģini meklēt:', 'runalatviski' ); ?></p>
	<?php get_search_form(); ?>
	<p style="margin-top:24px"><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Uz sākumlapu', 'runalatviski' ); ?></a></p>
</div>
<?php
get_footer();
