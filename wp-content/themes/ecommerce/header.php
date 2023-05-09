<!doctype html>
<html class="js">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--[if !IE]><!--> <script>
        if (/*@cc_on!@*/false) {
            document.documentElement.className += ' ie10';
        }
    </script>
    <!--<![endif]-->

    <?php wp_head(); ?>

</head>

<body <?php body_class() ;?> >

<section class="page-header py-2">
    <div class="container-xl">
        <div class="logo-conainer">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-2 d-flex justify-content-between">
                    <div class="brand-logo">

                       <?php if ( is_user_logged_in() ) { ?>
                           <a href="<?php echo get_permalink(32); ?>" class="text-dark no-underline">
                      <?php }else{ ?>
                           <a href="<?php echo get_permalink(22); ?>" class="text-dark no-underline">
                      <?php }?>
                              <!-- <h4 class="text-dark font-weight-bold mb-0">LVLUP</h4>-->


                         <img src="<?php echo ot_get_option('site_logo'); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"
                         class="img-fluid">

                        </a>
                    </div>
                        
                        <button class="navbar-toggler d-lg-none border-0 collapsed" type="button" data-toggle="collapse" data-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                   
                </div>
                <div class="col col-md-auto">
                    <nav class="navigation-wrapper navbar-light navbar navbar-expand-lg p-0 justify-content-end">

    
        <div id="mainNavigation" class="main-navigation ml-auto navbar-collapse collapse">
            

            <ul class="navbar-nav main-nav justify-content-start">
                <li class="nav-item"><a class="nav-link" href="<?php echo get_permalink(22); ?>">Home</a></li>
                <?php
                if ( is_user_logged_in() ) { ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo get_permalink(26); ?>">My Account</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
                <?php } ?>
            </ul>
            <div class="navbar-nav justify-content-start ml-md-5">
                <div class="contact-nav d-flex justify-content-between">

                    <?php $email = ot_get_option('email');
                    if(!empty($email)){ ?>
                  <a class="contact-link d-flex align-items-center justify-conten-center" href="mailto:<?= $email ?>"><i class="las la-envelope text-2xl mr-1"></i>
                  
                      <?= $email ?>
                      
                    </a>
                    <?php } ?>

                    <?php $phone_number = ot_get_option('phone_number');
                    if(!empty($phone_number)){ ?>
                  <a class="contact-link d-flex align-items-center justify-conten-center" href="tel:<?= $phone_number ?>"><i class="las la-mobile text-2xl mr-1"></i>
                      
                      <?= $phone_number ?> 
                      
                    </a>
                    <?php } ?>
             </div>

                <?php /*$socialLinks = ot_get_option('social_media'); */?><!--
                <?php /*if(!empty($socialLinks)){ */?>
                <div class="social-media d-flex justify-content-between align-items-center border-left ml-md-3 pl-md-3 mt-2 mt-md-0">
                        <?php /*foreach($socialLinks as $socialLink){ */?>
                            <?php /*if(!empty($socialLink['href']) && !empty($socialLink['title'])){ */?>
                                <a class="social-link" href="<?php /*echo $socialLink['href']; */?>" target="_blank">
                                    <?php /*echo $socialLink['title']; */?></a>
                            <?php /*} */?>
                        <?php /*} */?>
                </div>
                --><?php /*} */?>

             <!-- <div class="social-media d-flex justify-content-between align-items-center border-left ml-md-3 pl-md-3 mt-2 mt-md-0">
                  <a class="social-link" href="#"><i class="lab la-facebook-f"></i></a>
                  <a class="social-link" href="#"><i class="lab la-youtube"></i></a>
                  <a class="social-link" href="#"><i class="lab la-instagram"></i></a>
                  <a class="social-link" href="#"><i class="lab la-linkedin-in"></i></a>
             </div>-->
                 
              
            </div>

                    <?php
                   /* if( has_nav_menu('primary') ){
                        wp_nav_menu( array('theme_location'=>'primary', 'menu_class'=> 'navbar-nav main-nav justify-content-start', 'container'=> '') );
                    }*/
                    ?>
        </div>
   

</nav>
                </div>
            </div>

        </div>
    </div>
</section>

<?php if(is_user_logged_in()){ ?>
    <?php get_template_part( 'template-parts/header/mainmenu', 'header' ); ?>
<?php } ?>

<!--<header id="header" class="header">
    <?php /*get_template_part( 'template-parts/header/branding', 'header' ); */?>
    <?php /*get_template_part( 'template-parts/header/mainmenu', 'header' ); */?>
</header>-->

