<?php
include("db_connect.php");
$category_data = array();
$response = array();
$sqlquery=mysqli_query($conn,"SELECT country_id,country_name FROM  `ti_countries`;");
while($row=mysqli_fetch_array($sqlquery))
	{
		$category_data['country_id']=$row['country_id'];
		$category_data['name']=$row['country_name'];
	    array_push($response, $category_data );
			
	}
	echo json_encode($response);
?>