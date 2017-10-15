<?php
include("db_connect.php");
$category_data = array();
$response = array();
$sqlquery=mysqli_query($conn,"SELECT * FROM  `ti_categories` WHERE image IS NOT NULL LIMIT 4");
while($row=mysqli_fetch_array($sqlquery))
	{
		$category_data['category_id']=$row['category_id'];
		$category_data['name']=$row['name'];
		$category_data['image']=$row['image'];  
		$category_data['description']=$row['description'];
	    array_push($response, $category_data );
			
	}
	echo json_encode($response);
?>