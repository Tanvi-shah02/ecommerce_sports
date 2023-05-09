<?php
$contact_no = ot_get_option('contact_no');
$email = ot_get_option('email');

$india_office = ot_get_option('india_office_address');
$usa_office = ot_get_option('usa_office_address');
$africa_office = ot_get_option('africa_office_address');
?>
<section class="support-wrapper pb-5">
    <div class="container">
        <div class="row align-items-center pt1 mt-2 pt-md-5 mt-md-5">
            <div class="col-md-6 justify-content-between">
                <div class="title mb-4">
                    <h2 class="title-text text-dark"> <small class="d-block text-primary pb-2">Free 24/7 Support</small> Get Free &amp; Quality<br>
                        Online Consultation</h2>
                </div>
                <div class="supports-contact mb-3 mb-md-0">
                    <div class="media align-items-center mb-md-4 mb-0">
                        <div class="media-left mr-5 text-dark"> <i class="fa fa-phone-alt fa-3x"></i> </div>
                        <div class="media-body">
                            <h5 class="font-condensed">Call us</h5>
                            <h2 class="font-weight-light"><a href="tel:<?php echo $contact_no; ?>" class="text-dark"><?php echo $contact_no; ?> </a> </h2>
                        </div>
                    </div>
                    <div class="media align-items-center">
                        <div class="media-left mr-5 text-dark"> <i class="fa fa-envelope fa-3x"></i> </div>
                        <div class="media-body">
                            <h5 class="font-condensed">Email us</h5>
                            <h2 class="font-weight-light"><a href="mailto:<?php echo $email; ?>" class="text-dark"><?php echo $email; ?> </a> </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 offset-md-1">
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
            </div>
        </div>
    </div>
</section>