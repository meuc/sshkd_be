<?php

// enqueue the parent theme stylesheet
function yogax_child_enqueue_styles() {
	wp_enqueue_style( 'yogax-theme', get_template_directory_uri() . '/css/theme.min.css', array() );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('yogax-theme')  );
}
add_action( 'wp_enqueue_scripts', 'yogax_child_enqueue_styles');