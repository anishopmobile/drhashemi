<?php
/**
 * اصلاح‌های نمایشی محتوای قدیمی بدون بازنویسی متن علمی.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * اصلاح برچسب‌های ناقص، جدول‌های غیرریسپانسیو و تصاویر سنگین در متن محتوا.
 *
 * @param string $content محتوای مطلب.
 * @return string
 */
function drh_filter_content( $content ) {
	if ( is_admin() || '' === trim( (string) $content ) ) {
		return $content;
	}

	// ۱) تگ‌های <a ... /> که در محتوای قدیمی به‌صورت خودبسته نوشته شده‌اند.
	$content = preg_replace( '/<a\s([^>]*?)\s*\/>/i', '<a $1>', $content );

	// ۲) نگاشت نشانی فایل‌های قدیمی به نسخهٔ محلی موجود.
	$content = drh_localize_content_urls( $content );

	// ۳) جدول‌ها در یک قالب قابل اسکرول قرار می‌گیرند.
	$open  = preg_match_all( '/<table\b[^>]*>/i', $content );
	$close = preg_match_all( '/<\/table>/i', $content );
	if ( $open && $open === $close ) {
		$content = preg_replace( '/<table\b([^>]*)>/i', '<div class="drh-table-wrap"><table$1>', $content );
		$content = str_replace( '</table>', '</table></div>', $content );
	}

	// ۴) بارگذاری تنبل و ابعاد پایدار برای تصاویر داخل متن.
	$content = preg_replace_callback(
		'/<img\b[^>]*>/i',
		static function ( $matches ) {
			$tag = $matches[0];
			if ( false === stripos( $tag, 'loading=' ) ) {
				$tag = str_replace( '<img', '<img loading="lazy"', $tag );
			}
			if ( false === stripos( $tag, 'decoding=' ) ) {
				$tag = str_replace( '<img', '<img decoding="async"', $tag );
			}
			if ( false === stripos( $tag, 'alt=' ) ) {
				$tag = str_replace( '<img', '<img alt=""', $tag );
			}
			return $tag;
		},
		$content
	);

	return $content;
}
add_filter( 'the_content', 'drh_filter_content', 20 );
