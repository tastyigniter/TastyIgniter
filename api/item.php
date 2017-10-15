<?php
include("db_connect.php");

$category_data = array();
$response= array();
$cat_id=$_REQUEST['category'];
$sSQL= 'SET NAMES utf8'; 

mysqli_query($conn,$sSQL) 
or die ('Can\'t charset in DataBase');
$sqlquery=mysqli_query($conn,"SELECT menu_id,menu_name,menu_description,menu_price,stock_qty,menu_photo FROM  `ti_menus` WHERE  `menu_category_id`='$cat_id' AND `menu_photo` IS NOT NULL");
while($row=mysqli_fetch_array($sqlquery))
	{
		$category_data['item_id']=$row['menu_id'];
		$category_data['name']=$row['menu_name'];
		$category_data['description']=$row['menu_description'];
		$category_data['price']=$row['menu_price'];
		$category_data['quantity']=$row['stock_qty'];  
		$category_data['image_url']=$row['menu_photo'];
	  array_push($response, $category_data);
	}
	echo json_encode($response);
?>  

