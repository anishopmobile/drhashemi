<?php
/**
 * صفحهٔ ۴۰۴.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="drh-404">
	<div class="drh-container">
		<p class="drh-404__code" aria-hidden="true">۴۰۴</p>
		<h1 class="drh-404__title"><?php esc_html_e( 'این صفحه پیدا نشد', 'kadence-drhashemi' ); ?></h1>
		<p class="drh-404__text">
			<?php esc_html_e( 'نشانی واردشده وجود ندارد یا جابه‌جا شده است. می‌توانید صفحه را جست‌وجو کنید یا از فهرست‌های علمی زیر شروع کنید.', 'kadence-drhashemi' ); ?>
		</p>

		<div class="drh-404__search">
			<?php
			get_search_form(
				array(
					'drh_id'    => 'drh-404-search',
					'drh_label' => __( 'جست‌وجو در سایت', 'kadence-drhashemi' ),
				)
			);
			?>
		</div>

		<ul class="drh-404__links">
			<li><a class="drh-btn drh-btn--ghost drh-btn--sm" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'صفحهٔ اصلی', 'kadence-drhashemi' ); ?></a></li>
			<?php
			foreach ( array( 'dlew_article', 'dlew_book', 'dlew_project' ) as $drh_type ) :
				$drh_url = get_post_type_archive_link( $drh_type );
				if ( ! $drh_url ) {
					continue;
				}
				?>
				<li><a class="drh-btn drh-btn--ghost drh-btn--sm" href="<?php echo esc_url( $drh_url ); ?>"><?php echo esc_html( drh_post_type_label( $drh_type ) ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php get_footer(); ?>
