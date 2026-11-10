<?php
/**
 * آرشیو مقالات علمی.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$drh_total   = (int) $GLOBALS['wp_query']->found_posts;
$drh_current = is_category() ? (int) get_queried_object_id() : 0;

get_template_part(
	'template-parts/page-header',
	null,
	array(
		'eyebrow'     => __( 'پژوهش', 'kadence-drhashemi' ),
		'title'       => is_category() ? single_term_title( '', false ) : drh_post_type_label( 'dlew_article' ),
		'description' => is_category()
			? term_description()
			: __( 'فهرست مقاله‌های علمی منتشرشده در مجلات و همایش‌های داخلی و بین‌المللی.', 'kadence-drhashemi' ),
		'count'       => $drh_total,
	)
);
?>

<div class="drh-container">
	<div class="drh-toolbar">
		<div class="drh-toolbar__search">
			<?php
			get_search_form(
				array(
					'drh_id'        => 'drh-article-search',
					'drh_label'     => __( 'جست‌وجو در مقالات', 'kadence-drhashemi' ),
					'drh_post_type' => 'dlew_article',
				)
			);
			?>
		</div>
	</div>

	<?php $drh_categories = drh_article_categories(); ?>
	<?php if ( $drh_categories ) : ?>
		<nav class="drh-chips" aria-label="<?php esc_attr_e( 'فیلتر بر اساس دستهٔ مقاله', 'kadence-drhashemi' ); ?>">
			<a class="drh-chip<?php echo $drh_current ? '' : ' is-active'; ?>" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_article' ) ); ?>">
				<?php esc_html_e( 'همهٔ مقالات', 'kadence-drhashemi' ); ?>
				<span class="drh-chip__count"><?php echo esc_html( drh_number( drh_count_published( 'dlew_article' ) ) ); ?></span>
			</a>
			<?php foreach ( $drh_categories as $drh_category ) : ?>
				<a class="drh-chip<?php echo $drh_current === (int) $drh_category['term']->term_id ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $drh_category['term'] ) ); ?>">
					<?php echo esc_html( $drh_category['term']->name ); ?>
					<span class="drh-chip__count"><?php echo esc_html( drh_number( $drh_category['count'] ) ); ?></span>
				</a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>

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
			<h2 class="drh-empty__title"><?php esc_html_e( 'مقاله‌ای یافت نشد', 'kadence-drhashemi' ); ?></h2>
			<p class="drh-empty__text"><?php esc_html_e( 'در این بخش هنوز مقاله‌ای منتشر نشده است. می‌توانید همهٔ مقالات را ببینید یا عبارت دیگری را جست‌وجو کنید.', 'kadence-drhashemi' ); ?></p>
			<a class="drh-btn drh-btn--ghost drh-btn--sm" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_article' ) ); ?>">
				<?php esc_html_e( 'مشاهدهٔ همهٔ مقالات', 'kadence-drhashemi' ); ?>
			</a>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
