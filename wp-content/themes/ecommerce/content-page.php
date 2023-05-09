<?php

/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
		// Post thumbnail.
		//twentyfifteen_post_thumbnail();
        
	?>
  <section class="inner-page-wrapper pb-md-5">
    <div class="pageheaing-wrapper py-3 bg-primary-light">
      <div class="container">
        <div class="page-heading">
          <h4 class="text-dark m-0">
            <?php wp_title(''); ?>
          </h4>
        </div>
      </div>
    </div>
    <div class="auto-container pt-4">
      <div class="container">
        <div class="entry-content service-content">
            <div class="row mb-4">
            <?php if ( has_post_thumbnail() ) { ?>
				<div class="col-md">
                  <div class="service-image mb-3">
                    <?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid' ) );?>
                    </div>
                </div>
			<?php }?>
            
                <div class="col-md">
                 <div class="service-info">
                    <?php
                    $sub_title = get_post_meta( get_the_ID(), 'wpcf-sub-title-line', true ); ?>
                    <h4><?php echo $sub_title; ?></h4>
                    <?php $short_description = get_post_meta( get_the_ID(), 'wpcf-short-descriptions', true );
                        echo $short_description;
                    ?>
                </div>
                </div>
            </div>
          <?php the_content(); ?>
          <?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
        </div>
        <!-- .entry-content --> 
      </div>
    </div>
  </section>
  <?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
</article>
<!-- #post-## --> 
