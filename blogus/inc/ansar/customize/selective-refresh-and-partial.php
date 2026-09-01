<?php
function blogus_selective_refresh( $wp_customize ) {
	
	if (isset($wp_customize->selective_refresh)) {

		// site logo
		$wp_customize->selective_refresh->add_partial('custom_logo', array(
			'selector'        => '.site-logo',
			'render_callback' => 'custom_logo_selective_refresh'
		));
		
		// site title
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a, .site-title-footer a',
            'render_callback' => 'blogus_customize_partial_blogname',
        ));

		// site tagline
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description , .site-description-footer',
            'render_callback' => 'blogus_customize_partial_blogdescription',
        ));

        $wp_customize->selective_refresh->add_partial('blogus_header_social_icons', array(
            'selector'        => '.bs-header-main .left-nav',
            'render_callback' => 'blogus_customize_partial_header_social_icons',
        ));
        
        $wp_customize->selective_refresh->add_partial('footer_social_icon_enable', array(
            'selector'        => 'footer .footer-social',
            'render_callback' => 'blogus_customize_partial_footer_social_icon_enable',
        ));

        $wp_customize->selective_refresh->add_partial('blogus_footer_social_icons', array(
            'selector'        => 'footer .footer-social',
            'render_callback' => 'blogus_customize_partial_footer_social_icon_enable',
        ));

        $wp_customize->selective_refresh->add_partial('blogus_scrollup_enable', array(
            'selector'        => '.bs_upscr',
        ));

        $wp_customize->selective_refresh->add_partial('you_missed_title', array(
            'selector'        => '.missed .bs-widget-title .title',
            'render_callback' => 'blogus_customize_you_missed_title',
        ));

        $wp_customize->selective_refresh->add_partial('blogus_related_post_title', array(
            'selector'        => '.bs-card-box .relat-cls .title',
            'render_callback' => 'blogus_customize_blogus_related_post_title',
        ));
        
        $wp_customize->selective_refresh->add_partial('blogus_lite_dark_switcher', array(
            'selector'        => '.info-right.right-nav',
            'render_callback' => 'blogus_customize_partial_right_nav',
        ));
        $wp_customize->selective_refresh->add_partial('blogus_subsc_link', array(
            'selector'        => '.info-right.right-nav',
            'render_callback' => 'blogus_customize_partial_right_nav',
        ));
        $wp_customize->selective_refresh->add_partial('blogus_subsc_open_in_new', array(
            'selector'        => '.info-right.right-nav',
            'render_callback' => 'blogus_customize_partial_right_nav',
        ));        
        $wp_customize->selective_refresh->add_partial('blogus_footer_copyright', array(
            'selector'        => '.bs-footer-copyright p.mb-0 .copyright-text', 
            'render_callback' => 'blogus_customize_partial_copyright',
        ));
        $wp_customize->selective_refresh->add_partial('hide_copyright', array(
            'selector'        => '.bs-footer-copyright', 
            'render_callback' => 'blogus_customize_partial_hide_copyright',
        ));

        $wp_customize->selective_refresh->add_partial('header_social_icon_enable', array(
            'selector'        => '.bs-header-main .left-nav',
            'render_callback' => 'blogus_customize_partial_header_social_icons',
        ));

        $wp_customize->selective_refresh->add_partial('blogus_drop_caps_enable', array(
            'selector'        => '.content-right .bs-blog-post .bs-blog-meta, .content-full .bs-blog-post .bs-blog-meta', 
        ));

        $wp_customize->selective_refresh->add_partial('breadcrumb_settings', array(
            'selector'        => '.bs-breadcrumb-section ol.breadcrumb', 
        ));
        
        $wp_customize->selective_refresh->add_partial('blogus_content_layout', array(
            'selector'        => '.index-class .container > .row, .archive-class > .container > .row', 
			'render_callback' => 'blogus_customize_partial_content_layout',
        ));
		$wp_customize->selective_refresh->add_partial('blogus_page_layout', array(
			'selector'        => '.page-class > .container > .row',
			'render_callback' => 'blogus_customize_partial_page_layout',
		));
		$wp_customize->selective_refresh->add_partial('blogus_single_page_layout', array(
			'selector'        => '.single-class > .container > .row',
			'render_callback' => 'blogus_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('blogus_single_post_category', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_single_post_admin_details', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_single_post_date', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_single_post_tag', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('single_show_featured_image', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('single_show_share_icon', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_enable_single_admin_details', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_enable_related_post', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_enable_single_post_category', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_enable_single_post_date', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_enable_single_post_admin_details', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('blogus_enable_single_post_comments', array(
			'selector'        => '.single-class .row .col-lg-9, .single-class .row .col-lg-12',
			'render_callback' => 'blogus_customize_partial_single_page',
		));
		$wp_customize->selective_refresh->add_partial('featured_post_one_btn_txt', array(
			'selector'        => '.one .bs-widget.promo h5 a',
			'render_callback' => 'blogus_customize_partial_featured_post_one',
		));
		$wp_customize->selective_refresh->add_partial('featured_post_two_btn_txt', array(
			'selector'        => '.two .bs-widget.promo h5 a',
			'render_callback' => 'blogus_customize_partial_featured_post_two',
		));
		$wp_customize->selective_refresh->add_partial('featured_post_three_btn_txt', array(
			'selector'        => '.three .bs-widget.promo h5 a',
			'render_callback' => 'blogus_customize_partial_featured_post_three',
		));
		$wp_customize->selective_refresh->add_partial('you_missed_enable', array(
			'selector'        => 'div.missed',
			'render_callback' => 'blogus_customize_partial_you_missed_enable',
		));
	}

}
add_action( 'customize_register', 'blogus_selective_refresh' );

/**
 * Render the selective refresh partial.
 *
 * @return void
 */
function custom_logo_selective_refresh() {
    if( get_theme_mod( 'custom_logo' ) === "" ) return;
    echo '<div class="site-logo">'.the_custom_logo().'</div>';
}

function blogus_customize_partial_blogname() {
	bloginfo('name');
}

function blogus_customize_partial_blogdescription() {
	bloginfo('description');
}

function blogus_customize_partial_header_data_enable() {
    return get_theme_mod( 'header_data_enable' );
}

function blogus_customize_partial_footer_social_icon_enable() {
    return do_action('blogus_action_footer_social_section');
}

function blogus_customize_partial_sidebar_menu() {
    return get_theme_mod( 'sidebar_menu' ); 
}

function blogus_customize_you_missed_title() {
    return get_theme_mod( 'you_missed_title' ); 
}

function blogus_customize_partial_copyright() {
    return get_theme_mod( 'blogus_footer_copyright' ); 
}

function blogus_customize_partial_hide_copyright() {
	return do_action('blogus_footer_copyright_content');
}

function blogus_customize_blogus_related_post_title() {
    return get_theme_mod( 'blogus_related_post_title' ); 
}

function blogus_customize_partial_content_layout() {
	return do_action('blogus_action_main_content_layouts');
}

function blogus_customize_partial_right_nav() {
	blogus_menu_search();
    blogus_menu_subscriber();
    blogus_lite_dark_switcher();
}

function blogus_customize_partial_header_social_icons() {
	return do_action('blogus_action_header_social_section');
}

function blogus_customize_partial_single_page() {
	return do_action('blogus_action_main_single_content');

}
function blogus_customize_partial_you_missed_enable() {
	return do_action('blogus_action_footer_missed_section');
}

function blogus_customize_partial_featured_post_one() {
	return get_theme_mod('featured_post_one_btn_txt');
}

function blogus_customize_partial_featured_post_two() {
	return get_theme_mod('featured_post_two_btn_txt');
}

function blogus_customize_partial_featured_post_three() {
	return get_theme_mod('featured_post_three_btn_txt');
}

function blogus_customize_partial_page_layout() {
	return get_template_part('template-parts/content', 'page');
}

function blogus_customize_partial_single_layout() {
	return get_template_part('template-parts/content', 'single');
}