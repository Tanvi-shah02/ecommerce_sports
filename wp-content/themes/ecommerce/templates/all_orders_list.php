<style>
     .info{
        margin-top: 30px;
    }
    .fontitem{
        font-size: 15px;
        text-align: center;
    }
     .fontitem1{
         font-size: 15px;
         text-align: right;
     }
</style>


<div class="wrap">
    <h1 class="wp-heading-inline">All Orders</h1>
</div>

<?php
global $wpdb;
$table_orders = $wpdb->prefix.'orders';
$orders = $wpdb->get_results("SELECT * FROM $table_orders ORDER BY id DESC");
//$orders = $wpdb->get_results("SELECT * FROM $table_orders ORDER BY id DESC");
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

<div class="ur-frontend-form my-child-container" id="ur-frontend-form">

<div id="tableid" class="table-responsive">
    <table id="tblUser" class="table table-bordered table-hover mt-3">

        <thead>
        <tr class="bg-primary text-white">
            <th>Sr. No.</th>
            <th>Order Id</th>
            <th>Order Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php if(!empty($orders)){?>
            <?php $i=1; foreach($orders as $order){
                //echo "<pre>"; print_r($order); die;
                if($order->status == "Completed"){
                $date = explode(" ",$order->created_at );

                    $user = $wpdb->get_row("SELECT * FROM wp_users WHERE ID = '{$order->user_id}'");
                    $guest = $wpdb->get_row("SELECT * FROM wp_regstraion_data WHERE order_id = '{$order->id}'");
                    if(!empty($user)){
                        $email = $user->user_email;
                        $name = $user->user_nicename;
                    }else{
                        $email = "-";
                        $name= $guest->player_fname." ".$guest->player_lname;
                    }

                    if($order->user_id == 0){
                        $user_type = "Guest";
                    }else{
                        $user_type = "Registered";
                    }

                    $soccer_prize = $guest->soccer_kit;
                    $gst_on_soccer = $soccer_prize * 0.13;
                    $total = $order->total_amount + $soccer_prize + $gst_on_soccer;

                    $date = explode(" ",$order->created_at);
                ?>

                <tr>
                    <td class="text-center"><?php echo $i;?></td>
                    <td><?php echo $order->order_id?></td>
                    <td><?php echo $date[0];?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $user_type; ?></td>
                    <td><?php echo "CAD ".$total." "; ?></td>
                    <td><?php echo $order->status?></td>
                    <td><a href="javascript:void(0);" id="order_view" class="order_view btn btn-sm btn-secondary" data-id="<?php echo $order->id?>">View</a></td>
                </tr>
                <?php $i++;}} ?>
        <?php }else{ ?>
            <tr>
                <td colspan="4">No data found.</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

    <div id="invoice-detail">
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

<script>
    jQuery(document).ready(function($) {
        $('#tblUser').DataTable();

        jQuery(document).on("click",".order_view", function(){
            //jQuery('.order_view').click(function () {
            var order_id = jQuery(this).attr('data-id');

            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url("admin-ajax.php")?>',
                data: {"action": "wmt_order_view", "order_id": order_id},
                success: function (response) {
                    var booked_data = JSON.parse(response);
                    console.log(booked_data);

                    var personalinfo = booked_data.personalinfo;
                    var ddate = booked_data.created_at.split(" ");

                    var selected_data = '  <a href="javascript:void(0);" id="backto_list" class="backto_list float-right btn btn-sm btn-secondary">Back</a>';

                    selected_data += '</br></br></br>';

                    selected_data += '<div class="table-responsive">';
                    selected_data += '<table class="table" width="100%">';
                    selected_data += '<tbody>';
                    selected_data += '<tr>';
                    selected_data += '<td width="50%">';

                    selected_data += '<div class="text-left">';
                    selected_data += '<h2>Order Id: '+booked_data.order_id+'</h2>';
                    selected_data += '<h2>Order Date: '+ddate[0]+'</h2>';
                    selected_data += '<h2>Transaction Id: '+booked_data.transaction_id+'</h2>';
                    selected_data += '<h2>Status: '+booked_data.status+'</h2>';
                    selected_data += '</div>';

                    selected_data += '</td>';

                    selected_data += '</tr>';
                    selected_data += '</tbody>';
                    selected_data += '</table>';
                    selected_data += '</div>';

                    selected_data += '<div class="table-responsive">';
                    selected_data += '<table id="tblUser1" width="82%" border="1" class="info table table-bordered table-hover" width="100%">';
                    selected_data += '<thead>';
                    selected_data += '<tr class="bg-primary text-white">';
                    selected_data += '<th>Sr. No.</th>';
                    selected_data += '<th>Product Id</th>';
                    selected_data += '<th>Product Price</th>';
                    selected_data += '</tr>';
                    selected_data += '</thead>';

                    selected_data += '<tbody>';

                    var order_det = booked_data.order_details;
                    console.log(order_det);
                    var price_val = 0;
                    for(var i = 0; i < order_det.length; i++) {
                        var price = parseInt(order_det[i].product_price);
                        price_val = parseInt(price_val) + parseInt(price.toFixed(2));

                        selected_data += '<tr>';
                        selected_data += '<td class="fontitem" width="5%">'+(i + 1)+'</td>';
                        selected_data += '<td class="fontitem" width="55%">'+order_det[i].prod_title+'</td>';
                        selected_data += '<td class="fontitem1" width="40%">CAD '+price.toFixed(2)+'</td>';
                        selected_data += '</tr>';
                    }

                    /*selected_data += '<tr>';
                    selected_data += '<td class="fontitem" width="5%"></td>';
                    selected_data += '<td class="fontitem" width="55%">Total</td>';
                    selected_data += '<td class="fontitem" width="40%">CAD '+Math.ceil(total_gst)+'.00</td>';
                    selected_data += '</tr>';*/

                    selected_data += '<tr>';
                    selected_data += '<td class="fontitem" width="5%"></td>';
                    selected_data += '<td class="fontitem" width="55%">Soccer Kit</td>';
                    selected_data += '<td class="fontitem1" width="40%">CAD '+personalinfo.soccer_kit+'</td>';
                    selected_data += '</tr>';
                    
                    var price_gst = price_val * 0.13;
                    var total_gst =  parseInt(price_val) + price_gst;
                    var soccer_gst = personalinfo.soccer_kit * 0.13;
                    var total_soccer_gst = parseInt(personalinfo.soccer_kit) + soccer_gst;
                    var gst = price_gst + soccer_gst;

                    selected_data += '<tr>';
                    selected_data += '<td class="fontitem" width="5%"></td>';
                    selected_data += '<td class="fontitem" width="55%">HST(13%)</td>';
                    selected_data += '<td class="fontitem1" width="40%">CAD '+gst.toFixed(2)+'</td>';
                    selected_data += '</tr>';

                    //var grand_total = Math.ceil(total_gst) + parseInt(personalinfo.soccer_kit);
                    //var grand_total = Math.ceil(total_gst + total_soccer_gst);
                    var grand_total = total_gst + total_soccer_gst;

                    selected_data += '<tr>';
                    selected_data += '<td class="fontitem" width="5%"></td>';
                    selected_data += '<td class="fontitem" width="55%">Grand Total</td>';
                    selected_data += '<td class="fontitem1" width="40%">CAD '+grand_total+'</td>';
                    selected_data += '</tr>';

                    selected_data += '</tbody>';

                    selected_data += '</table>';
                    selected_data += '</div>';


                    selected_data += '<div class="table-responsive">';
                    selected_data += '<table class="table" width="100%">';
                    selected_data += '<tbody>';
                    selected_data += '<tr>';

                    selected_data += '<h1 class="info">Information</h1>';

                    selected_data += '<td width="33%">';

                    if(personalinfo !== null){
                        var guardian_name = personalinfo.guardian_fname+' '+personalinfo.guardian_lname;

                        selected_data += '<div class="text-right">';
                        selected_data += '<h4>Parent Name: '+guardian_name+'</h4>';
                        selected_data += '<h4>Parent Phone: '+personalinfo.guardian_phone+'</h4>';
                        selected_data += '<h4>Parent Email: '+personalinfo.guardian_email+'</h4>';
                        selected_data += '<h4>Parent Address: '+personalinfo.guardian_address+'</h4>';
                        selected_data += '</div>';
                    }
                    selected_data += '</td>';
                    selected_data += '<td width="33%">';

                    if(personalinfo !== null){
                        var player_name = personalinfo.player_fname+' '+personalinfo.player_lname;

                        selected_data += '<div class="text-right">';
                        selected_data += '<h4>Player Name: '+player_name+'</h4>';
                        selected_data += '<h4>Player Birthdate: '+personalinfo.player_birthdate+'</h4>';
                        selected_data += '<h4>Player Gender: '+personalinfo.player_gender+'</h4>';
                        selected_data += '<h4>Soccer Kit Size: '+personalinfo.soccer_kit_name+'</h4>';
                        selected_data += '</div>';
                    }

                    selected_data += '</td>';

                    selected_data += '<td width="33%">';

                    if(personalinfo !== null){
                        var emergencycont_name = personalinfo.emergency_fname+' '+personalinfo.emergency_lname;

                        selected_data += '<div class="text-right">';
                        selected_data += '<h4>Emergency Contact Name: '+emergencycont_name+'</h4>';
                        selected_data += '<h4>Emergency Contact Number: '+personalinfo.emergency_phone+'</h4>';
                        selected_data += '<h4>Medical Conditions: '+personalinfo.emergency_detail+'</h4>';
                        selected_data += '</div>';
                    }

                    selected_data += '</td>';

                    selected_data += '</tr>';
                    selected_data += '</tbody>';
                    selected_data += '</table>';
                    selected_data += '</div>';


                    jQuery('#invoice-detail').html(selected_data);

                    jQuery("#invoice-detail").show();
                    jQuery("#tableid").hide();
                }
            })

        });

        jQuery(document).on("click",".backto_list", function(){
            //jQuery("#backto_list").click(function() {
            //alert("Back");
            jQuery("#invoice-detail").hide();
            jQuery("#tableid").show();
        });



    });
</script>
