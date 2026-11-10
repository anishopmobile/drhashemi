<?php
/**
 * مدیریت رسانه‌های منتقل‌شده که در کتابخانهٔ وردپرس ثبت نشده‌اند.
 *
 * تصاویر و PDFهای سایت قدیمی مستقیماً در پوشه‌های files/images و files/pdf
 * قرار دارند. این توابع آن‌ها را به نشانی محلی نگاشت می‌کنند و از نمایش
 * تصویرهای شکسته جلوگیری می‌کنند.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * یافتن نسخهٔ محلی یک فایل بر اساس نام فایل.
 *
 * @param string $url نشانی قدیمی یا محلی.
 * @return string نشانی محلی فایل یا رشتهٔ خالی.
 */
function drh_local_file_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}

	$path = wp_parse_url( $url, PHP_URL_PATH );
	if ( ! $path ) {
		return '';
	}

	$file = basename( $path );
	if ( '' === $file || '.' === $file || '..' === $file ) {
		return '';
	}

	foreach ( array( 'images', 'pdf' ) as $folder ) {
		$absolute = ABSPATH . 'files/' . $folder . '/' . $file;
		if ( is_readable( $absolute ) ) {
			return home_url( '/files/' . $folder . '/' . rawurlencode( $file ) );
		}
	}

	return '';
}

/**
 * تبدیل نشانی تصویر به نشانی قابل نمایش.
 *
 * تصویرهای میزبان قدیمی تنها زمانی برگردانده می‌شوند که نسخهٔ محلی داشته
 * باشند؛ در غیر این صورت رشتهٔ خالی تا طرح جایگزین نمایش داده شود.
 *
 * @param string $url نشانی تصویر.
 * @return string
 */
function drh_resolve_image_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}

	$local = drh_local_file_url( $url );
	if ( $local ) {
		return $local;
	}

	$host = wp_parse_url( $url, PHP_URL_HOST );
	if ( ! $host ) {
		return '';
	}

	$home_host = wp_parse_url( home_url(), PHP_URL_HOST );
	$old_hosts = array( 'dr-hashemi.com', 'www.dr-hashemi.com' );

	if ( in_array( strtolower( $host ), $old_hosts, true ) ) {
		return '';
	}

	if ( $home_host && strtolower( $host ) === strtolower( $home_host ) ) {
		// فایل محلی موجود نیست؛ نمایش تصویر شکسته بی‌فایده است.
		return '';
	}

	return esc_url_raw( $url );
}

/**
 * ابعاد یک تصویر محلی برای تعیین width/height.
 *
 * @param string $url نشانی تصویر.
 * @return array{width:int,height:int}
 */
function drh_image_dimensions( $url ) {
	$empty = array(
		'width'  => 0,
		'height' => 0,
	);

	$path = wp_parse_url( (string) $url, PHP_URL_PATH );
	if ( ! $path ) {
		return $empty;
	}

	$file = basename( $path );
	foreach ( array( 'images', 'pdf' ) as $folder ) {
		$absolute = ABSPATH . 'files/' . $folder . '/' . $file;
		if ( is_readable( $absolute ) ) {
			$size = @getimagesize( $absolute ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			if ( $size ) {
				return array(
					'width'  => (int) $size[0],
					'height' => (int) $size[1],
				);
			}
		}
	}

	return $empty;
}

/**
 * نگاشت نشانی‌های قدیمی داخل متن به فایل‌های محلی موجود.
 *
 * فقط نشانی فایل‌هایی تغییر می‌کند که نسخهٔ محلی دارند؛ بقیهٔ متن دست‌نخورده
 * می‌ماند تا محتوای علمی بازنویسی نشود.
 *
 * @param string $content محتوای مطلب.
 * @return string
 */
function drh_localize_content_urls( $content ) {
	if ( '' === trim( (string) $content ) ) {
		return $content;
	}

	return preg_replace_callback(
		'/(src|href)=("|\')(https?:\/\/(?:www\.)?dr-hashemi\.com\/[^"\']+)\2/i',
		static function ( $matches ) {
			$aliases = array(
				// تصویر قدیمی CV در سایت قبلی؛ معادل محلی همان پرتره است.
				'scientific-and-executive-cv.jpg' => 'cv-photo.jpg',
			);

			$path = wp_parse_url( $matches[3], PHP_URL_PATH );
			$base = $path ? basename( $path ) : '';

			if ( $base && isset( $aliases[ $base ] ) ) {
				$local = drh_local_file_url( 'files/images/' . $aliases[ $base ] );
			} else {
				$local = drh_local_file_url( $matches[3] );
			}

			if ( ! $local ) {
				return $matches[0];
			}
			return $matches[1] . '=' . $matches[2] . esc_url( $local ) . $matches[2];
		},
		$content
	);
}

/**
 * نشانی تصویر معرفی دکتر.
 *
 * اولویت: تصویر کتابخانهٔ رسانه، سپس تصویر محلی پیش‌فرض.
 *
 * @return string
 */
function drh_portrait_url() {
	$attachment_id = (int) get_theme_mod( 'drh_portrait_id', 0 );
	if ( $attachment_id > 0 ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large' );
		if ( $url ) {
			return $url;
		}
	}

	$custom = drh_mod( 'drh_portrait_url' );
	if ( $custom ) {
		$resolved = drh_resolve_image_url( $custom );
		if ( $resolved ) {
			return $resolved;
		}
	}

	return '';
}
