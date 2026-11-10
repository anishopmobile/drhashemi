<?php
/**
 * بارگذاری استاندارد استایل‌ها، فونت‌ها و اسکریپت‌ها.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * چاپ منابع ظاهری سایت.
 *
 * Kadence به‌عنوان قالب والد فعال می‌ماند و استایل پایهٔ آن (`kadence-global`)
 * پیش از استایل این قالب فرزند بارگذاری می‌شود.
 *
 * @return void
 */
function drh_enqueue_assets() {
	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();

	$css_path = $dir . '/assets/css/main.css';
	wp_enqueue_style(
		'drh-main',
		$uri . '/assets/css/main.css',
		array( 'kadence-global' ),
		file_exists( $css_path ) ? (string) filemtime( $css_path ) : DRH_VERSION
	);

	$js_path = $dir . '/assets/js/main.js';
	wp_enqueue_script(
		'drh-main',
		$uri . '/assets/js/main.js',
		array(),
		file_exists( $js_path ) ? (string) filemtime( $js_path ) : DRH_VERSION,
		true
	);
	wp_script_add_data( 'drh-main', 'strategy', 'defer' );
}
add_action( 'wp_enqueue_scripts', 'drh_enqueue_assets', 20 );

/**
 * پیش‌بارگذاری فونت‌های اصلی برای جلوگیری از پرش متن.
 *
 * @return void
 */
function drh_preload_fonts() {
	$fonts = array( 'Vazirmatn-Regular.woff2', 'Vazirmatn-Bold.woff2' );
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_stylesheet_directory_uri() . '/assets/fonts/' . $font )
		);
	}
}
add_action( 'wp_head', 'drh_preload_fonts', 1 );

/**
 * حذف اسکریپت‌های کم‌کاربرد هسته برای سبک‌تر شدن صفحات.
 *
 * @return void
 */
function drh_trim_core_assets() {
	if ( is_admin() ) {
		return;
	}
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'drh_trim_core_assets' );

/**
 * افزودن کلاس‌های کمکی به body.
 *
 * @param array<int,string> $classes کلاس‌های فعلی.
 * @return array<int,string>
 */
function drh_body_classes( $classes ) {
	$classes[] = 'drh-theme';
	if ( is_singular() ) {
		$classes[] = 'drh-singular';
	}
	return $classes;
}
add_filter( 'body_class', 'drh_body_classes' );
