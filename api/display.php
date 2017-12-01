<?php
include("db_connect.php");
date_default_timezone_set("Asia/Kolkata");
$date=date("Y-m-d H:i:s");
$time=date("H:i:s");
$item_id=$_REQUEST['item_id'];
$quantity=$_REQUEST['quantity'];
$orderid=$_REQUEST['order_id'];
$customerid=$_REQUEST['customer_id'];
if($customerid>0){
$sqlquery5=mysqli_query($conn,"SELECT menu_name,menu_price FROM ti_menus WHERE menu_id='$item_id'");
if(mysqli_num_rows($sqlquery5)==1){
while($row1=mysqli_fetch_array($sqlquery5)){
    	$menu_name=$row1['menu_name'];
        $menu_price=$row1['menu_price'];
    }
} else{
echo "error1";
}
$sqlquery3=mysqli_query($conn,"SELECT * FROM ti_customers WHERE customer_id='$customerid'");
if(mysqli_num_rows($sqlquery3)==1){
	while($row2=mysqli_fetch_array($sqlquery3)){
    	$first_name=$row2['first_name'];
        $last_name=$row2['last_name'];
        $email=$row2['email'];
        $tele=$row2['telephone'];
        $address=$row2['address_id'];
    }
} else {
echo "error2";
}

$subtotal=$menu_price*$quantity;
$sqlquery2=mysqli_query($conn,"INSERT INTO `ti_orders`(`order_id`,`customer_id`,`first_name`,`last_name`,`email`,`telephone`,`cart`,`total_items`,`comment`,`status_id`,`date_added`,`date_modified`,`order_time`,`order_date`,`order_total`,`address_id`,`payment`) VALUES('$orderid','$customerid','$first_name','$last_name','$email','$tele','1','1','$comment','11','$date','$date','$time','$date','$subtotal','$address','cod')");
if($sqlquery2>0){
$flag=1;
} else {
$flag=0;
$sqlquery7=mysqli_query($conn,"UPDATE `ti_orders` SET `cart`=`cart`+1,`total_items`=`total_items`+1,`date_modified`='$date', `order_total`=`order_total`+$subtotal WHERE order_id='$orderid'");
}
$sqlquery4=mysqli_query($conn,"INSERT INTO ti_order_menus(`order_id`,`menu_id`,`name`,`quantity`,`price`,`subtotal`) VALUES('$orderid','$item_id','$menu_name','$quantity','$menu_price','$subtotal')"); 
$response['menu_name']=$menu_name;
$response['menu_price']=$menu_price;
$response['order_id']=$orderid;
$response['message']='SUCCESS';
}
else{
$response['message']='FAILED';
}
echo json_encode($response);
mysqli_close($conn);
?>