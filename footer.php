<?php
/**
 * Footer.
 *
 * @package runalatviski
 */
?>
	</div><!-- .wrap -->
</main>

<footer class="site-footer">
	<div class="wrap">
		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="footer-widgets">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<div><?php dynamic_sidebar( 'footer-' . $i ); ?></div>
				<?php endfor; ?>
			</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<div>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></div>
			<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Kājenes izvēlne', 'runalatviski' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
				?>
			</nav>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
