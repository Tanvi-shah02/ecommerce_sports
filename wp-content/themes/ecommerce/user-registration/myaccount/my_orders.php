<?php
global $wpdb;
$table_orders = $wpdb->prefix.'orders';
$table_regdata = $wpdb->prefix.'regstraion_data';
$orders = $wpdb->get_results("SELECT * FROM $table_orders WHERE user_id = ".get_current_user_id());
//echo "<pre>"; print_r($orders); die;
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />

<div class="ur-frontend-form my-child-container" id="ur-frontend-form">

    <div class="row justify-content-center">
        <h2><?php _e( 'My Orders', 'user-registration' ); ?></h2>
    </div>

    <div id="tableid" class="table-responsive">
        <table id="tblUser" class="table table-striped table-bordered table-hover">

            <thead>
            <tr class="bg-primary text-white">
                <th>Sr. No.</th>
                <th>Order Id</th>
                <th>Total Amount</th>
                <th>Transaction Id</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php if(!empty($orders)){?>
                <?php $i=1; foreach($orders as $order){
                    if($order->status == "Completed"){
                    $date = explode(" ",$order->created_at );
                    
                    $sk_data = ' ';
                     $reg_data  = $wpdb->get_results("SELECT * FROM $table_regdata WHERE order_id = ".$order->id);
                     foreach($reg_data as $regd){
                         $sk_data = $regd->soccer_kit; 
                     }
                     $totalsk = $sk_data * 0.13;
                     $totalamtt = $sk_data + $totalsk + ($order->total_amount);
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $order->order_id?></td>
                        <td>C$<?php echo $totalamtt?></td>
                        <td><?php echo $order->transaction_id?></td>
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

                    var selected_data = '  <a href="javascript:void(0);" id="backto_list" class="backto_list float-right btn btn-sm btn-secondary">Back</a>';

                    selected_data += '</br></br></br>';

                    selected_data += '<div class="float-left">';
                    selected_data += '<h6>Order Id: '+booked_data.order_id+'</h6>';
                    selected_data += '<h6>Transaction Id: '+booked_data.transaction_id+'</h6>';
                    selected_data += '<h6>Status: '+booked_data.status+'</h6>';
                    selected_data += '</div>';

                    var personalinfo = booked_data.personalinfo;
                    var player_name = personalinfo.player_fname+' '+personalinfo.player_lname;
                    var guardian_name = personalinfo.guardian_fname+' '+personalinfo.guardian_lname;

                    selected_data += '<div class="float-right">';
                    selected_data += '<h6>Player Name: '+player_name+'</h6>';
                    selected_data += '<h6>Guardian Name: '+guardian_name+'</h6>';
                    selected_data += '<h6>Guardian Email: '+personalinfo.guardian_email+'</h6>';
                  /*  selected_data += '<h6>Soccer Kit Price: '+personalinfo.soccer_kit+'</h6>';*/
                    selected_data += '</div>';

                    selected_data += '<div class="table-responsive">';
                    selected_data += '<table id="tblUser" class="table table-bordered table-hover">';
                    selected_data += '<thead>';
                    selected_data += '<tr class="bg-primary text-white">';
                    selected_data += '<th>Sr. No.</th>';
                    selected_data += '<th>Product Id</th>';
                    selected_data += '<th>Product Price</th>';
                    selected_data += '</tr>';
                    selected_data += '</thead>';

                    selected_data += '<tbody>';

                    var order_det = booked_data.order_details;
                    var totalproduct = 0;
                    
                    console.log(order_det);
                    for(var i = 0; i < order_det.length; i++) {
                        var price = parseInt(order_det[i].product_price);
                        
                        totalproduct = totalproduct + parseInt(price.toFixed(2));

                        selected_data += '<tr>';
                        selected_data += '<td>'+(i + 1)+'</td>';
                        selected_data += '<td>'+order_det[i].prod_title+'</td>';
                        selected_data += '<td>C$'+price.toFixed(2)+'</td>';
                        selected_data += '</tr>';

                    }
                    
                        selected_data += '<tr>';
                        selected_data += '<td></td>';
                        selected_data += '<td>Soccer Kit</td>';
                        selected_data += '<td>C$'+personalinfo.soccer_kit+'</td>';
                        selected_data += '</tr>';
                        
                        var skkit = parseInt(personalinfo.soccer_kit);
                        totalproduct = totalproduct + skkit;
                        var hst = totalproduct * 0.13;
                        hst = hst.toFixed(2);
                        
                        selected_data += '<tr>';
                        selected_data += '<td></td>';
                        selected_data += '<td>HST(13%)</td>';
                        selected_data += '<td>C$'+hst+'</td>';
                        selected_data += '</tr>';
                        
                        var final_amtt = totalproduct + parseFloat(hst);
                        
                        selected_data += '<tr>';
                        selected_data += '<td></td>';
                        selected_data += '<td>Total Amount</td>';
                        selected_data += '<td>C$'+final_amtt+'</td>';
                        selected_data += '</tr>';

                    selected_data += '</tbody>';

                    selected_data += '</div>';
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


    } );
</script>