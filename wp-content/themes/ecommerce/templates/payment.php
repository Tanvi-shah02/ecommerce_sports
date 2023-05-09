<?php

/**

 * Template Name: Square WebSDK
 * Template Post Type: post, page

 */


$rawdata = file_get_contents("php://input");
//echo "<pre>"; print_r(json_decode($rawdata)); die;

$curl = curl_init();


$url = 'https://connect.squareup.com/v2/payments';
//$url = 'https://connect.squareupsandbox.com/v2/payments';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
    "X-Custom-Header: header-value",
    "Content-Type: application/json",
    "Authorization: Bearer EAAAFJ-Y3jcAXtH4QM0m7NnK_YVxsfbtHqS9cfQ6_kA_i6vx7j_qinXKUATd_doN"
    //"Authorization: Bearer EAAAEBparn7X0cmMYa1knDNqS4Pf4PL7xrVmVbz7muJNmNqRr7q4LvWWRgDCJ5ut"
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_HEADER, false);
$data = $rawdata;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//curl_setopt_array($curl, $options);
$result = curl_exec($curl);

curl_close($curl);
echo $result; exit;
?>