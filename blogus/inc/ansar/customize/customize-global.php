<?php /*** Maintenance
 *
 * @package Blogus
 */

$blogus_default = blogus_get_default_theme_options();
// Add Globel Panel
$wp_customize->add_panel( 'global_panel', array(
    'title'    => __( 'Global Options', 'blogus' ),
    'priority' => 34,
));

/*=========================================
	Schema Markup
=========================================
-----------------------------------------*/
// Add Section
$wp_customize->add_section( 'blogus_schema_section', array(
    'title'    => __( 'Schema Markup', 'blogus' ),
    'panel'    => 'global_panel',
));

    $wp_customize->add_setting('blogus_enable_schema',
        array(
            'default' => $blogus_default['blogus_enable_schema'],
            'sanitize_callback' => 'blogus_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(new Blogus_Toggle_Control( $wp_customize, 'blogus_enable_schema', 
        array(
            'label' => esc_html__('Enable', 'blogus'),
            'type' => 'toggle',
            'section' => 'blogus_schema_section',
        )
    ));
/*=========================================
	Cursor Dot
=========================================
-----------------------------------------*/
// Add Section
$wp_customize->add_section( 'blogus_cursor_section', array(
    'title'    => __( 'Cursor Dot', 'blogus' ),
    'panel'    => 'global_panel',
));

    $wp_customize->add_setting('blogus_enable_cursor_dot',
        array(
            'default' => $blogus_default['blogus_enable_cursor_dot'],
            'sanitize_callback' => 'blogus_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(new Blogus_Toggle_Control( $wp_customize, 'blogus_enable_cursor_dot', 
        array(
            'label' => esc_html__('Enable', 'blogus'),
            'type' => 'toggle',
            'section' => 'blogus_cursor_section',
        )
    ));

/*=========================================
	Preloader
=========================================
-----------------------------------------*/
// Add Section
$wp_customize->add_section( 'blogus_preloader_section', array(
    'title'    => __( 'Preloader', 'blogus' ),
    'panel'    => 'global_panel',
));
// Enable Preloader
$wp_customize->add_setting('blogus_enable_preloader', array(
    'default' => $blogus_default['blogus_enable_preloader'],
    'sanitize_callback' => 'blogus_sanitize_checkbox',
));
$wp_customize->add_control(new Blogus_Toggle_Control( $wp_customize, 'blogus_enable_preloader', 
    array(
        'label' => esc_html__('Enable', 'blogus'),
        'type' => 'toggle',
        'section' => 'blogus_preloader_section',
        
    )
));

$wp_customize->add_setting('preloader_ad_image',
    array(
        'default' => $blogus_default['preloader_ad_image'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control($wp_customize, 'preloader_ad_image',
        array(
            'label' => esc_html__('Image', 'blogus'),
            'section' => 'blogus_preloader_section',
            'description' => sprintf(esc_html__('Recommended GIF & SVG', 'blogus'), 930, 100),
            'flex_width' => true,
            'flex_height' => true,
        )
    )
);