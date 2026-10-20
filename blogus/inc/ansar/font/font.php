<?php
/*--------------------------------------------------------------------*/
/*     Register Google Fonts
/*--------------------------------------------------------------------*/
function blogus_fonts_url() {
	
    $fonts_url = '';
		
    $font_families = array();
 
        $font_families = array(
            'Josefin Sans:300,400,500,600,700',
            'Open Sans:300,400,500,600,700',
            'Kalam:300,400,500,600,700',
            'Rokkitt:300,400,500,600,700',
            'Jost:300,400,500,600,700',
            'Poppins:300,400,500,600,700',
            'Lato:300,400,500,600,700',
            'Noto Serif:300,400,500,600,700',
            'Raleway:300,400,500,600,700',
            'Roboto:300,400,500,600,700',
            'Rubik:300,400,500,600,700',
        );

        // Build the URL
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'display' => 'swap',
            'subset' => 'latin,latin-ext',
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $fonts_url;
}
function blogus_scripts_styles() {
    wp_enqueue_style( 'blogus-fonts', blogus_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'blogus_scripts_styles' );