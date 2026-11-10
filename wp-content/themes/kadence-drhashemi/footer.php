<?php
/**
 * پابرگ سایت.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main><!-- #main -->

<footer class="drh-footer" id="footer">
	<div class="drh-container drh-footer__grid">
		<div class="drh-footer__brand">
			<a class="drh-brand drh-brand--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<span class="drh-brand__mark" aria-hidden="true"><?php drh_icon( 'cap', 26 ); ?></span>
				<span class="drh-brand__text">
					<span class="drh-brand__name"><?php echo esc_html( drh_mod( 'drh_hero_title' ) ); ?></span>
					<span class="drh-brand__tag" dir="ltr">Dr. Seyed Ahmad Hashemi</span>
				</span>
			</a>
			<p class="drh-footer__about">
				<?php esc_html_e( 'استاد دانشگاه، پژوهشگر و مشاور توسعهٔ سازمانی؛ این سایت مرجع معرفی سوابق علمی و اجرایی، مقالات، کتاب‌ها و طرح‌های پژوهشی است.', 'kadence-drhashemi' ); ?>
			</p>
		</div>

		<nav class="drh-footer__nav" aria-label="<?php esc_attr_e( 'پیوندهای پابرگ', 'kadence-drhashemi' ); ?>">
			<h2 class="drh-footer__title"><?php esc_html_e( 'دسترسی سریع', 'kadence-drhashemi' ); ?></h2>
			<?php drh_nav_menu( 'footer', 'drh-footer__list' ); ?>
		</nav>

		<?php $drh_footer_contacts = drh_contact_items(); ?>
		<?php if ( $drh_footer_contacts ) : ?>
			<div class="drh-footer__contact">
				<h2 class="drh-footer__title"><?php esc_html_e( 'راه‌های ارتباطی', 'kadence-drhashemi' ); ?></h2>
				<ul>
					<?php foreach ( $drh_footer_contacts as $drh_item ) : ?>
						<li>
							<?php drh_icon( $drh_item['icon'], 18 ); ?>
							<span class="drh-footer__contact-body">
								<span class="drh-footer__contact-label"><?php echo esc_html( $drh_item['label'] ); ?></span>
								<?php if ( $drh_item['url'] ) : ?>
									<a href="<?php echo esc_url( $drh_item['url'] ); ?>"<?php echo $drh_item['rtl'] ? ' dir="ltr"' : ''; ?>><?php echo esc_html( $drh_item['value'] ); ?></a>
								<?php else : ?>
									<span><?php echo esc_html( $drh_item['value'] ); ?></span>
								<?php endif; ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>

	<div class="drh-container drh-footer__bottom">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( drh_mod( 'drh_hero_title' ) ); ?> — <?php esc_html_e( 'تمامی حقوق محفوظ است.', 'kadence-drhashemi' ); ?></p>
		<a class="drh-footer__top" href="#masthead">
			<?php esc_html_e( 'بازگشت به بالا', 'kadence-drhashemi' ); ?>
			<?php drh_icon( 'arrow-up', 16 ); ?>
		</a>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
