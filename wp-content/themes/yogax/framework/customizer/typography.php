<?php
/**
 * Adds typography options to the Customizer and outputs the custom CSS for them
 * 
 */

if ( ! class_exists( 'Yogax_Theme_Customizer_Typography' ) ) {
	class Yogax_Theme_Customizer_Typography {

		/*-----------------------------------------------------------------------------------*/
		/*	- Constructor
		/*-----------------------------------------------------------------------------------*/
		public function __construct() {
			// Loads customizer js file for postmessage transport method
			//add_action( 'customize_preview_init', array( $this, 'preview_init' ) );
			add_action( 'customize_register', array( $this , 'yogax_register' ) );
			add_action( 'customize_save_after', array( $this, 'yogax_reset_cache' ) );
			add_action( 'wp_head', array( $this, 'yogax_load_fonts' ) );
			add_action( 'wp_head', array( $this, 'yogax_output_css' ) );
		}
		
		function yogax_typo_sanitize_choices( $input, $setting ) {
			global $wp_customize;
		 
			$control = $wp_customize->get_control( $setting->id );
		 
			if ( array_key_exists( $input, $control->choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
		
		/*-----------------------------------------------------------------------------------*/
		/*	- Array of elements for typography options
		/*-----------------------------------------------------------------------------------*/
		public function yogax_elements() {
			$array = array(
				'body'	=> array(
					'label'		=>	esc_html__( 'Body', 'yogax' ),
					'target'	=>	'body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title'
				),
				'paragraph'	=> array(
					'label'		=>	esc_html__( 'Paragraph <p>', 'yogax' ),
					'target'	=>	'p, .textwidget'
				),
				'intro'	=> array(
					'label'		=>	esc_html__( 'Intro Text', 'yogax' ),
					'target'	=>	'.intro'
				),
				'headings_xl_title'	=> array(
					'label'		=> esc_html__( 'Page Title XL', 'yogax' ),
					'target'	=> '.x-large .header_text_wrapper h1'
				),
				'headings_xl_subtitle'	=> array(
					'label'		=> esc_html__( 'Page Title XL Subtitle', 'yogax' ),
					'target'	=> '.header_text_wrapper .subtitle'
				),
				'headings_large_title'	=> array(
					'label'		=> esc_html__( 'Page Title L', 'yogax' ),
					'target'	=> '.large .header_text_wrapper h1'
				),
				'headings_small_title'	=> array(
					'label'		=> esc_html__( 'Page Title S', 'yogax' ),
					'target'	=> '.small .header_text_wrapper h1'
				),
				'headings_xs_title'	=> array(
					'label'		=> esc_html__( 'Page Title XS', 'yogax' ),
					'target'	=> '.x-small .header_text_wrapper h1'
				),
				'headings2'	=> array(
					'label'		=> esc_html__( 'Heading H2', 'yogax' ),
					'target'	=> 'h2'
				),
				'headings3'	=> array(
					'label'		=> esc_html__( 'Heading H3', 'yogax' ),
					'target'	=> 'h3'
				),
				'headings4'	=> array(
					'label'		=> esc_html__( 'Heading H4', 'yogax' ),
					'target'	=> 'h4'
				),
				'headings5'	=> array(
					'label'		=> esc_html__( 'Heading H5', 'yogax' ),
					'target'	=> 'h5'
				),
				'nav_menu'	=> array(
					'label'		=> esc_html__( 'Main Menu', 'yogax' ),
					'target'	=> '.nav-menu li a'
				),
				'menu_dropdown'	=> array(
					'label'		=> esc_html__( 'Main Menu: Dropdowns', 'yogax' ),
					'target'	=> '.nav-menu ul ul li a'
				),
				'mobile_menu'	=> array(
					'label'		=> esc_html__( 'Mobile Menu', 'yogax' ),
					'target'	=> '#mobile-navigation ul li a'
				),
				'breadcrumb'	=> array(
					'label'		=> esc_html__( 'Breadcrumbs', 'yogax' ),
					'target'	=> '.breadcrumb'
				),
				'sidebar_widget_title'	=> array(
					'label'		=> esc_html__( 'Sidebar Widget Heading', 'yogax' ),
					'target'	=> '.sidebar.widget .title'
				),
				'footer_widget_title'	=> array(
					'label'		=> esc_html__( 'Footer Widget Heading', 'yogax' ),
					'target'	=> '.site-footer .widget .title'
				),
				'footer_paragraph'	=> array(
					'label'		=>	esc_html__( 'Footer Paragraph <p>', 'yogax' ),
					'target'	=>	'.site-footer p'
				),
				'footer_list'	=> array(
					'label'		=>	esc_html__( 'Footer Lists <ul>', 'yogax' ),
					'target'	=>	'.site-footer ul'
				),
				'blog_post_title'	=> array(
					'label'			=> esc_html__( 'Blog Post Title', 'yogax' ),
					'target'		=> '.blog-normal .content-wrap .entry-title'
				),
				'forms_label'	=> array(
					'label'			=> esc_html__( 'Forms Label', 'yogax' ),
					'target'		=> 'label'
				),
				'copyright'	=> array(
					'label'		=> esc_html__( 'Copyright', 'yogax' ),
					'target'	=> '.site-info'
				),
				'button'	=> array(
					'label'		=> esc_html__( 'Primary Button', 'yogax' ),
					'target'	=> '.btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a'
				),
				'tab'	=> array(
					'label'		=> esc_html__( 'Accordion&Tabs', 'yogax' ),
					'target'	=> '.vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a, .timetable-tabs.ui-tabs .ui-tabs-nav li a, .ttbase-trainer-filter-list li a, .ttbase-class-filter-list li a'
				),
				'quote'	=> array(
					'label'		=> esc_html__( 'Quotes', 'yogax' ),
					'target'	=> 'blockquote'
				),
				// 'load_custom_font_1'	=> array(
				// 	'label'				=> esc_html__( 'Load Custom Font', 'yogax' ),
				// 	'settings'			=> array( 'font-family' )
				// ),
			);
			if (post_type_exists('classes')) {
				$array['timetable'] = array(
					'label'		=> esc_html__( 'Schedule', 'yogax' ),
					'target'	=> '.timetable, .timetable.small .box_header'
				);
			}
			return $array;
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Register Typography Panel and Sections
		/*-----------------------------------------------------------------------------------*/
		public function yogax_register ( $wp_customize ) {
		    
			require_once get_template_directory() . '/framework/customizer/controls.php';
			
			// Get elements
			$elements = $this->yogax_elements();

			// Return if elements are empty. This check is needed due to the filter added above
			if ( empty( $elements ) ) {
				return;
			}
			
			// Add General Panel
			$wp_customize->add_panel( 'yogax_typography', array(
				'priority'		=> 25,
				'capability'	=> 'edit_theme_options',
				'title'			=> esc_html__( 'Typography', 'yogax' ),
			) );
			
			// Add General Tab with font smoothing
			$wp_customize->add_section( 'yogax_typography_general' , array(
				'title' => esc_html__( 'General', 'yogax' ),
				'priority' => 1,
				'panel' => 'yogax_typography',
			) );

			// Font Smoothing
			$wp_customize->add_setting( 'yogax_enable_font_smoothing', array(
				'type' => 'theme_mod',
				'default' => false,
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'yogax_enable_font_smoothing', array(
				'label' => esc_html__( 'Font Smoothing', 'yogax' ),
				'section' => 'yogax_typography_general',
				'settings' => 'yogax_enable_font_smoothing',
				'priority' => 1,
				'type' => 'checkbox',
				'description' => esc_html__( 'Enable font-smoothing site wide. This makes fonts look a little "skinner".', 'yogax' ),
			) ) );


			// Lopp through elements
			$count = '1';
			foreach( $elements as $element => $array ) {
				$count++;
				
				// Get label
				$label            = ! empty( $array['label'] ) ? $array['label'] : '';
				$exclude_settings = ! empty( $array['exclude'] ) ? $array['exclude'] : '';
				$active_callback  = isset( $array['active_callback'] ) ? $array['active_callback'] : '';
				$margin           = isset( $array['margin'] ) ? true : false;
				
				// Get settings
				if ( ! isset ( $array['settings'] ) ) {
					$settings = array(
						'font-family',
						'font-weight',
						'font-style',
						'text-transform',
						'font-size',
						'line-height',
						'letter-spacing',
						//'font-color',
					);
				} else {
					$settings = $array['settings'];
				}

				// Set keys equal to vals
				$settings = array_combine( $settings, $settings );

				// Exclude options
				if ( $exclude_settings ) {
					foreach ( $exclude_settings as $key => $val ) {
						unset( $settings[ $val ] );
					}
				}

				if ( $label ) {

					// Define Section
					$wp_customize->add_section( 'yogax_typography_'. $element , array(
						'title' => $label,
						'priority' => $count,
						'panel' => 'yogax_typography',
					) );

					// Font Family
					if ( in_array( 'font-family', $settings ) ) {

						// Get default
						$default = ! empty( $array['defaults']['font-family'] ) ? $array['defaults']['font-family'] : NULL;

						// Add setting
						$wp_customize->add_setting( 'yogax_' . $element .'_typography[font-family]', array(
							'type' => 'theme_mod',
							'default' => $default,
							'sanitize_callback' => false,
						) );

						// Add Control
						$wp_customize->add_control( new yogax_Fonts_Dropdown_Custom_Control( $wp_customize, 'yogax_' . $element .'_typography[font-family]', array(
								'label' => esc_html__( 'Font Family', 'yogax' ),
								'section' => 'yogax_typography_'. $element,
								'settings' => 'yogax_' .$element .'_typography[font-family]',
								'priority' => 1,
								'active_callback' => $active_callback,
						) ) );

					}

					// Font Weight
					if ( in_array( 'font-weight', $settings ) ) {
						$wp_customize->add_setting( 'yogax_' .$element .'_typography[font-weight]', array(
							'type' => 'theme_mod',
							'description' => esc_html__( 'Note: Not all Fonts support every font weight style.', 'yogax' ),
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'yogax_' .$element .'_typography[font-weight]', array(
							'label' => esc_html__( 'Font Weight', 'yogax' ),
							'section' => 'yogax_typography_'. $element,
							'settings' => 'yogax_' .$element .'_typography[font-weight]',
							'priority' => 2,
							'type' => 'select',
							'active_callback' => $active_callback,
							'choices' => array (
								'' => esc_html__( 'Default', 'yogax' ),
								'100' => esc_html__( 'Extra Light: 100', 'yogax' ),
								'200' => esc_html__( 'Light: 200', 'yogax' ),
								'300' => esc_html__( 'Book: 300', 'yogax' ),
								'400' => esc_html__( 'Normal: 400', 'yogax' ),
								'500' => esc_html__( 'Medium: 500', 'yogax' ),
								'600' => esc_html__( 'Semibold: 600', 'yogax' ),
								'700' => esc_html__( 'Bold: 700', 'yogax' ),
								'800' => esc_html__( 'Extra Bold: 800', 'yogax' ),
							),
							'description' => esc_html__( 'Important: Not all fonts support every font-weight.', 'yogax' ),
						) );
					}

					// Font Style
					if ( in_array( 'font-style', $settings ) ) {
						$wp_customize->add_setting( 'yogax_' .$element .'_typography[font-style]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'yogax_' .$element .'_typography[font-style]', array(
							'label' => esc_html__( 'Font Style', 'yogax' ),
							'section' => 'yogax_typography_'. $element,
							'settings' => 'yogax_' .$element .'_typography[font-style]',
							'priority' => 3,
							'type' => 'select',
							'active_callback' => $active_callback,
							'choices' => array (
								'' => esc_html__( 'Default', 'yogax' ),
								'normal' => esc_html__( 'Normal', 'yogax' ),
								'italic' => esc_html__( 'Italic', 'yogax' ),
							),
						) );
					}

					// Text-Transform
					if ( in_array( 'text-transform', $settings ) ) {
						$wp_customize->add_setting( 'yogax_' .$element .'_typography[text-transform]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'yogax_' .$element .'_typography[text-transform]', array(
							'label' => esc_html__( 'Text Transform', 'yogax' ),
							'section' => 'yogax_typography_'. $element,
							'settings' => 'yogax_' .$element .'_typography[text-transform]',
							'priority' => 4,
							'type' => 'select',
							'active_callback' => $active_callback,
							'choices' => array (
								'' => esc_html__( 'Default', 'yogax' ),
								'capitalize' => esc_html__( 'Capitalize', 'yogax' ),
								'lowercase' => esc_html__( 'Lowercase', 'yogax' ),
								'uppercase' => esc_html__( 'Uppercase', 'yogax' ),
								'none' => esc_html__( 'None', 'yogax' ),
							),
						) );
					}

					// Font Size
					if ( in_array( 'font-size', $settings ) ) {
						$wp_customize->add_setting( 'yogax_' .$element .'_typography[font-size]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'yogax_' .$element .'_typography[font-size]', array(
							'label' => esc_html__( 'Font Size', 'yogax' ),
							'section' => 'yogax_typography_'. $element,
							'settings' => 'yogax_' .$element .'_typography[font-size]',
							'priority' => 5,
							'type' => 'text',
							'description' => esc_html__( 'Value in pixels.', 'yogax' ),
							'active_callback' => $active_callback,
						) );
					}

					// Font Color
					if ( in_array( 'font-color', $settings ) ) {
						$wp_customize->add_setting( 'yogax_' .$element .'_typography[color]', array(
							'type' => 'theme_mod',
							'default' => '',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'yogax_' . $element .'_typography_color', array(
							'label' => esc_html__( 'Font Color', 'yogax' ),
							'section' => 'yogax_typography_'. $element,
							'settings' => 'yogax_' . $element .'_typography[color]',
							'priority' => 6,
							'active_callback' => $active_callback,
						) ) );
					}

					// Line Height
					if ( in_array( 'line-height', $settings ) ) {
						$wp_customize->add_setting( 'yogax_' . $element .'_typography[line-height]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'yogax_' . $element .'_typography[line-height]',
							array(
								'label' => esc_html__( 'Line Height', 'yogax' ),
								'section' => 'yogax_typography_'. $element,
								'settings' => 'yogax_' . $element .'_typography[line-height]',
								'priority' => 7,
								'type' => 'text',
								'active_callback' => $active_callback,
						) );
					}

					// Letter Spacing
					if ( in_array( 'letter-spacing', $settings ) ) {
						$wp_customize->add_setting( 'yogax_' . $element .'_typography[letter-spacing]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'yogax_' . $element .'_typography_letter_spacing', array(
							'label' => esc_html__( 'Letter Spacing', 'yogax' ),
							'section' => 'yogax_typography_'. $element,
							'settings' => 'yogax_' . $element .'_typography[letter-spacing]',
							'priority' => 8,
							'type' => 'text',
							'active_callback' => $active_callback,
						) ) );
					}

					// Margin
					if ( $margin ) {
						$wp_customize->add_setting( 'yogax_' . $element .'_typography[margin]', array(
							'type' => 'theme_mod',
							'sanitize_callback' => false,
						) );
						$wp_customize->add_control( 'yogax_' . $element .'_typography[margin]',
							array(
								'label' => esc_html__( 'Margin', 'yogax' ),
								'section' => 'yogax_typography_'. $element,
								'settings' => 'yogax_' . $element .'_typography[margin]',
								'priority' => 9,
								'type' => 'text',
								'active_callback' => $active_callback,
						) );
					}

				}
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Reset Cache after customizer save
		/*-----------------------------------------------------------------------------------*/
		public function yogax_reset_cache() {
			remove_theme_mod( 'yogax_customizer_typography_cache' );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Output Custom CSS
		/*-----------------------------------------------------------------------------------*/
		public function yogax_loop( $return = 'css' ) {
			// Get typography data cache
			$data = get_theme_mod( 'yogax_customizer_typography_cache', false );
			// If theme mod cache empty or is live customizer loop through elements and set output
			if ( empty( $data ) || is_customize_preview() ) {
				// Define Vars
				$css			= '';
				$load_scripts	= '';
				$fonts			= array();
				$scripts		= array();
				$scripts_output = '';
				$elements		= $this->yogax_elements();
				// Loop through each elements that need typography styling applied to them
				foreach( $elements as $element => $array ) {
					// Attributes to loop through
					if ( ! empty( $array['settings'] ) ) {
						$attributes = $array['settings'];
					} else {
						$attributes = array( 'font-family', 'font-weight', 'font-style', 'font-size', 'color', 'line-height', 'letter-spacing', 'text-transform', 'margin' );
					}
					$add_css	= '';
					$target		= isset( $array['target'] ) ? $array['target'] : '';
					$get_mod	= get_theme_mod( 'yogax_' . $element .'_typography' );
					foreach ( $attributes as $attribute ) {
						$val = isset ( $get_mod[$attribute] ) ? $get_mod[$attribute] : '';
						if ( $val ) {
							// Sanitize
						$val = str_replace( '"', '', $val );

						// Sanitize data
						$val = ( 'font-size' == $attribute ) ? yogax_sanitize_data( $val, 'font_size' ) : $val;
						$val = ( 'letter-spacing' == $attribute ) ? yogax_sanitize_data( $val, 'px' ) : $val;
						$val = ( 'line-height' == $attribute ) ? yogax_sanitize_data( $val, 'px' ) : $val;

						// Add quotes around font-family && font family to scripts array
						if ( 'font-family' == $attribute ) {
							$fonts[] = $val;
							$val = $val;
						}
							// Add custom CSS
							$add_css .= $attribute .':'. $val .';';
						}
					}
					if ( $add_css ) {
						$css .= $target .'{'. $add_css .'}';
					} 
				}
				if ( $css || $fonts ) {
					// Only load 1 of each font
					if ( ! empty( $fonts ) ) {
						array_unique( $fonts );
					}
					// Get Google Scripts to load on the front end
					if ( ! empty ( $fonts ) ) {
						$google_fonts	= yogax_google_fonts_array();
						// Loop through fonts and create Google Font Link
						foreach ( $fonts as $font ) {
							if ( in_array( $font, $google_fonts ) ) {
								$scripts[] = 'https://fonts.googleapis.com/css?family='.str_replace(' ', '%20', $font ) .'';
							}
						}
						// If scripts need to be loaded create the link tags
						if ( ! empty( $scripts ) ) {
							$scripts_output = '<!-- Load Google Fonts -->';
							foreach ( $scripts as $script ) {
								$scripts_output .= '<link href="'. $script .':300italic,400italic,500italic,600italic,700italic,800italic,400,300,500,600,700,800&amp;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic" rel="stylesheet" type="text/css">';
							}
						}
					}
				}
			}
			// Set cache or get cache if not in customizer
			if ( ! is_customize_preview() ) {
				// Get Cache vars
				if ( $data ) {
					$css			= isset( $data['css'] ) ? $data['css'] : '';
					$fonts			= isset( $data['fonts'] ) ? $data['fonts'] : '';
					$scripts		= isset( $data['scripts'] ) ? $data['scripts'] : '';
					$scripts_output	= isset( $data['scripts_output'] ) ? $data['scripts_output'] : '';
				}
				// Set Cache
				else {
					set_theme_mod( 'yogax_customizer_typography_cache', array (
						'css'				=> $css,
						'fonts'				=> $fonts,
						'scripts'			=> $scripts,
						'scripts_output'	=> $scripts_output,
					) );
				}
			}
			// Return CSS
			if ( 'css' == $return && $css ) {
				$css = '<!-- Typography CSS --><style type="text/css">'. $css .'</style>';
				return $css;
			}
			// Return Fonts Array
			if ( 'fonts' == $return && ! empty( $fonts ) ) {
				return $fonts;
			}
			// Return Scripts Array
			if ( 'scripts' == $return && ! empty( $scripts ) ) {
				return $scripts;
			}
			// Return Scripts Output
			if ( 'scripts_output' == $return && $scripts_output ) {
				return $scripts_output;
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Output Custom CSS
		/*-----------------------------------------------------------------------------------*/
		public function yogax_output_css() {
			echo $this->yogax_loop( 'css' );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	- Load Google Fonts
		/*-----------------------------------------------------------------------------------*/
		public function yogax_load_fonts() {
			echo $this->yogax_loop( 'scripts_output' );
		}
		
		/**
		 * Loads customizer js file for postmessage transport method
		 *
		 * @link http://codex.wordpress.org/Theme_Customization_API
		 */
		public function yogax_preview_init() {
			wp_enqueue_script(
				'yogax-typography-postmessage',
				get_template_directory_uri() . '/framework/customizer/assets/typography-postmessage.js',
				array( 'jquery','customize-preview' ),
				false,
				true
			);
		}

	}
}
new Yogax_Theme_Customizer_Typography();