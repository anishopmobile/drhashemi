<?php
/**
 * کارت مقاله.
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
$drh_term  = drh_primary_term( $drh_post );
$drh_link  = get_permalink( $drh_post );
$drh_style = $drh_image['url'] ? ' style="background-image:url(' . esc_url( $drh_image['url'] ) . ')"' : '';
?>
<article class="drh-card drh-card--article">
	<a class="drh-card__media<?php echo $drh_image['url'] ? ' has-image' : ''; ?>" href="<?php echo esc_url( $drh_link ); ?>" tabindex="-1" aria-hidden="true"<?php echo $drh_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<span class="drh-card__fallback" aria-hidden="true"><?php drh_icon( 'article', 30 ); ?></span>
	</a>
	<div class="drh-card__body">
		<?php if ( $drh_term ) : ?>
			<a class="drh-card__cat" href="<?php echo esc_url( get_term_link( $drh_term ) ); ?>"><?php echo esc_html( $drh_term->name ); ?></a>
		<?php endif; ?>
		<h3 class="drh-card__title">
			<a href="<?php echo esc_url( $drh_link ); ?>"><?php echo esc_html( get_the_title( $drh_post ) ); ?></a>
		</h3>
		<?php $drh_excerpt = drh_card_excerpt( $drh_post, 24 ); ?>
		<?php if ( $drh_excerpt ) : ?>
			<p class="drh-card__excerpt"><?php echo esc_html( $drh_excerpt ); ?></p>
		<?php endif; ?>
		<div class="drh-card__foot">
			<span class="drh-card__date"><?php echo esc_html( drh_fa_date( $drh_post ) ); ?></span>
			<a class="drh-card__more" href="<?php echo esc_url( $drh_link ); ?>">
				<?php echo esc_html( drh_more_link_text() ); ?>
				<?php drh_icon( 'arrow', 16 ); ?>
			</a>
		</div>
	</div>
</article>
