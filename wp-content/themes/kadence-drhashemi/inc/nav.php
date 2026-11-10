<?php
/**
 * منوها و ناوبری.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * چاپ منو با پشتیبانی از منوی ساخته‌شده در پیشخوان و فهرست جایگزین.
 *
 * @param string $location محل منو.
 * @param string $class    کلاس فهرست.
 * @return void
 */
function drh_nav_menu( $location = 'primary', $class = 'drh-menu' ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'menu_class'     => $class,
				'depth'          => 2,
				'fallback_cb'    => 'drh_menu_fallback',
			)
		);
		return;
	}

	echo '<ul class="' . esc_attr( $class ) . '">';
	drh_menu_fallback();
	echo '</ul>';
}

/**
 * فهرست جایگزین منو بر پایهٔ محتوای واقعی سایت.
 *
 * @return void
 */
function drh_menu_fallback() {
	$items = array(
		array(
			'label' => __( 'خانه', 'kadence-drhashemi' ),
			'url'   => home_url( '/' ),
		),
	);

	$about = drh_page_link( 'drh_about_page_id', '' );
	if ( $about ) {
		$items[] = array(
			'label' => __( 'دربارهٔ دکتر', 'kadence-drhashemi' ),
			'url'   => $about,
		);
	}

	$cv = drh_page_link( 'drh_cv_page_id', '' );
	if ( $cv ) {
		$items[] = array(
			'label' => __( 'رزومه و سوابق', 'kadence-drhashemi' ),
			'url'   => $cv,
		);
	}

	foreach ( array(
		'dlew_article' => __( 'مقالات', 'kadence-drhashemi' ),
		'dlew_book'    => __( 'کتاب‌ها', 'kadence-drhashemi' ),
		'dlew_project' => __( 'طرح‌های پژوهشی', 'kadence-drhashemi' ),
	) as $type => $label ) {
		$url = get_post_type_archive_link( $type );
		if ( $url ) {
			$items[] = array(
				'label' => $label,
				'url'   => $url,
			);
		}
	}

	$items[] = array(
		'label' => __( 'تماس با من', 'kadence-drhashemi' ),
		'url'   => home_url( '/#contact' ),
	);

	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item"><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
}

/**
 * فعال کردن کلاس current-menu-item برای فهرست جایگزین در آرشیوها.
 *
 * @param array<int,string> $classes کلاس‌های آیتم منو.
 * @param WP_Post           $item    آیتم.
 * @param stdClass          $args    آرگومان‌ها.
 * @param int               $depth   عمق.
 * @return array<int,string>
 */
function drh_nav_classes( $classes, $item, $args, $depth ) {
	if ( 'primary' !== ( $args->theme_location ?? '' ) ) {
		return $classes;
	}

	if ( is_post_type_archive() && ! empty( $item->url ) ) {
		$type = get_query_var( 'post_type' );
		$type = is_array( $type ) ? reset( $type ) : $type;
		$link = get_post_type_archive_link( $type );
		if ( $type && $link && false !== strpos( $item->url, $type ) ) {
			$classes[] = 'current-menu-item';
		}
	}

	if ( is_page() && ! empty( $item->object_id ) && (int) $item->object_id === get_queried_object_id() ) {
		$classes[] = 'current-menu-item';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'drh_nav_classes', 10, 4 );
