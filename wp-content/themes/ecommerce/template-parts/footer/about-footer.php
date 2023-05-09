<div class="col-lg-4">
    <div class="footer-widget text-center text-md-left">
        <?php $logo = ot_get_option('footer_logo');
        if(!empty($logo)){
        ?>
        <div class="footer-widget-logo mb-3">
            <img src="<?php echo $logo; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="img-fluid">
        </div>
        <?php } ?>

        <?php $about = ot_get_option('about_content');
        if(!empty($about)) {
            echo $about;
        } ?>

        <?php $socialLinks = ot_get_option('social_links'); ?>
        <?php if(!empty($socialLinks)){ ?>
            <ul class="social-links list-inline">
                <?php foreach($socialLinks as $socialLink){ ?>
                    <?php if(!empty($socialLink['href']) && !empty($socialLink['title'])){ ?>
                        <li class="list-inline-item">
                            <a class="nav-link" href="<?php echo $socialLink['href']; ?>" title="<?php echo $socialLink['name']; ?>" target="_blank">
                                <?php echo $socialLink['title']; ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        <?php } ?>
        <!--<ul class="social-links list-inline">
            <li class="list-inline-item"><a class="nav-link" href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li class="list-inline-item"><a class="nav-link" href="#"><i class="fab fa-twitter"></i></a></li>
            <li class="list-inline-item"><a class="nav-link" href="#"><i class="fab fa-google-plus-g"></i></a> </li>
            <li class="list-inline-item"><a class="nav-link" href="#"><i class="fab fa-linkedin-in"></i></a> </li>
        </ul>-->
    </div>
</div>