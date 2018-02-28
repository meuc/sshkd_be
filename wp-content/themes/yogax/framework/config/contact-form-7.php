<?php
//add html5 support
add_filter( 'wpcf7_support_html5', '__return_true' );

//add Html5 fallback for datepicker and number selector for contact form
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

//add correct button style from customizer to contact form 7
add_filter('wpcf7_form_elements','yogax_wpcf7_form_elements');
function yogax_wpcf7_form_elements( $content ) {
	
	$rl_pfind = '/wpcf7-submit/';
	if ('style-1' == get_theme_mod('yogax_button_style', 'style-3')) {
		$rl_preplace = 'btn btn-primary';
	}
	elseif ('style-3' == get_theme_mod('yogax_button_style', 'style-3')) {
		$rl_preplace = 'btn btn-primary style-3';
	}
	else {
		$rl_preplace = 'btn btn-primary style-2';
	}
	$content = preg_replace( $rl_pfind, $rl_preplace, $content);

	return $content;	
}