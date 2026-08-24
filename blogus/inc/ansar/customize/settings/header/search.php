<?php
$blogus_default = blogus_get_default_theme_options();
$wp_customize->add_setting('blogus_search_icon_setting',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Blogus_Section_Title(
        $wp_customize,
        'blogus_search_icon_setting',
        array(
            'label' => __('Search', 'blogus'),
            'section' => 'header_search_section',

        )
    )
);
$wp_customize->add_setting( 'blogus_menu_search', array(
    'default'           => $blogus_default['blogus_menu_search'],
    'sanitize_callback' => 'blogus_sanitize_multi_choose',
    'transport'         => 'postMessage',
) );

$wp_customize->add_control( new Blogus_Button_Group_Control( $wp_customize, 'blogus_menu_search', array(
    'label'       => __( '', 'blogus' ),
    'section'     => 'header_search_section',
    'choices'     => array(
        'desktop' => array(
            'title' => __( 'On Desktop', 'blogus' ),
            'icon'  => 'dashicons dashicons-desktop',
        ),
        'tablet' => array(
            'title' => __( 'On Tablet', 'blogus' ),
            'icon'  => 'dashicons dashicons-tablet',
        ),
        'mobile' => array(
            'title' => __( 'On Mobile', 'blogus' ),
            'icon'  => 'dashicons dashicons-smartphone',
        ),
    ),
) ) );