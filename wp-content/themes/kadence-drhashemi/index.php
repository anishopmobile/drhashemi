<?php
/**
 * قالب پشتیبان.
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
		'eyebrow' => __( 'آرشیو', 'kadence-drhashemi' ),
		'title'   => is_home() ? __( 'نوشته‌ها', 'kadence-drhashemi' ) : wp_strip_all_tags( get_the_archive_title() ),
		'count'   => (int) $GLOBALS['wp_query']->found_posts,
	)
);
?>

<div class="drh-container">
	<?php if ( have_posts() ) : ?>
		<div class="drh-cards">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card-article', null, array( 'post' => get_post() ) );
			endwhile;
			?>
		</div>
		<?php drh_pagination(); ?>
	<?php else : ?>
		<div class="drh-empty">
			<span class="drh-empty__icon" aria-hidden="true"><?php drh_icon( 'article', 34 ); ?></span>
			<h2 class="drh-empty__title"><?php esc_html_e( 'محتوایی برای نمایش نیست', 'kadence-drhashemi' ); ?></h2>
			<p class="drh-empty__text"><?php esc_html_e( 'هنوز مطلبی در این بخش منتشر نشده است.', 'kadence-drhashemi' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
