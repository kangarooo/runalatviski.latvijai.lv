<?php
/**
 * Static page.
 *
 * @package runalatviski
 */

get_header();
?>
<div class="layout">
	<div class="primary">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-thumb"><?php the_post_thumbnail( 'large' ); ?></figure>
				<?php endif; ?>
				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages( array( 'before' => '<p class="page-links">' . esc_html__( 'Lapas:', 'runalatviski' ), 'after' => '</p>' ) );
					?>
				</div>
			</article>
			<?php
			if ( comments_open() ) {
				comments_template();
			}
		endwhile;
		?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
