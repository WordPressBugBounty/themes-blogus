<?php
$blogus_default = blogus_get_default_theme_options();
$wp_customize->add_setting('blogus_dark_mode_setting',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Blogus_Section_Title(
        $wp_customize,
        'blogus_dark_mode_setting',
        array(
            'label' => __('Dark and Light Mode Switcher', 'blogus'),
            'section' => 'header_dark_mode_section',

        )
    )
);
$wp_customize->add_setting( 'blogus_lite_dark_switcher', array(
    'default'           => $blogus_default['blogus_lite_dark_switcher'],
    'sanitize_callback' => 'blogus_sanitize_multi_choose',
    'transport'         => 'postMessage',
) );
$wp_customize->add_control( new Blogus_Button_Group_Control( $wp_customize, 'blogus_lite_dark_switcher', array(
    'label'       => __( '', 'blogus' ),
    'section'     => 'header_dark_mode_section',
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