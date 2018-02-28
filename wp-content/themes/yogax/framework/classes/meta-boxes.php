<?php
add_filter( 'rwmb_meta_boxes', function( $meta_boxes )
{
	
	/* ----------------------------------------------------- */
	// Page Settings
	/* ----------------------------------------------------- */
	
	$meta_boxes[] = array(
		'id'			=> 'pagesettings',
		'title' 		=> esc_html__('Page Settings','yogax'),
		'post_types'	=> array( 'page', 'post', 'trainers', 'classes' ),
		'context'		=> 'normal',
		'priority'		=> 'high',

		'tabs'      	=> array(
            'header'	=> array(
                'label' => esc_html__( 'Header', 'yogax' ),
            ),
            'footer'	=> array(
                'label' => esc_html__( 'Footer', 'yogax' ),
            ),
        	'content'	=> array(
                'label' => esc_html__( 'Content', 'yogax' ),
            ),
            'logo'	=> array(
                'label' => esc_html__( 'Logo', 'yogax' ),
            ),
        ),

        // Tab style: 'default', 'box' or 'left'. Optional
        'tab_style' => 'default',
		
		// List of meta fields
		'fields' => array(
				array(
						'name'		=> esc_html__( 'Logo Image', 'yogax' ),
						'id'		=> "yogax_post_logo_img",
						'type'		=> 'image_advanced',
						'desc'		=> esc_html__( 'Overwrites default logo from customizer.', 'yogax' ),
						'tab'		=> 'logo'
				),
				array(
						'name'		=> esc_html__( 'Logo Image (Transparent)', 'yogax' ),
						'id'		=> "yogax_post_logo_img_transparent",
						'type'		=> 'image_advanced',
						'desc'		=> esc_html__( 'Overwrites alternative transparent logo from customizer.', 'yogax' ),
						'tab'		=> 'logo'
				),
				array(
						'id'		=> "yogax_post_logo_divider1",
						'type'		=> 'divider',
						'tab'		=> 'logo'
				),
				array(
						'name'		=> esc_html__( 'Retina Logo Image', 'yogax' ),
						'id'		=> "yogax_post_logo2x_img",
						'type'		=> 'image_advanced',
						'desc'		=> esc_html__( 'Overwrites default 2x size logo from customizer.', 'yogax' ),
						'tab'		=> 'logo'
				),
				array(
						'name'		=> esc_html__( 'Retina Logo Image (Transparent)', 'yogax' ),
						'id'		=> "yogax_post_logo2x_img_transparent",
						'type'		=> 'image_advanced',
						'desc'		=> esc_html__( 'Overwrites alternative transparent 2x size logo from customizer.', 'yogax' ),
						'tab'		=> 'logo'
				),
				array(
						'id'		=> "yogax_post_logo_divider2",
						'type'		=> 'divider',
						'tab'		=> 'logo'
				),
				array(
						'name'		=> esc_html__( 'Sticky & Mobile Logo Image', 'yogax' ),
						'id'		=> "yogax_post_logo_mobile",
						'type'		=> 'image_advanced',
						'desc'		=> esc_html__( 'Overwrites default sticky and mobile logo from customizer.', 'yogax' ),
						'tab'		=> 'logo'
				),
				array(
						'name'		=> esc_html__( 'Sticky & Mobile Retina Logo Image', 'yogax' ),
						'id'		=> "yogax_post_logo2x_mobile",
						'type'		=> 'image_advanced',
						'desc'		=> esc_html__( 'Overwrites sticky and mobile 2x size logo from customizer.', 'yogax' ),
						'tab'		=> 'logo'
				),
				array(
					'name'		=> esc_html__( 'Header Style', 'yogax' ),
					'id'		=> "yogax_post_header_style",
					'type'		=> 'select',
					'options'	=> array(
						''							=> esc_html__( 'Default (set in Customizer)', 'yogax' ),
						'header-top-full'			=> esc_html__( 'Top Full Width', 'yogax' ),
						'header-top-boxed'	    	=> esc_html__( 'Top Boxed', 'yogax' ),
						'header-transparent-full'	=> esc_html__( 'Transparent Full Width', 'yogax' ),
						'header-transparent-boxed'	=> esc_html__( 'Transparent Boxed', 'yogax' ),
						'header-boxed'				=> esc_html__( 'Boxed', 'yogax' ),
                        'header-stacked'        	=> esc_html__( 'Logo above top bar', 'yogax' ),
                        'header-none'				=> esc_html__( 'No Header', 'yogax' )
					),
					'multiple'	=> false,
					'std'		=> array( '' ),
					'desc'		=> esc_html__( 'Choose your Header Style for this Page', 'yogax' ),
					'tab'		=> 'header'
				),
				array(
						'name'		=> esc_html__( 'Show Bottom Border For Transparent Headers?', 'yogax' ),
						'id'		=> "yogax_post_header_border_show",
						'type'		=> 'select',
						'options'	=> array(
							''					=> esc_html__( 'Default (set in Customizer)', 'yogax' ),
							'header-border'		=> esc_html__( 'Show', 'yogax' ),
							'no-border'			=> esc_html__( 'Hide', 'yogax' )
						),
						'multiple'	=> false,
						'std'		=> array( '' ),
						'desc'		=> esc_html__( 'Enable or Disable the bottom border for the transparent header styles.', 'yogax' ),
						'tab'		=> 'header',
						'visible'	=> array(
							array( 'yogax_post_header_style', 'in', array('header-transparent-full', 'header-transparent-boxed')),
						)
				),
			array(
					'name'		=> esc_html__( 'Transparent Header Bottom Border Color', 'yogax' ),
					'id'		=> "yogax_post_header_bottom_border_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'header',
					'visible'	=> array(
						array( 'yogax_post_header_style', 'in', array('header-transparent-full', 'header-transparent-boxed')),
						array( 'yogax_post_header_border_show', '!=', 'no-border')
					)
			),
			array(
					'id'		=> "yogax_post_divider1",
					'type'		=> 'divider',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
				'name'		=> esc_html__( 'Individual Page Menu', 'yogax' ),
				'id'		=> "yogax_post_header_menu",
				'desc'		=> esc_html__( 'Set a different navigation menu only for this page.', 'yogax' ),
				'type'    	=> 'taxonomy_advanced',
				'tab'		=> 'header',
				'taxonomy' 	=> 'nav_menu',
				'field_type'=> 'select'
			),
			array(
					'id'		=> "yogax_post_divider2",
					'type'		=> 'divider',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Show or hide Page Title', 'yogax' ),
					'id'		=> "yogax_post_header",
					'type'		=> 'select',
					'options'	=> array(
						'show'		=> esc_html__( 'Show', 'yogax' ),
						'hide'		=> esc_html__( 'Hide', 'yogax' )
					),
					'multiple'	=> false,
					'std'		=> array( 'show' ),
					'desc'		=> esc_html__( 'Enable or Disable the page title on this Page.', 'yogax' ),
					'tab'		=> 'header',
			),
			array(
					'name'		=> esc_html__( 'Page Title Background', 'yogax' ),
					'id'		=> "yogax_post_header_background",
					'type'		=> 'select',
					'options'	=> array(
						'color'     => esc_html__( 'Color', 'yogax' ),
                        'image'     => esc_html__( 'Image', 'yogax' ),
                        'slider'	=> esc_html__( 'Slider', 'yogax' ),
					),
					'multiple'	=> false,
					'std'		=> array( 'color' ),
					'desc'		=> esc_html__( 'Set the background for the page title to slider, image or color.', 'yogax' ),
					'tab'		=> 'header',
					'hidden'	=> array('yogax_post_header', '!=', 'show')
					
			),
			array(
					'name'		=> esc_html__( 'Page Title Height', 'yogax' ),
					'id'		=> "yogax_post_header_height",
					'type'		=> 'select',
					'options'	=> array(
						''			=> esc_html__( 'Default (set in Customizer)', 'yogax' ),
                        'large'     => esc_html__( 'Large', 'yogax' ),
						'small'		=> esc_html__( 'Small', 'yogax' ),
						'x-large'	=> esc_html__( 'Extra Large', 'yogax' ),
                        'x-small'   => esc_html__( 'Extra Small', 'yogax' )
					),
					'multiple'	=> false,
					'std'		=> array( '' ),
					'desc'		=> esc_html__( 'Set the page title height (Extra Small only for color background).', 'yogax' ),
					'tab'		=> 'header',
					'visible'	=> array(
						array( 'yogax_post_header_background', 'in', array('image', 'color')),
						array( 'yogax_post_header', 'show')
					)
					
			),
			array(
					'name'		=> esc_html__( 'Page Title Background Image', 'yogax' ),
					'id'		=> "yogax_post_header_image",
					'type'		=> 'image_advanced',
					'desc'		=> esc_html__( 'Upload page title image.', 'yogax' ),
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'image'),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Parallax Effect', 'yogax' ),
					'id'		=>  "yogax_post_header_image_parallax",
					'type'		=> 'checkbox',
					'desc'		=> esc_html__( 'Add parallax effect to background image', 'yogax' ),
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'image'),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Image Overlay Color', 'yogax' ),
					'id'		=> "yogax_post_pagetitle_image_overlay_color",
					'type'		=> 'color',
					'desc' => esc_html__( 'Add overlay color to image background', 'yogax' ),
					'std'		=> '',
					'tab'  => 'header',
					'visible' => array(
					    array( 'yogax_post_header_background', 'image'),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Image Overlay Opacity', 'yogax' ),
					'id'		=> "yogax_post_pagetitle_image_overlay_opacity",
					'type'		=> 'select',
					'options'	=> array(
						'1'			=> esc_html__( '0%', 'yogax' ),
						'0.9'		=> esc_html__( '10%', 'yogax' ),
						'0.8'		=> esc_html__( '20%', 'yogax' ),
						'0.7'		=> esc_html__( '30%', 'yogax' ),
						'0.6'		=> esc_html__( '40%', 'yogax' ),
						'0.5'		=> esc_html__( '50%', 'yogax' ),
						'0.4'		=> esc_html__( '60%', 'yogax' ),
						'0.3'		=> esc_html__( '70%', 'yogax' ),
						'0.2'		=> esc_html__( '80%', 'yogax' ),
						'0.1'		=> esc_html__( '90%', 'yogax' ),
						'0'			=> esc_html__( '100%', 'yogax' ),
					),
					'multiple'	=> false,
					'std'		=> '0.7',
					'tab'  => 'header',
					'visible' => array(
						array( 'yogax_post_header_background', 'image'),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Revolution Slider Shortcode', 'yogax' ),
					'id'		=> "yogax_post_header_slider",
					'type'		=> 'text',
					'desc'		=> esc_html__('[rev_slider id="sliderId"]', 'yogax'),
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'slider'),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Page Title Background Color', 'yogax' ),
					'id'		=> "yogax_post_header_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'color'),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'id'		=> "yogax_post_divider3",
					'type'		=> 'divider',
					'tab'		=> 'header',
					'visible'	=> array(
						array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Page Title', 'yogax' ),
					'id'		=> "yogax_post_page_title",
					'type'		=> 'text',
					'desc'		=> esc_html__( 'Overwrite the page title', 'yogax' ),
					'tab'		=> 'header',
					'visible'	=> array(
						array( 'yogax_post_header_background', 'in', array('image', 'color')),
						array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Page Title Alignment', 'yogax' ),
					'id'		=> "yogax_post_pagetitle_pos",
					'type'		=> 'select',
					'options'	=> array(
						''					=> esc_html__( 'Default (set in Customizer)', 'yogax' ),
						'text-left'			=> esc_html__( 'Left', 'yogax' ),
                        'text-center'   	=> esc_html__( 'Center', 'yogax' ),
						'text-right'		=> esc_html__( 'Right', 'yogax' )
					),
					'multiple'	=> false,
					'std'		=> array( '' ),
					'desc'		=> esc_html__( 'Set the page title alignment.', 'yogax' ),
					'tab'		=> 'header',
					'visible'	=> array(
						array( 'yogax_post_header_background', 'in', array('image', 'color')),
						array( 'yogax_post_header_height', 'in', array('', 'large', 'small', 'x-large')),
						array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Page Title Color', 'yogax' ),
					'id'		=> "yogax_post_pagetitle_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Page Title Separator Color', 'yogax' ),
					'id'		=> "yogax_post_pagetitle_underline_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Page Subtitle', 'yogax' ),
					'id'		=> "yogax_post_page_subtitle",
					'type'		=> 'text',
					'desc'		=> esc_html__( 'Set the page subtitle (only for extra large height).', 'yogax' ),
					'tab'		=> 'header',
					'visible'	=> array(
						array( 'yogax_post_header_background', 'in', array('image', 'color')),
						array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Page Subtitle Color', 'yogax' ),
					'id'		=> "yogax_post_page_subtitle_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'id'		=> "yogax_post_divider4",
					'type'		=> 'divider',
					'tab'		=> 'header',
					'visible'	=> array(
						array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Hide Breadcrumbs', 'yogax' ),
					'id'		=> "yogax_post_breadcrumbs_hide",
					'type'		=> 'checkbox',
					'desc'		=> esc_html__( 'Check to hide breadcrumbs for this page', 'yogax' ),
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show')
					)
			),
			array(
					'name'		=> esc_html__( 'Breadcrumbs Color', 'yogax' ),
					'id'		=>  "yogax_post_breadcrumb_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show'),
					    array( 'yogax_post_breadcrumbs_hide', false )
					)
			),
			array(
					'name'		=> esc_html__( 'Current Breadcrumb Color', 'yogax' ),
					'id'		=>  "yogax_post_breadcrumb_current_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'header',
					'visible'	=> array(
					    array( 'yogax_post_header_background', 'in', array('image', 'color')),
					    array( 'yogax_post_header', 'show'),
					    array( 'yogax_post_breadcrumbs_hide', false )
					)
			),
			array(
					'name'		=> esc_html__( 'Footer Widgets', 'yogax' ),
					'id'		=> "yogax_post_footer_widgets",
					'type'		=> 'select',
					'options'	=> array(
						'show'		=> esc_html__('Enable', 'yogax'),
						'hide'		=> esc_html__('Disable', 'yogax')
					),
					'multiple'	=> false,
					'std'		=> array( 'show' ),
					'desc'		=> esc_html__( 'Enable or disable the Footer Widgets on this Page.', 'yogax' ),
					'tab'		=> 'footer',
			),
			array(
					'name'		=> esc_html__( 'Footer Copyright', 'yogax' ),
					'id'		=> "yogax_post_footer_copyright",
					'type'		=> 'select',
					'options'	=> array(
						'show'		=> esc_html__('Enable', 'yogax'),
						'hide'		=> esc_html__('Disable', 'yogax')
					),
					'multiple'	=> false,
					'std'		=> array( 'show' ),
					'desc'		=> esc_html__( 'Enable or disable the Footer Copyright Section on this Page.', 'yogax' ),
					'tab'		=> 'footer',
			),
			array(
					'name'		=> esc_html__( 'Page Background Color', 'yogax' ),
					'id'		=> "yogax_post_site_bg_color",
					'type'		=> 'color',
					'desc'		=> esc_html__( 'Overwrite default color', 'yogax' ),
					'std'		=> '',
					'tab'		=> 'content'
				),
			array(
					'name'		=> esc_html__( 'Content Top Padding', 'yogax' ),
					'id'		=>  "yogax_post_top_padding",
					'type'		=> 'select',
					'options'	=> array(
						'pdt0'		=> '0',
						'pdt5'		=> '5px',
						'pdt10'		=> '10px',
						'pdt15'		=> '15px',
						'pdt25'		=> '25px',
						'pdt35'		=> '35px',
						'pdt50'		=> '50px',
						'pdt75'		=> '75px',
					),
					'multiple'	=> false,
					'std'		=> array( 'pdt75' ),
					'desc'		=> esc_html__( 'Set the top padding for the content.', 'yogax' ),
					'tab'		=> 'content',
			),
			array(
					'name'		=> esc_html__( 'Content Bottom Padding', 'yogax' ),
					'id'		=> "yogax_post_bottom_padding",
					'type'		=> 'select',
					'options'	=> array(
						'pdb0'		=> '0',
						'pdb5'		=> '5px',
						'pdb10'		=> '10px',
						'pdb15'		=> '15px',
						'pdb25'		=> '25px',
						'pdb35'		=> '35px',
						'pdb50'		=> '50px',
						'pdb75'		=> '75px',
					),
					'multiple'	=> false,
					'std'		=> array( 'pdb75' ),
					'desc'		=> esc_html__( 'Set the bottom padding for the content.', 'yogax' ),
					'tab'		=> 'content',
			),
			array(
					'name'		=> esc_html__( 'Sidebar', 'yogax' ),
					'id'		=> "yogax_post_content_sidebar",
					'type'		=> 'select',
					'options'	=> array(
						'show'		=> esc_html__('Enable','yogax'),
						'hide'		=> esc_html__('Disable','yogax')
					),
					'multiple'	=> false,
					'std'		=> array( 'show' ),
					'desc'		=> esc_html__( 'Enable or Disable the Sidebar for this Post.', 'yogax' ),
					'tab'		=> 'content',
					'visible'	=> array(
					    array( 'post_type', 'in', array('service', 'team')),
					)
			),
		)
	);
	
	
	/* ----------------------------------------------------- */
	// Blog Metaboxes
	/* ----------------------------------------------------- */
	
	// Link Post Format
	$meta_boxes[] = array(
		'id'		=> 'blog-link',
		'title' 	=> esc_html__( 'Link Settings', 'yogax' ),
		'pages' 	=> array( 'post' ),
		'context'	=> 'normal',
		'priority'	=> 'high',
		'visible'	=> array( 'post_format', 'link' ),
		// List of meta fields
		'fields'	=> array(
			array(
				'name'		=> esc_html__( 'URL', 'yogax' ),
				'id'		=> 'yogax_post_blog-link',
				'desc'		=> esc_html__( 'Enter a URL for your link post format. (Don\'t forget the http://)', 'yogax' ),
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			)
		)
	);

	// Quote Post Format
	$meta_boxes[] = array(
		'id'		=> 'blog-quote',
		'title' 	=> esc_html__( 'Quote Settings', 'yogax' ),
		'pages' 	=> array( 'post' ),
		'context'	=> 'normal',
		'priority'	=> 'high',
		'visible'	=> array( 'post_format', 'quote' ),
		// List of meta fields
		'fields'	=> array(
			array(
				'name'		=> esc_html__( 'Quote', 'yogax' ),
				'id'		=> 'yogax_post_blog-quote',
				'desc'		=> esc_html__( 'Please enter the text for your quote here.', 'yogax' ),
				'clone'		=> false,
				'type'		=> 'textarea',
				'std'		=> ''
			),
			array(
				'name'		=> esc_html__( 'Quote Source', 'yogax' ),
				'id'		=> 'yogax_post_blog-quotesource',
				'desc'		=> esc_html__( 'Please enter the Source of the Quote here.', 'yogax' ),
				'clone'		=> false,
				'type'		=> 'text',
				'std'		=> ''
			)
		)
	);

	// Video Post Format
	$meta_boxes[] = array(
		'id'		=> 'blog-video',
		'title' 	=> esc_html__( 'Video Settings', 'yogax' ),
		'pages' 	=> array( 'post' ),
		'context'	=> 'normal',
		'priority'	=> 'high',
		'visible'	=> array( 'post_format', 'video' ),
		// List of meta fields
		'fields'	=> array(
			array(
				'name'		=> esc_html__( 'Video Source', 'yogax' ),
				'id'		=> 'yogax_post_blog-videosource',
				'type'		=> 'select',
				'options'	=> array(
					'videourl'		=> esc_html__( 'Video URL', 'yogax' ),
					'embedcode'		=> esc_html__( 'Embed Code', 'yogax' )
				),
				'multiple'	=> false,
				'std'		=> array( 'videourl' ),
			),
			array(
				'name'		=> esc_html__( 'Video URL', 'yogax' ),
				'id'		=> 'yogax_post_blog-videourl',
				'desc'		=> sprintf( wp_kses(__( 'You can just insert the URL of the %s. If you fill out this field, it will be shown instead of the Slider. Notice: The Preview Image will be the Image set as Featured Image.', 'yogax' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Supported Video Site</a>' ),
				'type'		=> 'textarea',
				'std'		=> '',
				'hidden'	=> array( 'yogax_post_blog-videosource', 'embedcode' ),
			),
			array(
				'name'		=> esc_html__( 'Video Embed Code', 'yogax' ),
				'id'		=> 'yogax_post_blog-videoembed',
				'desc'		=> esc_html__( 'Insert the full embed code.', 'yogax' ),
				'clone'		=> false,
				'type'		=> 'textarea',
				'std'		=> '',
				'hidden'	=> array( 'yogax_post_blog-videosource', 'videourl' ),
			),
		)
	);

	// Audio Post Format
	$meta_boxes[] = array(
		'id'		=> 'blog-audio',
		'title' 	=> esc_html__( 'Audio Settings', 'yogax' ),
		'pages' 	=> array( 'post' ),
		'context'	=> 'normal',
		'priority'	=> 'high',
		'visible'	=> array( 'post_format', 'audio' ),
		// List of meta fields
		'fields'	=> array(
			array(
				'name'		=> esc_html__( 'Audio Embed Code', 'yogax' ),
				'id'		=> 'yogax_post_blog-audioembed',
				'desc'		=> esc_html__( 'Insert the full audio embed code here.', 'yogax' ),
				'clone'		=> false,
				'type'		=> 'textarea',
				'std'		=> ''
			),
		)
	);

	// Gallery Post Format
	$meta_boxes[] = array(
		'id'		=> 'blog-gallery',
		'title' 	=> esc_html__( 'Gallery Settings', 'yogax' ),
		'pages' 	=> array( 'post' ),
		'context'	=> 'normal',
		'priority'	=> 'high',
		'visible'	=> array( 'post_format', 'gallery' ),
		// List of meta fields
		'fields'	=> array(
			array(
				'name'				=> esc_html__( 'Gallery', 'yogax' ),
				'desc'				=> esc_html__( 'You can upload up to 50 gallery images for a slideshow', 'yogax' ),
				'id'				=> 'yogax_post_blog-gallery',
				'type'				=> 'image_advanced',
				'max_file_uploads'	=> 50,
			)
		)
	);
	
	/* ----------------------------------------------------- */
	// Portfolio Metaboxes
	/* ----------------------------------------------------- */
	if ( post_type_exists( 'portfolio' ) ) {
		$meta_boxes[] = array(
			'id'		=> 'portfolio_info',
			'title' 	=> esc_html__('Portfolio Settings','yogax'),
			'pages' 	=> array( 'portfolio' ),
			'context'	=> 'normal',

			'tabs'      => array(
				'portfolio' 	=> array(
	                'label' 	=> esc_html__( 'Portfolio Configuration', 'yogax' ),
	            ),
	            'slides'		=> array(
	                'label' 	=> esc_html__( 'Portfolio Slides', 'yogax' ),
	            ),
	            'video' 		=> array(
	                'label' 	=> esc_html__( 'Portfolio Video', 'yogax' ),
	            ),
	        ),

	        // Tab style: 'default', 'box' or 'left'. Optional
	        'tab_style' => 'default',
			
			'fields'	=> array(
				
				array(
					'name'		=> esc_html__('Detail Layout','yogax'),
					'id'		=> 'yogax_post_portfolio-detaillayout',
					'desc'		=> esc_html__('Choose your Layout for the Portfolio Detail Page.','yogax'),
					'type'		=> 'select',
					'options'	=> array(
						'wide'			=> esc_html__('Full Width (Slider)','yogax'),
						'wide-ns'		=> esc_html__('Full Width (No Slider)','yogax'),
						'sidebyside'	=> esc_html__('Side By Side (Slider)','yogax'),
						'sidebyside-ns'	=> esc_html__('Side By Side (No Slider)','yogax')
					),
					'multiple'	=> false,
					'std'		=> array( 'no' ),
					'tab'		=> 'portfolio',
				),
				array(
					'name'		=> esc_html__('Client','yogax'),
					'id'		=> 'yogax_post_portfolio-client',
					'desc'		=> esc_html__('The Client is shown on the Portfolio Detail Page. You can leave this empty to hide it.','yogax'),
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'		=> 'portfolio',
				),
				array(
					'name'		=> esc_html__('Project link','yogax'),
					'id'		=> 'yogax_post_portfolio-link',
					'desc'		=> esc_html__('URL Link to your Project (Do not forget the http://). This will be shown on the Portfolio Detail Page. You can leave this empty to hide it.','yogax'),
					'clone'		=> false,
					'type'		=> 'text',
					'std'		=> '',
					'tab'		=> 'portfolio',
				),
				array(
					'name'		=> esc_html__('Show Project Details?','yogax'),
					'id'		=>  "yogax_post_portfolio-details",
					'type'		=> 'checkbox',
					'std'		=> true,
					'tab'		=> 'portfolio',
				),
				array(
					'name'		=> esc_html__('Show Related Projects?','yogax'),
					'id'		=>  "yogax_post_portfolio-relatedposts",
					'type'		=> 'checkbox',
					'desc'		=> '',
					'std'		=> false,
					'tab'		=> 'portfolio',
				),
				array(
					'name'		=> esc_html__('Masonry Size','yogax'),
					'id'		=> 'yogax_post_portfolio-size',
					'desc'		=> esc_html__('Only relevant when the portfolio is displayed in masonry format.','yogax'),
					'type'		=> 'select',
					'options'	=> array(
						'regular'	=> esc_html__('Regular','yogax'),
						'wide'		=> esc_html__('Wide','yogax'),
						'tall'		=> esc_html__('Tall','yogax'),
						'widetall'	=> esc_html__('Wide & Tall','yogax')
					),
					'multiple'	=> false,
					'std'		=> array( 'regular' ),
					'tab'		=> 'portfolio',
				),
				array(
					'name'				=> esc_html__('Project Slider Images','yogax'),
					'desc'				=> esc_html__('You can upload up to 50 project images for a slideshow, or only one image to display a single image. Notice: The Preview Image (on Overview, Shortcodes & Related Projects) will be the Image set as Featured Image.','yogax'),
					'id'				=> 'yogax_post_screenshot',
					'type'				=> 'image_advanced',
					'max_file_uploads'	=> 50,
					'tab'				=> 'slides',
				),
				array(
					'name'		=> esc_html__('Video Source','yogax'),
					'id'		=> 'yogax_post_source',
					'type'		=> 'select',
					'options'	=> array(
						'videourl'		=> esc_html__('Video URL','yogax'),
						'embedcode'		=> esc_html__('Embed Code','yogax')
					),
					'multiple'	=> false,
					'std'		=> array( 'no' ),
					'tab'		=> 'video',
				),
				array(
					'name'		=> esc_html__('Video URL','yogax'),
					'id'		=> 'yogax_post_videourl',
					'desc'  	=> sprintf( wp_kses(__( 'You can just insert the URL of the %s. If you fill out this field, it will be shown instead of the Slider. Notice: The Preview Image will be the Image set as Featured Image.', 'yogax' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Supported Video Site</a>' ),
					'type' 		=> 'textarea',
					'std' 		=> "",
					'cols' 		=> "40",
					'rows' 		=> "8",
					'tab'		=> 'video',
					'visible'	=> array( 'yogax_post_source', 'videourl' ),
				),
				array(
					'name'		=> esc_html__('Embed Code','yogax'),
					'id'		=> 'yogax_post_embed',
					'desc'		=> esc_html__('Insert your own Embed Code. If you fill out this field, it will be shown instead of the Slider. Notice: The Preview Image will be the Image set as Featured Image.','yogax'),
					'type' 		=> 'textarea',
					'std' 		=> "",
					'cols' 		=> "40",
					'rows' 		=> "8",
					'tab'		=> 'video',
					'visible'	=> array( 'yogax_post_source', 'embedcode' ),
				)
			)
		);
	}
	
	/* ----------------------------------------------------- */
	// Testimonial Metaboxes
	/* ----------------------------------------------------- */
	if ( post_type_exists( 'testimonial' ) ) {
		$meta_boxes[] = array(
			'id'		=> 'testimonialsettings',
			'title' 	=> esc_html__('Testimonial Settings','yogax'),
			'pages' 	=> array( 'testimonial' ),
			'context'	=> 'normal',
			'priority'	=> 'high',
		
			// List of meta fields
			'fields' => array(
				array(
					'name'	=> esc_html__( 'Author', 'yogax' ),
					'desc'	=> esc_html__( 'Enter the author of this testimonial', 'yogax' ),
					'id'	=> 'yogax_post_testimonial-author',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Company', 'yogax' ),
					'desc'	=> esc_html__( 'Enter the company of this testimonial', 'yogax' ),
					'id'	=> 'yogax_post_testimonial-company',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Company URL', 'yogax' ),
					'desc'	=> esc_html__( 'Enter the company url of this testimonial', 'yogax' ),
					'id'	=> 'yogax_post_testimonial-companyurl',
					'type'	=> 'text'
				)
			)
		);
	}
	
	/* ----------------------------------------------------- */
	// Team Metaboxes
	/* ----------------------------------------------------- */
	if ( post_type_exists( 'team' ) ) {
		$meta_boxes[] = array(
			'id'		=> 'teamsettings',
			'title' 	=> esc_html__( 'Team Settings', 'yogax' ),
			'pages' 	=> array( 'team' ),
			'context'	=> 'normal',
			'priority'	=> 'high',
		
			// List of meta fields
			'fields' => array(
				array(
					'name'	=> esc_html__( 'Position', 'yogax' ),
					'desc'	=> esc_html__( 'Enter the job position of the team member', 'yogax' ),
					'id'	=> 'yogax_post_team-position',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Twitter Profile', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your twitter profile url', 'yogax' ),
					'id'	=> 'yogax_post_team-twitter',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Facebook Profile', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your facebook profile url', 'yogax' ),
					'id'	=> 'yogax_post_team-facebook',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Google+ Profile', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your google plus profile url', 'yogax' ),
					'id'	=> 'yogax_post_team-googleplus',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Instagram Profile', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your instagram profile url', 'yogax' ),
					'id'	=> 'yogax_post_team-instagram',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'LinkedIn Profile', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your linkedin profile url', 'yogax' ),
					'id'	=> 'yogax_post_team-linkedin',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Dribbble Profile', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your dribbble profile url', 'yogax' ),
					'id'	=> 'yogax_post_team-dribbble',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Skype Profile', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your skype profile url', 'yogax' ),
					'id'	=> 'yogax_post_team-skype',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'Phone Number', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your phone number', 'yogax' ),
					'id'	=> 'yogax_post_team-phone',
					'type'	=> 'text'
				),
				array(
					'name'	=> esc_html__( 'E-Mail', 'yogax' ),
					'desc'	=> esc_html__( 'Enter your mail', 'yogax' ),
					'id'	=> 'yogax_post_team-mail',
					'type'	=> 'text'
				)
			)
		);
	}
	
	/* ----------------------------------------------------- */
	// Service Metaboxes
	/* ----------------------------------------------------- */
	if ( post_type_exists( 'service' ) ) {
		$meta_boxes[] = array(
			'id'		=> 'service_show_featured_image',
			'title' 	=> esc_html__('Hide Featured Image?','yogax'),
			'pages' 	=> array( 'service' ),
			'context'	=> 'side',
			'priority'	=> 'low',
			// List of meta fields
			'fields'	=> array(
				array(
					'name'		=> '',
					'id'		=> "yogax_post_service_featured_image",
					'type'		=> 'checkbox',
					'desc'		=> '',
					'std'		=> false
				),
			)
		);
	}
	
	return $meta_boxes;
} );