<?php
/**
 * ردیف طرح پژوهشی.
 *
 * @param array $args آرگومان‌ها: post، index.
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drh_post = isset( $args['post'] ) ? $args['post'] : get_post();
if ( ! $drh_post ) {
	return;
}

$drh_index   = isset( $args['index'] ) ? (int) $args['index'] : 0;
$drh_link    = get_permalink( $drh_post );
$drh_excerpt = drh_card_excerpt( $drh_post, 26 );
$drh_term    = drh_primary_term( $drh_post );
?>
<article class="drh-project">
	<span class="drh-project__index" aria-hidden="true"><?php echo esc_html( drh_number( $drh_index + 1 ) ); ?></span>
	<div class="drh-project__body">
		<h3 class="drh-project__title">
			<a href="<?php echo esc_url( $drh_link ); ?>"><?php echo esc_html( get_the_title( $drh_post ) ); ?></a>
		</h3>
		<?php if ( $drh_excerpt ) : ?>
			<p class="drh-project__excerpt"><?php echo esc_html( $drh_excerpt ); ?></p>
		<?php endif; ?>
	</div>
	<?php if ( $drh_term ) : ?>
		<span class="drh-project__tag"><?php echo esc_html( $drh_term->name ); ?></span>
	<?php endif; ?>
	<a class="drh-project__link" href="<?php echo esc_url( $drh_link ); ?>">
		<span class="screen-reader-text"><?php echo esc_html( get_the_title( $drh_post ) ); ?></span>
		<?php drh_icon( 'arrow', 20 ); ?>
	</a>
</article>
