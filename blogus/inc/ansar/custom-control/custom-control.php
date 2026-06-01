<?php
if( ! function_exists( 'blogus_register_custom_controls' ) ) :
/**
 * Register Custom Controls
*/
function blogus_register_custom_controls( $wp_customize ) {

    require_once get_template_directory() . '/inc/ansar/custom-control/toggle/class-toggle-control.php';
    require_once get_template_directory() . '/inc/ansar/custom-control/customizer-alpha-color-picker/class-blogus-customize-alpha-color-control.php';

    require_once  get_template_directory() . '/inc/ansar/custom-control/custom_tab_control/custom_tab_control_class.php';
    require_once  get_template_directory() . '/inc/ansar/custom-control/dimension-control/dimension_control_class.php';

    $wp_customize->register_control_type( 'blogus_Toggle_Control' );

    $wp_customize->register_control_type( 'Dimension_Custom_Control' );

}
endif;
add_action( 'customize_register', 'blogus_register_custom_controls' );