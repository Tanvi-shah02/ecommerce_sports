<?php
session_start();
/**
 * Template Name: SqPay Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>
<?php
require 'connect-php-sdk-master/vendor/autoload.php';

$access_token = 'EAAAEBparn7X0cmMYa1knDNqS4Pf4PL7xrVmVbz7muJNmNqRr7q4LvWWRgDCJ5ut';
# setup authorization
\SquareConnect\Configuration::getDefaultConfiguration()->setAccessToken($access_token);
# create an instance of the Transaction API class
$transactions_api = new \SquareConnect\Api\TransactionsApi();
$location_id = 'L8V48DSHQEZDY';
$nonce = $_POST['nonce'];

$request_body = array (
    "card_nonce" => 'cnon:card-nonce-ok',
    # Monetary amounts are specified in the smallest unit of the applicable currency.
    # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
    "amount_money" => array (
        "amount" => (int) $_POST['amount'],
        "currency" => "CAD"
    ),
    # Every payment you process with the SDK must have a unique idempotency key.
    # If you're unsure whether a particular payment succeeded, you can reattempt
    # it with the same idempotency key without worrying about double charging
    # the buyer.
    "idempotency_key" => uniqid(),
    "reference_id"=> $_POST['ref_id']
);

try {
    $result = $transactions_api->charge($location_id,  $request_body);
    //echo "<pre>"; print_r($result); die;
    $transection_id = $result['transaction']['id'];
    $reg_id = $result['transaction']['reference_id'];
    $user_data = $wpdb->get_row('SELECT * From wp_orders WHERE id='.$reg_id);
    $information_data = $wpdb->get_row('SELECT guardian_email From wp_regstraion_data WHERE order_id='.$reg_id);
    $user = get_user_by( 'ID',$user_data->user_id);

    $user_email = $user->user_email;
    if(empty($user_email)){
        $user_email = $information_data->guardian_email;
    }

    if($result['transaction']['id']){

        $to = get_option( 'admin_email' );
        $subject = 'New Registraion';

        $headers = array('Content-Type: text/html; charset=UTF-8','From: LVLUP <support@example.com>');

        $body = '<p>Transation ID: '.$result['transaction']['id'].'</p>';
        $body .= '<p>Order ID: '.$user_data->order_id.'</p>';
        $body .= '<p>User Email: '.$user_email.'</p>';
        $body .= '<p>Total Item: '.$user_data->total_item.'</p>';
        $body .= '<p>Total Amount: '.$user_data->total_amount.'</p>';
        wp_mail( $to, $subject, $body, $headers );

        $to = $user_email;
        $subject = 'LVLUP Regristraion';
        $body1 = '<p>Hello '.$user_data->guardian_fname.' '.$user_data->guardian_lname.'</p>';
        $body1 .= '<p>Your registration process is done.</p>';
        $body1 .= '<p>Transation Id: '.$result["transaction"]["id"].'</p>';
        $body1 .= '<p>Thank You</p>';
        wp_mail( $to, $subject, $body1, $headers );
        //echo "<pre>"; print_r($user_data); die;

        $_SESSION["transaction_id"] = $result['transaction']['id'];
        wp_redirect( get_permalink(32).'?payment_status=successful' );
        //wp_redirect( get_permalink(32));

        $sql = "UPDATE wp_orders SET status = 'Completed',
                transaction_id = '{$transection_id}' WHERE id = '{$reg_id}'";
        $wpdb->query($sql);

    }
} catch (\SquareConnect\ApiException $e) {
    echo "Exception when calling TransactionApi->charge:";
    var_dump($e->getResponseBody());
}
?>