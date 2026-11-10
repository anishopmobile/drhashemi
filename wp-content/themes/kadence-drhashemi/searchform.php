<?php
/**
 * فرم جست‌وجو.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drh_args      = isset( $args ) && is_array( $args ) ? $args : array();
$drh_id        = ! empty( $drh_args['drh_id'] ) ? $drh_args['drh_id'] : wp_unique_id( 'drh-search-' );
$drh_label     = ! empty( $drh_args['drh_label'] ) ? $drh_args['drh_label'] : __( 'جست‌وجو در سایت', 'kadence-drhashemi' );
$drh_post_type = ! empty( $drh_args['drh_post_type'] ) ? $drh_args['drh_post_type'] : '';
$drh_placeholder = ! empty( $drh_args['drh_placeholder'] ) ? $drh_args['drh_placeholder'] : __( 'عبارت مورد نظر را بنویسید…', 'kadence-drhashemi' );
?>
<form role="search" method="get" class="drh-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $drh_id ); ?>"><?php echo esc_html( $drh_label ); ?></label>
	<span class="drh-search-form__field">
		<span class="drh-search-form__icon" aria-hidden="true"><?php drh_icon( 'search', 20 ); ?></span>
		<input
			type="search"
			id="<?php echo esc_attr( $drh_id ); ?>"
			class="drh-search-form__input"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php echo esc_attr( $drh_placeholder ); ?>"
			autocomplete="off"
		>
	</span>
	<?php if ( $drh_post_type ) : ?>
		<input type="hidden" name="post_type" value="<?php echo esc_attr( $drh_post_type ); ?>">
	<?php endif; ?>
	<button type="submit" class="drh-btn drh-btn--primary drh-btn--sm"><?php esc_html_e( 'جست‌وجو', 'kadence-drhashemi' ); ?></button>
</form>
