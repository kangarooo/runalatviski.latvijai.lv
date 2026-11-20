<?php
/**
 * Search form.
 *
 * @package runalatviski
 */
$uid = wp_unique_id( 'search-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Meklēt:', 'runalatviski' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $uid ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Meklēt…', 'runalatviski' ); ?>">
	<button type="submit" class="btn"><?php esc_html_e( 'Meklēt', 'runalatviski' ); ?></button>
</form>
