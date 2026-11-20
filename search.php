<?php
/**
 * Search results.
 *
 * @package runalatviski
 */

get_header();
?>
<div class="layout">
	<div class="primary">
		<header class="archive-header">
			<?php /* translators: %s: search query */ ?>
			<h1><?php printf( esc_html__( 'Meklēšanas rezultāti: %s', 'runalatviski' ), '<em>' . esc_html( get_search_query() ) . '</em>' ); ?></h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'card' );
				endwhile;
				?>
			</div>
			<?php runalv_pagination(); ?>
		<?php else : ?>
			<div class="entry">
				<p><?php esc_html_e( 'Diemžēl nekas netika atrasts. Pamēģini citus atslēgvārdus.', 'runalatviski' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
