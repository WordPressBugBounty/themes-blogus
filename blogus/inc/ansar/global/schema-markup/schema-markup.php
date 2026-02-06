<?php

function blogus_add_post_schema() {
    // IF schema is disabled in Customizer → stop
    if ( ! blogus_get_option( 'blogus_enable_schema' ) ) {
        return;
    }

    // Only on single posts
    if ( ! is_single() || ! is_singular( 'post' ) ) {
        return;
    }

    global $post;

    $post_id        = $post->ID;
    $title          = get_the_title( $post_id );
    $url            = get_permalink( $post_id );
    $image          = get_the_post_thumbnail_url( $post_id, 'full' );
    $excerpt        = wp_strip_all_tags( get_the_excerpt( $post_id ) );
    $date_published = get_the_date( 'c', $post_id );
    $date_modified  = get_the_modified_date( 'c', $post_id );
    $author_name    = get_the_author_meta( 'display_name', $post->post_author );
    $site_name      = get_bloginfo( 'name' );
    $site_url       = home_url( '/' );

    $schema_type = has_category( 'news', $post ) ? 'NewsArticle' : 'BlogPosting';

    $schema = [
        "@context"         => "https://schema.org",
        "@type"            => $schema_type,
        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id"   => $url,
        ],
        "headline"      => $title,
        "description"   => $excerpt,
        "image"         => $image ? $image : $site_url . "path-to-default-image.jpg",
        "author"        => [
            "@type" => "Person",
            "name"  => $author_name,
        ],
        "publisher"     => [
            "@type" => "Organization",
            "name"  => $site_name,
            "logo"  => [
                "@type" => "ImageObject",
                "url"   => $site_url . "path-to-logo.png",
            ],
        ],
        "datePublished" => $date_published,
        "dateModified"  => $date_modified,
    ];

    echo '<script type="application/ld+json">' .
         wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) .
         '</script>';
}
add_action( 'wp_head', 'blogus_add_post_schema' );