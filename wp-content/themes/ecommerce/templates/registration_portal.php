<?php

/**

 * Template Name: Registration Portal

 */

?>

<?php get_header(); ?>



<section class="login-wrapper d-flex justify-content-center align-items-center">

    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-7">

                <h4 class="text-uppercase my-2 my-md-4 text-center login-page-title"> Welcome to lvlup soccer registration portal</h4>

               <?php /*$obj = new UR_Shortcode_My_Account();
                     echo $obj->lost_password();
                */?>

                <a href="<?php echo get_permalink(32); ?>" class="card card-guest-member shadow-lg border-0 text-dark mb-2 mb-md-4 no-underline">
                    <div class="card-body p-3">
                        <div class="row justify-content-md-between align-items-center">
                            <div class="col-auto">
                                    <span
                                            class="icon-rounded bg-light d-flex justify-content-center align-items-center">
                                        <i class="la la-user la-2x text-dark"></i>
                                    </span>
                            </div>


                            <div class="col col-md">
                                <h5 class="text-dark login-sec-title">Register as a guest</h5>
                            </div>

                            <div class="col-auto">
                                <div class="arrow-icon">
                                    <i class="la la-angle-right la-2x"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>

                <div class="card card-register-member shadow-lg border-0">
                    <div class="card-body p-3">
                        <div class="row justify-content-md-between align-items-center">
                            <div class="col-auto">
                                    <span
                                            class="icon-rounded bg-light d-flex justify-content-center align-items-center">
                                        <i class="la la-user la-2x text-dark"></i>
                                    </span>
                            </div>

                           <div id="login_title" class="col col-md">
                                <h5 class="text-dark login-sec-title"> Login as a member</h5>
                                 <h6 class="font-medium login-sec-sub-title"> Dont have an account? <a href="javascript:void(0)"
                                         class="text-underline" id="signup_button">Sign up</a> </h6>
                            </div>

                            <div id="signup_title" class="col-auto col-md">
                                <h5 class="text-dark login-sec-title"> Sign up to become member</h5>
                                <h6 class="font-medium login-sec-sub-title"> Already have an account? <a href="javascript:void(0)"
                                 class="text-underline" id="login_button">Login</a></h6>
                            </div>

                            <div class="col-auto">
                                <div class="arrow-icon">
                                    <i class="la la-angle-right la-2x"></i>
                                </div>
                            </div>

                        </div>
                        
                        <div class="row">
                                <div class="col">

                              <div id="loginform">
                                  <?php echo do_shortcode( '[user_registration_my_account]' ); ?>
                                  <?php //echo lost_password(); ?>
                              </div>

                                <div id="signupform">
                                <?php echo do_shortcode( '[user_registration_form id="24"]' ); ?>
                                </div>

                                </div>
                            </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

<script>
    jQuery(function () {
        jQuery('#signup_title').hide();
        jQuery('#login_title').show();
        jQuery('#signupform').hide();
        jQuery('#loginform').show();
        jQuery( "#login_button" ).click(function() {
        jQuery('#signupform').hide();
        jQuery('#loginform').show();
        jQuery('#signup_title').hide();
        jQuery('#login_title').show();
        });

    jQuery( "#signup_button" ).click(function() {
        jQuery('#signupform').show();
        jQuery('#loginform').hide();
        jQuery('#signup_title').show();
        jQuery('#login_title').hide();
         });
    });
</script>