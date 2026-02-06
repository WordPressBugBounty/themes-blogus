<?php

function blogus_cursor_scripts() {
    
    if ( ! blogus_get_option( 'blogus_enable_cursor_dot') || wp_is_mobile() ) {
        return;
    }

    // Path to the current folder directory
    $dir = get_template_directory_uri() . '/inc/ansar/global/cursor-dot';

    // Enqueue CSS
    wp_enqueue_style( 'blogus-cursor-css', $dir . '/cursor-dot.css', array(), '1.0' );

    // Enqueue JS (In Footer: true)
    wp_enqueue_script( 'blogus-cursor-js', $dir . '/cursor-dot.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'blogus_cursor_scripts' );

function blogus_add_cursor_dot_effect() {

    if ( ! blogus_get_option( 'blogus_enable_cursor_dot') || wp_is_mobile() ) {
        return;
    }
    
    echo '<div id="blogus-cursor-dot" class="blogus-cursor-dot">
          <div id="blogus-cursor-outline" class="blogus-cursor-dot-outline"></div></div>';

}
add_action('wp_footer', 'blogus_add_cursor_dot_effect');