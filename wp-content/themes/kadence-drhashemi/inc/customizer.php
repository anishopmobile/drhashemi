<?php
/**
 * تنظیمات سفارشی‌ساز برای ویرایش بخش‌های صفحهٔ اصلی و اطلاعات تماس.
 *
 * @package kadence-drhashemi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ثبت پنل و کنترل‌ها.
 *
 * @param WP_Customize_Manager $wp_customize مدیر سفارشی‌ساز.
 * @return void
 */
function drh_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'drh_panel',
		array(
			'title'       => __( 'تنظیمات سایت دکتر هاشمی', 'kadence-drhashemi' ),
			'description' => __( 'متن‌ها، تصویر، سوابق و راه‌های ارتباطی صفحهٔ اصلی و سربرگ.', 'kadence-drhashemi' ),
			'priority'    => 5,
		)
	);

	/* ---------------------------------------------------------------- سربرگ */
	$wp_customize->add_section(
		'drh_hero_section',
		array(
			'title' => __( 'بخش معرفی (سربرگ صفحهٔ اصلی)', 'kadence-drhashemi' ),
			'panel' => 'drh_panel',
		)
	);

	$text_fields = array(
		'drh_hero_eyebrow'         => __( 'متن کوچک بالای عنوان', 'kadence-drhashemi' ),
		'drh_hero_title'           => __( 'عنوان اصلی', 'kadence-drhashemi' ),
		'drh_hero_subtitle'        => __( 'زیرعنوان', 'kadence-drhashemi' ),
		'drh_hero_primary_label'   => __( 'برچسب دکمهٔ اصلی', 'kadence-drhashemi' ),
		'drh_hero_secondary_label' => __( 'برچسب دکمهٔ دوم', 'kadence-drhashemi' ),
	);

	$priority = 10;
	foreach ( $text_fields as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => drh_default( $key ),
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'    => $label,
				'section'  => 'drh_hero_section',
				'type'     => 'text',
				'priority' => $priority++,
			)
		);
	}

	$wp_customize->add_setting(
		'drh_hero_text',
		array(
			'default'           => drh_default( 'drh_hero_text' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'drh_hero_text',
		array(
			'label'    => __( 'توضیح کوتاه معرفی', 'kadence-drhashemi' ),
			'section'  => 'drh_hero_section',
			'type'     => 'textarea',
			'priority' => $priority++,
		)
	);

	if ( class_exists( 'WP_Customize_Media_Control' ) ) {
		$wp_customize->add_setting(
			'drh_portrait_id',
			array(
				'default'           => 0,
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				'drh_portrait_id',
				array(
					'label'       => __( 'تصویر دکتر در بخش معرفی', 'kadence-drhashemi' ),
					'description' => __( 'تصویر عمودی و با کیفیت بارگذاری کنید. این تصویر بر نشانی پیش‌فرض اولویت دارد.', 'kadence-drhashemi' ),
					'section'     => 'drh_hero_section',
					'mime_type'   => 'image',
					'priority'    => $priority++,
				)
			)
		);
	}

	$wp_customize->add_setting(
		'drh_portrait_url',
		array(
			'default'           => drh_default( 'drh_portrait_url' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'drh_portrait_url',
		array(
			'label'       => __( 'نشانی تصویر پیش‌فرض (اختیاری)', 'kadence-drhashemi' ),
			'description' => __( 'نشانی تصویر موجود در پوشهٔ files/images؛ اگر تصویر کتابخانهٔ رسانه انتخاب نشود، این تصویر نمایش داده می‌شود.', 'kadence-drhashemi' ),
			'section'     => 'drh_hero_section',
			'type'        => 'text',
			'priority'    => $priority++,
		)
	);

	$page_fields = array(
		'drh_cv_page_id'           => __( 'صفحهٔ رزومهٔ علمی و اجرایی', 'kadence-drhashemi' ),
		'drh_about_page_id'        => __( 'صفحهٔ معرفی (دربارهٔ دکتر)', 'kadence-drhashemi' ),
		'drh_executive_cv_page_id' => __( 'صفحهٔ رزومهٔ اجرایی', 'kadence-drhashemi' ),
	);
	foreach ( $page_fields as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => 0,
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'    => $label,
				'section'  => 'drh_hero_section',
				'type'     => 'dropdown-pages',
				'priority' => $priority++,
			)
		);
	}

	/* -------------------------------------------------------------- درباره */
	$wp_customize->add_section(
		'drh_about_section',
		array(
			'title' => __( 'بخش دربارهٔ دکتر', 'kadence-drhashemi' ),
			'panel' => 'drh_panel',
		)
	);

	$wp_customize->add_setting(
		'drh_about_title',
		array(
			'default'           => drh_default( 'drh_about_title' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'drh_about_title',
		array(
			'label'   => __( 'عنوان بخش', 'kadence-drhashemi' ),
			'section' => 'drh_about_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'drh_about_text',
		array(
			'default'           => drh_default( 'drh_about_text' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'drh_about_text',
		array(
			'label'       => __( 'متن بخش درباره', 'kadence-drhashemi' ),
			'description' => __( 'هر خط خالی، یک پاراگراف تازه می‌سازد.', 'kadence-drhashemi' ),
			'section'     => 'drh_about_section',
			'type'        => 'textarea',
		)
	);

	/* ------------------------------------------------------ سوابق و تخصص‌ها */
	$wp_customize->add_section(
		'drh_lists_section',
		array(
			'title' => __( 'حوزه‌های تخصصی و سوابق', 'kadence-drhashemi' ),
			'panel' => 'drh_panel',
		)
	);

	$wp_customize->add_setting(
		'drh_expertise_items',
		array(
			'default'           => drh_default( 'drh_expertise_items' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'drh_expertise_items',
		array(
			'label'       => __( 'حوزه‌های تخصصی', 'kadence-drhashemi' ),
			'description' => __( 'هر خط یک حوزه، به شکل: عنوان | توضیح کوتاه', 'kadence-drhashemi' ),
			'section'     => 'drh_lists_section',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'drh_credential_items',
		array(
			'default'           => drh_default( 'drh_credential_items' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'drh_credential_items',
		array(
			'label'       => __( 'سوابق و مسئولیت‌های کلیدی', 'kadence-drhashemi' ),
			'description' => __( 'هر خط یک سابقه. این فهرست در صفحهٔ اصلی نمایش داده می‌شود.', 'kadence-drhashemi' ),
			'section'     => 'drh_lists_section',
			'type'        => 'textarea',
		)
	);

	/* -------------------------------------------------------------- تماس */
	$wp_customize->add_section(
		'drh_contact_section',
		array(
			'title'       => __( 'اطلاعات تماس', 'kadence-drhashemi' ),
			'description' => __( 'هر فیلدی که خالی بماند در سایت نمایش داده نمی‌شود.', 'kadence-drhashemi' ),
			'panel'       => 'drh_panel',
		)
	);

	$contact_fields = array(
		'drh_phone'            => array( __( 'شمارهٔ تلفن', 'kadence-drhashemi' ), 'sanitize_text_field' ),
		'drh_phone_link'       => array( __( 'شمارهٔ تلفن برای تماس مستقیم', 'kadence-drhashemi' ), 'sanitize_text_field' ),
		'drh_email'            => array( __( 'ایمیل', 'kadence-drhashemi' ), 'sanitize_email' ),
		'drh_email_university' => array( __( 'ایمیل دانشگاهی', 'kadence-drhashemi' ), 'sanitize_email' ),
		'drh_website'          => array( __( 'نشانی وب‌سایت (متن نمایشی)', 'kadence-drhashemi' ), 'sanitize_text_field' ),
		'drh_website_url'      => array( __( 'نشانی وب‌سایت (پیوند کامل)', 'kadence-drhashemi' ), 'esc_url_raw' ),
		'drh_address'          => array( __( 'نشانی محل کار', 'kadence-drhashemi' ), 'sanitize_text_field' ),
	);

	foreach ( $contact_fields as $key => $config ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => drh_default( $key ),
				'transport'         => 'refresh',
				'sanitize_callback' => $config[1],
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $config[0],
				'section' => 'drh_contact_section',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'drh_customize_register' );
