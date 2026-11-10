<?php
/**
 * صفحهٔ ثابت.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$drh_page_id   = get_the_ID();
	$drh_cv_id     = (int) get_theme_mod( 'drh_cv_page_id', 0 );
	$drh_exec_id   = (int) get_theme_mod( 'drh_executive_cv_page_id', 0 );
	$drh_is_cv     = ( $drh_page_id === $drh_cv_id || $drh_page_id === $drh_exec_id );
	?>
	<article class="drh-page" id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="drh-page-header">
			<div class="drh-container">
				<?php drh_breadcrumb(); ?>
				<h1 class="drh-page-header__title"><?php the_title(); ?></h1>
			</div>
		</header>

		<div class="drh-container">
			<?php if ( $drh_is_cv && $drh_cv_id && $drh_exec_id && $drh_cv_id !== $drh_exec_id ) : ?>
				<nav class="drh-page-switch" aria-label="<?php esc_attr_e( 'بخش‌های رزومه', 'kadence-drhashemi' ); ?>">
					<a class="drh-page-switch__item<?php echo $drh_page_id === $drh_cv_id ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_permalink( $drh_cv_id ) ); ?>">
						<?php esc_html_e( 'شناسنامهٔ علمی و اجرایی', 'kadence-drhashemi' ); ?>
					</a>
					<a class="drh-page-switch__item<?php echo $drh_page_id === $drh_exec_id ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_permalink( $drh_exec_id ) ); ?>">
						<?php esc_html_e( 'رزومهٔ اجرایی', 'kadence-drhashemi' ); ?>
					</a>
				</nav>
			<?php endif; ?>

			<div class="drh-page__content drh-prose<?php echo $drh_is_cv ? ' drh-prose--cv' : ''; ?>">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages(
				array(
					'before' => '<nav class="drh-page-links"><span>' . esc_html__( 'صفحه‌ها:', 'kadence-drhashemi' ) . '</span>',
					'after'  => '</nav>',
				)
			);
			?>
		</div>
	</article>
	<?php
endwhile;

get_template_part( 'template-parts/contact-cta' );

get_footer();
