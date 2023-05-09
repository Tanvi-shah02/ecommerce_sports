<div class="container">

    <div class="row row-small align-items-center">

        <div class="co1-12 col-lg-4 d-flex justify-content-between align-items-center">

            <a class="navbar-brand py-3" href="<?php echo site_url();?>">

                <img src="<?php echo ot_get_option('site_logo'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="img-fluid">

            </a>
              <div class="d-lg-none">
                    <a class="btn btn-primary" href="<?php echo get_permalink('160')?>">REQUEST DEMO</a>
                </div>

            <button class="navbar-toggler d-lg-none border-0 my-3" type="button" id="mobile_button" data-toggle="collapse" data-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>

        </div>

        <div class="col-lg-8 py-3 d-none d-md-flex justify-content-center justify-content-lg-end header-contacts">

            <?php $contact_no = ot_get_option('contact_number');
            if(!empty($contact_no)){ ?>
                <div class="media contact-media">
                    <div class="media-left"> <span class="icon-circle d-flex justify-content-center align-items-center text-dark">
                            <i class="fas fa-phone-alt"></i></span> </div>
                    <div class="media-body"> <span class="text-primary d-block text-uppercase">Call us</span>
                        <a href="tel:<?= $contact_no ?>" class="text-body"><?= $contact_no ?></a> </div>
                </div>
            <?php } ?>

            <?php $email = ot_get_option('email');
            if(!empty($email)){ ?>
            <div class="media contact-media ml-4">
                <div class="media-left"> <span class="icon-circle d-flex justify-content-center align-items-center text-dark">
                        <i class="fas fa-envelope"></i></span> </div>
                <div class="media-body"> <span class="text-primary d-block text-uppercase">Mail Us</span> <a href="mailto:<?= $email ?>" class="text-body"><?= $email ?></a> </div>
            </div>
            <?php } ?>

        </div>

    </div>

</div>