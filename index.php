<?php
/**
 * Main template: home (latest posts), archives and fallback.
 *
 * @package runalatviski
 */

get_header();

$is_front = is_home() && ! is_paged();
?>
<div class="layout">
	<div class="primary">

		<?php if ( is_archive() ) : ?>
			<header class="archive-header">
				<h1><?php the_archive_title(); ?></h1>
				<?php the_archive_description( '<p>', '</p>' ); ?>
			</header>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>

			<?php
			if ( $is_front ) :
				$hero_n = max( 1, min( 3, (int) runalv_opt( 'hero_count', 3 ) ) );
				$hero   = new WP_Query( array(
					'posts_per_page'      => $hero_n,
					'ignore_sticky_posts' => false,
					'no_found_rows'       => true,
				) );
				$hero_ids = array();
				if ( $hero->have_posts() ) :
					?>
					<section class="hero" aria-label="<?php esc_attr_e( 'Galvenie raksti', 'runalatviski' ); ?>">
						<?php
						$i = 0;
						while ( $hero->have_posts() ) :
							$hero->the_post();
							$hero_ids[] = get_the_ID();
							if ( 0 === $i ) :
								?>
								<article class="hero-main">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'runalv-hero', array( 'alt' => '' ) );
									}
									?>
									<div class="overlay"></div>
									<div class="hero-text">
										<?php runalv_cat_label(); ?>
										<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<?php runalv_meta(); ?>
									</div>
								</article>
								<?php if ( $hero_n > 1 ) : ?><div class="hero-side"><?php endif; ?>
							<?php else : ?>
								<article class="card">
									<?php runalv_thumb(); ?>
									<div class="card-body">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<?php runalv_meta( false ); ?>
									</div>
								</article>
							<?php endif; ?>
							<?php $i++; ?>
						<?php endwhile; ?>
						<?php if ( $hero_n > 1 ) : ?></div><?php endif; ?>
					</section>
					<?php
					wp_reset_postdata();
				endif;
				?>

				<section class="tabs" data-tabs>
					<h2 class="screen-reader-text"><?php esc_html_e( 'Jaunākās ziņas', 'runalatviski' ); ?></h2>
					<div role="tablist" aria-label="<?php esc_attr_e( 'Jaunākās ziņas', 'runalatviski' ); ?>">
						<button role="tab" id="tab-new" aria-controls="panel-new" aria-selected="true"><?php esc_html_e( 'Jaunākie', 'runalatviski' ); ?></button>
						<button role="tab" id="tab-pop" aria-controls="panel-pop" aria-selected="false" tabindex="-1"><?php esc_html_e( 'Populāri', 'runalatviski' ); ?></button>
					</div>
					<div role="tabpanel" id="panel-new" aria-labelledby="tab-new">
						<?php
						runalv_post_list( new WP_Query( array(
							'posts_per_page' => 6,
							'post__not_in'   => $hero_ids,
							'no_found_rows'  => true,
						) ) );
						?>
					</div>
					<div role="tabpanel" id="panel-pop" aria-labelledby="tab-pop" hidden>
						<?php
						runalv_post_list( new WP_Query( array(
							'posts_per_page' => 6,
							'orderby'        => 'comment_count',
							'order'          => 'DESC',
							'date_query'     => array( array( 'after' => '1 year ago' ) ),
							'no_found_rows'  => true,
						) ) );
						?>
					</div>
				</section>

				<h2 class="section-title" style="margin-top:40px"><?php esc_html_e( 'Visi raksti', 'runalatviski' ); ?></h2>
			<?php endif; ?>

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
				<h1 class="entry-title"><?php esc_html_e( 'Nekas netika atrasts', 'runalatviski' ); ?></h1>
				<p><?php esc_html_e( 'Mēģini meklēt citādi.', 'runalatviski' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>

	</div>
	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
