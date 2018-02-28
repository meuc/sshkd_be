<?php
/**
 * The template for displaying 404 pages (not found).
 */

get_header(); 
$btn_style = get_theme_mod('yogax_button_style', 'style-3');
?>
<div class="wrapper" id="404-wrapper">
    
    <div class="container">
        
        <div class="row pd50">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="text-center">
                    <p class="intro"><?php esc_html_e("The page you requested couldn't be found - this could be due to a spelling error in the URL or a removed page.",'yogax'); ?></p>
                    <div class="mt35">
                        <a class="btn-primary <?php echo esc_attr($btn_style); ?>" href="<?php echo esc_url(home_url('/')); ?>"><span><?php esc_html_e('Go Back Home','yogax'); ?></span></a>
                    </div>
                </div>
            </div>
        </div>
        
    </div><!-- Container end -->
    
</div><!-- Wrapper end -->

<?php get_footer(); ?>
