<?php
/**
 * Post card.
 *
 * @package runalatviski
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
	<?php runalv_thumb(); ?>
	<div class="card-body">
		<?php runalv_cat_label(); ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php runalv_meta(); ?>
		<p class="excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28, '…' ) ); ?></p>
	</div>
</article>
