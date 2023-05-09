<?php
   register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'ecommerce' ),
        'topbar' => __( 'Topbar Menu', 'ecommerce' ),
        'footer_menu1' => __( 'Footer Menu 1', 'ecommerce' ),
        'footer_menu2' => __( 'Footer Menu 2', 'ecommerce' ),
        'bottom_menu' => __( 'Bottom Menu', 'ecommerce' ),

    ) );
    function mytheme_post_thumbnails() {
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
    }
    add_action( 'after_setup_theme', 'mytheme_post_thumbnails' );
    function ecommerce_widgets_init() {
         register_sidebar( array(
        'name'          => __( 'Contact page sidebar', 'ecommerce' ),
        'id'            => 'contact-sidebar',
        'description'   => __( 'Add widgets here to appear in your contact page.', 'ecommerce' ),
        'before_widget' => '<div class="footer-widget twitter-feeds">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
        ) );
    }
    add_action( 'widgets_init', 'ecommerce_widgets_init' );

    function my_admin_theme_style() {
        wp_enqueue_style('my-admin-style', get_template_directory_uri() . '/admin-style.css');
    }
    add_action('admin_enqueue_scripts', 'my_admin_theme_style');

    function ecommerce_scripts() {
        wp_enqueue_style( 'bootstrap_style', get_template_directory_uri() . '/css/bootstrap.css', array() );
        wp_enqueue_style( 'font_style', get_template_directory_uri() . '/css/fonts.css', array() );
        wp_enqueue_style( 'lineawsome_style', get_template_directory_uri() . '/css/line-awesome.min.css', array() );
    	wp_enqueue_style( 'theam_style', get_template_directory_uri() . '/style.css', array(),strtotime("now") );

        wp_enqueue_script( 'jquery' );

        wp_enqueue_script( 'boostrap-min', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '2020', true );
        wp_enqueue_script( 'html_shiv', get_template_directory_uri() . '/js/html5shiv.js', array( 'jquery' ), '2020', false );
        wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', array( 'jquery' ), '2020', false );
        wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array( 'jquery' ), '2020', true );
       // wp_enqueue_script( 'owl_carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '2020', true );
        wp_enqueue_script( 'popper', get_template_directory_uri() . '/js/popper.min.js', array( 'jquery' ), '2020', true );
        wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/respond.min.js', array( 'jquery' ), '2020', true );
        wp_enqueue_script( 'theme_js', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), '2020', true );
       // wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.min.js', array( 'jquery' ), '2020', true );
        wp_enqueue_script( 'paymentform-js', 'https://js.squareupsandbox.com/v2/paymentform', array(), '2020', false );
        //wp_enqueue_script( 'sqpaymentform-js', get_template_directory_uri() . '/js/sqpaymentform.js', array(), '2020', false );
        wp_enqueue_script( 'sqpaymentform-server-js', get_template_directory_uri() . '/js/server.js', array(), '2022', false );
    }
    add_action( 'wp_enqueue_scripts', 'ecommerce_scripts' );

    add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 3);
    function special_nav_class($classes, $item, $args){

        if( in_array('current-menu-item', $classes) ){
            $classes[] = 'active ';
        }
        if($args->add_li_class) {
            $classes[] = $args->add_li_class;
        }
        return $classes;

        return $classes;
    }
add_filter( 'nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );

function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'nav-link'; // or something based on $item
    $atts['class'] = $class;
    return $atts;
}
function custom_submenu_class($menu) {
    $menu = preg_replace('/ class="sub-menu"/','/ class="dropdown-menu" /',$menu);
    return $menu;
}

add_filter('wp_nav_menu','custom_submenu_class');
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

add_filter( 'user_registration_login_redirect', 'ur_redirect_after_login', 10, 2 );
function ur_redirect_after_login( $redirect, $user ) {
    return 'purchase' ;
}

add_action( 'wp', 'redirect_logged_users_to_specific_page' );
function redirect_logged_users_to_specific_page() {
    if ( is_user_logged_in() && is_front_page() ) {
        wp_redirect(  get_permalink(32) );
        exit;
    }
}

add_action( 'wp_logout', 'auto_redirect_external_after_logout');
function auto_redirect_external_after_logout(){
    wp_redirect(home_url());
    exit();
}

add_action("wp_ajax_programs_filter", "programs_filter_callback");
add_action("wp_ajax_nopriv_programs_filter", "programs_filter_callback");
function programs_filter_callback() {
    //echo "testt"; die;
    
    $posts = get_posts(
        array(
            'posts_per_page' => -1,
            'post_type' => 'programs',

            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'program_category',
                    'field' => 'term_id',
                    'terms' => $_POST['programcat'],
                ),
                array(
                    'taxonomy' => 'region_category',
                    'field' => 'term_id',
                    'terms' => $_POST['regioncat'],
                ),
                  array(
                      'taxonomy' => 'age_category',
                      'field' => 'term_id',
                      'terms' => $_POST['agecat'],
                  )
            )

            /*'tax_query' => array(
                array(
                    'taxonomy' => 'program_category',
                    'field' => 'term_id',
                    'terms' => $_POST['category'],
                )
            )*/
        )
    );

    if(!empty($posts)){

        $tdate = date("Y-m-d");
        //echo $tdate; die;
        $term = get_term_by('id', $_POST['programcat'], 'program_category');

        foreach($posts as $program){
            //$soldout = get_post_meta($program->ID,'sold-out', true);
            $soldout = get_post_meta($program->ID,'testing', true);
            $notopen = get_post_meta($program->ID,'opening-date', true);
            //echo $notopen; die;

            echo '<div class="card program-card mb-3">';
            echo '<div class="card-body">';
            echo '<h5 class="mb-3">'.$term->name.' - 2022 Program</h5>';
            echo '</hr>';

            echo '<div class="row">';

            /*echo '<div class="col-md-6 col-lg-3">';
            echo get_the_post_thumbnail( $program->ID , 'full', array( 'class' => 'img-fluid' ) );
            echo '</div>';*/

            echo '<div class="col-md-12">';
            echo '<div class="row">';

            echo '<div class="col-md">';
            echo '<h6>'.$program->post_title.'</h6>';
            echo '<p>'.$program->post_content.'</p>';

            echo '<div class="price-info text-lg font-medium">';
            echo 'original: <span class="old-price">'.get_post_meta($program->ID,'old-price', true).'</span>';
            echo '   ';
            echo 'discount: <span class="new-price text-primary">'.get_post_meta($program->ID,'new-price', true).'</span>';
            echo '</div>';

            echo '</div>';

            //if(!empty($soldout)){
            if($soldout == "Yes"){
                echo '<div class="col-md-auto">';
                echo '<h4 class="sold-out-badge">Sold Out</h4>';
                echo '<a href="javascript:void(0)" id="btn-soldout" data-name="'.$program->post_title.'" data-toggle="modal" data-target="#spotModal">Looking for a spot?</a>';
                //echo '<button id="'.$program->post_title.'" data-toggle="modal" data-target="#myModal" class="btn btn-select1 btn-outline-dark btn-soldout">Sold Out</button>';
                echo '</div>';
            }elseif(!empty($notopen) && ($notopen <= $tdate)){
                echo '<div class="col-md-auto">';
                echo '<a href="javascript:void(0)" data-price="'.get_post_meta($program->ID,'new-price', true).'" id="'.$program->ID.'" class="btn btn-select btn-outline-dark">Select<i class="la la-long-arrow-alt-right ml-2 la-lg"></i> </a>';
                echo '</div>';
            }
            elseif(!empty($notopen) && ($notopen > $tdate)){
                //echo $notopen; die;
                echo '<div class="col-md-auto">';
                echo '<h6 class="sold-out-badge">Not Open Yet</h6>';
                echo '<a href="javascript:void(0)" id="btn-notifyme" data-name="'.$program->post_title.'" data-toggle="modal" data-target="#notOpenModal">Notify me!</a>';
                //echo '<button id="'.$program->post_title.'" data-toggle="modal" data-target="#myModal" class="btn btn-select1 btn-outline-dark btn-soldout">Sold Out</button>';
                echo '</div>';
            }
            else{
                echo '<div class="col-md-auto">';
                echo '<a href="javascript:void(0)" data-price="'.get_post_meta($program->ID,'new-price', true).'" id="'.$program->ID.'" class="btn btn-select btn-outline-dark">Select<i class="la la-long-arrow-alt-right ml-2 la-lg"></i> </a>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }else{
        echo '<div>';
        echo '<h5 class="mb-3">No such program found.</h5>';
        echo '</div>';
    }

    exit;
}

$order = [];

add_action("wp_ajax_programs_selected", "programs_selected_callback");
add_action("wp_ajax_nopriv_programs_selected", "programs_selected_callback");
function programs_selected_callback() {
    $programid = $_POST['programid'];

        $page = get_post($programid);
        //echo "<pre>"; print_r($page); die;
        //$page->post_content = '';

        $page->image = get_the_post_thumbnail_url( $page->ID , 'full', array( 'class' => 'img-fluid' ) );

            echo json_encode($page);

    exit;
}


add_action("wp_ajax_orders_data", "orders_data_callback");
add_action("wp_ajax_nopriv_orders_data", "orders_data_callback");
function orders_data_callback() {
        //echo "test"; die;

    $orders_data = $_POST["orders"];
    //echo "<pre>"; print_r($orders_data); die;

    $tempData = str_replace("\\", "",$orders_data);
    //echo "<pre>"; print_r($tempData); die;

   $cleanData = json_decode($tempData,false);
    //echo "<pre>"; print_r($cleanData); die;

    global $wpdb;
    if(is_user_logged_in()){
        $userid = get_current_user_id();
    }else{
        $userid = 0;
    }

    $price_val = explode(" ",$cleanData->total_price);
    //echo $price_val;

    $wpdb->insert('wp_orders', array(
        'user_id' => $userid,
        'total_item' => $cleanData->item_count,
        'total_amount' => $price_val[1],
        'status' => "Pending",
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ));
    $insert_order = $wpdb->insert_id;
    //echo $insert_order; die;

    $order_insid = sprintf('%04d', $insert_order);
    $sql = "UPDATE wp_orders SET order_id = '{$order_insid}' WHERE id = '{$insert_order}'";
    $wpdb->query($sql);

    foreach($cleanData->programs as $order_det){
        $price = get_post_meta($order_det->ID,'new-price', true);
        $price_val = explode("$",$price);

        $wpdb->insert('wp_order_details', array(
            'orderid' => $insert_order,
            'product_id' => $order_det->ID,
            'product_price' => $price_val[0],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ));
        $insert_orderdet = $wpdb->insert_id;
    }

    $information = $_POST["info"];
    $infotempData = str_replace("\\", "",$information);
    $infocleanData = json_decode($infotempData,false);
    //echo "<pre>"; print_r($infocleanData); die;

    $wpdb->insert('wp_regstraion_data', array(
        'user_id' => $userid,
        'order_id' => $insert_order,

        'program' => $infocleanData->program_name,
        'player_birth_year' => $infocleanData->age_name,
        'program_address' => $infocleanData->region_name,

        'guardian_fname' => $infocleanData->guardian_fname,
        'guardian_lname' => $infocleanData->guardian_lname,
        'guardian_phone' => empty($infocleanData->guardian_phone) ? '' : $infocleanData->guardian_phone,
        'guardian_email' => $infocleanData->guardian_email,
        'guardian_address' => empty($infocleanData->guardian_address) ? '' : $infocleanData->guardian_address,

        'player_fname' => $infocleanData->player_fname,
        'player_lname' => $infocleanData->player_lname,
        'player_birthdate' => empty($infocleanData->player_birthday) ? '' : $infocleanData->player_birthday,
        'player_gender' => empty($infocleanData->player_gender) ? '' : $infocleanData->player_gender,
        'emergency_detail' => empty($infocleanData->emergency_detail) ? '' : $infocleanData->emergency_detail,

        'emergency_fname' => $infocleanData->emergency_fname,
        'emergency_lname' => $infocleanData->emergency_lname,
        'emergency_phone' => empty($infocleanData->emergency_phone) ? '' : $infocleanData->emergency_phone,

        'soccer_kit' => empty($infocleanData->soccer_kit) ? '' : $infocleanData->soccer_kit,
        'soccer_kit_name' => empty($infocleanData->soccer_kit_name) ? '' : $infocleanData->soccer_kit_name,
    ));

    echo $insert_order;

    exit;
}

add_filter( 'user_registration_account_menu_items', 'ur_custom_menu_items', 10, 1 );
function ur_custom_menu_items( $items ) {
    //echo "<pre>"; print_r($items); die;
    //$items['order-list'] = __( 'Orders', 'user-registration' ) ;

    $items = array_slice($items, 0, 2, true) +
        array("order-list" => __( 'Orders', 'user-registration' )) +
        array_slice($items, 2, count($items) - 1, true) ;
    return $items;
}

add_action( 'init', 'user_registration_add_new_my_account_endpoint' );
function user_registration_add_new_my_account_endpoint() {
    add_rewrite_endpoint( 'order-list', EP_PAGES );
}

function user_registration_order_list_endpoint_content() {
    ur_get_template( 'myaccount/my_orders.php');
    //echo 'Your new content';
}
add_action( 'user_registration_account_order-list_endpoint', 'user_registration_order_list_endpoint_content' );


add_action("wp_ajax_wmt_order_view", "wmt_order_view_callback");
add_action("wp_ajax_nopriv_wmt_order_view", "wmt_order_view_callback");
function wmt_order_view_callback()
{
    $orders_id = $_POST["order_id"];

    global $wpdb;
    $user_data = $wpdb->get_row('SELECT * From wp_orders WHERE id='.$orders_id);
    $personal_info = $wpdb->get_row('SELECT * From wp_regstraion_data WHERE order_id='.$orders_id);
    $orders = $wpdb->get_results("SELECT * FROM wp_order_details WHERE orderid = ".$orders_id);
    foreach($orders as $ord){
        //echo "<pre>"; print_r($ord);
        $prodid = $ord->product_id;

        $page = get_post($prodid);
        if(!empty($page)) {
            $title = $page->post_title;
            $ord->prod_title = $title;
        }
    }
    $user_data->order_details = $orders;
    $user_data->personalinfo = $personal_info;

    //echo "<pre>"; print_r($user_data); die;
    echo json_encode($user_data);

    exit;
}

add_action( 'admin_menu', 'wmt_admin_menu_callback' );
function wmt_admin_menu_callback()
{
    add_menu_page( 'All Orders', 'All Orders', 'manage_options', 'all_orders', 'wmt_all_orders_list_callback', 'dashicons-portfolio', 90 );
}

function wmt_all_orders_list_callback(){
    include_once 'templates/all_orders_list.php';
}

add_action( 'wp', 'redirect_if_user_not_logged_in' );
function redirect_if_user_not_logged_in() {
    if ( !is_user_logged_in() && is_page('my-account')) {
        wp_redirect( get_permalink(22) );
        exit;
    }
}


add_action("wp_ajax_apply_coupon", "apply_coupon_callback");
add_action("wp_ajax_nopriv_apply_coupon", "apply_coupon_callback");
function apply_coupon_callback() {
    $coupon_name = $_POST["coupon"];
    //echo $coupon_name;

    $coupons = get_posts(
        array(
            'post_type' => 'couponcode',
            'post_status'      => 'publish',
            'title'  => $coupon_name,
        )
    );
    //echo "<pre>"; print_r($coupons); die;

    $coupon_details = [];
        if(!empty($coupons)){
            foreach($coupons as $coupon){
                if($coupon_name == $coupon->post_title){
                    $discount_percent = get_post_meta($coupon->ID,'discount-percentage', true);
                    $discount_amount = get_post_meta($coupon->ID,'discount-amount', true);

                    if(!empty($discount_percent)){
                        $coupon_details['type'] = "percent";
                        $coupon_details['value'] = $discount_percent;
                    }else{
                        $coupon_details['type'] = "amount";
                        $coupon_details['value'] = $discount_amount;
                    }
                    echo json_encode($coupon_details);
                }
            }
        }else{
            $coupon_details['type'] = "No";
            //$coupon_details['value'] = 0;
            echo json_encode($coupon_details);
        }

    exit;
}

add_action("wp_ajax_payment_success", "payment_success_callback");
add_action("wp_ajax_nopriv_payment_success", "payment_success_callback");
function payment_success_callback() {
    global $wpdb;

    $payment = $_POST['payment'];
    $id = $_POST['id'];

    $paymenttempData = str_replace("\\", "",$payment);
    $paymentcleanData = json_decode($paymenttempData,false);

    $user_data = $wpdb->get_row('SELECT * From wp_orders WHERE id='.$id);
    $information_data = $wpdb->get_row('SELECT * From wp_regstraion_data WHERE order_id='.$id);
    $user = get_user_by( 'ID',$user_data->user_id);

    $user_email = $user->user_email;
    if(empty($user_email)){
        $user_email = $information_data->guardian_email;
    }

    //$user_email = 'tanvi.webmobi@gmail.com';

    foreach($paymentcleanData as $pay) {
        if ($pay->status == "COMPLETED") {

            $to = get_option('admin_email');
            $subject = 'New Registraion';

            $headers = array('Content-Type: text/html; charset=UTF-8', 'From: LVLUP <info@ecommercesoccer.ca>');
            $amt_val = ($pay->amount_money->amount) / 100;

            $body = '<p>Transation ID: ' . $pay->id . '</p>';
            $body .= '<p>Order ID: ' . $pay->order_id . '</p>';
            $body .= '<p>User Email: ' . $user_email . '</p>';
            $body .= '<p>Total Item: '.$user_data->total_item.'</p>';
            $body .= '<p>Total Amount: '.$amt_val.' CAD</p>';
            wp_mail($to, $subject, $body, $headers);

            $to_user = $user_email;
            $subject_user = 'LVLUP Registration';
            $headers1 = array('Content-Type: text/html; charset=UTF-8');
            //$body1 = "hello";
            $body1 = '<p>Hello ' . $information_data->guardian_fname . ' ' . $information_data->guardian_lname . '</p>';
            $body1 .= '<p>Your registration process is done.</p>';
            $body1 .= '<p>Transation Id: ' . $pay->id . '</p>';
            $body1 .= '<p>Thank You</p>';
            wp_mail($to_user, $subject_user, $body1, $headers1);
           /* if(wp_mail($to_user, $subject_user, $body1)){
                echo "yes"; die;
            }else{
                echo "no"; die;
            }*/

            $sql = "UPDATE wp_orders SET status = 'Completed',
                transaction_id = '{$pay->id}' WHERE id = '{$id}'";
            $wpdb->query($sql);

        }else{
            echo "Your Payment is not completed.";
        }

        exit;
    }
}

?>
