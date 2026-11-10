<?php
/**
 * سربرگ سایت: هد، منوی اصلی، جست‌وجو و منوی موبایل.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="drh-skip-link" href="#main"><?php esc_html_e( 'رفتن به محتوای اصلی', 'kadence-drhashemi' ); ?></a>

<header class="drh-header" id="masthead">
	<div class="drh-container drh-header__inner">
		<a class="drh-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<span class="drh-brand__mark" aria-hidden="true"><?php drh_icon( 'cap', 26 ); ?></span>
			<span class="drh-brand__text">
				<span class="drh-brand__name"><?php echo esc_html( drh_mod( 'drh_hero_title' ) ); ?></span>
				<span class="drh-brand__tag" dir="ltr">Dr. Seyed Ahmad Hashemi</span>
			</span>
		</a>

		<nav class="drh-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'kadence-drhashemi' ); ?>">
			<?php drh_nav_menu( 'primary', 'drh-menu' ); ?>
		</nav>

		<div class="drh-header__actions">
			<button type="button" class="drh-icon-btn" id="drh-search-toggle" aria-expanded="false" aria-controls="drh-search-panel">
				<?php drh_icon( 'search', 20 ); ?>
				<span class="screen-reader-text"><?php esc_html_e( 'جست‌وجو در سایت', 'kadence-drhashemi' ); ?></span>
			</button>
			<button type="button" class="drh-burger" id="drh-menu-toggle" aria-expanded="false" aria-controls="drh-drawer">
				<span class="drh-burger__bars" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'منو', 'kadence-drhashemi' ); ?></span>
			</button>
		</div>
	</div>

	<div class="drh-search-panel" id="drh-search-panel" hidden>
		<div class="drh-container">
			<?php
			get_search_form(
				array(
					'drh_id'        => 'drh-header-search',
					'drh_label'     => __( 'جست‌وجو در مقالات، کتاب‌ها و طرح‌ها', 'kadence-drhashemi' ),
					'drh_post_type' => '',
				)
			);
			?>
		</div>
	</div>
</header>

<div class="drh-drawer" id="drh-drawer" data-state="closed" aria-hidden="true" inert>
	<div class="drh-drawer__backdrop" data-drh-close></div>
	<div class="drh-drawer__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'منوی موبایل', 'kadence-drhashemi' ); ?>">
		<div class="drh-drawer__head">
			<span class="drh-brand__name"><?php echo esc_html( drh_mod( 'drh_hero_title' ) ); ?></span>
			<button type="button" class="drh-icon-btn" data-drh-close>
				<?php drh_icon( 'close', 20 ); ?>
				<span class="screen-reader-text"><?php esc_html_e( 'بستن منو', 'kadence-drhashemi' ); ?></span>
			</button>
		</div>

		<nav class="drh-drawer__nav" aria-label="<?php esc_attr_e( 'منوی موبایل', 'kadence-drhashemi' ); ?>">
			<?php drh_nav_menu( 'primary', 'drh-drawer__list' ); ?>
		</nav>

		<?php $drh_contacts = drh_contact_items(); ?>
		<?php if ( $drh_contacts ) : ?>
			<div class="drh-drawer__contact">
				<p class="drh-drawer__contact-title"><?php esc_html_e( 'راه‌های ارتباطی', 'kadence-drhashemi' ); ?></p>
				<ul>
					<?php foreach ( $drh_contacts as $drh_item ) : ?>
						<li>
							<?php drh_icon( $drh_item['icon'], 18 ); ?>
							<?php if ( $drh_item['url'] ) : ?>
								<a href="<?php echo esc_url( $drh_item['url'] ); ?>"<?php echo $drh_item['rtl'] ? ' dir="ltr"' : ''; ?>><?php echo esc_html( $drh_item['value'] ); ?></a>
							<?php else : ?>
								<span><?php echo esc_html( $drh_item['value'] ); ?></span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>

<main id="main" class="drh-main">
