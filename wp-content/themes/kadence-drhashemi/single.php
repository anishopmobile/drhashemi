<?php
/**
 * نوشتهٔ معمولی.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="drh-single" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="drh-single__header">
			<div class="drh-container">
				<?php drh_breadcrumb(); ?>
				<h1 class="drh-single__title"><?php the_title(); ?></h1>
				<div class="drh-single__meta">
					<span class="drh-meta-item">
						<?php drh_icon( 'calendar', 16 ); ?>
						<span><?php echo esc_html( drh_fa_date() ); ?></span>
					</span>
				</div>
			</div>
		</header>

		<div class="drh-container drh-single__layout">
			<div class="drh-single__content drh-prose">
				<?php the_content(); ?>
			</div>
			<aside class="drh-single__aside">
				<div class="drh-aside-card drh-aside-card--soft">
					<h2 class="drh-aside-card__title"><?php esc_html_e( 'پژوهش و انتشارات', 'kadence-drhashemi' ); ?></h2>
					<ul class="drh-aside-list">
						<?php
						$drh_links = array(
							'dlew_article' => drh_post_type_label( 'dlew_article' ),
							'dlew_book'    => drh_post_type_label( 'dlew_book' ),
							'dlew_project' => drh_post_type_label( 'dlew_project' ),
						);
						foreach ( $drh_links as $drh_type => $drh_label ) :
							$drh_url = get_post_type_archive_link( $drh_type );
							if ( ! $drh_url ) {
								continue;
							}
							?>
							<li><a href="<?php echo esc_url( $drh_url ); ?>"><?php echo esc_html( $drh_label ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</aside>
		</div>
	</article>
	<?php
endwhile;

get_footer();
