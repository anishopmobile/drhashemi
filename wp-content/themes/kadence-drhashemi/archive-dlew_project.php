<?php
/**
 * آرشیو طرح‌های پژوهشی.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part(
	'template-parts/page-header',
	null,
	array(
		'eyebrow'     => __( 'پژوهش کاربردی', 'kadence-drhashemi' ),
		'title'       => drh_post_type_label( 'dlew_project' ),
		'description' => __( 'طرح‌های پژوهشی اجراشده در حوزهٔ مدیریت، آموزش و توسعهٔ سازمانی.', 'kadence-drhashemi' ),
		'count'       => (int) $GLOBALS['wp_query']->found_posts,
	)
);
?>

<div class="drh-container">
	<div class="drh-toolbar">
		<div class="drh-toolbar__search">
			<?php
			get_search_form(
				array(
					'drh_id'        => 'drh-project-search',
					'drh_label'     => __( 'جست‌وجو در طرح‌های پژوهشی', 'kadence-drhashemi' ),
					'drh_post_type' => 'dlew_project',
				)
			);
			?>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="drh-project-list">
			<?php
			$drh_index = ( max( 1, (int) get_query_var( 'paged' ) ) - 1 ) * (int) get_query_var( 'posts_per_page' );
			while ( have_posts() ) :
				the_post();
				get_template_part(
					'template-parts/card-project',
					null,
					array(
						'post'  => get_post(),
						'index' => $drh_index,
					)
				);
				$drh_index++;
			endwhile;
			?>
		</div>
		<?php drh_pagination(); ?>
	<?php else : ?>
		<div class="drh-empty">
			<span class="drh-empty__icon" aria-hidden="true"><?php drh_icon( 'layers', 34 ); ?></span>
			<h2 class="drh-empty__title"><?php esc_html_e( 'طرحی یافت نشد', 'kadence-drhashemi' ); ?></h2>
			<p class="drh-empty__text"><?php esc_html_e( 'در این بخش هنوز طرح پژوهشی ثبت نشده است.', 'kadence-drhashemi' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
