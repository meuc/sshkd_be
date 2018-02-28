<?php
/**
 * Declaring menus & widgets
 *
 */

/**
 * Register menus
 */
if(!( function_exists('yogax_register_nav_menus') )){
    function yogax_register_nav_menus() {
        register_nav_menus(
            array(
                'main'  => esc_html__( 'Main Menu', 'yogax' ),
                'mobile'  => esc_html__( 'Mobile Menu', 'yogax' )
            )
        );
    }
    add_action( 'init', 'yogax_register_nav_menus' );
}

/**
 * Register sidebars and footer widgets
 */
if(! function_exists('yogax_widgets_init')) {
    function yogax_widgets_init()
    {
        //Sidebars
        register_sidebar(array(
            'name' => esc_html__('Blog Sidebar', 'yogax'),
            'id' => 'sidebar-blog',
            'description' => esc_html__('Sidebar for the blog', 'yogax'),
            'before_widget' => '<aside id="%1$s" class="sidebar widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5 class="title">',
            'after_title' => '</h5>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Page Sidebar', 'yogax'),
            'id' => 'sidebar-page',
            'description' => esc_html__('Sidebar for the page with sidebar template', 'yogax'),
            'before_widget' => '<aside id="%1$s" class="sidebar widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h5 class="title">',
            'after_title' => '</h5>',
        ));
        
        if( class_exists('Woocommerce') ){
            register_sidebar(array(
                'name' => esc_html__('Shop Sidebar', 'yogax'),
                'id' => 'sidebar-shop',
                'description' => esc_html__('Sidebar for the shop', 'yogax'),
                'before_widget' => '<aside id="%1$s" class="sidebar widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h5 class="title">',
                'after_title' => '</h5>',
            ));
        }
        //Header
        register_sidebar(array(
            'name' => esc_html__('Header', 'yogax'),
            'id' => 'header-widgets',
            'description' => esc_html__('Header Topbar Widget Area', 'yogax'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget' => '</div>'
        ));

        //Footer
        register_sidebar(array(
            'name' => esc_html__('Footer One', 'yogax'),
            'id' => 'footer-1',
            'description' => esc_html__('Add content to the footer', 'yogax'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Two', 'yogax'),
            'id' => 'footer-2',
            'description' => esc_html__('Add content to the footer', 'yogax'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Three', 'yogax'),
            'id' => 'footer-3',
            'description' => esc_html__('Add content to the footer', 'yogax'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Four', 'yogax'),
            'id' => 'footer-4',
            'description' => esc_html__('Add content to the footer', 'yogax'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="title">',
            'after_title' => '</h4>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Footer Bottom Right', 'yogax'),
            'id' => 'footer-bottom-right',
            'description' => esc_html__('Footer Bottom Widget Area', 'yogax'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '',
            'after_title' => '',
        ));
    }

}
add_action( 'widgets_init', 'yogax_widgets_init' );