<?php if ( get_post_meta( get_the_ID(), 'yogax_post_blog-audioembed', true ) != '' ) {  ?>
    <div class="content-audio">
       <?php   
            echo wp_kses(get_post_meta( get_the_ID(), 'yogax_post_blog-audioembed', true ), yogax_allowed_tags());
        ?>
    </div>
    <?php } ?>