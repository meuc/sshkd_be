<?php
/*
Register Fonts
*/
function yogax_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Roboto, translate this to 'off'. Do not translate
    * into your own language.
    */
    $google_font1 = esc_html_x( 'on', 'Source Sans Pro font: on or off', 'yogax' );
    $google_font2 = esc_html_x( 'on', 'Quicksand font: on or off', 'yogax' );
    $google_font3 = esc_html_x( 'on', 'Merriweather font: on or off', 'yogax' );

    if ( 'off' !== $google_font1 || 'off' !== $google_font2 ) {
        $font_families = array();

        if ( 'off' !== $google_font1 ) {
            $font_families[] = 'Source+Sans+Pro:400,400i,600,700';
        }
        if ( 'off' !== $google_font2 ) {
            $font_families[] = 'Quicksand:400,700';
        }
        if ( 'off' !== $google_font3 ) {
            $font_families[] = 'Merriweather:400,400i';
        }

        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}

/**
 * yogax enqueue scripts
 *
 */
function yogax_scripts() {
    wp_enqueue_style( 'yogax-fonts', yogax_fonts_url(), array(), null );
    
    /* Visual Composer CSS - Load now to avoid delay during page load and to avoid !important in yogax css */
    wp_enqueue_style('js_composer_front');
    
    wp_register_style( 'woocommerce', get_template_directory_uri() . '/css/woocommerce.css' );
	
	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'woocommerce' );
	}
    
    wp_enqueue_style( 'yogax-theme', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), '1.0.1' );
    
    wp_enqueue_style( 'yogax-font', get_template_directory_uri() . '/css/ttbase-font.min.css', array(), '1.0.0' );

    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '20160901', true );
	wp_enqueue_script( 'bootstrap-filestyle', get_template_directory_uri() . '/js/bootstrap-filestyle.min.js', array('jquery', 'bootstrap'), '20160901', true );
    
    wp_enqueue_script("jquery-ui-core", array("jquery"));
    wp_enqueue_script("jquery-ui-accordion", array("jquery"));
	wp_enqueue_script("jquery-ui-tabs", array("jquery"));
    
    wp_enqueue_script( 'yogax-scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), '20170414', true );
    wp_enqueue_script( 'yogax-js', get_template_directory_uri() . '/js/yogax-main.js', array('jquery', "jquery-ui-core", 'jquery-ui-accordion', 'jquery-ui-tabs', 'yogax-scripts', 'bootstrap-filestyle'), '20170414', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'yogax_scripts' );