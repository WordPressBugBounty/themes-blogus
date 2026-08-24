<?php

$blogus_default = blogus_get_default_theme_options();
$wp_customize->add_setting('blogus_subscribe_icon_setting',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Blogus_Section_Title(
        $wp_customize,
        'blogus_subscribe_icon_setting',
        array(
            'label' => __('Subscribe Button', 'blogus'),
            'section' => 'header_subscribe_section',

        )
    )
);
$wp_customize->add_setting( 'blogus_menu_subscriber', array(
    'default'           => $blogus_default['blogus_menu_subscriber'],
    'sanitize_callback' => 'blogus_sanitize_multi_choose',
    'transport'         => 'postMessage',
) );
$wp_customize->add_control( new Blogus_Button_Group_Control( $wp_customize, 'blogus_menu_subscriber', array(
    'label'       => __( '', 'blogus' ),
    'section'     => 'header_subscribe_section',
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
$wp_customize->add_setting('blogus_subsc_link',
    array(
        'default' => '#',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control('blogus_subsc_link',
    array(
        'label' => __('Button Link', 'blogus'),
        'section' => 'header_subscribe_section',
        'type' => 'url',
    )
);

$wp_customize->add_setting('blogus_subsc_open_in_new',
    array(
        'default' => true,
        'sanitize_callback' => 'blogus_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Blogus_Toggle_Control( $wp_customize, 'blogus_subsc_open_in_new', 
    array(
        'label' => __('Open link in new tab', 'blogus'),
        'type' => 'toggle',
        'section' => 'header_subscribe_section',
    )
));