<?php
/**
 * آرشیوهای عمومی: دسته، برچسب و تاریخ.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$drh_is_category = is_category();
$drh_current     = $drh_is_category ? (int) get_queried_object_id() : 0;
$drh_show_chips  = $drh_is_category && drh_category_has_articles( $drh_current );

get_template_part(
	'template-parts/page-header',
	null,
	array(
		'eyebrow'     => $drh_is_category ? __( 'دسته‌بندی', 'kadence-drhashemi' ) : __( 'آرشیو', 'kadence-drhashemi' ),
		'title'       => wp_strip_all_tags( get_the_archive_title() ),
		'description' => wp_strip_all_tags( get_the_archive_description() ),
		'count'       => (int) $GLOBALS['wp_query']->found_posts,
	)
);
?>

<div class="drh-container">
	<?php if ( $drh_show_chips ) : ?>
		<?php $drh_categories = drh_article_categories(); ?>
		<?php if ( $drh_categories ) : ?>
			<nav class="drh-chips" aria-label="<?php esc_attr_e( 'دسته‌های مقالات', 'kadence-drhashemi' ); ?>">
				<a class="drh-chip" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_article' ) ); ?>"><?php esc_html_e( 'همهٔ مقالات', 'kadence-drhashemi' ); ?></a>
				<?php foreach ( $drh_categories as $drh_category ) : ?>
					<a class="drh-chip<?php echo $drh_current === (int) $drh_category['term']->term_id ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $drh_category['term'] ) ); ?>">
						<?php echo esc_html( $drh_category['term']->name ); ?>
						<span class="drh-chip__count"><?php echo esc_html( drh_number( $drh_category['count'] ) ); ?></span>
					</a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<div class="drh-cards">
			<?php
			while ( have_posts() ) :
				the_post();
				switch ( get_post_type() ) {
					case 'dlew_book':
						get_template_part( 'template-parts/card-book', null, array( 'post' => get_post() ) );
						break;
					case 'dlew_project':
						get_template_part( 'template-parts/card-project', null, array( 'post' => get_post() ) );
						break;
					case 'post':
						get_template_part( 'template-parts/card-article', null, array( 'post' => get_post() ) );
						break;
					default:
						get_template_part( 'template-parts/card-article', null, array( 'post' => get_post() ) );
				}
			endwhile;
			?>
		</div>
		<?php drh_pagination(); ?>
	<?php else : ?>
		<div class="drh-empty">
			<span class="drh-empty__icon" aria-hidden="true"><?php drh_icon( 'search', 34 ); ?></span>
			<h2 class="drh-empty__title"><?php esc_html_e( 'موردی در این بخش نیست', 'kadence-drhashemi' ); ?></h2>
			<p class="drh-empty__text"><?php esc_html_e( 'هنوز مطلبی در این دسته منتشر نشده است.', 'kadence-drhashemi' ); ?></p>
			<a class="drh-btn drh-btn--ghost drh-btn--sm" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'بازگشت به صفحهٔ اصلی', 'kadence-drhashemi' ); ?></a>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
