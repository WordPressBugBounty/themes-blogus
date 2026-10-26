
<?php
/*--------------------------------------------------------------------*/
/*     Register Google Fonts
/*--------------------------------------------------------------------*/
function blogus_fonts_url() {

    $fonts = array(
        'Josefin Sans' => array( 300, 400, 500, 600, 700 ),
        'Rubik'        => array( 300, 400, 500, 600 ),
    );

    $requested = array(
        array( get_theme_mod( 'site_title_fontfamily', '' ), get_theme_mod( 'site_title_fontweight', '400' ) ),
        array( get_theme_mod( 'blogus_menu_fontfamily', '' ), '400' ),
    );

    foreach ( $requested as $item ) {
        list( $font, $weight ) = $item;

        $font   = trim( explode( ',', (string) $font )[0], " \t\n\r\0\x0B'\"" );
        $weight = absint( $weight );

        if ( $font && $weight >= 100 && $weight <= 900 ) {
            $fonts[ $font ][] = $weight;
        }
    }

    $fonts = apply_filters( 'blogus_google_fonts', $fonts );

    ksort( $fonts );

    $families = array();

    foreach ( $fonts as $font => $weights ) {
        $weights = array_filter( array_unique( array_map( 'absint', (array) $weights ) ) );
        sort( $weights, SORT_NUMERIC );

        if ( ! $font || empty( $weights ) ) {
            continue;
        }

        $families[] = 'family=' . urlencode( $font ) . ':wght@' . implode( ';', $weights );
    }

    return 'https://fonts.googleapis.com/css2?' . implode( '&', $families ) . '&display=swap';
}

function blogus_scripts_styles() {
    wp_enqueue_style( 'blogus-fonts', blogus_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'blogus_scripts_styles' );