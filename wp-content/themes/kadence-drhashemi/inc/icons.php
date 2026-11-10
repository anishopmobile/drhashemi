<?php
/**
 * مجموعه آیکون‌های SVG درون‌خطی.
 *
 * همهٔ آیکون‌ها تزئینی هستند و aria-hidden دارند؛ متن کنارشان نقش برچسب دارد.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * مسیرهای SVG هر آیکون (stroke-based، سازگار با currentColor).
 *
 * @return array<string,string>
 */
function drh_icon_paths() {
	return array(
		'search'   => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'close'    => '<path d="M6 6 18 18M18 6 6 18"/>',
		'menu'     => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'arrow'    => '<path d="M19 12H5"/><path d="m12 19-7-7 7-7"/>',
		'download' => '<path d="M12 3v12"/><path d="m7 11 5 5 5-5"/><path d="M5 21h14"/>',
		'book'     => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5z"/><path d="M4 20.5A2.5 2.5 0 0 1 6.5 18H20v3H6.5"/>',
		'article'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/>',
		'layers'   => '<path d="m12 3 9 5-9 5-9-5z"/><path d="m3 13 9 5 9-5"/>',
		'cap'      => '<path d="m2 8 10-4 10 4-10 4z"/><path d="M6 10.5V16c0 1.7 2.7 3 6 3s6-1.3 6-3v-5.5"/><path d="M22 8v6"/>',
		'users'    => '<circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.2 2.7-5.2 6-5.2s6 2 6 5.2"/><path d="M17 6.2a3 3 0 0 1 0 5.6"/><path d="M18 14.6c2.4.5 4 2.3 4 4.9"/>',
		'chart'    => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
		'target'   => '<circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="1"/>',
		'leaf'     => '<path d="M20 4C10 4 4 9 4 16a4 4 0 0 0 4 4c7 0 12-6 12-16Z"/><path d="M4 20C7 15 11 12 16 10"/>',
		'check'    => '<path d="m4 12 5 5L20 6"/>',
		'phone'    => '<path d="M6.5 3h3l1.5 4-2 1.5a12 12 0 0 0 5.5 5.5L16 12l4 1.5v3a2 2 0 0 1-2.2 2A16.5 16.5 0 0 1 4 6.2 2 2 0 0 1 6.5 3Z"/>',
		'mail'     => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 7 8.5 6 8.5-6"/>',
		'globe'    => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/>',
		'pin'      => '<path d="M12 21s7-5.6 7-11a7 7 0 1 0-14 0c0 5.4 7 11 7 11Z"/><circle cx="12" cy="10" r="2.6"/>',
		'calendar' => '<rect x="3.5" y="5" width="17" height="16" rx="2.5"/><path d="M8 3v4M16 3v4M3.5 10h17"/>',
		'quote'    => '<path d="M9 6c-3 1.5-4.5 4-4.5 7.5V18h5v-5H6c0-2.5.8-4.3 3-5.5Z"/><path d="M19 6c-3 1.5-4.5 4-4.5 7.5V18h5v-5H16c0-2.5.8-4.3 3-5.5Z"/>',
		'trophy'   => '<path d="M8 4h8v5a4 4 0 0 1-8 0z"/><path d="M8 5H5v2a3 3 0 0 0 3 3M16 5h3v2a3 3 0 0 1-3 3"/><path d="M12 13v4M9 20h6"/>',
		'chevron'  => '<path d="m14 6-6 6 6 6"/>',
		'arrow-up' => '<path d="M12 20V5"/><path d="m5 12 7-7 7 7"/>',
	);
}

/**
 * چاپ یک آیکون SVG.
 *
 * @param string $name  نام آیکون.
 * @param int    $size  اندازه به پیکسل.
 * @param string $class کلاس اضافی.
 * @return string خروجی امن HTML.
 */
function drh_get_icon( $name, $size = 24, $class = '' ) {
	$paths = drh_icon_paths();
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	$classes = 'drh-icon' . ( $class ? ' ' . $class : '' );

	return sprintf(
		'<svg class="%1$s" width="%2$d" height="%2$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%3$s</svg>',
		esc_attr( $classes ),
		(int) $size,
		$paths[ $name ] // مسیرها ثابت و درون کد تعریف شده‌اند.
	);
}

/**
 * چاپ مستقیم آیکون.
 *
 * @param string $name  نام آیکون.
 * @param int    $size  اندازه.
 * @param string $class کلاس.
 * @return void
 */
function drh_icon( $name, $size = 24, $class = '' ) {
	echo drh_get_icon( $name, $size, $class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- خروجی از drh_get_icon امن است.
}
