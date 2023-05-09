<?php
    /**
    * The template for displaying all single posts and attachments
    *
    * @package WordPress
    * @subpackage Twenty_Fifteen
    * @since Twenty Fifteen 1.0
    */
//echo "hy"; die;
    get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
            // Start the loop.
            while ( have_posts() ) : the_post();

                /*
                * Include the post format-specific template for the content. If you want to
                * use this in a child theme, then include a file called called content-___.php
                * (where ___ is the post format) and that will be used instead.
                */

                if(get_post_type() == "testimonial")
                {
                    get_template_part('content','testimonial');
                }
                else
                {
                    get_template_part('content','page');
                }

                endwhile;
        ?>

    </main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
