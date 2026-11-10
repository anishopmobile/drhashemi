<?php
/**
 * تنظیم پرس‌وجوهای آرشیو.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * چیدمان آرشیوها و پشتیبانی از آرشیو دسته‌ای برای انواع محتوای اختصاصی.
 *
 * دسته‌های منتقل‌شده به مقالات، کتاب‌ها و طرح‌های پژوهشی تعلق دارند؛ بنابراین
 * آرشیو دسته باید همهٔ انواع منتشرشده را نشان دهد، نه فقط نوشته‌های پیش‌فرض.
 *
 * @param WP_Query $query پرس‌وجوی اصلی.
 * @return void
 */
function drh_pre_get_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_category() ) {
		$types = array( 'post' );
		foreach ( array( 'dlew_article', 'dlew_book', 'dlew_project' ) as $type ) {
			if ( post_type_exists( $type ) ) {
				$types[] = $type;
			}
		}
		$query->set( 'post_type', $types );
		return;
	}

	if ( $query->is_post_type_archive() ) {
		$type    = $query->get( 'post_type' );
		$type    = is_array( $type ) ? reset( $type ) : $type;
		$per_page = array(
			'dlew_article' => 9,
			'dlew_book'    => 12,
			'dlew_project' => 9,
		);
		if ( isset( $per_page[ $type ] ) ) {
			$query->set( 'posts_per_page', $per_page[ $type ] );
		}
	}
}
add_action( 'pre_get_posts', 'drh_pre_get_posts' );

/**
 * محدود کردن نتایج جست‌وجو به انواع عمومی و قابل جست‌وجو.
 *
 * @param WP_Query $query پرس‌وجو.
 * @return void
 */
function drh_search_post_types( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$requested = $query->get( 'post_type' );
	if ( $requested ) {
		return;
	}

	$types = array();
	foreach ( get_post_types( array( 'public' => true, 'exclude_from_search' => false ), 'names' ) as $type ) {
		if ( 'attachment' !== $type ) {
			$types[] = $type;
		}
	}
	$query->set( 'post_type', $types );
}
add_action( 'pre_get_posts', 'drh_search_post_types' );
