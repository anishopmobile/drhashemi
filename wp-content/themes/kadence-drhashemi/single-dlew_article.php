<?php
/**
 * صفحهٔ جزئیات مقاله.
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
	<article class="drh-single" id="post-<?php the_ID(); ?>" <?php post_class( 'drh-single--article' ); ?>>
		<header class="drh-single__header">
			<div class="drh-container">
				<?php drh_breadcrumb(); ?>
				<?php if ( $drh_term ) : ?>
					<a class="drh-single__cat" href="<?php echo esc_url( get_term_link( $drh_term ) ); ?>"><?php echo esc_html( $drh_term->name ); ?></a>
				<?php endif; ?>
				<h1 class="drh-single__title"><?php the_title(); ?></h1>
				<div class="drh-single__meta">
					<span class="drh-meta-item">
						<?php drh_icon( 'calendar', 16 ); ?>
						<span><?php echo esc_html( drh_fa_date() ); ?></span>
					</span>
					<?php if ( $drh_term ) : ?>
						<span class="drh-meta-item">
							<?php drh_icon( 'article', 16 ); ?>
							<a href="<?php echo esc_url( get_term_link( $drh_term ) ); ?>"><?php echo esc_html( $drh_term->name ); ?></a>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</header>

		<div class="drh-container drh-single__layout">
			<div class="drh-single__content drh-prose">
				<?php the_content(); ?>
			</div>

			<aside class="drh-single__aside" aria-label="<?php esc_attr_e( 'مطالب مرتبط', 'kadence-drhashemi' ); ?>">
				<?php
				$drh_related = new WP_Query(
					array(
						'post_type'              => 'dlew_article',
						'posts_per_page'         => 4,
						'post__not_in'           => array( get_the_ID() ),
						'ignore_sticky_posts'    => true,
						'no_found_rows'          => true,
						'update_post_term_cache' => false,
						'category__in'           => $drh_term ? array( $drh_term->term_id ) : array(),
					)
				);
				if ( $drh_related->have_posts() ) :
					?>
					<div class="drh-aside-card">
						<h2 class="drh-aside-card__title"><?php esc_html_e( 'مقالات مرتبط', 'kadence-drhashemi' ); ?></h2>
						<ul class="drh-aside-list">
							<?php
							while ( $drh_related->have_posts() ) :
								$drh_related->the_post();
								?>
								<li>
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</li>
							<?php endwhile; ?>
						</ul>
						<?php wp_reset_postdata(); ?>
						<a class="drh-aside-card__more" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_article' ) ); ?>">
							<?php esc_html_e( 'آرشیو مقالات', 'kadence-drhashemi' ); ?>
							<?php drh_icon( 'arrow', 15 ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if ( $drh_term ) : ?>
					<div class="drh-aside-card drh-aside-card--soft">
						<h2 class="drh-aside-card__title"><?php esc_html_e( 'همین دسته', 'kadence-drhashemi' ); ?></h2>
						<p class="drh-aside-card__text"><?php echo esc_html( $drh_term->name ); ?></p>
						<a class="drh-aside-card__more" href="<?php echo esc_url( get_term_link( $drh_term ) ); ?>">
							<?php esc_html_e( 'مشاهدهٔ همهٔ مقالات این دسته', 'kadence-drhashemi' ); ?>
							<?php drh_icon( 'arrow', 15 ); ?>
						</a>
					</div>
				<?php endif; ?>
			</aside>
		</div>

		<div class="drh-container">
			<nav class="drh-post-nav" aria-label="<?php esc_attr_e( 'پیمایش مقاله‌ها', 'kadence-drhashemi' ); ?>">
				<?php
				$drh_prev = get_previous_post();
				$drh_next = get_next_post();
				?>
				<div class="drh-post-nav__item drh-post-nav__item--prev">
					<?php if ( $drh_next ) : ?>
						<span class="drh-post-nav__label"><?php esc_html_e( 'مقالهٔ بعدی', 'kadence-drhashemi' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $drh_next ) ); ?>"><?php echo esc_html( get_the_title( $drh_next ) ); ?></a>
					<?php endif; ?>
				</div>
				<div class="drh-post-nav__item drh-post-nav__item--next">
					<?php if ( $drh_prev ) : ?>
						<span class="drh-post-nav__label"><?php esc_html_e( 'مقالهٔ قبلی', 'kadence-drhashemi' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $drh_prev ) ); ?>"><?php echo esc_html( get_the_title( $drh_prev ) ); ?></a>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</article>
	<?php
endwhile;

get_footer();
