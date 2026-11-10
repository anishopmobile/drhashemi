<?php
/**
 * صفحهٔ اصلی: معرفی، حوزه‌ها، سوابق و آخرین آثار.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$drh_cv_url    = drh_page_link( 'drh_cv_page_id', get_post_type_archive_link( 'dlew_article' ) );
$drh_about_url = drh_page_link( 'drh_about_page_id', '' );
$drh_exec_url  = drh_page_link( 'drh_executive_cv_page_id', $drh_cv_url );
$drh_portrait  = drh_portrait_url();
$drh_portrait_size = $drh_portrait ? drh_image_dimensions( $drh_portrait ) : array( 'width' => 0, 'height' => 0 );

$drh_articles  = drh_count_published( 'dlew_article' );
$drh_books     = drh_count_published( 'dlew_book' );
$drh_projects  = drh_count_published( 'dlew_project' );
$drh_expertise = drh_expertise_items();
$drh_credentials = drh_credential_items();

$drh_hero_facts = array(
	array(
		'icon'  => 'cap',
		'title' => __( 'استاد دانشگاه', 'kadence-drhashemi' ),
		'text'  => __( 'رتبهٔ علمی استاد', 'kadence-drhashemi' ),
	),
	array(
		'icon'  => 'users',
		'title' => __( 'هیئت علمی', 'kadence-drhashemi' ),
		'text'  => __( 'دانشگاه آزاد اسلامی لامرد', 'kadence-drhashemi' ),
	),
	array(
		'icon'  => 'target',
		'title' => __( 'مشاور و مجری', 'kadence-drhashemi' ),
		'text'  => __( 'طرح‌های توسعهٔ سازمانی', 'kadence-drhashemi' ),
	),
	array(
		'icon'  => 'book',
		'title' => __( 'پژوهشگر و مؤلف', 'kadence-drhashemi' ),
		'text'  => __( 'مقاله و کتاب تخصصی', 'kadence-drhashemi' ),
	),
);

$drh_stats = array(
	array(
		'value' => $drh_articles,
		'label' => __( 'مقالهٔ علمی و پژوهشی', 'kadence-drhashemi' ),
	),
	array(
		'value' => $drh_books,
		'label' => __( 'کتاب تألیف و ترجمه', 'kadence-drhashemi' ),
	),
	array(
		'value' => $drh_projects,
		'label' => __( 'طرح پژوهشی', 'kadence-drhashemi' ),
	),
	array(
		'value' => count( $drh_expertise ),
		'label' => __( 'حوزهٔ تخصصی', 'kadence-drhashemi' ),
	),
);
?>

<section class="drh-hero">
	<div class="drh-hero__pattern" aria-hidden="true"></div>
	<div class="drh-container drh-hero__inner">
		<div class="drh-hero__content">
			<p class="drh-eyebrow"><?php echo esc_html( drh_mod( 'drh_hero_eyebrow' ) ); ?></p>
			<h1 class="drh-hero__title"><?php echo esc_html( drh_mod( 'drh_hero_title' ) ); ?></h1>
			<p class="drh-hero__latin" dir="ltr">Dr. Seyed Ahmad Hashemi</p>
			<span class="drh-hero__rule" aria-hidden="true"></span>
			<p class="drh-hero__subtitle"><?php echo esc_html( drh_mod( 'drh_hero_subtitle' ) ); ?></p>
			<p class="drh-hero__text"><?php echo esc_html( drh_mod( 'drh_hero_text' ) ); ?></p>

			<ul class="drh-hero__facts">
				<?php foreach ( $drh_hero_facts as $drh_fact ) : ?>
					<li class="drh-hero__fact">
						<span class="drh-hero__fact-icon" aria-hidden="true"><?php drh_icon( $drh_fact['icon'], 24 ); ?></span>
						<span class="drh-hero__fact-body">
							<span class="drh-hero__fact-title"><?php echo esc_html( $drh_fact['title'] ); ?></span>
							<span class="drh-hero__fact-text"><?php echo esc_html( $drh_fact['text'] ); ?></span>
						</span>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="drh-hero__actions">
				<a class="drh-btn drh-btn--gold" href="<?php echo esc_url( $drh_cv_url ); ?>">
					<?php drh_icon( 'download', 18 ); ?>
					<?php echo esc_html( drh_mod( 'drh_hero_primary_label' ) ); ?>
				</a>
				<?php if ( $drh_about_url ) : ?>
					<a class="drh-btn drh-btn--outline-light" href="<?php echo esc_url( $drh_about_url ); ?>">
						<?php echo esc_html( drh_mod( 'drh_hero_secondary_label' ) ); ?>
						<?php drh_icon( 'chevron', 16 ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="drh-hero__media">
			<figure class="drh-portrait<?php echo $drh_portrait ? ' has-photo' : ''; ?>">
				<span class="drh-portrait__arc" aria-hidden="true"></span>
				<?php if ( $drh_portrait ) : ?>
					<span class="drh-portrait__frame">
						<img
							class="drh-portrait__img"
							src="<?php echo esc_url( $drh_portrait ); ?>"
							alt="<?php echo esc_attr( drh_mod( 'drh_hero_title' ) ); ?>"
							<?php if ( $drh_portrait_size['width'] && $drh_portrait_size['height'] ) : ?>
								width="<?php echo esc_attr( (string) $drh_portrait_size['width'] ); ?>"
								height="<?php echo esc_attr( (string) $drh_portrait_size['height'] ); ?>"
							<?php endif; ?>
							loading="eager"
							fetchpriority="high"
							decoding="async"
						>
					</span>
				<?php else : ?>
					<div class="drh-portrait__placeholder">
						<span class="drh-portrait__monogram" aria-hidden="true">س.ا.ه</span>
						<span class="drh-portrait__rule" aria-hidden="true"></span>
						<span class="drh-portrait__caption"><?php echo esc_html( drh_mod( 'drh_hero_subtitle' ) ); ?></span>
					</div>
				<?php endif; ?>
				<figcaption class="drh-portrait__badge">
					<span class="drh-portrait__badge-icon" aria-hidden="true"><?php drh_icon( 'cap', 20 ); ?></span>
					<span>
						<span class="drh-portrait__badge-name"><?php echo esc_html( drh_mod( 'drh_hero_title' ) ); ?></span>
						<span class="drh-portrait__badge-role"><?php esc_html_e( 'استاد مدیریت آموزشی', 'kadence-drhashemi' ); ?></span>
					</span>
				</figcaption>
			</figure>
		</div>
	</div>
</section>

<?php if ( $drh_expertise ) : ?>
	<section class="drh-section drh-expertise" id="expertise">
		<div class="drh-container">
			<?php drh_section_title( __( 'زمینه‌های کاری', 'kadence-drhashemi' ), __( 'حوزه‌های تخصصی', 'kadence-drhashemi' ) ); ?>
			<ul class="drh-expertise__grid">
				<?php foreach ( $drh_expertise as $drh_item ) : ?>
					<li class="drh-expertise__item">
						<span class="drh-expertise__icon" aria-hidden="true"><?php drh_icon( $drh_item['icon'], 26 ); ?></span>
						<h3 class="drh-expertise__title"><?php echo esc_html( $drh_item['title'] ); ?></h3>
						<?php if ( $drh_item['text'] ) : ?>
							<p class="drh-expertise__text"><?php echo esc_html( $drh_item['text'] ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<section class="drh-section drh-about" id="about">
	<div class="drh-container drh-about__grid">
		<div class="drh-about__content">
			<?php drh_section_title( __( 'دربارهٔ دکتر', 'kadence-drhashemi' ), drh_mod( 'drh_about_title' ) ); ?>
			<div class="drh-prose drh-prose--lead">
				<?php echo wp_kses_post( wpautop( esc_html( drh_mod( 'drh_about_text' ) ) ) ); ?>
			</div>
			<?php if ( $drh_about_url ) : ?>
				<a class="drh-btn drh-btn--ghost" href="<?php echo esc_url( $drh_about_url ); ?>">
					<?php esc_html_e( 'بیشتر بدانید', 'kadence-drhashemi' ); ?>
					<?php drh_icon( 'arrow', 16 ); ?>
				</a>
			<?php endif; ?>
		</div>

		<aside class="drh-facts" aria-label="<?php esc_attr_e( 'اطلاعات کلی', 'kadence-drhashemi' ); ?>">
			<h2 class="drh-facts__title"><?php esc_html_e( 'در یک نگاه', 'kadence-drhashemi' ); ?></h2>
			<dl class="drh-facts__list">
				<div class="drh-facts__row">
					<dt><?php esc_html_e( 'رتبهٔ علمی', 'kadence-drhashemi' ); ?></dt>
					<dd><?php esc_html_e( 'استاد', 'kadence-drhashemi' ); ?></dd>
				</div>
				<div class="drh-facts__row">
					<dt><?php esc_html_e( 'رشتهٔ علمی', 'kadence-drhashemi' ); ?></dt>
					<dd><?php esc_html_e( 'مدیریت آموزشی', 'kadence-drhashemi' ); ?></dd>
				</div>
				<div class="drh-facts__row">
					<dt><?php esc_html_e( 'دانشگاه', 'kadence-drhashemi' ); ?></dt>
					<dd><?php esc_html_e( 'آزاد اسلامی واحد لامرد', 'kadence-drhashemi' ); ?></dd>
				</div>
				<div class="drh-facts__row">
					<dt><?php esc_html_e( 'تحصیلات', 'kadence-drhashemi' ); ?></dt>
					<dd><?php esc_html_e( 'دکترای مدیریت آموزشی، ۱۳۸۸', 'kadence-drhashemi' ); ?></dd>
				</div>
			</dl>
			<a class="drh-facts__link" href="<?php echo esc_url( $drh_cv_url ); ?>">
				<?php esc_html_e( 'مشاهدهٔ شناسنامهٔ علمی', 'kadence-drhashemi' ); ?>
				<?php drh_icon( 'arrow', 16 ); ?>
			</a>
		</aside>
	</div>
</section>

<section class="drh-stats" aria-label="<?php esc_attr_e( 'آمار علمی', 'kadence-drhashemi' ); ?>">
	<div class="drh-container">
		<ul class="drh-stats__grid">
			<?php foreach ( $drh_stats as $drh_stat ) : ?>
				<li>
					<span class="drh-stats__value"><?php echo esc_html( drh_number( $drh_stat['value'] ) ); ?></span>
					<span class="drh-stats__label"><?php echo esc_html( $drh_stat['label'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
$drh_latest = new WP_Query(
	array(
		'post_type'              => 'dlew_article',
		'posts_per_page'         => 3,
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_term_cache' => true,
		'post_status'            => 'publish',
	)
);
if ( $drh_latest->have_posts() ) :
	?>
	<section class="drh-section drh-latest" id="latest-articles">
		<div class="drh-container">
			<div class="drh-section__bar">
				<?php drh_section_title( __( 'پژوهش', 'kadence-drhashemi' ), __( 'تازه‌ترین مقالات', 'kadence-drhashemi' ) ); ?>
				<?php drh_archive_link( 'dlew_article', __( 'آرشیو مقالات', 'kadence-drhashemi' ) ); ?>
			</div>
			<div class="drh-cards">
				<?php
				while ( $drh_latest->have_posts() ) :
					$drh_latest->the_post();
					get_template_part( 'template-parts/card-article', null, array( 'post' => get_post() ) );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
$drh_book_query = new WP_Query(
	array(
		'post_type'              => 'dlew_book',
		'posts_per_page'         => 4,
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'post_status'            => 'publish',
	)
);
if ( $drh_book_query->have_posts() ) :
	?>
	<section class="drh-section drh-books" id="books">
		<div class="drh-container">
			<div class="drh-section__bar">
				<?php drh_section_title( __( 'تألیف و ترجمه', 'kadence-drhashemi' ), __( 'کتاب‌های منتشرشده', 'kadence-drhashemi' ) ); ?>
				<?php drh_archive_link( 'dlew_book', __( 'آرشیو کتاب‌ها', 'kadence-drhashemi' ) ); ?>
			</div>
			<div class="drh-book-grid">
				<?php
				while ( $drh_book_query->have_posts() ) :
					$drh_book_query->the_post();
					get_template_part( 'template-parts/card-book', null, array( 'post' => get_post() ) );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
$drh_project_query = new WP_Query(
	array(
		'post_type'              => 'dlew_project',
		'posts_per_page'         => 3,
		'no_found_rows'          => true,
		'update_post_term_cache' => true,
		'post_status'            => 'publish',
	)
);
if ( $drh_project_query->have_posts() ) :
	?>
	<section class="drh-section drh-projects" id="projects">
		<div class="drh-container">
			<div class="drh-section__bar">
				<?php drh_section_title( __( 'طرح‌های پژوهشی', 'kadence-drhashemi' ), __( 'پژوهش‌های انجام‌شده', 'kadence-drhashemi' ) ); ?>
				<?php drh_archive_link( 'dlew_project', __( 'همهٔ طرح‌ها', 'kadence-drhashemi' ) ); ?>
			</div>
			<div class="drh-project-list">
				<?php
				$drh_index = 0;
				while ( $drh_project_query->have_posts() ) :
					$drh_project_query->the_post();
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
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<section class="drh-section drh-highlights">
	<div class="drh-container drh-highlights__grid">
		<div class="drh-highlights__col">
			<?php drh_section_title( __( 'کارنامهٔ اجرایی', 'kadence-drhashemi' ), __( 'برخی از سوابق و مسئولیت‌های کلیدی', 'kadence-drhashemi' ) ); ?>
			<?php if ( $drh_credentials ) : ?>
				<ul class="drh-checklist">
					<?php foreach ( $drh_credentials as $drh_credential ) : ?>
						<li>
							<span class="drh-checklist__icon" aria-hidden="true"><?php drh_icon( 'check', 14 ); ?></span>
							<?php echo esc_html( $drh_credential ); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<a class="drh-btn drh-btn--ghost drh-btn--sm" href="<?php echo esc_url( $drh_exec_url ); ?>">
				<?php esc_html_e( 'مشاهدهٔ همهٔ سوابق', 'kadence-drhashemi' ); ?>
				<?php drh_icon( 'arrow', 16 ); ?>
			</a>
		</div>

		<div class="drh-highlights__col">
			<?php drh_section_title( __( 'دستاوردها', 'kadence-drhashemi' ), __( 'مروری بر آثار و فعالیت‌ها', 'kadence-drhashemi' ) ); ?>
			<ul class="drh-achievements">
				<li>
					<a class="drh-achievement" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_book' ) ); ?>">
						<span class="drh-achievement__icon" aria-hidden="true"><?php drh_icon( 'book', 24 ); ?></span>
						<span class="drh-achievement__label"><?php esc_html_e( 'کتاب‌ها و تألیفات', 'kadence-drhashemi' ); ?></span>
						<span class="drh-achievement__count"><?php echo esc_html( drh_number( $drh_books ) ); ?></span>
						<span class="drh-achievement__arrow" aria-hidden="true"><?php drh_icon( 'chevron', 18 ); ?></span>
					</a>
				</li>
				<li>
					<a class="drh-achievement" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_article' ) ); ?>">
						<span class="drh-achievement__icon" aria-hidden="true"><?php drh_icon( 'article', 24 ); ?></span>
						<span class="drh-achievement__label"><?php esc_html_e( 'مقالات علمی و پژوهشی', 'kadence-drhashemi' ); ?></span>
						<span class="drh-achievement__count"><?php echo esc_html( drh_number( $drh_articles ) ); ?></span>
						<span class="drh-achievement__arrow" aria-hidden="true"><?php drh_icon( 'chevron', 18 ); ?></span>
					</a>
				</li>
				<li>
					<a class="drh-achievement" href="<?php echo esc_url( get_post_type_archive_link( 'dlew_project' ) ); ?>">
						<span class="drh-achievement__icon" aria-hidden="true"><?php drh_icon( 'layers', 24 ); ?></span>
						<span class="drh-achievement__label"><?php esc_html_e( 'طرح‌های پژوهشی', 'kadence-drhashemi' ); ?></span>
						<span class="drh-achievement__count"><?php echo esc_html( drh_number( $drh_projects ) ); ?></span>
						<span class="drh-achievement__arrow" aria-hidden="true"><?php drh_icon( 'chevron', 18 ); ?></span>
					</a>
				</li>
				<li>
					<a class="drh-achievement" href="<?php echo esc_url( $drh_cv_url ); ?>">
						<span class="drh-achievement__icon" aria-hidden="true"><?php drh_icon( 'article', 24 ); ?></span>
						<span class="drh-achievement__label"><?php esc_html_e( 'شناسنامهٔ علمی و اجرایی', 'kadence-drhashemi' ); ?></span>
						<span class="drh-achievement__arrow" aria-hidden="true"><?php drh_icon( 'chevron', 18 ); ?></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/contact-cta' ); ?>

<?php get_footer(); ?>
