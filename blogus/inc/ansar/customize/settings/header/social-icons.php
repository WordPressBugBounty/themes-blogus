<?php
$wp_customize->add_setting('social_settings',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Blogus_Section_Title(
        $wp_customize,
        'social_settings',
        array(
            'label' => __('Social icons','blogus'),
            'section' => 'social_options',

        )
    )
);
$wp_customize->add_setting('header_social_icon_enable',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'blogus_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Blogus_Toggle_Control( $wp_customize, 'header_social_icon_enable', 
    array(
        'label' => __('Hide / Show Social icons', 'blogus'),
        'type' => 'toggle',
        'section' => 'social_options',
    )
));

$wp_customize->add_setting(
    'blogus_header_social_icons',
    array(
        'default'           => blogus_get_social_icon_default(),
        'sanitize_callback' => 'blogus_repeater_sanitize',
        'transport'         => 'postMessage',
    )
);
$wp_customize->add_control(
    new Blogus_Repeater_Control(
        $wp_customize,
        'blogus_header_social_icons',
        array(
            'label'                            => __( 'Social icons', 'blogus' ),
            'section'                          => 'social_options',
            'add_field_label'                  => __( 'Add New', 'blogus' ),
            'item_name'                        => __( 'Social', 'blogus' ),
            'customizer_repeater_icon_control' => true,
            'customizer_repeater_link_control' => true,
            'customizer_repeater_checkbox_control' => true,
        )
    )
);

$wp_customize->add_setting( 'blogus_social_upgrade_to_pro', array(
    'capability'            => 'edit_theme_options',
    'sanitize_callback' => 'wp_filter_nohtml_kses',
));
$wp_customize->add_control(
    new Blogus_social_section_upgrade(
    $wp_customize,
    'blogus_social_upgrade_to_pro',
        array(
            'section'               => 'social_options',
            'settings'              => 'blogus_social_upgrade_to_pro',
        )
    )
);