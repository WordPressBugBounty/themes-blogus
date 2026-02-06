<?php

function blogus_preloader_scripts() {
    
    if ( ! blogus_get_option( 'blogus_enable_preloader')) {
        return;
    }

    // Path to the current folder directory
    $dir = get_template_directory_uri() . '/inc/ansar/global/preloader';

    // Enqueue CSS
    wp_enqueue_style( 'blogus-preloader-css', $dir . '/preloader.css', array(), '1.0' );

    // Enqueue JS (In Footer: true)
    wp_enqueue_script( 'blogus-preloader-js', $dir . '/preloader.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'blogus_preloader_scripts' );

function blogus_add_preloader_effect() {

    if ( ! blogus_get_option( 'blogus_enable_preloader')) {
        return;
    }
    
    $preloader_ad_image = blogus_get_option('preloader_ad_image'); ?> 
    <!--preloader-->
        <div class="preloader" id="preloader">
            <?php if (!empty($preloader_ad_image)){ ?>
                <img src="<?php echo esc_url($preloader_ad_image); ?>" alt="preloader"> 
            <?php } else { echo esc_html('Please Add Preloader','blogus'); } ?>
        </div>
    <!--/preloader-->
    <?php
}
add_action('wp_body_open', 'blogus_add_preloader_effect');