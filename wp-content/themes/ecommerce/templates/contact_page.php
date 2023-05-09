<?php
/**

 * Template Name: Contact Page

 */
get_header(); ?>
<?php
$page = get_post('');
$title = "";
$tag_line = "";
if(!empty($page)) {
    //echo "<pre>"; print_R($post); die;
    $title = $page->post_title;
    $head_line = get_post_meta($page->ID,'head-line', true);
    $tag_line = get_post_meta($page->ID,'tag-line', true);
    $content = $post->post_content;
}
?>
<?php
$contact_no = ot_get_option('contact_no');
$email = ot_get_option('email');

$india_office = ot_get_option('india_office_address');
$usa_office = ot_get_option('usa_office_address');
$africa_office = ot_get_option('africa_office_address');
?>
<section class="inner-page-wrapper pb-md-5">
        <div class="pageheaing-wrapper py-2 py-md-5"> 
            <div class="container">
                <div class="page-heading">
                    <h2 class="text-primary m-0">
                        <?php wp_title(''); ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="auto-container pt-4">
            <div class="container">
                <div class="entry-content service-content">
                    <div class="row">
                        <?php echo $content;?>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <?php if(!empty($india_office)){ ?>
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-left mr-4"><img src="<?php echo get_template_directory_uri(); ?>/images/assets/india.png" class="img-fluid" alt="India"/></div>
                                            <div class="media-body">
                                                <h5> India Office</h5>
                                                <p class="mb-0"><?php echo $india_office; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(!empty($usa_office)){ ?>
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-left mr-4"><img src="<?php echo get_template_directory_uri(); ?>/images/assets/usa.png" class="img-fluid" alt="India"/></div>
                                            <div class="media-body">
                                                <h5>USA Office</h5>
                                                <p class="mb-0"><?php echo $usa_office; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(!empty($africa_office)){ ?>
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-left mr-4"><img src="<?php echo get_template_directory_uri(); ?>/images/assets/kenya.png" class="img-fluid" alt="India"/></div>
                                            <div class="media-body">
                                                <h5>Africa Office </h5>
                                                <p class="mb-0"><?php echo $africa_office; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <?php $email = ot_get_option('email');
                                if(!empty($email)){ ?>
                                    <div class="col-md-6">
                                        <div class="media contact-media">
                                            <div class="media-left"> <span class="icon-circle d-flex justify-content-center align-items-center text-dark"> <i class="fas fa-envelope"></i></span> </div>
                                            <div class="media-body"> <span class="text-primary d-block text-uppercase">Mail Us</span> <a href="mailto:<?= $email ?>" class="text-body"><?= $email ?></a> </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php $contact_no = ot_get_option('contact_no');
                            if(!empty($contact_no)){ ?>
                                <div class="col-md-6 mt-3 mt-md-0">
                                <div class="media contact-media">
                                    <div class="media-left"> <span class="icon-circle d-flex justify-content-center align-items-center text-dark"> <i class="fas fa-phone-alt"></i></span> </div>
                                    <div class="media-body"> <span class="text-primary d-block text-uppercase">Call us</span> <a href="tel:<?= $contact_no ?>" class="text-body"><?= $contact_no ?></a> </div>
                                </div>
                                </div>
                            <?php } ?>

                            </div>
                        </div>
                        <div class="col-md-5">
                            <?php echo do_shortcode('[contact-form-7 id="86" title="Contact form 1"]')?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php get_footer(); ?>