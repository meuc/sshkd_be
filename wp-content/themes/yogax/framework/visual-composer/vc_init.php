<?php

function yogax_vc_set_as_theme() {
	vc_set_as_theme();
}
add_action( 'vc_before_init', 'yogax_vc_set_as_theme' );

add_action('admin_init', function()
{
    if(is_admin()) {
        setcookie('vchideactivationmsg', '1', strtotime('+3 years'), '/');
        setcookie('vchideactivationmsg_vc11', (defined('WPB_VC_VERSION') ? WPB_VC_VERSION : '1'), strtotime('+3 years'), '/');
    }
});

// REMOVE UPDATE NOTICE FOR VISUAL COMPOSER
function yogax_filter_plugin_updates( $value ) {
    if ( isset( $value ) && is_object( $value ) ) {
        unset($value->response[ 'js_composer_theme/js_composer.php' ]);
    }
}
add_filter( 'site_transient_update_plugins', 'yogax_filter_plugin_updates' );

/**
 * Removes "About" page in the Visual Composer
 */
function yogax_remove_welcome() {
    remove_submenu_page( 'vc-general', 'vc-welcome' );
}

//Use Visual Composer for pages and service post type
if (function_exists("vc_set_default_editor_post_types")) {
	vc_set_default_editor_post_types(array(
			"page",
			"classes",
			"trainers"
		));
}

/**
 * Redirect page template if vc_row shortcode is found in the page.
 */
if(!( function_exists('yogax_vc_page_template') )){
	function yogax_vc_page_template( $template ){
		global $post;
		
		if( is_archive() || is_404() || is_single() || is_page_template( 'templates/template-sidebar-left.php' ) || is_page_template( 'templates/template-sidebar-right.php' ) )
			return $template;
		
		if(!( isset($post->post_content) ) || is_search())
			return $template;
			
		if( has_shortcode($post->post_content, 'vc_row') ){
			$new_template = get_template_directory() . '/page-visual-composer.php';
			if (!( '' == $new_template )){
				return $new_template;
			}
		}
		return $template;
	}
	add_filter( 'template_include', 'yogax_vc_page_template', 99 );
}

if ( ! function_exists( 'yogax_bg_image_overlay' ) ) {

	function yogax_bg_image_overlay( $atts ) {

		// Extract attributes
		extract( $atts );

		// Return if a video is defined
		if ( $bg_type != 'image' || empty( $bg_image ) || $image_bg_overlay == 'none' ) {
			return;
		}

		// Image overlay
		if ( 'color' != $image_bg_overlay ) { ?>
			<span class="ttbase-bg-overlay <?php echo sanitize_html_class($image_bg_overlay); ?>"></span>
		<?php } else { ?>
			<span class="ttbase-bg-overlay" style="background-color:<?php echo esc_attr($image_bg_overlay_color); ?>"></span>
		<?php } ?>

	<?php
	}

}

//Video Output for vc_row
if ( ! function_exists( 'yogax_row_video' ) ) {
	function yogax_row_video( $atts ) {

		// Extract attributes
		extract( $atts );

		// Return if video_bg is empty
		if ( $bg_type != 'video' || 'self-hosted' != $video_bg ) {
			return;
		}

		// Make sure videos are defined
		if ( ! $video_bg_webm && ! $video_bg_ogv && ! $video_bg_mp4 ) {
			return;
		}

		// Get background image
		$bg_image = ! empty( $bg_image ) ? $bg_image : '';

		// Check sound
		$sound = apply_filters( 'yogax_self_hosted_row_video_sound', false );
		$sound = $sound ? '' : 'muted volume="0"'; ?>

		<div class="ttbase-video-bg-wrap">
			<video class="ttbase-video-bg" poster="<?php echo esc_url($bg_image); ?>" preload="auto" autoplay="true" loop="loop" <?php echo esc_attr($sound); ?>>
				<?php if ( $video_bg_webm ) { ?>
					<source src="<?php echo esc_url($video_bg_webm); ?>" type="video/webm" />
				<?php } ?>
				<?php if ( $video_bg_ogv ) { ?>
					<source src="<?php echo esc_url($video_bg_ogv); ?>" type="video/ogg ogv" />
				<?php } ?>
				<?php if ( $video_bg_mp4 ) { ?>
					<source src="<?php echo esc_url($video_bg_mp4); ?>" type="video/mp4" />
				<?php } ?>
			</video>
		</div>

		<?php
		// Video overlay
		if ( ! empty( $video_bg_overlay ) && 'none' != $video_bg_overlay ) { ?>
			
			<?php if ( 'color' != $video_bg_overlay ) { ?>
				<span class="ttbase-bg-overlay ttbase-bg-video-overlay <?php echo sanitize_html_class($video_bg_overlay); ?>"></span>
			<?php } else { ?>
				<span class="ttbase-bg-overlay ttbase-bg-video-overlay" style="background-color:<?php echo esc_attr($video_bg_overlay_color); ?>"></span>
			<?php } ?>
		<?php } ?>

	<?php
	}
}

// Remove VC Teaser Metabox
if ( ! function_exists('yogax_vc_remove_teaserbox') ) {
	function yogax_vc_remove_teaserbox(){
		$post_types = get_post_types( '', 'names' ); 
		foreach ( $post_types as $post_type ) {
			remove_meta_box('vc_teaser',  $post_type, 'side');
		}
	}
}
add_action('do_meta_boxes', 'yogax_vc_remove_teaserbox');

if ( ! function_exists('yogax_update_params') ) {
	function yogax_update_params(){
		
		// Only needed on front-end
		if ( ! is_admin() ) return;
		
		// Set ID weight
		$param = WPBMap::getParam( 'vc_row', 'el_id' );
		if ( $param ) {
			$param['weight'] = 99;
			$param['description'] = esc_html__('Enter row id, so you can use it as an anchor link for one page layouts with a smooth scrolling effect. (Note: make sure it is unique and valid according to w3c specification).', 'yogax' );
			vc_update_shortcode_param( 'vc_row', $param );
		}
		
		// Set ID weight
		$param = WPBMap::getParam( 'vc_row', 'full-width' );
		if ( $param ) {
			$param['weight'] = 95;
			vc_update_shortcode_param( 'vc_row', $param );
		}
			
		// Move parallax
		$param = WPBMap::getParam( 'vc_row', 'parallax' );
		if ( $param ) {
			$param['group'] = esc_html__( 'Background', 'yogax' );
			$param['dependency'] = array(
				'element' => 'bg_image',
				'not_empty' => true,
			);
			vc_update_shortcode_param( 'vc_row', $param );
		}
		
		// Move video parallax setting
		$param = WPBMap::getParam( 'vc_row', 'video_bg_parallax' );
		if ( $param ) {
			$param['group'] = esc_html__( 'Background', 'yogax' );
			$param['dependency'] = array(
				'element' => 'video_bg',
				'value' => 'youtube',
			);
			vc_update_shortcode_param( 'vc_row', $param );
		}

		// Move youtube url
		$param = WPBMap::getParam( 'vc_row', 'video_bg_url' );
		if ( $param ) {
			$param['group'] = esc_html__( 'Background', 'yogax' );
			$param['dependency'] = array(
				'element' => 'video_bg',
				'value' => 'youtube',
			);
			vc_update_shortcode_param( 'vc_row', $param );
		}
	}
}

add_action( 'vc_after_init', 'yogax_update_params' );

/* ------------------------------------------------------------------------ */
/* Edit VC Row
/* ------------------------------------------------------------------------ */
vc_remove_param("vc_row", "parallax_image");
vc_remove_param("vc_row", "bg_color");
vc_remove_param("vc_row", "bg_image");
vc_remove_param("vc_row", "css");


vc_add_param("vc_row", array(
	'type' => 'textfield',
	'heading' => esc_html__( 'Minimum Height', 'yogax' ),
	'description' => esc_html__( 'Add a minimum height for this row. So you can show a video or image background at a certain height without any content.', 'yogax' ),
	'param_name' => 'min_height',
	'weight' => 90
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => esc_html__( 'Padding Top', 'yogax' ),
	"value" => "",
	"param_name" => "top_padding",
	"description" => esc_html__( 'Add your top padding without px. For example: 40', 'yogax' ),
	'weight' => 85
));

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => esc_html__( 'Padding Bottom', 'yogax' ),
	"value" => "",
	"param_name" => "bottom_padding",
	"description" => esc_html__( 'Add your bottom padding without px. For example: 40', 'yogax' ),
	'weight' => 80
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => esc_html__('Top Border', 'yogax'),
	"value" => array(
		esc_html__('Enable Top Border for this row', 'yogax') => "false" 
	),
	"param_name" => "top_border",
	"description" => "",
	"group"	=> esc_html__( 'Background', 'yogax' ),
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => esc_html__( 'Top Border Width', 'yogax' ),
	"value" => "",
	"param_name" => "top_border_width",
	"dependency" => array('element' => "top_border", 'not_empty' => true ),
	"description" => esc_html__( 'Add your top border width. For example: 2 or 2px', 'yogax' ),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Top Border Color', 'yogax' ),
	"param_name" => "top_border_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "top_border", 'not_empty' => true ),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => esc_html__('Bottom Border', 'yogax'),
	"value" => array(
		esc_html__('Enable Bottom Border for this row', 'yogax') => "false" 
	),
	"param_name" => "bottom_border",
	"description" => "",
	"group"	=> esc_html__( 'Background', 'yogax' ),
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => esc_html__( 'Bottom Border Width', 'yogax' ),
	"value" => "",
	"param_name" => "bottom_border_width",
	"dependency" => array('element' => "bottom_border", 'not_empty' => true ),
	"description" => esc_html__( 'Add your bottom border width. For example: 2 or 2px', 'yogax' ),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Bottom Border Color', 'yogax' ),
	"param_name" => "border_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "bottom_border", 'not_empty' => true ),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));


vc_add_param("vc_row", array(
	"type" 						=> "dropdown",
	"show_settings_on_create" 	=> true,
	"heading" 					=> esc_html__( 'Background Type', 'yogax' ),
	"param_name" 				=> "bg_type",
	"value" 					=> array(
		esc_html__( 'None', 'yogax' ) 		=> "",
		esc_html__( 'Color', 'yogax' ) 	=> "color",
		esc_html__( 'Image', 'yogax' ) 	=> "image",
		esc_html__( 'Video', 'yogax' ) 	=> "video",
	),
	"group"	=> esc_html__( 'Background', 'yogax' ),
	'weight' => 10
)); 

//Color
vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Background Color', 'yogax' ),
	"param_name" => "bg_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "bg_type", 'value' => array('color')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
	'weight' => 9
));

//Image
vc_add_param("vc_row", array(
	"type" => "attach_image",
	"class" => "",
	"heading" => esc_html__( 'Background Image', 'yogax' ),
	"param_name" => "bg_image",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "bg_type", 'value' => array('image')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
	'weight' => 9
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => esc_html__( 'Background Repeat', 'yogax' ),
	"param_name" => "bg_repeat",
	"value" => array(
		esc_html__( 'No Repeat', 'yogax' ) 		=> "no-repeat",
		esc_html__( 'Repeat', 'yogax' ) 	=> "repeat",
		esc_html__( 'Stretch', 'yogax' ) 	=> "stretch"
	),
	"dependency" => Array('element' => "bg_image", 'not_empty' => true),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));

vc_add_param("vc_row", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Image Overlay', 'yogax' ),
	'param_name' => 'image_bg_overlay',
	'value' => array(
		esc_html__( 'None', 'yogax' ) => 'none',
		esc_html__( 'Dark', 'yogax' ) => 'dark',
		esc_html__( 'Dotted', 'yogax' ) => 'dotted',
		esc_html__( 'Diagonal Lines', 'yogax' ) => 'dashed',
		esc_html__( 'Custom Color', 'yogax' ) => 'color',
	),
	"dependency" => array('element' => "bg_image", 'not_empty' => true ),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Overlay Color', 'yogax' ),
	"param_name" => "image_bg_overlay_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "image_bg_overlay", 'value' => array('color')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));

//Video
vc_add_param("vc_row", array(
	"type" 						=> "dropdown",
	"show_settings_on_create" 	=> true,
	"heading" 					=> esc_html__( 'Video Background?', 'yogax' ),
	"param_name" 				=> "video_bg",
	"value" 					=> array(
		esc_html__( 'None', 'yogax' ) 		=> "",
		esc_html__( 'Youtube Video', 'yogax' ) 		=> "youtube",
		esc_html__( 'Self Hosted Video', 'yogax' ) 	=> "self-hosted",
	),
	"dependency" 				=> array('element' => "bg_type", 'value' => array('video')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
	'weight' => 9
)); 

vc_add_param("vc_row", array(
	"type" 						=> "textfield",
	"heading" 					=> esc_html__( 'WebM File URL', 'yogax' ),
	"value" 					=> "",
	"param_name" 				=> "video_bg_webm",
	"description" 				=> esc_html__( 'You must include this format & the mp4 format to render your video with cross browser compatibility, OGV is optional.
Video must be in a 16:9 aspect ratio', 'yogax' ),
	"dependency" 				=> array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));

vc_add_param("vc_row", array(
	"type" 						=> "textfield",
	"heading" 					=> esc_html__( 'MP4 File URL', 'yogax' ),
	"value" 					=> "",
	"param_name" 				=> "video_bg_mp4",
	"description" 				=> esc_html__( 'Enter the URL for your mp4 video file here', 'yogax' ),
	"dependency" 				=> array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"					=> esc_html__( 'Background', 'yogax' ),
));

vc_add_param("vc_row", array(
	"type" 						=> "textfield",
	"heading" 					=> esc_html__( 'OGV File URL', 'yogax' ),
	"value" 					=> "",
	"param_name" 				=> "video_bg_ogv",
	"description" 				=> esc_html__( 'Enter the URL for your ogv video file here', 'yogax' ),
	"dependency" 				=> array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));

vc_add_param("vc_row", array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'Video Overlay', 'yogax' ),
	'param_name' => 'video_bg_overlay',
	'value' => array(
		esc_html__( 'None', 'yogax' ) => 'none',
		esc_html__( 'Dark', 'yogax' ) => 'dark',
		esc_html__( 'Dotted', 'yogax' ) => 'dotted',
		esc_html__( 'Diagonal Lines', 'yogax' ) => 'dashed',
		esc_html__( 'Custom Color', 'yogax' ) => 'color',
	),
	"dependency" => array('element' => "video_bg", 'value' => array('self-hosted')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));

vc_add_param("vc_row", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Overlay Color', 'yogax' ),
	"param_name" => "video_bg_overlay_color",
	"value" => "",
	"description" => "",
	"dependency" => array('element' => "video_bg_overlay", 'value' => array('color')),
	"group"	=> esc_html__( 'Background', 'yogax' ),
));
// vc_add_param("vc_row", array(
// 	'type' => 'dropdown',
// 	'heading' => esc_html__( 'CSS Animation', 'yogax' ),
// 	"description" => esc_html__( 'Add animation when row comes in visible area.', 'yogax' ),
// 	'param_name' => 'css_animation',
// 	'value' => array(
// 		esc_html__( 'No', 'yogax' )  			=> '',
// 		esc_html__( 'From Bottom', 'yogax' )    => 'has-animation from-bottom',
// 		esc_html__( 'From Top', 'yogax' )   	=> 'has-animation from-top',
// 		esc_html__( 'From Left', 'yogax' )    	=> 'has-animation from-left',
// 		esc_html__( 'From Right', 'yogax' )    	=> 'has-animation from-right',
// 		esc_html__( 'Fade In', 'yogax' )    	=> 'has-animation fade',
// 	),
// 	"group"	=> esc_html__( 'Animation', 'yogax' ),
// ));

/*-----------------------------------------------------------------------------------*/
/* Edit VC Pie
/*-----------------------------------------------------------------------------------*/
vc_remove_param("vc_pie", "color");

vc_add_param("vc_pie", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Color', 'yogax' ),
	"param_name" => "color",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_pie", array(
	"type" => "colorpicker",
	"class" => "",
	"heading" => esc_html__( 'Background Color', 'yogax' ),
	"param_name" => "background_color",
	"value" => "",
	"description" => "",
));

/*-----------------------------------------------------------------------------------*/
/* Edit VC Tabs
/*-----------------------------------------------------------------------------------*/
vc_remove_param("vc_tta_tabs", "title");
vc_remove_param("vc_tta_tabs", "style");
vc_remove_param("vc_tta_tabs", "shape");
vc_remove_param("vc_tta_tabs", "no_fill_content_area");
vc_remove_param("vc_tta_tabs", "color");
vc_remove_param("vc_tta_tabs", "pagination_color");
vc_remove_param("vc_tta_tabs", "spacing");
vc_remove_param("vc_tta_tabs", "gap");
//vc_remove_param("vc_tta_tabs", "tab_position");
vc_remove_param("vc_tta_tabs", "pagination_style");

/*-----------------------------------------------------------------------------------*/
/* Edit VC Accordion
/*-----------------------------------------------------------------------------------*/
vc_remove_param("vc_tta_accordion", "title");
//vc_remove_param("vc_tta_accordion", "style");
vc_remove_param("vc_tta_accordion", "shape");
vc_remove_param("vc_tta_accordion", "no_fill");
vc_remove_param("vc_tta_accordion", "color");
vc_remove_param("vc_tta_accordion", "spacing");
vc_remove_param("vc_tta_accordion", "gap");

/*-----------------------------------------------------------------------------------*/
/* Edit VC Contact Form 7
/*-----------------------------------------------------------------------------------*/
if(yogax_contact_form_7_installed()){
	vc_add_param("contact-form-7", array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__( 'Style', 'yogax' ),
		"param_name" => "html_class",
		"value" => array(
			esc_html__("Style 1",'yogax')		=> "wpcf7-style-1",
			esc_html__("Style 2",'yogax')		=> "wpcf7-style-2",
			esc_html__("Style 3",'yogax')		=> "wpcf7-style-3"
		),
		'save_always' => true,
		"description" => esc_html__( 'You can change each style in the Customizer > Contact Form 7', 'yogax' ),
	));
}