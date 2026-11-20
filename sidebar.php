<?php
/**
 * Sidebar.
 *
 * @package runalatviski
 */
?>
<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sānjosla', 'runalatviski' ); ?>">
	<?php
	$donate = runalv_opt( 'donate_url' );
	if ( $donate ) :
		?>
		<section class="widget widget-donate">
			<h3 class="widget-title"><?php esc_html_e( 'Atbalsti latviešu valodu', 'runalatviski' ); ?></h3>
			<p><?php esc_html_e( 'Tavs ziedojums palīdz turpināt darbu latviešu valodas aizsardzībā.', 'runalatviski' ); ?></p>
			<a class="btn" href="<?php echo esc_url( $donate ); ?>"><?php echo esc_html( runalv_opt( 'donate_label', 'Ziedo' ) ); ?></a>
		</section>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php else : ?>
		<section class="widget"><h3 class="widget-title"><?php esc_html_e( 'Meklēt', 'runalatviski' ); ?></h3><?php get_search_form(); ?></section>
		<section class="widget"><h3 class="widget-title"><?php esc_html_e( 'Jaunākie komentāri', 'runalatviski' ); ?></h3>
			<ul>
				<?php
				foreach ( get_comments( array( 'number' => 5, 'status' => 'approve' ) ) as $c ) {
					echo '<li>' . esc_html( $c->comment_author ) . ' — <a href="' . esc_url( get_comment_link( $c ) ) . '">' . esc_html( get_the_title( $c->comment_post_ID ) ) . '</a></li>';
				}
				?>
			</ul>
		</section>
		<section class="widget"><h3 class="widget-title"><?php esc_html_e( 'Arhīvs', 'runalatviski' ); ?></h3><ul><?php wp_get_archives( array( 'type' => 'monthly', 'limit' => 12 ) ); ?></ul></section>
		<section class="widget"><h3 class="widget-title"><?php esc_html_e( 'Kategorijas', 'runalatviski' ); ?></h3><ul><?php wp_list_categories( array( 'title_li' => '' ) ); ?></ul></section>
	<?php endif; ?>
</aside>
