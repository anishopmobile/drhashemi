<?php
/**
 * سربرگ داخلی صفحه‌ها و آرشیوها.
 *
 * @param array $args آرگومان‌ها: eyebrow، title، description، count.
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drh_title       = isset( $args['title'] ) ? $args['title'] : '';
$drh_eyebrow     = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$drh_description = isset( $args['description'] ) ? $args['description'] : '';
$drh_count       = isset( $args['count'] ) ? (int) $args['count'] : 0;
?>
<header class="drh-page-header">
	<div class="drh-container">
		<?php drh_breadcrumb(); ?>
		<?php if ( $drh_eyebrow ) : ?>
			<p class="drh-eyebrow"><?php echo esc_html( $drh_eyebrow ); ?></p>
		<?php endif; ?>
		<h1 class="drh-page-header__title"><?php echo esc_html( $drh_title ); ?></h1>
		<?php if ( $drh_description ) : ?>
			<p class="drh-page-header__desc"><?php echo esc_html( $drh_description ); ?></p>
		<?php endif; ?>
		<?php if ( $drh_count ) : ?>
			<p class="drh-page-header__count">
				<?php
				printf(
					/* translators: %s: number of items. */
					esc_html__( '%s مورد ثبت شده است.', 'kadence-drhashemi' ),
					esc_html( drh_number( $drh_count ) )
				);
				?>
			</p>
		<?php endif; ?>
	</div>
</header>
