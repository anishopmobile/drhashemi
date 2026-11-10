<?php
/**
 * کارت کتاب با جلد جایگزین.
 *
 * @param array $args آرگومان‌ها: post.
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drh_post = isset( $args['post'] ) ? $args['post'] : get_post();
if ( ! $drh_post ) {
	return;
}

$drh_image = drh_card_image( $drh_post );
$drh_link  = get_permalink( $drh_post );
$drh_term  = drh_primary_term( $drh_post );
$drh_style = $drh_image['url'] ? ' style="background-image:url(' . esc_url( $drh_image['url'] ) . ')"' : '';
?>
<article class="drh-book">
	<a class="drh-book__cover<?php echo $drh_image['url'] ? ' has-image' : ''; ?>" href="<?php echo esc_url( $drh_link ); ?>" tabindex="-1" aria-hidden="true"<?php echo $drh_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<span class="drh-book__badge"><?php esc_html_e( 'کتاب', 'kadence-drhashemi' ); ?></span>
		<span class="drh-book__cover-mark" aria-hidden="true"><?php drh_icon( 'book', 34 ); ?></span>
		<span class="drh-book__cover-title"><?php echo esc_html( get_the_title( $drh_post ) ); ?></span>
	</a>
	<div class="drh-book__body">
		<h3 class="drh-book__title">
			<a href="<?php echo esc_url( $drh_link ); ?>"><?php echo esc_html( get_the_title( $drh_post ) ); ?></a>
		</h3>
		<?php if ( $drh_term ) : ?>
			<p class="drh-book__meta"><?php echo esc_html( $drh_term->name ); ?></p>
		<?php endif; ?>
	</div>
</article>
