<?php
/**
 * توابع کمکی نمایش محتوا.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * خواندن یک تنظیم سفارشی‌ساز با مقدار پیش‌فرض واقعی.
 *
 * @param string $key کلید تنظیم.
 * @return string
 */
function drh_mod( $key ) {
	$value = get_theme_mod( $key, drh_default( $key ) );
	return is_string( $value ) ? $value : '';
}

/**
 * نشانی یک صفحهٔ انتخابی در سفارشی‌ساز، با بازگشت به یک آرشیو.
 *
 * شناسه‌ها در قالب هاردکد نمی‌شوند؛ مدیر آن‌ها را در سفارشی‌ساز انتخاب می‌کند.
 *
 * @param string $mod_key  کلید تنظیم (شناسهٔ صفحه).
 * @param string $fallback آدرس جایگزین.
 * @return string
 */
function drh_page_link( $mod_key, $fallback = '' ) {
	$page_id = (int) get_theme_mod( $mod_key, 0 );
	if ( $page_id > 0 ) {
		$permalink = get_permalink( $page_id );
		if ( $permalink ) {
			return $permalink;
		}
	}
	return $fallback ? $fallback : home_url( '/' );
}

/**
 * برچسب فارسی نوع محتوا.
 *
 * @param string $type نام نوع محتوا.
 * @return string
 */
function drh_post_type_label( $type ) {
	$object = get_post_type_object( $type );
	if ( $object && ! empty( $object->labels->name ) ) {
		return $object->labels->name;
	}
	return __( 'مطلب', 'kadence-drhashemi' );
}

/**
 * آدرس اولین تصویر موجود برای یک مطلب.
 *
 * ترتیب: تصویر شاخص، سپس نخستین تصویر داخل متن. مسیرها ممکن است به فایل‌های
 * خارج از کتابخانهٔ رسانه اشاره کنند؛ در صورت نبود فایل، طرح جایگزین CSS
 * نمایش داده می‌شود.
 *
 * @param int|WP_Post|null $post مطلب.
 * @return array{url:string,alt:string}
 */
function drh_card_image( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return array(
			'url' => '',
			'alt' => '',
		);
	}

	if ( has_post_thumbnail( $post ) ) {
		$url = get_the_post_thumbnail_url( $post, 'drh-card' );
		if ( $url ) {
			return array(
				'url' => $url,
				'alt' => get_post_meta( $post->ID, '_wp_attachment_image_alt', true ) ?: get_the_title( $post ),
			);
		}
	}

	if ( preg_match( '/<img[^>]+src=("|\')([^"\']+)\1/i', $post->post_content, $matches ) ) {
		$resolved = drh_resolve_image_url( $matches[2] );
		if ( $resolved ) {
			return array(
				'url' => $resolved,
				'alt' => get_the_title( $post ),
			);
		}
	}

	return array(
		'url' => '',
		'alt' => '',
	);
}

/**
 * خلاصهٔ خوانا برای کارت‌ها.
 *
 * @param int|WP_Post|null $post  مطلب.
 * @param int              $words تعداد واژه.
 * @return string متن ساده و امن.
 */
function drh_card_excerpt( $post = null, $words = 26 ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}

	$text = '';

	if ( has_excerpt( $post ) ) {
		$text = $post->post_excerpt;
	} else {
		$description = get_post_meta( $post->ID, '_dlew_description', true );
		if ( is_string( $description ) && '' !== trim( $description ) ) {
			$text = $description;
		} else {
			$text = $post->post_content;
		}
	}

	$text = strip_shortcodes( (string) $text );
	$text = wp_strip_all_tags( $text );
	$text = trim( preg_replace( '/\s+/u', ' ', $text ) );

	if ( '' === $text ) {
		return '';
	}

	return wp_trim_words( $text, $words, '…' );
}

/**
 * دستهٔ اصلی یک مطلب (نخستین دستهٔ غیر از «دسته‌بندی نشده»).
 *
 * @param int|WP_Post|null $post مطلب.
 * @return WP_Term|null
 */
function drh_primary_term( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return null;
	}

	$terms = get_the_terms( $post, 'category' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return null;
	}

	$default = (int) get_option( 'default_category' );
	foreach ( $terms as $term ) {
		if ( (int) $term->term_id !== $default ) {
			return $term;
		}
	}

	return $terms[0];
}

/**
 * شمارش مطالب منتشرشدهٔ یک نوع محتوا.
 *
 * @param string $type نام نوع محتوا.
 * @return int
 */
function drh_count_published( $type ) {
	$counts = wp_count_posts( $type );
	return isset( $counts->publish ) ? (int) $counts->publish : 0;
}

/**
 * شمارش مطالب منتشرشدهٔ هر دسته برای مقالات.
 *
 * نتیجه یک ساعت کش می‌شود و با ذخیرهٔ مطلب یا ویرایش دسته پاک می‌شود.
 *
 * @return array<int,int> کلید: term_id، مقدار: تعداد.
 */
function drh_article_category_counts() {
	return drh_post_type_category_counts( 'dlew_article' );
}

/**
 * شمارش مطالب منتشرشدهٔ هر دسته برای یک نوع محتوا.
 *
 * @param string $post_type نام نوع محتوا.
 * @return array<int,int> کلید: term_id، مقدار: تعداد.
 */
function drh_post_type_category_counts( $post_type ) {
	$post_type = (string) $post_type;
	$cache_key = 'drh_cat_counts_' . md5( $post_type );
	$cached    = get_transient( $cache_key );
	if ( is_array( $cached ) ) {
		return $cached;
	}

	global $wpdb;
	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT tt.term_id AS term_id, COUNT(DISTINCT p.ID) AS total
			 FROM {$wpdb->posts} p
			 INNER JOIN {$wpdb->term_relationships} tr ON tr.object_id = p.ID
			 INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
			 WHERE p.post_type = %s AND p.post_status = 'publish' AND tt.taxonomy = 'category'
			 GROUP BY tt.term_id",
			$post_type
		)
	);

	$counts = array();
	foreach ( (array) $rows as $row ) {
		$counts[ (int) $row->term_id ] = (int) $row->total;
	}

	set_transient( $cache_key, $counts, HOUR_IN_SECONDS );
	return $counts;
}

/**
 * آیا این دسته دست‌کم یک مقالهٔ منتشرشده دارد؟
 *
 * @param int $term_id شناسهٔ دسته.
 * @return bool
 */
function drh_category_has_articles( $term_id ) {
	$counts = drh_article_category_counts();
	return ! empty( $counts[ (int) $term_id ] );
}

/**
 * پاک‌سازی کش شمارش دسته‌ها.
 *
 * @return void
 */
function drh_flush_category_cache() {
	foreach ( array( 'dlew_article', 'dlew_book', 'dlew_project', 'post' ) as $type ) {
		delete_transient( 'drh_cat_counts_' . md5( $type ) );
	}
}
add_action( 'save_post', 'drh_flush_category_cache' );
add_action( 'deleted_post', 'drh_flush_category_cache' );
add_action( 'edited_term', 'drh_flush_category_cache' );
add_action( 'created_term', 'drh_flush_category_cache' );
add_action( 'delete_term', 'drh_flush_category_cache' );

/**
 * دسته‌هایی که دست‌کم یک مقاله دارند، همراه با تعداد.
 *
 * @return array<int,array{term:WP_Term,count:int}>
 */
function drh_article_categories() {
	$counts = drh_article_category_counts();
	if ( empty( $counts ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'category',
			'include'    => array_keys( $counts ),
			'hide_empty' => false,
			'orderby'    => 'count',
			'order'      => 'DESC',
		)
	);

	if ( is_wp_error( $terms ) ) {
		return array();
	}

	$output = array();
	foreach ( $terms as $term ) {
		$output[] = array(
			'term'  => $term,
			'count' => isset( $counts[ $term->term_id ] ) ? (int) $counts[ $term->term_id ] : 0,
		);
	}

	return $output;
}

/**
 * فهرست حوزه‌های تخصصی از تنظیمات سفارشی‌ساز.
 *
 * هر خط به شکل «عنوان | توضیح» است.
 *
 * @return array<int,array{title:string,text:string}>
 */
function drh_expertise_items() {
	$raw   = drh_mod( 'drh_expertise_items' );
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	$items = array();
	$icons = array( 'chart', 'layers', 'users', 'quote', 'target', 'leaf' );

	foreach ( (array) $lines as $index => $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts   = array_map( 'trim', explode( '|', $line, 2 ) );
		$items[] = array(
			'title' => $parts[0],
			'text'  => isset( $parts[1] ) ? $parts[1] : '',
			'icon'  => $icons[ $index % count( $icons ) ],
		);
	}

	return $items;
}

/**
 * فهرست سوابق کلیدی از تنظیمات سفارشی‌ساز.
 *
 * @return array<int,string>
 */
function drh_credential_items() {
	$raw   = drh_mod( 'drh_credential_items' );
	$lines = preg_split( '/\r\n|\r|\n/', (string) $raw );
	$items = array();

	foreach ( (array) $lines as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$items[] = $line;
		}
	}

	return $items;
}

/**
 * اطلاعات تماس معتبر سایت.
 *
 * @return array<int,array{icon:string,label:string,value:string,url:string}>
 */
function drh_contact_items() {
	$items = array();

	$phone = drh_mod( 'drh_phone' );
	if ( $phone ) {
		$link = drh_mod( 'drh_phone_link' );
		$items[] = array(
			'icon'  => 'phone',
			'label' => __( 'تلفن', 'kadence-drhashemi' ),
			'value' => $phone,
			'url'   => $link ? 'tel:' . preg_replace( '/[^0-9+]/', '', $link ) : '',
			'rtl'   => true,
		);
	}

	$email = drh_mod( 'drh_email' );
	if ( $email ) {
		$items[] = array(
			'icon'  => 'mail',
			'label' => __( 'ایمیل', 'kadence-drhashemi' ),
			'value' => $email,
			'url'   => 'mailto:' . $email,
			'rtl'   => false,
		);
	}

	$uni_email = drh_mod( 'drh_email_university' );
	if ( $uni_email ) {
		$items[] = array(
			'icon'  => 'mail',
			'label' => __( 'ایمیل دانشگاهی', 'kadence-drhashemi' ),
			'value' => $uni_email,
			'url'   => 'mailto:' . $uni_email,
			'rtl'   => false,
		);
	}

	$website = drh_mod( 'drh_website' );
	if ( $website ) {
		$items[] = array(
			'icon'  => 'globe',
			'label' => __( 'وب‌سایت', 'kadence-drhashemi' ),
			'value' => $website,
			'url'   => drh_mod( 'drh_website_url' ),
			'rtl'   => false,
		);
	}

	$address = drh_mod( 'drh_address' );
	if ( $address ) {
		$items[] = array(
			'icon'  => 'pin',
			'label' => __( 'نشانی', 'kadence-drhashemi' ),
			'value' => $address,
			'url'   => '',
			'rtl'   => true,
		);
	}

	return $items;
}

/**
 * مسیر راهنما (breadcrumb) سبک و بدون افزونه.
 *
 * @return void
 */
function drh_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}

	$crumbs = array(
		array(
			'label' => __( 'خانه', 'kadence-drhashemi' ),
			'url'   => home_url( '/' ),
		),
	);

	if ( is_singular() ) {
		$type = get_post_type();
		if ( 'page' !== $type ) {
			$archive = get_post_type_archive_link( $type );
			if ( $archive ) {
				$crumbs[] = array(
					'label' => drh_post_type_label( $type ),
					'url'   => $archive,
				);
			}
		}
		$crumbs[] = array(
			'label' => get_the_title(),
			'url'   => '',
		);
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$crumbs[] = array(
				'label' => $term->name,
				'url'   => '',
			);
		}
	} elseif ( is_search() ) {
		$crumbs[] = array(
			'label' => __( 'نتایج جست‌وجو', 'kadence-drhashemi' ),
			'url'   => '',
		);
	} elseif ( is_404() ) {
		$crumbs[] = array(
			'label' => __( 'صفحه یافت نشد', 'kadence-drhashemi' ),
			'url'   => '',
		);
	} elseif ( is_post_type_archive() ) {
		$crumbs[] = array(
			'label' => post_type_archive_title( '', false ),
			'url'   => '',
		);
	} elseif ( is_home() ) {
		$crumbs[] = array(
			'label' => __( 'نوشته‌ها', 'kadence-drhashemi' ),
			'url'   => '',
		);
	}

	echo '<nav class="drh-breadcrumb" aria-label="' . esc_attr__( 'مسیر صفحه', 'kadence-drhashemi' ) . '"><ol>';
	$last = count( $crumbs ) - 1;
	foreach ( $crumbs as $index => $crumb ) {
		echo '<li>';
		if ( $crumb['url'] && $index !== $last ) {
			echo '<a href="' . esc_url( $crumb['url'] ) . '">' . esc_html( $crumb['label'] ) . '</a>';
		} else {
			echo '<span aria-current="page">' . esc_html( $crumb['label'] ) . '</span>';
		}
		echo '</li>';
	}
	echo '</ol></nav>';
}

/**
 * صفحه‌بندی استاندارد وردپرس با آرایه‌بندی راست‌به‌چپ.
 *
 * @param WP_Query|null $query پرس‌وجوی دلخواه.
 * @return void
 */
function drh_pagination( $query = null ) {
	$query = $query ? $query : $GLOBALS['wp_query'];
	if ( $query->max_num_pages < 2 ) {
		return;
	}

	$links = paginate_links(
		array(
			'total'     => (int) $query->max_num_pages,
			'current'   => max( 1, (int) get_query_var( 'paged' ) ),
			'type'      => 'array',
			'mid_size'  => 1,
			'end_size'  => 1,
			'prev_text' => drh_get_icon( 'chevron', 18 ) . '<span class="screen-reader-text">' . esc_html__( 'صفحهٔ قبل', 'kadence-drhashemi' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . esc_html__( 'صفحهٔ بعد', 'kadence-drhashemi' ) . '</span>' . str_replace( 'm14 6-6 6 6 6', 'm10 6 6 6-6 6', drh_get_icon( 'chevron', 18 ) ),
		)
	);

	if ( empty( $links ) ) {
		return;
	}

	echo '<nav class="drh-pagination" aria-label="' . esc_attr__( 'صفحه‌بندی', 'kadence-drhashemi' ) . '"><ul>';
	foreach ( $links as $link ) {
		$classes = false !== strpos( $link, 'current' ) ? ' class="is-current"' : '';
		// رقم‌های متن پیوند فارسی می‌شوند؛ اعداد داخل آدرس دست‌نخورده می‌مانند.
		$link = preg_replace_callback(
			'/>([^<]*)</u',
			function ( $drh_match ) {
				return '>' . drh_fa_digits( $drh_match[1] ) . '<';
			},
			$link
		);
		echo '<li' . $classes . '>' . wp_kses_post( $link ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</ul></nav>';
}

/**
 * دکمهٔ «همهٔ مطالب» به‌همراه لینک آرشیو نوع محتوا.
 *
 * @param string $type نوع محتوا.
 * @param string $label برچسب.
 * @return void
 */
function drh_archive_link( $type, $label = '' ) {
	$url = get_post_type_archive_link( $type );
	if ( ! $url ) {
		return;
	}
	$label = $label ? $label : sprintf( __( 'مشاهدهٔ همهٔ %s', 'kadence-drhashemi' ), drh_post_type_label( $type ) );
	printf(
		'<a class="drh-btn drh-btn--ghost drh-btn--sm" href="%s">%s %s</a>',
		esc_url( $url ),
		esc_html( $label ),
		drh_get_icon( 'arrow', 16 ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * عنوان بخش‌ها با خط تأکیدی.
 *
 * @param string $eyebrow متن بالای عنوان.
 * @param string $title   عنوان.
 * @param string $class   کلاس اضافی.
 * @return void
 */
function drh_section_title( $eyebrow, $title, $class = '' ) {
	echo '<div class="drh-section__head ' . esc_attr( $class ) . '">';
	if ( $eyebrow ) {
		echo '<p class="drh-eyebrow">' . esc_html( $eyebrow ) . '</p>';
	}
	echo '<h2 class="drh-section__title">' . esc_html( $title ) . '</h2>';
	echo '</div>';
}

/**
 * «ادامهٔ مطلب» برای آرشیوها.
 *
 * @return string
 */
function drh_more_link_text() {
	return __( 'ادامهٔ مطلب', 'kadence-drhashemi' );
}

/**
 * تبدیل رقم‌های لاتین به رقم‌های فارسی.
 *
 * @param string|int $value مقدار ورودی.
 * @return string
 */
function drh_fa_digits( $value ) {
	$latin   = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
	return str_replace( $latin, $persian, (string) $value );
}

/**
 * عدد قالب‌بندی‌شده با رقم‌های فارسی.
 *
 * @param int|float $number عدد.
 * @return string
 */
function drh_number( $number ) {
	return drh_fa_digits( number_format_i18n( $number ) );
}

/**
 * تبدیل تاریخ میلادی به شمسی.
 *
 * الگوریتم استاندارد تبدیل تقویم بدون وابستگی به افزونهٔ خارجی.
 *
 * @param int $gy سال میلادی.
 * @param int $gm ماه میلادی.
 * @param int $gd روز میلادی.
 * @return array{0:int,1:int,2:int} سال، ماه و روز شمسی.
 */
function drh_gregorian_to_jalali( $gy, $gm, $gd ) {
	$g_days_in_month = array( 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334 );
	$gy2             = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;

	$days = 355666 + ( 365 * $gy ) + (int) ( ( $gy2 + 3 ) / 4 ) - (int) ( ( $gy2 + 99 ) / 100 )
		+ (int) ( ( $gy2 + 399 ) / 400 ) + $gd + $g_days_in_month[ $gm - 1 ];

	$jy    = -1595 + ( 33 * (int) ( $days / 12053 ) );
	$days %= 12053;
	$jy   += 4 * (int) ( $days / 1461 );
	$days %= 1461;

	if ( $days > 365 ) {
		$jy  += (int) ( ( $days - 1 ) / 365 );
		$days = ( $days - 1 ) % 365;
	}

	if ( $days < 186 ) {
		$jm = 1 + (int) ( $days / 31 );
		$jd = 1 + ( $days % 31 );
	} else {
		$days -= 186;
		$jm    = 7 + (int) ( $days / 30 );
		$jd    = 1 + ( $days % 30 );
	}

	return array( $jy, $jm, $jd );
}

/**
 * تاریخ شمسی یک مطلب برای نمایش.
 *
 * @param int|WP_Post|null $post مطلب.
 * @return string نمونه: «۱۴ مهر ۱۳۹۹».
 */
function drh_fa_date( $post = null ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}

	$parts = explode( '-', substr( (string) $post->post_date, 0, 10 ) );
	if ( count( $parts ) !== 3 ) {
		return '';
	}

	list( $jy, $jm, $jd ) = drh_gregorian_to_jalali( (int) $parts[0], (int) $parts[1], (int) $parts[2] );

	$months = array(
		__( 'فروردین', 'kadence-drhashemi' ),
		__( 'اردیبهشت', 'kadence-drhashemi' ),
		__( 'خرداد', 'kadence-drhashemi' ),
		__( 'تیر', 'kadence-drhashemi' ),
		__( 'مرداد', 'kadence-drhashemi' ),
		__( 'شهریور', 'kadence-drhashemi' ),
		__( 'مهر', 'kadence-drhashemi' ),
		__( 'آبان', 'kadence-drhashemi' ),
		__( 'آذر', 'kadence-drhashemi' ),
		__( 'دی', 'kadence-drhashemi' ),
		__( 'بهمن', 'kadence-drhashemi' ),
		__( 'اسفند', 'kadence-drhashemi' ),
	);

	$month = isset( $months[ $jm - 1 ] ) ? $months[ $jm - 1 ] : '';

	return drh_fa_digits( $jd . ' ' . $month . ' ' . $jy );
}
