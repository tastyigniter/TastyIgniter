<?php
include("db_connect.php");
$item_id=$_REQUEST['item_id'];
$sqlquery=mysqli_query($conn,"SELECT * FROM  `ti_menus` where `menu_id`='$item_id'");
if(mysqli_num_rows($sqlquery)==1){
    while($row=mysqli_fetch_array($sqlquery)){
    	$response['menu_name']=$row['menu_name'];
        $response['menu_price']=$row['menu_price'];
	$response['message']="SUCCESS";

    }
}else{
    $response['message']="Failed";
}
echo json_encode($response);
mysqli_close($conn);
?>
