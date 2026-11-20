<?php
/**
 * Single post.
 *
 * @package runalatviski
 */

get_header();
?>
<div class="layout">
	<div class="primary">
		<?php
		while ( have_posts() ) :
			the_post();
			$url   = rawurlencode( get_permalink() );
			$title = rawurlencode( get_the_title() );
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
				<header>
					<?php runalv_cat_label(); ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php runalv_meta(); ?>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="entry-thumb">
						<?php the_post_thumbnail( 'large' ); ?>
						<?php $cap = get_the_post_thumbnail_caption(); if ( $cap ) : ?><figcaption><?php echo esc_html( $cap ); ?></figcaption><?php endif; ?>
					</figure>
				<?php endif; ?>

				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages( array( 'before' => '<p class="page-links">' . esc_html__( 'Lapas:', 'runalatviski' ), 'after' => '</p>' ) );
					?>
				</div>

				<footer class="entry-footer">
					<?php the_tags( '<div class="tag-list">', '', '</div>' ); ?>
					<div class="share">
						<span><?php esc_html_e( 'Dalīties:', 'runalatviski' ); ?></span>
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; // phpcs:ignore ?>" target="_blank" rel="noopener">Facebook</a>
						<a href="https://twitter.com/intent/tweet?url=<?php echo $url; // phpcs:ignore ?>&text=<?php echo $title; // phpcs:ignore ?>" target="_blank" rel="noopener">X</a>
						<a href="https://t.me/share/url?url=<?php echo $url; // phpcs:ignore ?>&text=<?php echo $title; // phpcs:ignore ?>" target="_blank" rel="noopener">Telegram</a>
					</div>
				</footer>
			</article>

			<nav class="post-nav" aria-label="<?php esc_attr_e( 'Raksta navigācija', 'runalatviski' ); ?>">
				<?php
				$prev = get_previous_post();
				$next = get_next_post();
				if ( $prev ) {
					echo '<a class="prev" href="' . esc_url( get_permalink( $prev ) ) . '"><small>← ' . esc_html__( 'Iepriekšējais', 'runalatviski' ) . '</small>' . esc_html( get_the_title( $prev ) ) . '</a>';
				} else {
					echo '<span></span>';
				}
				if ( $next ) {
					echo '<a class="next" href="' . esc_url( get_permalink( $next ) ) . '"><small>' . esc_html__( 'Nākamais', 'runalatviski' ) . ' →</small>' . esc_html( get_the_title( $next ) ) . '</a>';
				}
				?>
			</nav>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
