<?php
/**
 * راه‌اندازی قالب: پشتیبانی‌ها، اندازهٔ تصاویر، محل منو و مقادیر پیش‌فرض.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * پشتیبانی‌های قالب.
 *
 * @return void
 */
function drh_theme_setup() {
	load_child_theme_textdomain( 'kadence-drhashemi', get_stylesheet_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	// اندازه‌های تصویر مخصوص کارت‌ها و جلد کتاب‌ها.
	add_image_size( 'drh-card', 760, 480, true );
	add_image_size( 'drh-cover', 600, 900, true );

	register_nav_menus(
		array(
			'primary' => __( 'منوی اصلی', 'kadence-drhashemi' ),
			'footer'  => __( 'منوی پابرگ', 'kadence-drhashemi' ),
		)
	);
}
add_action( 'after_setup_theme', 'drh_theme_setup', 20 );

/**
 * مقادیر پیش‌فرض قابل ویرایش در سفارشی‌ساز.
 *
 * این مقادیر از محتوای واقعی موجود در سایت (صفحهٔ شناسنامهٔ علمی و اجرایی)
 * گرفته شده‌اند و از پیشخوان ← نمایش ← سفارشی‌سازی قابل تغییرند.
 *
 * @return array<string,mixed>
 */
function drh_default_mods() {
	return array(
		'drh_hero_eyebrow'   => 'هیئت علمی دانشگاه آزاد اسلامی واحد لامرد',
		'drh_hero_title'     => 'دکتر سید احمد هاشمی',
		'drh_hero_subtitle'  => 'استاد تمام دانشگاه و مشاور توسعهٔ مدیریت، منابع انسانی و برنامه‌ریزی در سازمان',
		'drh_hero_text'      => 'عضو هیئت علمی تمام‌وقت دانشگاه آزاد اسلامی لامرد با بیش از دو دهه فعالیت علمی، پژوهشی و اجرایی در حوزه‌های مدیریت آموزشی، توسعهٔ سازمانی، بهره‌وری و مدیریت منابع انسانی؛ مشاور و مجری طرح‌های پژوهشی دانش‌بنیان و مدرس دوره‌های مدیریت و رهبری سازمان.',
		'drh_hero_primary_label' => 'مشاهدهٔ رزومهٔ کامل',
		'drh_hero_secondary_label' => 'معرفی بیشتر',
		'drh_about_title'    => 'دربارهٔ دکتر سید احمد هاشمی',
		'drh_about_text'     => "دکتر سید احمد هاشمی، استاد دانشگاه آزاد اسلامی واحد لامرد و دارندهٔ دکترای تخصصی مدیریت آموزشی از دانشگاه علوم و تحقیقات تهران (۱۳۸۸) است. کارنامهٔ او ترکیبی از تدریس در مقاطع تحصیلات تکمیلی، پژوهش در حوزهٔ مدیریت و آموزش و همکاری با سازمان‌ها در زمینهٔ برنامه‌ریزی، بهسازی منابع انسانی و ارتقای بهره‌وری است.\n\nحاصل این مسیر، تألیف و ترجمهٔ کتاب‌های تخصصی و انتشار مقاله‌های علمی در مجلات و همایش‌های داخلی و بین‌المللی است؛ آثاری که در بخش‌های همین سایت فهرست شده‌اند.",
		'drh_credential_items' => "عضو هیئت علمی تمام‌وقت دانشگاه آزاد اسلامی واحد لامرد\nاستاد رشتهٔ مدیریت آموزشی، دانشگاه آزاد اسلامی واحد لامرد\nمشاور و مجری طرح‌های پژوهشی توسعهٔ سازمانی و بهره‌وری\nمدرس دوره‌های مدیریت، رهبری و بهسازی منابع انسانی\nدکترای تخصصی مدیریت آموزشی، دانشگاه علوم و تحقیقات تهران (۱۳۸۸)",
		'drh_portrait_url'   => 'files/images/cv-photo.jpg',
		'drh_expertise_items' => "مدیریت آموزشی | برنامه‌ریزی، سیاست‌گذاری و ارتقای کیفیت در نظام‌های آموزشی\nتوسعهٔ سازمانی | طراحی ساختار، اصلاح فرایند و بهبود عملکرد سازمان\nمدیریت منابع انسانی | جذب، بهسازی، نگهداشت و توانمندسازی سرمایهٔ انسانی\nرفتار سازمانی و رهبری | سبک‌های رهبری، انگیزش و روابط انسانی در سازمان\nبهره‌وری و اثربخشی | ارزشیابی عملکرد و بهبود مستمر کیفیت خدمات\nکارآفرینی و آموزش | پرورش مهارت، نوآوری و آموزش‌های سازمانی",
		'drh_phone'          => '09177823024',
		'drh_phone_link'     => '+989177823024',
		'drh_email'          => 'Hmd_hashemi@yahoo.com',
		'drh_email_university' => 'seyedahmad.hashemi@iau.ac.ir',
		'drh_website'        => 'www.Dr-Hashemi.com',
		'drh_website_url'    => 'http://www.Dr-Hashemi.com',
		'drh_address'        => 'استان فارس، شهرستان لامرد، دانشگاه آزاد اسلامی',
	);
}

/**
 * دریافت یک مقدار پیش‌فرض.
 *
 * @param string $key نام کلید.
 * @return string
 */
function drh_default( $key ) {
	$defaults = drh_default_mods();
	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}

/**
 * ایجاد منو و اتصال صفحه‌های کلیدی در اولین فعال‌سازی قالب.
 *
 * فقط یک‌بار اجرا می‌شود؛ پس از آن مدیر می‌تواند منو را آزادانه ویرایش کند.
 *
 * @return void
 */
function drh_maybe_create_defaults() {
	if ( get_option( 'drh_setup_done' ) ) {
		return;
	}

	$pages = drh_find_core_pages();

	$mods = array();
	foreach ( array( 'drh_cv_page_id' => 'cv', 'drh_about_page_id' => 'about', 'drh_executive_cv_page_id' => 'executive' ) as $mod => $key ) {
		if ( ! empty( $pages[ $key ] ) ) {
			$mods[ $mod ] = (int) $pages[ $key ];
		}
	}
	foreach ( $mods as $mod => $value ) {
		if ( ! get_theme_mod( $mod ) ) {
			set_theme_mod( $mod, $value );
		}
	}

	drh_maybe_create_primary_menu( $pages );

	update_option( 'drh_setup_done', 1, false );
	flush_rewrite_rules( false );
}
add_action( 'after_switch_theme', 'drh_maybe_create_defaults' );

/**
 * یافتن صفحه‌های اصلی سایت بر اساس عنوان واقعی محتوای منتقل‌شده.
 *
 * @return array<string,int>
 */
function drh_find_core_pages() {
	$map = array(
		'about'     => 'کلام اول',
		'cv'        => 'شناسنامه علمی و اجرایی',
		'executive' => 'رزومه اجرایی',
	);
	$found = array();

	foreach ( $map as $key => $title ) {
		$page = get_page_by_path( sanitize_title( $title ) );
		if ( ! $page ) {
			$query = new WP_Query(
				array(
					'post_type'              => 'page',
					'post_status'            => 'publish',
					'title'                  => $title,
					'posts_per_page'         => 1,
					'no_found_rows'          => true,
					'update_post_term_cache' => false,
				)
			);
			$page = $query->have_posts() ? $query->posts[0] : null;
		}
		if ( $page ) {
			$found[ $key ] = (int) $page->ID;
		}
	}

	return $found;
}

/**
 * ساخت منوی اصلی پیش‌فرض (قابل ویرایش در پیشخوان ← نمایش ← فهرست‌ها).
 *
 * @param array<string,int> $pages صفحه‌های یافت‌شده.
 * @return void
 */
function drh_maybe_create_primary_menu( $pages ) {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$menu_name = __( 'منوی اصلی', 'kadence-drhashemi' );
	$existing  = wp_get_nav_menu_object( $menu_name );

	if ( ! empty( $locations['primary'] ) && wp_get_nav_menu_object( $locations['primary'] ) ) {
		return;
	}

	$menu_id = $existing ? $existing->term_id : wp_create_nav_menu( $menu_name );

	if ( is_wp_error( $menu_id ) ) {
		return;
	}

	if ( ! $existing ) {
		$items = array();

		$items[] = array(
			'title' => __( 'خانه', 'kadence-drhashemi' ),
			'url'   => home_url( '/' ),
		);
		if ( ! empty( $pages['about'] ) ) {
			$items[] = array(
				'title'     => __( 'دربارهٔ دکتر', 'kadence-drhashemi' ),
				'object_id' => $pages['about'],
				'type'      => 'post_type',
				'object'    => 'page',
			);
		}
		if ( ! empty( $pages['cv'] ) ) {
			$items[] = array(
				'title'     => __( 'رزومه و سوابق', 'kadence-drhashemi' ),
				'object_id' => $pages['cv'],
				'type'      => 'post_type',
				'object'    => 'page',
			);
		}

		$post_types = array(
			'dlew_article' => __( 'مقالات', 'kadence-drhashemi' ),
			'dlew_book'    => __( 'کتاب‌ها', 'kadence-drhashemi' ),
			'dlew_project' => __( 'طرح‌های پژوهشی', 'kadence-drhashemi' ),
		);
		foreach ( $post_types as $type => $label ) {
			if ( ! post_type_exists( $type ) ) {
				continue;
			}
			$items[] = array(
				'title' => $label,
				'url'   => get_post_type_archive_link( $type ),
			);
		}

		$items[] = array(
			'title' => __( 'تماس با من', 'kadence-drhashemi' ),
			'url'   => home_url( '/#contact' ),
		);

		foreach ( $items as $item ) {
			$args = array(
				'menu-item-title'  => $item['title'],
				'menu-item-status' => 'publish',
			);
			if ( isset( $item['object_id'] ) ) {
				$args['menu-item-object-id'] = $item['object_id'];
				$args['menu-item-object']    = $item['object'];
				$args['menu-item-type']      = $item['type'];
			} else {
				$args['menu-item-url']  = $item['url'];
				$args['menu-item-type'] = 'custom';
			}
			wp_update_nav_menu_item( $menu_id, 0, $args );
		}
	}

	$locations['primary'] = $menu_id;
	$locations['footer']  = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}
