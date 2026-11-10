<?php
/**
 * صفحهٔ جزئیات طرح پژوهشی.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$drh_term = drh_primary_term();
	?>
	<article class="drh-single drh-single--project" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="drh-single__header">
			<div class="drh-container">
				<?php drh_breadcrumb(); ?>
				<a class="drh-single__cat" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_project' ) ); ?>">
					<?php esc_html_e( 'طرح پژوهشی', 'kadence-drhashemi' ); ?>
				</a>
				<h1 class="drh-single__title"><?php the_title(); ?></h1>
			</div>
		</header>

		<div class="drh-container drh-single__layout">
			<div class="drh-single__content drh-prose">
				<?php the_content(); ?>
			</div>

			<aside class="drh-single__aside">
				<div class="drh-aside-card drh-aside-card--soft">
					<h2 class="drh-aside-card__title"><?php esc_html_e( 'طرح‌های پژوهشی', 'kadence-drhashemi' ); ?></h2>
					<p class="drh-aside-card__text"><?php esc_html_e( 'فهرست کامل طرح‌های اجراشده در حوزهٔ مدیریت و آموزش.', 'kadence-drhashemi' ); ?></p>
					<a class="drh-aside-card__more" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_project' ) ); ?>">
						<?php esc_html_e( 'مشاهدهٔ همهٔ طرح‌ها', 'kadence-drhashemi' ); ?>
						<?php drh_icon( 'arrow', 15 ); ?>
					</a>
				</div>
				<?php if ( $drh_term ) : ?>
					<div class="drh-aside-card">
						<h2 class="drh-aside-card__title"><?php esc_html_e( 'دسته‌بندی', 'kadence-drhashemi' ); ?></h2>
						<p class="drh-aside-card__text"><?php echo esc_html( $drh_term->name ); ?></p>
					</div>
				<?php endif; ?>
			</aside>
		</div>
	</article>
	<?php
endwhile;

get_footer();
