<?php 
//Deregister Gravity Stylesheets and Scripts from specific pages
add_action("gform_enqueue_scripts", "yogax_deregister_scripts");

function yogax_deregister_scripts(){
    wp_deregister_style("gforms_browsers_css");
}

// filter the Gravity Forms button type
add_filter( 'gform_submit_button', 'yogax_form_submit_button', 10, 2 );
function yogax_form_submit_button( $button, $form ) {
    if ('style-1' == get_theme_mod('yogax_button_style', 'style-3')) {
		return "<button class='btn btn-primary' id='gform_submit_button_{$form['id']}'><span>{$form['button']['text']}</span></button>";
	}
	else {
		return "<button class='btn btn-primary style-3' id='gform_submit_button_{$form['id']}'><span>{$form['button']['text']}</span></button>";
	}
}

add_filter( 'gform_next_button', 'yogax_form_next_button', 10, 2 );
function yogax_form_next_button( $button, $form ) {
    $next_button = '';
    if ('style-1' == get_theme_mod('yogax_button_style', 'style-3')) {
		$next_button = str_replace('gform_next_button button','btn-next btn btn-primary',$button);
		return $next_button;
	}
	else {
		$next_button = str_replace('gform_next_button button','btn-next btn btn-primary style-3',$button);
		return $next_button;
	}
}
add_filter( 'gform_previous_button', 'yogax_form_previous_button', 10, 2 );
function yogax_form_previous_button( $button, $form ) {
    $previous_button = '';
    if ('style-1' == get_theme_mod('yogax_button_style', 'style-3')) {
		$previous_button = str_replace('gform_previous_button button','btn-previous btn btn-primary style-3',$button);
		return $previous_button;
	}
	else {
		$previous_button = str_replace('gform_previous_button button','btn-previous btn btn-primary',$button);
		return $previous_button;
	}
}

?>