<?php
session_start();

/**

 * Template Name: Purchase

 */

?>

<?php get_header(); ?>



<style>
    * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    iframe {
        margin: 0;
        padding: 0;
        border: 0;
    }
    
    button {
        border: 0;
    }
    
    hr {
        height: 1px;
        border: 0;
        background-color: #CCC;
    }
    
    fieldset {
        margin: 0;
        padding: 0;
        border: 0;
    }
    
    #form-container {
        position: relative;
    }
    
    .third {
        float: left;
        width: calc((100% - 32px) / 3);
        padding: 0;
        margin: 0 16px 16px 0;
    }
    
    .third:last-of-type {
        margin-right: 0;
    }
    
    /* Define how SqPaymentForm iframes should look */
    .sq-input {
        box-sizing: border-box;
        border: 1px solid #3c3c3c;
        border-radius: 0.25rem;
        width: 100%;
        height: calc(1.5em + 1.75rem + 2px);
        outline-offset: -2px;
        display: inline-block;
        -webkit-transition: border-color .2s ease-in-out, background .2s ease-in-out;
        -moz-transition: border-color .2s ease-in-out, background .2s ease-in-out;
        -ms-transition: border-color .2s ease-in-out, background .2s ease-in-out;
        transition: border-color .2s ease-in-out, background .2s ease-in-out;
    }
    
    /* Define how SqPaymentForm iframes should look when they have focus */
    .sq-input--focus {
        border: 1px solid #cecece;
        background-color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.15);
    }
    
    /* Define how SqPaymentForm iframes should look when they contain invalid values */
    .sq-input--error {
        border: 1px solid #E02F2F;
        background-color: rgba(244, 47, 47, 0.02);
    }
    
    #sq-card-number {
        margin-bottom: 16px;
    }
    
    #error {
        width: 100%;
        margin-top: 16px;
        font-size: 18px;
        color: red;
        font-weight: 300;
        text-align: center;
        opacity: 0.8;
    }
    
    @media (min-width:768px){
        .sq-card-wrapper .sq-card-iframe-container{
    max-height:50px;
}
        
    }

</style>

<script
        type="text/javascript"
        src="https://web.squarecdn.com/v1/square.js"
></script>
<!--<script type="text/javascript" src="./server.js"></script>-->
<script>
    var total = 0;
    var insertid = 0;
    const appId = 'sq0idp-mYi_g4OsW8UWCkDgE5OZWA';
    const locationId = 'L863H2RSDBWCV';
       //const locationId = 'L8V48DSHQEZDY';

    async function initializeCard(payments) {
        const card = await payments.card();
        await card.attach('#card-container');

        return card;
    }

    async function createPayment(token) {
         var amountt =  total * 100;
         //console.log(parseInt(amountt));
       
        const body = {
            locationId,
            sourceId: token,
            //sourceId: 'cnon:card-nonce-ok',
            amount: parseInt(amountt),
        };
        var result = createServerPayment(body);
        return result;
        //return false;
    }

    async function tokenize(paymentMethod) {
        const tokenResult = await paymentMethod.tokenize();
        if (tokenResult.status === 'OK') {
            return tokenResult.token;
        } else {
            let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
            if (tokenResult.errors) {
                errorMessage += ` and errors: ${JSON.stringify(
                    tokenResult.errors
                )}`;
            }

            throw new Error(errorMessage);
        }
    }

    document.addEventListener('DOMContentLoaded', async function () {
        if (!window.Square) {
            throw new Error('Square.js failed to load properly');
        }

        let payments;
        try {
            payments = window.Square.payments(appId, locationId);
        } catch {
            const statusContainer = document.getElementById(
                'payment-status-container'
            );
            statusContainer.className = 'missing-credentials';
            statusContainer.style.visibility = 'visible';
            return;
        }

        let card;
        try {
            card = await initializeCard(payments);
        } catch (e) {
            console.error('Initializing Card failed', e);
            return;
        }

        // Checkpoint 2.
        async function handlePaymentMethodSubmission(event, paymentMethod) {
            event.preventDefault();

            try {
                cardButton.disabled = true;
                const token = await tokenize(paymentMethod);
                const paymentResults = await createPayment(token);
               // displayPaymentResults('SUCCESS');
                console.log('Payment Success', paymentResults);

                if(typeof paymentResults.errors !== 'undefined'){
                    jQuery( '#card-error' ).show();
                    jQuery( '#card-error' ).html( paymentResults.errors[0].detail );
                }else{
                    jQuery( '#orderid' ).html( paymentResults.payment.id );

                    jQuery( "#wizardStep2" ).removeClass( "active" );
                    jQuery( "#wizardStep3" ).addClass( "active" );
                    jQuery( "#wizardStep-2" ).removeClass( "active" );
                    jQuery( "#wizardStep-3" ).addClass( "active" );
                    
                    jQuery( "#wizardStep4" ).addClass( "disabled" );
                        jQuery( "#wizardStep4" ).click( function () {
                            jQuery( "#payment-section" ).hide();
                            jQuery( "#promo-code-section" ).hide();
                            jQuery( "#paymentbutt-section" ).hide();
                            jQuery( "#first-section" ).addClass( "col-lg-12" );
                            jQuery( "#first-section" ).removeClass( "col-lg-8" );
                        } );

                        jQuery( "#wizardStep1" ).addClass( "disabled" );
                        jQuery( "#wizardStep1" ).click( function () {
                            jQuery( "#payment-section" ).hide();
                            jQuery( "#promo-code-section" ).hide();
                            jQuery( "#paymentbutt-section" ).hide();
                            jQuery( "#first-section" ).addClass( "col-lg-12" );
                            jQuery( "#first-section" ).removeClass( "col-lg-8" );
                        } );

                        jQuery( "#wizardStep2" ).addClass( "disabled" );
                        jQuery( "#wizardStep2" ).click( function () {
                            jQuery( "#payment-section" ).hide();
                            jQuery( "#promo-code-section" ).hide();
                            jQuery( "#paymentbutt-section" ).hide();
                            jQuery( "#first-section" ).removeClass( "col-lg-8" );
                            jQuery( "#first-section" ).addClass( "col-lg-12" );
                        } ); 

                    jQuery( "#payment-section" ).hide();
                    jQuery( "#first-section" ).removeClass( "col-lg-8" );
                    jQuery( "#first-section" ).addClass( "col-lg-12" );

                    var paymentjson = JSON.stringify( paymentResults );

                    jQuery.ajax( {

                        type: 'POST',
                        url: '/wp-admin/admin-ajax.php',
                        dataType: 'text',
                        data: {
                            action: 'payment_success',
                            payment: paymentjson,
                            id: insertid,
                        },

                        success: function ( res ) {
                                /*jQuery( "#payment-section" ).hide();
                                jQuery( "#first-section" ).removeClass( "col-lg-8" );
                                jQuery( "#first-section" ).addClass( "col-lg-12" );*/
                                
                            jQuery( "#wizardStep4" ).addClass( "disabled" );
                             jQuery( "#wizardStep4" ).click( function () {
                            jQuery( "#payment-section" ).hide();
                            jQuery( "#promo-code-section" ).hide();
                            jQuery( "#paymentbutt-section" ).hide();
                            jQuery( "#first-section" ).addClass( "col-lg-12" );
                            jQuery( "#first-section" ).removeClass( "col-lg-8" );
                        } );

                        jQuery( "#wizardStep1" ).addClass( "disabled" );
                        jQuery( "#wizardStep1" ).click( function () {
                            jQuery( "#payment-section" ).hide();
                            jQuery( "#promo-code-section" ).hide();
                            jQuery( "#paymentbutt-section" ).hide();
                            jQuery( "#first-section" ).addClass( "col-lg-12" );
                            jQuery( "#first-section" ).removeClass( "col-lg-8" );
                        } );

                        jQuery( "#wizardStep2" ).addClass( "disabled" );
                        jQuery( "#wizardStep2" ).click( function () {
                            jQuery( "#payment-section" ).hide();
                            jQuery( "#promo-code-section" ).hide();
                            jQuery( "#paymentbutt-section" ).hide();
                            jQuery( "#first-section" ).removeClass( "col-lg-8" );
                            jQuery( "#first-section" ).addClass( "col-lg-12" );
                        } );    
                        
                        }
                    } )
                }


            } catch (e) {
                cardButton.disabled = false;
               // displayPaymentResults('FAILURE');
                console.error(e.message);
            }
        }

        const cardButton = document.getElementById('card-button');
        cardButton.addEventListener('click', async function (event) {
            await handlePaymentMethodSubmission(event, card);
        });
    });
</script>


<section class="register-wrapper">

    <div class="container-xl">

        <div class="register-card card border-0 mt-3">

            <div class="card-body px-0">

                <div class="row">



                    <div class="col-lg-8 mb-3 mb-lg-0" id="first-section">



                        <ul id="ultab" class="wizard-nav nav nav-tabs d-flex list-unstyled mb-3">

                            <li class="wizard-nav-item">

                                <a href="#wizardStep-1" id="wizardStep1" data-toggle="tab" class="wizard-nav-link active">

                                    <span class="wizard-num">1</span>

                                    Program

                                </a>

                            

                            </li>

                            <li class="wizard-nav-item">

                                <a href="#wizardStep-4" id="wizardStep4" data-toggle="tab" class="wizard-nav-link disabled">

                                    <span class="wizard-num">2</span>

                                    Information</a>

                            

                            </li>


                            <li class="wizard-nav-item">

                                <a href="#wizardStep-2" id="wizardStep2" data-toggle="tab" class="wizard-nav-link disabled">

                                    <span class="wizard-num">3</span>

                                    Payment</a>

                            

                            </li>

                            <li class="wizard-nav-item">

                                <a href="#wizardStep-3" id="wizardStep3" data-toggle="tab" class="wizard-nav-link disabled">

                                    <span class="wizard-num">4</span>

                                    Order Complete

                                </a>

                            

                            </li>

                        </ul>


                        <?php $complete_status = $_GET['payment_status']; ?>
                        <input type="hidden" id="payment_success" name="payment_success" value="<?php echo $complete_status; ?>">

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="wizardStep-1">

                                <div class="wizard-heading my-4">

                                    <h5 class="text-dark">Select Program</h5>

                                </div>



                                <div class="form-module">
                                    <form action="">
                                        <div class="row">
                                            
                                               <div class="col-md-4"> 
                                       
                                        <?php $pcategories = get_categories( array(
                                            'taxonomy' => 'program_category',
                                        ) ); ?>
                                           
                                          

                                        <div class="form-group">
                                            <select name="program_name" id="program_name" class="custom-select">
                                                <option selected value="">Select Season</option>
                                                <?php foreach($pcategories as $cat){ ?>
                                                <option value="<?php echo $cat->term_id; ?>">
                                                    <?php echo $cat->name; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                              
                                               </div>
                                               <div class="col-md-4">

                                        <?php $rcategories = get_categories( array(
                                                'taxonomy' => 'region_category',
                                            ) ); ?>
                                                
                                              

                                        <div class="form-group">
                                            <select name="region_name" id="region_name" class="custom-select">
                                                <option selected value="">Select Region</option>
                                                <?php foreach($rcategories as $cat){ ?>
                                                <option value="<?php echo $cat->term_id; ?>">
                                                    <?php echo $cat->name; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                                   
                                                    </div>                                            
                                               <div class="col-md-4">

                                        <?php $acategories = get_categories( array(
                                                'taxonomy' => 'age_category',
                                            ) ); ?>

                                        <div class="form-group">
                                            <select name="age_name" id="age_name" class="custom-select">
                                                <option selected value="">Select Player Age</option>
                                                <?php foreach($acategories as $cat){ ?>
                                                <option value="<?php echo $cat->term_id; ?>">
                                                    <?php echo $cat->name; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                       
                                              </div>
                                             </div>
                                            </div>
                                    </form>
                                </div>



                                <div class="alert alert-success" id="alert-tab" role="alert">
                                    Item is added to cart.
                                </div>



                                <div class="programs-module-wrapper">

                                    <div class="programs-heading my-4">

                                        <h5 class="text-dark">Available Programs</h5>

                                        <hr>

                                    </div>



                                    <div class="programs-module">

                                        <div id="filter_programs"></div>

                                    </div>



                                </div>

                            </div>





                            <div class="tab-pane fade show" id="wizardStep-2">
                                <!--<div class="wizard-heading mb-5">
                                    <h5 class="text-dark">Step 02</h5>
                                </div>-->

                                <form id="payment-form">
                                    <div id="card-container"></div>
                                    <button id="card-button" type="button"></button>
                                    <div id="card-error" class="primary mt-3"></div>
                                </form>
                                
                                 <div id="card-error-default" class="text-danger text-center mt-3">Please don't
                                    refresh or go back until the payment is processed.</div>

                            </div>

                       



                        <div class="tab-pane fade show" id="wizardStep-3">

                            <section class="register-wrapper py-5 circles">

                                <div class="container-xl">

                                    <div class="title mb-2 mb-md-4 wow fadeInUp text-center">

                                        <span class="sub-title-text"></span>

                                        <h2 class="title-text">Payment Success</h2>

                                    </div>

                                    <div class="register-card card border-0 bg-secondary1 mt-5 text-center">

                                        <div class="card-body p-3 p-md-5">

                                            <h2 class="pb-3 font-light display-4">Thank You</h2>

                                            <h5 class="font-light pb-5">Your Transaction Id is <span class="transection_id border border-light rounded d-inine-block py-1 px-3" id="orderid"></span> </h5>

                                            <a href="<?php echo get_permalink(32); ?>" class="btn btn-outline-primary">Go To Home</a>

                                        </div>

                                    </div>

                                </div>

                            </section>

                        </div>

                        <div class="tab-pane fade show" id="wizardStep-4">

                            <div class="wizard-heading pt-3 mb-3">
                                <h5 class="text-dark">Parent Information</h5>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="First Name*" class="form-control" id="guardian_fname" name="guardian_fname" required>
                                        <div class="text-danger" id="guardian_fname_err"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Last Name*" class="form-control" id="guardian_lname" name="guardian_lname" required>
                                        <div class="text-danger" id="guardian_lname_err"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Phone*" class="form-control textto_numbers" id="guardian_phone" name="guardian_phone" pattern="" required>
                                        <div class="text-danger" id="guardian_phone_err"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="email" placeholder="Email*" class="form-control" id="guardian_email" name="guardian_email" required>
                                        <div class="text-danger" id="guardian_email_err"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Address*" class="form-control" id="guardian_address" name="guardian_address" required>
                                        <!--<textarea class="form-control" placeholder="Address" id="guardian_address" name="guardian_address" rows="4" cols="95" ></textarea>-->
                                        <div class="text-danger" id="guardian_address_err"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="wizard-heading pt-3 mb-3">
                                <h5 class="text-dark">Player Information</h5>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="First Name*" class="form-control" id="player_fname" name="player_fname" required>
                                        <div class="text-danger" id="player_fname_err"></div>
                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Last Name*" class="form-control" id="player_lname" name="player_lname" required>
                                        <div class="text-danger" id="player_lname_err"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="date" placeholder="Birthday*" class="form-control" id="player_birthdate" name="player_birthdate" required>
                                        <div class="text-danger" id="player_birthday_err"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select name="player_gender" id="player_gender" class="custom-select" required>
                                            <option value="" selected>Select Gender*</option>
                                            <?php $player_gender = ot_get_option('gender');
                                                 if(!empty($player_gender)){
                                                     $player_g = (explode(",",$player_gender));
                                                     foreach($player_g as $pg){
                                                         ?>
                                            <option value="<?php echo trim($pg," "); ?>">
                                                <?php echo trim($pg," "); ?>
                                            </option>
                                            <?php }} ?>
                                        </select>

                                        <!--  <input type="text" placeholder="Gender" class="form-control" id="player_gender" name="player_gender">-->
                                        <div class="text-danger" id="player_gender_err"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="colFormLabel" class="col-form-label1 text-l">Does the player have any medical conditions we should be aware of?
                                            If so, what medication will they have with them at training?* </label>

                                    <input type="text" class="form-control" id="emergency_detail" name="emergency_detail" required>
                                    <!--  <textarea class="form-control" id="emergency_detail" name="emergency_detail" rows="4" cols="9" required></textarea>-->
                                    <div class="text-danger" id="emergency_detail_err"></div>
                                </div>
                            </div>

                            <div class="wizard-heading pt-3 mb-3">
                                <h5 class="text-dark">Emergency Contact</h5>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="First Name*" class="form-control" id="emergency_fname" name="emergency_fname" required>
                                        <div class="text-danger" id="emergency_fname_err"></div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Last Name*" class="form-control" id="emergency_lname" name="emergency_lname" required>
                                        <div class="text-danger" id="emergency_lname_err"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Phone*" class="form-control textto_numbers" id="emergency_phone" name="emergency_phone" pattern="">
                                        <div class="text-danger" id="emergency_phone_err"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="wizard-heading pt-3 mb-3">
                                <h5 class="text-dark">Soccer Kit</h5>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select name="soccer_kit_size" id="soccer_kit_size" class="custom-select" required>
                                            <option value="" selected>Select Size:</option>
                                            <?php $itemName = ot_get_option('item_name');
                                            if(!empty($itemName)){
                                                $i = 0;
                                            foreach($itemName as $itemN){
                                                if(!empty($itemN['name']) && !empty($itemN['title'])){ ?>
                                            <option value="<?php echo $itemN['title']; ?>">
                                                <?php echo $itemN['name']; ?>
                                            </option>
                                            <?php  $i++; }}} ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="colFormLabel" class="col-form-label1 text-l">New players are required to buy the full kit.
                                        This is a one time fee of 50$ and players will be reusing the uniform
                                        in following seasons.</label>
                                    <div class="text-danger" id="soccer_size_err"></div>
                                </div>

                            </div>


                        </div>

                       <!-- <div class="tab-pane fade show" id="wizardStep-5">

                            <div class="wizard-heading mb-5">

                                <h5 class="text-dark">Step 05</h5>

                            </div>

                        </div>

                        <div class="tab-pane fade show" id="wizardStep-6">

                            <div class="wizard-heading mb-5">

                                <h5 class="text-dark">Step 06</h5>

                            </div>

                        </div>-->

                    </div>

                </div>





                <div class="col-lg-4" id="payment-section">



                    <div class="card borde-0 mb-4">

                        <div class="card-body">

                            <h5 class="text-dark">Order Summary</h5>

                            <div class="cart-summary mt-3">

                                <div class="d-flex justify-content-between align-items-center py-2">

                                    <span>Original Price</span>

                                    <span id="original_price">CAD 00.00</span>

                                </div>


                                <div class="d-flex justify-content-between align-items-center py-2">

                                    <span>Soccer Kit</span>

                                    <span id="soccer_kit_billing">CAD 00.00</span>

                                </div>
                                
                                    <div class="d-flex justify-content-between align-items-center py-2">

                                    <span>HST</span>

                                    <span id="tax_price">CAD 00.00</span>

                                </div>


                                <!--<div class="d-flex justify-content-between align-items-center py-2">
                                        <span>Uniform</span> <span>--</span>
                                    </div>-->

                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span>Promotional Discount</span>
                                    <span id="discount-price">CAD 00.00</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center py-2">

                                    <span class="text-dark font-weight-bold">Total </span>

                                    <span class="text-dark font-weight-bold" id="total_price">CAD 00.00</span>

                                </div>

                            </div>

                        </div>

                    </div>




                    <div class="card borde-0 mb-4">
                        <div class="card-body">
                            <h5 class="text-dark">Order Details</h5>
                            <hr>
                            <div class="order-details-module">
                                <ul class="list-group list-group-flush" id="selected_programs">
                                    <!--<div id="selected_programs"></div>-->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="promo-code-section">
                        <div class="input-group input-group-sm my-3">
                            <input type="text" name="coupon-name" id="coupon-name" class="form-control" placeholder="Enter your promo code">
                            <div class="input-group-append">
                                <button class="btn btn-light" id="apply-coupon" type="button">Apply</button>
                            </div>
                        </div>
                        <p id="apply-coupon-err"></p>
                    </div>

                    <div id="paymentbutt-section">
                        <?php $upload_dir = wp_upload_dir(); ?>

                        <div class="col-sm-12">
                            <input type="checkbox" id="termscond" name="termscond">
                            <label for="termscond"> I agree to the
                                <a href="<?php echo $upload_dir['baseurl'].'/2023/02/ecommerce-Terms-and-Conditions-.pdf'; ?>" target="_blank">
                                    Terms and Conditions</a>
                            </label><br>
                            <div class="text-danger" id="tems_cond_err"></div>

                            <input type="checkbox" id="liability_consent" name="liability_consent">
                            <label for="liability_consent"> I agree to the
                                <a href="<?php echo $upload_dir['baseurl'].'/2022/09/CONSENT-AND-LIABILITY-WAIVER-RELEASE-FORM.pdf'; ?>" target="_blank">
                                    Consent and Liability Waiver</a>
                            </label><br>
                            <div class="text-danger" id="liability_consent_err"></div>
                            
                             <input type="checkbox" id="refund_cancel" name="refund_cancel">
                            <label for="refund_cancel"> I agree to the
                                <a href="<?php echo $upload_dir['baseurl'].'/2023/02/Policies.pdf'; ?>" target="_blank">
                                    Refund and Cancellation Policy</a>
                            </label><br>
                            <div class="text-danger" id="refund_cancel_err"></div>
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-sm-12">
                                <div class="g-recaptcha" data-sitekey="6LcXc18jAAAAAOFkUNioLAZbRIfhDjvTub_o5itx">
                                </div>
                                <div class="text-danger" id="captcha_err"></div>
                            </div>
                        </div>

                        <a href="javascript:void(0)" id="payment-button" class="btn btn-primary btn-block">Payment</a>
                        <div class="payment-option-img mt-4 w-50">
                            <img src="<?php echo ot_get_option('payment_option'); ?>" alt="payment options" class="img-fluid">
                        </div>
                    </div>


                </div>

            </div>

        </div>


    </div>

    </div>


    <!--</div>

    </div>-->

</section>

<div class="modal fade" id="spotModal" tabindex="-1" role="dialog" aria-labelledby="spotModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header py-3 border-light">
                <h5 class="modal-title" id="spotModallLabel">Contact Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="p-3 pb-0">
                    <?php echo do_shortcode('[contact-form-7 id="98" title="Looking for a spot"]') ?>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>

<div class="modal fade" id="notOpenModal" tabindex="-1" role="dialog" aria-labelledby="notOpenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header py-3 border-light">
                <h5 class="modal-title" id="notOpenModalLabel">Contact Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="p-3 pb-0">
                    <?php echo do_shortcode('[contact-form-7 id="140" title="Not open yet"]') ?>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>


<?php get_footer(); ?>



<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    jQuery( document ).ready( function () {

        jQuery( '.textto_numbers' ).keyup( function () {
            this.value = this.value.replace( /[^0-9\.]/g, '' );
        } );

        jQuery( '#alert-tab' ).hide();
        jQuery( '#paymentbutt-section' ).hide();
        jQuery( '#card-error' ).hide();
        //jQuery("#wizardStep1").addClass("active");

        var payment_success = jQuery( '#payment_success' ).val();

        if ( payment_success == 'successful' ) {
            jQuery( "#wizardStep1" ).addClass( "disabled" );

            jQuery( "#wizardStep1" ).removeClass( "active" );
            jQuery( "#wizardStep3" ).addClass( "active" );
            jQuery( "#wizardStep-1" ).removeClass( "active" );
            jQuery( "#wizardStep-3" ).addClass( "active" );

            jQuery( "#payment-section" ).hide();
            jQuery( "#first-section" ).removeClass( "col-lg-8" );
            jQuery( "#first-section" ).addClass( "col-lg-12" );
        }

            jQuery( "#age_name" ).change( function () {
            var program_id = jQuery( '#program_name' ).val();
            var region_id = jQuery( '#region_name' ).val();
            var age_id = jQuery( '#age_name' ).val();
            jQuery.ajax( {
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                dataType: 'html',
                data: {
                    action: 'programs_filter',
                    programcat: program_id,
                    regioncat: region_id,
                    agecat: age_id,
                },
                success: function ( res ) {
                    jQuery( '#filter_programs' ).html( res );
                }
            } )
        } );

        jQuery( "#program_name" ).change( function () {
            var program_id = jQuery( '#program_name' ).val();
            var region_id = jQuery( '#region_name' ).val();
            var age_id = jQuery( '#age_name' ).val();
            if ((region_id != '') &&  (age_id != '') ) {
                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    dataType: 'html',
                    data: {
                        action: 'programs_filter',
                        programcat: program_id,
                        regioncat: region_id,
                        agecat: age_id,
                    },
                    success: function (res) {
                        jQuery('#filter_programs').html(res);
                    }
                })
            }
        } );

        jQuery( "#region_name" ).change( function () {
            var program_id = jQuery( '#program_name' ).val();
            var region_id = jQuery( '#region_name' ).val();
            var age_id = jQuery( '#age_name' ).val();
            if ((age_id != '') &&  (program_id != '') ) {
                jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    dataType: 'html',
                    data: {
                        action: 'programs_filter',
                        programcat: program_id,
                        regioncat: region_id,
                        agecat: age_id,
                    },
                    success: function (res) {
                        jQuery('#filter_programs').html(res);
                    }
                })
            }
        } );


        var sum = 0;
        var tax = 0;
     //   var total = 0;
        var orders = {};
        var products = [];
        //var amount = 0;

       jQuery( document ).on( "click", "#btn-soldout", function () {
           var name = jQuery( this ).attr( 'data-name' );
           //alert(name);
           jQuery( '#programname' ).val( name );
        });
        
          jQuery( document ).on( "click", "#btn-notifyme", function () {
            var name = jQuery( this ).attr( 'data-name' );
            //alert(name);
            jQuery( '#programnamee' ).val( name );
        });

        document.addEventListener('wpcf7submit', function(event) {
            setTimeout(function() {
                jQuery('form.wpcf7-form').removeClass('sent');
                jQuery('form.wpcf7-form').removeClass('failed');
                jQuery('form.wpcf7-form').addClass('init');
            }, 3000);

        }, false);

      

        jQuery( document ).on( "click", ".btn-select", function () {
            jQuery( '#paymentbutt-section' ).show();

            var id = jQuery( this ).attr( 'id' );
            var price = jQuery( this ).attr( 'data-price' );
            var pri = price.split( '$' );

            tax = tax + ( parseInt( pri[ 0 ] ) * 0.13 );
            jQuery( '#tax_price' ).html( "CAD " + tax.toFixed( 2 ) );

            sum = sum + parseInt( pri[ 0 ] );
            total = sum + tax ;
            //total = total + tax + sum;

            jQuery( '#original_price' ).html( "CAD " + sum.toFixed( 2 ) );
            jQuery( '#total_price' ).html( "CAD " + total.toFixed( 2 ) );
            jQuery( '#card-button' ).html( "CAD " + total.toFixed( 2 ) );
            //jQuery( '#sq-creditcard' ).html( "Pay C$" + total.toFixed( 2 ) );

            //jQuery( '#card-button' ).html( "Pay $" + total.toFixed( 2 ) );
            //amount = total.toFixed( 2 );


            jQuery( '#alert-tab' ).show();
            jQuery( '#alert-tab' ).delay( 2000 ).fadeOut();


            jQuery.ajax( {

                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                dataType: 'html',
                data: {
                    action: 'programs_selected',
                    programid: id,
                },

                success: function ( res ) {

                    var booked_data = JSON.parse( res );
                    
                    var selected_data = '<li class="list-group-item px-0">';
                    selected_data += '<div class="media">';

                    /*  selected_data += '<div class="media-left mr-3">';
                      //selected_data += booked_data.image;
                      selected_data += '<img src="'+booked_data.image+'" alt="Program" class="img-fluid">';
                      selected_data += '</div>';*/

                    selected_data += '<div class="media-body">';
                    selected_data += '<h6>' + booked_data.post_title + '</h6>';
                    selected_data += '<p>' + booked_data.post_content + '</p>';
                    selected_data += '</div>';

                    selected_data += '</div>';
                    selected_data += '</li>';

                    jQuery( '#selected_programs' ).append( selected_data );
                    
                    booked_data.post_content = "";

                    orders[ "item_count" ] = products.push( booked_data );
                    orders[ "programs" ] = products;
                    //orders[ "total_price" ] = "$" + sum.toFixed( 2 );
                    orders[ "total_price" ] = "CAD " + total.toFixed( 2 );
                    orders[ "original_price" ] = "CAD " + sum.toFixed( 2 );

                    jQuery( "#wizardStep4" ).removeClass( "disabled" );
                    jQuery( '#wizardStep4' ).click();

                    /*jQuery("#wizardStep1").removeClass("active");
                    jQuery("#wizardStep4").addClass("active");
                    jQuery("#wizardStep-1").removeClass("active");
                    jQuery("#wizardStep-4").addClass("active");*/
                }
            } )
        } );
        
          var soccer_kit_size = 0;
          
        jQuery( "#soccer_kit_size" ).change( function () {
            var temp_price = soccer_kit_size;
            var temp_tax = (soccer_kit_size * .13);
            soccer_kit_size = parseInt( jQuery( '#soccer_kit_size' ).val() );
            var soccer_kit_sizee = (soccer_kit_size * 0.13);
            var s_sizee =  soccer_kit_size + soccer_kit_sizee;
            
             tax = tax + ( soccer_kit_size * 0.13 );
             tax = tax - temp_tax;
            jQuery( '#tax_price' ).html( "CAD " + tax.toFixed( 2 ) );

            jQuery( '#soccer_kit_billing' ).html( "CAD " + soccer_kit_size.toFixed( 2 ) );
            total = total + s_sizee;
            total = total - temp_price;
            total = total - temp_tax;
            jQuery( '#total_price' ).html( "CAD " + total.toFixed( 2 ) );
            jQuery( '#card-button' ).html( "CAD " + total.toFixed( 2 ) );
            
        } );
        
        var error_count = 0;

        jQuery( "#payment-button" ).click( function () {
            console.log( orders );
            var json = JSON.stringify( orders );

            var guardian_fname = jQuery( '#guardian_fname' ).val();
            var guardian_lname = jQuery( '#guardian_lname' ).val();
            var guardian_phone = jQuery( '#guardian_phone' ).val();
            var guardian_email = jQuery( '#guardian_email' ).val();
            var guardian_address = jQuery( '#guardian_address' ).val();

            var player_fname = jQuery( '#player_fname' ).val();
            var player_lname = jQuery( '#player_lname' ).val();
            //var player_birthday = jQuery('#player_birthdate').val();
            var player_birthday = new Date( jQuery( '#player_birthdate' ).val() );
            var player_gender = jQuery( '#player_gender' ).val();
            var emergency_detail = jQuery( '#emergency_detail' ).val();

            var emergency_fname = jQuery( '#emergency_fname' ).val();
            var emergency_lname = jQuery( '#emergency_lname' ).val();
            var emergency_phone = jQuery( '#emergency_phone' ).val();
            //var soccer_kit = jQuery('#soccer_kit').val();
            var soccer_kit = jQuery( '#soccer_kit_size' ).val();
            var soccer_kit_name = jQuery( '#soccer_kit_size option:selected' ).text().trim();
            //console.log(soccer_kit_name);

            var terms = jQuery( 'input[name="termscond"]:checked' ).val();
            var consent = jQuery( 'input[name="liability_consent"]:checked' ).val();
            var policy = jQuery( 'input[name="refund_cancel"]:checked' ).val();

            var response = grecaptcha.getResponse();
            //alert(response);
            
            if( guardian_fname == ''){
                jQuery( '#guardian_fname_err' ).html( "Please enter guardian's first name" ); 
                error_count++;
            }else{
                 jQuery( '#guardian_fname_err' ).html( "" ); 
                 error_count = 0;
            }
            
            if( guardian_lname == ''){
                jQuery( '#guardian_lname_err' ).html( "Please enter guardian's last name" ); 
                error_count++;
            }else{
                 jQuery( '#guardian_lname_err' ).html( "" ); 
                  error_count = 0;
            }
            
            if( guardian_phone == ''){
                jQuery( '#guardian_phone_err' ).html( "Please enter guardian's phone number" ); 
                error_count++;
            }else{
                 jQuery( '#guardian_phone_err' ).html( "" ); 
                 error_count = 0;
            }
            
            if( guardian_email == ''){
                jQuery( '#guardian_email_err' ).html( "Please enter guardian's email" ); 
                error_count = error_count++;
            }else{
                 jQuery( '#guardian_email_err' ).html( "" ); 
                  error_count = 0;
            }
            
            if( guardian_address == ''){
                jQuery( '#guardian_address_err' ).html( "Please enter guardian's address" ); 
                error_count++;
            }else{
                 jQuery( '#guardian_address_err' ).html( "" ); 
                  error_count = 0;
            }
            
            if( player_fname == ''){
                jQuery( '#player_fname_err' ).html( "Please enter player's first name" ); 
                error_count++;
            }else{
                 jQuery( '#player_fname_err' ).html( "" ); 
                  error_count = 0;
            }
            
            if( player_lname == ''){
                jQuery( '#player_lname_err' ).html( "Please enter player's last name" ); 
                error_count++;
            }else{
                 jQuery( '#player_lname_err' ).html( "" ); 
                  error_count = 0;
            }
            
             if(player_birthday == 'Invalid Date'){
                jQuery( '#player_birthday_err' ).html( "Please enter player's birthday" ); 
                error_count++;
            }else{
                 jQuery( '#player_birthday_err' ).html( "" ); 
                  error_count = 0;
            }
            
             if(player_gender == ''){
                jQuery( '#player_gender_err' ).html( "Please enter player's gender" ); 
                error_count++;
            }else{
                 jQuery( '#player_gender_err' ).html( "" ); 
                  error_count = 0;
            }
            
            if(emergency_detail == ''){
                jQuery( '#emergency_detail_err' ).html( "Please enter emergency detail if any." ); 
                error_count++;
            }else{
                 jQuery( '#emergency_detail_err' ).html( "" );
                 error_count = 0;
            }
            
            if(emergency_fname == ''){
                jQuery( '#emergency_fname_err' ).html( "Please enter emergency contact's first name" ); 
                error_count++;
            }else{
                 jQuery( '#emergency_fname_err' ).html( "" ); 
                  error_count = 0;
            }
            
             if(emergency_lname == ''){
                jQuery( '#emergency_lname_err' ).html( "Please enter emergency contact's last name" ); 
                error_count++;
            }else{
                 jQuery( '#emergency_lname_err' ).html( "" );
                 error_count = 0;
            }
            
              if(emergency_phone == ''){
                jQuery( '#emergency_phone_err' ).html( "Please enter emergency contact's phone" ); 
                error_count++;
            }else{
                 jQuery( '#emergency_phone_err' ).html( "" ); 
                  error_count = 0;
            }
            
              if(soccer_kit == ''){
                jQuery( '#soccer_size_err' ).html( "Please enter soccer kit size" ); 
                error_count++;
            }else{
                 jQuery( '#soccer_size_err' ).html( "" ); 
                  error_count = 0;
            }
            
             if(typeof terms === 'undefined' ){
             jQuery( '#tems_cond_err' ).html( "Please check terms and conditions" );
                error_count++;
            }else{
                 jQuery( '#tems_cond_err' ).html( "" ); 
                  error_count = 0;
            }
            
            if(typeof consent === 'undefined' ){
             jQuery( '#liability_consent_err' ).html( "Please check liability-consent waiver" );
                error_count++;
            }else{
                 jQuery( '#liability_consent_err' ).html( "" ); 
                  error_count = 0;
            }
            
                if(typeof policy === 'undefined' ){
             jQuery( '#refund_cancel_err' ).html( "Please check refund-cancellation policy" );
                error_count++;
            }else{
                 jQuery( '#refund_cancel_err' ).html( "" ); 
                  error_count = 0;
            }
            
              if(response.length == 0){
                 jQuery( '#captcha_err' ).html( 'Please check the captcha' );
                error_count++;
            }else{
                error_count++;
                 if(error_count >= 1){
                 if((guardian_fname != '') && (guardian_lname != '') && (guardian_phone != '') && (guardian_email != '') && (guardian_address != '') && 
                 (player_fname != '') && (player_lname != '') && (player_birthday != 'Invalid Date') && (player_gender != '') && (emergency_detail != '')
                 && (emergency_fname != '') && (emergency_lname != '') && (emergency_phone != '') && (soccer_kit != '') && (typeof terms !== 'undefined')
                 && (typeof consent !== 'undefined') && (typeof policy !== 'undefined')){
                     error_count = 0;
                     jQuery( '#captcha_err' ).html( '' );
                 }else{
                     error_count = 1;
                     jQuery( '#captcha_err' ).html( '' );
                 }
            }
            }
             
            if(error_count == 0){
                      var information = {};
                /* var program_id = jQuery('#program_name').val();
                 var region_id = jQuery('#region_name').val();
                 var age_id = jQuery('#age_name').val();*/

                information[ "program_name" ] = jQuery( '#program_name' ).val();
                information[ "region_name" ] = jQuery( '#region_name' ).val();
                information[ "age_name" ] = jQuery( '#age_name' ).val();

                information[ "guardian_fname" ] = guardian_fname;
                information[ "guardian_lname" ] = guardian_lname;
                information[ "guardian_phone" ] = guardian_phone;
                information[ "guardian_email" ] = guardian_email;
                information[ "guardian_address" ] = guardian_address;

                information[ "player_fname" ] = player_fname;
                information[ "player_lname" ] = player_lname;
                information[ "player_birthday" ] = player_birthday;
                information[ "player_gender" ] = player_gender;
                information[ "emergency_detail" ] = emergency_detail;

                information[ "emergency_fname" ] = emergency_fname;
                information[ "emergency_lname" ] = emergency_lname;
                information[ "emergency_phone" ] = emergency_phone;
                information[ "soccer_kit" ] = soccer_kit;
                information[ "soccer_kit_name" ] = soccer_kit_name;

                var information = JSON.stringify( information );
                
                jQuery.ajax( {

                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    dataType: 'text',
                    data: {
                        action: 'orders_data',
                        orders: json,
                        info: information
                    },

                    success: function ( res ) {

                        insertid = res;

                        //jQuery( '#ref_id' ).val( res );

                        jQuery( "#wizardStep2" ).removeClass( "disabled" );
                        jQuery( '#wizardStep2' ).click();

                        jQuery( "#wizardStep4" ).click( function () {
                            jQuery( "#payment-section" ).show();
                            jQuery( "#promo-code-section" ).show();
                            jQuery( "#paymentbutt-section" ).show();
                            jQuery( "#first-section" ).removeClass( "col-lg-12" );
                            jQuery( "#first-section" ).addClass( "col-lg-8" );
                        } );

                        jQuery( "#wizardStep1" ).click( function () {
                            jQuery( "#payment-section" ).show();
                            jQuery( "#promo-code-section" ).show();
                            jQuery( "#paymentbutt-section" ).show();
                            jQuery( "#first-section" ).removeClass( "col-lg-12" );
                            jQuery( "#first-section" ).addClass( "col-lg-8" );
                        } );

                        jQuery( "#wizardStep2" ).click( function () {
                            jQuery( "#payment-section" ).show();
                            jQuery( "#promo-code-section" ).hide();
                            jQuery( "#paymentbutt-section" ).hide();
                            jQuery( "#first-section" ).addClass( "col-lg-8" );
                            jQuery( "#first-section" ).removeClass( "col-lg-12" );
                        } );

                        /*jQuery("#wizardStep3").click(function() {
                            jQuery("#payment-section").hide();
                            jQuery("#first-section").removeClass("col-lg-8");
                            jQuery("#first-section").addClass("col-lg-12");
                        });*/

                        jQuery( "#payment-section" ).show();
                        jQuery( "#promo-code-section" ).hide();
                        jQuery( "#paymentbutt-section" ).hide();
                        jQuery( "#first-section" ).addClass( "col-lg-8" );
                        jQuery( "#first-section" ).removeClass( "col-lg-12" );

                    }
                } )
            }
        } );

        jQuery( "#apply-coupon" ).click( function () {
            var coupon_name = jQuery( '#coupon-name' ).val();
            //alert(coupon_name);

            jQuery.ajax( {

                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                dataType: 'text',
                data: {
                    action: 'apply_coupon',
                    coupon: coupon_name,
                },

                success: function ( res ) {
                    var coupon_data = JSON.parse( res );

                    if ( coupon_data.type == "No" ) {
                        jQuery( '#apply-coupon-err' ).html( "No such coupon available." );
                    } else if ( coupon_data.type == "amount" ) {
                        var couponprice = parseInt( coupon_data.value );

                        total = total - couponprice;
                        jQuery( '#total_price' ).html( "CAD " + total.toFixed( 2 ) );
                        jQuery( '#discount-price' ).html( "CAD " + couponprice.toFixed( 2 ) );
                        jQuery( '#apply-coupon-err' ).html( "Coupon Applied." );
                         jQuery( '#card-button' ).html( "CAD " + total.toFixed( 2 ) );
                    } else {
                        var couponprice = parseInt( coupon_data.value );

                        var percent_discount = ( total * couponprice ) / 100;
                        total = total - percent_discount;
                        jQuery( '#total_price' ).html( "CAD " + total.toFixed( 2 ) );
                        jQuery( '#discount-price' ).html( "CAD " + percent_discount.toFixed( 2 ) );
                        jQuery( '#apply-coupon-err' ).html( "Coupon Applied." );
                         jQuery( '#card-button' ).html( "CAD " + total.toFixed( 2 ) );
                    }

                }
            } )


        } );

    } );
</script>