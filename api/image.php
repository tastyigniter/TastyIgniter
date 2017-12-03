<?php
include("db_connect.php");
$category_data = array();
$response = array();
$sqlquery=mysqli_query($conn,"SELECT * FROM  `ti_customers` join `ti_customers_image` on ti_customers.customer_id=ti_customers_image.customer_id;");
while($row=mysqli_fetch_array($sqlquery))
	{
		$category_data['customer_id']=$row['customer_id'];
		$category_data['first_name']=$row['first_name'];
		$category_data['last_name']=$row['last_name'];
		$category_data['email']=$row['email'];
		$category_data['mobile']=$row['telephone'];
		$category_data['image']=$row['image_string'];
		$category_data['uuid']=$row['uuid_image'];
	    array_push($response, $category_data );
			
	}
	echo json_encode($response);
?>