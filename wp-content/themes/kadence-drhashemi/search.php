<?php
/**
 * نتایج جست‌وجو.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$drh_query = get_search_query();
$drh_total = (int) $GLOBALS['wp_query']->found_posts;
?>

<header class="drh-page-header">
	<div class="drh-container">
		<?php drh_breadcrumb(); ?>
		<p class="drh-eyebrow"><?php esc_html_e( 'جست‌وجو', 'kadence-drhashemi' ); ?></p>
		<h1 class="drh-page-header__title">
			<?php
			printf(
				/* translators: %s: search query. */
				esc_html__( 'نتایج جست‌وجو برای «%s»', 'kadence-drhashemi' ),
				esc_html( $drh_query )
			);
			?>
		</h1>
		<?php if ( $drh_total ) : ?>
			<p class="drh-page-header__count">
				<?php
				printf(
					/* translators: %s: number of results. */
					esc_html__( '%s مورد پیدا شد.', 'kadence-drhashemi' ),
					esc_html( drh_number( $drh_total ) )
				);
				?>
			</p>
		<?php endif; ?>
	</div>
</header>

<div class="drh-container">
	<div class="drh-toolbar">
		<div class="drh-toolbar__search">
			<?php
			get_search_form(
				array(
					'drh_id'    => 'drh-search-page',
					'drh_label' => __( 'جست‌وجوی دوباره', 'kadence-drhashemi' ),
				)
			);
			?>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<ul class="drh-results">
			<?php
			while ( have_posts() ) :
				the_post();
				$drh_type  = get_post_type();
				$drh_label = drh_post_type_label( $drh_type );
				$drh_term  = drh_primary_term();
				?>
				<li class="drh-result">
					<a class="drh-result__link" href="<?php the_permalink(); ?>">
						<span class="drh-result__type"><?php echo esc_html( $drh_label ); ?></span>
						<span class="drh-result__title"><?php the_title(); ?></span>
						<?php $drh_excerpt = drh_card_excerpt( get_post(), 30 ); ?>
						<?php if ( $drh_excerpt ) : ?>
							<span class="drh-result__excerpt"><?php echo esc_html( $drh_excerpt ); ?></span>
						<?php endif; ?>
						<?php if ( $drh_term ) : ?>
							<span class="drh-result__term"><?php echo esc_html( $drh_term->name ); ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
		<?php drh_pagination(); ?>
	<?php else : ?>
		<div class="drh-empty">
			<span class="drh-empty__icon" aria-hidden="true"><?php drh_icon( 'search', 34 ); ?></span>
			<h2 class="drh-empty__title"><?php esc_html_e( 'نتیجه‌ای پیدا نشد', 'kadence-drhashemi' ); ?></h2>
			<p class="drh-empty__text">
				<?php esc_html_e( 'برای عبارت جست‌وجوشده مطلبی پیدا نشد. می‌توانید عبارت کوتاه‌تری بنویسید یا از فهرست‌های زیر استفاده کنید.', 'kadence-drhashemi' ); ?>
			</p>
			<ul class="drh-empty__links">
				<?php
				foreach ( array( 'dlew_article', 'dlew_book', 'dlew_project' ) as $drh_type_key ) :
					$drh_archive = get_post_type_archive_link( $drh_type_key );
					if ( ! $drh_archive ) {
						continue;
					}
					?>
					<li>
						<a class="drh-btn drh-btn--ghost drh-btn--sm" href="<?php echo esc_url( $drh_archive ); ?>">
							<?php echo esc_html( drh_post_type_label( $drh_type_key ) ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
