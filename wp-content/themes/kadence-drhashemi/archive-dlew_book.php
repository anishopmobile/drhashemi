<?php
/**
 * آرشیو کتاب‌ها.
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
		'eyebrow'     => __( 'تألیف و ترجمه', 'kadence-drhashemi' ),
		'title'       => drh_post_type_label( 'dlew_book' ),
		'description' => __( 'کتاب‌های تألیف و ترجمه‌شده در حوزهٔ مدیریت، آموزش و علوم تربیتی.', 'kadence-drhashemi' ),
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
					'drh_id'        => 'drh-book-search',
					'drh_label'     => __( 'جست‌وجو در کتاب‌ها', 'kadence-drhashemi' ),
					'drh_post_type' => 'dlew_book',
				)
			);
			?>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="drh-book-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card-book', null, array( 'post' => get_post() ) );
			endwhile;
			?>
		</div>
		<?php drh_pagination(); ?>
	<?php else : ?>
		<div class="drh-empty">
			<span class="drh-empty__icon" aria-hidden="true"><?php drh_icon( 'book', 34 ); ?></span>
			<h2 class="drh-empty__title"><?php esc_html_e( 'کتابی یافت نشد', 'kadence-drhashemi' ); ?></h2>
			<p class="drh-empty__text"><?php esc_html_e( 'در این بخش هنوز کتابی ثبت نشده است.', 'kadence-drhashemi' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
