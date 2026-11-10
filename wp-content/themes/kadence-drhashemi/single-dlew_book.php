<?php
/**
 * صفحهٔ جزئیات کتاب.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$drh_image = drh_card_image();
	$drh_term  = drh_primary_term();
	$drh_style = $drh_image['url'] ? ' style="background-image:url(' . esc_url( $drh_image['url'] ) . ')"' : '';
	?>
	<article class="drh-single drh-single--book" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="drh-single__header">
			<div class="drh-container">
				<?php drh_breadcrumb(); ?>
				<?php if ( $drh_term ) : ?>
					<a class="drh-single__cat" href="<?php echo esc_url( get_term_link( $drh_term ) ); ?>"><?php echo esc_html( $drh_term->name ); ?></a>
				<?php endif; ?>
				<h1 class="drh-single__title"><?php the_title(); ?></h1>
			</div>
		</header>

		<div class="drh-container drh-single__layout drh-single__layout--book">
			<div class="drh-book-detail">
				<div class="drh-book-detail__cover<?php echo $drh_image['url'] ? ' has-image' : ''; ?>"<?php echo $drh_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<span class="drh-book-detail__badge"><?php esc_html_e( 'کتاب', 'kadence-drhashemi' ); ?></span>
					<span class="drh-book-detail__cover-title"><?php the_title(); ?></span>
				</div>
				<?php if ( $drh_term ) : ?>
					<a class="drh-book-detail__back" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_book' ) ); ?>">
						<?php drh_icon( 'arrow', 16 ); ?>
						<?php esc_html_e( 'بازگشت به فهرست کتاب‌ها', 'kadence-drhashemi' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<div class="drh-single__content drh-prose">
				<?php the_content(); ?>
			</div>
		</div>

		<div class="drh-container">
			<nav class="drh-post-nav" aria-label="<?php esc_attr_e( 'پیمایش کتاب‌ها', 'kadence-drhashemi' ); ?>">
				<?php
				$drh_prev = get_previous_post();
				$drh_next = get_next_post();
				?>
				<div class="drh-post-nav__item drh-post-nav__item--prev">
					<?php if ( $drh_next ) : ?>
						<span class="drh-post-nav__label"><?php esc_html_e( 'کتاب بعدی', 'kadence-drhashemi' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $drh_next ) ); ?>"><?php echo esc_html( get_the_title( $drh_next ) ); ?></a>
					<?php endif; ?>
				</div>
				<div class="drh-post-nav__item drh-post-nav__item--next">
					<?php if ( $drh_prev ) : ?>
						<span class="drh-post-nav__label"><?php esc_html_e( 'کتاب قبلی', 'kadence-drhashemi' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $drh_prev ) ); ?>"><?php echo esc_html( get_the_title( $drh_prev ) ); ?></a>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</article>
	<?php
endwhile;

get_footer();
