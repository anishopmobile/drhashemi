<?php
/**
 * بخش ارتباط و دریافت رزومه.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$drh_contacts = drh_contact_items();
$drh_cv_url   = drh_page_link( 'drh_cv_page_id', '' );
$drh_exec_url = drh_page_link( 'drh_executive_cv_page_id', '' );
?>
<section class="drh-contact" id="contact">
	<div class="drh-container drh-contact__grid">
		<div class="drh-contact__intro">
			<p class="drh-eyebrow"><?php esc_html_e( 'ارتباط', 'kadence-drhashemi' ); ?></p>
			<h2 class="drh-section__title"><?php esc_html_e( 'راه‌های ارتباطی', 'kadence-drhashemi' ); ?></h2>
			<p class="drh-contact__text">
				<?php esc_html_e( 'برای هماهنگی همکاری پژوهشی، مشاورهٔ سازمانی یا پرسش‌های دانشگاهی می‌توانید از راه‌های زیر در تماس باشید.', 'kadence-drhashemi' ); ?>
			</p>

			<?php if ( $drh_contacts ) : ?>
				<ul class="drh-contact__list">
					<?php foreach ( $drh_contacts as $drh_item ) : ?>
						<li class="drh-contact__item">
							<span class="drh-contact__icon" aria-hidden="true"><?php drh_icon( $drh_item['icon'], 20 ); ?></span>
							<span class="drh-contact__body">
								<span class="drh-contact__label"><?php echo esc_html( $drh_item['label'] ); ?></span>
								<?php if ( $drh_item['url'] ) : ?>
									<a href="<?php echo esc_url( $drh_item['url'] ); ?>"<?php echo $drh_item['rtl'] ? ' dir="ltr"' : ''; ?>><?php echo esc_html( $drh_item['value'] ); ?></a>
								<?php else : ?>
									<span><?php echo esc_html( $drh_item['value'] ); ?></span>
								<?php endif; ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php if ( $drh_cv_url ) : ?>
			<aside class="drh-cv-card">
				<span class="drh-cv-card__icon" aria-hidden="true"><?php drh_icon( 'article', 30 ); ?></span>
				<h3 class="drh-cv-card__title"><?php esc_html_e( 'رزومهٔ کامل علمی و اجرایی', 'kadence-drhashemi' ); ?></h3>
				<p class="drh-cv-card__text">
					<?php esc_html_e( 'سوابق تحصیلی، رتبهٔ علمی، فعالیت‌های پژوهشی و مسئولیت‌های اجرایی در یک صفحه.', 'kadence-drhashemi' ); ?>
				</p>
				<a class="drh-btn drh-btn--primary" href="<?php echo esc_url( $drh_cv_url ); ?>">
					<?php drh_icon( 'download', 18 ); ?>
					<?php esc_html_e( 'مشاهدهٔ رزومه', 'kadence-drhashemi' ); ?>
				</a>
				<?php if ( $drh_exec_url && $drh_exec_url !== $drh_cv_url ) : ?>
					<a class="drh-cv-card__link" href="<?php echo esc_url( $drh_exec_url ); ?>">
						<?php esc_html_e( 'رزومهٔ اجرایی', 'kadence-drhashemi' ); ?>
						<?php drh_icon( 'chevron', 14 ); ?>
					</a>
				<?php endif; ?>
			</aside>
		<?php endif; ?>
	</div>
</section>
