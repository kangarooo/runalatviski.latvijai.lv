<?php
/**
 * Comments.
 *
 * @package runalatviski
 */

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="section-title">
			<?php
			$n = get_comments_number();
			/* translators: %s: comments count */
			printf( esc_html( _n( '%s komentārs', '%s komentāri', $n, 'runalatviski' ) ), esc_html( number_format_i18n( $n ) ) );
			?>
		</h2>
		<ol class="comment-list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 40 ) ); ?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php
	comment_form( array(
		'title_reply'         => esc_html__( 'Pievienot komentāru', 'runalatviski' ),
		'label_submit'        => esc_html__( 'Publicēt komentāru', 'runalatviski' ),
		'comment_notes_before'=> '',
	) );
	?>
</div>
