<?php
$wp_customize->add_panel('header_option_panel',
    array(
        'title' => esc_html__('Header Options', 'blogus'),
        'priority' => 30,
    )
);
    $wp_customize->add_section( 'social_options' , array(
        'title' => __('Social icons', 'blogus'),
        'panel' => 'header_option_panel',
    ) );
    $wp_customize->add_section( 'header_search_section' , array(
        'title' => __('Search', 'blogus'),
        'panel' => 'header_option_panel',
    ) );
    $wp_customize->add_section( 'header_subscribe_section' , array(
        'title' => __('Subscribe Button', 'blogus'),
        'panel' => 'header_option_panel',
    ) );
    $wp_customize->add_section( 'header_dark_mode_section' , array(
        'title' => __('Dark and Light Mode Switcher', 'blogus'),
        'panel' => 'header_option_panel',
    ) );
