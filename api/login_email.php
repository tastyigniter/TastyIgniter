<?php
include("db_connect.php");
$username=$_REQUEST['email'];
$query = mysqli_query($conn,"SELECT t1.customer_id,t1.first_name,t1.last_name,t1.telephone,t2.address_1,t2.address_2,t2.city,t2.postcode,t2.state,t3.country_name FROM `ti_customers` as t1 join `ti_addresses` as t2 ON t1.customer_id=t2.customer_id join `ti_countries` as t3 ON t2.country_id=t3.country_id WHERE t1.`email`='$username'");
if(mysqli_num_rows($query)==1){
    while($row=mysqli_fetch_array($query)){
    	$response['cust_id']=$row['customer_id'];
        $response['fname']=$row['first_name'];
	$response['lname']=$row['last_name'];
	$response['mobile']=$row['telephone'];
	$response['address1']=$row['address_1'];
	$response['address2']=$row['address_2'];
	$response['city']=$row['city'];
	$response['state']=$row['state'];
	$response['pin']=$row['postcode'];
	$response['country_name']=$row['country_name'];
	$response['message']="Success";
    }
} else{
    $response['message']="Failed";
}
echo json_encode($response);
mysqli_close($conn);
?>