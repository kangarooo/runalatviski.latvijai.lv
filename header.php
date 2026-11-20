<?php
/**
 * Header.
 *
 * @package runalatviski
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#content"><?php esc_html_e( 'Pāriet uz saturu', 'runalatviski' ); ?></a>

<?php
$camp_text = runalv_opt( 'campaign_text' );
if ( $camp_text ) :
	$camp_url = runalv_opt( 'campaign_url' );
	?>
	<div class="campaign-bar">
		<div class="wrap">
			<span><?php echo esc_html( $camp_text ); ?></span>
			<?php if ( $camp_url ) : ?>
				<a href="<?php echo esc_url( $camp_url ); ?>" rel="noopener"><?php echo esc_html( runalv_opt( 'campaign_label', 'Parakstīties' ) ); ?> →</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<header class="site-header">
	<div class="wrap header-main">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) { the_custom_logo(); } ?>
			<div>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php $desc = get_bloginfo( 'description', 'display' ); if ( $desc ) : ?>
					<p class="site-description"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<div class="header-actions">
			<?php
			$socials = array(
				'facebook' => 'Facebook',
				'x'        => 'X',
				'telegram' => 'Telegram',
				'youtube'  => 'YouTube',
			);
			$items = '';
			foreach ( $socials as $k => $label ) {
				$u = runalv_opt( 'social_' . $k );
				if ( $u ) {
					$items .= '<li><a href="' . esc_url( $u ) . '" rel="noopener me" target="_blank">' . esc_html( $label ) . '</a></li>';
				}
			}
			if ( $items ) {
				echo '<ul class="social-links">' . $items . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}
			$donate = runalv_opt( 'donate_url' );
			if ( $donate ) :
				?>
				<a class="btn" href="<?php echo esc_url( $donate ); ?>"><?php echo esc_html( runalv_opt( 'donate_label', 'Ziedo' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>

	<nav class="main-nav" id="main-nav" aria-label="<?php esc_attr_e( 'Galvenā izvēlne', 'runalatviski' ); ?>">
		<div class="wrap">
			<button class="menu-toggle" aria-expanded="false" aria-controls="primary-menu">☰ <?php esc_html_e( 'Izvēlne', 'runalatviski' ); ?></button>
			<div class="menu-wrap">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => 'runalv_menu_fallback',
				) );
				?>
			</div>
		</div>
	</nav>
</header>

<main id="content" class="site-content">
	<div class="wrap">
